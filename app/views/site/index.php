<?php

/* @var $this yii\web\View */

$this->title = 'All Indonesia Photo Blog';
?>
<div class="site-index">
    <div id="layerslider" class="fullsize" style="width:1200px;height:600vh;">
 
        <!-- First slide -->
        <div class="ls-slide" data-ls="duration: 4000; transition2d: all;">
            <!-- Slide background image of the first slide -->
            <img src="images/slide-1.jpg" class="ls-bg" alt="Slide background">
        </div>
     
        <!-- Second slide -->
        <div class="ls-slide" data-ls="duration: 4000; transition3d: all;">
            <!-- Slide background image of the second slide -->
            <img src="images/slide-2.jpg" class="ls-bg" alt="Slide background">
        </div>

        <!-- Second slide -->
        <div class="ls-slide" data-ls="duration: 4000; transition2d: all;">
            <!-- Slide background image of the second slide -->
            <img src="images/slide-3.jpg" class="ls-bg" alt="Slide background">
        </div>
    </div>
</div>

<?php
$js = <<<JS
    $('#layerslider').layerSlider({
        skin: 'borderlessdark3d',
        plugins: ['origami']
    });
JS;
$this->registerJs($js);
?>