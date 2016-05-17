<?php

use app\extentions\helpers\MyPjax;
use app\extentions\MulaffGraphWidget;
use app\extentions\MulaffGraphWidgetV2;
use app\extentions\PdfView;
use app\extentions\StyleIcon;
use app\models\Training;
use app\models\User;
use app\widgets\DoneDisplayWidget;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\helpers\Html;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* @var $isCoach booleen */
/* @var $model Training */
/* @var $user User */
MyPjax::begin(['id' => 'training' . $model->id]);

$options = ['class' => 'eachTraining'];


echo Html::beginTag('div', $options);
echo Html::beginTag('div', ['class' => 'row trainingDesc']);
echo Html::beginTag('div', ['class' => ($isCoach) ? 'col-sm-9' : 'col-sm-12 trainingWrapper']);

echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-xs-3']);

echo Html::beginTag('div', ['class' => 'timeDuration']);
echo $model->duration;
echo Html::endTag('div'); //timeDuration

echo Html::beginTag('div', ['class' => 'sports']);
// @mytodo adapter le code pourprendre en compte les couleurs de poilces
$img_options =  ['width' => 25, 'class' => 'sport-icon'];
if($model->reporting){
    if($model->reporting->done){
        Html::addCssClass($img_options, 'done');
    }else{
        Html::addCssClass($img_options, 'not-done');
    }
}
echo Html::img($model->sport->iconUrl,$img_options);
echo Html::endTag('div'); //sporticons

echo Html::endTag('div'); //end col-xs-3

echo Html::beginTag('div', ['class' => 'col-xs-9']); //start title and time col
echo Html::beginTag('div', ['class' => 'title']);
echo ' ' . $model->sport->title;
echo ' - ';
echo $model->title;
echo Html::endTag('div'); //sporticons
echo Html::endTag('div'); //end col-xs-9
echo Html::endTag('div'); //end row



echo Html::endTag('div'); //col-sm-12 trainingWrapper


if ($isCoach) {
    Html::addCssClass($options, 'col-sm-3');
} else {
    Html::addCssClass($options, 'col-sm-12');
}
echo Html::beginTag('div', ['class' => ($isCoach) ? 'col-sm-3' : 'col-sm-12']);
echo Html::beginTag('p', ['class' => 'text-right']);

// coach can edit training
if ($isCoach) {
    echo AjaxModalButton::widget([
        'label'       => StyleIcon::showStyled('edit'),
        'encodeLabel' => false,
        'url'         => [
            'training-update',
            'id'          => $user->id,
            'training_id' => $model->id
        ],
        'title'       => Yii::t('app', 'Edit training: {title}', ['title' => $model->title]),
        'success'     => '#training' . $model->id,
        'options'     => [
            'class' => 'red',
        ],
    ]);

    echo ' ';

    echo Html::a(StyleIcon::showStyled('remove'), Url::to(['training-delete', 'id' => $user->id, 'training_id' => $model->id]), [
        'title'        => Yii::t('yii', 'Delete'),
        'class'        => 'red',
        'aria-label'   => Yii::t('yii', 'Delete'),
        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
        'data-method'  => 'post',
        'data-pjax'    => '0',
    ]);
}


echo Html::endTag('p');
//if ($isCoach) {
//    echo Html::beginTag('p', ['class' => 'text-right']);
//    echo Html::a(StyleIcon::showStyled('plus'), "#", ['onClick' => '$("#training' . $model->id . '").find(".trainingToggle").slideToggle();return false;', 'class' => 'red right-align']);
//    echo Html::endTag('p');
//}
echo Html::endTag('div');
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-sm-12']);
echo $this->render('training/reporting', ['model' => $model, 'user' => $user]);
echo Html::endTag('div');
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'row plus']);
if (Yii::$app->user->planningStyle == 'short') {

    echo Html::beginTag('div', ['class' => 'col-sm-12']);
    $attributes = [
        'explanation:ntext',
    ];
    echo PdfView::widget([
        'model'      => $model,
        'attributes' => $attributes,
    ]);
    echo Html::endTag('div'); // col-sm-12
}
echo Html::beginTag('div', ['class' => 'col-sm-12 graphWrapper']);
echo MulaffGraphWidgetV2::widget(['width' => '100%', 'height' => 150, 'model' => $model, 'attribute' => 'graph', 'withLegends' => true, 'withLines' => true, 'color' => MulaffGraphWidget::COLOR_GRADIENT]);
echo Html::endTag('div');
if (Yii::$app->user->planningStyle == 'short') {

    echo Html::beginTag('div', ['class' => 'col-sm-12']);
    $attributes = [
        'extra_comment:ntext'
    ];
    if ($isCoach) {
        array_push($attributes, 'rpe');
    }
    echo PdfView::widget([
        'model'      => $model,
        'attributes' => $attributes,
    ]);
    echo Html::endTag('div'); // col-sm-12
}
echo Html::endTag('div'); // dayToggle

echo Html::endTag('div'); //sporticons
MyPjax::end();
