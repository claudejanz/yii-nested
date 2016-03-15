<?php

namespace app\models\base;

use Yii;
use app\models\PressImage;

/**
 * This is the model class for table "press".
*
    * @property integer $id
    * @property string $title
    * @property string $slug
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property PressImage[] $pressImages
    */
class PressBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'press';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 255],
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
    'slug' => Yii::t('app', 'Slug'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPressImages()
    {
    return $this->hasMany(PressImage::className(), ['press_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\PressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\PressQuery(get_called_class());
}
}