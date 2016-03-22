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


$linkDate = clone $startDate;
$interval = DateInterval::createFromDateString('1 week');
$period = new DatePeriod($startDate, $interval, $endDate);
//var_dump(array_keys($models));
$linkDate->modify('-7 days');
MyPjax::begin(['id' => 'weeks']);
echo $this->render('navigation',['startDate'=>$startDate,'linkDate'=>$linkDate]);
echo Html::beginTag('div', ['class' => 'row']);
foreach ($period as $dateTime) {
    echo Html::beginTag('div', ['class' => ($isCoach) ? 'col-lg-6' : 'col-lg-12']);
    echo $this->render('week', [
        'date' => $dateTime,
        'models' => $models,
        'model' => $model,
        'isCoach' => $isCoach,
    ]);
    echo Html::endTag('div');
}
echo Html::endTag('div');
$linkDate = clone $startDate;
$linkDate->modify('+7 days');
echo $this->render('navigation',['startDate'=>$startDate,'linkDate'=>$linkDate]);

$js = '$(function() {
    $( ".day" ).droppable({
        hoverClass: "hover",
        activeClass: "target",
        accept: ":not(.ui-sortable-helper)",
        drop: function( event, ui ) {
            target = ui.draggable;
            insert = $(this).find(".droppable:first");
            var jqxhr2 = $.ajax({
              method: "GET",
              url: "' . Url::to(['training-create', 'id' => $model->id]) . '",
              data: { date:$(this).data("date") , training_type_id: target.find(".training-type:first").data("training-type-id")}
            })
            .done(function( data ) {
               insert.append(data);
            })
            .fail(function( data ) {
            });
        }
    });
    
  });';
$this->registerJs($js);
MyPjax::end();

