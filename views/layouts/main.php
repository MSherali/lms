<?php
use app\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    $directoryAsset = AppAsset::register($this)->baseUrl;
?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="shortcut icon" href="<?=$directoryAsset?>/favicon.ico" type="image/x-icon">
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render('header.php',compact('directoryAsset')); ?>

        <?=  $this->render('left.php'); ?>

        <?= $this->render('content.php', compact('content', 'directoryAsset')); ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
