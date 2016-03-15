<?php

namespace app\models;

use app\models\base\ElementBase;
use claudejanz\toolbox\models\behaviors\CssClassBehavior;
use claudejanz\toolbox\models\behaviors\MultilingualBehavior;
use claudejanz\toolbox\models\behaviors\MultilingualQuery;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use claudejanz\toolbox\models\behaviors\RelatedBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "element".
 *
 * @property ElementText $elementText
 * @property ElementSlideshow $elementSlideshow
 * @property Place[] $places
 * @property ElementSlideshowImage[] $elementSlideshowImage
 * @property string $typeLabel
 */
class Element extends ElementBase
{

    public function behaviors()
    {
        return array(
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['langsNames'],
                'langClassName' => ElementLang::className(), // or namespace/for/a/class/PostLang
                'langForeignKey' => 'element_id',
                'attributes' => [
                    'title',
                ]
            ],
            'publish' => [
                'class' => PublishBehavior::className(),
            ],
            'cssClass' => [
                'class' => CssClassBehavior::className(),
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

    public static function find()
    {
        $q = new MultilingualQuery(get_called_class());
        $q->orderBy('weight');
        $q->localised();
        return $q;
    }

    const TYPE_RELATED_MENU = 2;
    const TYPE_TEXT = 3;
    const TYPE_SPLASH = 4;
    const TYPE_SLIDESHOW = 5;
    const TYPE_MULTITEXT = 6;
    const TYPE_TITLETEXT = 7;

    /**
     * @return array type names indexed by type IDs
     */
    public static function getTypeOptions()
    {
        return array(
            self::TYPE_RELATED_MENU => Yii::t('core', 'Related Menu'),
            self::TYPE_TEXT => Yii::t('core', 'Text'),
            self::TYPE_SPLASH => Yii::t('core', 'Splash'),
            self::TYPE_SLIDESHOW => Yii::t('core', 'Slideshow'),
            self::TYPE_MULTITEXT => Yii::t('core', 'Multi Text'),
            self::TYPE_TITLETEXT => Yii::t('core', 'Title Text'),
        );
    }

    /**
     * @return array type names indexed by type IDs
     */
    public static function getTypeValueOptions()
    {
        return array(
            self::TYPE_RELATED_MENU => 'related-menu',
            self::TYPE_TEXT => 'text',
            self::TYPE_SPLASH => 'splash',
            self::TYPE_SLIDESHOW => 'slideshow',
            self::TYPE_MULTITEXT => 'multi-text',
            self::TYPE_TITLETEXT => 'title-text',
        );
    }

    /**
     * Returns display type label
     * @return string display text for the current Type
     */
    public function getTypeLabel()
    {
        $options = self::getTypeOptions();
        return isset($options[$this->type]) ? $options[$this->type] : "unknown type ($this->type)";
    }

    /**
     * Returns display type label
     * @return string display text for the current Type
     */
    public function getTypeValue()
    {
        $options = self::getTypeValueOptions();
        return isset($options[$this->type]) ? $options[$this->type] : "unknown type ($this->type)";
    }

    /**
     * Returns data for dropDownList
     * @return string display text for the current Type
     */
//    public function getPlaceOptions()
//    {
//        return ArrayHelper::map(Place::find()->with('layout')->all(), 'id',  'title');
//    }

    /**
     * Returns model display label
     * @param number $n
     * @return string
     */
    public static function getLabel($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Element} other{Elements}}', ['n' => $n]);
    }

    /**
     * Relations definition
     * @return ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasMany(Place::className(), ['id' => 'place_id'])->via('placeElements');
    }

    /**
     * Relations definition
     * @return ActiveQuery
     */
    public function getElementImage()
    {
        return $this->hasOne(ElementImage::className(), ['element_id' => 'id']);
    }

    /**
     * Relations definition
     * @return ActiveQuery
     */
    public function getElementText()
    {
        return $this->hasOne(ElementText::className(), ['element_id' => 'id']);
    }

    /**
     * Relations definition
     * @return ActiveQuery
     */
    public function getElementSlideshow()
    {
        return $this->hasOne(ElementSlideshow::className(), ['element_id' => 'id']);
    }

    /**
     * Relations definition
     * @return ActiveQuery
     */
    public function getElementSlideshowImages()
    {
        return $this->hasMany(ElementSlideshowImage::className(), ['element_slideshow_id' => 'id'])->via('elementSlideshow');
    }

}
