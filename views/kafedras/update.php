<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kafedra */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Kafedra',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'kafedras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="kafedra-update  panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>