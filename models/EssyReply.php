<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "essy_replies".
 *
 * @property int $id
 * @property int $essy_id
 * @property int $user_id
 * @property string $reply
 * @property int $rating
 */
class EssyReply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'essy_replies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['essy_id', 'user_id', 'reply'], 'required'],
            [['essy_id', 'user_id', 'rating'], 'integer'],
            [['reply'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'essy_id' => Yii::t('app', 'question'),
            'user_id' => Yii::t('app', 'user'),
            'reply' => Yii::t('app', 'answer'),
            'rating' => Yii::t('app', 'rating'),
            'created_at' => Yii::t('app', 'created_at'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getEssy()
    {
        return $this->hasOne(Essy::className(), ['id' => 'essy_id']);
    }
}
