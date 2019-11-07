<?php

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="panel">
    <div class="panel-body">
        <?php foreach ($data as $model): ?>
            <?php if(count($model->replies)>0): ?>
                <?php if($model->replies[0]->rating == 0): ?>
                    <?php $form = ActiveForm::begin(); $r_model = $model->replies[0];   ?>
                        <h4>
                            <span class="h4"><?=$model->title?></span>
                        </h4>
                        <?= $form->field($r_model, 'reply')->textarea()->label(false) ?>
                        <?= $form->field($r_model, 'id')->hiddenInput()->label(false) ?>
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-success']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                <?php else: ?>
                    <div class="form-group">
                        <h4>
                            <span class="h4"><?=$model->title?></span>
                            <span class="label bg-red text-bold"><?=$model->replies[0]->rating?></span>
                        </h4>
                        <div class="well">
                            <p><?=$model->replies[0]->reply?></p>
                            <span class="label bg-gray pull-right"><?=$model->replies[0]->created_at?></span>
                        </div>

                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php $form = ActiveForm::begin(); $r_model = new \app\models\EssyReply(); $r_model->essy_id = $model->id;   ?>
                    <h4>
                        <span class="h4"><?=$model->title?></span>
                    </h4>
                    <?= $form->field($r_model, 'reply')->textarea()->label(false) ?>
                    <?= $form->field($r_model, 'essy_id')->hiddenInput()->label(false) ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'btn-save'), ['class' => 'btn btn-success']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
