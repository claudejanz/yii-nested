<?php

namespace app\widgets;

use app\models\ProjectImage;
use claudejanz\gsap\TimelineMax;
use claudejanz\gsap\TweenMax;
use claudejanz\scrollmagic\ScrollController;
use claudejanz\scrollmagic\ScrollScene;
use kartik\helpers\Html;
use kartik\icons\Icon;
use Yii;
use yii\base\Widget;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SplashWidget
 *
 * @author Claude
 */
class SplashWidget extends Widget
{

    public $model;

    public function run()
    {
        $model = $this->model;
        if ($model) {
            echo Html::beginTag('section', ['id'=>$this->id]);
            $image = ProjectImage::find()->where(['homepage'=>1])->orderBy('RAND()')->limit(1)->one();
            $img = Html::img($image->imageBig, ['class' => 'img-responsive']);
            echo Html::a($img,['projects/index']);
            echo Html::beginTag('div', ['class' => 'container']);
            echo Html::beginTag('h2');

            echo $model->title;
            if (Yii::$app->user->can('editor')) {
                echo Html::a(Icon::show('pencil'), ['elements/update', 'id' => $model->id], ['class' => 'btn btn-sm btn-default']);
            }
            echo Html::endTag('h2');
            $textes = $model->elementTexts;
            foreach ($textes as $text) {
                echo Html::tag('p', $text->content);
            }
            echo Html::endTag('div'); //container
            echo Html::endTag('section'); //container
            $this->registerScripts();
        }
    }

    private function registerScripts(){
        $this->registerJs();
        $this->registerCss();
    }
    private function registerJs()
    {
        $this->view->registerJsFile('@web/js/SplitText.js', ['depends' => ['yii\web\JqueryAsset']]);
        

        $controller = new ScrollController([
//    'globalSceneOptions' => [
//        'triggerHook' => "onEnter",
//    ]
        ]);
        /*
         * section 1
         */
// create a Screen
        $scene = new ScrollScene(['triggerElement' => '#$this->id', 'triggerHook' => 'onEnter']);
// create a Timeline
        $timeline = new TimelineMax([]);

// title effect
        $tween1 = TweenMax::from("#$this->id h2", 0.5, ['autoAlpha' => 0, 'scale' => 0]);
        $timeline->add($tween1);

// teaser effect
        $controller->addJs("
	var teaser = $('#$this->id p:nth-child(2)').splitText({'types':['letters']});");
        $controller->addJs("
	teaser.find('.letter').each(function(){
        var tween = TweenMax.from($(this), 0.5, {'x' : Math.ceil(Math.random()*100+100),'y' : Math.ceil(Math.random()*200-100),'autoAlpha':0,'delay':-0.49});
        $timeline.add(tween);
});
");


// create Tweens
        $controller->addJs("
	var baseline = $('#$this->id p:nth-child(3)').splitText({'types':['lines']});");

        $controller->addJs("
	baseline.find('.line').each(function(){
        var tween = TweenMax.from($(this), 0.5, {'x' : Math.ceil(Math.random()*100+100),'autoAlpha' : 0,'delay':-0.3});
        $timeline.add(tween);
});
");

// attach timeline to scene
        $scene->setTween($timeline);

// add indicator
//        $scene->addIndicators();

//add to controller
        $scene->addTo($controller);
    }

    private function registerCss()
    {
        $this->view->registerCssFile('@web/css/SplitText.css');
        $this->view->registerCss("#$this->id {
  position: relative;
  color: #FFFFFF;
  text-shadow: 2px 2px 1px rgba(0, 0, 0, 0.7);
}
#$this->id .kv-editable-value {
  margin-right: 0px;
}
#$this->id .kv-editable,
#$this->id .kv-editable-value {
  display: block;
}
#$this->id h2 {
  font-size: 2em;
  position: absolute;
  top: 50%;
}
#$this->id p:nth-child(2) {
  font-size: 4em;
  font-family: Georgia, serif;
  position: absolute;
  display: table;
  top: 70%;
}
#$this->id p:nth-child(2) span {
  position: relative;
  display: table-cell;
}
#$this->id p:nth-child(3) {
  position: absolute;
  bottom: 5%;
}
@media (max-width: 767px) {
  #$this->id h2 {
    top: 5%;
  }
  #$this->id p:nth-child(2) {
    font-size: 2em;
    top: 40%;
  }
}");
    }

}
