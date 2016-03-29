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
/* @var $weekStartDate DateTime */

$dateId = $dateTime->format("Y-m-d");
MyPjax::begin(['id' => 'day' . $dateId]);
echo Html::beginTag('div', ['class' => 'day white-block animated fadeInUp', 'data' => ['date' => $dateId]]);
echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-sm-2 col-md-12']);
echo Html::beginTag('div', ['class' => 'dayFormat']); //date
echo Yii::$app->formatter->asDate($dateTime, 'full');
echo Html::beginTag('div', ['class' => 'cityFormat']); //city and button
if (isset($days[$dateTime->format('Y-m-d')])) {
    $day = $days[$dateTime->format('Y-m-d')];
    $text = $day->training_city;
} else {
    $text = $model->city;
}
echo Html::a($text, 'https://www.google.ch/search?q=meteo+' . $text, ['target' => '_blank']);
echo ' ';
echo AjaxModalButton::widget([
    'label' => StyleIcon::showStyled('edit'),
    'encodeLabel' => false,
    'url' => ['day-update', 'id' => $model->id, 'date' => $dateId],
    'success' => '#week' . $weekStartDate->format('Y-m-d'),
    'title' => Yii::t('app', 'Update training city'),
    'options' => ['class' => 'red']
]);
echo Html::endTag('div'); //city and button
echo Html::endTag('div'); //date
echo Html::endTag('div'); //col-sm-2
echo Html::beginTag('div', ['class' => 'col-sm-10 col-md-12']);
echo Html::beginTag('div', ['class' => ($isCoach) ? 'droppable' : '']);
if (isset($models[$dateTime->format('Y-m-d')])) {
    $trainings = $models[$dateTime->format('Y-m-d')];

    foreach ($trainings as $training) {
        /* @var $training Training */
        if ($isCoach || $training->published == PublishBehavior::PUBLISHED_ACTIF){
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
