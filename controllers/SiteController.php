<?php

namespace app\controllers;

use app\models\Media;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		return $this->render('index');
    }

    public function actionUpload($id)
    {
        $model = new Media();
        $uploadedFile = UploadedFile::getInstance($model, 'file');
        $model->article_id = $id;

        $directory = Yii::getAlias('@app/web/uploads') . DIRECTORY_SEPARATOR;// . Yii::$app->session->id . DIRECTORY_SEPARATOR;
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
                $model->extension = $uploadedFile->extension;
                $model->url = $path;
                $model->size = $uploadedFile->size;
                if(!$model->save()){
                    return Json::encode(['error' => Yii::t('app', 'Madia save error.')]);
                }

                return Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $uploadedFile->size,
                            'url' =>  Url::to('@web'.$path),
                            'thumbnailUrl' => Url::home() . DIRECTORY_SEPARATOR .$path,
                            'deleteUrl' => 'image-delete?name=' . $fileName,
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
            else{
                return Json::encode(['error' => Yii::t('app', 'Unable to save picture')]);
            }
        }
        return Json::encode(['error' => Yii::t('app', 'Could not upload file.')]);
    }

    public function actionImageDelete($name)
    {
        $directory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->session->id;
        if (is_file($directory . DIRECTORY_SEPARATOR . $name)) {
            unlink($directory . DIRECTORY_SEPARATOR . $name);
        }

        $files = FileHelper::findFiles($directory);
        $output = [];
        foreach ($files as $file) {
            $fileName = basename($file);
            $path = '/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
            $output['files'][] = [
                'name' => $fileName,
                'size' => filesize($file),
                'url' => $path,
                'thumbnailUrl' => $path,
                'deleteUrl' => 'image-delete?name=' . $fileName,
                'deleteType' => 'POST',
            ];
        }
        return Json::encode($output);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAuthor()
    {
        return $this->render('author');
    }

    public function actionLanguage($lang)
    {
        Yii::$app->language = $lang;

        $languageCookie = new Cookie([
            'name' => 'language',
            'value' => $lang,
            'expire' => time() + 60 * 60 * 24 * 30, // 30 days
        ]);
        Yii::$app->response->cookies->add($languageCookie);
        $this->redirect(Yii::$app->request->referrer);
    }
}
