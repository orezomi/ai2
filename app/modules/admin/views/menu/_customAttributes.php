<?php
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\modules\admin\models\Menu;

$permissions = Yii::$app->authManager->permissions;
$items = ArrayHelper::map($permissions, 'name', 'name');
$existingMenuActions = Menu::find()->select(['action'])->distinct()->all();
$m=[];

foreach ($existingMenuActions as $ma) {
	$m[$ma->action]=$ma->action;
}

$actions = Yii::$app->global->actions;

echo $form->field($node, 'action')->widget(Select2::classname(),[
	'name' => 'action',
    'value' => $node->action,
    'data' => array_unique(array_merge($actions,$m)),
    'options' => ['placeholder' => 'Select an action ...'],
    'pluginOptions' => [
        'tags' => true,
        'tokenSeparators' => [',', ' '],
        'maximumInputLength' => 200
    ],
]);
echo $form->field($node, 'permission')->dropDownList($items,['prompt'=>'Select Role']);

echo $form->field($node,'position')->dropDownList(['top'=>'Top','left'=>'Left'],['prompt'=>'Select menu position'])
?>