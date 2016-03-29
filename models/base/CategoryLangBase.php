<?php

namespace app\models\base;

use Yii;
use app\models\Category;

/**
 * This is the model class for table "category_lang".
*
    * @property integer $id
    * @property integer $category_id
    * @property string $title
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    * @property string $language
    *
            * @property Category $category
    */
class CategoryLangBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'category_lang';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['category_id', 'title', 'language'], 'required'],
            [['category_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 5],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'category_id' => Yii::t('app', 'Category ID'),
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
    public function getCategory()
    {
    return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\CategoryLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\CategoryLangQuery(get_called_class());
}
}