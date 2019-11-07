<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answer-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'rating')->textInput(['maxlength' => true,'autofocus'=>'autofocus']) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
