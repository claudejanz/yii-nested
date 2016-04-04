<?php

use app\extentions\helpers\MyPjax;
use app\models\SubCategory;
use claudejanz\toolbox\widgets\ajax\AjaxButton;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\icons\Icon;
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
/* @var $model SubCategory */
MyPjax::begin(['id'=>'subcat'.$model->id]);
echo Html::beginTag('li');
$update = AjaxModalButton::widget([
    'label' => Icon::show('edit'),
    'encodeLabel' => false,
    'url' => [
        'item-update',
        'id' => $model->id,
        'type'=> 'subcat',
    ],
    'title' => Yii::t('app', 'Update Sub-Category {name}', ['name' => $model->title]),
    'success' => '#subcat' . $model->id,
    'options' => [
        'title' => Yii::t('app', 'Update'),
    ],
]);
$delete = AjaxButton::widget([
            'label' => Icon::show('trash'),
            'encodeLabel' => false,
            'url' => [
                'item-delete',
                'id' => $model->id,
                'type' => 'subcat',
            ],
            'success' => '#cat'.$model->category_id,
            'options' => [
                'title' => Yii::t('app', 'Delete'),
            ],
            'ajaxOptions' => [
                'type' => 'post',
            ],
        ]);
echo $model->title.' '.$update.' '.$delete.' ';
echo Html::endTag('li');
MyPjax::end();