<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Resource */

$this->title = Yii::t('app', 'Create Resource');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Resources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resource-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
