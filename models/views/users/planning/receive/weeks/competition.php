<?php

use app\extentions\StyleIcon;
use app\models\Competition;
use app\models\User;
use yii\bootstrap\Alert;
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
/* @var $startDate DateTime */
/* @var $endDate DateTime */
$competitions = Competition::find()->andWhere(['sportif_id' => $model->id])
        ->andWhere(['<=', 'date_begin', $endDate->format('Y-m-d')])
        ->andWhere(['>=', 'date_end', $startDate->format('Y-m-d')])
//        ->andWhere(['OR', ['between', 'date_begin', $startDate->format('Y-m-d'), $endDate->format('Y-m-d')], ['between', 'date_end', $startDate->format('Y-m-d'), $endDate->format('Y-m-d')]])
        ->all();
if ($competitions) {
    Alert::begin([
        'options' => [
            'class' => 'alert-info',
        ],
    ]);
    echo Html::tag('h4', Yii::t('app', 'Competitions'));
    echo Html::beginTag('ul');
    foreach ($competitions as $competition) {
        /* @var $competition Competition */
        echo Html::beginTag('li');
        echo $competition->title . ' - ';
        echo Yii::$app->formatter->asDate($competition->date_begin) . ' - ';
        echo Yii::$app->formatter->asDate($competition->date_end) . ' - ';
        echo Html::a(StyleIcon::showStyled('edit'), ['competition/update', 'id' => $competition->id, 'sportif_id' => $model->id]);
        echo Html::endTag('li');
    }
    echo Html::endTag('ul');
    Alert::end();
}