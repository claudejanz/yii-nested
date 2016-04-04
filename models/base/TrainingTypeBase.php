<?php

namespace app\models\base;

use Yii;
use app\models\Sport;
use app\models\Category;
use app\models\SubCategory;
use app\models\TrainingTypeLang;

/**
 * This is the model class for table "training_type".
*
    * @property integer $id
    * @property string $title
    * @property integer $sport_id
    * @property integer $category_id
    * @property integer $sub_category_id
    * @property string $time
    * @property double $rpe
    * @property string $explanation
    * @property string $extra_comment
    * @property string $graph
    * @property integer $graph_type
    * @property integer $published
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Sport $sport
            * @property Category $category
            * @property SubCategory $subCategory
            * @property TrainingTypeLang[] $trainingTypeLangs
    */
class TrainingTypeBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'training_type';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'sport_id', 'published'], 'required'],
            [['sport_id', 'category_id', 'sub_category_id', 'graph_type', 'published', 'created_by', 'updated_by'], 'integer'],
            [['time', 'created_at', 'updated_at'], 'safe'],
            [['rpe'], 'number'],
            [['explanation', 'extra_comment', 'graph'], 'string'],
            [['title'], 'string', 'max' => 1024],
            [['sport_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sport::className(), 'targetAttribute' => ['sport_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
    'title' => Yii::t('app', 'Title'),
    'sport_id' => Yii::t('app', 'Sport ID'),
    'category_id' => Yii::t('app', 'Category ID'),
    'sub_category_id' => Yii::t('app', 'Sub Category ID'),
    'time' => Yii::t('app', 'Time'),
    'rpe' => Yii::t('app', 'Rpe'),
    'explanation' => Yii::t('app', 'Explanation'),
    'extra_comment' => Yii::t('app', 'Extra Comment'),
    'graph' => Yii::t('app', 'Graph'),
    'graph_type' => Yii::t('app', 'Graph Type'),
    'published' => Yii::t('app', 'Published'),
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
    public function getCategory()
    {
    return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSubCategory()
    {
    return $this->hasOne(SubCategory::className(), ['id' => 'sub_category_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainingTypeLangs()
    {
    return $this->hasMany(TrainingTypeLang::className(), ['training_type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\TrainingTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\TrainingTypeQuery(get_called_class());
}
}