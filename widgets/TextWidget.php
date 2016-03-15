<?php

namespace app\widgets;

use kartik\editable\Editable;
use kartik\popover\PopoverX;
use Yii;
use yii\base\Widget;
use yii\redactor\widgets\Redactor;

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
class TextWidget extends Widget {

   
    public $model;

    public function run() {
        $model = $this->model->elementText;
        if ($model) {
           
            if (Yii::$app->user->can('update')) {
                echo Editable::widget([
                    'model' => $model,
                    'attribute' => 'content',
                    'options'=>['id'=>$this->id.'-content','options' =>['id'=>$this->id.'-editor'] ],
                    'asPopover' => false,
                    'inlineSettings' => [
                        'templateBefore' => Editable::INLINE_BEFORE_2,
                        'templateAfter' => Editable::INLINE_AFTER_2
                    ],
                    'formOptions'=>['action'=>['ajax/update','id'=>$model->id]],
                    'format' => Editable::FORMAT_BUTTON,
                    'header' => Yii::t('app', 'Modify Text'),
                    'preHeader' => false,
                    'inputType' => Editable::INPUT_WIDGET,
                    'widgetClass' => Redactor::className(),
                    'size'=>PopoverX::SIZE_LARGE,
                ]);
            } else {
                echo $this->model->elementText->content;
            }
           
        }
    }

}
