<?php

namespace app\models\base;

use Yii;
use app\models\Training;
use app\models\Week;
use app\models\Day;
use app\models\Sport;

/**
 * This is the model class for table "reporting".
*
    * @property integer $id
    * @property integer $training_id
    * @property string $feedback
    * @property string $date
    * @property integer $week_id
    * @property integer $day_id
    * @property integer $sport_id
    * @property double $km
    * @property integer $done
    * @property integer $time_done
    * @property string $time
    * @property integer $feeled_rpe
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Training $training
            * @property Week $week
            * @property Day $day
            * @property Sport $sport
    */
class ReportingBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'reporting';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['training_id', 'date', 'week_id', 'day_id', 'sport_id'], 'required'],
            [['training_id', 'week_id', 'day_id', 'sport_id', 'done', 'time_done', 'feeled_rpe', 'created_by', 'updated_by'], 'integer'],
            [['feedback'], 'string'],
            [['date', 'time', 'created_at', 'updated_at'], 'safe'],
            [['km'], 'number'],
            [['training_id'], 'exist', 'skipOnError' => true, 'targetClass' => Training::className(), 'targetAttribute' => ['training_id' => 'id']],
            [['week_id'], 'exist', 'skipOnError' => true, 'targetClass' => Week::className(), 'targetAttribute' => ['week_id' => 'id']],
            [['day_id'], 'exist', 'skipOnError' => true, 'targetClass' => Day::className(), 'targetAttribute' => ['day_id' => 'id']],
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
    'training_id' => Yii::t('app', 'Training ID'),
    'feedback' => Yii::t('app', 'Feedback'),
    'date' => Yii::t('app', 'Date'),
    'week_id' => Yii::t('app', 'Week ID'),
    'day_id' => Yii::t('app', 'Day ID'),
    'sport_id' => Yii::t('app', 'Sport ID'),
    'km' => Yii::t('app', 'Km'),
    'done' => Yii::t('app', 'Done'),
    'time_done' => Yii::t('app', 'Time Done'),
    'time' => Yii::t('app', 'Time'),
    'feeled_rpe' => Yii::t('app', 'Feeled Rpe'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTraining()
    {
    return $this->hasOne(Training::className(), ['id' => 'training_id']);
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
    public function getDay()
    {
    return $this->hasOne(Day::className(), ['id' => 'day_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSport()
    {
    return $this->hasOne(Sport::className(), ['id' => 'sport_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\ReportingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ReportingQuery(get_called_class());
}
}