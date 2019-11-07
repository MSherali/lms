<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'tasks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index panel panel-info">

    <div class="panel-heading">
        <?= Html::a(Yii::t('app', 'btn-create'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                [
                    'attribute'=>'article',
                    'value' => 'article.title',
                    'label'=>Yii::t('app','article')
                ],
                'title',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
