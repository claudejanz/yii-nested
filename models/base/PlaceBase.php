<?php

namespace app\models\base;

use Yii;
use app\models\Layout;
use app\models\PlaceElement;

/**
 * This is the model class for table "place".
*
    * @property integer $id
    * @property string $title
    * @property integer $layout_id
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Layout $layout
            * @property PlaceElement[] $placeElements
    */
class PlaceBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'place';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'layout_id'], 'required'],
            [['layout_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['layout_id'], 'exist', 'skipOnError' => true, 'targetClass' => Layout::className(), 'targetAttribute' => ['layout_id' => 'id']],
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
    'layout_id' => Yii::t('app', 'Layout ID'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLayout()
    {
    return $this->hasOne(Layout::className(), ['id' => 'layout_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPlaceElements()
    {
    return $this->hasMany(PlaceElement::className(), ['place_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\PlaceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\PlaceQuery(get_called_class());
}
}