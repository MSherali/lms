<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini"><img src="'. $directoryAsset.'/img/logo.png"  class="img-circle" /> </span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if(Yii::$app->user->isGuest){ ?>
                    <li>
                        <a href="<?=\yii\helpers\Url::to(['site/login'])?>"><i class="fa fa-sign-in"></i></a>
                    </li>
                <?php } else {?>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= $directoryAsset ?>/img/nophoto-160x160.png" class="user-image" alt="User Image"/>
                            <span class="hidden-xs"><?=Yii::$app->user->identity->username?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?=$directoryAsset?>/img/nophoto-160x160.png" class="img-circle" alt="User Image"/>

                                <?php //Html::a(Yii::$app->user->identity->fullname, ['users/view','id'=>Yii::$app->user->id],['class'=>'text-white'])?>
                                <p>
                                    <small><?=Yii::$app->user->identity->fullname?></small>
                                    <small><?=Yii::$app->user->identity->email?></small>
                                    <small><?=Yii::$app->user->identity->phone?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-right">
                                    <?= Html::a('<i class="fa fa-key"></i>',
                                        ['users/update-password'],
                                        ['class' => 'btn btn-default btn-flat']
                                    ) ?>
                                    <?= Html::a('<i class="fa fa-info-circle"></i>',
                                        ['users/view','id'=>Yii::$app->user->id],
                                        ['class' => 'btn btn-default btn-flat']
                                    ) ?>
                                    <?= Html::a(
                                        Yii::t('app','btn-sign-out'),
                                        ['/site/logout'],
                                        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                    ) ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            
            <ul class="nav navbar-nav">
                <?php foreach (Yii::$app->params['lang'] as $k=>$lang){
                    if(Yii::$app->language==$k){
                        echo '<li>'.Html::a('<strong><u>'.$lang.'</u></strong>',['site/language','lang'=>$k],['class'=>'text-bold']).'</li>';
                    }
                    else{
                        echo '<li>'.Html::a($lang,['site/language','lang'=>$k]).'</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </nav>
</header>
