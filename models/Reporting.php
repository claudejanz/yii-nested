<?php

namespace app\models;

use app\models\base\ReportingBase;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * 
 * @property string $duration
 * @property int $minutes
 * @property int $load
 * @property string doneColor css class
 */
class Reporting extends ReportingBase
{

    public function behaviors()
    {
        return array(
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
        );
    }

    public function rules()
   {

        return array_merge([
            ['done', 'validateLoad'],
            ['done', 'default', 'value' => 0]
                ], parent::rules());
   }

    public function validateLoad($attribute){
        if ($this->$attribute) {
            if (!$this->time) {
                $this->addError('time', Yii::t('app', 'If training done you have to fill "{attribute}"', ['attribute' => $this->getAttributeLabel('time')]));
            }
            if (empty($this->feeled_rpe)) {
                $this->addError('feeled_rpe', Yii::t('app', 'If training done you have to fill "{attribute}"', ['attribute' => $this->getAttributeLabel('feeled_rpe')]));
            }
        }
    }

    /*
     * GETTERS
     */

    public function getMinutes()
    {
        if(!$this->done){
            return 0;
        }
        $parse = array();
        if (!preg_match('#^(?<hours>[\d]{2}):(?<mins>[\d]{2}):(?<secs>[\d]{2})$#', $this->time, $parse)) {
            // Throw error, exception, etc
            return 0;
        }
        return (int) $parse['hours'] * 60 + (int) $parse['mins'];
    }

    public function getLoad(){
        return ($this->done) ? $this->minutes * $this->feeled_rpe : null;
    }

    public function getDoneColor(){
        return ($this->done) ? 'green' : 'red';
    }

    public function getDuration()
    {
        return Yii::$app->formatter->asDuration($this->minutes);
    }

    /*
     * Relations Def
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTraining()
{
        return $this->hasOne(Training::className(), ['id' => 'training_id'])->inverseOf('reporting');
}

    /**
     * @return ActiveQuery
     */
    public function getDay()
{
        return $this->hasOne(Day::className(), ['id' => 'day_id'])->via('training');
}

    /**
     * @return ActiveQuery
     */
    public function getSport()
{
        return $this->hasOne(Sport::className(), ['id' => 'sport_id'])->via('training');
}

    /**
     * @return ActiveQuery
     */
    public function getWeek()
{
        return $this->hasOne(Week::className(), ['id' => 'week_id'])->via('day');
}

}
