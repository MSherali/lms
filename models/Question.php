<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property int $id
 * @property int $article_id
 * @property string $question
 * @property int $difficulty
 * @property int $multianswer
 */
class Question extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'lang'], 'required'],
            [['difficulty', 'multianswer'], 'integer'],
            [['question','lang'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            //'article_id' => Yii::t('app', 'article'),
            'question' => Yii::t('app', 'question'),
            'difficulty' => Yii::t('app', 'difficulty'),
            'multianswer' => Yii::t('app', 'multianswer'),
            'lang' => Yii::t('app', 'lang'),
        ];
    }

    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])->viaTable('article_question', ['question_id' => 'id']);
    }

    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    public function getExamDetails()
    {
        return $this->hasMany(ExamDetail::className(), ['question_id' => 'id']);
    }
}
