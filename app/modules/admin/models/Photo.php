<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "photo".
 *
 * @property integer $id_photo
 * @property string $metadata
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $title;
    public $file;
    public $alt;

    public static function tableName()
    {
        return 'photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['metadata','title','file','alt'], 'required'],
            [['metadata','title','file','alt'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_photo' => 'Id Photo',
            'metadata' => 'Metadata',
            'title' => 'Title',
            'file' => 'File',
            'alt' => 'Alt Text',
        ];
    }
}
