<?php

use app\models\Page;
use app\models\Element;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* @var $model Page */
/* @var $element Element */
$model = Yii::$app->controller->page;
if (isset($model->elements)) {
    foreach ($model->elements as $element) {
        echo $this->render('/elements/view',['model'=>$element]);
    }
}else{
    echo 'pages vide';
}