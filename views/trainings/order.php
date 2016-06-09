<?php

use app\models\Day;
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
    foreach ($items as $key => $row) {
        $items[$key]['options'] = ['id' => $row['id']];
        $items[$key]['content'] = $items[$key]['title'];
        unset($items[$key]['id']);
        unset($items[$key]['title']);
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
        'itemOptions' => ['class' => 'btn btn-info'],
        'items' => $items,
//        'clientOptions'=>['placeholder'=> "ui-sortable-handle ui-sortable-highlight"],
        'clientOptions'=>['placeholder'=> ""],
        
        'clientEvents' => [
            'update' => 'function(){$.ajax("' . $url . '",' . $ajaxOptions . ').done(function( data ) {
            $("#response-order").html(data);
})}'
        ]
    ]);
    ?>

</div>
