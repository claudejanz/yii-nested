<?php

use app\extentions\helpers\MyPjax;
use app\models\Training;
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
echo $this->render('weeks/navigation', ['startDate' => $startDate, 'model' => $model]);
echo $this->render('weeks/competition', ['startDate' => $startDate,'endDate'=>$endDate, 'model' => $model]);

echo $this->render('weeks/list', [
    'period'  => $period,
    'model'   => $model,
    'isCoach' => $isCoach,
]);

echo $this->render('weeks/navigation', ['startDate' => $startDate, 'model' => $model]);
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
    
     $(document).on("click",".day",function(event){
        
        $(this).find(".collapsable").slideToggle();
    });
    ';
$this->registerJs($js);


