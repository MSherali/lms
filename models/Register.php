<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "register".
 *
 * @property int $id
 * @property int $user_id
 * @property int $exam
 * @property int $essy
 * @property int $task
 * @property int $behaviors
 * @property string $created_at
 */
class Register extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'register';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'required'],
            [['user_id', 'exam', 'essy', 'task', 'behaviors'], 'integer'],
            [['created_at'], 'safe'],
            [['user_id', 'created_at'], 'unique', 'targetAttribute' => ['user_id', 'created_at']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'user'),
            'exam' => Yii::t('app', 'test'),
            'essy' => Yii::t('app', 'question'),
            'task' => Yii::t('app', 'task'),
            'behaviors' => Yii::t('app', 'behaviors'),
            'created_at' => Yii::t('app', 'date'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getTotal()
    {
        //return ceil(($this->exam + $this->essy + $this->task + $this->behaviors) / 4 );
        return round(($this->exam + $this->essy + $this->task + $this->behaviors) / 4 );
    }
}
