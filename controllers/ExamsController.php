<?php

namespace app\controllers;

use app\models\Answer;
use app\models\ExamDetail;
use app\models\ExamSearch;
use app\models\Question;
use Yii;
use app\models\Exam;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExamsController implements the CRUD actions for Exam model.
 */
class ExamsController extends Controller
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
     * Lists all Exam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExamSearch();
        if(Yii::$app->user->can('admin')) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        else{
            $dataProvider = $searchModel->search(ArrayHelper::merge(Yii::$app->request->queryParams, [$searchModel->formName() => ['user_id' => Yii::$app->user->id]]));
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Exam model.
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
     * Deletes an existing Exam model.
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
     * Finds the Exam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Exam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Exam::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTest($id)
    {
        //$difficulty1 = 15;
        //$difficulty2 = 5;
        $questions1 = Question::find()->select(['id'])->innerJoin('article_question','questions.id=article_question.question_id')->where(['article_question.article_id'=>$id, 'difficulty'=>1])->asArray()->all();
        $questions2 = Question::find()->select(['id'])->innerJoin('article_question','questions.id=article_question.question_id')->where(['article_question.article_id'=>$id, 'difficulty'=>2])->asArray()->all();

        if(count($questions1)>=1 && count($questions2)>=1){

            // delete not finished tests
            $model = Exam::find()->where(['article_id'=>$id, 'user_id'=>Yii::$app->user->id, 'finished_at'=>null])->one();
            if($model){
                ExamDetail::deleteAll(['exam_id'=>$model->id]);
                $model->delete();
            }

            $model = new Exam();
            $model->article_id = $id;
            $model->user_id = Yii::$app->user->id;
            $model->started_at = date('Y-m-d H:i:s');
            $model->save();

            shuffle($questions1);
            shuffle($questions2);
            $i=0;
            // get 15 from q1
            $arr_q = [];
            foreach ($questions1 as $question) {
                if($i==$difficulty1) break;
                $arr_q[] = [$model->id,$question['id']];
                $i++;
            }

            $i=0;
            // get 5 from q2
            foreach ($questions2 as $question) {
                if($i==$difficulty2) break;
                $arr_q[] = [$model->id,$question['id']];
                $i++;
            }

            Yii::$app->db->createCommand()
                ->batchInsert(ExamDetail::tableName(), ['exam_id','question_id'], $arr_q)
                ->execute();

            return $this->redirect(['answer','id'=>$model->id]);
        }
        else{
            throw new MethodNotAllowedHttpException(Yii::t('app','not-enough'));
        }
    }

    public function actionAnswer($id)
    {
        $post = Yii::$app->request->post();
        if(isset($post['Exam'])){
            $answers = isset($post['Answer'])?$post['Answer']:[];
            $ans = implode(',',$answers);
            $model = ExamDetail::find()->with('question')->where(['id'=>$post['Exam']])->one();
            $correct_answers = Answer::find()->select(['id'])->where(['question_id'=>$model->question_id,'is_correct'=>1])->all();
            $arrayCA = [];
            foreach ($correct_answers as $v){
                $arrayCA[] = $v->id;
            }

            $correct = 0;
            $incorrect = 0;
            foreach ($answers as $i_a){
                if(in_array($i_a, $arrayCA)){
                    $correct++;
                }
                else{
                    $incorrect++;
                }
            }

            $rating = ($model->question->difficulty * ($correct-$incorrect))/count($arrayCA);

            if($rating<0) $rating = 0;
            //$rating = round($rating);
			$rating = ceil($rating);
            $model->answer_id = $ans;
            $model->rating = $rating*4;
            $model->save();
        }

        $data = ExamDetail::find()->with(['question.answers'])->where(['exam_id'=>$id,'answer_id'=>null])->one();
        if(count($data) == 0){
            /**
             * Finished the exam
             * Redirect to summary page
            */
            $total = ExamDetail::find()->where(['exam_id'=>$id])->sum('rating');
            $exam = Exam::findOne($id);
            $exam->finished_at = date('Y-m-d H:i:s');
            $exam->rating = $total;
            $exam->save();

            return $this->redirect(['summary','id'=>$id]);
            //return $this->render('_summary', ['model'=>$data,'exam'=>$id]);
        }

        return $this->render('_test', ['model'=>$data,'exam'=>$id]);
    }

    public function actionSummary($id)
    {
        $exam = Exam::find()->with(['user','article'])->where(['id'=>$id])->one();
        $details = ExamDetail::find()->with('question')->where(['exam_id'=>$id])->all();
        return $this->render('_summary', compact('exam','details'));
    }
}
