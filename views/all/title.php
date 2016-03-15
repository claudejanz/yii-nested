<?php

use app\extentions\MyEditable;
use kartik\editable\Editable;
use kartik\icons\Icon;
use kartik\popover\PopoverX;
use yii\helpers\Html;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$model = Yii::$app->controller->page;
if (Yii::$app->user->can('update') && !$model->isNewRecord) {
    echo Html::beginTag('h1');
    $editable = MyEditable::begin([
                'model' => $model,
                'attribute' => 'title',
                'asPopover' => true,
                'formOptions' => ['action' => ['ajax/update', 'id' => $model->id]],
                'format' => Editable::FORMAT_BUTTON,
                'header' => Yii::t('app','Page'),
//                'preHeader' => false,
                'inputType' => Editable::INPUT_HTML5_INPUT,
                'placement' => PopoverX::ALIGN_BOTTOM,
//                'size' => PopoverX::SIZE_MEDIUM,
        'renderLabel'=>null,
    ]);
    $form = $editable->getForm();

    $editable->afterInput = $form->field($model, 'breadcrumb_text')->textInput(['placeholder' => 'Enter menu title...'])
            .$form->field($model, 'meta_description')->textInput(['placeholder' => 'Enter zip code...'])
            . $form->field($model, 'meta_keywords')->textInput(['placeholder' => 'Enter zip code...']);
    MyEditable::end();

    if (Yii::$app->user->can('publisher') && Yii::$app->controller->id == 'projects' && Yii::$app->controller->action->id == 'index') {
        echo Html::a(Icon::show('transfer'), ['order'], ['class' => 'btn btn-sm btn-default']);
        echo ' ';
        echo Html::a(Icon::show('plus'), ['create'], ['class' => 'btn btn-sm btn-default']);
    }
    echo Html::endTag('h1');
} elseif (Yii::$app->user->can('publisher') && Yii::$app->controller->id == 'projects' && Yii::$app->controller->action->id == 'view') {
    echo Html::beginTag('h1');
    $model = Yii::$app->controller->model;
    echo $model->title;
    echo ' ';
    echo Html::a(Icon::show('pencil'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-default']);
    echo ' ';
    echo Html::a(Icon::show('transfer'), ['order-image', 'id' => $model->id], ['class' => 'btn btn-sm btn-default']);
    echo ' ';
    echo Html::a(Icon::show('remove'), ['delete', 'id' => $model->id], ['class' => 'btn btn-sm btn-default', 'data' => ['method' => 'post', 'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]]);
    echo ' ';
    echo Html::button(Icon::show('pencil'), ['value' => Url::to(['pages/create']), 'title' => 'Creating New Page', 'class' => 'showModal btn btn-sm btn-success']); 
    echo Html::endTag('h1');
} elseif (!Yii::$app->user->isGuest) {
    echo Html::beginTag('h1');
    echo $model->title;
    echo Html::endTag('h1');
}

