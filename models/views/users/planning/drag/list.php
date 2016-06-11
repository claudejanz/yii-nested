<?php

use app\extentions\helpers\MyPjax;
use app\models\search\TrainingTypeSearch;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\jui\JuiAsset;
use yii\web\View;
use yii\widgets\ListView;

/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel TrainingTypeSearch */
/* @var $this View */
/* @var $model User */


JuiAsset::register($this);
MyPjax::begin(['id' => 'drag']);

echo $this->render('_search', ['model' => $searchModel, 'user' => $model]);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'viewParams' => [
        'searchModel' => $searchModel,
    ],
    'itemOptions' => [
        'class' => 'draggable'
        ],
    'itemView' => '_item',
]);

$js = '$(function() {
    $( ".draggable" ).draggable({
      stack: ".draggable",
      activeClass: "ui-state-hover",
      hoverClass: "ui-state-active",
      cursor: "move",
      helper: "clone",
      revert: "invalid"
    })
    
  })';

$this->registerJs($js);

MyPjax::end();
?>

