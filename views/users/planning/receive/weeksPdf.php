<?php

use app\extentions\helpers\MyPjax;
use app\models\Training;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\models\User;

/* @var $startDate DateTime */
/* @var $endDate DateTime */
/* @var $models Training[] */
/* @var $model User */
/* @var $isCoach booleen */



$interval = DateInterval::createFromDateString('1 week');
$period = new DatePeriod($startDate, $interval, $endDate);
//var_dump(array_keys($models));

echo Html::beginTag('table',['class'=>'table table-striped']);
foreach ($period as $dateTime) {
    echo $this->render('weeks/weekPdf', [
        'date' => $dateTime,
        'weekId' => $dateTime->format('Y-m-d'),
        'model' => $model,
        'isCoach' => $isCoach,
    ]);
}
echo Html::endTag('table');






