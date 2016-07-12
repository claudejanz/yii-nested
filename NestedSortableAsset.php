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

	public $sourcePath = '@vendor/claudejanz/yii2-nested/assets/nested';

	public $css = [
		'jquery.nestable.css',
	];

	public $js = [
		'functions.js',
		'jquery.nestable.js',
	];

	public $depends = [
		'yii\web\YiiAsset',
		'claudejanz\yii2nested\TouchEventAsset',
	];

}