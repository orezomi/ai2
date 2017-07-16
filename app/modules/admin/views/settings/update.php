<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Settings */

$this->title = 'Update Settings: ' . $model->i_setting;
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->i_setting, 'url' => ['view', 'id' => $model->i_setting]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-info">
	<div class="box-body">
	    <?= $this->render('_form', [
	        'model' => $model,
	        'config' => $config,
	    ]) ?>
	</div>
</div>
