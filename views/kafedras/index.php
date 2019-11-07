<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KafedraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'kafedras');
$this->params['breadcrumbs'][] = $this->title;
$status = $searchModel->getStatusList();
?>
<div class="kafedra-index panel panel-info">
    <div class="panel-heading">
        <?= Html::a(Yii::t('app', 'btn-create'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'short_name',
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
