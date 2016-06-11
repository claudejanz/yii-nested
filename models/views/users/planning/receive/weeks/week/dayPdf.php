<?php

use app\models\Day;
use app\models\Training;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use kartik\helpers\Html;
use yii\web\User;

/* @var $date DateTime */
/* @var $models Training[] */
/* @var $model User */
/* @var $isCoach booleen */
/* @var $dateTime DateTime */
/* @var $weekId string */
/* @var $dayId string */
/* @var $day Day */

$today = new DateTime('now');
$options=[];
if($dayId == $today->format('Y-d-m')){
   Html::addCssClass($options, 'currentDay'); 
}
// $options['width']='12%'; 
 $options['valign']='top'; 
echo Html::beginTag('td', $options);

echo Html::beginTag('div');
echo Yii::$app->formatter->asDate($dateTime, 'full');
echo Html::endTag('div');



$options = [];
$today = new DateTime('now');
if($dayId != $today->format('Y-d-m')){
   Html::addCssClass($options, 'collapsed'); 
}
else {
   Html::addCssClass($options, 'currentDay'); 
}

if ($day && isset($day->trainingsWithSport)) {
    $trainings = $day->trainingsWithSport;

    foreach ($trainings as $training) {
        /* @var $training Training */
        if ($isCoach || $training->published == PublishBehavior::PUBLISHED_ACTIF) {
            echo $this->render('day/trainingPdf', [
                'model' => $training,
                'user' => $model,
                'isCoach' => $isCoach,
            ]);
        }
    }
}
echo Html::endTag('td'); //day


