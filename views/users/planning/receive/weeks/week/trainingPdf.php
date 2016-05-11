<?php

use app\extentions\MulaffGraphWidget;
use app\extentions\PdfView;
use app\models\Training;
use app\models\User;
use kartik\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* @var $isCoach booleen */
/* @var $model Training */
/* @var $user User */

echo $model->duration;
echo ' - ';
echo Html::img($model->sport->iconUrl, ['width' => 25, 'class' => 'svg']);
echo ' ' . $model->sport->title;
echo ' - ';
echo $model->title;



//if ($isCoach) {
//    echo Html::beginTag('p', ['class' => 'text-right']);
//    echo Html::a(StyleIcon::showStyled('plus'), "#", ['onClick' => '$("#training' . $model->id . '").find(".trainingToggle").slideToggle();return false;', 'class' => 'red right-align']);
//    echo Html::endTag('p');
//}
$attributes = [
    'explanation:ntext',
];
  
echo PdfView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'class'=>'nonr'
]);
echo MulaffGraphWidget::widget(['width' => '200', 'height' => '100', 'model' => $model, 'attribute' => 'graph', 'withLegends' => true, 'withLines' => true, 'color' => MulaffGraphWidget::COLOR_GRADIENT]);
$attributes = [
    'extra_comment:ntext'
];
if ($isCoach) {
    array_push($attributes, 'rpe');
}
  
echo PdfView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'class'=>'nonr'
]);

