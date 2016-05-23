<?php

use app\extentions\helpers\MyPjax;
use app\extentions\MulaffGraphWidget;
use app\extentions\MulaffGraphWidgetV2;
use app\extentions\MyDetailView;
use app\extentions\WebUser;
use app\models\Day;
use app\models\Training;
use app\models\User;
use kartik\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* @var $isCoach booleen */
/* @var $isLight booleen */
/* @var $training Training */
/* @var $model User */
/* @var $dateTime DateTime */
/* @var $day Day */
/* @var $weekId string */
/* @var $dayId string */
MyPjax::begin(['id' => 'training' . $training->id]);

$options = ['class' => 'eachTraining'];


echo Html::beginTag('div', $options);

// training header
echo $this->render('training/training-header', [
    'day'      => $day,
    'training' => $training,
    'model'    => $model,
    'dayId'    => $dayId,
    'weekId'   => $weekId,
    'weekId'   => $weekId,
    'isCoach'  => $isCoach,
    'isLight'  => $isLight,
]);


echo Html::beginTag('div', ['class' => 'row plus']);

// explications
if (!$isLight) {
    echo Html::beginTag('div', ['class' => 'col-sm-12']);
    $attributes = [
        'explanation:ntext',
    ];
    echo MyDetailView::widget([
        'model'      => $training,
        'attributes' => $attributes,
    ]);
    echo Html::endTag('div'); // col-sm-12
}
// graph
echo Html::beginTag('div', ['class' => 'col-sm-12 graphWrapper']);
echo MulaffGraphWidgetV2::widget(['width' => '100%', 'height' => (!$isLight) ? 100 : 65, 'model' => $training, 'attribute' => 'graph', 'withLegends' => true, 'withLines' => true, 'color' => MulaffGraphWidget::COLOR_GRADIENT]);
echo Html::endTag('div');

// comment and rpe
if (!$isLight) {
    echo Html::beginTag('div', ['class' => 'col-sm-12']);
    $attributes = [
        'extra_comment:ntext'
    ];
    if ($isCoach) {
        array_push($attributes, 'rpe');
    }
    echo MyDetailView::widget([
        'model'      => $training,
        'attributes' => $attributes,
    ]);
    echo Html::endTag('div'); // col-sm-12
}
echo Html::endTag('div'); // dayToggle

echo Html::endTag('div'); //sporticons


echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-sm-12']);
echo $this->render('training/reporting', ['training' => $training, 'model' => $model]);
echo Html::endTag('div');
echo Html::endTag('div');
MyPjax::end();
