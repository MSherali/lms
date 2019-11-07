<?php
/* @var $this yii\web\View */

use app\assets\AppAsset;

$this->title = Yii::$app->name;
$model = new \app\models\Media();
$directoryAsset = AppAsset::register($this)->baseUrl;
?>

<div class="content-wrapper"
		 style="background-image: url('<?= $directoryAsset ?>/img/banner.jpg');
			 background-position: center;
			 background-repeat: no-repeat;
			 background-size: contain;">
</div>
