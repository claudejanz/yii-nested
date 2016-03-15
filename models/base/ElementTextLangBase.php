<?php

namespace app\models\base;

use Yii;
use app\models\ElementText;

/**
 * This is the model class for table "element_text_lang".
*
    * @property integer $id
    * @property integer $element_text_id
    * @property string $content
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    * @property string $language
    *
            * @property ElementText $elementText
    */
class ElementTextLangBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'element_text_lang';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['element_text_id', 'content', 'language'], 'required'],
            [['element_text_id', 'created_by', 'updated_by'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['language'], 'string', 'max' => 5],
            [['element_text_id'], 'exist', 'skipOnError' => true, 'targetClass' => ElementText::className(), 'targetAttribute' => ['element_text_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'element_text_id' => Yii::t('app', 'Element Text ID'),
    'content' => Yii::t('app', 'Content'),
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
    public function getElementText()
    {
    return $this->hasOne(ElementText::className(), ['id' => 'element_text_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\ElementTextLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ElementTextLangQuery(get_called_class());
}
}