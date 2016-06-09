<?php

namespace app\models\base;

use Yii;
use app\models\Category;
use app\models\SportLang;
use app\models\Training;
use app\models\TrainingType;
use app\models\UserSport;
use app\models\User;

/**
 * This is the model class for table "sport".
*
    * @property integer $id
    * @property string $title
    * @property string $icon
    * @property integer $published
    * @property integer $weight
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Category[] $categories
            * @property SportLang[] $sportLangs
            * @property Training[] $trainings
            * @property TrainingType[] $trainingTypes
            * @property UserSport[] $userSports
            * @property User[] $users
    */
class SportBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'sport';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'icon', 'published'], 'required'],
            [['published', 'weight', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'icon'], 'string', 'max' => 255],
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
    'icon' => Yii::t('app', 'Icon'),
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
    public function getCategories()
    {
    return $this->hasMany(Category::className(), ['sport_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSportLangs()
    {
    return $this->hasMany(SportLang::className(), ['sport_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainings()
    {
    return $this->hasMany(Training::className(), ['sport_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainingTypes()
    {
    return $this->hasMany(TrainingType::className(), ['sport_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUserSports()
    {
    return $this->hasMany(UserSport::className(), ['sport_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsers()
    {
    return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_sport', ['sport_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\SportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\SportQuery(get_called_class());
}
}