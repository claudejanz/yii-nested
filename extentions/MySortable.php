<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\extentions;

use yii\jui\Sortable;

/**
 * Description of MySortable
 *
 * @author Claude
 */
class MySortable extends Sortable
{

    public function run()
    {
        parent::run();
        $this->registerWidget('mouse');
        MySortableAsset::register($this->getView());
    }

}
