<?php

namespace app\models;

use app\models\base\SportBase;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Sport extends SportBase
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
    
    /**
     * Returns model display label
     * @param number $n
     * @return string
     */
    public static function getLabel($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Sport} other{Sports}}', ['n' => $n]);
    }

}
