<?php

namespace app\models\base;

use Yii;
use app\models\Week;

/**
 * This is the model class for table "week_comment".
*
    * @property integer $id
    * @property string $title
    * @property integer $week_id
    * @property string $content
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Week $week
    */
class WeekCommentBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'week_comment';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'week_id'], 'required'],
            [['week_id', 'created_by', 'updated_by'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 1024],
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
    'title' => Yii::t('app', 'Title'),
    'week_id' => Yii::t('app', 'Week ID'),
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
     * @return \app\models\querys\WeekCommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\WeekCommentQuery(get_called_class());
}
}