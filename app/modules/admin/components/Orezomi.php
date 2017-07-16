<?php
namespace app\modules\admin\components;
 
use Yii;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\admin\models\Menu;
use app\modules\admin\models\Settings;
 
class Orezomi extends Component {

    public function getAppconf(){
        $set = Settings::find()->where(['active'=>true])->one();
        $conf = json_decode($set->config,true);
        return $conf;
    }

    public function getActions(){
        $controllers = FileHelper::findFiles(Yii::getAlias('@app/controllers'), ['recursive' => true]);
        $actions = [];
        foreach ($controllers as $controller) {
            $contents = file_get_contents($controller);
            $controllerId = Inflector::camel2id(substr(basename($controller), 0, -14));
            preg_match_all('/public function action(\w+?)\(/', $contents, $result);
            foreach ($result[1] as $action) {
                $actionId = Inflector::camel2id($action);
                $route = '/'.$controllerId . '/' . $actionId;
                $actions[$route] = $route;
                // $actions[] = $route;
            }
        }
        asort($actions);
        return $actions;
    } 

    private function menuChildren($id){
        $menu = Menu::findOne(['id' => $id]);
        $children = $menu->children()->all();
        $permissions = !Yii::$app->user->isGuest?Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->identity->id):[];
        $items = [];
        if ($children) {
            foreach ($children as $key=>$child) {
                $items[$key]['label']=$child->name;
                $items[$key]['icon']=$child->icon;
                $items[$key]['url']=[$child->action];
                $items[$key]['visible']=array_key_exists($child->permission,$permissions)?true:false;
                $items[$key]['items']=$this->menuChildren($child->id);
            }
        }
        return $items;
        
    }

    public function menuItems($params){

        $permissions = !Yii::$app->user->isGuest?Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->identity->id):[];

        $roots = Menu::find()->select(['id','name','action','permission','icon'])->where(['position'=>$params['menuPosition']])->roots()->all();

        $items=[];
        foreach ($roots as $key=>$root) {
            $items[$key]['label'] = $params['menuPosition']!=='top'?$root->name:Html::tag('span','',['class'=>'fa fa-'.$root->icon]);
            $items[$key]['icon']=$root->icon;
            $items[$key]['url']=[$root->action];
            $items[$key]['visible']=array_key_exists($root->permission,$permissions)?true:false;
            $items[$key]['items']=$this->menuChildren($root->id);
        }
        return $items;
    }
}
?>