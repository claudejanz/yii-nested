<?php

namespace app\models\base;

use Yii;
use app\models\Sport;
use app\models\CategoryLang;
use app\models\SubCategory;
use app\models\Training;
use app\models\TrainingType;

/**
 * This is the model class for table "category".
*
    * @property integer $id
    * @property integer $sport_id
    * @property string $title
    * @property integer $published
    * @property integer $weight
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Sport $sport
            * @property CategoryLang[] $categoryLangs
            * @property SubCategory[] $subCategories
            * @property Training[] $trainings
            * @property TrainingType[] $trainingTypes
    */
class CategoryBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'category';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['sport_id', 'title', 'published'], 'required'],
            [['sport_id', 'published', 'weight', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['sport_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sport::className(), 'targetAttribute' => ['sport_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'sport_id' => Yii::t('app', 'Sport ID'),
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
    public function getSport()
    {
    return $this->hasOne(Sport::className(), ['id' => 'sport_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCategoryLangs()
    {
    return $this->hasMany(CategoryLang::className(), ['category_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSubCategories()
    {
    return $this->hasMany(SubCategory::className(), ['category_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainings()
    {
    return $this->hasMany(Training::className(), ['category_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainingTypes()
    {
    return $this->hasMany(TrainingType::className(), ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\CategoryQuery(get_called_class());
}
}