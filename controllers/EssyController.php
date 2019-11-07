<?php

namespace app\controllers;

use app\models\EssyReply;
use app\models\EssySearch;
use Yii;
use app\models\Essy;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EssyController implements the CRUD actions for Essy model.
 */
class EssyController extends Controller
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
     * Lists all Essy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EssySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Essy model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (($model = Essy::find()->with('article')->where(['id'=>$id])->one()) !== null) {

            $dataProvider = new ActiveDataProvider([
                'query' => EssyReply::find()->with(['user'])->where(['essy_id'=>$id])->orderBy('created_at DESC')
            ]);

            return $this->render('view', compact('model','dataProvider'));
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Essy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = new Essy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Essy model.
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
            return $this->render('update', compact('model'));
        }
    }

    /**
     * Deletes an existing Essy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }
        EssyReply::deleteAll('essy_id=:essy_id',[':essy_id'=>$id]);
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Essy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Essy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Essy::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRate($id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = EssyReply::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['essy/view','id'=>$model->essy_id]);
        } else {
            return $this->renderAjax('_rate', [
                'model' => $model
            ]);
        }
    }

    public function actionEssyCreate($article_id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = new Essy();
        $model->article_id = $article_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['articles/update', 'id' => $article_id]);
        } else {
            return $this->renderAjax('_essy_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionEssyUpdate($id)
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = Essy::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['articles/update', 'id' => $model->article_id]);
        } else {
            return $this->renderAjax('_essy_form', [
                'model' => $model,
            ]);
        }
    }
}
