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

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Description of MyGridView
 *
 * @author Claude
 */
class MyGridView extends GridView
{

    public $responsive = true;
    public $hover = true;
    public $condensed = true;
    public $floatHeader = true;
    
    public $dataColumnClass = 'app\extentions\MyDataColumn';

    const TYPE_ACTIVE = 'black';

    public function init()
    {
        $this->panel = ArrayHelper::merge($this->panel, [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i></h3>',
                    'type' => self::TYPE_ACTIVE,
                    'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['users/create'], ['class' => 'btn btn-success', 'data-pjax' => 0]),
                    'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info', 'data-pjax' => 0]),
                    'showFooter' => false
        ]);
        parent::init();
    }

   

}
