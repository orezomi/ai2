<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Settings;
use app\modules\admin\models\SettingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller 
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'activate' => ['POST'],
                ],
            ],
            'access'=>[
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','update','delete','view','activate','create'],
                        'roles' => ['accessAdminArea'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Settings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Settings model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Settings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Settings();

        if ($model->load(Yii::$app->request->post())) {
            //process config to json settings
            $config['theme'] = $model->theme;
            $config['appTitleLong']= $model->appTitleLong;
            $config['appTitleShort']= $model->appTitleShort;

            $model->active = 0;

            $model->config = json_encode($config);

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Settings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
             //process config to json settings
            $config['theme'] = $model->theme;
            $config['appTitleLong']= $model->appTitleLong;
            $config['appTitleShort']= $model->appTitleShort;

            $model->config = json_encode($config);

            if ($model->save()) {
                return $this->redirect(['index']);
            }
            
        } else {
            $config = json_decode($model->config,true);
            return $this->renderAjax('update', [
                'model' => $model,
                'config' => $config,
            ]);
        }
    }

    public function actionActivate($id){

        $request = Yii::$app->request;
        
        $model = $this->findModel($id);

        $allModel = Settings::find()->all();

        foreach ($allModel as $m) {
            $m->active = false;
            $m->save(false);
        }
        $model->active = true;
        if ($model->save(false)) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes an existing Settings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
