<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Photo */

$this->title = 'Update Photo: ' . $model->id_photo;
$this->params['breadcrumbs'][] = ['label' => 'Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_photo, 'url' => ['view', 'id' => $model->id_photo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-info">
    <div class="box-body">
    
    <?= $this->render('_form', [
        'model' => $model,
        'metadata' => $metadata
    ]) ?>

	</div>
</div>