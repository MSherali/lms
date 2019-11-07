<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Subject */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Subject',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="subject-update  panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>