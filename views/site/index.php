<?php

use app\extentions\helpers\MyPjax;
use app\models\search\SportifSearch;
use kartik\grid\GridView;
use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* @var $searchModel SportifSearch */

echo Html::tag('h2', Yii::t('app', 'My sportifs'));
MyPjax::begin();
if(Yii::$app->user->can('admin'))echo $this->render('/users/_trainerSearch', ['model' => $searchModel]); 
?>

<p>
    <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
      'modelClass' => 'User',
      ]), ['create'], ['class' => 'btn btn-success']) */ ?>
</p>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $searchModel->getColumns($this),
    'responsive' => true,
    'hover' => true,
    'condensed' => true,
    //'floatHeader' => true,
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode($this->title) . ' </h3>',
        'type' => 'info',
        'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['users/create'], ['class' => 'btn btn-success','data-pjax'=>0]), 
        'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
        'showFooter' => false
    ],
]);
MyPjax::end();
?>