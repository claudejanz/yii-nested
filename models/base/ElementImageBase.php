<?php

namespace app\models\base;

use Yii;
use app\models\Element;

/**
 * This is the model class for table "element_image".
*
    * @property integer $id
    * @property integer $element_id
    * @property string $title
    * @property string $url
    * @property integer $weight
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Element $element
    */
class ElementImageBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'element_image';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['element_id', 'title'], 'required'],
            [['element_id', 'weight', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'url'], 'string', 'max' => 255],
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
    'element_id' => Yii::t('app', 'Element ID'),
    'title' => Yii::t('app', 'Title'),
    'url' => Yii::t('app', 'Url'),
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
    public function getElement()
    {
    return $this->hasOne(Element::className(), ['id' => 'element_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\ElementImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ElementImageQuery(get_called_class());
}
}