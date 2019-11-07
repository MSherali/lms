<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Kafedra;
use app\models\Subject;

/* @var $this yii\web\View */
/* @var $model app\models\KafedraSubject */
/* @var $form yii\widgets\ActiveForm */
$kafedras = ArrayHelper::map(Kafedra::find()->all(),'id','name');
$subjects = ArrayHelper::map(Subject::find()->all(),'id','name');
?>

<div class="kafedra-subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kafedras_id')->dropDownList($kafedras) ?>

    <?= $form->field($model, 'subjects_id')->dropDownList($subjects) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
