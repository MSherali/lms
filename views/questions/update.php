<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Question',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
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
<div class="question-update panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', compact('model','articles')) ?>
        <fieldset>
            <legend><?=Yii::t('app','answers')?></legend>
            <?= $this->render('_answers',compact('model'))?>
        </fieldset>
    </div>
</div>
