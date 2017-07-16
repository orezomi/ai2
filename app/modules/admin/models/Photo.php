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
            [['metadata'], 'required'],
            [['metadata'], 'string'],
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
        ];
    }
}
