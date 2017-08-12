<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Photo */

$this->title = $metadata['title'];
$this->params['breadcrumbs'][] = ['label' => 'Photos', 'url' => ['site/gallery']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
    <?=\imanilchaudhari\rrssb\ShareBar::widget([
            'title' => $metadata['title'], // i.e. $model->title
            'media' => 'images/'.$model->id_photo.'_'.$metadata['file'], // Media Content
            'networks' => [
                'Facebook',
                'Twitter', 
                'GooglePlus',
                'Pinterest',
                'Email',
            ]
        ]); 
    ?>
    <?=Html::img('images/'.$model->id_photo.'_'.$metadata['file'],['class'=>'thumbnail','width'=>'100%'])?>

    <?= DetailView::widget([
        'model' => $model,
        'options' =>[
            'class'=>'table table-condensed table-striped'
        ],
        'attributes' => [
            // 'id_photo',
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