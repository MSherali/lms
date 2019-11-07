<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form ">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'article_id')->dropDownList($articles) ?>

    <?= $form->field($model, 'question')->widget(TinyMce::className(), [
        'options' => ['rows' => 8],
        'language' => Yii::$app->language,
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste imagetools image"
            ],
            'file_picker_types' => 'file image media',
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <div class="row">
    <?= $form->field($model, 'difficulty',
        ['options'=>['class'=>'col-md-4'], 'template'=>'<div class="input-group"><span class="input-group-addon bg-gray text-bold">{label}</span>{input}{error}{hint}</div>'])
        ->dropDownList(Yii::$app->params['difficulties']) ?>

    <?= $form->field($model, 'lang',
        ['options'=>['class'=>'col-md-4'], 'template'=>'<div class="input-group"><span class="input-group-addon bg-gray text-bold">{label}</span>{input}{error}{hint}</div>'])
        ->dropDownList(Yii::$app->params['lang']) ?>


    <?= $form->field($model, 'multianswer',
        ['options'=>['class'=>'col-md-4'],'template' => '<div class="input-group"><span class="input-group-addon text-bold">{label}</span>{input}{error}{hint}</div>'])
        ->checkbox() ?>

    </div>

    <div class="">
        <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>


