<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'questions');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="question-index panel panel-info">
    <div class="panel-heading">
        <?= Html::a(Yii::t('app', 'btn-create'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'question',
                    'format' => 'html'
                ],
                'difficulty',
                [
                    'attribute'=>'multianswer',
                    'content'=>function($model){
                        return $model->multianswer==1?'<i class="fa fa-check-circle" aria-hidden="true"></i>':'';
                    }
                ],
                [
                    'attribute'=>'lang',
                    'content'=>function($model){
                        return Yii::$app->params['lang'][$model->lang];
                    },
                    'filter'=>Yii::$app->params['lang']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>
    </div>
</div>
