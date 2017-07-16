<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;

class MenuController extends \yii\web\Controller {

	public function behaviors()
    {
        return [
            'access'=>[
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['accessAdminArea'],
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
?>