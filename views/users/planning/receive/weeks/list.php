<?php

use app\extentions\WebUser;
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

/* @var $period DatePeriod */
/* @var $model User */
/* @var $isCoach booleen */

echo Html::beginTag('div', ['class' => 'row']);

switch (Yii::$app->user->planningStyle) {

    case WebUser::VIEWSTYLE_COACH:
        foreach ($period as $key => $dateTime) {
            if ($key < 2) {
                echo Html::beginTag('div', ['class' => ($isCoach) ? 'col-lg-6' : 'col-lg-12']);
            }
            echo $this->render('week', [
                'date'    => $dateTime,
                'weekId'  => $dateTime->format('Y-m-d'),
                'model'   => $model,
                'isCoach' => $isCoach,
                'isLight' => ($key == 0) ? true : false,
            ]);
            if ($key == 0) {
                echo Html::endTag('div');
            }
        }
        echo Html::endTag('div');
        break;
    case WebUser::VIEWSTYLE_NORMAL:
    default :
        foreach ($period as $dateTime) {
            echo Html::beginTag('div', ['class' => ($isCoach) ? 'col-lg-6' : 'col-lg-12']);
            echo $this->render('week', [
                'date'    => $dateTime,
                'weekId'  => $dateTime->format('Y-m-d'),
                'model'   => $model,
                'isCoach' => $isCoach,
                'isLight' => false,
            ]);
            echo Html::endTag('div');
        }
        break;
}
echo Html::endTag('div'); //row