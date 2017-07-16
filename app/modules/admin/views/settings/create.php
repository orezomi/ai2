<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Settings */

$this->title = 'New Setting';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
	<div class="box-body">
	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>
	</div>
</div>