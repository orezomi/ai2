<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id_tag
 * @property string $tag
 *
 * @property PhotoTag[] $photoTags
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag'], 'required'],
            [['tag'], 'unique'],
            [['tag'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tag' => 'Id Tag',
            'tag' => 'Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        // return $this->hasMany(PhotoTag::className(), ['id_tag' => 'id_tag']);
        return $this->hasMany(Photo::className(), ['id_photo' => 'id_photo'])->viaTable('photoTag', ['id_tag' => 'id_tag']);
    }
}
