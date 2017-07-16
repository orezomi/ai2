<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Settings */

$this->title = $model->i_setting;
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'i_setting',
                'n_setting',
                'config:ntext',
                'active',
            ],
        ]) ?>
    </div>
</div>