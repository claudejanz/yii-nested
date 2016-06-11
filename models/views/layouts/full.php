<?php

use app\models\Place;
use app\widgets\PlaceDisplayWidget;
use claudejanz\toolbox\widgets\Alerts;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->beginContent('@app/views/layouts/main.php');
?>
<?= PlaceDisplayWidget::widget(array('place' => Place::PLACE_CONTENT_BEFORE)); ?>
<div class="contentmarginless">
    <div class="titlevar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <?= $this->render('/all/title') ?>
                    <?= Alerts::widget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $content ?>
<?= PlaceDisplayWidget::widget(array('place' => Place::PLACE_CONTENT_AFTER)); ?>


<?php
echo $this->endContent();
