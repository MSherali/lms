<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property int $sequence
 * @property string $title
 * @property string $lecture
 * @property string $lang
 * @property string $course_id
 * @property string $subject_id
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Article extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_NOTACTIVE = 9;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }


    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','sequence', 'lecture', 'lang', 'course_id', 'subject_id', 'created_at'], 'required'],
            [['sequence','course_id','subject_id','status'], 'integer'],
            [['lecture', 'lang'], 'string'],
            [['file', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 2000],
            [['lang'], 'default', 'value'=> 'uz'],

            [['file'], 'file', 'extensions'=>'jpg, gif, png, ppt, pptx, mp4, mp3, avi, 3gp'],
            [['file'], 'file', 'maxSize'=>'1000000'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'title' => Yii::t('app', 'title'),
            'sequence' => Yii::t('app', 'sequence'),
            'lecture' => Yii::t('app', 'lecture'),
            'lang' => Yii::t('app', 'lang'),
            'course_id' => Yii::t('app', 'course'),
            'subject_id' => Yii::t('app', 'subject'),
            'status' => Yii::t('app', 'status'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
        ];
    }

    public function getMedias()
    {
        return $this->hasMany(Media::className(),['article_id' => 'id']);
    }

    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    public function getEssies()
    {
        return $this->hasMany(Essy::className(), ['article_id' => 'id']);
    }

    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['article_id' => 'id']);
    }

    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])->viaTable('article_question', ['article_id' => 'id']);
    }

    public function getStatusList()
    {
        return [ $this::STATUS_ACTIVE => Yii::t('app','Active'), $this::STATUS_NOTACTIVE => Yii::t('app','Not active') ];
    }
}
