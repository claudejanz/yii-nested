<?php

namespace app\models;

use app\models\base\PageLangBase;
use claudejanz\toolbox\models\behaviors\AutoSlugBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


class PageLang extends PageLangBase
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
            'autoSlug' => [
                'class' => AutoSlugBehavior::className(),
                'addLanguage' => true,
            ],
        );
    }
}