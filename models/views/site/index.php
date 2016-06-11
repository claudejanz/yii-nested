<?php

use app\extentions\helpers\MyPjax;
use app\extentions\MyGridView;
use app\models\search\SportifSearch;
use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* @var $searchModel SportifSearch */

echo Html::tag('h2', Yii::t('app', 'My sportifs'));
MyPjax::begin();
echo $this->render('index/_sportifSearch', ['model' => $searchModel]);
echo $this->render('index/_navigation', ['model' => $searchModel]);
?>

<p>
    <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
      'modelClass' => 'User',
      ]), ['create'], ['class' => 'btn btn-success']) */ ?>
</p>
<?php
$legend = $this->render('index/_legend');
echo MyGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => $searchModel->getColumns($this),
    'addHeader'    => true,
    'panel'        => [

        'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info', 'data-pjax' => 0]).Html::tag('p',$legend,['class'=>'pull-right']),
    ]
]);
MyPjax::end();
?>