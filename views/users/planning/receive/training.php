<?php

use app\extentions\helpers\MyPjax;
use app\extentions\MulaffGraphWidget;
use app\models\Training;
use app\models\User;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\helpers\Url;
use yii\widgets\DetailView;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $isCoach booleen */
/* @var $model Training */
/* @var $user User */


MyPjax::begin(['id' => 'training' . $model->id]);
echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => ($isCoach)?'col-sm-11':'col-sm-12']);
echo Html::tag('b', $model->duration);
echo ' - ';
echo $model->title;
echo Html::endTag('div');

if ($isCoach) {
echo Html::beginTag('div', ['class' => 'col-sm-1']);
    echo AjaxModalButton::widget([
        'label' => Icon::show('pencil'),
        'encodeLabel' => false,
        'url' => [
            'training-update',
            'id' => $user->id,
            'training_id' => $model->id
        ],
        'title' => Yii::t('app', 'Edit training: {title}', ['title' => $model->title]),
        'success' => '#training' . $model->id,
        'options' => [
            'class' => 'red',
        ],
    ]);
    echo ' ';
    echo Html::a(Icon::show('trash'), Url::to(['training-delete', 'id' => $user->id, 'training_id' => $model->id]), [
        'title' => Yii::t('yii', 'Delete'),
        'class' => 'red',
        'aria-label' => Yii::t('yii', 'Delete'),
        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
        'data-method' => 'post',
        'data-pjax' => '0',
    ]);
    echo ' ';
echo Html::a(Icon::show('plus'), "#", ['onClick' => '$("#training' . $model->id . '").find(".hid").slideToggle();return false;', 'class' => 'red']);
    echo Html::endTag('div');
}
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'row'.(($isCoach)?' hid':'')]);
echo Html::beginTag('div', ['class' => 'col-sm-12']);
echo MulaffGraphWidget::widget(['width' => 300, 'height' => 150, 'model' => $model, 'attribute' => 'graph','withLegends'=>true,'withLines'=>true,  'color'=>MulaffGraphWidget::COLOR_GRADIENT]);
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'col-sm-12']);
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
//        'title',
        'rpe',
        'explanation:ntext',
        'extra_comment:ntext'
    ]
]);
echo Html::endTag('div');
echo Html::endTag('div');

MyPjax::end();
