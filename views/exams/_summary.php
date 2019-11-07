<?php
/**
 * Created by PhpStorm.
 * User: SM7949
 * Date: 6/2/2017
 * Time: 6:33 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="exam-form">
    <div class="panel-body">
        <div class="row margin-bottom">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon bg-gray text-bold"><?=Yii::t('app','article')?></span>
                    <span class="form-control"><?=$exam->article->title?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon bg-gray text-bold"><?=Yii::t('app','fullname')?></span>
                    <span class="form-control"><?=$exam->user->fullname?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon bg-gray text-bold"><?=Yii::t('app','started_at')?></span>
                    <span class="form-control"><?=$exam->started_at?></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon bg-gray text-bold"><?=Yii::t('app','finished_at')?></span>
                    <span class="form-control"><?=$exam->finished_at?></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon bg-gray text-bold"><?=Yii::t('app','time_difference')?> (HH:mm:ss)</span>
                    <span class="form-control"><?php $d1 = new DateTime($exam->started_at); $d2 = new DateTime($exam->finished_at); $inter = $d1->diff($d2); echo $inter->format('%H:%i:%s') ?></span>
                </div>
            </div>
        </div>
    </div>
     <div class="panel panel-body">
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th><?=Yii::t('app','id')?></th>
                    <th><?=Yii::t('app','question')?></th>
                    <th><?=Yii::t('app','rating')?></th>
                </tr>
            </thead>
            <tbody>
            <?php $i=0;$total=0; $correct=0; $mistake=0; foreach ($details as $item):?>
                <tr>
                    <td><?=++$i;?></td>
                    <td><?=$item->question->question?></td>

                    <?php if($item->rating==0): ?>
                        <td class="danger"><?php echo $item->rating; $mistake++; ?></td>
                    <?php else: ?>
                        <td><?php echo $item->rating; $total+=$item->rating;  $correct++; ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach;?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3"><?=Yii::t('app','test-summary',['total'=>$total, 'success'=>$correct, 'fail'=>$mistake])?></th>
                </tr>
            </tfoot>
        </table>
     </div>
</div>
