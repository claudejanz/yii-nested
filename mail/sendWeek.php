<?php

use app\models\Day;
use app\models\User;
use app\models\Week;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $user User */
/* @var $model Week */

echo Html::tag('h1',  Yii::t('mail', 'Hi {name},',['name'=>$user->firstname]));
if (isset($model) && !empty($model->words_of_the_week)) {
    echo Html::tag('p', Yii::t('mail', 'Your objectif: {word_of_the_week}',['word_of_the_week'=>$model->words_of_the_week]));
}

$days = $model->getNewPublishedDay();
if (!empty($days)) {
    echo Html::tag('p', Yii::t('mail', 'Your new planning for the following days:'));
    echo Html::beginTag('ul');
    foreach ($days as $day) {
        /* @var $day Day */
        echo Html::beginTag('li');
        echo Yii::$app->formatter->asDate($day->date);
        echo Html::endTag('li');
    }
    echo Html::endTag('ul');
}
echo Html::tag('p',  Yii::t('mail', 'Click on the following link to see your planning:'));
$planningLink = Yii::$app->urlManager->createAbsoluteUrl(['users/planning','id'=>$user->id,'date'=>$model->date_begin]);
echo Html::a(Yii::t('mail', 'See planning'), $planningLink) 
        
        ?>

