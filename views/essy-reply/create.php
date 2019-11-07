<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EssyReply */

$this->title = Yii::t('app', 'Create Essy Reply');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Essy Replies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="essy-reply-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
