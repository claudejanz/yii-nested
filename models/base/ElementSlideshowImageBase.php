<?php

namespace app\models\base;

use Yii;
use app\models\ElementSlideshow;
use app\models\ElementSlideshowImageLang;

/**
 * This is the model class for table "element_slideshow_image".
*
    * @property integer $id
    * @property string $title
    * @property integer $element_slideshow_id
    * @property integer $weight
    * @property integer $size
    * @property string $url
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property ElementSlideshow $elementSlideshow
            * @property ElementSlideshowImageLang[] $elementSlideshowImageLangs
    */
class ElementSlideshowImageBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'element_slideshow_image';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'element_slideshow_id', 'size', 'url'], 'required'],
            [['element_slideshow_id', 'weight', 'size', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['url'], 'string', 'max' => 255],
            [['element_slideshow_id'], 'exist', 'skipOnError' => true, 'targetClass' => ElementSlideshow::className(), 'targetAttribute' => ['element_slideshow_id' => 'id']],
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
    'element_slideshow_id' => Yii::t('app', 'Element Slideshow ID'),
    'weight' => Yii::t('app', 'Weight'),
    'size' => Yii::t('app', 'Size'),
    'url' => Yii::t('app', 'Url'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getElementSlideshow()
    {
    return $this->hasOne(ElementSlideshow::className(), ['id' => 'element_slideshow_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getElementSlideshowImageLangs()
    {
    return $this->hasMany(ElementSlideshowImageLang::className(), ['element_slideshow_image_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\ElementSlideshowImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ElementSlideshowImageQuery(get_called_class());
}
}