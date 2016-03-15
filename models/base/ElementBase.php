<?php

namespace app\models\base;

use Yii;
use app\models\ElementImage;
use app\models\ElementLang;
use app\models\ElementSlideshow;
use app\models\ElementText;
use app\models\PageElement;
use app\models\PlaceElement;

/**
 * This is the model class for table "element".
*
    * @property integer $id
    * @property string $title
    * @property integer $class_css
    * @property integer $weight
    * @property integer $display_title
    * @property integer $type
    * @property integer $published
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property ElementImage[] $elementImages
            * @property ElementLang[] $elementLangs
            * @property ElementSlideshow[] $elementSlideshows
            * @property ElementText[] $elementTexts
            * @property PageElement[] $pageElements
            * @property PlaceElement[] $placeElements
    */
class ElementBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'element';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'type', 'published'], 'required'],
            [['class_css', 'weight', 'display_title', 'type', 'published', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'title' => Yii::t('app', 'Title'),
    'class_css' => Yii::t('app', 'Class Css'),
    'weight' => Yii::t('app', 'Weight'),
    'display_title' => Yii::t('app', 'Display Title'),
    'type' => Yii::t('app', 'Type'),
    'published' => Yii::t('app', 'Published'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getElementImages()
    {
    return $this->hasMany(ElementImage::className(), ['element_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getElementLangs()
    {
    return $this->hasMany(ElementLang::className(), ['element_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getElementSlideshows()
    {
    return $this->hasMany(ElementSlideshow::className(), ['element_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getElementTexts()
    {
    return $this->hasMany(ElementText::className(), ['element_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPageElements()
    {
    return $this->hasMany(PageElement::className(), ['element_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPlaceElements()
    {
    return $this->hasMany(PlaceElement::className(), ['element_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\ElementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ElementQuery(get_called_class());
}
}