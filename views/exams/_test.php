<?php
/**
 * Created by PhpStorm.
 * User: SM7949
 * Date: 6/2/2017
 * Time: 6:33 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$js = <<< JS
    setInterval(function(){
      var elapsed = $('#elapsed').val();
      elapsed++;
      var remain = 120-elapsed;
      $('#elapsed').val(elapsed);
      if(remain <= 0){
          $('#examForm').submit();
      }          
      var m = Math.floor(remain / 60);
      var s = Math.floor(remain % 60 % 60);
      $('#timer').text(('0' + m).slice(-2) + ":" + ('0' + s).slice(-2));
    }, 1000);
JS;

$this->registerJs($js);
?>
<div class="exam-form">
    <?php $form = ActiveForm::begin(['action'=>['exams/answer','id'=>$exam],'id'=>'examForm']); ?>
    <div class="well">
        <?=$model->question->question?>
    </div>
     <div class="panel-body">
    <?php
        foreach ($model->question->answers as $answer){
            if($model->question->multianswer == 1){
                echo '<div class="form-group field-answer-answer required"><label><input type="checkbox" id="answer-answer" name="Answer[]" value="'.$answer->id.
                    '"> '.$answer->answer.'</label></div>';
            }
            else{
                echo '<div class="form-group field-answer-answer required"><label><input type="radio" id="answer-answer" name="Answer[]" value="'.$answer->id.
                    '"> '.$answer->answer.'</label></div>';
            }
        }

        echo '<input type="hidden" name="Exam" value="'.$model->id.'" />';
        echo '<input type="hidden" name="elapsed" value="0" id="elapsed" />';
    ?>
     </div>
    <div class="form-group">
        <span class="h4 pull-right text-center" style="border:1px solid #ff0000; width: 100px;" id="timer"></span>

        <?= Html::submitButton(Yii::t('app', 'btn-next'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
