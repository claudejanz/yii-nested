<?php

use app\extentions\helpers\MyPjax;
use app\extentions\StyleIcon;
use app\models\Training;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\web\User;

/* @var $date DateTime */
/* @var $models Training[] */
/* @var $model User */
/* @var $isCoach booleen */
/* @var $dateTime DateTime */
/* @var $weekId string */
/* @var $dayId string */
/* @var $day Day */

MyPjax::begin(['id' => 'day' . $dayId]);
$options = ['class' => 'day white-block', 'data' => ['date' => $dayId, 'week' => $weekId]];
if (!Yii::$app->request->isAjax) {
    Html::addCssClass($options, 'animated fadeInUp');
}
echo Html::beginTag('div', $options);
echo Html::beginTag('div', ['class' => 'dayFormat']); //date
echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-sm-12 col-md-9']);
echo Yii::$app->formatter->asDate($dateTime, 'full');
echo Html::beginTag('div', ['class' => 'cityFormat']); //city and button
if ($day) {
    $text = $day->training_city;
} else {
    $text = $model->city;
}
echo Html::a($text, 'https://www.google.ch/search?q=meteo+' . $text, ['target' => '_blank']);
echo ' ';
echo AjaxModalButton::widget([
    'label' => StyleIcon::showStyled('edit'),
    'encodeLabel' => false,
    'url' => ['day-update', 'id' => $model->id, 'date' => $dayId],
    'success' => '#week' . $weekId,
    'title' => Yii::t('app', 'Update training city'),
    'options' => ['class' => 'red']
]);
echo Html::endTag('div'); //city and button

echo Html::endTag('div'); //col-sm-12 col-md-9
echo Html::beginTag('div', ['class' => 'col-sm-12 col-md-3 bullet']);
if ($day && $day->duration) {

    echo Html::beginTag('div', ['class' => 'timeDuration']);
    echo $day->duration . "<br>";
    echo Html::endTag('div'); //timeDuration
    echo Html::beginTag('div', ['class' => 'all-sports']);
    foreach ($day->getIcons() as $icon) {
        echo Html::img($icon, ['width' => 25, 'class' => 'svg']);
    }
    echo Html::endTag('div'); //sporticons
}
echo Html::endTag('div'); //col-sm-12 col-md-3 text-center
echo Html::endTag('div'); //row
echo Html::endTag('div'); //date



echo Html::beginTag('div', ['class' => 'row colapsable']);
echo Html::beginTag('div', ['class' => 'col-lg-12']);
echo Html::beginTag('div', ['class' => ($isCoach) ? 'droppable' : '']);
if ($day && isset($day->trainingsWithSport)) {
    $trainings = $day->trainingsWithSport;

    foreach ($trainings as $training) {
        /* @var $training Training */
        if ($isCoach || $training->published == PublishBehavior::PUBLISHED_ACTIF) {
            echo $this->render('training', [
                'model' => $training,
                'user' => $model,
                'isCoach' => $isCoach,
            ]);
        }
    }
}
echo Html::endTag('div'); //droppable or empty
echo Html::endTag('div'); //coll-sm-10
echo Html::endTag('div'); //row
echo Html::endTag('div'); //day

$js = '$(function() {
    $(".day").on("click",function(){
        $(this).find(".colapsable").slideToggle();
    });
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
    
  });';
$this->registerJs($js);

MyPjax::end();
