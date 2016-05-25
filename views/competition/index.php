<?php

use app\extentions\MyGridView;
use app\models\search\CompetitionSearch;
use kartik\icons\Icon;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var CompetitionSearch $searchModel
 */

Yii::$app->controller->page->title = Yii::t('app', 'Competitions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competition-index">
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Competition',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo MyGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'title',
//            'sportif_id',
            ['attribute'=>'date_begin','format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y']],
            ['attribute'=>'date_end','format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y']],
//            'published', 
//            'created_by', 
//            ['attribute'=>'created_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            'updated_by', 
//            ['attribute'=>'updated_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a(Icon::show('edit'), Yii::$app->urlManager->createUrl(['competition/update','sportif_id'=>Yii::$app->controller->model->id,'id' => $model->id]), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);
                                    
                },

                        'delete'=>function ($url, $model) {
                                    return Html::a(Icon::show('remove'), Yii::$app->urlManager->createUrl(['competition/delete','sportif_id'=>Yii::$app->controller->model->id,'id' => $model->id]), [
                                                    'title' => Yii::t('yii', 'Delete'),
                                        'data-comfirm'=>  Yii::t('app', 'Are you sure you want to delete this item?'),
                                        'data-method'=> 'post'
                                                  ]);
                                    
                },
                ],
            ],
        ],
       



        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create','sportif_id'=>Yii::$app->controller->model->id], ['class' => 'btn btn-success','data'=>['pjax'=>0]]),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
        ],
    ]); Pjax::end(); ?>

</div>
