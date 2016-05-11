<?php

use app\models\Week;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use kartik\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* @var $model Week | null */
/* @var $dateTime DateTime */
$color = 'info';
$label = Yii::t('app', 'Not set');
if (isset($model)) {
    $color = $model->getPublishedColor();
    $label = $model->getPublishedLabel();
}
$label .= ': '.Yii::$app->formatter->asDate($dateTime);
$linkText = Yii::t('app', 'W{n}', ['n' => $dateTime->format('W')]);
echo Html::a($linkText, ['users/planning', 'id' => $id, 'date' => $dateTime->format('Y-m-d')], [
    'data' => ['pjax' => 0],
    'class' => 'btn btn-' . $color.' btn-xs',
    'title' => $label,
]);
