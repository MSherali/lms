<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answers".
 *
 * @property int $id
 * @property int $question_id
 * @property string $answer
 * @property int $is_correct
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'answer'], 'required'],
            [['question_id', 'is_correct'], 'integer'],
            [['answer'], 'string', 'max' => 4000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'question_id' => Yii::t('app', 'question'),
            'answer' => Yii::t('app', 'answer'),
            'is_correct' => Yii::t('app', 'is_correct'),
        ];
    }
}
