<?php

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
<div class="panel">
    <div class="panel-heading">
        <form class="col-md-11" action="<?=Url::to(['articles/tasks'])?>" method="get">
            <input type="hidden" name="id" value="<?=$id?>">
            <div class="row">
                <div class="col-md-4">
                    <?=Html::dropDownList('task',$task, $tasks,['class'=>'form-control' ])?>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary"><?=Yii::t('app','btn-search')?></button>
                </div>
            </div>
        </form>
        <span class="pull-right col-md-1">
            <?=Html::a(Yii::t('app','article'),['articles/view','id'=>$id],['class'=>'btn btn-sm btn-success'])?>
        </span>
    </div>
    <div class="panel-body">
        <?php foreach ($data as $model): ?>
            <div class="form-group">
                <h4>
                    <span class="label bg-gray text-bold"><?=$model->user->fullname?></span>
                    <span class="label bg-red text-bold"><?=$model->rating?></span>
                    <?= Html::a(Yii::t('app', 'btn-rate'), ['articles/task-rate','id'=>$model->id,'article'=>$id], ['class' => 'update-modal pull-right']) ?>
                </h4>
                <div class="well">
                    <p><?=$model->reply?></p>
                    <span class="label bg-gray pull-right"><?=$model->created_at?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
