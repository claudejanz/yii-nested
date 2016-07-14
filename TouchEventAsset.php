<?php

/**
 * @inheritdoc
 */
namespace claudejanz\yii2nested;

use yii\web\AssetBundle;


/**
 * @inheritdoc
 */
class TouchEventAsset extends AssetBundle
{

	public $sourcePath = '@bower/jquery-touch-events/src/';

	public $css = [
	];

	public $js = [
		'jquery.mobile-events.min.js',
	];

	public $depends = [
            'yii\web\YiiAsset',
	];

}