<?php

namespace app\models;

use app\models\base\ElementTextLangBase;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class ElementTextLang extends ElementTextLangBase
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
}