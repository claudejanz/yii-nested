<?php

namespace app\models;

use app\models\base\ElementTextBase;
use claudejanz\toolbox\models\behaviors\MultilingualBehavior;
use claudejanz\toolbox\models\behaviors\MultilingualQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class ElementText extends ElementTextBase
{
    public function behaviors() {
        return array(
            
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['langsNames'],
                'langClassName' => ElementTextLang::className(), // or namespace/for/a/class/PostLang
                'langForeignKey' => 'element_text_id',
                'attributes' => [
                    'content',
                    
                ]
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
    
    public static function find() {
        $q = new MultilingualQuery(get_called_class());
//        $q->orderBy('weight');
        $q->localised();
        return $q;
    }
}