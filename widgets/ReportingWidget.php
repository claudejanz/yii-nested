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

namespace app\widgets;

use app\models\Training;
use app\models\User;
use claudejanz\toolbox\widgets\ajax\AjaxButton;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Description of DoneDisplayWidget
 *
 * @author Claude
 */
class ReportingWidget extends Widget
{

    /**
     * @var Training the data model that this widget is associated with.
     * 
     */
    public $model;

    /**
     * @var User the data model that this widget is associated with.
     * 
     */
    public $user;

    /**
     * @var string the model attribute that this widget is associated with.
     */
    public $attribute;

    /**
     * @var array the HTML attributes for the input tag.
     * @see Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'mini-reporting'];

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        if (!$this->hasModel()) {
            throw new InvalidConfigException("'model' and 'attribute' properties must be specified.");
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        parent::init();
    }

    public function run()
    {
        echo Html::beginTag('div', $this->options);

        echo $this->renderDone();

        if ($this->model->reporting && $this->model->reporting->done) {

            // Training KM
            if ($this->model->reporting->km) {

                echo $this->renderKm();
            }

            // Training Feeled Rpe
            if ($this->model->reporting->feeled_rpe) {

                echo $this->renderFeeledRpe();
            }
            // Training Load
            if ($this->model->reporting->getLoad()) {
                echo $this->renderLoad();
            }
            // Training time
            echo $this->renderTime();
        }

        echo $this->renderEdit();

        echo Html::endTag('div');
    }

    /**
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }

    protected function renderEdit()
    {
        return $this->renderModify();
//                ' ' .
//                $this->renderDelete();
    }

    protected function renderKm()
    {
        $return = Yii::t('app', 'Training Km: ');
        $label = '';
        $options = [];
        if ($this->model->reporting) {
            $label = $this->model->reporting->km . ' km';
            $return .= Html::Tag('span', $label, $options);
        }
        $return .= Html::tag('br');
        return $return;
    }

    protected function renderFeeledRpe()
    {
        $return = Yii::t('app', 'Training RPE: ');
        $label = '';
        $options = [];
        if ($this->model->reporting) {
            $label = $this->model->reporting->feeled_rpe . ' rpe';
            $return .= Html::Tag('span', $label, $options);
        }
        $return .= Html::tag('br');
        return $return;
    }

    protected function renderLoad()
    {

        $return = Yii::t('app', 'Training Load: ');
        $label = '';
        $options = [];
        if ($this->model->reporting) {
            $label = $this->model->reporting->load . ' ';
            $return .= Html::Tag('span', $label, $options);
        }
        $return .= Html::tag('br');
        return $return;
    }

    protected function renderTime()
    {
        $return = Yii::t('app', 'Training Time: ');
        $label = '';
        $options = [];
        if ($this->model->reporting) {
            $label = $this->model->reporting->duration . ' ';
            $return .= Html::Tag('span', $label, $options);
        }
        $return .= Html::tag('br');
        return $return;
    }

    protected function renderDone()
    {
        // Training Done
        $return = Yii::t('app', 'Training Done: ');
        $label = '';
        $options = [];
        if ($this->model->reporting) {
            Html::addCssClass($options, $this->model->reporting->getDoneColor() . '-border');
            $label = Yii::$app->formatter->asBoolean($this->model->reporting->done);
        } else {
            Html::addCssClass($options, 'blue-border');
            $label = Yii::t('app', 'No Report');
        }
        $return .= Html::Tag('span', $label, $options);
        $return .= Html::tag('br');
        return $return;
    }

    public function renderModify()
    {
        $model = $this->model;
        $user = $this->user;
        return AjaxModalButton::widget([
                    'label'       => Yii::t('app', 'Update Feedback'),
                    'encodeLabel' => false,
                    'url'         => [
                        'reporting-update',
                        'id'          => $user->id,
                        'training_id' => $model->id
                    ],
                    'title'       => Yii::t('app', 'Update report: {title}', ['title' => $model->title]),
                    'success'     => '#week' . date('Y-m-d',strtotime($model->week->date_begin)),
                    'options'     => [
                        'class' => 'red-btn',
                    ],
        ]);
    }

    public function renderDelete()
    {
        $model = $this->model;
        $user = $this->user;
        return AjaxButton::widget([
                    'label'       => Yii::t('app', 'Delete Feedback'),
                    'encodeLabel' => false,
                    'url'         => [
                        'reporting-update',
                        'id'          => $user->id,
                        'training_id' => $model->id
                    ],
//                    'title'       => Yii::t('app', 'Update report: {title}', ['title' => $model->title]),
                    'success'     =>'#week' . date('Y-m-d',strtotime($model->week->date_begin)),
                    'options'     => [
                        'class' => 'red-btn',
                    ],
        ]);
    }

}
