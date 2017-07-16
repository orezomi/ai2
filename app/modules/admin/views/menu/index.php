<?php
use kartik\tree\TreeView;
use kartik\tree\Module;
use app\modules\admin\models\Menu;

$this->title = 'Menu Management';
?>
<div class="box box-info">
	<div class="box-body">	
	<?=TreeView::widget([
	    // single query fetch to render the tree
	    // use the Product model you have in the previous step
	    'query' => Menu::find()->addOrderBy('root, lft'), 
	    // 'permissions'=>$permissions,
	    'nodeAddlViews' => [
	        Module::VIEW_PART_1 => '',
	        Module::VIEW_PART_2 => '@app/modules/admin/views/menu/_customAttributes',
	        Module::VIEW_PART_3 => '',
	        Module::VIEW_PART_4 => '',
	        Module::VIEW_PART_5 => '',
	    ],
	    'headingOptions' => ['label' => 'Menu Items'],
	    'fontAwesome' => true,     // optional
	    'isAdmin' => false,         // optional (toggle to enable admin mode)
	    'displayValue' => 1,        // initial display value
	    'softDelete' => false,       // defaults to true
	    'cacheSettings' => [        
	        'enableCache' => true   // defaults to true
	    ],
	]);
	?>
	</div>
</div>