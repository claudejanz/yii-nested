<?php

namespace app\models\base;

use Yii;
use app\models\User;
use app\models\Sport;

/**
 * This is the model class for table "user_sport".
*
    * @property integer $user_id
    * @property integer $sport_id
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property User $user
            * @property Sport $sport
    */
class UserSportBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'user_sport';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['user_id', 'sport_id'], 'required'],
            [['user_id', 'sport_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['sport_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sport::className(), 'targetAttribute' => ['sport_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'user_id' => Yii::t('app', 'User ID'),
    'sport_id' => Yii::t('app', 'Sport ID'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSport()
    {
    return $this->hasOne(Sport::className(), ['id' => 'sport_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\UserSportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\UserSportQuery(get_called_class());
}
}