<?php

use app\models\Page;
use app\models\ElementSlideshow;
use app\models\ElementSlideshowImage;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\Sortable;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var View $this
 * @var Page $model
 */


?>
<div class="slideshow-order">

    <?php
    $ws_id = ElementSlideshow::find()->select(['id'])->andWhere(['element_id'=>$id])->asArray()->one();
    $items = ElementSlideshowImage::find()->select(['id','title'])->andWhere(['element_slideshow_id'=>$ws_id])->asArray()->orderBy('weight')->all();
    foreach ($items as $key => $row) {
        $items[$key]['options'] = ['id' => $row['id']];
        $items[$key]['content'] = $items[$key]['title'];
        unset($items[$key]['id']);
        unset($items[$key]['title']);
    }
    $url = Url::to(['slideshow-sort']);
    $ajaxOptions = Json::encode([
                'data' => ['order' => new JsExpression('$(this).sortable("toArray").toString()')],
                'type' => 'POST'
    ]);
    echo Html::tag('div', '', ['id' => 'response-order']);
    echo Sortable::widget([
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
