<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'articles');
$this->params['breadcrumbs'][] = $this->title;
$status = $searchModel->getStatusList();
?>
<div class="article-index panel panel-info">
    <div class="panel-heading">
        <?= Html::a(Yii::t('app', 'btn-create'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                [
                    'attribute'=>'lang',
                    'content'=>function($model){
                        return Yii::$app->params['lang'][$model->lang];
                    },
                    'filter'=>Yii::$app->params['lang']
                ],
                [
                    'attribute'=>'course_id',
                    'content'=>function($model){
                       return $model->course->course.'-'.$model->course->faculty;
                    },
                    'filter'=>$courses
                ],
                [
                    'attribute'=>'subject_id',
                    'content'=>function($model){
                        return $model->subject->name;
                    },
                    'filter'=>$subjects
                ],
                'created_at',
                [
                    'attribute'=>'status',
                    'content' => function($data)use($status){
                        return '<label class="label label-'.($data->status == \app\models\Kafedra::STATUS_ACTIVE ? 'success' : 'danger').'">'.$status[$data->status].'</label>';
                    },
                    'format' => 'html',
                    'filter' => $status,
                    'contentOptions' => ['class'=>'text-center'],
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>