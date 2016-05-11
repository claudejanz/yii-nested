<?php

use app\extentions\helpers\MyPjax;
use app\extentions\StyleIcon;
use app\models\Training;
use app\models\Week;
use kartik\helpers\Html;
use yii\web\User;

/* @var $date DateTime */
/* @var $models Training[] */
/* @var $model User */
/* @var $isCoach booleen */
/* @var $weekId string */

$startDate = $date;
$endDate = clone $date;
$endDate->modify('+7 days');
$weekId = $startDate->format('Y-m-d');

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($startDate, $interval, $endDate);

$week = Week::findOne(['date_begin' => $weekId, 'sportif_id' => $model->id]);
$days = ($week) ? $week->daysByDate : [];



//echo Html::beginTag('td');
//
//
//
//// word of the week
//if (isset($week) && isset($week->words_of_the_week)) {
//    $options = ['class' => 'words-of-the-week'];
//    if (!Yii::$app->request->isAjax) {
//        Html::addCssClass($options, 'animated flipInX');
//    }
//    echo Html::tag('div', $week->words_of_the_week, $options);
//}
//
//
//// dates 
//echo Html::beginTag('div', ['class' => 'dates animated flipInX']);
//echo Yii::t('app', '{startDate} to {endDate}', [
//    'startDate' => Yii::$app->formatter->asDate($startDate, 'd MMM'),
//    'endDate' => Yii::$app->formatter->asDate($endDate->modify('-1 day'), 'd MMM \'\'yy'),
//]);
//
//
//echo Html::endTag('td');
// trainins
    echo Html::beginTag('tr');
foreach ($period as $dateTime) {
    /* @var $dateTime DateTime */
    $dayId = $dateTime->format('Y-m-d');
    echo $this->render('week/dayPdf', [
        'dateTime' => $dateTime,
        'weekId' => $weekId,
        'dayId' => $dayId,
        'day' => isset($days[$dayId]) ? $days[$dayId] : null,
        'isCoach' => $isCoach,
        'model' => $model,
    ]);
}
    echo Html::endTag('tr');




