<?php

use app\models\Week;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use yii\helpers\Html;


/* @var $week Week */

$color = 'info';
$label = Yii::t('app', 'Nothing done');
if ($week) {
    
    switch ($week->published) {
        case PublishBehavior::PUBLISHED_ACTIF:
            $color = 'success';
            $label = Yii::t('app', 'Sended');
            break;
        case PublishBehavior::PUBLISHED_VALIDATED:
            $color = 'warning';
            $label = Yii::t('app', 'City Registered');
            break;
        case PublishBehavior::PUBLISHED_DRAFT:
            $color = 'danger';
            $label = Yii::t('app', 'Draft');
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