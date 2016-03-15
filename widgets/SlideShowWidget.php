<?php

namespace app\widgets;

use app\models\ElementSlideshow;
use dosamigos\gallery\Carousel;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SlideShowWidget
 *
 * @author Claude
 */
class SlideShowWidget extends Widget {

   
    public $model;

    public function run() {
        $model = $this->model;
        if ($model->elementSlideshowImages) {
            $all = $model->elementSlideshowImages;
            $items = [];
            foreach ($all as $slide) {
                /* @var $slide ElementSlideshow */
                $items[] = [
                    'url' => $slide->url,
                    'src' => $slide->src,
                    'options' => array('title' => $slide->title)
                ];
            }
            $options = ['items' => $items, 'clientOptions' => ['stretchImages' => "cover"]];
            echo Carousel::widget($options);
            if (Yii::$app->user->can('update')) {
                $editableButtonOptions = ['class' => 'btn btn-sm btn-default kv-editable-button'];
                echo Html::a('<i class="glyphicon glyphicon-pencil"></i>',['/elements/update','id'=>$model->id], $editableButtonOptions);
                echo Html::a('<i class="glyphicon glyphicon-sort-by-attributes"></i>',['/elements/slideshow-order','id'=>$model->id], $editableButtonOptions);
            }
        }
    }
}
