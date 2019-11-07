<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Kafedra */

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'kafedras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kafedra-create panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', compact('model')) ?>
    </div>
</div>