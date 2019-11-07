<?php

namespace app\controllers;

use app\models\Article;
use app\models\User;
use Yii;
use app\models\Question;
use app\models\QuestionSearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * QuestionsController implements the CRUD actions for Question model.
 */
class QuestionsController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all Question models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Question model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = new Question();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            //$articles = ArrayHelper::map(Article::find()->all(),'id','title');
            return $this->render('create', compact('model'));
        }
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $articles = ArrayHelper::map(Article::find()->all(),'id','title');
            return $this->render('update', compact('model','articles'));
        }
    }

    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::find()->with(['answers'])->where(['id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionQidir($q, $article, $lang, $page=null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $offset=0;
        $limit = 30;
        try{
            if($page!=null) $offset = $page*$limit;
            $out=[];
            $query = new Query();
            $queryCount = new Query();
            $query->select('q.id, q.question AS text')
                ->from('questions as q')
                ->leftJoin('article_question as aq','aq.question_id=q.id AND aq.article_id='.$article)
                ->where(['like', 'q.question', $q])
                ->andWhere(['aq.question_id'=>null])
                ->andWhere(['q.lang'=>$lang])
                ->limit($limit)
                ->offset($offset);
            $command = $query->createCommand();
            $data = $command->queryAll();

            $out['results'] = $data;

            $queryCount->select('COUNT(q.id)')
                ->from('questions as q')
                ->leftJoin('article_question as aq','aq.question_id=q.id AND aq.article_id='.$article)
                ->where(['like', 'q.question', $q])
                ->andWhere(['aq.question_id'=>null])
                ->andWhere(['q.lang'=>$lang]);
            $commandCount = $queryCount->createCommand();
            $out['total_count'] = $commandCount->queryScalar();
            return $out;
        }
        catch (\Exception $ex){
            return $ex->getMessage();
        }

    }
}
