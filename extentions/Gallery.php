<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\extentions;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Description of Gallery
 *
 * @author Claude
 */
class Gallery extends \dosamigos\gallery\Gallery {

    public $imageOptions = [];

    public function renderItem($item) {
        if (is_string($item)) {
            return Html::a(Html::img($item), $item, ['class' => 'gallery-item']);
        }
        $src = ArrayHelper::getValue($item, 'src');
        if ($src === null) {
            return null;
        }
        $url = ArrayHelper::getValue($item, 'url', $src);
        $options = ArrayHelper::getValue($item, 'options', []);
        Html::addCssClass($options, 'gallery-item');

        return Html::a(Html::img($src, $this->imageOptions), $url, $options);
    }

}
