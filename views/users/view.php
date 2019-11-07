<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
$this->title = $model->fullname;

 if(!Yii::$app->user->isGuest && Yii::$app->user->can('admin')){
     $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'users'), 'url' => ['index']];
     $this->params['breadcrumbs'][] = $this->title;
 }


?>
<div class="user-view panel panel-default">

    <div class="panel-heading">
        <span class="h3"><?=$model->fullname ?></span>
        <?php if(!Yii::$app->user->isGuest && Yii::$app->user->can('admin')): ?>
        <div class="btn-group pull-right">
            <?= Html::a(Yii::t('app', 'btn-update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'btn-delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'confirm-delete'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="panel-body">
        <table id="w0" class="table table-striped table-bordered detail-view">
            <tbody>
            <tr>
                <th><?=$model->getAttributeLabel('username')?></th>
                <td><?=$model->username?></td>
                <th><?=$model->getAttributeLabel('address')?></th>
                <td><?=$model->address?></td>
            </tr>
            <tr>
                <th><?=$model->getAttributeLabel('fullname')?></th>
                <td><?=$model->fullname?></td>
                <th><?=$model->getAttributeLabel('phone')?></th>
                <td><?=$model->phone?></td>
            </tr>
            <tr>
                <th><?=$model->getAttributeLabel('gruppa')?></th>
                <td><?=$model->gruppa?></td>
                <th><?=$model->getAttributeLabel('email')?></th>
                <td><?=$model->email?></td>

            </tr>
            <tr>
                <th><?=Yii::t('app','course')?></th>
                <td><?=$model->course ? $model->course->course : ''?></td>
                <th><?=$model->getAttributeLabel('birthplace')?></th>
                <td><?=$model->birthplace?></td>
            </tr>
            <tr>
                <th><?=Yii::t('app','faculty')?></th>
                <td><?=$model->course ? $model->course->faculty : '' ?></td>
                <th><?=$model->getAttributeLabel('updated_at')?></th>
                <td><?=$model->updated_at?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a  href="#1" data-toggle="tab"><?=Yii::t('app','test')?></a></li>
            <li><a href="#2" data-toggle="tab"><?=Yii::t('app','essies')?></a></li>
            <li><a href="#3" data-toggle="tab"><?=Yii::t('app','tasks')?></a></li>
        </ul>

        <div class="tab-content ">
            <div class="tab-pane active" id="1">
                <table class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th><?=Yii::t('app','id')?></th>
                        <th><?=Yii::t('app','title')?></th>
                        <th><?=Yii::t('app','rating')?></th>
                        <th><?=Yii::t('app','started_at')?></th>
                        <th><?=Yii::t('app','finished_at')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=0;foreach ($model->exams as $item):?>
                        <tr>
                            <td><?=++$i;?></td>
                            <td><?=$item->article->title?></td>
                            <td><?php echo $item->rating; ?></td>
                            <td><?php echo $item->started_at; ?></td>
                            <td><?php echo $item->finished_at; ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="2">
                <table class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th><?=Yii::t('app','question')?></th>
                        <th><?=Yii::t('app','answer')?></th>
                        <th><?=Yii::t('app','rating')?></th>
                        <th><?=Yii::t('app','created_at')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model->essyReplies as $eReply):?>
                        <tr>
                            <td><?=$eReply->essy->title?></td>
                            <td><?php echo $eReply->reply; ?></td>
                            <td><?php echo $eReply->rating; ?></td>
                            <td><?php echo $eReply->created_at; ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="3">
                <table class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th><?=Yii::t('app','question')?></th>
                        <th><?=Yii::t('app','answer')?></th>
                        <th><?=Yii::t('app','rating')?></th>
                        <th><?=Yii::t('app','created_at')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model->taskReplies as $taskReply):?>
                        <tr>
                            <td><?=$taskReply->task->title?></td>
                            <td><?php echo $taskReply->reply; ?></td>
                            <td><?php echo $taskReply->rating; ?></td>
                            <td><?php echo $taskReply->created_at; ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
