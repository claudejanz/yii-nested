<?php

use app\extentions\helpers\EuroDateTime;
use app\models\search\SportifSearch;
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

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
/**
 * @var View $this
 * @var SportifSearch $model
 */
$startDate = new EuroDateTime($model->date);
$startDate->modify('first day of this month');
$linkDate = clone $startDate;

$linkDate->modify('-1 month');
$optionsLeft=['class' => 'col-xs-6'];
$optionsRight=['class' => 'col-xs-6'];

echo Html::beginTag('div', ['class' => 'row weekNav']);

echo Html::beginTag('div', $optionsLeft);
echo Html::a(Yii::t('app', 'Previous Month'), Url::current(['SportifSearch[date]' => $linkDate->format('Y-m-d')]), ['class' => 'kneubuhler', 'data' => ['pjax' => '0']]);
echo Html::endTag('div');

$linkDate = clone $startDate;
$linkDate->modify('+1 month');

echo Html::beginTag('div', $optionsRight);
echo Html::a(Yii::t('app', 'Next Month'), Url::current(['SportifSearch[date]' => $linkDate->format('Y-m-d')]), ['class' => 'kneubuhler', 'data' => ['pjax' => '0']]);
echo Html::endTag('div');

echo Html::endTag('div');