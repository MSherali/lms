<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KafedraSubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'kafedras and subjects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kafedra-subject-index panel panel-info">
    <div class="panel-heading">
        <?= Html::a(Yii::t('app', 'btn-create'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'kafedra',
                    'value' => 'kafedras.name',
                    'label' => Yii::t('app','kafedra')
                ],
                [
                    'attribute'=>'subject',
                    'value' => 'subjects.name',
                    'label' => Yii::t('app','subject')
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
