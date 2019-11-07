<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subjects".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property int $status
 *
 * @property Kafedra $kafedra
 */
class Subject extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_NOTACTIVE = 9;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status','kafedra_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['short_name'], 'string', 'max' => 15],
            [['name'], 'unique'],
            [['short_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'subject'),
            'short_name' => Yii::t('app', 'short-name'),
            'kafedra_id' => Yii::t('app', 'kafedra'),
            'status' => Yii::t('app', 'status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKafedra()
    {
        return $this->hasOne(Kafedra::className(), ['id' => 'kafedra_id']);
    }

    public function getKafedraName()
    {
        return $this->kafedra ? $this->kafedra->name : '';
    }

    public function getKafedraList()
    {
        return ArrayHelper::map(Kafedra::find()->all(),'id','name');
    }

    public function getArticles()
    {
        return $this->hasMany(Article::className(),['subject_id' => 'id']);
    }

    public function getStatusList()
    {
        return [ $this::STATUS_ACTIVE => Yii::t('app','Active'), $this::STATUS_NOTACTIVE => Yii::t('app','Not active') ];
    }
}
