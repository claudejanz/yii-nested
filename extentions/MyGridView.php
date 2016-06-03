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

use kartik\grid\GridView;
use kartik\helpers\Html as Html2;
use Yii;
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
    public $floatHeader = false;
    public $dataColumnClass = 'app\extentions\MyDataColumn';
    public $addHeader = false;

    const TYPE_ACTIVE = 'black';

    public function init()
    {
        $this->panel = ArrayHelper::merge([
                    'heading'    => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i></h3>',
                    'type'       => self::TYPE_ACTIVE,
                    'before'     => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['users/create'], ['class' => 'btn btn-success', 'data-pjax' => 0]),
                    'after'      => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info', 'data-pjax' => 0]),
                    'showFooter' => false
                        ], $this->panel);
        parent::init();
    }

    public function renderTableHeader()
            {
        $cells = [];
        foreach ($this->columns as $index => $column) {
            /* @var DataColumn $column */
            if ($this->resizableColumns && $this->persistResize) {
                $column->headerOptions['data-resizable-column-id'] = "kv-col-{$index}";
            }
            $cells[] = $column->renderHeaderCell();
        }
        $content = Html::tag('tr', implode('', $cells), $this->headerRowOptions);
        if ($this->filterPosition == self::FILTER_POS_HEADER) {
            $content = $this->renderFilters() . $content;
        } elseif ($this->filterPosition == self::FILTER_POS_BODY) {
            $content .= $this->renderFilters();
        }
        $add = ($this->addHeader) ? $this->renderHeaderAdd() . "\n" : '';
        return "<thead>\n" .
                $add . "\n" .
                $this->generateRows($this->beforeHeader) . "\n" .
                $content . "\n" .
                $this->generateRows($this->afterHeader) . "\n" .
                "</thead>";
}

    public function renderHeaderAdd() {
        return Html::tag('tr', Html::tag('th', '', ['colspan' => 2])
                        . Html::tag('th', Yii::t('app', 'Contract'), ['colspan' => 2])
                        . Html::tag('th', Yii::t('app', 'Week'), ['colspan' => 31])
        );
    }

}
