<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update-password">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'password_hash')->passwordInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','btn-update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
