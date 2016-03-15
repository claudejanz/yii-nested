<?php

namespace app\models\base;

use Yii;
use app\models\Event;

/**
 * This is the model class for table "event_lang".
*
    * @property integer $id
    * @property string $title
    * @property integer $event_id
    * @property string $language
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Event $event
    */
class EventLangBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'event_lang';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'event_id', 'language'], 'required'],
            [['event_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['language'], 'string', 'max' => 5],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
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
    'event_id' => Yii::t('app', 'Event ID'),
    'language' => Yii::t('app', 'Language'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEvent()
    {
    return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }
}