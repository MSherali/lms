<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
<div class="question-view panel panel-default">
    <div class="panel-heading">
        <?= Html::a(Yii::t('app', 'btn-update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'btn-delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'confirm-delete'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <h4><span class="label bg-gray text-bold"><?=$model->getAttributeLabel('question')?></span></h4>
            <div class="well"><?=$model->question?></div>
        </div>

        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon bg-gray text-bold"><?=$model->getAttributeLabel('difficulty')?></span>
                <span class="form-control"><?=$model->difficulty?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon bg-gray text-bold"><?=$model->getAttributeLabel('multianswer')?></span>
                <span class="form-control"><?=$model->multianswer?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon bg-gray text-bold"><?=$model->getAttributeLabel('lang')?></span>
                <span class="form-control"><?=$model->lang?></span>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <fieldset>
            <legend><?=Yii::t('app','answers')?></legend>
            <?= $this->render('_answers',compact('model'))?>
        </fieldset>
    </div>
</div>
