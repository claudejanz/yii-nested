<?php

namespace app\models;

use app\models\base\ReportingBase;
use DateTime;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Reporting extends ReportingBase
{

    public function behaviors()
    {
        return array(
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
        );
    }

    public function getMinutes()
    {
        $value = ($this->time) ? $this->time : $this->training->time;
        $parsed = date_parse($value);
        return $parsed['hour'] * 60 + $parsed['minute'] ;
    }
    public function getLoad(){
        return $this->minutes*$this->feeled_rpe;
    }
}
