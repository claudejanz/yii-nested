<?php

namespace app\models\base;

use Yii;
use app\models\Element;

/**
 * This is the model class for table "element_lang".
*
    * @property integer $id
    * @property integer $element_id
    * @property string $title
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    * @property string $language
    *
            * @property Element $element
    */
class ElementLangBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'element_lang';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['element_id', 'title', 'language'], 'required'],
            [['element_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 5],
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
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
    'language' => Yii::t('app', 'Language'),
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
     * @return \app\models\querys\ElementLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ElementLangQuery(get_called_class());
}
}