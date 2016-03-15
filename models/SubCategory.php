<?php

namespace app\models;

use app\models\base\SubCategoryBase;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class SubCategory extends SubCategoryBase
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
    /**
     * Returns model display label
     * @param number $n
     * @return string
     */
    public static function getLabel($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Sub Category} other{Sub Categories}}', ['n' => $n]);
    }
}