<?php

use app\extentions\helpers\MyPjax;
use app\models\Training;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\web\User;

/* @var $date DateTime */
/* @var $models Training[] */
/* @var $model User */
/* @var $isCoach booleen */
/* @var $dateTime DateTime */

$dateId = $dateTime->format("Y-m-d");
MyPjax::begin(['id' => 'day' . $dateId]);
echo Html::beginTag('div', ['class' => 'day white-block', 'data' => ['date' => $dateId]]);
echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-sm-2']);
echo Html::beginTag('div'); //date
echo Yii::$app->formatter->asDate($dateTime, 'full');
echo Html::beginTag('div'); //city and button
if (isset($days[$dateTime->format('Y-m-d')])) {
    $day = $days[$dateTime->format('Y-m-d')];
    $text = $day->training_city;
} else {
    $text = $model->city;
}
echo Html::a($text, 'https://www.google.ch/search?q=meteo+' . $text, ['target' => '_blank']);
echo ' ';
echo AjaxModalButton::widget([
    'label' => Icon::show('pencil'),
    'encodeLabel' => false,
    'url' => ['day-update', 'id' => $model->id, 'date' => $dateId],
    'success' => '#day' . $dateId,
    'title' => Yii::t('app', 'Update training city'),
    'options' => ['class' => 'red']
]);
echo Html::endTag('div'); //city and button
echo Html::endTag('div'); //date
echo Html::endTag('div'); //col-sm-2
echo Html::beginTag('div', ['class' => 'col-sm-10']);
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
MyPjax::end();
