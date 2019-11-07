<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'course')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'faculty')->textInput(['maxlength' => true]) ?>

    <div class="">
        <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
