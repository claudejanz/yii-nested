<?php

namespace app\models;

use app\models\base\TrainingTypeBase;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class TrainingType extends TrainingTypeBase
{
     public function behaviors()
    {
        return array(
            'publish' => [
                'class' => PublishBehavior::className(),
            ],
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
            ['published', 'default', 'value' => PublishBehavior::PUBLISHED_ACTIF],
                ], parent::rules());
    }
    
    public function getDuration(){
        $split =  preg_split('@:@', $this->time, -1, PREG_SPLIT_NO_EMPTY);
        return sprintf('%1$01dh%2$02d', $split['0'], $split['1']);;
    }
    public function getShortTitle(){
        return substr($this->title, 0, 25).'...';
    }
}