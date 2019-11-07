<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Register */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="register-update">

    <div class="register-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <label class="control-label" for="register-created_at"><?=Yii::t('app','fullname')?></label>
            <label class="form-control"><?=$model->user->fullname?></label>
            <div class="help-block"></div>
        </div>

        <?= $form->field($model, 'exam')->textInput() ?>

        <?= $form->field($model, 'essy')->textInput() ?>

        <?= $form->field($model, 'task')->textInput() ?>

        <?= $form->field($model, 'behaviors')->textInput() ?>

        <div class="form-group">
            <label class="control-label" for="register-created_at"><?=Yii::t('app','date')?></label>
            <label class="form-control"><?=$model->created_at?></label>
            <div class="help-block"></div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
