<?php

use app\models\Element;
use app\models\Layout;
use app\widgets\MultiTextWidget;
use app\widgets\RelatedMenuWidget;
use app\widgets\SlideShowWidget;
use app\widgets\SplashWidget;
use app\widgets\TextWidget;
use app\widgets\TitleTextWidget;
use claudejanz\toolbox\widgets\BootstrapPortlet;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Element $model
 */

    switch ($model->type) {
        case Element::TYPE_RELATED_MENU:
            $content = RelatedMenuWidget::widget();
            break;
        case Element::TYPE_TEXT:
            $content = TextWidget::widget(['model' => $model]);
            break;
        case Element::TYPE_SPLASH:
            $content = SplashWidget::widget(['model' => $model]);
            break;
        case Element::TYPE_SLIDESHOW:
            $content = SlideShowWidget::widget(['model' => $model]);
            break;
        case Element::TYPE_MULTITEXT:
            $content = MultiTextWidget::widget(['model' => $model]);
            break;
        case Element::TYPE_TITLETEXT:
            $content = TitleTextWidget::widget(['model' => $model]);
            break;
        default :
            $content = $model->content;
            break;
    }
    if (trim($content) != '') {
        switch ($model->type) {
            case Element::TYPE_RELATED_MENU:
            case Element::TYPE_TEXT:
            case Element::TYPE_MULTITEXT:
                if (Yii::$app->controller->page->layout->path == Layout::PATH_FULL) {
                    echo Html::beginTag('div', ['class' => 'container-fluid']);
                }
                break;
        }
        if ($model->display_title) {
            switch ($model->type) {
                case Element::TYPE_RELATED_MENU:
                case Element::TYPE_SLIDESHOW :
                    BootstrapPortlet::begin(array(
                        'title' => ($model->display_title) ? $model->title : null,
                        'color' => $model->getClassCssText(),
                    ));
                    break;
                case Element::TYPE_SPLASH :
                    break;
                default:
                    echo Html::tag('h2', $model->title);
            }
        }
        echo $content;
//    if (!$model->display_title) {
//        echo $this->render('/all/menu', ['model' => $model]);
//    }


        if ($model->display_title) {
            switch ($model->type) {
                case Element::TYPE_RELATED_MENU:
                case Element::TYPE_SLIDESHOW :
                    BootstrapPortlet::end();
                    break;
            }
        }
        switch ($model->type) {
            case Element::TYPE_RELATED_MENU:
            case Element::TYPE_TEXT:
            case Element::TYPE_MULTITEXT:
                if (Yii::$app->controller->page->layout->path == Layout::PATH_FULL) {
                    
                    echo Html::endTag('div'); //container
                }

                break;
        }
    }
    ?>
