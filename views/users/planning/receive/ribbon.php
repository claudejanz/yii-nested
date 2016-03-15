<?php

use app\models\Week;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use yii\helpers\Html;


/* @var $week Week */

$color = 'danger';
$label = Yii::t('app', 'Draft');
if ($week) {
    
    switch ($week->published) {
        case PublishBehavior::PUBLISHED_ACTIF:
            $color = 'primary';
            $label = Yii::t('app', 'Sended');
            break;
        default:
            break;
    }
}

echo Html::beginTag('div', ['class' => 'ribbon']);
echo Html::beginTag('span', ['class' => $color]);
echo $label;
echo Html::endTag('span');
echo Html::endTag('div'); //ribbon