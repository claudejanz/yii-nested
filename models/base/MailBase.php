<?php

namespace app\models\base;

use Yii;
use app\models\Week;

/**
 * This is the model class for table "mail".
*
    * @property integer $id
    * @property string $subject
    * @property integer $sender_id
    * @property integer $receiver_id
    * @property integer $week_id
    * @property string $date
    * @property string $content
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Week $week
    */
class MailBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'mail';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['subject', 'receiver_id', 'week_id', 'date', 'content'], 'required'],
            [['sender_id', 'receiver_id', 'week_id', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['content'], 'string'],
            [['subject'], 'string', 'max' => 1024],
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
    'subject' => Yii::t('app', 'Subject'),
    'sender_id' => Yii::t('app', 'Sender ID'),
    'receiver_id' => Yii::t('app', 'Receiver ID'),
    'week_id' => Yii::t('app', 'Week ID'),
    'date' => Yii::t('app', 'Date'),
    'content' => Yii::t('app', 'Content'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getWeek()
    {
    return $this->hasOne(Week::className(), ['id' => 'week_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\MailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\MailQuery(get_called_class());
}
}