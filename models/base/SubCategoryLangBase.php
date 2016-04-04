<?php

namespace app\models\base;

use Yii;
use app\models\SubCategory;

/**
 * This is the model class for table "sub_category_lang".
*
    * @property integer $id
    * @property integer $sub_category_id
    * @property string $title
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    * @property string $language
    *
            * @property SubCategory $subCategory
    */
class SubCategoryLangBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'sub_category_lang';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['sub_category_id', 'title', 'language'], 'required'],
            [['sub_category_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 5],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategory::className(), 'targetAttribute' => ['sub_category_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'sub_category_id' => Yii::t('app', 'Sub Category ID'),
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
    public function getSubCategory()
    {
    return $this->hasOne(SubCategory::className(), ['id' => 'sub_category_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\SubCategoryLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\SubCategoryLangQuery(get_called_class());
}
}