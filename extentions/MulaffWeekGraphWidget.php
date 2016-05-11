<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\extentions;

use app\models\Week;
use DateInterval;
use DatePeriod;
use DateTime;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Description of MulaffGraphWidget
 *
 * @author Claude
 */
class MulaffWeekGraphWidget extends Widget
{

    /**
     * @var Week the data model that this widget is associated with.
     */
    public $model;

    /**
     * @var int the width of the graph
     */
    public $width;

    /**
     * @var int the height of the graph
     */
    public $height;

    /**
     * @var int the options for the svg tag
     */
    public $options = [];

    /**
     * @var int the width value returned by the 
     */
    private $values;
    private $matrix;
    private $matrixWidth;
    private $maxHeight;
    private $gap = 1;
    private $colWidth = 5;

    public function init()
    {
        parent::init();
        if (!$this->model) {
            throw new InvalidConfigException(Yii::t('mulaff', "Must have 'model' to be specified."));
        }
        if (!$this->model instanceof Week) {
            throw new InvalidConfigException(Yii::t('mulaff', "'model' must be an instance of Week."));
        }
        if (!isset($this->height)) {
            throw new InvalidConfigException(Yii::t('mulaff', 'The attribute "{attribute}" must be set in class "{class}"', ['attribute' => 'height', 'class' => __CLASS__]));
        }
        $this->values = $this->model->getLoadsByDate();
        $this->calaulateMatrix();



        $this->options = array_merge($this->options, [
            'width' => '100%',
            'height' => $this->height,
            'viewBox' => '0 0 ' . $this->matrixWidth . ' ' . $this->height,
            'preserveAspectRatio' => 'none'
        ]);
    }

    public function run()
    {
        echo Html::beginTag('svg', $this->options);
        $this->renderGraph();
        echo Html::endTag('svg');
        $this->renderLegends();
    }

    protected function renderGraph()
    {
        $step = 0;
        $bottom = $this->height;
        $r = $this->height/$this->maxHeight;
        foreach ($this->matrix as $m) {
            $w = $m[0];
            $h = $m[1]*$r;




            $points = $step . ',' . $bottom . ' ' . ($w + $step) . ',' . $bottom . ' ' . ($w + $step) . ',' . ($bottom - $h) . ' ' . $step . ',' . ($bottom - $h);
            echo Html::tag('polygon', null, ['points' => $points, 'class' => 'gradi', 'title' => $m[2] . ' - ' . $h]);

            $step+=$w + $this->gap;
        }
    }

    protected function formatTime($val)
    {
        $str = (string) $val;
        $val = (float) $val;
        if ($val < 1) {
            return ($val * 100) . '\'\'';
        }
        $str = preg_replace('@\.@', '\' ', $str);
        return $str . ((intval($val) != $val) ? '\'\'' : '\'');
    }

    protected function calaulateMatrix()
    {
        /* @var $week Week */
        $week = $this->model;
        $startDate = new DateTime($week->date_begin);
        $endDate = clone $startDate;
        $endDate->modify('+7days');
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($startDate, $interval, $endDate);
        $step = 0;
        $maxHeight = 0;
        $matrix = [];
        $w = $this->colWidth;
        foreach ($period as $dateTime) {
            $date = $dateTime->format('Y-m-d');
            $h = (isset($this->values[$date])) ? $this->values[$date] : 0;
            if ($h > $this->maxHeight) {
                $this->maxHeight = $h;
            }
            $matrix[] = [$w, $h, Yii::$app->formatter->asDate($dateTime, 'short')];
            $step+=$w + $this->gap;
        }
        $this->matrixWidth = $step - $this->gap;
        $this->matrix = $matrix;
    }

    public function renderLegends()
    {
        $options = [];
        $optionsCol = [];
        $optionsSep = [];
        $colW = (100 / $this->matrixWidth) * $this->colWidth;
        $sepW = (100 / $this->matrixWidth) * $this->gap;
        // styles
        echo Html::addCssClass($options, 'legends');
        echo Html::addCssClass($optionsCol, 'overflow');
        echo Html::addCssStyle($optionsCol, 'float:left');
        echo Html::addCssStyle($optionsCol, 'float:left');
        echo Html::addCssStyle($optionsCol, 'width:' . $colW . '%');
        echo Html::addCssStyle($optionsCol, 'text-align:center');
        echo Html::addCssStyle($optionsSep, 'float:left');
        echo Html::addCssStyle($optionsSep, 'width:' . $sepW . '%');
        // render;
        echo Html::beginTag('div', $options);
        foreach ($this->matrix as $key => $m) {
            if ($key != 0) {
                echo Html::tag('div', '&nbsp;', $optionsSep);
            }
            echo Html::tag('div', $m[1] . '<br>' . $m[2], $optionsCol);
        }
        echo Html::endTag('div');
    }

}
