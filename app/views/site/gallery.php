<?php
use orezomi\wmk\Wookmark;
use app\modules\admin\models\Photo;
use app\modules\admin\models\Tags;
use yii\helpers\Url;

echo Wookmark::widget();

?>

<div id="filters" class="text-center"> 
	<span data-filter="all" class="btn btn-xs btn-default">All</span>
	<?php
		$tags = Tags::find()->limit(17)->all();
		foreach ($tags as $tag) {
			echo "<span data-filter='$tag->tag' class='btn btn-xs btn-default'>$tag->tag</span>";
		}
	?>
</div>
<hr />
<div style="margin:0px 10px;">
	<?=\imanilchaudhari\rrssb\ShareBar::widget([
	        'title' => 'All Indonesia Photo Blog', // i.e. $model->title
	        'media' => 'http://all-indonesia.com/images/small/7_DSC00566.jpg', // Media Content
	        'networks' => [
	            'Facebook',
	            'Twitter', 
	            'GooglePlus',
	            'Pinterest',
	            'Email',
	        ]
	    ]); 
	?>
</div>

<div id ="main" role="main">

	<ul id="tiles" class="tiles-wrap animated">
		<?php
			$photos = Photo::find()->with('tags')->asArray()->all();
			foreach ($photos as $photo) {
				$filters = json_encode(array_column($photo['tags'], 'tag'));
				$file = (json_decode($photo['metadata'],true));
				echo '<li class="wookmark-inactive"  data-filter-class=\''.$filters.'\'><a href="'.Url::to(['photo/view','id'=>$photo['id_photo']]).'"><img src="images/small/'.$photo['id_photo'].'_'.$file['file'].'"></a><h4>'.$file['title'].'</h4><p>'.$file['desc'].'</p></li>';
			}
		?>
	</ul>
</div>
<?php
$js=<<<js
	(function ($){
		$('#tiles').imagesLoaded(function() {
			// Prepare layout options.
	        var options = {
				autoResize: true,
				container: $('#main'),
				offset: 5, // Optional, the distance between grid items
				itemWidth: 350,
				fillEmptySpace: true,
				outerOffset: 10,
				flexibleWidth:true
	        };
	        
	        var handler = $('#tiles li'),
	            filters = $('#filters span');
	        
	        handler.wookmark(options);
	        
	        var onClickFilter = function(event) {
	          var item = $(event.currentTarget),
	              activeFilters = [],
	              filterType = item.data('filter');;
	          
			if (filterType === 'all') {
	        	filters.removeClass('active');
	        } else {
					item.toggleClass('active');
					filters.filter('.active').each(function() {
						activeFilters.push($(this).data('filter'));
					});
				}
	          handler.wookmarkInstance.filter(activeFilters, 'or');
	        }
	        filters.click(onClickFilter);
      	});
    })(jQuery);
js;

$css='
	#tiles li {
	    -moz-box-sizing: border-box;
	    box-sizing: border-box;
	}

	#tiles li p{
	    text-align:left;
	}

	#tiles li h4{
		margin: 7px 0 2px 7px;
	}
	 
	#tiles li img {
	    width: 100%;
	    height: auto;
	}

	#tiles li {
	  -webkit-transition: all 0.3s ease-in-out;
	     -moz-transition: all 0.3s ease-in-out;
	       -o-transition: all 0.3s ease-in-out;
	          transition: all 0.3s ease-in-out;
	}

	.wookmark-placeholder {
	  -webkit-transition: all 0.3s ease-in-out;
	     -moz-transition: all 0.3s ease-in-out;
	       -o-transition: all 0.3s ease-in-out;
	          transition: all 0.3s ease-in-out;
	}

	#main {
		margin-bottom : 80px;
		margin-top : 0px;
		position: relative;
		overflow: hidden;
	}

	.content-header{
		display : none;
	}

	#filters span{
		margin :3px;
	}
';

$this->registerJs($js);
$this->registerCss($css);
?>