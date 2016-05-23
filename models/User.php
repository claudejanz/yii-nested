<?php

namespace app\models;

use app\extentions\helpers\EuroDateTime;
use app\models\base\UserBase;
use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use arogachev\ManyToMany\validators\ManyToManyValidator;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property Day[] | null $daysByDate write-only password
 */
class User extends UserBase implements IdentityInterface
{

    public $password;
    public $editableSports;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'relation'  => [
                'class'     => ManyToManyBehavior::className(),
                'relations' => [
                    [
                        'name'              => 'sports',
                        // This is the same as in previous example
                        'editableAttribute' => 'editableSports',
                    ],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge([
            ['password', 'default', 'value' => function ($value) {
                    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!?"), 0, 6);
                }, 'on' => 'create'],
            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6, 'on' => 'create'],
            ['password', 'setMyPassword', 'on' => 'create'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['role', 'default', 'value' => self::ROLE_SPORTIF],
            ['role', 'in', 'range' => array_keys(self::getRoleOptions())],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['editableSports', ManyToManyValidator::className()],
                ], parent::rules());
    }

    public function attributeLabels()
    {
        return array_merge([
            'fullname'    => Yii::t('app', 'Full name'),
            'trainername' => Yii::t('app', 'Trainer name'),
            'editableSports' => Yii::t('app', 'Editable Sports'),
                ], parent::attributeLabels());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }


        return static::findOne([
                    'password_reset_token' => $token,
                    'status'               => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public function setMyPassword($password)
    {
        $this->setPassword($this->{$password});
        $this->generateAuthKey();
        return $this->{$password};
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Returns model display label
     * @param number $n
     * @return string
     */
    public static function getLabel($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{User} other{Users}}', ['n' => $n]);
    }

    const ROLE_SPORTIF = 1;
    const ROLE_COACH = 3;
    const ROLE_ADMIN = 5;
    const ROLE_SUPERADMIN = 10;

    /**
     * @return array category names indexed by category IDs
     */
    public static function getRoleOptions($user = null)
    {
        $roles = [];
        if ($user === null) {
            $roles[self::ROLE_SPORTIF] = Yii::t('app', 'Sportif');
            $roles[self::ROLE_COACH] = Yii::t('app', 'Coach');
            $roles[self::ROLE_ADMIN] = Yii::t('app', 'Admin');
            $roles[self::ROLE_SUPERADMIN] = Yii::t('app', 'Super Admin');
        } else {
            switch ($user->identity->role) {
                case 10:
                    $roles[self::ROLE_SUPERADMIN] = Yii::t('app', 'Super Admin');
                case 5:
                    $roles[self::ROLE_ADMIN] = Yii::t('app', 'Admin');
                case 3:
                    $roles[self::ROLE_COACH] = Yii::t('app', 'Coach');
                case 1:
                    $roles[self::ROLE_SPORTIF] = Yii::t('app', 'Sportif');
                default:
                    break;
            }
            ksort($roles);
        }
        return $roles;
    }

    public function getRoleLabel()
    {
        $roleOptions = self::getRoleOptions();
        return isset($roleOptions[$this->role]) ? $roleOptions[$this->role] : "unknown role ($this->role)";
    }

    public static function getRoleNames()
    {

        return array(
            self::ROLE_SPORTIF    => 'sportif',
            self::ROLE_COACH      => 'coach',
            self::ROLE_ADMIN      => 'admin',
            self::ROLE_SUPERADMIN => 'super admin',
        );
    }

    public function getRoleName()
    {
        $roleNames = self::getRoleNames();
        return isset($roleNames[$this->role]) ? $roleNames[$this->role] : "unknown role ($this->role)";
    }

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public static function getStatusOptions()
    {

        return array(
            self::STATUS_ACTIVE  => Yii::t('app', 'Actif'),
            self::STATUS_DELETED => Yii::t('app', 'Deleted'),
        );

    }

    const GENDER_FEMALE = 1;
    const GENDER_MALE = 2;
    
     public static function getGenderOptions() {
         return array(
            self::GENDER_FEMALE  => Yii::t('app', 'Female'),
            self::GENDER_MALE => Yii::t('app', 'Male'),
        );
    }
    
    public function getGenderLabel() {
        $options = self::getGenderOptions();
        return isset($options[$this->gender]) ? $options[$this->gender] : "unknown role ($this->gender)";
    }

    public function getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getTrainername()
    {
        return $this->getFullname();
    }

    public function sendPasswordInit()
    {
        $this->generatePasswordResetToken();
        if ($this->save()) {
            return Yii::$app->mailer->compose('passwordInit', ['user' => $this])
                            ->setFrom([Yii::$app->params['mailerEmail'] => Yii::$app->params['mailerName']])
                            ->setTo($this->email)
                            ->setSubject(Yii::t('mail', 'Welcome on {sitename}', ['sitename' => Yii::$app->name]))
                            ->send();
        }

        return false;
    }

    public function sendCityMail($date_begin)
    {
        $date = new EuroDateTime($date_begin);
        $dateEnd = clone $date;
        $dateEnd->modify('+6 days');
        $sender = [Yii::$app->params['mailerEmail'] => Yii::$app->params['mailerName']];
        $title = Yii::t('app', 'Please fill your citys {begin_date} to {end_date}', ['begin_date' => Yii::$app->formatter->asDate($date), 'end_date' => Yii::$app->formatter->asDate($dateEnd)]);
        return Yii::$app->mailer->compose('sendFillCity', [ 'model' => $this, 'date' => $date, 'date_begin' => $date_begin, 'title' => $title])
                        ->setFrom($sender)
                        ->setTo($this->email)
                        ->setSubject($title)
                        ->send();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDaysByDate()
  {
        return $this->hasMany(Day::className(), ['sportif_id' => 'id'])->indexBy('date');
  }

    

}
