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

	public $sourcePath = 'assets/';

	public $css = [
		'nested/jquery.nestable.css',
	];

	public $js = [
		'nested/functions.js',
		'jquery.nestable.js',
	];

	public $depends = [
		'yii\web\YiiAsset',
		'claudejanz\yii2nested\TouchEventAsset',
	];

}