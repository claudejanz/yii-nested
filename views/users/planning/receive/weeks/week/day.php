<?php

use app\extentions\helpers\MyPjax;
use app\extentions\StyleIcon;
use app\models\Day;
use app\models\Training;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use claudejanz\toolbox\widgets\ajax\AjaxButton;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\web\User;

/* @var $date DateTime */
/* @var $models Training[] */
/* @var $model User */
/* @var $isCoach booleen */
/* @var $isLight booleen */
/* @var $dateTime DateTime */
/* @var $weekId string */
/* @var $dayId string */
/* @var $day Day */


MyPjax::begin(['id' => 'day' . $dayId]);
$options = ['class' => 'day white-block', 'data' => ['date' => $dayId, 'week' => $weekId]];
if (!Yii::$app->request->isAjax) {
    Html::addCssClass($options, 'animated fadeInUp');
}
$today = new DateTime('now');
if ($dayId == $today->format('Y-d-m')) {
    Html::addCssClass($options, 'currentDay');
}
echo Html::beginTag('div', $options);
echo $this->render('day/day-header', [
    'dateTime' => $dateTime,
    'day'      => $day,
    'model'    => $model,
    'dayId'    => $dayId,
    'weekId'   => $weekId,
    'weekId'   => $weekId,
    'isCoach'  => $isCoach,
    'isLight'  => $isLight,
]);

$options = ['class' => 'row collapsable'];
$today = new DateTime('now');
if ($dayId != $today->format('Y-d-m')) {
    Html::addCssClass($options, 'collapsed');
} else {
    Html::addCssClass($options, 'currentDay');
}

echo Html::beginTag('div', $options);
echo Html::beginTag('div', ['class' => 'col-lg-12']);
echo Html::beginTag('div', ['class' => ($isCoach) ? 'droppable' : '']);
if ($day && isset($day->trainingsWithSport)) {
    $trainings = $day->trainingsWithSport;

    foreach ($trainings as $training) {
        /* @var $training Training */
        if ($isCoach || $training->published == PublishBehavior::PUBLISHED_ACTIF) {
            echo $this->render('day/training', [
                'model'   => $training,
                'user'    => $model,
                'dateTime' => $dateTime,
                'day'      => $day,
                'dayId'    => $dayId,
                'weekId'   => $weekId,
                'weekId'   => $weekId,
                'isCoach'  => $isCoach,
                'isLight'  => $isLight,
            ]);
        }
    }
}
echo Html::endTag('div'); //droppable or empty
echo Html::endTag('div'); //coll-sm-10
echo Html::endTag('div'); //row
echo Html::endTag('div'); //day



$js = '
    $( ".day" ).droppable({
        hoverClass: "hover",
        activeClass: "target",
        accept: ":not(.ui-sortable-helper)",
        drop: function( event, ui ) {
            target = ui.draggable;
            insert = $(this).find(".droppable:first");
            date = $(this).data("date");
            week = $(this).data("week");
            var jqxhr2 = $.ajax({
              method: "GET",
              url: "' . Url::to(['training-create', 'id' => $model->id]) . '",
              data: { date:date , training_type_id: target.find(".training-type:first").data("training-type-id")}
            })
            .done(function( data ) {
               insert.append(data);
               $.pjax.reload("#week"+week,{timeout:false});
            })
            .fail(function( data ) {
            });
        }
    });
    
  ';
$this->registerJs($js);

MyPjax::end();
