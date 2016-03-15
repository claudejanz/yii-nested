<?php

namespace app\models\base;

use Yii;
use app\models\EventLang;

/**
 * This is the model class for table "event".
*
    * @property integer $id
    * @property string $title
    * @property integer $allDay
    * @property string $start
    * @property string $end
    * @property string $url
    * @property string $className
    * @property integer $editable
    * @property integer $startEditable
    * @property integer $durationEditable
    * @property string $rendering
    * @property integer $overlap
    * @property string $constraint
    * @property string $color
    * @property string $backgroundColor
    * @property string $borderColor
    * @property string $textColor
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property EventLang[] $eventLangs
    */
class EventBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'event';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'start'], 'required'],
            [['allDay', 'editable', 'startEditable', 'durationEditable', 'overlap', 'created_by', 'updated_by'], 'integer'],
            [['start', 'end', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['url', 'className'], 'string', 'max' => 255],
            [['rendering', 'constraint'], 'string', 'max' => 55],
            [['color', 'backgroundColor', 'borderColor', 'textColor'], 'string', 'max' => 10],
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
    'allDay' => Yii::t('app', 'All Day'),
    'start' => Yii::t('app', 'Start'),
    'end' => Yii::t('app', 'End'),
    'url' => Yii::t('app', 'Url'),
    'className' => Yii::t('app', 'Class Name'),
    'editable' => Yii::t('app', 'Editable'),
    'startEditable' => Yii::t('app', 'Start Editable'),
    'durationEditable' => Yii::t('app', 'Duration Editable'),
    'rendering' => Yii::t('app', 'Rendering'),
    'overlap' => Yii::t('app', 'Overlap'),
    'constraint' => Yii::t('app', 'Constraint'),
    'color' => Yii::t('app', 'Color'),
    'backgroundColor' => Yii::t('app', 'Background Color'),
    'borderColor' => Yii::t('app', 'Border Color'),
    'textColor' => Yii::t('app', 'Text Color'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEventLangs()
    {
    return $this->hasMany(EventLang::className(), ['event_id' => 'id']);
    }
}