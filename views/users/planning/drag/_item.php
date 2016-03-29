<?php

use app\extentions\MulaffGraphWidgetV2;
use app\models\TrainingType;
use kartik\helpers\Html;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* @var $model TrainingType */
echo Html::beginTag('div',['class'=>'rounded training-type','data'=>['training-type-id'=>$model->id]]);
echo Html::beginTag('div',['class'=>'row']);
echo Html::beginTag('div',['class'=>'col-sm-8']);
echo Html::tag('b',$model->duration);
echo ' - ';
echo Html::tag('span',$model->sport->icon,['class'=>'sports']);
if (!isset($searchModel->sport_id)) {
    echo ' ' . $model->sport->title;
}
echo ' - ';
echo Html::tag('span',$model->getShortTitle());
echo Html::endTag('div');
echo Html::beginTag('div',['class'=>'col-sm-4']);
echo MulaffGraphWidgetV2::widget(['width'=>'100%','height'=>30,'model'=>$model,'attribute'=>'graph']);
echo Html::endTag('div');
echo Html::endTag('div');
echo Html::endTag('div');