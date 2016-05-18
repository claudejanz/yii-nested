<?php

namespace app\models\base;

use Yii;
use app\models\Day;
use app\models\Training;
use app\models\User;
use app\models\UserSport;
use app\models\Sport;
use app\models\Week;

/**
 * This is the model class for table "user".
*
    * @property integer $id
    * @property string $firstname
    * @property string $lastname
    * @property string $address
    * @property string $npa
    * @property string $city
    * @property string $tel
    * @property string $username
    * @property string $email
    * @property string $auth_key
    * @property string $password_hash
    * @property string $password_reset_token
    * @property string $comments
    * @property integer $role
    * @property string $language
    * @property integer $trainer_id
    * @property string $birthday
    * @property integer $gender
    * @property integer $status
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Day[] $days
            * @property Training[] $trainings
            * @property User $trainer
            * @property User[] $users
            * @property UserSport[] $userSports
            * @property Sport[] $sports
            * @property Week[] $weeks
    */
class UserBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'user';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['firstname', 'lastname', 'address', 'npa', 'city', 'tel', 'username', 'email', 'auth_key', 'password_hash', 'language', 'birthday', 'gender'], 'required'],
            [['comments'], 'string'],
            [['role', 'trainer_id', 'gender', 'status', 'created_by', 'updated_by'], 'integer'],
            [['birthday', 'created_at', 'updated_at'], 'safe'],
            [['firstname', 'lastname', 'address', 'npa', 'city', 'tel', 'username', 'email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['language'], 'string', 'max' => 5],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['trainer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['trainer_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'firstname' => Yii::t('app', 'Firstname'),
    'lastname' => Yii::t('app', 'Lastname'),
    'address' => Yii::t('app', 'Address'),
    'npa' => Yii::t('app', 'Npa'),
    'city' => Yii::t('app', 'City'),
    'tel' => Yii::t('app', 'Tel'),
    'username' => Yii::t('app', 'Username'),
    'email' => Yii::t('app', 'Email'),
    'auth_key' => Yii::t('app', 'Auth Key'),
    'password_hash' => Yii::t('app', 'Password Hash'),
    'password_reset_token' => Yii::t('app', 'Password Reset Token'),
    'comments' => Yii::t('app', 'Comments'),
    'role' => Yii::t('app', 'Role'),
    'language' => Yii::t('app', 'Language'),
    'trainer_id' => Yii::t('app', 'Trainer ID'),
    'birthday' => Yii::t('app', 'Birthday'),
    'gender' => Yii::t('app', 'Gender'),
    'status' => Yii::t('app', 'Status'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDays()
    {
    return $this->hasMany(Day::className(), ['sportif_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainings()
    {
    return $this->hasMany(Training::className(), ['sportif_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrainer()
    {
    return $this->hasOne(User::className(), ['id' => 'trainer_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsers()
    {
    return $this->hasMany(User::className(), ['trainer_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUserSports()
    {
    return $this->hasMany(UserSport::className(), ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSports()
    {
    return $this->hasMany(Sport::className(), ['id' => 'sport_id'])->viaTable('user_sport', ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getWeeks()
    {
    return $this->hasMany(Week::className(), ['sportif_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\UserQuery(get_called_class());
}
}