<?php

namespace app\models;

use app\extentions\helpers\EuroDateTime;
use app\models\base\DayBase;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Day extends DayBase
{

    public function behaviors()
    {
        return array(
            'publish' => [
                'class' => PublishBehavior::className(),
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
            ['published', 'default', 'value' => PublishBehavior::PUBLISHED_DRAFT],
            ['week_id', 'validateWeek', 'skipOnEmpty' => false],
            ['training_city', 'validateTrainingCity', 'skipOnEmpty' => false],
                ], parent::rules());
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
                    'date_end' => $endDate->format('Y-m-d'),
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



            $model = User::findOne(['id' => $this->sportif_id]);

            $this->{$attribute} = $model->city;
        }
    }

    public function publish($value = PublishBehavior::PUBLISHED_ACTIF)
    {
        $this->published = $value;
        if ($this->save()) {
            foreach ($this->trainings as $training)
                if (!$training->publish($value))
                    return false;

            return true;
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
                    $hours += $split[0];
                    $minutes += $split[1];
                }
                /* @var $training Training */
            }
            if (!($hours == 0 && $minutes == 0)) {
                return sprintf('%1$01dh%2$02d', $hours, $minutes);
            }
        }
        return null;
    }

    public function getIcons()
    {
        if ($this->trainings) {
            $isCoach = Yii::$app->user->can('coach');
            $all = [];
            foreach ($this->trainings as $training) {
                if ($isCoach || $training->published == PublishBehavior::PUBLISHED_ACTIF) {
                    if (!isset($all[$training->sport_id])) {
                        $all[$training->sport_id] = $training->sport->iconUrl;
                    }
                }
            }
            if (!empty($all)) {
                return $all;
            }
        }
        return null;
    }

}
