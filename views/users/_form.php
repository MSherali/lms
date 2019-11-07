<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
        <?= $form->field($model, 'username')->textInput(['placeholder'=>Yii::t('app','placeholder-username')]) ?>
        <?= $form->field($model, 'fullname')->textInput(['placeholder'=>Yii::t('app','placeholder-fullname')]) ?>
        <?= $form->field($model, 'email')->textInput(['placeholder'=>Yii::t('app','placeholder-email')]) ?>
        <?php if($model->isNewRecord)  echo $form->field($model, 'password_hash')->passwordInput(['placeholder'=>Yii::t('app','placeholder-password')]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'course_id')->dropDownList($courses,[
            'id' => 'course-id',
            'prompt'=>Yii::t('app','placeholder-course')
        ]) ?>
        <?= $form->field($model, 'gruppa')->textInput(['placeholder'=>Yii::t('app','placeholder-gruppa')]) ?>
        <?= $form->field($model, 'address')->textInput(['placeholder'=>Yii::t('app','placeholder-address')]) ?>
        <?= $form->field($model, 'birthplace')->textInput(['placeholder'=>Yii::t('app','placeholder-birthplace')]) ?>
        <?= $form->field($model, 'phone')->textInput(['placeholder'=>Yii::t('app','placeholder-phone')]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
