<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\extentions;

use app\models\behaviors\GraphTypeBehavior;
use kartik\helpers\Html;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;

/**
 * Description of MulaffGraphWidget
 *
 * @author Claude
 */
class MulaffGraphWidgetV2 extends Widget
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
    public $fontWidth = 18;

    /**
     * @var int Place taken by the font on height to calculate to the middle of the line
     */
    public $fontHeight = 15;

    /**
     * @var type Color must be on off COLOR constant
     */
    public $color;

    /**
     * @var int Value that separeats legends to graph.
     */
    private $fontToGraphWidth = 15;

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

    /**
     * @var int the width value returned by the 
     */
    private $matrixWidth;
    private $rightDivOptions = [];
    private $leftDivOptions = [];
    private $legendOptions = [];
    public $graphOptions = [];

    public function init()
    {
        parent::init();
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
        if (!isset($this->color) || !in_array($this->color, [self::COLOR_GRAY, self::COLOR_GRADIENT])) {
            $this->color = self::COLOR_GRADIENT;
        }
        Html::addCssStyle($this->options, 'display:inline-block');
        Html::addCssStyle($this->options, 'width:' . $this->width);


        if ($this->withLegends) {
            Html::addCssStyle($this->leftDivOptions, 'display:table-cell');
            Html::addCssStyle($this->leftDivOptions, 'min-width:' . $this->fontToGraphWidth . 'px');
            Html::addCssStyle($this->leftDivOptions, 'height:' . $this->height . 'px');

            Html::addCssStyle($this->rightDivOptions, 'display:table-cell');
            Html::addCssStyle($this->rightDivOptions, 'vertical-align: top;');
            Html::addCssStyle($this->rightDivOptions, 'width:100%');
            Html::addCssStyle($this->rightDivOptions, 'height:' . $this->height . 'px');
        } else {
            $this->fontHeight = 2;
        }

//        Html::addCssStyle($this->rightDivOptions, 'background-color:#00FF00');

        Html::addCssStyle($this->legendOptions, 'width:' . $this->fontToGraphWidth . 'px');
        Html::addCssStyle($this->legendOptions, 'height:' . $this->height . 'px');

        if ($this->hasModel()) {
            $this->value = $this->model->{$this->attribute};
        }

        $this->calaulateMatrix();
        $this->graphOptions = array_merge($this->graphOptions, [
            'viewBox' => '0 0 ' . $this->matrixWidth . ' ' . $this->height,
            'width' => '100%',
            'height' => $this->height,
            'preserveAspectRatio' => 'none'
        ]);



        if ($this->hasModel()) {
            $this->value = $this->model->{$this->attribute};
            if (isset($this->model->graph_type)) {
                $this->type = $this->model->graph_type;
            }
        }


//        $this->height = $this->matrixWidth*$this->ratio;
    }

    public function run()
    {
        if ($this->matrix) {

            echo Html::beginTag('div', $this->options);

            if ($this->withLegends)
                $this->renderLegends();

            echo Html::beginTag('div', $this->rightDivOptions);
            echo Html::beginTag('svg', $this->graphOptions);
            if ($this->color == self::COLOR_GRADIENT) {
                $this->renderGradDef();
            }
            if ($this->withLines) {
                $this->renderLines();
            }
            $this->renderGraph();
            echo Html::endTag('svg');
            echo Html::endTag('div');
            echo Html::endTag('div');
        }
    }

    protected function renderGraph()
    {
        $arr = $this->matrix;
        $step = 0;
        $bottom = $this->height + ($this->fontHeight / 2);
        $prevPoint = [$step, $bottom];
        foreach ($arr as $key => $m) {



            $w = $m[0];
            $h = $m[1] * $this->height;

            if ($this->type == GraphTypeBehavior::GRAPH_TYPE_HISTOGRAMME) {
                

                $points = $step . ',' . $bottom . ' ' . ($w + $step) . ',' . $bottom . ' ' . ($w + $step) . ',' . ($bottom - $h) . ' ' . $step . ',' . ($bottom - $h);
                echo Html::tag('polygon', null, ['fill'=>'url(#gardient_'.$this->id.')','points' => $points, 'class' => 'gradi', 'title' => $m[2] . ' / ' . $this->formatTime($m[3])]);
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
                echo Html::tag('path', null, ['d' => "M $x1 $y1 C $cx1 $cy1 $cx2 $cy2 $x2 $y2",'stroke'=>'url(#gardient_'.$this->id.')']);
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
        echo Html::beginTag('div', $this->leftDivOptions);
        echo Html::beginTag('svg', $this->legendOptions);
        $bottom = $this->height + ($this->fontHeight / 2);
        $fontHeigth = $this->fontHeight;
        for ($i = 1; $i < 6; $i++) {
            echo Html::tag('text', 'I' . $i, [
                'x' => 0,
                'y' => $bottom - ($i * 0.20 * $this->height) + ($fontHeigth / 2),
                'fill' => 'gray',
            ]);
        }
        echo Html::endTag('svg');
        echo Html::endTag('div');
    }

    protected function renderLines()
    {
        $bottom = $this->height + ($this->fontHeight / 2);
        $fontWidth = 0;
        for ($i = 1; $i < 6; $i++) {
            echo Html::tag('line', null, [
                'x1' => $fontWidth,
                'y1' => $bottom - ($i * 0.20 * $this->height),
                'x2' => $this->matrixWidth,
                'y2' => $bottom - ($i * 0.20 * $this->height),
                'style' => 'stroke:gray;stroke-width:0.3%',
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
    }

    public function renderGradDef() {
        echo Html::beginTag('defs');
        echo Html::beginTag('linearGradient',[
            'id'=>'gardient_'.$this->id,
            'gradientUnits'=>'userSpaceOnUse',
            'x1'=>'0%',
            'y1'=>'100%',
            'x2'=>'0%',
            'y2'=>'0%'
        ]);
        echo Html::tag('stop',null,['offset'=>'13.01%','style'=>'stop-color:#FAC413']);
        echo Html::tag('stop',null,['offset'=>'34.62%','style'=>'stop-color:#49B749']);
        echo Html::tag('stop',null,['offset'=>'56.24%','style'=>'stop-color:#1F9447']);
        echo Html::tag('stop',null,['offset'=>'76.24%','style'=>'stop-color:#F6901E']);
        echo Html::tag('stop',null,['offset'=>'100%','style'=>'stop-color:#ED1C24']);
        echo Html::endTag('linearGradient');
        echo Html::endTag('defs');
    }

}
