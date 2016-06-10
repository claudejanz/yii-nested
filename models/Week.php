<?php

namespace app\models;

use app\extentions\behaviors\WeekPublishBehavior;
use app\extentions\helpers\EuroDateTime;
use app\models\base\WeekBase;
use DateTime;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * @property Day[] $daysByDate
 * @property Reporting[] $reportingsByDate
 * @property int[] $loadsByDate
 * @property int[] $kmByDate
 * @property int $reportingsKm
 * @property int $reportingsMinutes
 * @property int $trainingsKm
 * @property int $trainingsMinutes
 */
class Week extends WeekBase
{

    public function behaviors()
    {
        return array(
            'publish'   => [
                'class' => WeekPublishBehavior::className(),
            ],
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
            ['title', 'validateTitle', 'skipOnEmpty' => false],
                ], parent::rules());
    }

    public function validateTitle($attribute, $params)
    {
        if (!isset($this->{$attribute})) {


            if (!isset($this->date_begin)) {
                $this->addError($attribute, Yii::t('app', 'date_begin must be set for {attribute} to be set'));
                return false;
            }

            $date = new DateTime($this->date_begin);
            $this->{$attribute} = 'W' . $date->format('W');
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getDaysByDate()
    {
        return $this->hasMany(Day::className(), ['week_id' => 'id'])->with(['trainings'])->indexBy('date');
    }

    public function getReportingsByDate()
    {
        $models = $this->reportings;
        return ($models) ? ArrayHelper::index($models, 'id', ['day.date']) : null;
    }
    public function getTrainingsByDate()
    {
        $models = $this->trainings;
        return ($models) ? ArrayHelper::index($models, 'id', ['day.date']) : null;
    }

    public function getLoadsByDate()
    {
        if (!$this->getReportingsByDate()) {
            return null;
        }
        $data = [];
        foreach ($this->getReportingsByDate() as $key => $rows) {
            $data[$key] = 0;
            foreach ($rows as $reporting) {
                /* @var $reporting Reporting */
                $data[$key]+=$reporting->load;
            }
        }
        return $data;
    }

    public function getKmByDate()
    {
        if (!$this->getReportingsByDate()) {
            return null;
        }
        $data = [];
        foreach ($this->getReportingsByDate() as $key => $rows) {
            $data[$key] = 0;
            foreach ($rows as $reporting) {
                /* @var $reporting Reporting */
                $data[$key]+=$reporting->km;
            }
        }
        return $data;
    }

    public function getReportingsKm()
    {
        if (!$this->reportings) {
            return 0;
        }
        $total = 0;
        foreach ($this->reportings as $reporting) {
            /* @var $reporting Reporting */
            $total+=$reporting->km;
        }
        return $total;
    }
    public function getReportingsMinutes()
    {
        if (!$this->reportings) {
            return 0;
        }
        $total = 0;
        foreach ($this->reportings as $reporting) {
            /* @var $reporting Reporting */
            $total+=$reporting->minutes;
        }
        return $total;
    }

    public function getTrainingsKm()
    {
        if (!$this->trainings) {
            return 0;
        }
        $total = 0;
        foreach ($this->trainings as $training) {
                /* @var $training Training */
                $total+=$training->km;
        }
        return $total;
    }
    public function getTrainingsMinutes()
    {
        if (!$this->trainings) {
            return 0;
        }
        $total = 0;
        foreach ($this->trainings as $training) {
                /* @var $training Training */
                $total+=$training->minutes;
        }
        return $total;
    }

    public function sendWeekMail($user)
    {

        $date = new EuroDateTime($this->date_begin);
        $dateEnd = clone $date;
        $dateEnd->modify('+6 days');
        $title = Yii::t('app', 'A new planning has been done for you');
        return Yii::$app->mailer->compose('sendWeek', ['model' => $this, 'user' => $user, 'title' => $title])
                        ->setFrom([Yii::$app->params['mailerEmail'] => Yii::$app->params['mailerName']])
                        ->setTo($user->email)
                        ->setSubject($title)
                        ->send();
    }

    public function publish($value = WeekPublishBehavior::PUBLISHED_PLANING_DONE)
    {
        if ($value > $this->published) {
            $this->published = $value;
        }
        if ($this->save()) {
            foreach ($this->days as $day) {
                if (!$day->publish($value)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    private $_newPublishedDay = [];

    /**
     * Add new published day for mail report
     * @param Day $day
     */
    public function addNewPublishedDay($day) {

        $this->_newPublishedDay[] = $day;
    }

    /**
     * Returns new days for mail report
     * @return Day[]
     */
    public function getNewPublishedDay() {
        return $this->_newPublishedDay;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDays()
    {
        return $this->hasMany(Day::className(), ['week_id' => 'id'])->orderBy(['date' => SORT_ASC])->inverseOf('week');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMails()
   {
        return $this->hasMany(Mail::className(), ['week_id' => 'id'])->inverseOf('week');
   }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainings()
    {
        return $this->hasMany(Training::className(), ['week_id' => 'id'])->inverseOf('week');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportings()
    {
        return $this->hasMany(Reporting::className(), ['training_id' => 'id'])->via('trainings')->inverseOf('week');
    }

}
