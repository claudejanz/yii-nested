<?php

use app\extentions\StyleIcon;
use app\models\User;
use app\models\WeekComment;
use claudejanz\toolbox\widgets\ajax\AjaxButton;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use yii\helpers\Html;
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
 * @var Boolean $forDashBoard
 */

/* @var $forDashBoard boolean */
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
                    'users/week-update-comment',
                    'id'      => $user->id,
                    'comment_id' => $model->id,
                ],
                'success'     => '#comment' . $model->id,
                'title'       => $label,
                'options'     => ['class' => 'red mulaffBtn']
    ]);
}
if(Yii::$app->user->can('admin')&&!$model->read){
    $label = Yii::t('app', 'Mark as Viewed');
    
    $buttons[] = AjaxButton::widget([
                'label'       => StyleIcon::showStyled('check').' '.$label,
                'encodeLabel' => false,
                'url'         => [
                    'users/week-read-comment',
                    'id'      => $user->id,
                    'comment_id' => $model->id,
                ],
                'success'     => ($forDashBoard)?'#comments':'#comment' . $model->id,
//                'title'       => $label,
                'options'     => ['class' => 'red mulaffBtn']
    ]);
}
if($forDashBoard){
    $label = Yii::t('app', 'View message in context');
    $buttons[] = Html::a(StyleIcon::showStyled('eye').' '.$label,[
        'users/planning',
        'id'=>$model->created_by,
        'date'=>$model->week->date_begin,
    ],[
       'class' => 'red mulaffBtn', 
       'data-pjax' => '0' 
    ]);
}

if (!empty($buttons)) {
    echo ' ' . join(' ', $buttons);
}