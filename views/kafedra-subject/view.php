<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\KafedraSubject */

$this->title = $model->kafedras_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'kafedras and subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kafedra-view panel panel-default">
    <div class="panel-heading">
        <?= Html::a(Yii::t('app', 'btn-update'), ['update', 'kafedras_id' => $model->kafedras_id,'subjects_id'=>$model->subjects_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'btn-delete'), ['delete', 'kafedras_id' => $model->kafedras_id,'subjects_id'=>$model->subjects_id], [
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
                [
                    'attribute'=>'kafedras_id',
                    'value'=>function($model){ return $model->kafedras->name; }
                ],
                [
                    'attribute'=>'subjects_id',
                    'value'=>function($model){ return $model->subjects->name; }
                ],
            ],
        ]) ?>
    </div>
</div>
