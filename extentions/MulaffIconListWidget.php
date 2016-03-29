<?php

/*
 * Copyright (C) 2016 Claude
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace app\extentions;

use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Description of MulaffIconListWidget
 *
 * @author Claude
 */
class MulaffIconListWidget extends InputWidget
{

    public $items;

    public function run()
    {
        parent::run();
        
            echo Html::activeRadioList($this->model, $this->attribute,$this->items,['item'=>array($this,'getItem'),'unselect'=>null]);
    }
    public function getItem($index, $label, $name, $checked, $value){
//        echo var_dump($index, $label, $name, $checked, $value);
        echo \kartik\helpers\Html::radio($name, $checked,['value'=>$value]).Html::img($label,['width'=>25]);
    }

}
