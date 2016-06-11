<?php

use app\models\Training;
use app\widgets\ReportingWidget;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
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
/* @var $training Training */
/* @var $model User */
echo Html::beginTag('fieldset');
echo Html::tag('legend',  Yii::t('app', 'Reporting'));
if ($training->reporting) {
    echo ReportingWidget::widget(['model' => $training, 'attribute' => 'done', 'user' => $model]);
} else {
    echo AjaxModalButton::widget([
        'label'       => Yii::t('app', 'Add Reporting'),
        'encodeLabel' => false,
        'url'         => [
            'reporting-update',
            'id'          => $model->id,
            'training_id' => $training->id
        ],
        'title'       => Yii::t('app', 'Make a report: {title}', ['title' => $training->title]),
        'success'     => '#week' . date('Y-m-d',strtotime($training->week->date_begin)),
        'options'     => [
            'class' => 'red-btn',
        ],
    ]);
}
echo Html::endTag('fieldset');



