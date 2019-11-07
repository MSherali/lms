<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('app','Sign In');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];
$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
$directoryAsset = AppAsset::register($this)->baseUrl;
?>

<div class="login-box">
    <div class="login-logo">
        <img src="<?= $directoryAsset ?>/favicon.ico" class="img-md user-image" alt="logo"/>
        <span class="hidden-xs"><?=Yii::$app->name?></span>
    </div>
    <div class="login-box-body">

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => Yii::t('app','username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => Yii::t('app','password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox(['label' => Yii::t('app','remember-me')]) ?>
            </div>
            <div class="col-xs-4">
                <?= Html::submitButton(Yii::t('app','btn-sign-in'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
