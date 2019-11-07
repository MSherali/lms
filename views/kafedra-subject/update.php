<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KafedraSubject */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'kafedras and subjects',
]) . $model->kafedras_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'kafedras and subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kafedras_id, 'url' => ['view', 'kafedras_id' => $model->kafedras_id, 'subjects_id' => $model->subjects_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="kafedra-subject-update  panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', compact('model')) ?>
    </div>
</div>