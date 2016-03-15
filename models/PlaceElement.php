<?php

namespace app\models;

use app\models\base\PlaceElementBase;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class PlaceElement extends PlaceElementBase
{
    public function behaviors() {
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
}
