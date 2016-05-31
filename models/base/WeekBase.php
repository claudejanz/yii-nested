<?php

namespace app\models\base;

use Yii;
use app\models\Day;
use app\models\Mail;
use app\models\Reporting;
use app\models\Training;
use app\models\User;

/**
 * This is the model class for table "week".
*
    * @property integer $id
    * @property string $title
    * @property string $words_of_the_week
    * @property integer $sportif_id
    * @property string $date_begin
    * @property string $date_end
    * @property integer $published
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Day[] $days
            * @property Mail[] $mails
            * @property Reporting[] $reportings
            * @property Training[] $trainings
            * @property User $sportif
    */
class WeekBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'week';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'sportif_id', 'date_begin', 'date_end', 'published'], 'required'],
            [['sportif_id', 'published', 'created_by', 'updated_by'], 'integer'],
            [['date_begin', 'date_end', 'created_at', 'updated_at'], 'safe'],
            [['title', 'words_of_the_week'], 'string', 'max' => 1024],
            [['sportif_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sportif_id' => 'id']],
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
    'words_of_the_week' => Yii::t('app', 'Words Of The Week'),
    'sportif_id' => Yii::t('app', 'Sportif ID'),
    'date_begin' => Yii::t('app', 'Date Begin'),
    'date_end' => Yii::t('app', 'Date End'),
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
    public function getDays()
    {
    return $this->hasMany(Day::className(), ['week_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMails()
    {
    return $this->hasMany(Mail::className(), ['week_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getReportings()
    {
    return $this->hasMany(Reporting::className(), ['week_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainings()
    {
    return $this->hasMany(Training::className(), ['week_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSportif()
    {
    return $this->hasOne(User::className(), ['id' => 'sportif_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\WeekQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\WeekQuery(get_called_class());
}
}