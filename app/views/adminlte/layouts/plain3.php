<?php
use app\assets\Layerslider;
use yii\helpers\Html;
use app\modules\admin\models\Settings;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
app\assets\AppAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$setting = Settings::find()->where(['active'=>true])->one();
$config = json_decode($setting->config,true);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<div class="hold-transition <?=$config['theme']?> sidebar-collapse">
		<?= $this->render(
	        'header1.php',
	        ['directoryAsset' => $directoryAsset]
	    ) ?>
	    <?= $this->render(
	        'content3.php',
	        [
	        	'directoryAsset' => $directoryAsset,
	        	'content' => $content 
	        ]
	    ) ?>
	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
