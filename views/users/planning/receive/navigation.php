<?php

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

echo Html::beginTag('div', ['class' => 'row weekNav']);
echo Html::beginTag('div', ['class' => 'col-xs-6 animated fadeInLeft']);
echo Html::a(Yii::t('app', 'Previous Week'), Url::current(['date' => $linkDate->format('Y-m-d')]), ['class' => 'kneubuhler', 'data' => ['pjax' => '0']]);
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'col-xs-6 animated fadeInRight']);
$linkDate = clone $startDate;
$linkDate->modify('+7 days');
echo Html::a(Yii::t('app', 'Next Week'), Url::current(['date' => $linkDate->format('Y-m-d')]), ['class' => 'kneubuhler', 'data' => ['pjax' => '0']]);
echo Html::endTag('div');
echo Html::endTag('div');