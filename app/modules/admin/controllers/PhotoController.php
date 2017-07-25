<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Photo;
use app\modules\admin\models\PhotoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * PhotoController implements the CRUD actions for Photo model.
 */
class PhotoController extends Controller 
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
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','update','delete','create','view'],
                        'roles' => ['accessAdminArea'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Photo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhotoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Photo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('view', [
            'model' => $model,
            'metadata' => json_decode($model->metadata,true),
        ]);
    }

    /**
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Photo();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            $model->file = UploadedFile::getInstance($model, 'imageFile')->name;

            $metadata['title'] = $model->title;
            $metadata['file'] = UploadedFile::getInstance($model, 'imageFile')->name;
            $metadata['alt'] = $model->alt;
            $metadata['desc'] = $model->desc;



            $model->metadata = json_encode($metadata);

            if ($model->save()) {
                if ($model->upload()) {
                    return $this->redirect(['index']);
                }
            }
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Photo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldData = json_decode($model->metadata,true);
        $oldFile = $model->id_photo.'_'.$oldData['file'];

        if ($model->load(Yii::$app->request->post())) {

            $metadata['title'] = $model->title;
            $metadata['alt'] = $model->alt;
            $metadata['file'] = $model->file;
            $metadata['desc'] = $model->desc;
            $imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($imageFile) {
                $model->imageFile = $imageFile;
                $metadata['file'] = $imageFile->name;
            }

            $model->metadata = json_encode($metadata);

            if ($model->save()) {
                if ($imageFile && $model->upload()) {
                    $location = Yii::getAlias('@webroot/images/');
                    file_exists($location.$oldFile)?unlink($location.$oldFile):false;
                    file_exists($location.'thumb/'.$oldFile)?unlink($location.'thumb/'.$oldFile):false;
                    file_exists($location.'small/'.$oldFile)?unlink($location.'small/'.$oldFile):false;
                    return $this->redirect(['index']);
                }
                return $this->redirect(['index']);
            }
        } else {
            $metadata = json_decode($model->metadata,true);
            return $this->renderAjax('update', [
                'model' => $model,
                'metadata' => $metadata,
            ]);
        }
    }

    /**
     * Deletes an existing Photo model.
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
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
