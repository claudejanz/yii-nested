<?php

use app\models\Mail;
use app\models\User;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $user User */
/* @var $model Mail */

echo Html::tag('h1',  Yii::t('mail', 'Hi {name},',['name'=>$user->firstname]));


echo $model->content;
        
 

