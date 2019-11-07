<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kafedras".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property int $status
 *
 * @property KafedrasSubjects[] $kafedrasSubjects
 * @property Subjects[] $subjects
 */
class Kafedra extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_NOTACTIVE = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kafedras';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
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
            'name' => Yii::t('app', 'kafedra'),
            'short_name' => Yii::t('app', 'short-name'),
            'status' => Yii::t('app', 'status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects()
    {
        return $this->hasMany(Subject::className(), ['kafedra_id' => 'id']);
    }

    public function getStatusList()
    {
        return [ $this::STATUS_ACTIVE => Yii::t('app','Active'), $this::STATUS_NOTACTIVE => Yii::t('app','Not active') ];
    }
}
