<?php

namespace app\models\base;

use Yii;
use app\models\Element;
use app\models\ElementSlideshowImage;

/**
 * This is the model class for table "element_slideshow".
*
    * @property integer $id
    * @property integer $stretchImages
    * @property integer $element_id
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Element $element
            * @property ElementSlideshowImage[] $elementSlideshowImages
    */
class ElementSlideshowBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'element_slideshow';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['stretchImages', 'element_id', 'created_by', 'updated_by'], 'integer'],
            [['element_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['element_id'], 'exist', 'skipOnError' => true, 'targetClass' => Element::className(), 'targetAttribute' => ['element_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'stretchImages' => Yii::t('app', 'Stretch Images'),
    'element_id' => Yii::t('app', 'Element ID'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getElement()
    {
    return $this->hasOne(Element::className(), ['id' => 'element_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getElementSlideshowImages()
    {
    return $this->hasMany(ElementSlideshowImage::className(), ['element_slideshow_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\ElementSlideshowQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ElementSlideshowQuery(get_called_class());
}
}