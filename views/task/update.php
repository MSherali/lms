<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="task-update  panel panel-default">
    <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>

</div>
