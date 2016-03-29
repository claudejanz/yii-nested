<?php

namespace app\models;

use app\models\base\SubCategoryBase;
use claudejanz\toolbox\models\behaviors\MultilingualBehavior;
use claudejanz\toolbox\models\behaviors\MultilingualQuery;
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
             'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['langsNames'],
                'langClassName' => SubCategoryLang::className(), // or namespace/for/a/class/PostLang
                'langForeignKey' => 'sub_category_id',
                'attributes' => [
                    'title',
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