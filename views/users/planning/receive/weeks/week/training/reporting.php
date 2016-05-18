<?php

use app\models\Training;
use app\widgets\ReportingWidget;
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
/* @var $model Training */

if ($model->reporting) {
    echo ReportingWidget::widget(['model' => $model, 'attribute' => 'done', 'user' => $user]);
} else {
    echo AjaxModalButton::widget([
        'label'       => Yii::t('app', 'Add Feedback'),
        'encodeLabel' => false,
        'url'         => [
            'reporting-update',
            'id'          => $user->id,
            'training_id' => $model->id
        ],
        'title'       => Yii::t('app', 'Make a report: {title}', ['title' => $model->title]),
        'success'     => '#week' . date('Y-m-d',strtotime($model->week->date_begin)),
        'options'     => [
            'class' => 'red-btn',
        ],
    ]);
}




