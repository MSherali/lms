<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="user-update panel panel-default">
    <div class="panel-heading">
        <span class="h4"><?= Html::encode($this->title) ?></span>
    </div>
    <div class="panel-body">
        <?= $this->render('_form',compact('model','courses')) ?>
    </div>
</div>