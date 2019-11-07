<?php
$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="question-create panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', compact('model','articles')) ?>
    </div>
</div>