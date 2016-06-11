<?php

use app\extentions\helpers\MyPjax;
use app\models\Element;
use app\models\search\ElementSearch;
use claudejanz\toolbox\models\behaviors\CssClassBehavior;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var ElementSearch $searchModel
 * @var Element $model
 */
?>
<div class="element-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
          'modelClass' => 'Widget',
          ]), ['create'], ['class' => 'btn btn-success']) */ ?>
    </p>

    <?php
    MyPjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'title',
            'type',
            [
                'attribute' => 'class_css',
                'value' => function($model) {
                    return $model->getClassCssLabel();
                },
                'filter' => Html::activeDropDownList($searchModel, 'class_css', CssClassBehavior::getClassCssTextOptions(), ['prompt' => Yii::t('app', 'All'), 'class' => 'form-control']),
            ],
//            'weight',
//            'display_title',
//            'type', 
//            'published', 
//            'created_by', 
//            ['attribute'=>'created_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            'updated_by', 
//            ['attribute'=>'updated_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {order} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['elements/update', 'id' => $model->id]), [
                                    'title' => Yii::t('yii', 'Edit'),
                        ]);
                    },
                    'order' => function ($url, $model) {
                        return ($model->type==Element::TYPE_SLIDESHOW)?Html::a('<span class="glyphicon glyphicon-sort-by-attributes"></span>', Yii::$app->urlManager->createUrl(['elements/slideshow-order', 'id' => $model->id]), [
                                    'title' => Yii::t('yii', 'Order'),
                        ]):'';
                    }
                        ],
                    ],
                ],
                'responsive' => true,
                'hover' => true,
                'condensed' => true,
                'floatHeader' => true,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode($this->title) . ' </h3>',
                    'type' => 'info',
                    'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']), 'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                    'showFooter' => false
                ],
            ]);
            MyPjax::end();
            ?>

</div>
