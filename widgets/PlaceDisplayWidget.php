<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlaceDisplayWidget
 *
 * @author Claude
 */
class PlaceDisplayWidget extends Widget{
   public $place;

    public function run() {
        
        $controller = Yii::$app->controller;
        $elements = $controller->page->getElementByPlaceName($this->place);
        if ($elements) {
            foreach ($elements as $element) {
        //var_dump('ici',$element,'ici');
                echo $controller->renderPartial('/elements/view', array('model' => $element));
            }
        }
    }

}
