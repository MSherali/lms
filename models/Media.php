<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medias".
 *
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property string $url
 * @property int $size
 * @property int $article_id
 */
class Media extends \yii\db\ActiveRecord
{
    const SECTION_PRESENTATION = 0;
    const SECTION_VIDEO = 1;
    const SECTION_OTHERS = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medias';
    }

    /**
     * @inheritdoc
     */
    //public $file;
    public function rules()
    {
        return [
            [['name', 'extension', 'url', 'size', 'article_id'], 'required'],
            [['size', 'article_id'], 'integer'],
            [['name'], 'string', 'max' => 255],

            [['extension'], 'string', 'max' => 10],
            [['url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'extension' => Yii::t('app', 'Extension'),
            'url' => Yii::t('app', 'Url'),
            'size' => Yii::t('app', 'Size'),
            'article_id' => Yii::t('app', 'article'),
        ];
    }
}
