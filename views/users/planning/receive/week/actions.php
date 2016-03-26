<?php

use app\models\User;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use claudejanz\toolbox\widgets\ajax\AjaxButton;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\icons\Icon;
use yii\helpers\Html;

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
if ($week) {
    echo Html::beginTag('div', ['class' => 'white-block animated fadeInUp']);
    echo Html::beginTag('div', ['class' => 'row']);
    echo Html::beginTag('div', ['class' => 'col-sm-12']);
    if ($isCoach) {
        echo AjaxModalButton::widget([
            'label' => Icon::show('thumbs-up') . ' ' . Yii::t('app', 'Publish'),
            'encodeLabel' => false,
            'url' => [
                'week-publish',
                'id' => $model->id,
                'week_id' => $week->id,
            ],
            'title' => Yii::t('app', 'Send the week to {username}', ['username' => $model->fullname]),
            'success' => '#week' . $startDate->format('Y-m-d'),
            'options' => [
                'title' => Yii::t('app', 'Publish'),
                'class' => 'red',
            ],
        ]);
    } else {
        $label = ($week->published!=PublishBehavior::PUBLISHED_DRAFT)?Yii::t('app', 'Re-validate week'):Yii::t('app', 'Validate week');
        echo AjaxButton::widget([
            'label' => Icon::show('thumbs-up') . ' ' . $label,
            'encodeLabel' => false,
            'url' => [
                'week-ready',
                'id' => $model->id,
                'week_id' => $week->id,
            ],
            'success' => '#week' . $startDate->format('Y-m-d'),
            'options' => [
                'title' => $label,
                'class' => 'red',
            ],
        ]);
    }
    echo Html::endTag('div'); //col-sm-12
    echo Html::endTag('div'); //row
    echo Html::endTag('div'); //white-block
}