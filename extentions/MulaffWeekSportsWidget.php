<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\extentions;

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
        foreach ($this->model->reportings as $key => $reporting) {
            /* @var $reporting Reporting */
            if(!isset($all[$reporting->sport_id])){
               $all[$reporting->sport_id]=[
                   'km'=>0,
                   'sport'=>$reporting->sport,
               ] ;
            }
            $all[$reporting->sport_id]['km']+=$reporting->km;
            
        }
        foreach ($all as $row) {
            /* @var $sport Sport */
            $sport = $row['sport'];
            $km = $row['km'];
            echo Html::beginTag('div',['class'=>'sports-mini']);
            echo Html::img($sport->iconUrl,['width'=>'20']);
            echo Html::endTag('div');
            echo $sport->title.': '.$km.'km<br>';
            
        }
    }

   
}
