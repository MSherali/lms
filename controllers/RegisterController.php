<?php

namespace app\controllers;

use app\models\Course;
use app\models\EssyReply;
use app\models\Exam;
use app\models\RegisterForm;
use app\models\TaskReply;
use app\models\User;
use Yii;
use app\models\Register;
use app\models\RegisterSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegisterController implements the CRUD actions for Register model.
 */
class RegisterController extends Controller
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
     * Lists all Register models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegisterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Register model.
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
     * Creates a new Register model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {
            $course = Course::findOne($model->course);
            try{
                foreach (User::find()->where(['course_id'=>$model->course])->all() as $user){
                    $exam = Exam::find()->where(['user_id'=>$user->id])->andWhere("date(finished_at)='".$model->created_at."'")->all();
                    //$exam = Exam::findBySql('SELECT * FROM exams WHERE date(finished_at)=:finished AND user_id=:user_id',[':finished'=>$model->created_at,':user_id'=>$user->id])->all();
                    $essy = EssyReply::find()->where(['user_id'=>$user->id])->andWhere("date(created_at)='".$model->created_at."'")->all();
                    $task = TaskReply::find()->where(['user_id'=>$user->id])->andWhere("date(created_at)='".$model->created_at."'")->all();

                    $exam_score = count($exam) == 1 ? $exam[0]->rating : 0;
                    $essy_score = count($essy) == 1 ? $essy[0]->rating : 0;
                    $task_score = count($task) == 1 ? $task[0]->rating : 0;

                    $register = new Register();
                    $register->user_id = $user->id;
                    $register->exam = $exam_score;
                    $register->essy = $essy_score;
                    $register->task = $task_score;
                    $register->created_at = $model->created_at;
                    $register->save();

                    /*echo $user->id. ' '.$exam_score.' '.$essy_score.' '.$task_score;
                    var_dump($exam);
                    var_dump($essy);
                    var_dump($task);

                    echo "<hr/>";*/
                }
            }
            catch (\Exception $ex){
                echo $ex->getMessage();
            }

            // insert user_id, from course and
            /*Yii::$app->db->createCommand('INSERT IGNORE INTO `register`(`user_id`, `created_at`) SELECT u.id, :date FROM users u INNER JOIN courses c ON u.course_id=c.id WHERE c.id=:course_id')
                ->bindValue(':date', $model->created_at)
                ->bindValue(':course_id', $model->course)
                ->execute();*/
            return $this->redirect(['index', 'RegisterSearch[course]' => $course->course,'RegisterSearch[faculty]' => $course->faculty,'RegisterSearch[created_at]' => $model->created_at]);
        } else {
            $courses = ArrayHelper::map(Course::find()->asArray()->all(),
                'id',
                function($model, $defaultValue){
                    return $model['course'].'-'.$model['faculty'];
                }
            );

            return $this->renderAjax('create', compact('model','courses'));
        }
    }

    /**
     * Updates an existing Register model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('update', compact('model'));
        }
    }

    /**
     * Deletes an existing Register model.
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
     * Finds the Register model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Register the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Register::find()->with('user')->where(['id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
