<?php

use app\models\Day;
use app\models\User;
use kartik\helpers\Html;

/* 
 * Copyright (C) 2016 Claude
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/* @var $dateTime DateTime */
/* @var $day Day */
/* @var $model User */
/* @var $weekId string */
/* @var $dayId string */
/* @var $isCoach booleen */
/* @var $isLight booleen */

echo Html::beginTag('div', ['class' => 'dayFormat']); //date
echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-xs-8']);
echo Yii::$app->formatter->asDate($dateTime, 'EEEE, d');
echo Html::beginTag('div', ['class' => 'cityFormat']); //city and button
if ($day) {
    $text = $day->training_city;
} else {
    $text = $model->city;
}
echo Html::a($text, 'https://www.google.ch/search?q=meteo+' . $text, ['target' => '_blank']);

if ($day) {
    $labels = $day->attributeLabels();
    if ($day->time_dispo) {
        echo Html::tag('br') . Html::tag('b', $labels['time_dispo']) . ' - ' . $day->time_dispo;
    }
    if ($day->comment) {
        echo Html::tag('br') . Html::tag('b', $labels['comment']) . ' - ' . $day->comment;
    }
}
echo $this->render('day-actions', [
    'dateTime' => $dateTime,
    'day'      => $day,
    'model'    => $model,
    'dayId'    => $dayId,
    'weekId'   => $weekId,
    'isCoach'  => $isCoach,
    'isLight'  => $isLight,
]);

echo Html::endTag('div'); //city and button



echo Html::endTag('div'); //col-sm-12 col-md-9
echo Html::beginTag('div', ['class' => 'col-xs-4 bullet text-right']);
if ($day && $day->duration) {

    echo Html::beginTag('div', ['class' => 'timeDuration']);
    echo $day->duration . "<br>";
    echo Html::endTag('div'); //timeDuration
    echo Html::beginTag('div', ['class' => 'all-sports']);
    foreach ($day->getIcons() as $icon) {
        if ($icon['count'] > 1) {
            echo $icon['count'] . 'x ';
        }
        echo Html::img($icon['url'], ['width' => 25, 'class' => 'svg']);
    }
    echo Html::endTag('div'); //sporticons
}
echo Html::endTag('div'); //col-sm-12 col-md-3 text-center
echo Html::endTag('div'); //row
echo Html::endTag('div'); //date