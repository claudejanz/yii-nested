<?php

namespace app\models\base;

use Yii;
use app\models\Element;
use app\models\ElementTextLang;

/**
 * This is the model class for table "element_text".
*
    * @property integer $id
    * @property integer $element_id
    * @property string $content
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Element $element
            * @property ElementTextLang[] $elementTextLangs
    */
class ElementTextBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'element_text';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['element_id', 'content'], 'required'],
            [['element_id', 'created_by', 'updated_by'], 'integer'],
            [['content'], 'string'],
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
    'element_id' => Yii::t('app', 'Element ID'),
    'content' => Yii::t('app', 'Content'),
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
    public function getElementTextLangs()
    {
    return $this->hasMany(ElementTextLang::className(), ['element_text_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\ElementTextQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ElementTextQuery(get_called_class());
}
}