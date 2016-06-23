<?php

use app\extentions\helpers\MyPjax;
use app\extentions\MulaffGraphWidgetV2;
use app\extentions\StyleIcon;
use app\models\TrainingType;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* @var $model TrainingType */
MyPjax::begin(['id' => 'training-type' . $model->id]);
echo Html::beginTag('div', ['class' => 'rounded training-type', 'data' => ['training-type-id' => $model->id]]);
echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-sm-8']);


$buttons;
$buttons[] = AjaxModalButton::widget([
            'label'       => StyleIcon::showStyled('edit'),
            'encodeLabel' => false,
            'url'         => ['training-types/update', 'id' => $model->id],
            'success'     => '#training-type' . $model->id,
            'title'       => Yii::t('app', 'Update training type'),
            'options'     => ['class' => 'red mulaffBtn']
        ]);

if (!empty($buttons)) {
    echo ' ' . join(' ', $buttons);
}

echo ' - ';
echo Html::tag('b', $model->duration);
echo ' - ';
echo Html::img($model->sport->iconUrl, ['width' => 20]);
if (!isset($searchModel->sport_id)) {
    echo ' ' . $model->sport->title;
}
echo ' - ';
echo Html::tag('span', $model->getShortTitle());
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'col-sm-4']);
echo MulaffGraphWidgetV2::widget(['width' => '100%', 'height' => 30, 'model' => $model, 'attribute' => 'graph', 'graphOptions' => ['class' => 'small']]);
echo Html::endTag('div');
echo Html::endTag('div');


echo Html::endTag('div');
MyPjax::end();
