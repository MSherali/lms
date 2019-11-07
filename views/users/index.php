<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'students');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index panel panel-info">
    <div class="panel-heading">
        <?= Html::a(Yii::t('app', 'btn-create'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'gruppa',
                'username',
                'fullname',
                'phone',
                'address',
                'birthplace',
                [
                    'attribute'=>'faculty',
                    'value' => 'course.faculty',
                    'label'=>Yii::t('app','faculty')
                ],
                [
                    'attribute'=>'course',
                    'value' => 'course.course',
                    'label'=>Yii::t('app','course')
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' =>'{view} {update} {delete} {updatePassword}',
                    'header'=>'Action',
                    'headerOptions'=>['style'=>'width: 20px;text-align: center;'],
                    'contentOptions'=>['style'=>'width: 20px;text-align: center;'],
                    'buttons' => [
                        'updatePassword' => function ( $url, $model) {
                            $url = Url::toRoute(['users/update-password', 'id' => $model->id]);
                            return Html::a('<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>', $url, [
                                'title' => 'Change password',
                            ]);
                        },


                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
