<?php

namespace app\models\base;

use Yii;
use app\models\User;
use app\models\Week;
use app\models\Training;

/**
 * This is the model class for table "day".
*
    * @property integer $id
    * @property string $training_city
    * @property integer $sportif_id
    * @property integer $week_id
    * @property string $date
    * @property string $time_dispo
    * @property string $comment
    * @property integer $published
    * @property integer $weight
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property User $sportif
            * @property Week $week
            * @property Training[] $trainings
    */
class DayBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'day';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['training_city', 'sportif_id', 'week_id', 'date', 'published'], 'required'],
            [['sportif_id', 'week_id', 'published', 'weight', 'created_by', 'updated_by'], 'integer'],
            [['date', 'time_dispo', 'created_at', 'updated_at'], 'safe'],
            [['comment'], 'string'],
            [['training_city'], 'string', 'max' => 1024],
            [['sportif_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sportif_id' => 'id']],
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
    'training_city' => Yii::t('app', 'Training City'),
    'sportif_id' => Yii::t('app', 'Sportif ID'),
    'week_id' => Yii::t('app', 'Week ID'),
    'date' => Yii::t('app', 'Date'),
    'time_dispo' => Yii::t('app', 'Time Dispo'),
    'comment' => Yii::t('app', 'Comment'),
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
    public function getSportif()
    {
    return $this->hasOne(User::className(), ['id' => 'sportif_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getWeek()
    {
    return $this->hasOne(Week::className(), ['id' => 'week_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainings()
    {
    return $this->hasMany(Training::className(), ['day_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\DayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\DayQuery(get_called_class());
}
}