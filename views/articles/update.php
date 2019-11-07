<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use dosamigos\fileupload\FileUploadUI;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$js = <<< JS
    $(function  () {
      $(".update-modal").click(function(e){
          e.preventDefault();
          $("#modal").modal('show')
            .find('#modalContent')
            .load($(this).attr('href'));             
      });
      
    });
JS;
$this->registerJs($js);

Modal::begin([
    'header'=>'<h4></h4>',
    'id'=>'modal',
    'size'=>'modal-md'
]);

echo '<div id="modalContent"></div>';
Modal::end();

?>



<div class="article-update panel panel-default">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel-body">

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <div class="row">
            <?= $form->field($model, 'sequence', ['options'=>['class'=>'col-sm-3']])->textInput(['type' => 'number']) ?>

            <?= $form->field($model, 'lang', ['options'=>['class'=>'col-sm-3']])->dropDownList(Yii::$app->params['lang']) ?>

            <?= $form->field($model, 'course_id', ['options'=>['class'=>'col-sm-3']])->dropDownList($courses) ?>

            <?= $form->field($model, 'subject_id', ['options'=>['class'=>'col-sm-3']])->dropDownList($subjects) ?>
        </div>



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
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-sm-3"><?= $form->field($model, 'status')->dropDownList($model->getStatusList())->label(false) ?></div>
            <div class="col-sm-9 text-right">
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="panel-body">
    <ul class="nav nav-tabs">
        <li class="active"><a  href="#1" data-toggle="tab"><i class="fa fa-puzzle-piece" aria-hidden="true"></i> <?=Yii::t('app','questions')?></a></li>
        <li><a  href="#2" data-toggle="tab"><i class="fa fa-film" aria-hidden="true"></i> <?=Yii::t('app','media')?></a></li>
        <li><a href="#3" data-toggle="tab"><i class="fa fa-question" aria-hidden="true"></i> <?=Yii::t('app','essies')?></a></li>
        <li><a href="#4" data-toggle="tab"><i class="fa fa-tasks" aria-hidden="true"></i> <?=Yii::t('app','tasks')?></a></li>
    </ul>

    <div class="tab-content ">
        <div class="tab-pane active" id="1">
            <?= $this->render('_questions',compact('model'))?>
        </div>
        <div class="tab-pane" id="2">
            <br/>
            <?php echo FileUploadUI::widget([
                'model' => $model,
                'attribute' => 'file',
                'url' => ['articles/upload', 'id' => $model->id],
                'gallery' => false,
                'load' => true,
                'fieldOptions' => [
                    'accept' => 'image/*'
                ],
                'clientOptions' => [
                    'maxFileSize' => 30000000,
                ],
                'clientEvents' => [
                    'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
                    'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
                ],
            ]); ?>
        </div>
        <div class="tab-pane" id="3">
            <?= $this->render('_essies',compact('model'))?>
        </div>
        <div class="tab-pane" id="4">
            <?= $this->render('_tasks',compact('model'))?>
        </div>
    </div>
</div>

