<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\extentions;

use app\models\behaviors\GraphTypeBehavior;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Description of MulaffGraphWidget
 *
 * @author Claude
 */
class MulaffGraphWidget extends Widget
{

    /**
     * @var Model the data model that this widget is associated with.
     */
    public $model;

    /**
     * @var string the model attribute that this widget is associated with.
     */
    public $attribute;

    /**
     * @var string the value to convert into graph.
     */
    public $value;

    /**
     * @var int the width of the graph
     */
    public $width;

    /**
     * @var int type of graph
     */
    public $type;

    /**
     * @var int the height of the graph
     */
    public $height;
    public $withLegends = false;
    public $withLines = false;

    /**
     * @var int the options for the svg tag
     */
    public $options = [];

    /**
     * @var int Place taken by the font before graph begin
     */
    public $fontWidth = 15;

    /**
     * @var int Place taken by the font on height to calculate to the middle of the line
     */
    public $fontHeight = 10;

    /**
     * @var type Color must be on off COLOR constant
     */
    public $color;

    /**
     * @var int Value that separeats legends to graph.
     */
    private $fontToGraphWidth = 10;

    /**
     * @var array The matrix for caluculations
     */
    private $matrix = [];
    private $color1 = '#FCC40B';
    private $color2 = '#3FC344';
    private $color3 = '#1f9445';
    private $color4 = '#f68e12';
    private $color5 = '#f60100';

    const COLOR_GRAY = 1;
    const COLOR_GRADIENT = 2;
    const COLOR_RAINBOW = 3;

    /**
     * @var int the width value returned by the 
     */
    private $matrixWidth;
    private $ratiox;
    private $ratioy;

    public function init()
    {
        if ($this->value === null && !$this->hasModel()) {
            throw new InvalidConfigException(Yii::t('mulaff', "Either 'value', or 'model' and 'attribute' properties must be specified."));
        }
        if (!isset($this->width)) {
            throw new InvalidConfigException(Yii::t('mulaff', 'The attribute "{attribute}" must be set in class "{class}"', ['attribute' => 'width', 'class' => __CLASS__]));
        }
        if (!isset($this->height)) {
            throw new InvalidConfigException(Yii::t('mulaff', 'The attribute "{attribute}" must be set in class "{class}"', ['attribute' => 'height', 'class' => __CLASS__]));
        }
        if (!isset($this->type)) {
            $this->type = GraphTypeBehavior::GRAPH_TYPE_HISTOGRAMME;
        }
        if (!isset($this->color) || !in_array($this->color, [self::COLOR_GRAY, self::COLOR_GRADIENT, self::COLOR_RAINBOW])) {
            $this->color = self::COLOR_GRAY;
        }

        $this->options = array_merge($this->options, [
            'width' => $this->width,
            'height' => $this->height,
        ]);

        if ($this->hasModel()) {
            $this->value = $this->model->{$this->attribute};
        }

        parent::init();
    }

    public function run()
    {
        echo Html::beginTag('svg', $this->options);
        $this->calaulateMatrix();
        switch ($this->color) {
            case self::COLOR_GRADIENT:
                echo Html::beginTag('defs');
                echo Html::beginTag('linearGradient', ['id' => 'grad2', 'x1' => '0%', 'y1' => '100%', 'x2' => '0%', 'y2' => '0%']);
                echo Html::beginTag('stop', ['offset' => '0%', 'style' => 'stop-color:' . $this->color1 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '50%', 'style' => 'stop-color:' . $this->color1 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '100%', 'style' => 'stop-color:' . $this->color2 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::endTag('linearGradient');
                echo Html::beginTag('linearGradient', ['id' => 'grad3', 'x1' => '0%', 'y1' => '100%', 'x2' => '0%', 'y2' => '0%']);
                echo Html::beginTag('stop', ['offset' => '0%', 'style' => 'stop-color:' . $this->color1 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '33.33%', 'style' => 'stop-color:' . $this->color1 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '66.66%', 'style' => 'stop-color:' . $this->color2 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '100%', 'style' => 'stop-color:' . $this->color3 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::endTag('linearGradient');
                echo Html::beginTag('linearGradient', ['id' => 'grad4', 'x1' => '0%', 'y1' => '100%', 'x2' => '0%', 'y2' => '0%']);
                echo Html::beginTag('stop', ['offset' => '0%', 'style' => 'stop-color:' . $this->color1 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '25%', 'style' => 'stop-color:' . $this->color1 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '50%', 'style' => 'stop-color:' . $this->color2 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '75%', 'style' => 'stop-color:' . $this->color3 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '100%', 'style' => 'stop-color:' . $this->color4 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::endTag('linearGradient');
                echo Html::beginTag('linearGradient', ['id' => 'grad5', 'x1' => '0%', 'y1' => '100%', 'x2' => '0%', 'y2' => '0%']);
                echo Html::beginTag('stop', ['offset' => '0%', 'style' => 'stop-color:' . $this->color1 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '20%', 'style' => 'stop-color:' . $this->color1 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '40%', 'style' => 'stop-color:' . $this->color2 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '60%', 'style' => 'stop-color:' . $this->color3 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '80%', 'style' => 'stop-color:' . $this->color4 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::beginTag('stop', ['offset' => '100%', 'style' => 'stop-color:' . $this->color5 . ';stop-opacity:1']);
                echo Html::endTag('stop');
                echo Html::endTag('linearGradient');
                echo Html::endTag('defs');
                break;
        }
        if ($this->withLegends)
            $this->renderLegends();
        if ($this->withLines)
            $this->renderLines();
        $this->renderGraph();
        echo Html::endTag('svg');
    }

    protected function renderGraph()
    {
        $arr = $this->matrix;
        $step = ($this->withLegends) ? $this->fontWidth + $this->fontToGraphWidth : 0;
        $bottom = $this->height;
        $prevPoint = [$step, $bottom];
        foreach ($arr as $key => $m) {



            $w = $m[0] * $this->ratiox;
            $h = $m[1] * $this->ratioy;

            if ($this->type == GraphTypeBehavior::GRAPH_TYPE_HISTOGRAMME) {
                switch ($this->color) {
                    case self::COLOR_GRAY:
                        switch ($m[1]) {
                            case 1:
                                $style = 'fill:rgb(0,0,0)';
                                break;
                            case 0.8:
                                $style = 'fill:rgb(50,50,50)';
                                break;
                            case 0.6:
                                $style = 'fill:rgb(100,100,100)';
                                break;
                            case 0.4:
                                $style = 'fill:rgb(150,150,150)';
                                break;
                            case 0.2:
                                $style = 'fill:rgb(200,200,200)';
                                break;
                        }
                        break;
                    case self::COLOR_GRADIENT:
                        switch ($m[1]) {
                            case 1:
                                $style = 'fill:url(#grad5)';
                                break;
                            case 0.8:
                                $style = 'fill:url(#grad4)';
                                break;
                            case 0.6:
                                $style = 'fill:url(#grad3)';
                                break;
                            case 0.4:
                                $style = 'fill:url(#grad2)';
                                break;
                            case 0.2:
                                $style = 'fill:'.$this->color1;
                                break;
                        }
                        break;
                    case self::COLOR_RAINBOW:
                        switch ($m[1]) {
                            case 1:
                                $style = 'fill:'.$this->color5;
                                break;
                            case 0.8:
                                $style = 'fill:'.$this->color4;
                                break;
                            case 0.6:
                                $style = 'fill:'.$this->color3;
                                break;
                            case 0.4:
                                $style = 'fill:'.$this->color2;
                                break;
                            case 0.2:
                                $style = 'fill:'.$this->color1;
                                break;
                        }
                        break;
                }

                $points = $step . ',' . $bottom . ' ' . ($w + $step) . ',' . $bottom . ' ' . ($w + $step) . ',' . ($bottom - $h) . ' ' . $step . ',' . ($bottom - $h);
                echo Html::tag('polygon', null, ['points' => $points, 'class' => 'gradi', 'title' => $m[2] . ' / ' . $this->formatTime($m[3])]);
            } else {
                $x1 = $prevPoint[0];
                $y1 = $prevPoint[1];
                if ($key == 0) {
                    $y1 = $bottom - $h;
                }
                $x2 = $w + $step;
                $y2 = $bottom - $h;
                $cx1 = ($x2 + $x1) / 2;
                $cy1 = $y1;
                $cx2 = ($x2 + $x1) / 2;
                $cy2 = $y2;
                $prevPoint = [$x2, $y2];
                echo Html::tag('path', null, ['d' => "M $x1 $y1 C $cx1 $cy1 $cx2 $cy2 $x2 $y2", 'stroke' => "black", 'stroke-width' => 3, 'fill' => 'none']);
            }
            $step+=$w;
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

    protected function renderLegends()
    {
        $bottom = $this->height;
        $fontHeigth = $this->fontHeight;
        for ($i = 1; $i < 6; $i++) {
            echo Html::tag('text', 'I' . $i, [
                'x' => 0,
                'y' => $bottom - ($i * 0.20 * $this->ratioy) + $fontHeigth / 2,
                'fill' => 'gray',
            ]);
        }
    }

    protected function renderLines()
    {
        $bottom = $this->height;
        $fontWidth = ($this->withLegends) ? $this->fontWidth : 0;
        for ($i = 1; $i < 6; $i++) {
            echo Html::tag('line', null, [
                'x1' => $fontWidth,
                'y1' => $bottom - ($i * 0.20 * $this->ratioy),
                'x2' => $this->width,
                'y2' => $bottom - ($i * 0.20 * $this->ratioy),
                'style' => 'stroke:gray;stroke-width:1',
            ]);
        }
    }

    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }

    protected function calaulateMatrix()
    {
        $arr = preg_split('@/@', $this->value, -1, PREG_SPLIT_NO_EMPTY);
        $step = 0;
        $matrix = [];

        foreach ($arr as $value) {
            $vals = preg_split('@X@', $value, -1, PREG_SPLIT_NO_EMPTY);

            switch ($vals[0]) {
                case'I5':
                    $h = 1;
                    break;
                case'I4':
                    $h = 0.8;
                    break;
                case'I3':
                    $h = 0.6;
                    break;
                case'I2':
                    $h = 0.4;
                    break;
                case'I1':
                    $h = 0.2;
                    break;
            }
            $w = ($vals[1] > 1) ? $vals[1] : 1;
            $matrix[] = [$w, $h, $vals[0], $vals[1]];
            $step+=$w;
        }
        $this->matrixWidth = $step;
        $this->matrix = $matrix;
        if (!$step) {
            $step = 1;
        }
        $this->ratiox = ($this->withLegends) ? ($this->width - ($this->fontWidth + $this->fontToGraphWidth)) / $step : $this->width / $step;
        $this->ratioy = ($this->withLegends) ? $this->height - $this->fontHeight : $this->height;
    }

}
