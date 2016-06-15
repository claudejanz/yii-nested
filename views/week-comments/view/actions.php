<?php

use app\extentions\StyleIcon;
use app\models\User;
use app\models\WeekComment;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
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

/* @var $this View */
/* @var $model WeekComment */
/* @var $user User */
/* @var $creator User */

$buttons;
if (Yii::$app->user->id == $creator->id) {
    $label = Yii::t('app', 'Update Comment');
    $buttons[] = AjaxModalButton::widget([
                'label'       => StyleIcon::showStyled('edit').' '.$label,
                'encodeLabel' => false,
                'url'         => [
                    'week-update-comment',
                    'id'      => $user->id,
                    'comment_id' => $model->id,
                ],
                'success'     => '#comment' . $model->id,
                'title'       => $label,
                'options'     => ['class' => 'red mulaffBtn']
    ]);
}

if (!empty($buttons)) {
    echo ' ' . join(' ', $buttons);
}