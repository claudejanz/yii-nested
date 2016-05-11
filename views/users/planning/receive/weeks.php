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


MyPjax::begin(['id' => 'weeks']);
//echo $this->render('weeks/view-style');
echo $this->render('weeks/navigation', ['startDate' => $startDate]);

switch (Yii::$app->user->planningStyle) {

    case 'middle':
        echo $this->render('weeks/grid', [
            'period' => $period,
            'model' => $model,
            'isCoach' => $isCoach,
        ]);
        break;
    case 'short':
    default :
        echo $this->render('weeks/list', [
            'period' => $period,
            'model' => $model,
            'isCoach' => $isCoach,
        ]);
        break;
}
echo $this->render('weeks/navigation', ['startDate' => $startDate]);
MyPjax::end();
$js = 'var a=document.getElementsByTagName("a");
for(var i=0;i<a.length;i++) {
    if(!a[i].onclick && a[i].getAttribute("target") != "_blank") {
        a[i].onclick=function() {
                window.location=this.getAttribute("href");
                return false; 
        }
    }
}';

$this->registerJs($js);
// script to collapse days
$js = '
    $("body").on("click",".day",function(){
        $(this).find(".collapsable").slideToggle();
    });
    ';
$this->registerJs($js);


