
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use app\modules\admin\models\Tags;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\PhotoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Photos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">
    <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        
            <p>
                <?= Html::button('<i class="glyphicon glyphicon-plus"></i> &nbsp; Create Photo', ['class' => 'btn btn-success input-data btn-xs','value'=>Url::to(['create'])]) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'condensed' => true,
                'bordered' => false,
                'hover' => true,
                'striped' => true,
                'responsive' => false,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'header'=>'Image',
                        'format'=>'raw',
                        'value'=>function($model){
                            $metadata = json_decode($model->metadata,true);
                            return Html::img('images/thumb/'.$model->id_photo.'_'.$metadata['file'],['alt'=>$metadata['alt'],'title'=>$metadata['title'],'class'=>'thumbnail']);
                        }
                    ],
                    [
                        'header'=>'Title',
                        'format'=>'raw',
                        'value'=>function($model){
                            $metadata = json_decode($model->metadata,true);
                            return $metadata['title'];
                        }
                    ],
                    [
                        'header'=>'File',
                        'format'=>'raw',
                        'value'=>function($model){
                            $metadata = json_decode($model->metadata,true);
                            return $metadata['file'];
                        }
                    ],
                    [
                        'header'=>'Alt',
                        'format'=>'raw',
                        'value'=>function($model){
                            $metadata = json_decode($model->metadata,true);
                            return $metadata['alt'];
                        }
                    ],
                    [
                        'header'=>'Desc',
                        'format'=>'raw',
                        'value'=>function($model){
                            $metadata = json_decode($model->metadata,true);
                            return $metadata['desc'];
                        }
                    ],
                    [
                        'header'=>'Width',
                        'format'=>'raw',
                        'value'=>function($model){
                            $metadata = json_decode($model->metadata,true);
                            return isset($metadata['width'])?$metadata['width']:null;
                        }
                    ],
                    [
                        'header'=>'Height',
                        'format'=>'raw',
                        'value'=>function($model){
                            $metadata = json_decode($model->metadata,true);
                            return isset($metadata['height'])?$metadata['height']:null;
                        }
                    ],
                    [
                        'header'=>'Tags',
                        'format'=>'raw',
                        'value'=>function($model){
                            // $t = Tags::findOne(2);
                            // $model->link('tags', $t);
                            $tags = $model->tags;

                            $ts=[];
                            foreach ($tags as $tag) {
                                $ts[]=$tag->tag;
                            }
                            
                            return implode(', ', $ts);
                            // return $t->tag;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'headerOptions' => ['style' => 'width:100px;'],
                        'buttons' => [
                            'view' => function($url,$model,$key){
                                $url = Url::to(['view','id'=>$model->id_photo]);
                                $link = Html::button('<span class="glyphicon glyphicon-eye-open"></span>',['class'=>'btn btn-xs btn-success viewButton','value'=>$url,'title'=>'View']);
                                return $link;
                            },
                            'update' => function($url,$model,$key){
                                $url = Url::to(['update','id'=>$model->id_photo]);
                                $link = Html::button('<span class="glyphicon glyphicon-pencil"></span>',['class'=>'btn btn-xs btn-warning updateButton','value'=>$url,'title'=>'Edit']);
                                return $link;
                            },
                            'delete' => function($url,$model,$key){
                                $link = Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id_photo], [
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete',
                                    'data' => [
                                        'confirm' => 'Yakin mau hapus ini?',
                                        'method' => 'post',
                                    ],
                                ]);
                                return $link;
                            }
                        ],
                    ],
                ],
            ]); ?>
            </div>

</div>
