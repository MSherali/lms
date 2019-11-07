<?php

/* @var $this yii\web\View */

use app\assets\AppAsset;

$this->title = Yii::t('app','author');
$this->params['breadcrumbs'][] = $this->title;
$directoryAsset = AppAsset::register($this)->baseUrl;
?>
<div class="bs-example" data-example-id="default-media">
    <div class="media">
        <div class="media-left">
            <a href="#">
                <img alt="author" class="media-object img-circle" src="<?=$directoryAsset?>/img/author1.jpg" data-holder-rendered="true" style="width: 96px; height: 96px;">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">Каримов Мухаммадали Абдухоликович</h4>
            <p>
                <ul class="list-group">
                    <li>31.07.1983 йили Наманган вилояти, Косонсой туманида ишчилар оиласида туғилган. Миллати тожик.</li>
                    <li>2009 й. Андижон давлат тиббиёт институтини (кундузги) даволаш факультетини тамомлаган.</li>
                    <li>2009-2009 йй. - Наманган вилояти Косонсой туман бирлашмасининг кўп тармоқли поликлиникаси шифокори</li>
                    <li>2009-2012 йй. - Андижон давлат тиббиёт институти онкология мутахассислиги бўйича магистранти</li>
                    <li>2012-2015 йй. - Андижон давлат тиббиёт институти клиник радиология, онкология ва фтизиатрия кафедраси ассистенти</li>
                    <li>2015 - 2016 йй.   - Андижон давлат тиббиёт институти онкология, радиология ва фтизиатрия кафедраси ассистенти</li>
                    <li>2016 й ҳв - Андижон давлат тиббиёт институти онкология ва тиббий радиология кафедраси ассистенти</li>
                </ul>
            </p>
            <p>
                <a href="https://telegram.me/karalidoctor" class="btn btn-sm btn-icon btn-info"><i class="fa fa-telegram"></i></a>
                <a href="https://www.facebook.com/" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-facebook"></i></a>
                <a href="https://plus.google.com/" class="btn btn-sm btn-icon btn-danger"><i class="fa fa-google-plus"></i></a>
                <a href="https://www.linkedin.com/in/" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-linkedin"></i></a>
                <a href="#" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-phone"></i>&nbsp;&nbsp;+998 97 2520644</a>
            </p>
        </div>
    </div>	  
    <hr>
    <div class="media">
        <div class="media-left">
            <a href="#">
                <img alt="author" class="media-object img-circle" src="<?=$directoryAsset?>/img/developer.jpg" data-holder-rendered="true" style="width: 96px; height: 96px;">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">Маматкаримов Шерали</h4>
            <h5 class="media-heading text-bold">Дастурчи</h5>
            <p>
                <ul class="list-group">
                    <li>Веб технологиялари: Php, Yii2, Laravel, Jquery, JS, HTML5, CSS</li>
                    <li>Windows desktop: C#</li>
                    <li>Маълумотлар базаси: Oracle, MS SQL, MySQL, SQLite, MS Access</li>
                </ul>
            </p>

            <p>
                <a href="https://telegram.me/SheraliM" class="btn btn-sm btn-icon btn-info"><i class="fa fa-telegram"></i></a>
                <a href="https://www.facebook.com/sherali.mamatkarimov" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-facebook"></i></a>
                <a href="https://plus.google.com/+SheraliMamatkarimov" class="btn btn-sm btn-icon btn-danger"><i class="fa fa-google-plus"></i></a>
                <a href="https://www.linkedin.com/in/sherali-m-40370749" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-linkedin"></i></a>
                <a href="#" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-phone"></i>&nbsp;&nbsp;+998 90 3811777</a>

            </p>
        </div>
    </div>
</div>