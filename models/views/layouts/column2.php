<?php

use app\models\Place;
use app\widgets\PlaceDisplayWidget;
use claudejanz\toolbox\widgets\Alerts;
use yii\widgets\Breadcrumbs;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->beginContent('@app/views/layouts/main.php');
?>
<div class="content">
    <div class="container-fluid">
        <?php
        if(!Yii::$app->user->isGuest){
        echo Breadcrumbs::widget([
            'links' => Yii::$app->controller->page->breadcrumbs,
            'homeLink'=>false,
        ]);
        }
        ?>
        <?= $this->render('/all/title') ?>
        <?= Alerts::widget(); ?>
        <div class="row">
            <div class="col-sm-3">
                <?= PlaceDisplayWidget::widget(array('place' => Place::PLACE_LEFT)); ?>
            </div>
            <div class="col-sm-9">
                <?= PlaceDisplayWidget::widget(array('place' => Place::PLACE_CONTENT_BEFORE)); ?>
                <?= $content ?>
                <?= PlaceDisplayWidget::widget(array('place' => Place::PLACE_CONTENT_AFTER)); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->endContent();
