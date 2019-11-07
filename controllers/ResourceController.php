<?php

namespace app\controllers;

use Yii;
use app\models\Resource;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\helpers\Json;

/**
 * ResourceController implements the CRUD actions for Resource model.
 */
class ResourceController extends Controller
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
     * Lists all Resource models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('admin')){
            $dataProvider = new ActiveDataProvider([
                'query' => Resource::find()->where(['size'=>0]),
            ]);
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }
        else{
            $dataProvider = new ActiveDataProvider([
                'query' => Resource::find(),
            ]);
            return $this->render('list', [
                'dataProvider' => $dataProvider,
            ]);
        }


    }

    /**
     * Displays a single Resource model.
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
     * Creates a new Resource model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        $model = new Resource();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['resource/index']);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Resource model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['resource/index']);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Resource model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Resource model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Resource the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Resource::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpload()
    {
        if(!Yii::$app->user->can('admin')){
            throw new ForbiddenHttpException(Yii::t('app','forbidden'));
        }

        if(Yii::$app->request->isGet){
            $files = [];
            foreach (Resource::find()->where(['>','size',0])->all() as $media){
                $files[] = [
                    'name' => $media->name,
                    'size' => $media->size,
                    'url' =>  Yii::getAlias('@web'). $media->url,
                    'thumbnailUrl' => Yii::getAlias('@web').'/img/'.$media->extension.'-48.png',
                    'deleteUrl' => Url::to(['resource/file-delete','id'=>$media->id]),
                    'deleteType' => 'POST',
                ];
            }
            return Json::encode([
                'files' => $files,
            ]);
        }

        try{
            $model = new Resource();
            $uploadedFile = UploadedFile::getInstance($model, 'file');

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

                    $model->name = $uploadedFile->baseName;
                    $model->extension = strtolower($uploadedFile->extension);
                    $model->url = $path;
                    $model->size = $uploadedFile->size;

                    if(!$model->save()){
                        return Json::encode(['error' => $model->getErrors()]);
                    }

                    return Json::encode([
                        'files' => [
                            [
                                'name' => $model->name,
                                'size' => $uploadedFile->size,
                                'url' =>  Url::to('@web'.$path),
                                'thumbnailUrl' => Yii::getAlias('@web'). '/img/'. $model->extension.'-48.png',
                                'deleteUrl' => Url::to(['articles/file-delete','id'=>$model->id]),
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

        $model = Resource::find()->where(['id'=>$id])->one();
        if($model){
            $model->delete();

            $directory = Yii::getAlias('@app/web');// . DIRECTORY_SEPARATOR . Yii::$app->session->id;
            if (is_file($directory . DIRECTORY_SEPARATOR . $model->url)) {
                unlink($directory . DIRECTORY_SEPARATOR . $model->url);
            }

            $files = [];
            foreach (Resource::find()->where(['>','size',0])->all() as $media){
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
}
