<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
//$this->title = 'KLOD';


echo Html::beginTag('div',['class'=>'row']);
echo Html::beginTag('div',['class'=>'col-sm-8']);
echo Html::endTag('div');
echo Html::beginTag('div',['class'=>'col-sm-4']);


echo $this->render('/training-type/drag',[
        ]);
echo Html::endTag('div');
echo Html::endTag('div');



