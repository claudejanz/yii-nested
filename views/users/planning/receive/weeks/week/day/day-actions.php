<?php

use app\extentions\StyleIcon;
use app\models\Day;
use app\models\User;
use claudejanz\toolbox\widgets\ajax\AjaxButton;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;

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
$buttons;
if (!$isLight) {
    if (!$day) {
        $buttons[] = AjaxButton::widget([
                    'label'       => StyleIcon::showStyled('check'),
                    'encodeLabel' => false,
                    'url'         => ['day-validate-city', 'id' => $model->id, 'date' => $dayId],
                    'success'     => '#day' . $dayId,
                    'options'     => [
                        'title' => Yii::t('app', 'Update training city'),
                        'class' => 'red mulaffBtn'
                    ]
        ]);
        $buttons[] = AjaxModalButton::widget([
                    'label'       => StyleIcon::showStyled('edit'),
                    'encodeLabel' => false,
                    'url'         => ['day-update', 'id' => $model->id, 'date' => $dayId],
                    'success'     => '#day' . $dayId,
                    'title'       => Yii::t('app', 'Update training city'),
                    'options'     => ['class' => 'red mulaffBtn']
        ]);
    } else {
        $buttons[] = AjaxModalButton::widget([
                    'label'       => StyleIcon::showStyled('edit'),
                    'encodeLabel' => false,
                    'url'         => ['day-update', 'id' => $model->id, 'date' => $dayId],
                    'success'     => '#day' . $dayId,
                    'title'       => Yii::t('app', 'Update training city'),
                    'options'     => ['class' => 'red mulaffBtn']
        ]);
        $buttons[] = AjaxModalButton::widget([
                    'label'       => StyleIcon::showStyled('plus'),
                    'encodeLabel' => false,
                    'url'         => ['training-create', 'id' => $model->id, 'date' => $dayId],
                    'success'     => '#day' . $dayId,
                    'title'       => Yii::t('app', 'Add training'),
                    'options'     => ['class' => 'red mulaffBtn']
        ]);
        if ($day->trainings && $isCoach) {
            $buttons[] = AjaxModalButton::widget([
                        'label'       => StyleIcon::showStyled('clone'),
                        'encodeLabel' => false,
                        'url'         => ['day-trainings-duplicate', 'id' => $model->id, 'day_id' => $day->id],
//                        'success'     => '#day' . $dayId,
                        'title'       => Yii::t('app', 'Duplicate trainings'),
                        'options'     => ['class' => 'red mulaffBtn']
            ]);
        }
        if ($day->trainings && count($day->trainings) > 1) {

            $buttons[] = AjaxModalButton::widget([
                        'label'       => StyleIcon::showStyled('list'),
                        'encodeLabel' => false,
                        'url'         => ['training-order', 'id' => $model->id, 'date' => $dayId],
                        'success'     => '#trainings' . $dayId,
                        'title'       => Yii::t('app', 'Update training city'),
                        'options'     => ['class' => 'red mulaffBtn']
            ]);
        }
    }
}
if (!empty($buttons)) {
    echo ' ' . join(' ', $buttons);
}