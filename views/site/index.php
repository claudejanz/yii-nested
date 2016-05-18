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
if (Yii::$app->user->can('coach')) {
    echo $this->render('/users/_trainerSearch', ['model' => $searchModel]);
}
?>

<p>
    <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
      'modelClass' => 'User',
      ]), ['create'], ['class' => 'btn btn-success']) */ ?>
</p>
<?php
echo MyGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $searchModel->getColumns($this),
]);
MyPjax::end();
?>