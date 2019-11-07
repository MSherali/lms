<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exam_details".
 *
 * @property int $id
 * @property int $exam_id
 * @property int $question_id
 * @property int $answer_id
 * @property int $rating
 * @property int $elapsed
 */
class ExamDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exam_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['exam_id', 'question_id'], 'required'],
            [['exam_id', 'question_id', 'rating', 'elapsed'], 'integer'],
            [['answer_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'exam_id' => Yii::t('app', 'Exam ID'),
            'question_id' => Yii::t('app', 'question'),
            'answer_id' => Yii::t('app', 'answer'),
            'rating' => Yii::t('app', 'rating'),
            'elapsed' => Yii::t('app', 'Elapsed'),
        ];
    }

    public function getExam()
    {
        return $this->hasOne(Exam::className(), ['id' => 'exam_id']);
    }

    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }
}
