<?php

use app\extentions\helpers\MyPjax;
use app\models\Training;
use app\models\Week;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\web\User;

/* @var $date DateTime */
/* @var $models Training[] */
/* @var $model User */
/* @var $isCoach booleen */

$startDate = $date;
$endDate = clone $date;
$endDate->modify('+7 days');

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($startDate, $interval, $endDate);

$week = Week::findOne(['date_begin' => $startDate->format('Y-m-d'), 'sportif_id' => $model->id]);
$days = ($week) ? $week->daysByDate : [];
MyPjax::begin(['id' => 'week' . $startDate->format('Y-m-d')]);
echo Html::beginTag('div', ['class' => 'week']);
echo Html::beginTag('div', ['class' => 'ribbon-block']);
if ($isCoach) {
    echo $this->render('ribbon', [
        'week' => $week,
    ]);
}
if (isset($week) && isset($week->words_of_the_week))
    echo Html::tag('div', $week->words_of_the_week, ['class' => 'words-of-the-week animated flipInX']);
echo Html::beginTag('div', ['class' => 'title']);
echo Yii::t('app', '{startDate} to {endDate}', [
    'startDate' => Yii::$app->formatter->asDate($startDate),
    'endDate' => Yii::$app->formatter->asDate($endDate->modify('-1 day')),
]);
echo Html::endTag('div');

foreach ($period as $dateTime) {
    /* @var $dateTime DateTime */
    echo $this->render('day', [
        'dateTime' => $dateTime,
        'days' => $days,
        'isCoach' => $isCoach,
        'model' => $model,
        'models' => $models,
    ]);
}
if ($isCoach) {
    echo Html::beginTag('div', ['class' => 'white-block animated fadeInUp']);
    echo Html::beginTag('div', ['class' => 'row']);
    echo Html::beginTag('div', ['class' => 'col-sm-12']);
    echo AjaxModalButton::widget([
        'label' => Icon::show('thumbs-up') . ' ' . Yii::t('app', 'Publish'),
        'encodeLabel' => false,
        'url' => [
            'week-publish',
            'id' => $model->id,
            'date_begin' => $startDate->format('Y-m-d')
        ],
        'title' => Yii::t('app', 'Send the week to {username}', ['username' => $model->fullname]),
        'success' => '#weeks',
        'options' => [
            'title' => Yii::t('app', 'Publish'),
            'class' => 'red',
        ],
    ]);

    echo Html::endTag('div'); //col-sm-12
    echo Html::endTag('div'); //row
    echo Html::endTag('div'); //white-block
}
echo $this->render('reportingResume', ['week' => $week, 'startDate' => $startDate]);
echo Html::endTag('div'); //ribbon-block
echo Html::endTag('div'); //week


MyPjax::end();
