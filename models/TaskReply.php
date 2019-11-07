<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_replies".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string $reply
 * @property int $rating
 * @property string $created_at
 */
class TaskReply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_replies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id', 'reply'], 'required'],
            [['task_id', 'user_id', 'rating'], 'integer'],
            [['reply'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'task_id' => Yii::t('app', 'task'),
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

    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}
