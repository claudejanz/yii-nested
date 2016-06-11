<?php

use app\models\search\TrainingTypeSearch;
use app\models\Training;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\View;

/* @var $this View */
/* @var $model User */
/* @var $startDate DateTime */
/* @var $endDate DateTime */
/* @var $models Training[] */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel TrainingTypeSearch */
/* @var $isCoach booleen */


echo $this->render('planning/receive/weeksPdf', [
    'startDate' => $startDate,
    'endDate' => $endDate,
    'model' => $model,
    'isCoach' => $isCoach,
]);
