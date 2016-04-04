<?php

namespace app\models;

use app\models\base\TrainingTypeBase;
use claudejanz\toolbox\models\behaviors\MultilingualBehavior;
use claudejanz\toolbox\models\behaviors\MultilingualQuery;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class TrainingType extends TrainingTypeBase
{
     public function behaviors()
    {
        return array(
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['langsNames'],
                'langClassName' => TrainingTypeLang::className(), // or namespace/for/a/class/PostLang
                'langForeignKey' => 'training_type_id',
                'attributes' => [
                    'title',
                    'explanation',
                    'extra_comment',
                ]
            ],
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
    public static function find()
    {
        $q = new MultilingualQuery(get_called_class());
        $q->localised();
        return $q;
    }
    
    public function getDuration(){
        $split =  preg_split('@:@', $this->time, -1, PREG_SPLIT_NO_EMPTY);
        return sprintf('%1$01dh%2$02d', $split['0'], $split['1']);;
    }
    public function getShortTitle(){
        return substr($this->title, 0, 25).'...';
    }
    
    
}