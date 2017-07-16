<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $this     yii\web\View
 * @var $content string
 */

use dektrium\rbac\widgets\Menu;

?>

<div class="box box-danger">
	<div class="box-body">
		<?= Menu::widget() ?>
		<?= $content ?>
	</div>
</div>