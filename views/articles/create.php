<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create panel panel-default">
    <div class="panel-heading">
        <span class="h4"><?= Html::encode($this->title) ?></span>
    </div>
    <div class="panel-body">
        <?= $this->render('_form', compact('model','courses','subjects')) ?>
    </div>
</div>
