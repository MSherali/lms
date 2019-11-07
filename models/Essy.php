<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "essies".
 *
 * @property int $id
 * @property int $article_id
 * @property string $title
 */
class Essy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'essies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'title'], 'required'],
            [['article_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'question'),
        ];
    }

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    public function getReplies()
    {
        return $this->hasMany(EssyReply::className(), ['essy_id' => 'id']);
    }
}
