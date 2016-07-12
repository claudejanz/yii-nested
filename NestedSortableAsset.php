<?php

/**
 * @inheritdoc
 */
namespace claudejanz\yii2nested;

use yii\web\AssetBundle;


/**
 * @inheritdoc
 */
class NestedSortableAsset extends AssetBundle
{

	public $sourcePath = '@app/widgets/nested/assets/';

	public $css = [
		'nested/jquery.nestable.css',
	];

	public $js = [
		'nested/functions.js',
		'@vendor/bower/jquery-touch-events/jquery.nestable.js',
	];

	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapPluginAsset',
	];

}