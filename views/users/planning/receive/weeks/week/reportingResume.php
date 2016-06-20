<?php

use app\extentions\helpers\MyPjax;
use app\extentions\MulaffWeekGraphWidget;
use app\extentions\MulaffWeekSportsWidget;
use app\models\Week;
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

/* @var $week Week */
/* @var $startDate DateTime */
MyPjax::begin(['id' => 'week_graph' . $startDate->format('Y-m-d')]);
$options = ['class' => 'white-block week-graph'];
if (!Yii::$app->request->isAjax) {
    Html::addCssClass($options, 'animated fadeInUp');
}
if ($week) {
    echo Html::beginTag('div', $options);
    if ($week->reportings) {
        echo Html::beginTag('div', ['class' => 'row']);
        echo Html::beginTag('div', ['class' => 'col-sm-12']);
        echo Html::tag('h4', Yii::t('app', 'Week Graph'));
        echo MulaffWeekGraphWidget::widget(['model' => $week, 'width' => '100%', 'height' => '100']);
        echo Html::endTag('div');
        echo Html::endTag('div');
    }
    echo Html::beginTag('div', ['class' => 'row']);
    echo Html::beginTag('div', ['class' => 'col-sm-12']);
    echo Html::tag('h4', Yii::t('app', 'Week Sports'));
    echo MulaffWeekSportsWidget::widget(['model' => $week]);
    echo Html::endTag('div');
    echo Html::endTag('div');
    
    echo Html::endTag('div');
}
MyPjax::end();
