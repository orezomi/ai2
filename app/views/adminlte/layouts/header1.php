<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header"> 

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">
        <div class="navbar-custom-menu">
            <?=Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'encodeLabels' => false,
                'items' => array_merge(
                        Yii::$app->global->menuItems(['menuPosition'=>'top'])?Yii::$app->global->menuItems(['menuPosition'=>'top']):[],
                        [
                        Yii::$app->user->isGuest ? (
                                ['label' => '<span class="fa fa-power-off"></span>', 'url' => ['/user/security/login']]
                            ) : (
                                '<li>'
                                . Html::a('<span class="fa fa-power-off"></span>', ['/user/security/logout'], ['data' => ['method' => 'post'],'class' => 'bg-black'])
                                . '</li>'
                            )
                        ]
                    ),
                ]);
            ?>
        </div>
    </nav>
</header>
