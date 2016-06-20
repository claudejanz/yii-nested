<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\extentions;

use app\models\Day;
use app\models\Reporting;
use app\models\Sport;
use app\models\Week;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Description of MulaffGraphWidget
 *
 * @author Claude
 */
class MulaffWeekSportsWidget extends Widget
{

    /**
     * @var Week the data model that this widget is associated with.
     */
    public $model;

    public function init()
    {
        parent::init();
        if (!$this->model) {
            throw new InvalidConfigException(Yii::t('mulaff', "Must have 'model' to be specified."));
        }
        if (!$this->model instanceof Week) {
            throw new InvalidConfigException(Yii::t('mulaff', "'model' must be an instance of Week."));
        }



    }

    public function run()
    {
        $all = [];
        $hours = 0;
        $minutes = 0;
        $week = $this->model;
        foreach ($week->reportings as $key => $reporting) {
            /* @var $reporting Reporting */
            $split = preg_split('@:@', $reporting->time, -1, PREG_SPLIT_NO_EMPTY);
            if (count($split) > 1) {
                $hours += $split[0];
                $minutes += $split[1];
                if ($minutes >= 60) {
                    $hours +=floor($minutes / 60);
                    $minutes -= floor($minutes / 60) * 60;
                }
            }
            if (!isset($all[$reporting->training->sport->id])) {
                $all[$reporting->training->sport->id] = [
                    'km'    => 0,
                    'sport' => $reporting->training->sport,
                ];
            }
            $all[$reporting->training->sport->id]['km']+=$reporting->km;
        }
        
        if (!empty($all)) {
            echo Html::beginTag('div', ['class' => 'row']);
            foreach ($all as $row) {
                /* @var $sport Sport */
                $sport = $row['sport'];
                $km = $row['km'];
                echo Html::beginTag('div', ['class' => 'col-sm-4']);
                echo Html::img($sport->iconUrl, ['width' => '15', 'title' => $sport->title]);
//                echo ' - ';
//                echo $sport->title;
                echo ': ';
                echo $km . 'km';
                echo Html::endTag('div');
            }
            echo Html::endTag('div'); //row

            echo Html::tag('br');
        }else{
            echo Yii::t('app', 'No sports done this week.');
        }

        echo Html::beginTag('div', ['class' => 'row']);

        echo Html::beginTag('div', ['class' => 'col-sm-6']);
        $label = Yii::t('app', 'Trainings');
        echo Html::tag('h4', $label);
        echo Html::endTag('div');

        echo Html::beginTag('div', ['class' => 'col-sm-6']);
        $label = Yii::t('app', 'Reportings');
        echo Html::tag('h4', $label);
        echo Html::endTag('div');

        echo Html::endTag('div'); //row


        echo Html::beginTag('div', ['class' => 'row']);

        echo Html::beginTag('div', ['class' => 'col-sm-6']);
        $time = Yii::$app->formatter->asMyDuration($week->trainingsMinutes);
        echo Yii::t('app', 'Total time planned: {time}', ['time' => $time]);
        echo Html::endTag('div');

        echo Html::beginTag('div', ['class' => 'col-sm-6']);
        $time = Yii::$app->formatter->asMyDuration($week->reportingsMinutes);
        echo Yii::t('app', 'Total time made: {time}', ['time' => $time]);
        echo Html::endTag('div');

        echo Html::endTag('div'); //row

        echo Html::beginTag('div', ['class' => 'row']);

        echo Html::beginTag('div', ['class' => 'col-sm-6']);
        echo '';
        echo Html::endTag('div');

        echo Html::beginTag('div', ['class' => 'col-sm-6']);
        echo Yii::t('app', 'Total distance made: {km}km', ['km' => $week->reportingsKm]);
        echo Html::endTag('div');

        echo Html::endTag('div'); //row

    }

}
