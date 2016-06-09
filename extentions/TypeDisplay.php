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

use kartik\helpers\Html as Html;
use Yii;
use yii\base\Widget;

/**
 * Description of TypeDisplay
 *
 * @author Claude
 */
class TypeDisplay extends Widget
{

    public $day;
    public $options = [];

    //put your code here
    public function init() {

        parent::init();
        Html::addCssClass($this->options, 'day-ribbon');
        echo Html::beginTag('div', $this->options);
        if ($this->day) {
            echo $this->day->publishedLabel;
        } else {
            echo Yii::t('app', 'Nothing done');
        }
}

    public function run() {

        echo Html::endTag('div');
        parent::run();

}

}
