<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'exam');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-index">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute'=>'fullname',
                'value'=>'user.fullname',
                'label'=>Yii::t('app','fullname'),
            ],
            [
                'attribute'=>'title',
                'value'=>'article.title',
                'label'=>Yii::t('app','title'),
            ],
            [
                'attribute'=>'baho',
                'label'=>Yii::t('app','rating'),
            ],
            'started_at',
            'finished_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->can('admin') ? '{view}{delete}' : '{view}',
                'buttons' => [
                    'view' => function ( $url, $model) {
                        $url = Url::toRoute(['exams/summary', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-list" aria-hidden="true"></span>', $url, [
                            'title' => Yii::t('app','details'),
                        ]);
                    },


                ],
            ],

        ],
    ]); ?>
</div>
