<?php

use app\models\WeekComment;
use yii\data\ActiveDataProvider;

use app\models\User;
use app\models\WeekComment;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var WeekComment $model
 */

?>
<div class="week-comment-view">
  
    <?php
    /* @var $model WeekComment */
    $user = User::findOne($model->created_by);
    echo Html::tag('p',Yii::$app->formatter->asDatetime($model->created_at)); 
    echo Html::tag('p',$user->firstname); 
    echo Html::tag('h2',$model->title); 
    echo Html::tag('p',$model->content); 
    ?>

</div>
