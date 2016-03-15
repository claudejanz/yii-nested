<?php

namespace app\models;

use app\models\base\ElementSlideshowImageBase;
use claudejanz\multilingual\MultilingualBehavior;
use claudejanz\toolbox\models\behaviors\RelatedBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

class ElementSlideshowImage extends ElementSlideshowImageBase {

    public function behaviors() {
        return array(
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['langsNames'],
                'langClassName' => ElementSlideshowImageLang::className(), // or namespace/for/a/class/PostLang
                'langForeignKey' => 'element_slideshow_image_id',
                'attributes' => [
                    'title',
                ]
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'relation' => [
                'class' => RelatedBehavior::className(),
            ]
        );
    }

    public static function find() {
        $q = new ActiveQuery(get_called_class());
        $q->orderBy('weight');
        return $q;
    }

    public function getSrc() {
        return $this->url;
    }

}
