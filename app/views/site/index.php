<?php

/* @var $this yii\web\View */

$this->title = 'All Indonesia Photo Blog';
?>
<div class="site-index">
    <div id="layerslider" class="fullsize" style="width:1600px;height:900vh;">
        <?php
            foreach ($photoArray as $key => $value) {
        ?>
        <div class="ls-slide" data-ls="duration: 4000; transition2d: 48;">
            <!-- Slide background image of the first slide -->
            <img src="<?='images/'.$key.'_'.$value['file'].''?>" class="ls-bg" alt="Slide background">
            <h1 class="ls-layer" style="top: 80%; left: 50%; color:white;"><?=$value['title']?></h1>
            <p class="ls-layer" style="top: 84%; left: 50%; color:white;"><?=$value['desc']?></p>
        </div>
        <?php 
            }
        ?>
    </div>
</div>

<?php
$js = <<<JS
    $('#layerslider').layerSlider({
        skin: 'fullwidthdark'
    });
JS;
$this->registerJs($js);
?>