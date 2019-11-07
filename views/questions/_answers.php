<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel-body">
    <?= Html::a(Yii::t('app', 'btn-create'), ['answers/create','question_id'=>$model->id], ['class' => 'btn btn-success update-modal']) ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'key'=>'id',
            'allModels' => $model->answers,
            'sort' => [
                'attributes' => ['id', 'answer','is_correct'],
            ],
            'pagination' => false,
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'answer',
            [
                'attribute'=>'is_correct',
                'content'=>function($model){
                    return $model->is_correct==1?'<i class="fa fa-check-circle" aria-hidden="true"></i>':'';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'controller' => 'answers',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            Url::to(['answers/update','id'=>$model->id]),
                            [
                                'class' => 'update-modal',
                            ]
                        );
                    },
                ],
            ],
        ],
    ])?>
</div>
