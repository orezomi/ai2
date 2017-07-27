<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "photoTag".
 *
 * @property integer $id_photo
 * @property integer $id_tag
 */
class PhotoTag extends \yii\db\ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photoTag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_photo', 'id_tag'], 'required'],
            [['id_photo', 'id_tag'], 'integer'],
            [['id_photo', 'id_tag'], 'unique', 'targetAttribute' => ['id_photo', 'id_tag'], 'message' => 'The combination of Id Photo and Id Tag has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_photo' => 'Id Photo',
            'id_tag' => 'Id Tag',
        ];
    }
}
