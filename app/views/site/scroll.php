<?php
use orezomi\wmk\Wookmark;
use app\modules\admin\models\Photo;
use app\modules\admin\models\Tags;
use yii\helpers\Url;

echo Wookmark::widget();
$this->title='All Indonesia Photo Blog';

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

<div role="main">

	<ul id="container" class="tiles-wrap animated">
	<!-- These is where we place content loaded from the Wookmark API -->
	</ul>

	<div id="loader">
	<div id="loaderCircle"></div>
	</div>

</div>
<?php
$urldata = Url::to(['site/data']);
$js=<<<js
	(function ($) {
      var handler = null,
          page = 1,
          isLoading = false,
          apiURL = '$urldata',
          container = '#container',
          loaderCircle = $('#loaderCircle'),
          wookmark = undefined,
          options = {
            offset: 2, // Optional, the distance between grid items
            itemWidth: 210 // Optional, the width of a grid item
          };
      /**
       * When scrolled all the way to the bottom, add more tiles.
       */
      function onScroll(event) {
        // Only check when we're not still waiting for data.
        if(!isLoading) {
          // Check if we're within 100 pixels of the bottom edge of the broser window.
          var closeToBottom = ($(window).scrollTop() + $(window).height() > $(document).height() - 100);
          if (closeToBottom) {
            loadData();
          }
        }
      };
      /**
       * Refreshes the layout after all images have loaded
       */
      function applyLayout() {
        imagesLoaded(container, function () {
          if (wookmark === undefined) {
            wookmark = new Wookmark(container);
          } else {
            wookmark.initItems();
            wookmark.layout(true);
          }
        });
      };
      /**
       * Loads data from the API.
       */
      function loadData() {
        isLoading = true;
        loaderCircle.show();
        $.ajax({
          url: apiURL,
          dataType: 'jsonp',
          data: {page: page}, // Page parameter to make sure we load new data
          success: onLoadData
        });
      };
      /**
       * Receives data from the API, creates HTML for images and updates the layout
       */
      function onLoadData(data) {
        isLoading = false;
        loaderCircle.hide();
        // Increment page index for future calls.
        page++;
        // Create HTML for the images.
        var html = '';
        var i=0, length=data.length, image;
        for(; i<length; i++) {
          image = data[i];
          html += '<li>';
          // Image tag (preview in Wookmark are 200px wide, so we calculate the height based on that).
          html += '<img src="'+image.preview+'" width="200" height="'+Math.round(image.height/image.width*200)+'">';
          // Image title.
          html += '<p>'+image.title+'</p>';
          html += '</li>';
        }
        // Add image HTML to the page.
        $(container).append(html);
        // Apply layout.
        applyLayout();
      };
      // Capture scroll event.
      $(document).bind('scroll', onScroll);
      // Load first data from the API.
      loadData();
    })(jQuery);
js;

$css='
	#container li {
	    -moz-box-sizing: border-box;
	    box-sizing: border-box;
	}

	#container li p{
	    text-align:left;
	}

	#container li h4{
		margin: 7px 0 2px 7px;
	}
	 
	#container li img {
	    width: 100%;
	    height: auto;
	}

	#container li {
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