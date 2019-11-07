<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EssyReply */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="essy-reply-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'essy_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'reply')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
