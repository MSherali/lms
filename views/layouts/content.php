<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } ?>
        <div class="">
        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
        </div>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>
