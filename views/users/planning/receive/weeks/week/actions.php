<?php

use app\extentions\StyleIcon;
use app\models\User;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use claudejanz\toolbox\widgets\ajax\AjaxButton;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use yii\helpers\Html;
use yii\helpers\Url;

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

/* @var $model User */
/* @var $startDate DateTime */
/* @var $isCoach boolean */
$options = ['class' => 'white-block'];
if (!Yii::$app->request->isAjax) {
    Html::addCssClass($options, 'animated fadeInUp');
}
echo Html::beginTag('div', $options);
echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-sm-12']);
if ($isCoach && (!$week || $week->published <= app\extentions\behaviors\WeekPublishBehavior::PUBLISHED_CITY_EDIT)) {
    $label = Yii::t('app', 'Send Mail to Fill citys');
    echo AjaxButton::widget([
        'label' => StyleIcon::showStyled('send-o') . ' ' . $label,
        'encodeLabel' => false,
        'url' => [
            'week-fill',
            'id' => $model->id,
            'date_begin' => $startDate->format('Y-m-d'),
        ],
//        'success' => '#week' . $startDate->format('Y-m-d'),
        'options' => [
            'title' => $label,
            'class' => 'red',
        ],
    ]);
}
if (!$isCoach) {
    $label = ($week && $week->published < app\extentions\behaviors\WeekPublishBehavior::PUBLISHED_CITY_EDIT) ? Yii::t('app', 'Re-validate citys') : Yii::t('app', 'Validate citys');
    echo AjaxButton::widget([
        'label' => StyleIcon::showStyled('thumbs-up') . ' ' . $label,
        'encodeLabel' => false,
        'url' => [
            'week-ready',
            'id' => $model->id,
            'begin_date' => $startDate->format('Y-m-d'),
        ],
        'success' => '#week' . $startDate->format('Y-m-d'),
        'options' => [
            'title' => $label,
            'class' => 'red',
        ],
    ]);
}
if ($week) {
    if ($isCoach) {


        $label = Yii::t('app', 'Publish week');
        echo ' ' . AjaxModalButton::widget([
            'label' => StyleIcon::showStyled('send') . ' ' . $label,
            'encodeLabel' => false,
            'url' => [
                'week-publish',
                'id' => $model->id,
                'week_id' => $week->id,
            ],
            'title' => Yii::t('app', 'Send the week to {username}', ['username' => $model->fullname]),
            'success' => '#week' . $startDate->format('Y-m-d'),
            'options' => [
                'title' => $label,
                'class' => 'red',
            ],
        ]);
    }
    if ($isCoach || $week->published >= app\extentions\behaviors\WeekPublishBehavior::PUBLISHED_PLANING_DONE) {
        echo ' ' . Html::a(StyleIcon::showStyled('file-pdf-o') . ' ' . Yii::t('app', 'Week PDF'), Url::to(['planning-pdf', 'id' => $model->id, 'date' => $startDate->format('Y-m-d'), 'ViewStyleForm[viewStyle]' => 'pdf']), ['class' => 'red', 'target' => '_blank', 'data-pjax' => 0]);
    }
}
echo Html::endTag('div'); //col-sm-12
echo Html::endTag('div'); //row
echo Html::endTag('div'); //white-block