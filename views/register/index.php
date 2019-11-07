<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RegisterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'register');
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
<div class="register-index panel panel-info">

    <div class="panel-heading">
        <?= Html::a(Yii::t('app', 'btn-create'), ['create'], ['class' => 'btn btn-success update-modal']) ?>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                [
                    'attribute' => 'faculty',
                    'value' => 'user.course.faculty',
                    'label' => Yii::t('app','faculty')
                ],
                [
                    'attribute' => 'course',
                    'value' => 'user.course.course',
                    'label' => Yii::t('app','course')
                ],
                [
                    'attribute' => 'fullname',
                    'value' => 'user.fullname',
                    'label' => Yii::t('app','fullname')
                ],
                'exam',
                'essy',
                'task',
                'behaviors',
                [
                    'attribute' => 'total',
                    'label' => Yii::t('app','total')
                ],                
                [
                    'attribute' => 'created_at',
                    'value' => 'created_at',
                    'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'created_at',
                            //'value' => date('Y-m-d', strtotime('+2 days')),
                            'options' => ['placeholder' => Yii::t('app','date')],
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true
                            ]]),
                    'format' => 'html',
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' =>'{update} {delete}',
                    'header'=>Yii::t('app','Action'),
                    'buttons' => [
                        'update' => function ( $url, $model) {
                            return Html::a('<span class="fa fa-pencil " aria-hidden="true"></span>', $url, [
                                'title' => 'Change password',
                                'class' => 'update-modal'
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
