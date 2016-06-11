<?php

use app\extentions\helpers\MyPjax;
use app\models\Sport;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $models Sport[] */

?>
<div class="sport-index">
        <?php
        echo Html::beginTag('ul',['class'=>'sport']);
        MyPjax::begin(['id' => 'sports']);
        foreach ($models as $model) {
            echo $this->render('order/_sport', [
                'model' => $model,
            ]);
        }
        echo AjaxModalButton::widget([
            'label' => Icon::show('plus'),
            'encodeLabel' => false,
            'url' => [
                'item-add',
            ],
            'title' => Yii::t('app', 'Add Sport'),
            'success' => '#sports' ,
            'options' => [
                'title' => Yii::t('app', 'Add Sport'),
            ],
        ]);
       
        MyPjax::end();
        Html::endTag('ul');
        ?>
</div>