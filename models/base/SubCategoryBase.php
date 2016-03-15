<?php

namespace app\models\base;

use Yii;
use app\models\Category;
use app\models\Training;
use app\models\TrainingType;

/**
 * This is the model class for table "sub_category".
*
    * @property integer $id
    * @property integer $category_id
    * @property string $title
    * @property integer $published
    * @property integer $weight
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Category $category
            * @property Training[] $trainings
            * @property TrainingType[] $trainingTypes
    */
class SubCategoryBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'sub_category';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['category_id', 'title', 'published'], 'required'],
            [['category_id', 'published', 'weight', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
    'published' => Yii::t('app', 'Published'),
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
    public function getCategory()
    {
    return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainings()
    {
    return $this->hasMany(Training::className(), ['sub_category_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainingTypes()
    {
    return $this->hasMany(TrainingType::className(), ['sub_category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\SubCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\SubCategoryQuery(get_called_class());
}
}