<?php

use app\extentions\helpers\MyPjax;
use app\models\Sport;
use claudejanz\toolbox\widgets\ajax\AjaxButton;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\helpers\Html as Html2;
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
/* @var $model Sport */
MyPjax::begin(['id' => 'sport' . $model->id]);
$add = AjaxModalButton::widget([
            'label' => Icon::show('plus'),
            'encodeLabel' => false,
            'url' => [
                'item-add',
                'parent_id' => $model->id,
                'type' => 'cat'
            ],
            'title' => Yii::t('app', 'Add Category to {name}', ['name' => $model->title]),
            'success' => '#sport' . $model->id,
            'options' => [
                'title' => Yii::t('app', 'Add'),
            ],
        ]);
$update = AjaxModalButton::widget([
            'label' => Icon::show('pencil'),
            'encodeLabel' => false,
            'url' => [
                'item-update',
                'id' => $model->id,
            ],
            'title' => Yii::t('app', 'Update Sport {name}', ['name' => $model->title]),
            'success' => '#sport' . $model->id,
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
            ],
            'success' => '#sports',
            'options' => [
                'title' => Yii::t('app', 'Delete'),
            ],
            'ajaxOptions' => [
                'type' => 'post',
            ],
        ]);
echo Html::beginTag('li');
echo $model->title . ' ' . $update . ' ' . $delete . ' ';
echo Html2::endTag('li');
echo Html::beginTag('ul', ['class' => 'cat']);
if ($model->categories) {
    foreach ($model->categories as $m) {
        echo $this->render('_cat', [
            'model' => $m,
        ]);
    }
}
echo $add;
echo Html::endTag('ul');
MyPjax::end();

