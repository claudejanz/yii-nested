<?php

use app\extentions\MySortableAsset;
use app\models\search\TrainingTypeSearch;
use app\models\Training;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model User */
/* @var $startDate DateTime */
/* @var $endDate DateTime */
/* @var $models Training[] */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel TrainingTypeSearch */
/* @var $isCoach booleen */

MySortableAsset::register($this);
if (Yii::$app->user->id == $model->id) {
    Yii::$app->controller->page->title = Yii::t('app', 'My Planning');
} else {
    Yii::$app->controller->page->title = Yii::t('app', 'Planning of {name}', ['name' => $model->fullname]);
}

echo Html::beginTag('div', ['class' => 'row']);

echo Html::beginTag('div', ['class' => ($isCoach) ? 'col-sm-8' : 'col-sm-12']);
echo $this->render('planning/receive/weeks', [
    'startDate' => $startDate,
    'endDate'   => $endDate,
    'model'     => $model,
    'isCoach'   => $isCoach,
]);
echo Html::endTag('div'); // col

if ($isCoach) {
    echo Html::beginTag('div', ['class' => 'col-sm-4 hidden-xs']);
    echo Html::beginTag('div', ['class' => 'kneubuhler', 'data-spy' => "affix", 'data-offset-top' => "180", 'data-top' => "0",]);

    echo $this->render('planning/drag/list', [
        'model'        => $model,
        'dataProvider' => $dataProvider,
        'searchModel'  => $searchModel,
    ]);
    echo Html::endTag('div');
    echo Html::endTag('div');
}
echo Html::endTag('div');// row 

$this->registerJs("
        var affix = $('div[data-spy=\"affix\"]'), 
       parent = affix.parent(), 
       resize = function() { affix.width(parent.width()); };
   $(window).resize(resize); 
   resize();
        ");

// script to collapse days
$js = '
    
     $(document).on("click",".day, .training-type, .comments",function(event){
        
        $(this).find(".collapsable").slideToggle();
    });
    ';
$this->registerJs($js);
