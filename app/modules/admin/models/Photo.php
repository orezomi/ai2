<?php

namespace app\modules\admin\models;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;



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
    public $imageFile;
    public $desc;
    public $tag;
    public $width;
    public $height;

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
            [['metadata','title','alt','desc','tag'], 'required'],
            [['file','imageFile'], 'required', 'on' => 'create'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['metadata','title','file','alt','date'], 'string'],
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
            'desc' => 'Description',
            'tag' => 'Tags',
            'date'=> 'Date',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            $main = 'images/'.$this->id_photo.'_'. $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $small = 'images/small/'.$this->id_photo.'_'. $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $thumb = 'images/thumb/'.$this->id_photo.'_'. $this->imageFile->baseName . '.' . $this->imageFile->extension;

            $this->imageFile->saveAs($main);

            Image::thumbnail('@webroot/'.$main, 160, 120)->save(Yii::getAlias('@webroot/'.$thumb), ['quality' => 100]);

            // Image::thumbnail('@webroot/'.$main, 600, 400)->save(Yii::getAlias('@webroot/'.$small), ['quality' => 100]);

            $rootFolder = Yii::getAlias('@webroot');

            Image::getImagine()->open($rootFolder.'/'.$main)->thumbnail(new Box(600, 400))->save($rootFolder.'/'.$small , ['quality' => 100]);


            return true;
        } else {
            return false;
        }
    }

    public function getTags()
    {
        // return $this->hasMany(PhotoTag::className(), ['id_tag' => 'id_tag']);
        return $this->hasMany(Tags::className(), ['id_tag' => 'id_tag'])->viaTable('photoTag', ['id_photo' => 'id_photo']);
    }
}
