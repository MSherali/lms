<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Course',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->course.'-'.$model->faculty, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="course-update  panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
