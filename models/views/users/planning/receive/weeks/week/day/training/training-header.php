<?php

use app\extentions\StyleIcon;
use app\models\Day;
use app\models\Training;
use claudejanz\toolbox\widgets\ajax\AjaxButton;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use yii\helpers\Html;
use yii\web\User;

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
/* @var $day Day */
/* @var $training Training */
/* @var $model User */
/* @var $weekId string */
/* @var $dayId string */
/* @var $isCoach booleen */

echo Html::beginTag('div', ['class' => 'row trainingDesc']);

//
if ($isCoach && !$isLight) {

    echo Html::beginTag('div', ['class' => 'col-xs-3']);


    echo Html::beginTag('div', ['class' => 'timeDuration']);
    echo $training->duration;
    echo Html::endTag('div'); //timeDuration

    echo Html::beginTag('div', ['class' => 'sports']);
// @mytodo adapter le code pourprendre en compte les couleurs de poilces
    $img_options = ['width' => 25, 'class' => 'sport-icon'];
    if ($training->reporting) {
        if ($training->reporting->done) {
            Html::addCssClass($img_options, 'done');
        } else {
            Html::addCssClass($img_options, 'not-done');
        }
    }
    echo Html::img($training->sport->iconUrl, $img_options);
    echo Html::endTag('div'); //sports

    echo Html::endTag('div'); //end col-xs-3
}

echo Html::beginTag('div', ['class' => ($isCoach && !$isLight) ? 'col-xs-6' : 'col-xs-12']); //start title and time col
echo Html::beginTag('div', ['class' => 'title']);
echo ' ' . $training->sport->title;
echo ' - ';
echo $training->title;
echo Html::endTag('div'); //sporticons
echo Html::endTag('div'); //end col-xs-6 col-xs-12
// actions


if ($isCoach && !$isLight) {
    echo Html::beginTag('div', ['class' => 'col-sm-3']);
    echo Html::beginTag('p', ['class' => 'text-right']);

// coach can edit training
    echo AjaxModalButton::widget([
        'label'       => StyleIcon::showStyled('edit'),
        'encodeLabel' => false,
        'url'         => [
            'training-update',
            'id'          => $model->id,
            'training_id' => $training->id
        ],
        'title'       => Yii::t('app', 'Edit training: {title}', ['title' => $training->title]),
//        'success'     => '#training' . $training->id,
        'options'     => [
            'class' => 'red',
        ],
    ]);

    echo ' ';
    echo AjaxModalButton::widget([
        'label'       => StyleIcon::showStyled('clone'),
        'encodeLabel' => false,
        'url'         => [
            'training-duplicate',
            'id'          => $model->id,
            'training_id' => $training->id
        ],
        'title'       => Yii::t('app', 'Duplicate training: {title}', ['title' => $training->title]),
//        'success'     => '#training' . $training->id,
        'options'     => [
            'class' => 'red',
        ],
    ]);

    echo ' ';


    echo AjaxButton::widget([
        'label'       => StyleIcon::showStyled('remove'),
        'encodeLabel' => false,
        'url'         => [
            'training-delete',
            'id'          => $model->id,
            'training_id' => $training->id
        ],
        'success'     => '#day' . $dayId,
            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
        'ajaxOptions' => [
            'type'=>'post'
        ],
        'options'     => [
            'title'        => Yii::t('yii', 'Delete'),
            'class'        => 'red',
        ],
    ]);


    echo Html::endTag('p');
    echo Html::endTag('div');
}


echo Html::endTag('div'); // row trainingDesc
