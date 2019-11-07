<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
