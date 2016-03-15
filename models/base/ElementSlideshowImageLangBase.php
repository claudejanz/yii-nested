<?php

namespace app\models\base;

use Yii;
use app\models\ElementSlideshowImage;

/**
 * This is the model class for table "element_slideshow_image_lang".
*
    * @property integer $id
    * @property string $title
    * @property integer $element_slideshow_image_id
    * @property string $language
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property ElementSlideshowImage $elementSlideshowImage
    */
class ElementSlideshowImageLangBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'element_slideshow_image_lang';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'element_slideshow_image_id', 'language'], 'required'],
            [['element_slideshow_image_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['language'], 'string', 'max' => 5],
            [['element_slideshow_image_id'], 'exist', 'skipOnError' => true, 'targetClass' => ElementSlideshowImage::className(), 'targetAttribute' => ['element_slideshow_image_id' => 'id']],
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
    'element_slideshow_image_id' => Yii::t('app', 'Element Slideshow Image ID'),
    'language' => Yii::t('app', 'Language'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getElementSlideshowImage()
    {
    return $this->hasOne(ElementSlideshowImage::className(), ['id' => 'element_slideshow_image_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\ElementSlideshowImageLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ElementSlideshowImageLangQuery(get_called_class());
}
}