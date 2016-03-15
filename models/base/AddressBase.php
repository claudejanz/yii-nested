<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "address".
*
    * @property integer $id
    * @property string $title
    * @property string $street
    * @property string $city
    * @property double $lat
    * @property double $lng
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
*/
class AddressBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'address';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'street', 'city', 'lat', 'lng'], 'required'],
            [['lat', 'lng'], 'number'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'street', 'city'], 'string', 'max' => 255],
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
    'street' => Yii::t('app', 'Street'),
    'city' => Yii::t('app', 'City'),
    'lat' => Yii::t('app', 'Lat'),
    'lng' => Yii::t('app', 'Lng'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
     * @inheritdoc
     * @return \app\models\querys\AddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\AddressQuery(get_called_class());
}
}