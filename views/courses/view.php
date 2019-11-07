<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-view panel panel-default">
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
        <div class="form-group">
            <h4><span class="label bg-primary text-bold"><?=$model->getAttributeLabel('course')?></span></h4>
            <div class="well"><?=$model->course?></div>
        </div>
        <div class="form-group">
            <h4><span class="label bg-primary text-bold"><?=$model->getAttributeLabel('faculty')?></span></h4>
            <div class="well"><?=$model->faculty?></div>
        </div>
    </div>
</div>
