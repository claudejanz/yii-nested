<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\extentions;

use kartik\base\Config;
use kartik\editable\Editable;
use kartik\helpers\Html;
use kartik\widgets\InputWidget;
use yii\helpers\ArrayHelper;

/**
 * Description of MyEditable
 *
 * @author Claude
 */
class MyEditable extends Editable
{

    /**
     * Sets the label for input
     * null for default label | false for no label | string for string
     * @var string|null|false 
     */
    public $renderLabel = false;

    /**
     * Renders the HTML 5 input
     *
     * @return string
     */
    protected function renderHtml5Input()
    {
        $type = ArrayHelper::remove($this->_inputOptions, 'type', 'text');
        $out = Html::input($type, $this->name, $this->value, $this->_inputOptions);
        if ($this->hasModel()) {
            if (isset($this->_form)) {
                return $this->_form
                                ->field($this->model, $this->attribute, $this->inputFieldConfig)
                                ->input($type, $this->_inputOptions)
                                ->label($this->renderLabel);
            }
            $out = Html::activeInput($this->type, $this->model, $this->attribute, $this->_inputOptions);
        }
        return Html::tag('div', $out, $this->inputContainerOptions);
    }

    /**
     * Renders a widget
     *
     * @param string $class the input widget class name
     *
     * @return string
     */
    protected function renderWidget($class)
    {
        if ($this->hasModel()) {
            if (isset($this->_form)) {
                return $this->_form
                                ->field($this->model, $this->attribute, $this->inputFieldConfig)
                                ->widget($class, $this->_inputOptions)
                                ->label($this->renderLabel);
            }
            $defaults = ['model' => $this->model, 'attribute' => $this->attribute];
        } else {
            $defaults = ['name' => $this->name, 'value' => $this->value];
        }
        $options = ArrayHelper::merge($this->_inputOptions, $defaults);
        /**
         * @var InputWidget $class
         */
        $field = $class::widget($options);
        return Html::tag('div', $field, $this->inputContainerOptions);
    }

    /**
     * Renders all other HTML inputs (except HTML5)
     *
     * @return string
     */
    protected function renderInput()
    {
        $list = Config::isDropdownInput($this->inputType);
        $input = $this->inputType;
        if ($this->hasModel()) {
            if (isset($this->_form)) {
                return $list ?
                        $this->_form
                                ->field($this->model, $this->attribute, $this->inputFieldConfig)
                                ->$input($this->data, $this->_inputOptions)
                                ->label($this->renderLabel) :
                        $this->_form
                                ->field($this->model, $this->attribute, $this->inputFieldConfig)
                                ->$input($this->_inputOptions)
                                ->label($this->renderLabel);
            }
            $input = 'active' . ucfirst($this->inputType);
        }
        $checked = false;
        if ($input == 'radio' || $input == 'checkbox') {
            $this->options['value'] = $this->value;
            $checked = ArrayHelper::remove($this->_inputOptions, 'checked', false);
        }
        if ($list) {
            $field = Html::$input($this->name, $this->value, $this->data, $this->_inputOptions);
        } else {
            $field = ($input == 'checkbox' || $input == 'radio') ?
                    Html::$input($this->name, $checked, $this->_inputOptions) :
                    Html::$input($this->name, $this->value, $this->_inputOptions);
        }
        return Html::tag('div', $field, $this->inputContainerOptions);
    }

}
