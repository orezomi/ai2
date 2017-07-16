<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="images/logo.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info"> 
                <p><?=!Yii::$app->user->isGuest?Yii::$app->user->identity->username:'Guest'?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => Yii::$app->global->menuItems(['menuPosition'=>'left'])?Yii::$app->global->menuItems(['menuPosition'=>'left']):[],
            ]
        ) ?>

    </section>

</aside>
