<?php

namespace app\models\base;

use Yii;
use app\models\Reporting;
use app\models\Sport;
use app\models\Category;
use app\models\SubCategory;
use app\models\User;
use app\models\Day;
use app\models\Week;

/**
 * This is the model class for table "training".
*
    * @property integer $id
    * @property string $title
    * @property integer $sport_id
    * @property integer $category_id
    * @property integer $sub_category_id
    * @property integer $sportif_id
    * @property integer $day_id
    * @property integer $week_id
    * @property string $time
    * @property integer $rpe
    * @property string $explanation
    * @property string $extra_comment
    * @property string $graph
    * @property integer $graph_type
    * @property string $date
    * @property integer $published
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Reporting[] $reportings
            * @property Sport $sport
            * @property Category $category
            * @property SubCategory $subCategory
            * @property User $sportif
            * @property Day $day
            * @property Week $week
    */
class TrainingBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'training';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'sport_id', 'sportif_id', 'day_id', 'week_id', 'date', 'published'], 'required'],
            [['sport_id', 'category_id', 'sub_category_id', 'sportif_id', 'day_id', 'week_id', 'rpe', 'graph_type', 'published', 'created_by', 'updated_by'], 'integer'],
            [['time', 'date', 'created_at', 'updated_at'], 'safe'],
            [['explanation', 'extra_comment', 'graph'], 'string'],
            [['title'], 'string', 'max' => 1024],
            [['sport_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sport::className(), 'targetAttribute' => ['sport_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategory::className(), 'targetAttribute' => ['sub_category_id' => 'id']],
            [['sportif_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sportif_id' => 'id']],
            [['day_id'], 'exist', 'skipOnError' => true, 'targetClass' => Day::className(), 'targetAttribute' => ['day_id' => 'id']],
            [['week_id'], 'exist', 'skipOnError' => true, 'targetClass' => Week::className(), 'targetAttribute' => ['week_id' => 'id']],
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
    'sportif_id' => Yii::t('app', 'Sportif ID'),
    'day_id' => Yii::t('app', 'Day ID'),
    'week_id' => Yii::t('app', 'Week ID'),
    'time' => Yii::t('app', 'Time'),
    'rpe' => Yii::t('app', 'Rpe'),
    'explanation' => Yii::t('app', 'Explanation'),
    'extra_comment' => Yii::t('app', 'Extra Comment'),
    'graph' => Yii::t('app', 'Graph'),
    'graph_type' => Yii::t('app', 'Graph Type'),
    'date' => Yii::t('app', 'Date'),
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
    public function getReportings()
    {
    return $this->hasMany(Reporting::className(), ['training_id' => 'id']);
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
    public function getSportif()
    {
    return $this->hasOne(User::className(), ['id' => 'sportif_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDay()
    {
    return $this->hasOne(Day::className(), ['id' => 'day_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getWeek()
    {
    return $this->hasOne(Week::className(), ['id' => 'week_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\TrainingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\TrainingQuery(get_called_class());
}
}