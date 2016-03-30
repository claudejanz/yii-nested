<?php

use app\extentions\helpers\MyPjax;
use app\models\Training;
use app\models\Week;
use kartik\helpers\Html;
use yii\web\User;

/* @var $date DateTime */
/* @var $models Training[] */
/* @var $model User */
/* @var $isCoach booleen */

$startDate = $date;
$endDate = clone $date;
$endDate->modify('+7 days');
$weekId =  $startDate->format('Y-m-d');

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($startDate, $interval, $endDate);

$week = Week::findOne(['date_begin' => $startDate->format('Y-m-d'), 'sportif_id' => $model->id]);
$days = ($week) ? $week->daysByDate : [];
MyPjax::begin(['id' => 'week' .$weekId]);
echo Html::beginTag('div', ['class' => 'week']);
echo Html::beginTag('div', ['class' => 'ribbon-block']);
if ($isCoach) {
    echo $this->render('ribbon', [
        'week' => $week,
    ]);
}
if (isset($week) && isset($week->words_of_the_week)) {
    $options = ['class' => 'words-of-the-week'];
    if (!Yii::$app->request->isAjax) {
        Html::addCssClass($options, 'animated flipInX');
    }
    echo Html::tag('div', $week->words_of_the_week,$options);
}
echo Html::beginTag('div', ['class' => 'dates']);
echo Yii::t('app', '{startDate} to {endDate}', [
    'startDate' => Yii::$app->formatter->asDate($startDate),
    'endDate' => Yii::$app->formatter->asDate($endDate->modify('-1 day')),
]);
echo Html::endTag('div');

foreach ($period as $dateTime) {
    /* @var $dateTime DateTime */
    echo $this->render('day', [
        'dateTime' => $dateTime,
        'weekId' => $weekId,
        'days' => $days,
        'isCoach' => $isCoach,
        'model' => $model,
    ]);
}
echo $this->render('week/reportingResume', ['week' => $week, 'startDate' => $startDate]);
echo $this->render('week/actions', ['week' => $week, 'isCoach' => $isCoach, 'model' => $model, 'startDate' => $startDate]);

echo Html::endTag('div'); //ribbon-block
echo Html::endTag('div'); //week


MyPjax::end();
