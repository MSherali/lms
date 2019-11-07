<?php

use dosamigos\fileupload\FileUploadUI;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Resources');
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
    <fieldset class="resource-index">
        <legend><i class="fa fa-link" aria-hidden="true"></i> <?=Yii::t('app','resource-files')?></legend>
        <?php echo FileUploadUI::widget([
            'model' => new \app\models\Resource(),
            'attribute' => 'file',
            'url' => ['resource/upload'],
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
    </fieldset>
    <hr>
    <fieldset>
        <legend><i class="fa fa-book" aria-hidden="true"></i> <?=Yii::t('app','resource')?></legend>

        <?php if(Yii::$app->user->can('admin')): ?>
            <?= Html::a(Yii::t('app', 'btn-create'), ['resource/create'], ['class' => 'btn btn-success update-modal']) ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'name',
                        'format' => 'html'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'controller' => 'resource',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                    Url::to(['resource/update','id'=>$model->id]),
                                    [
                                        'class' => 'update-modal',
                                    ]
                                );
                            },
                        ],
                    ],
                ],
            ]); ?>
        <?php else: ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'name',
                        'format' => 'html'
                    ],
                ],
            ]); ?>
        <?php endif; ?>


    </fieldset>
</div>
