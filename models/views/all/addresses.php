<?php

use app\models\Address;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* @var $models Address */

    foreach ($models as $model) {
        echo $this->render('/addresses/view',['model'=>$model]);
    }