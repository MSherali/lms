<?php

namespace app\controllers;

use app\models\Course;
use app\models\Essy;
use app\models\EssyReply;
use app\models\Exam;
use app\models\ExamDetail;
use app\models\Media;
use app\models\Subject;
use app\models\Task;
use app\models\TaskReply;
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\helpers\Json;

/**
 * ArticlesController implements the CRUD actions for Article model.
 */
class ArticlesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'question-delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $subjects = ArrayHelper::map(Subject::find()->all(),'id','name');
        $courses = ArrayHelper::map(Course::find()->asArray()->all(),
            'id',
            function($model, $defaultValue){
                return $model['course'].'-'.$model['faculty'];
            }
        );

        return $this->render('index', compact('courses','searchModel','dataProvider','subjects'));
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = new Article();
        $model->created_at = date('now');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $courses = ArrayHelper::map(Course::find()->asArray()->all(),
                'id',
                function($model, $defaultValue){
                    return $model['course'].'-'.$model['faculty'];
                }
            );
	  
           $subjects = ArrayHelper::map(Subject::find()->asArray()->all(),
                'id','name'
            );	

            return $this->render('create', compact('model','courses','subjects'));
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = Article::find()->with(['questions','medias','course','essies','tasks'])->where(['id'=>$id])->one();
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $courses = ArrayHelper::map(Course::find()->asArray()->all(),
                'id',
                function($model, $defaultValue){
                    return $model['course'].'-'.$model['faculty'];
                }
            );
            $subjects = ArrayHelper::map(Subject::find()->where(['status'=>Subject::STATUS_ACTIVE])->all(),'id','name');
            return $this->render('update', compact('model','courses','subjects'));
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        foreach (Exam::find()->where(['article_id'=>$id])->all() as $exam){
            ExamDetail::deleteAll('exam_id=:id',[':id'=>$exam->id]);
            $exam->delete();
        }

        foreach (Essy::find()->where(['article_id'=>$id])->all() as $essy){
            EssyReply::deleteAll('essy_id=:id',[':id'=>$essy->id]);
            $essy->delete();
        }

        foreach (Task::find()->where(['article_id'=>$id])->all() as $task){
            TaskReply::deleteAll('task_id=:id',[':id'=>$task->id]);
            $task->delete();
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::find()->with(['medias','course','subject'])->where(['id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpload($id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        if(Yii::$app->request->isGet){
            $files = [];
            foreach (Media::find()->where(['article_id'=>$id])->all() as $media){
                $files[] = [
                    'name' => $media->name,
                    'size' => $media->size,
                    'url' =>  Yii::getAlias('@web'). $media->url,
                    'thumbnailUrl' => Yii::getAlias('@web').'/img/'.$media->extension.'-48.png',
                    'deleteUrl' => Url::to(['articles/file-delete','id'=>$media->id]),
                    'deleteType' => 'POST',
                ];
            }
            return Json::encode([
                'files' => $files,
            ]);
        }

        try{
            $model = Article::find()->where(['id'=>$id])->one();
            $uploadedFile = UploadedFile::getInstance($model, 'file');
            //$model->article_id = $id;

            $directory = Yii::getAlias('@app/web/uploads') . DIRECTORY_SEPARATOR;
            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }

            if ($uploadedFile) {
                $uid = uniqid(time(), true);
                $fileName = $uid . '.' . $uploadedFile->extension;
                $filePath = $directory . $fileName;
                if ($uploadedFile->saveAs($filePath)) {
                    $path = '/uploads/' . $fileName;

                    $file = new Media();
                    $file->name = $uploadedFile->baseName;
                    $file->extension = strtolower($uploadedFile->extension);
                    $file->url = $path;
                    $file->size = $uploadedFile->size;
                    $file->article_id = $id;
                    //$file->section = isset($_POST['section'])?$_POST['section']:Media::SECTION_OTHERS;

                    if(!$file->save()){
                        return Json::encode(['error' => $file->getErrors()]);
                    }

                    return Json::encode([
                        'files' => [
                            [
                                'name' => $file->name,
                                'size' => $uploadedFile->size,
                                'url' =>  Url::to('@web'.$path),
                                'thumbnailUrl' => Yii::getAlias('@web'). '/img/'. $file->extension.'-48.png',//Url::home() . DIRECTORY_SEPARATOR .$path,
                                'deleteUrl' => Url::to(['articles/file-delete','id'=>$file->id]),
                                'deleteType' => 'POST',
                            ],
                        ],
                    ]);
                }
                else{
                    return Json::encode(['error' => Yii::t('app', 'Unable to save picture')]);
                }
            }
            else{
                return Json::encode(['error' => Yii::t('app', 'Could not upload file.')]);
            }

        }
        catch (\Exception $ex){
            return Json::encode(['error' => $ex->getMessage()]);
        }
    }

    public function actionFileDelete($id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = Media::find()->where(['id'=>$id])->one();
        if($model){
            $article_id = $model->article_id;
            $model->delete();

            $directory = Yii::getAlias('@app/web');// . DIRECTORY_SEPARATOR . Yii::$app->session->id;
            if (is_file($directory . DIRECTORY_SEPARATOR . $model->url)) {
                unlink($directory . DIRECTORY_SEPARATOR . $model->url);
            }

            $files = [];
            foreach (Media::find()->where(['article_id'=>$article_id])->all() as $media){
                $files[] = [
                    'name' => $media->name,
                    'size' => $media->size,
                    'url' =>  Yii::getAlias('@web'). $media->url,
                    //'thumbnailUrl' => Yii::getAlias('@web'). DIRECTORY_SEPARATOR . $media->url,
                    'deleteUrl' => Url::to(['articles/file-delete','id'=>$media->id]),
                    'deleteType' => 'POST',
                ];
            }

            return Json::encode([
                'files' => $files,
            ]);
        }
        else{
            return Json::encode(['error' => Yii::t('app', 'not-found')]);
        }
    }

    public function actionEssies($id, $essy=null)
    {
        if(Yii::$app->user->can('admin')){
            $essies = ArrayHelper::map(Essy::find()->where(['article_id'=>$id])->all(),'id','title');
            $data = [];

            if($essy!==null){
                $data = EssyReply::find()->with(['user'])->where(['essy_id'=>$essy])->orderBy('rating')->all();
            }

            return $this->render('essies', compact('id', 'essies','essy','course','data'));
        }
        else{
            $user = Yii::$app->user->id;
            $data = Essy::find()->with(['replies'=>function($query)use($user){
                $query->andWhere(['user_id' => $user]);
            }])->where(['article_id'=>$id])->all();

            if(Yii::$app->request->isPost){
                if(isset($_POST['EssyReply']['id'])){
                    $model = EssyReply::findOne($_POST['EssyReply']['id']);
                }
                else{
                    $model = new EssyReply();
                    $model->user_id = $user;
                }

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['articles/essies', 'id' => $id]);
                }
            }

            return $this->render('my_essies', compact('id', 'data'));
        }
    }

    public function actionReplyCreate($essy_id, $article_id)
    {
        $model = new EssyReply;
        $model->essy_id = $essy_id;
        $model->user_id = Yii::$app->user->id;

        $model->load(Yii::$app->request->post());
        $model->save();

        return $this->redirect(['articles/essies', 'id' => $article_id]);
    }

    public function actionTasks($id, $task=null)
    {
        if(Yii::$app->user->can('admin')){
            $tasks = ArrayHelper::map(Task::find()->where(['article_id'=>$id])->all(),'id','title');
            $data = [];

            if($task!==null){
                $data = TaskReply::find()->with(['user'])->where(['task_id'=>$task])->orderBy('rating')->all();
            }

            return $this->render('tasks', compact('id', 'tasks','task','course','data'));
        }
        else{
            $user = Yii::$app->user->id;
            $data = Task::find()->with(['replies'=>function($query)use($user){
                $query->andWhere(['user_id' => $user]);
            }])->where(['article_id'=>$id])->all();

            if(Yii::$app->request->isPost){
                if(isset($_POST['TaskReply']['id'])){
                    $model = TaskReply::findOne($_POST['TaskReply']['id']);
                }
                else{
                    $model = new TaskReply();
                    $model->user_id = $user;
                }

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['articles/tasks', 'id' => $id]);
                }
            }

            return $this->render('my_tasks', compact('id', 'data'));
        }
    }

    public function actionTaskreplyCreate($task_id, $article_id)
    {
        $model = new TaskReply();
        $model->task_id = $task_id;
        $model->user_id = Yii::$app->user->id;

        $model->load(Yii::$app->request->post());
        $model->save();

        return $this->redirect(['articles/tasks', 'id' => $article_id]);
    }

    public function actionTaskRate($id, $article)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = TaskReply::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['articles/tasks','id'=>$article, 'task'=>$model->task_id]);
        } else {
            return $this->renderAjax('_task_rate', [
                'model' => $model
            ]);
        }
    }


    public function actionQuestion()
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        if(isset($_POST['question_id'], $_POST['article_id'])){

            Yii::$app->db->createCommand()->insert('article_question',['article_id'=>$_POST['article_id'], 'question_id'=>$_POST['question_id']])->execute();
            return $this->redirect(['update','id'=>$_POST['article_id']]);
        }
        else{
            return $this->redirect(['index']);
        }
    }

    public function actionQuestionDelete($article_id, $question_id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        Yii::$app->db->createCommand()->delete('article_question',['article_id'=>$article_id, 'question_id'=>$question_id])->execute();
        return $this->redirect(['update','id'=>$article_id]);

    }

}
