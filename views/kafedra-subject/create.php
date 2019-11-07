<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\KafedraSubject */

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'kafedras and subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kafedra-subject-create panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', compact('model')) ?>
    </div>
</div>