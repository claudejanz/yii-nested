<?php

use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!Yii::$app->user->isGuest) {
    echo Html::beginTag('div', ['class' => 'ribbon']);
    echo Html::beginTag('span', ['class' => $model->publishedColor]);
    echo $model->publishedLabel;
    echo Html::endTag('span');
    echo Html::endTag('div');
}