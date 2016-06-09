<?php

namespace app\models;

use app\extentions\behaviors\WeekPublishBehavior;
use app\extentions\helpers\EuroDateTime;
use app\models\base\DayBase;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;

/**
 * @property Training[] $trainingsWithSport
 * @property booleen $hasReportingDone
 * @property booleen $hasReporting
 */
class Day extends DayBase
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

    const PUBLISHED_TRAINING_DONE = 5;
    const PUBLISHED_TRAINING_NOT_DONE =6;
    const PUBLISHED_TRAINING_DAY_OFF = 7;
    
    
    /**
     * @return array published names indexed by published IDs
     */
    public static function getPublishedOptions()
    {
        return array(
            WeekPublishBehavior::PUBLISHED_CITY_EDIT => Yii::t('app', 'City Edit'),
            WeekPublishBehavior::PUBLISHED_CITY_DONE => Yii::t('app', 'City Done'),
            WeekPublishBehavior::PUBLISHED_PLANING_DONE => Yii::t('app', 'Planned'),
            self::PUBLISHED_TRAINING_DONE => Yii::t('app', 'Training done'),
            self::PUBLISHED_TRAINING_NOT_DONE => Yii::t('app', 'Training not done'),
            self::PUBLISHED_TRAINING_DAY_OFF => Yii::t('app', 'Day off'),
        );
    }

    public static function getPublishedColors()
    {
        return array(
            WeekPublishBehavior::PUBLISHED_CITY_EDIT => 'info',
            WeekPublishBehavior::PUBLISHED_CITY_DONE => 'yellow',
            WeekPublishBehavior::PUBLISHED_PLANING_DONE => 'warning',
            self::PUBLISHED_TRAINING_DONE => 'green',
            self::PUBLISHED_TRAINING_NOT_DONE => 'dark-green',
            self::PUBLISHED_TRAINING_DAY_OFF => 'danger',
        );
    }
    /**
     * Overrides 
     * @return string a text on published status
     */
    public function getPublishedLabel()
    {

        $publishedOptions = self::getPublishedOptions();
        if ($this->published > 2) {
            if ($this->reportingsDone) {
                return Yii::t('app', 'Done');
            } elseif ($this->reportings) {
                return Yii::t('app', 'Not done');
            }
        }
        return isset($publishedOptions[$this->published]) ? $publishedOptions[$this->published] : "unknown published ($this->published)";
    }

    public function getPublishedColor()
    {

        $publishedOptions = self::getPublishedColors();
        if ($this->published > 2) {
            if ($this->getHasSportId(47)) {
                return 'danger';
            }
            if ($this->reportingsDone) {
                return 'green';
            }
            if ($this->reportings) {
                return 'dark-green';
            }
        }
        return isset($publishedOptions[$this->published]) ? $publishedOptions[$this->published] : "unknown published ($this->published)";
    }

    public function rules()
    {

        return array_merge([
            ['published', 'default', 'value' => PublishBehavior::PUBLISHED_DRAFT],
            ['week_id', 'validateWeek', 'skipOnEmpty' => false],
            ['training_city', 'validateTrainingCity', 'skipOnEmpty' => false],
                ], self::rules());
    }

    public function validateWeek($attribute, $params)
    {
        if (!isset($this->{$attribute})) {

            if (!isset($this->date)) {
                $this->addError($attribute, Yii::t('app', 'date must be set for {attribute} to be set', ['attribute' => $attribute]));
                return false;
            }
            if (!isset($this->sportif_id)) {
                $this->addError($attribute, Yii::t('app', 'sportif_id must be set for {attribute} to be set', ['attribute' => $attribute]));
                return false;
            }

            $startDate = new EuroDateTime($this->date);
            $startDate->modify('Monday this week');
            $endDate = clone $startDate;
            $endDate->modify('+6days');

            $model = Week::findOne(['date_begin' => $startDate->format('Y-m-d'), 'sportif_id' => $this->sportif_id]);
            if (!$model) {
                $model = new Week();
                $model->setAttributes([
                    'date_begin' => $startDate->format('Y-m-d'),
                    'date_end'   => $endDate->format('Y-m-d'),
                    'sportif_id' => $this->sportif_id,
                ]);
                if (!$model->validate()) {
                    $this->addError($attribute, Yii::t('app', 'A new week could not be created because: {errors}', ['errors' => print_r($model->errors, true)]));
                    return false;
                }
                $model->save(false);
            }
            $this->{$attribute} = $model->id;
        }
    }

    public function validateTrainingCity($attribute, $params)
    {
        if (!isset($this->{$attribute})) {
            if (!isset($this->sportif_id)) {
                $this->addError($attribute, Yii::t('app', 'sportif_id must be set for {attribute} to be set', ['attribute' => $attribute]));
                return false;
            }
            $model = $this->sportif;

            $this->{$attribute} = $model->city;
        }
    }

    public function publish($value = WeekPublishBehavior::PUBLISHED_PLANING_DONE)
    {
        if ($value == WeekPublishBehavior::PUBLISHED_PLANING_DONE) {
            if ($this->trainings) {
                if ($value > $this->published) {
                    $this->published = $value;
                }
                if (!$this->save()) {
                    return false;
                }
                foreach ($this->trainings as $training) {
                    if (!$training->publish($value)) {
                        return false;
                    }
                }
                $this->week->addNewPublishedDay($this);
                return true;
            }
            return true;
        } elseif ($value < WeekPublishBehavior::PUBLISHED_PLANING_DONE) {
            if ($value > $this->published) {
                $this->published = $value;
            }
            if ($this->save()) {
                return true;
            }
        }
        return false;
    }

    public function getDuration()
    {
        if ($this->trainings) {
            $isCoach = Yii::$app->user->can('coach');
            $hours = 0;
            $minutes = 0;
            foreach ($this->trainings as $training) {
                if ($isCoach || $training->published == PublishBehavior::PUBLISHED_ACTIF) {
                    $duration = $training->time;
                    $split = preg_split('@:@', $training->time, -1, PREG_SPLIT_NO_EMPTY);
                    if (count($split) > 1) {
                        $hours += $split[0];
                        $minutes += $split[1];
                        if ($minutes >= 60) {
                            $hours +=floor($minutes / 60);
                            $minutes -= floor($minutes / 60) * 60;
                        }
                    }
                }
                /* @var $training Training */
            }
            if (!($hours == 0 && $minutes == 0)) {
                return sprintf('%1$01dh%2$02d', $hours, $minutes);
            }
        }
        return null;
    }

    /**
     * @return ActiveQuery
     */
    public function getTrainingsWithSport()
    {
        return $this->hasMany(Training::className(), ['day_id' => 'id'])->with('sport');
    }

    public function getIcons()
    {
        if ($this->trainingsWithSport) {
            $isCoach = Yii::$app->user->can('coach');
            $all = [];
            foreach ($this->trainingsWithSport as $training) {
                if ($isCoach || $training->published == PublishBehavior::PUBLISHED_ACTIF) {
                    if (!isset($all[$training->sport_id])) {
                        $all[$training->sport_id] = [
                            'url'   => $training->sport->iconUrl,
                            'count' => 0
                        ];
                    }
                    $all[$training->sport_id]['count'] ++;
                }
            }
            if (!empty($all)) {
                return $all;
            }
        }
        return [];
    }

    


    /**
     * @return ActiveQuery
     */
    public function getTrainings()
    {
        return $this->hasMany(Training::className(), ['day_id' => 'id'])->inverseOf('day');
    }
    
    /**
     * @return ActiveQuery
     */
    public function getReportings()
    {
        return $this->hasMany(Reporting::className(), ['training_id' => 'id'])->via('trainings')->inverseOf('day');
    }
    /**
     * @return ActiveQuery
     */
    public function getReportingsDone()
    {
        return $this->hasMany(Reporting::className(), ['training_id' => 'id'])->via('trainings')->where(['done' => 1])->inverseOf('day');
    }

    public function getHasSportId($sport_id) {
        return ((new Query())
                        ->select(['sport_id'])
                        ->from('training')
                        ->where(['day_id' => $this->id])
                        ->andWhere(['sport_id' => $sport_id])
                        ->scalar() != null) ? true : false;

         }

}
