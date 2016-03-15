<?php

namespace app\models\base;

use Yii;
use app\models\Page;
use app\models\Element;

/**
 * This is the model class for table "page_element".
*
    * @property integer $id
    * @property integer $page_id
    * @property integer $element_id
    * @property integer $weight
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Page $page
            * @property Element $element
    */
class PageElementBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'page_element';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['page_id', 'element_id'], 'required'],
            [['page_id', 'element_id', 'weight', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
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
    'page_id' => Yii::t('app', 'Page ID'),
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
    public function getPage()
    {
    return $this->hasOne(Page::className(), ['id' => 'page_id']);
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
     * @return \app\models\querys\PageElementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\PageElementQuery(get_called_class());
}
}