<?php

namespace app\models\base;

use Yii;
use app\models\TrainingType;

/**
 * This is the model class for table "training_type_lang".
*
    * @property integer $id
    * @property string $title
    * @property integer $training_type_id
    * @property string $explanation
    * @property string $extra_comment
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    * @property string $language
    *
            * @property TrainingType $trainingType
    */
class TrainingTypeLangBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'training_type_lang';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'training_type_id', 'language'], 'required'],
            [['training_type_id', 'created_by', 'updated_by'], 'integer'],
            [['explanation', 'extra_comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 1024],
            [['language'], 'string', 'max' => 5],
            [['training_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TrainingType::className(), 'targetAttribute' => ['training_type_id' => 'id']],
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
    'training_type_id' => Yii::t('app', 'Training Type ID'),
    'explanation' => Yii::t('app', 'Explanation'),
    'extra_comment' => Yii::t('app', 'Extra Comment'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
    'language' => Yii::t('app', 'Language'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainingType()
    {
    return $this->hasOne(TrainingType::className(), ['id' => 'training_type_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\TrainingTypeLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\TrainingTypeLangQuery(get_called_class());
}
}