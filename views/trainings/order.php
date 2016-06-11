<?php

use app\models\Training;
use claudejanz\toolbox\widgets\ajax\AjaxSubmit;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\Sortable;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var View $this
 * @var Training[] $items
 */


?>
<div class="training-order">

    <?php
    $items=[];
    foreach ($trainings as $key => $training) {
        /* @var $training Training */
        $items[$key]['options'] = ['id' => $training->id];
        $items[$key]['content'] = Html::img($training->sport->iconUrl, ['width' => '15', 'title' => $training->sport->title]).' - '.$training->sport->title.' - '.$training->shortTitle.' - '.$training->duration;
        
    }
    $url = Url::to(['training-sort']);
    $ajaxOptions = Json::encode([
                'data' => ['order' => new JsExpression('$(this).sortable("toArray").toString()')],
                'type' => 'POST'
    ]);
    echo Html::tag('div', '', ['id' => 'response-order']);
    echo Sortable::widget([
        'id' => 'sortable_bloum',
        'options' => ['class' => 'nav nav-pills nav-stacked'],
        'itemOptions' => ['class' => 'btn btn-default'],
        'items' => $items,
//        'clientOptions'=>['placeholder'=> "ui-sortable-handle ui-sortable-highlight"],
        'clientOptions'=>['placeholder'=> ""],
        
        'clientEvents' => [
            'update' => 'function(){$.ajax("' . $url . '",' . $ajaxOptions . ').done(function( data ) {
            $("#trainig").html(data);
})}'
        ]
    ]);
    echo AjaxSubmit::widget(['label'   => Yii::t('app', 'Update'),
            'options' => [
                'class' => 'btn btn-primary'
        ]]);
    ?>

</div>
