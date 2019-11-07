<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Kafedra;

/* @var $this yii\web\View */
/* @var $model app\models\Subject */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$kafedra = new Kafedra();
$statuses = $kafedra->getStatusList();
?>
<div class="subject-view panel panel-default">
    <div class="panel-heading">
        <?= Html::a(Yii::t('app', 'btn-update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'btn-delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'confirm-delete'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="panel-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'short_name',
                [
                    'attribute'=>'kafedra_id',
                    'value' => $model->kafedraName
                ],
                [
                    'attribute'=>'status',
                    'format'=>'raw',
                    'value'=> '<label class="label label-'.($model->status == \app\models\Subject::STATUS_ACTIVE ? 'success' : 'danger').'">'.$model->getStatusList()[$model->status].'</label>'
                ]
            ],
        ]) ?>
    </div>
</div>
