<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Subject;

/* @var $this yii\web\View */
/* @var $model app\models\Kafedra */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'kafedras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$subject = new Subject();
$statuses = $subject->getStatusList();
?>
<div class="kafedra-view panel panel-default">
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
                    'attribute'=>'status',
                    'format'=>'raw',
                    'value'=> '<label class="label label-'.($model->status == \app\models\Subject::STATUS_ACTIVE ? 'success' : 'danger').'">'.$model->getStatusList()[$model->status].'</label>'
                ]
            ],
        ]) ?>
    </div>

    <div class="panel-body">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'key'=>'id',
                'allModels' => $model->subjects,
                'sort' => [
                    'attributes' => ['name', 'short_name', 'status'],
                ],
                'pagination' => false,
            ]),
            'columns' => [
                [
                    'attribute'=>'name',
                    'label' => $subject->getAttributeLabel('name')
                ],
                [
                    'attribute'=>'short_name',
                    'label' => $subject->getAttributeLabel('short_name')
                ],
                [
                    'attribute'=>'status',
                    'label' => $subject->getAttributeLabel('status'),
                    'content' => function($model)use($statuses){
                        return $statuses[$model->status];
                    }
                ],
            ],
        ])?>
    </div>
</div>