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

use app\extentions\helpers\EuroDateTime;
use DateTime;
use kartik\grid\DataColumn;
use kartik\helpers\Html;
use Yii;

/**
 * Description of MyDataColumn
 *
 * @author Claude
 */
class MyDataColumn extends DataColumn
{

    /**
     *
     * @var DateTime
     */
    public $dateTime;

    
    public static $hasADayBeenDisplayed = false;
    /**
     * Renders the filter.
     * @return string the rendering result.
     */
    public function renderHeaderCell()
    {
        if (!isset($this->dateTime)) {
            return parent::renderHeaderCell();
        }
        $date = new EuroDateTime($this->dateTime->format('Y-m-d'));
        if (Yii::$app->formatter->asDate($this->dateTime, 'e') == 1 || !self::$hasADayBeenDisplayed) {
            $this->dateTime->format('d');
            $colspan= ( !self::$hasADayBeenDisplayed)?7-Yii::$app->formatter->asDate($this->dateTime, 'e')+1:7;
            self::$hasADayBeenDisplayed = true;
            return Html::tag('th', Yii::t('app', 'Week {n}', ['n' => $this->dateTime->format('W')]), ['colspan' => $colspan]);
        }
        return '';
    }

    /**
     * Renders the filter.
     * @return string the rendering result.
     */
    public function renderFilterCell()
    {
        if (!isset($this->dateTime)) {
            return parent::renderFilterCell();
        }
        return Html::tag('td', strtoupper(Yii::$app->formatter->asDate($this->dateTime,'d\'<br>\'EEEEE')));
    }

}
