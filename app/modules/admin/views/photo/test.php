<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Photo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="photo-form">

    <?php $form = ActiveForm::begin(['id'=>'form']); ?>

    <!-- <?= $form->field($model, 'metadata')->textarea(['rows' => 6]) ?> -->

    <?php $title = !$model->isNewRecord?(array_key_exists('title', $metadata)?$metadata['title']:null):null;?>
    <?= $form->field($model, 'title')->textInput(['value'=>$title]) ?>

    <?php $file = !$model->isNewRecord?(array_key_exists('file', $metadata)?$metadata['file']:null):null;?>
    <?= $form->field($model, 'file')->textInput(['value'=>$file]) ?>

    <?php $alt = !$model->isNewRecord?(array_key_exists('alt', $metadata)?$metadata['alt']:null):null;?>
    <?= $form->field($model, 'alt')->textInput(['value'=>$alt]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
