<?php

namespace app\widgets;

use kartik\editable\Editable;
use kartik\helpers\Html;
use kartik\icons\Icon;
use kartik\popover\PopoverX;
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
class AddressWidget extends Widget
{

    public $model;
    public $editable = true;

    public function run()
    {
        $model = $this->model;
        $editable = $this->editable;
        if ($model) {
            echo Html::beginTag('address', ['id' => $this->id]);

            if (Yii::$app->user->can('editor') && $editable) {
                $field = Editable::begin([
                            'model' => $model,
                            'attribute' => 'title',
                            'options' => [
                                'id' => $this->id . '-title',
                            ],
                            'asPopover' => true,
                            'formOptions' => ['action' => ['ajax/update', 'id' => $model->id]],
                            'format' => Editable::FORMAT_BUTTON,
                            'header' => false,
                            'preHeader' => false,
                            'inputType' => Editable::INPUT_TEXT,
                            'placement' => PopoverX::ALIGN_BOTTOM,
                            'size' => PopoverX::SIZE_LARGE,
                ]);
                $form = $field->getForm();

                $field->beforeInput = '';
                $field->afterInput = $form->field($model, 'lng')->textInput(['placeholder' => Yii::t('app', 'Enter longitude...')])
                        . $form->field($model, 'lat')->textInput(['placeholder' => Yii::t('app', 'Enter latitude...')]);
                Editable::end();
            } else {
                echo $model->title;
            }
            echo Html::tag('br');
            if (Yii::$app->user->can('editor') && $editable) {
                Editable::begin([
                    'model' => $model,
                    'attribute' => 'street',
                    'options' => [
                        'id' => $this->id . '-street',
                    ],
                    'asPopover' => true,
                    'formOptions' => ['action' => ['ajax/update', 'id' => $model->id]],
                    'format' => Editable::FORMAT_BUTTON,
                    'header' => false,
                    'preHeader' => false,
                    'inputType' => Editable::INPUT_TEXT,
                    'placement' => PopoverX::ALIGN_BOTTOM,
                    'size' => PopoverX::SIZE_LARGE,
                ]);
                Editable::end();
            } else {
                echo $model->street;
            }
            echo Html::tag('br');
            if (Yii::$app->user->can('editor') && $editable) {
                Editable::begin([
                    'model' => $model,
                    'attribute' => 'city',
                    'options' => [
                        'id' => $this->id . '-city',
                    ],
                    'asPopover' => true,
                    'formOptions' => ['action' => ['ajax/update', 'id' => $model->id]],
                    'format' => Editable::FORMAT_BUTTON,
                    'header' => false,
                    'preHeader' => false,
                    'inputType' => Editable::INPUT_TEXT,
                    'placement' => PopoverX::ALIGN_BOTTOM,
                    'size' => PopoverX::SIZE_LARGE,
                ]);
                Editable::end();
            } else {
                echo $model->city;
            }
            echo Html::tag('br');
            echo Html::endTag('address'); //container
        }
    }

}
