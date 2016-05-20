<?php

namespace app\extentions\behaviors;

use app\models\Day;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @author Janz
 *
 */
class WeekPublishBehavior extends Behavior
{
    const PUBLISHED_CITY_EDIT = 1;
    const PUBLISHED_CITY_DONE = 2;
    const PUBLISHED_PLANING_DONE = 3;
    const PUBLISHED_DELETED = 4;

    public $field = 'published';
    public $value = self::PUBLISHED_CITY_EDIT;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        $model = $this->owner;
        if (empty($model->{$this->field}))
            $model->{$this->field} = $this->value;
    }


    /**
     * @return array published names indexed by published IDs
     */
    public static function getPublishedOptions()
    {
        return array(
            self::PUBLISHED_CITY_EDIT => Yii::t('claudejanz', 'City Edit'),
            self::PUBLISHED_CITY_DONE => Yii::t('claudejanz', 'City Done'),
            self::PUBLISHED_PLANING_DONE => Yii::t('claudejanz', 'Planned'),
            self::PUBLISHED_DELETED => Yii::t('claudejanz', 'Archived'),
        );
    }

    public static function getPublishedColors()
    {
        return array(
            self::PUBLISHED_CITY_EDIT => 'yellow',
            self::PUBLISHED_CITY_DONE => 'warning',
            self::PUBLISHED_PLANING_DONE => 'warning',
            self::PUBLISHED_DELETED => 'info'
        );
    }

    /**
     * @return string display text for the current Published
     */
    public function getPublishedLabel()
    {
        $model = $this->owner;
        $publishedOptions = self::getPublishedOptions();
        return isset($publishedOptions[$model->published]) ? $publishedOptions[$model->published] : "unknown published ($model->published)";
    }

    /**
     * @return string color for the current Published
     */
    public function getPublishedColor()
    {
        $model = $this->owner;
        $publishedOptions = self::getPublishedColors();
        return isset($publishedOptions[$model->published]) ? $publishedOptions[$model->published] : "unknown published ($model->published)";
    }

}
