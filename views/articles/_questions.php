<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $form yii\widgets\ActiveForm */
$question_url = Url::to('/iOncology/web/questions/qidir');
$article_id = $model->id;
$lang = $model->lang;
$js = <<< JS
    $(function  () {        
        $("#questions_ajax").select2({
          ajax: {
            url: '$question_url',
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                q: params.term, // search term
                page: params.page,
                article: $article_id,
                lang: '$lang'
              };
            },
            processResults: function (data, params) {
              // parse the results into the format expected by Select2
              // since we are using custom formatting functions we do not need to
              // alter the remote JSON data, except to indicate that infinite
              // scrolling can be used
              params.page = params.page || 1;
        
              return {
                results: data.results,
                pagination: {
                  more: (params.page * 30) < data.total_count
                }
              };
            }
            //cache: true
          },
          escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
          minimumInputLength: 1
          //templateResult: funtion(repo){}, // omitted for brevity, see the source of this page
          //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });
      
    });
JS;
$this->registerJs($js);

?>

<div class="panel-body">
    <div class="panel panel-body">
        <?php $form = ActiveForm::begin(['action'=>['articles/question'],'method'=>'POST']); ?>
            <div class="form-group">
                <select class="form-control" id="questions_ajax" name="question_id">
                    <option value="" selected="selected"><?=Yii::t('app','Search')?></option>
                </select>
            </div>
            <input type="hidden" name="article_id" value="<?=$model->id?>">
            <?= Html::submitButton(Yii::t('app', 'btn-add'), ['class' => 'btn btn-info']) ?>
        <?php ActiveForm::end(); ?>
    </div>



    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'key'=>'id',
            'allModels' => $model->questions,
            'sort' => [
                'attributes' => ['id', 'answer','is_correct'],
            ],
            'pagination' => false,
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'question',
                'format' => 'html'
            ],
            'difficulty',
            [
                'attribute'=>'multianswer',
                'content'=>function($model){
                    return $model->multianswer==1?'<i class="fa fa-check-circle" aria-hidden="true"></i>':'';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                //'controller' => 'answers',
                'buttons' => [
                    'delete' => function ($url, $model)use($article_id) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            Url::to(['articles/question-delete','article_id'=>$article_id,'question_id'=>$model->id]),
                            [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                'data-method' => 'post',
                            ]
                        );
                    },
                ],
            ],
        ],
    ])?>
</div>
