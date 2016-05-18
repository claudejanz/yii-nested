<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\TrainingType $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Training Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-type-view">
   

    <?= DetailView::widget([
            'model' => $model,
//            'condensed'=>false,
//            'hover'=>true,
//            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
//            'panel'=>[
//            'heading'=>$this->title,
////            'type'=>DetailView::TYPE_INFO,
//        ],
        'attributes' => [
            'id',
            'title',
            'sport_id',
            'category_id',
            'sub_category_id',
//            [
//                'attribute'=>'time',
//                'format'=>['time',(isset(Yii::$app->modules['datecontrol']['displaySettings']['time'])) ? Yii::$app->modules['datecontrol']['displaySettings']['time'] : 'H:i:s A'],
//                'type'=>DetailView::INPUT_WIDGET,
//                'widgetOptions'=> [
//                    'class'=>DateControl::classname(),
//                    'type'=>DateControl::FORMAT_TIME
//                ]
//            ],
            'rpe',
            'explanation:ntext',
            'extra_comment:ntext',
            'graph:ntext',
            'graph_type',
            'published',
//            'created_by',
//            [
//                'attribute'=>'created_at',
//                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
//                'type'=>DetailView::INPUT_WIDGET,
//                'widgetOptions'=> [
//                    'class'=>DateControl::classname(),
//                    'type'=>DateControl::FORMAT_DATETIME
//                ]
//            ],
//            'updated_by',
//            [
//                'attribute'=>'updated_at',
//                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
//                'type'=>DetailView::INPUT_WIDGET,
//                'widgetOptions'=> [
//                    'class'=>DateControl::classname(),
//                    'type'=>DateControl::FORMAT_DATETIME
//                ]
//            ],
        ],
//        'deleteOptions'=>[
//            'url'=>['delete', 'id' => $model->id],
//            'data'=>[
//                'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method'=>'post',
//            ],
//        ],
//        'enableEditMode'=>true,
    ]) ?>

</div>
