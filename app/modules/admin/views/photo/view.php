<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Photo */

$this->title = $model->id_photo;
$this->params['breadcrumbs'][] = ['label' => 'Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
    <div class="box-body">
    <?=Html::img('images/'.$model->id_photo.'_'.$metadata['file'],['class'=>'thumbnail','width'=>'100%'])?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_photo',
            [
            	'attribute'=>'metadata',
            	'format'=>'raw',
            	'value'=>function($model) use ($metadata){
            		
            		return '
						<b>Title</b> : '.$metadata['title'].'<br/>
						<b>File</b> : '.$model->id_photo.'_'.$metadata['file'].'<br/>
						<b>Alt</b> : '.$metadata['alt'].'
            		';
            	}
            ],
            [
                'attribute'=>'tags',
                'format'=>'raw',
                'value'=>function($model){
                    return implode(', ',array_keys(ArrayHelper::map($model->tags,'tag','tag'))); 
                }
            ]
        ],
    ]) ?>

    </div>
</div>