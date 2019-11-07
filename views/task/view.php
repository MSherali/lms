<?php

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'tasks'), 'url' => ['index']];
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
<div class="task-view panel panel-default">
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
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute'=>'article.title',
                    'label'=>Yii::t('app','article')
                ],
                'title',
            ],
        ]) ?>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'user_id',
                    'value'=>'user.fullname'
                ],
                'reply',
                'rating',
                'created_at',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' =>'{rate}',
                    'header'=>Yii::t('app','Action'),
                    'headerOptions'=>['style'=>'width: 20px;text-align: center;'],
                    'contentOptions'=>['style'=>'width: 20px;text-align: center;'],
                    'buttons' => [
                        'rate' => function ( $url, $model) {
                            $url = Url::toRoute(['task/rate', 'id' => $model->id]);
                            return Html::a('<span class="fa fa-pencil-square" aria-hidden="true"></span>', $url, [
                                'title' => 'Rating', 'class'=>'update-modal'
                            ]);
                        },


                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
