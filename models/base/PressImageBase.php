<?php

namespace app\models\base;

use Yii;
use app\models\Press;

/**
 * This is the model class for table "press_image".
*
    * @property integer $id
    * @property integer $press_id
    * @property string $title
    * @property string $url
    * @property integer $size
    * @property integer $weight
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Press $press
    */
class PressImageBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'press_image';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['press_id', 'title', 'size'], 'required'],
            [['press_id', 'size', 'weight', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'url'], 'string', 'max' => 255],
            [['press_id'], 'exist', 'skipOnError' => true, 'targetClass' => Press::className(), 'targetAttribute' => ['press_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'press_id' => Yii::t('app', 'Press ID'),
    'title' => Yii::t('app', 'Title'),
    'url' => Yii::t('app', 'Url'),
    'size' => Yii::t('app', 'Size'),
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
    public function getPress()
    {
    return $this->hasOne(Press::className(), ['id' => 'press_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\PressImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\PressImageQuery(get_called_class());
}
}