<?php

use app\extentions\helpers\EuroDateTime;
use app\extentions\helpers\MyPjax;
use app\extentions\TypeDisplay;
use app\models\Day;
use app\models\Training;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
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


// block pjax
MyPjax::begin(['id' => 'day' . $dayId]);
// options de base
$options = ['class' => 'day white-block', 'data' => ['date' => $dayId, 'week' => $weekId,'isLight'=>$isLight]];
// options annimée si c'est pas de l'ajax
if (!Yii::$app->request->isAjax) {
    Html::addCssClass($options, 'animated fadeInUp');
}
//option aujourd'hui
$today = new EuroDateTime('now');
if ($dayId == $today->format('Y-d-m')) {
    Html::addCssClass($options, 'currentDay');
}
// les options pour le display du statut
if ($day) {
    Html::addCssClass($options, 'day-' . $day->publishedColor);
} else {
    Html::addCssClass($options, 'day-empty');
}
echo Html::beginTag('div', $options);

MyPjax::begin(['id' => 'day-header' . $dayId]);

echo $this->render('day/day-header', [
    'dateTime' => $dateTime,
    'day'      => $day,
    'model'    => $model,
    'dayId'    => $dayId,
    'weekId'   => $weekId,
    'isCoach'  => $isCoach,
    'isLight'  => $isLight,
]);
MyPjax::end();

// default options
$options = ['class' => 'row collapsable'];

// add current day
$today = new EuroDateTime('now');
if ($dayId == $today->format('Y-m-d')) {
    Html::addCssClass($options, 'currentDay');
}

// add collapsed
Html::addCssClass($options, 'collapsed');
Html::addCssStyle($options, 'display: none;');

echo Html::beginTag('div', $options);
echo Html::beginTag('div', ['class' => 'col-lg-12']);
// block pjax
MyPjax::begin(['id' => 'trainings' . $dayId]);
echo Html::beginTag('div', ['class' => ($isCoach) ? 'droppable' : '']);
if ($day && isset($day->trainingsWithSport)) {
    $trainings = $day->trainingsWithSport;

    foreach ($trainings as $training) {
        /* @var $training Training */
        if ($isCoach || $training->published == PublishBehavior::PUBLISHED_ACTIF) {
            echo $this->render('day/training', [
                'training' => $training,
                'model'    => $model,
                'dateTime' => $dateTime,
                'day'      => $day,
                'dayId'    => $dayId,
                'weekId'   => $weekId,
                'isCoach'  => $isCoach,
                'isLight'  => $isLight,
            ]);
        }
    }
}
echo Html::endTag('div'); //droppable or empty
MyPjax::end();
echo Html::endTag('div'); //coll-sm-10
echo Html::endTag('div'); //row
if ($isCoach) {
    echo TypeDisplay::widget([
        'day' => $day,
    ]);
}
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
            isLight = $(this).data("isLight");
            var jqxhr2 = $.ajax({
              method: "GET",
              url: "' . Url::to(['training-add', 'id' => $model->id]) . '",
              data: { date:date ,isLight: isLight, training_type_id: target.find(".training-type:first").data("training-type-id")}
            })
            .done(function( data ) {
               insert.append(data);
               $.pjax.reload("#day-header"+date,{timeout:false});
            })
            .fail(function( data ) {
            });
        }
    });
    
  ';
$this->registerJs($js);
MyPjax::end();
