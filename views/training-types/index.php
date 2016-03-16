<?php

use app\extentions\helpers\MyPjax;
use app\models\search\TrainingTypeSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

 /* @var $this View  */
 /* @var $dataProvider ActiveDataProvider  */
 /* @var $searchModel TrainingTypeSearch  */

Yii::$app->controller->page->title = Yii::t('app', 'Training Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-type-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Training Type',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php MyPjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $searchModel->getColumns(),
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,




        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success','data'=>['pjax'=>0]]),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); MyPjax::end(); ?>

</div>
