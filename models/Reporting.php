<?php

namespace app\models;

use app\models\base\ReportingBase;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * 
 * @property string $duration
 */

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
    
     public function rules()
    {

        return array_merge([
            ['done','validateLoad'],
            ['done','default','value'=>0]
                ], parent::rules());
    }
    
            

    public function getMinutes()
    {
        $value = ($this->time) ? $this->time : $this->training->time;
        $parsed = date_parse($value);
        return $parsed['hour'] * 60 + $parsed['minute'] ;
    }
    public function getLoad(){
        return ($this->done)?$this->minutes*$this->feeled_rpe:null;
    }
    public function getDoneColor(){
        return ($this->done)?'green':'red';
    }
    public function validateLoad($attribute){
        if($this->$attribute){
            if(!$this->time){
                $this->addError('time', Yii::t('app', 'If training done you have to fill "{attribute}"',['attribute'=>  $this->getAttributeLabel('time')]));
            }
            if(!$this->feeled_rpe){
                $this->addError('feeled_rpe', Yii::t('app', 'If training done you have to fill "{attribute}"',['attribute'=>  $this->getAttributeLabel('feeled_rpe')]));
            }
            if(!$this->km){
                $this->addError('km', Yii::t('app', 'If training done you have to fill "{attribute}"',['attribute'=>  $this->getAttributeLabel('km')]));
            }
        }
    }
    public function getDuration()
    {
        $split = preg_split('@:@', $this->time, -1, PREG_SPLIT_NO_EMPTY);
        return sprintf('%1$01dh%2$02d', $split['0'], $split['1']);
    }
}
