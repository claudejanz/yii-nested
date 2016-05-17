<?php
use kartik\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* @var $model Day | null */
$color = 'info';
$label = Yii::t('app', 'Not set');
if (isset($model)) {
    $color = $model->getPublishedColor();
    $label = $model->getPublishedLabel();
}
$label .= ': '.Yii::$app->formatter->asDate($date);
$linkText =  Yii::$app->formatter->asDate($date,'d');
echo Html::a($linkText, ['users/planning', 'id' => $id, 'date' => $date], [
    'data' => ['pjax' => 0],
    'class' => 'btn btn-' . $color.' btn-xs',
    'title' => $label,
]);