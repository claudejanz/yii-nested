<?php

use app\extentions\helpers\MyPjax;
use app\extentions\MyGridView;
use app\models\search\SportifSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var  $this View */
/* @var $dataProvider ActiveDataProvider  */
/* @var $searchModel SportifSearch */

//Yii::$app->controller->page->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
   


    <?php MyPjax::begin(); echo MyGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $searchModel->getColumns(),




        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success','data-pjax'=>0]),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
        ],
    ]); MyPjax::end(); ?>

</div>