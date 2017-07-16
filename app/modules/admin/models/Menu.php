<?php
namespace app\modules\admin\models;
 
use Yii;
 
class Menu extends \kartik\tree\models\Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }    
    
    /**
     * Override isDisabled method if you need as shown in the  
     * example below. You can override similarly other methods
     * like isActive, isMovable etc.
     */
    public function isDisabled()
    {
        if (Yii::$app->user->can('accessAdminArea') !== true) {
            return true;
        }
        return parent::isDisabled();
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['action','permission','position'], 'safe'];
        $rules[] = [['action','permission','position'], 'required'];
        return $rules;
    }
}
?>