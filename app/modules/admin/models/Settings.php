<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $i_setting
 * @property string $n_setting
 * @property string $config
 * @property integer $active
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $theme;
    public $appTitleLong;
    public $appTitleShort;


    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['n_setting', 'config', 'active','theme','appTitleShort','appTitleLong'], 'required'],
            [['config'], 'string'],
            [['active'], 'integer'],
            [['n_setting'], 'string', 'max' => 50],
            [['appTitleShort','appTitleLong'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'i_setting' => 'ID Setting',
            'n_setting' => 'Name',
            'config' => 'Config',
            'active' => 'Active',
            'theme' => 'Theme',
            'appTitleShort'=>'Short Title',
            'appTitleLong'=>'Long Title',
        ];
    }
}
