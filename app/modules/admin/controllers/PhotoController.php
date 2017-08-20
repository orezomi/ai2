<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Photo;
use app\modules\admin\models\PhotoSearch;
use app\modules\admin\models\Tags;
use app\modules\admin\models\PhotoTag;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

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
        $dataProvider->query = Photo::find()->orderBy('id_photo desc');

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

            $tags = $model->tag;

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            $model->file = UploadedFile::getInstance($model, 'imageFile')->name;

            $metadata['title'] = $model->title;
            $metadata['file'] = UploadedFile::getInstance($model, 'imageFile')->name;
            $metadata['alt'] = $model->alt;
            $metadata['desc'] = $model->desc;

            list($width, $height) = getimagesize($model->imageFile->tempName);
            $metadata['width']=$width;
            $metadata['height']=$height;

            $model->metadata = json_encode($metadata);

            if ($model->save()) {
                if ($model->upload()) {
                    $this->linkTag($model,$tags);
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
        $location = Yii::getAlias('@webroot/images/');

        if ($model->load(Yii::$app->request->post())) {

            $tags = $model->tag;

            $metadata['title'] = $model->title;
            $metadata['alt'] = $model->alt;
            $metadata['file'] = $model->file;
            $metadata['desc'] = $model->desc;

            list($width, $height) = getimagesize($location.$oldFile);
            $metadata['width']=$width;
            $metadata['height']=$height;

            $imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($imageFile) {
                $model->imageFile = $imageFile;
                $metadata['file'] = $imageFile->name;
                list($width, $height) = getimagesize($imageFile->tempName);
                $metadata['width']=$width;
                $metadata['height']=$height;
            }

            $model->metadata = json_encode($metadata);

            if ($model->save()) {
                if ($imageFile && $model->upload()) {
                    file_exists($location.$oldFile)?unlink($location.$oldFile):false;
                    file_exists($location.'thumb/'.$oldFile)?unlink($location.'thumb/'.$oldFile):false;
                    file_exists($location.'small/'.$oldFile)?unlink($location.'small/'.$oldFile):false;
                    return $this->redirect(['index']);
                }

                $this->unlinkTag($model,$tags);
                $this->linkTag($model,$tags);

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

    protected function unlinkTag($model,$tags=[]){
        $modelOldTags = array_keys(ArrayHelper::map($model->tags,'tag','tag'));
        $newTag = $tags;
        $result = array_diff($modelOldTags,$newTag);
        foreach ($result as $res) {
            $tag = Tags::find()->where(['tag'=>$res])->one();
            if ($tag) {
                $pt = PhotoTag::find()->where(['id_tag'=>$tag->id_tag,'id_photo'=>$model->id_photo])->one();
                if ($pt) {
                    // $model->unlink('tags',$tag);
                    $pt->delete();
                }
            }
            
        }
    }

    protected function linkTag($model,$tags=[]){
        // $model = $this->findModel($id);
        foreach ($tags as $tag) {
            $searchTag = Tags::find()->where(['tag'=>$tag])->one();
            if (!$searchTag) {
                $newTag = new Tags;
                $newTag->tag = $tag;
                $newTag->save();
                $model->link('tags',$newTag);
            }elseif($searchTag){
                $pt = PhotoTag::find()->where(['id_tag'=>$searchTag->id_tag,'id_photo'=>$model->id_photo])->one();
                if (!$pt) {
                    $model->link('tags',$searchTag);
                }
            }
        }
    }
}
