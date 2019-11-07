<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "courses".
 *
 * @property int $id
 * @property string $course
 * @property string $faculty
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course', 'faculty'], 'required'],
            [['course'], 'string', 'max' => 30],
            [['faculty'], 'string', 'max' => 50],
            [['course', 'faculty'], 'unique', 'targetAttribute' => ['course', 'faculty']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'course' => Yii::t('app', 'course'),
            'faculty' => Yii::t('app', 'faculty'),
        ];
    }
}
