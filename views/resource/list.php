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

?>
    <fieldset>
        <legend><i class="fa fa-book" aria-hidden="true"></i> <?=Yii::t('app','resource')?></legend>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'name',
                    'format' => 'html',
                    'content'=>function($model){
                        return $model->size>0?Html::a($model->name,$model->url):$model->name;
                    }
                ]
            ],
            'summary'=>'',
            'showHeader'=>false,
        ]); ?>

    </fieldset>
</div>
