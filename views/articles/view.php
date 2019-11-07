<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
?>
<div class="article-view panel panel-default">
    <div class="panel-heading">
        <span class="pull-right label label-default"><?=$model->subject->name . ' / ' . $model->sequence?></span>
        <?=$model->title?>
    </div>

    <div class="panel-body" style="overflow-y:scroll; max-height:600px;">
        <div class="post-sum"><?=$model->lecture?></div>
    </div>

    <?php if($model->getMedias()->count()>0): ?>
    <div class="panel-body">
        <fieldset>
            <legend><i class="fa fa-film" aria-hidden="true"></i> <?=Yii::t('app','media')?></legend>
            <div class="row">
            <?php foreach ($model->medias as $media):?>
                <div class="col-md-3">
                    <a href="<?=Yii::getAlias('@web').$media->url?>">
                        <div class="media">
                            <div class="media-left">
                                <img alt="64x64" class="media-object" data-src="" src="<?=Yii::getAlias('@web').'/img/'.$media->extension.'-48.png'?>" style="width: 34px; height: 34px;">
                            </div>
                            <div class="media-body">
                                <?=$media->name?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach;?>
            </div>
        </fieldset>
    </div>
    <?php endif; ?>

    <div class="panel-footer">
        <?php if(!Yii::$app->user->isGuest){ ?>
            <?php if(Yii::$app->user->can('manage-articles')){ ?>
                <?= Html::a(Yii::t('app', 'btn-update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'btn-delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'confirm-delete'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php } ?>

            <?php if(Yii::$app->user->can('pass-test')){ ?>
                <?= Html::a(Yii::t('app', 'btn-exam'), ['exams/test', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
            <?php } ?>
            <?= Html::a(Yii::t('app', 'btn-question'), ['essies', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
            <?= Html::a('<i class="fa fa-question-circle-o"></i> '.Yii::t('app', 'task'), ['tasks', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?php } ?>
        <div class="text-muted pull-right">
            <span class="label label-info margin-right"><?=$model->course->course.' '.$model->course->faculty?></span> /
            <span class="label label-default margin-right"><?=Yii::$app->params['lang'][$model->lang]?></span> /
            <span class="label label-success"><i class="fa fa-clock-o icon-muted"></i> <?=date('j M, y',strtotime($model->updated_at))  ?></span> /
            <span class="label label-<?=$model->status == \app\models\Article::STATUS_ACTIVE ? 'success' : 'danger'?>"><?=$model->getStatusList()[$model->status]?></span>
        </div>
        <br/>
    </div>
</div>
