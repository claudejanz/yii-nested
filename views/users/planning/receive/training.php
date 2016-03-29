<?php

use app\extentions\helpers\MyPjax;
use app\extentions\MulaffGraphWidget;
use app\extentions\MulaffGraphWidgetV2;
use app\extentions\StyleIcon;
use app\models\Training;
use app\models\User;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\helpers\Html;
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
echo Html::beginTag('div', ['class' => 'row trainingDesc']);
echo Html::beginTag('div', ['class' => ($isCoach) ? 'col-sm-10' : 'col-sm-12 trainingWrapper']);
echo Html::beginTag('div', ['class' => 'timeDuration']);
echo $model->duration;
echo ' - ';
echo Html::img($model->sport->iconUrl, ['width' => 25]);
echo ' ' . $model->sport->title;
echo ' - ';
echo $model->title;
echo Html::endTag('div'); //timeDuration
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-sm-2']);
echo Html::beginTag('p', ['class' => 'text-right']);
if ($isCoach) {
    echo AjaxModalButton::widget([
        'label' => StyleIcon::showStyled('edit'),
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
//    echo AjaxButton::widget([
//        'label' => StyleIcon::showStyled('remove'),
//        'encodeLabel' => false,
//        'url' => [
//            'training-delete',
//            'id' => $user->id,
//            'training_id' => $model->id
//        ],
//        'success' => '#training' . $model->id,
//        'options' => [
//            'class' => 'red',
//            'title' => Yii::t('yii', 'Delete'),
//            'class' => 'red',
//            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
//            'data-method' => 'post',
//            'data-pjax' => '0',
//        ],
//    ]);

    echo Html::a(StyleIcon::showStyled('remove'), Url::to(['training-delete', 'id' => $user->id, 'training_id' => $model->id]), [
        'title' => Yii::t('yii', 'Delete'),
        'class' => 'red',
        'aria-label' => Yii::t('yii', 'Delete'),
        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
        'data-method' => 'post',
        'data-pjax' => '0',
    ]);
    echo ' ';
}
echo ' ';
echo AjaxModalButton::widget([
    'label' => StyleIcon::showStyled('tasks'),
    'encodeLabel' => false,
    'url' => [
        'reporting-update',
        'id' => $user->id,
        'training_id' => $model->id
    ],
    'title' => Yii::t('app', 'Make a report: {title}', ['title' => $model->title]),
    'success' => '#week_graph' . $model->week->date_begin,
    'options' => [
        'class' => 'red',
    ],
]);
echo Html::endTag('p');
echo Html::beginTag('p', ['class' => 'text-right']);
echo Html::a(StyleIcon::showStyled('plus'), "#", ['onClick' => '$("#training' . $model->id . '").find(".hid").slideToggle();return false;', 'class' => 'red right-align']);
echo Html::endTag('p');
echo Html::endTag('div');
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'row' . (($isCoach) ? ' hid' : '')]);
echo Html::beginTag('div', ['class' => 'col-sm-12 graphWrapper']);
echo MulaffGraphWidgetV2::widget(['width' => '100%', 'height' => 150, 'model' => $model, 'attribute' => 'graph', 'withLegends' => true, 'withLines' => true, 'color' => MulaffGraphWidget::COLOR_GRADIENT]);
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'col-sm-12']);
$attributes = [
//        'title',
//        'rpe',
    'explanation:ntext',
    'extra_comment:ntext'
];
if($isCoach){
    array_push($attributes, 'rpe');
}
echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
]);
echo Html::endTag('div');
echo Html::endTag('div');

MyPjax::end();
