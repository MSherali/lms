    <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use dosamigos\fileupload\FileUploadUI;
/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sequence', ['options'=>['class'=>'col-sm-3']])->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'lang', ['options'=>['class'=>'col-sm-3']])->dropDownList(Yii::$app->params['lang']) ?>

    <?= $form->field($model, 'course_id', ['options'=>['class'=>'col-sm-3']])->dropDownList($courses) ?>

    <?= $form->field($model, 'subject_id', ['options'=>['class'=>'col-sm-3']])->dropDownList($subjects) ?>

    <?= $form->field($model, 'lecture')->widget(TinyMce::className(), [
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
        <div class="col-sm-3"><?= $form->field($model, 'status')->dropDownList($model->getStatusList())->label(false) ?></div>
        <div class="col-sm-9 text-right">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
