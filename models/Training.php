<?php

namespace app\models;

use app\extentions\behaviors\WeekPublishBehavior;
use app\models\base\TrainingBase;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "training".
 *
 *
 * @property Reporting[] $reportings
 * @property string $duration
 */
class Training extends TrainingBase
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
            ['day_id', 'validateDay', 'skipOnEmpty' => false],
                ], parent::rules());
    }

    public function validateDay($attribute, $params)
    {
        if (!isset($this->{$attribute})) {
            if (!isset($this->sportif_id)) {
                $this->addError($attribute, Yii::t('app', 'sportif_id must be set for {attribute} to be set', ['attribute' => $attribute]));
                return;
            }
            if (!isset($this->date)) {
                $this->addError($attribute, Yii::t('app', 'date must be set for {attribute} to be set', ['attribute' => $attribute]));
                return false;
            }
            $model = Day::findOne(['date' => $this->date, 'sportif_id' => $this->sportif_id]);
            if (!$model) {
                $model = new Day();
                $model->setAttributes([
                    'date'       => $this->date,
                    'sportif_id' => $this->sportif_id,
                ]);
                if (!$model->validate()) {
                    $this->addError($attribute, Yii::t('app', 'A new day could not be created because: {errors}', ['errors' => print_r($model->errors, true)]));
                    return false;
                }
                $model->save(false);
            }
            $this->{$attribute} = $model->id;
            $this->week_id = $model->week->id;
        }
    }

    public function getDuration()
    {
        $split = preg_split('@:@', $this->time, -1, PREG_SPLIT_NO_EMPTY);
        return sprintf('%1$01dh%2$02d', $split['0'], $split['1']);
    }

    public function getShortTitle()
    {
        return substr($this->title, 0, 25) . '...';
    }

    public function publish($value = WeekPublishBehavior::PUBLISHED_PLANING_DONE)
    {
        $this->published = $value;
        if ($this->save()) {
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getReporting()
    {
        return $this->hasOne(Reporting::className(), ['training_id' => 'id']);
    }

}
