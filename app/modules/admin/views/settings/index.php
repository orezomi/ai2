<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView; 

/* @var $this yii\web\View */
/* @var $searchModel app\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
    <div class="box-body">
        <p>
            <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Add New Setting',['class'=>'btn btn-danger input-data btn-xs','value'=>Url::to(['settings/create'])]) ?>
        </p>
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            // 'condensed'=>true,
            // 'striped'=>true,
            // 'bordered'=>false,
            // 'hover'=>true,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'n_setting',
                'config:ntext',
                // 'active',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Active',
                    'template' => '{active}',
                    'headerOptions' => ['style' => 'width:40px;'],
                    'buttons' => [
                        'active' => function($url,$model,$key){
                            $url = Url::to(['activate','id'=>$model->i_setting]);
                            $link = Html::a('<span class="fa fa-close"></span>',$url,[
                                    'class'=>'activate',
                                    // 'value'=>$url,
                                    'title'=>'Activate',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]);
                            return $model->active==true ? '<span class="fa fa-check"></span>':$link;
                        },
                    ],
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'headerOptions' => ['style' => 'width:100px;'],
                    'buttons' => [
                        'view' => function($url,$model,$key){
                            $url = Url::to(['view','id'=>$model->i_setting]);
                            $link = Html::button('<span class="glyphicon glyphicon-eye-open"></span>',['class'=>'btn btn-xs btn-success viewButton','value'=>$url,'title'=>'View']);
                            return $link;
                        },
                        'update' => function($url,$model,$key){
                            $url = Url::to(['update','id'=>$model->i_setting]);
                            $link = Html::button('<span class="glyphicon glyphicon-pencil"></span>',['class'=>'btn btn-xs btn-warning updateButton','value'=>$url,'title'=>'Edit']);
                            return $link;
                        },
                        'delete' => function($url,$model,$key){
                            $link = Html::a('<span class="glyphicon glyphicon-trash"></span>', ['settings/delete', 'id' => $model->i_setting], [
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
