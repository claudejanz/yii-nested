<?php

namespace app\widgets;

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
 * Description of TextWidget
 *
 * @author Claude
 */
class MultiTextWidget extends Widget
{

    public $model;

    public function run()
    {
        $model = $this->model;
        if ($model) {
            echo Html::beginTag('h2');
            echo $model->title;
            if (Yii::$app->user->can('editor')) {
                 echo Html::a(Icon::show('pencil'), ['elements/update', 'id' => $model->id], ['class' => 'btn btn-sm btn-default']);
           
            }
            echo Html::endTag('h2');
            $texts = $this->model->elementTexts;

            echo Html::beginTag('div', ['class' => 'row']);
            foreach ($texts as $text) {
                echo Html::beginTag('div', ['class' => 'col-sm-6']);
                echo $text->content;
                echo Html::endTag('div');
            }
            echo Html::endTag('div');
        }
    }

}
