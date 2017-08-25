<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;


/* @var $this \yii\web\View */
/* @var $content string */

?>

<header class="main-header"> 

    <?= Html::a('<span class="logo-mini"><b>AI</b></span><span class="logo-lg">' . Yii::$app->global->appconf['appTitleShort'] . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <?php
                $staticMenu = [
                    ['label' => 'Privacy Policy', 'url' => ['/site/privacypolicy']],
                    ['label' => 'Term of Services', 'url' => ['/site/tos']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']]
                ];
                $menu = array_merge(
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
                );

                $semuaMenu = array_merge($staticMenu,$menu);
            ?>
            <?=Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'encodeLabels' => false,
                'items' => $semuaMenu,
                ]);
            ?>
        </div>
    </nav>
</header>
