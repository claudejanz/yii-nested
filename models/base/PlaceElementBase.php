<?php

namespace app\models\base;

use Yii;
use app\models\Place;
use app\models\Element;

/**
 * This is the model class for table "place_element".
*
    * @property integer $id
    * @property integer $place_id
    * @property integer $element_id
    * @property integer $weight
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Place $place
            * @property Element $element
    */
class PlaceElementBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'place_element';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['place_id', 'element_id'], 'required'],
            [['place_id', 'element_id', 'weight', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['place_id'], 'exist', 'skipOnError' => true, 'targetClass' => Place::className(), 'targetAttribute' => ['place_id' => 'id']],
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
    'place_id' => Yii::t('app', 'Place ID'),
    'element_id' => Yii::t('app', 'Element ID'),
    'weight' => Yii::t('app', 'Weight'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPlace()
    {
    return $this->hasOne(Place::className(), ['id' => 'place_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getElement()
    {
    return $this->hasOne(Element::className(), ['id' => 'element_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\PlaceElementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\PlaceElementQuery(get_called_class());
}
}