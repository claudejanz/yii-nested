<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($model && (Yii::$app->user->can('update'))) {
    $controller = Yii::$app->controller;
    $params = $controller->actionParams;
    // $model->class_css = 'default';

    $self = (isset($params['returnUrl'])) ? urldecode($params['returnUrl']) : Url::to(array_merge(["{$controller->id}/{$controller->action->id}"], $params));
    NavBar::begin([
        'innerContainerOptions'=>['class'=>'rien'],
        'options' => [
            'class' => 'navbar-default pull-right',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items' => [
            ['label' => "<span class=\"glyphicon glyphicon-edit\"></span>", 'url' => array_merge(['elements/update'], ['id' => $model->id, 'returnUrl' => urlencode($self)]), 'encode' => false],
            ['label' => "<span class=\"glyphicon glyphicon-remove\"></span>", 'url' => array_merge(['elements/delete'], ['id' => $model->id, 'returnUrl' => urlencode($self)]), 'encode' => false],
            ['label' => "<span class=\"glyphicon glyphicon-eye-open\"></span>", 'url' => array_merge(['elements/view'], ['id' => $model->id, 'returnUrl' => urlencode($self)]), 'encode' => false],
            ['label' => "<span class=\"glyphicon glyphicon-list\"></span>", 'url' => array_merge(['elements/index'], ['id' => $model->id, 'returnUrl' => urlencode($self)]), 'encode' => false],
        ]
    ]);
    NavBar::end();
    echo Html::tag('div','',['class'=>'clearfix']);
}