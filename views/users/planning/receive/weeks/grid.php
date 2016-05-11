<?php

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
//echo Html::beginTag('div',['class'=>'table-responsive']);
echo Html::beginTag('table',['class'=>'table table-condensed']);
foreach ($period as $dateTime) {
    echo $this->render('weekLine', [
        'date' => $dateTime,
        'weekId' => $dateTime->format('Y-m-d'),
        'model' => $model,
        'isCoach' => $isCoach,
    ]);
}
echo Html::endTag('table');
//echo Html::endTag('div');
