<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Register */

$this->title = Yii::t('app', 'register');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'register'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-create">

    <div class="register-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'course')->dropDownList($courses) ?>

        <?= $form->field($model, 'created_at')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => Yii::t('app','date')],
            'value' => date('Y-m-d'),
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
