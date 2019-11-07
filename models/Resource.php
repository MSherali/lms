<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resources".
 *
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property string $url
 * @property int $size
 */
class Resource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resources';
    }

    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['size'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 10],
            [['url'], 'string', 'max' => 1000],

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
            'name' => Yii::t('app', 'name'),
            'extension' => Yii::t('app', 'extension'),
            'url' => Yii::t('app', 'url'),
            'size' => Yii::t('app', 'size'),
        ];
    }
}
