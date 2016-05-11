<?php

use app\models\Week;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use yii\helpers\Html;

/* @var $week Week */

$color = 'info';
$label = Yii::t('app', 'Nothing done');
if ($week) {
    $color = $week->getPublishedColor();
    $label = $week->getPublishedLabel();
}

echo Html::beginTag('div', ['class' => 'ribbon']);
echo Html::beginTag('span', ['class' => $color]);
echo $label;
echo Html::endTag('span');
echo Html::endTag('div'); //ribbon