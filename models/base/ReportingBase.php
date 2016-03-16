<?php

namespace app\models\base;

use Yii;
use app\models\Training;

/**
 * This is the model class for table "reporting".
*
    * @property integer $id
    * @property integer $training_id
    * @property string $feedback
    * @property integer $done
    * @property integer $time_done
    * @property string $time
    * @property integer $feeled_rpe
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Training $training
    */
class ReportingBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'reporting';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['training_id'], 'required'],
            [['training_id', 'done', 'time_done', 'feeled_rpe', 'created_by', 'updated_by'], 'integer'],
            [['feedback'], 'string'],
            [['time', 'created_at', 'updated_at'], 'safe'],
            [['training_id'], 'exist', 'skipOnError' => true, 'targetClass' => Training::className(), 'targetAttribute' => ['training_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'training_id' => Yii::t('app', 'Training ID'),
    'feedback' => Yii::t('app', 'Feedback'),
    'done' => Yii::t('app', 'Done'),
    'time_done' => Yii::t('app', 'Time Done'),
    'time' => Yii::t('app', 'Time'),
    'feeled_rpe' => Yii::t('app', 'Feeled Rpe'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTraining()
    {
    return $this->hasOne(Training::className(), ['id' => 'training_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\ReportingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ReportingQuery(get_called_class());
}
}