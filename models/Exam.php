<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exams".
 *
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property string $started_at
 * @property string $finished_at
 * @property int $rating
 */
class Exam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'user_id'], 'required'],
            [['article_id', 'user_id','rating'], 'integer'],
            [['started_at', 'finished_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'article_id' => Yii::t('app', 'article'),
            'user_id' => Yii::t('app', 'user'),
            'rating' => Yii::t('app', 'rating'),
            'started_at' => Yii::t('app', 'started_at'),
            'finished_at' => Yii::t('app', 'finished_at'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    public function getDetails()
    {
        return $this->hasMany(ExamDetail::className(), ['exam_id' => 'id']);
    }

    public function getBaho() {
        return $this->getDetails()->sum('rating');
    }
}
