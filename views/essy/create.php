<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Essy */

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'essies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="essy-create panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', compact('model')) ?>
    </div>
</div>
