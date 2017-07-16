<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Settings */
/* @var $form yii\widgets\ActiveForm */



$const = [
    'theme'=>[
        "skin-blue"=>"skin-blue",
        "skin-black"=>"skin-black",
        "skin-red"=>"skin-red",
        "skin-yellow"=>"skin-yellow",
        "skin-purple"=>"skin-purple",
        "skin-green"=>"skin-green",
        "skin-blue-light"=>"skin-blue-light",
        "skin-black-light"=>"skin-black-light",
        "skin-red-light"=>"skin-red-light",
        "skin-yellow-light"=>"skin-yellow-light",
        "skin-purple-light"=>"skin-purple-light",
        "skin-green-light"=>"skin-green-light",
    ],
];

?>

<div class="settings-form">

    <?php $form = ActiveForm::begin([
    	'id'=>'settingsForm'
    ]); ?>
    
    <?= $form->field($model, 'n_setting')->textInput(['maxlength' => true]) ?>

    <?php $ddvalue = !$model->isNewRecord?(array_key_exists('theme',$config)?$config['theme']:null):null;?>
    <?= $form->field($model, 'theme')->dropDownList($const['theme'],['value'=>$ddvalue]);?>

    <?php $appTitleLong = !$model->isNewRecord?(array_key_exists('appTitleLong', $config)?$config['appTitleLong']:null):null;?>
    <?= $form->field($model, 'appTitleLong')->textInput(['value'=>$appTitleLong]) ?>

    <?php $appTitleShort = !$model->isNewRecord?(array_key_exists('appTitleShort', $config)?$config['appTitleShort']:null):null;?>
    <?= $form->field($model, 'appTitleShort')->textInput(['value'=>$appTitleShort]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
