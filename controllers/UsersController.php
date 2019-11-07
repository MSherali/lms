<?php

namespace app\controllers;

use app\models\Course;
use app\models\EssyReply;
use app\models\Exam;
use app\models\ExamDetail;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (($model = User::find()->with(['course','essyReplies.essy','taskReplies.task','exams.article'])->where(['id'=>$id])->one()) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        //$exams = Exam::find()->with(['article','details'])->where(['user_id'=>$id])->all();
        return $this->render('view', compact('model'));
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('manage-users')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = new User();

        if($model->load(Yii::$app->request->post())){
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            if($model->save()) {
                $auth = Yii::$app->authManager;
                $roleObject = $auth->getRole('student');
                if (!$roleObject) {
                    throw new InvalidParamException("There is no role student.");
                }

                $auth->assign($roleObject, $model->id);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $courses = ArrayHelper::map(Course::find()->asArray()->all(),
                'id',
                function($model, $defaultValue){
                    return $model['course'].'-'.$model['faculty'];
                }
            );

        return $this->render('create', compact('model','courses'));
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can('manage-users')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = $this->findModel($id);

        if($model->load(Yii::$app->request->post())){
            //$model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            if($model->save()) return $this->redirect(['view', 'id' => $model->id]);
        }

        $courses = ArrayHelper::map(Course::find()->asArray()->all(),
            'id',
            function($model, $defaultValue){
                return $model['course'].'-'.$model['faculty'];
            }
        );

        return $this->render('update', compact('model','courses'));
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can('manage-users')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        EssyReply::deleteAll('user_id=:id',[':id'=>$id]);
        foreach (Exam::find()->where(['user_id'=>$id])->all() as $exam){
            ExamDetail::deleteAll('exam_id=:id',[':id'=>$exam->id]);
            $exam->delete();
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdatePassword($id=null)
    {
        $iid = Yii::$app->user->id;
        if($id != null) $iid = $id;
        if(Yii::$app->user->can('manage-users') || Yii::$app->user->id==$iid){
            $model = User::findOne($iid);

            if ($model->load(Yii::$app->request->post()) ) {
                $postArrayUser =  Yii::$app->request->post('User');
                if(trim($postArrayUser['password_hash']) != '')
                {
                    $model->setPassword($postArrayUser['password_hash']);
                    if($model->save(false)){
                        if(Yii::$app->user->can('manage-users'))
                            return $this->redirect(['index']);
                        else
                            return $this->redirect(['view','id'=>$iid]);
                    }
                }
                else {
                    $model->addError('password','Калит сўз тўлдирилиши шарт.');
                    return $this->render('update-password', ['model' => $model,]);

                }

            }
            else {
                return $this->render('update-password', [
                    'model' => $model,
                ]);
            }
        }
        else{
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }
    }
}
