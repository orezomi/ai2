<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\Tags;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Photo */
/* @var $form yii\widgets\ActiveForm */
$data = ArrayHelper::map(Tags::find()->all(),'tag','tag');
?>

<div class="photo-form">

    <?php $form = ActiveForm::begin([
        'id'=>'form',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?php $title = !$model->isNewRecord?(array_key_exists('title', $metadata)?$metadata['title']:null):null;?>
    <?= $form->field($model, 'title')->textInput(['value'=>$title]) ?>

    <?php $file = !$model->isNewRecord?(array_key_exists('file', $metadata)?$metadata['file']:null):null;?>
    <?php 
        if (!$model->isNewRecord) {
            echo $form->field($model, 'file')->hiddenInput(['value'=>$file])->label(false);
        }
    ?>

    <?php $alt = !$model->isNewRecord?(array_key_exists('alt', $metadata)?$metadata['alt']:null):null;?>
    <?= $form->field($model, 'alt')->textInput(['value'=>$alt]) ?>

    <?php $desc = !$model->isNewRecord?(array_key_exists('desc', $metadata)?$metadata['desc']:null):null;?>
    <?= $form->field($model, 'desc')->textArea(['value'=>$desc]) ?>

    <?php 

        if (!$model->isNewRecord) {
            $model->tag = array_keys(ArrayHelper::map($model->tags,'tag','tag'));
        }else{
            $model->tag = [];
        }

    ?>
    <?= $form->field($model, 'tag')->widget(Select2::classname(), [
        'data' => $data,
        'options' => ['placeholder' => 'Tags...','multiple'=>true],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
            'tokenSeparators' => [',', ';'],
            'maximumInputLength' => 10
        ],
    ]);?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
