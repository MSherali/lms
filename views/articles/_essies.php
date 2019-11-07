<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel-body">
    <?= Html::a(Yii::t('app', 'btn-create'), ['essy/essy-create','article_id'=>$model->id], ['class' => 'btn btn-success update-modal']) ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'key'=>'id',
            'allModels' => $model->essies,
            'sort' => [
                'attributes' => ['id', 'answer','is_correct'],
            ],
            'pagination' => false,
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                //'controller' => 'answers',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            Url::to(['essy/essy-update','id'=>$model->id]),
                            [
                                'class' => 'update-modal',
                            ]
                        );
                    },

                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            Url::to(['essy/delete','id'=>$model->id]),[
                                'title' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                'data-method' => 'post',
                            ]
                        );
                    },
                ],
            ],
        ],
    ])?>
</div>
