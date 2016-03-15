<?php

use app\extentions\MySortableAsset;
use app\models\search\TrainingTypeSearch;
use app\models\Training;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\jui\JuiAsset;
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
Yii::$app->controller->page->title = Yii::t('app', 'Planning of {name}', ['name' => $model->fullname]);

echo '<svg width="0" height="0"><defs><linearGradient id="grad2" x1="0%" y1="100%" x2="0%" y2="0%"><stop offset="0%" style="stop-color:#FCC40B;stop-opacity:1"></stop><stop offset="50%" style="stop-color:#FCC40B;stop-opacity:1"></stop><stop offset="100%" style="stop-color:#3FC344;stop-opacity:1"></stop></linearGradient><linearGradient id="grad3" x1="0%" y1="100%" x2="0%" y2="0%"><stop offset="0%" style="stop-color:#FCC40B;stop-opacity:1"></stop><stop offset="33.33%" style="stop-color:#FCC40B;stop-opacity:1"></stop><stop offset="66.66%" style="stop-color:#3FC344;stop-opacity:1"></stop><stop offset="100%" style="stop-color:#1f9445;stop-opacity:1"></stop></linearGradient><linearGradient id="grad4" x1="0%" y1="100%" x2="0%" y2="0%"><stop offset="0%" style="stop-color:#FCC40B;stop-opacity:1"></stop><stop offset="25%" style="stop-color:#FCC40B;stop-opacity:1"></stop><stop offset="50%" style="stop-color:#3FC344;stop-opacity:1"></stop><stop offset="75%" style="stop-color:#1f9445;stop-opacity:1"></stop><stop offset="100%" style="stop-color:#f68e12;stop-opacity:1"></stop></linearGradient><linearGradient id="grad5" x1="0%" y1="100%" x2="0%" y2="0%"><stop offset="0%" style="stop-color:#FCC40B;stop-opacity:1"></stop><stop offset="20%" style="stop-color:#FCC40B;stop-opacity:1"></stop><stop offset="40%" style="stop-color:#3FC344;stop-opacity:1"></stop><stop offset="60%" style="stop-color:#1f9445;stop-opacity:1"></stop><stop offset="80%" style="stop-color:#f68e12;stop-opacity:1"></stop><stop offset="100%" style="stop-color:#f60100;stop-opacity:1"></stop></linearGradient></defs></svg>';


echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => ($isCoach) ? 'col-sm-8' : 'col-sm-12']);
echo $this->render('planning/receive/weeks', [
    'startDate' => $startDate,
    'endDate' => $endDate,
    'models' => $models,
    'model' => $model,
    'isCoach' => $isCoach,
]);
echo Html::endTag('div');
if ($isCoach) {

    echo Html::beginTag('div', ['class' => 'col-sm-4']);
    echo Html::beginTag('div', ['class' => 'kneubuhler', 'data-spy' => "affix", 'data-offset-top' => "180", 'data-top' => "0",]);

    echo $this->render('planning/drag/list', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]);
    echo Html::endTag('div');
    echo Html::endTag('div');
}
echo Html::endTag('div');

$this->registerJs("
        var affix = $('div[data-spy=\"affix\"]'), 
       parent = affix.parent(), 
       resize = function() { affix.width(parent.width()); };
   $(window).resize(resize); 
   resize();
        ");
