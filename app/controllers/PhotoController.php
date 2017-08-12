<?php

namespace app\controllers;
use app\modules\admin\models\Photo;
use yii\web\NotFoundHttpException;

class PhotoController extends \yii\web\Controller
{
    public function actionView($id)
    {
    	$this->layout = 'plain2';
    	$model = $this->findModel($id);
        return $this->render('view',[
        	'model'=>$model,
        	'metadata' => json_decode($model->metadata,true),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
