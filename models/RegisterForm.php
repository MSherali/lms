<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $course;
    public $created_at;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['course', 'created_at'], 'required'],
            ['course', 'integer'],
            ['created_at', 'date'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'course' => Yii::t('app', 'course'),
            'created_at' => Yii::t('app', 'created_at'),
        ];
    }
}
