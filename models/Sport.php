<?php

namespace app\models;

use app\models\base\SportBase;
use claudejanz\toolbox\models\behaviors\MultilingualBehavior;
use claudejanz\toolbox\models\behaviors\MultilingualQuery;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\FileHelper;



class Sport extends SportBase
{

    private static $_iconlist;

    public function behaviors()
    {
        return array(
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['langsNames'],
                'langClassName' => SportLang::className(), // or namespace/for/a/class/PostLang
                'langForeignKey' => 'sport_id',
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
        return Yii::t('app', '{n, plural, =1{Sport} other{Sports}}', ['n' => $n]);
    }

    public static function getIconOptions()
    {
        if (empty(self::$_iconlist)) {
            $dir = Yii::getAlias('@webroot/images/icons');
            $files = FileHelper::findFiles($dir);
            $web = Yii::getAlias('@web/images/icons');
            foreach ($files as $key => $file) {
                $arr = preg_split('@[\\\\./]@', $file, -1, PREG_SPLIT_NO_EMPTY);
                if ($arr[count($arr) - 1] == 'svg') {
                    $key = $arr[count($arr) - 2];
                    self::$_iconlist[$key]=$web.'/'.$key.'.svg';
                }
            }
        }
        return self::$_iconlist;
    }

    public function getIconUrl(){
         return Yii::getAlias('@web/images/icons').'/'.$this->icon.'.svg';
    }
}
