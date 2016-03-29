<?php

namespace app\models\base;

use Yii;
use app\models\Sport;

/**
 * This is the model class for table "sport_lang".
*
    * @property integer $id
    * @property integer $sport_id
    * @property string $title
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    * @property string $language
    *
            * @property Sport $sport
    */
class SportLangBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'sport_lang';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['sport_id', 'title', 'language'], 'required'],
            [['sport_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 5],
            [['sport_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sport::className(), 'targetAttribute' => ['sport_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'sport_id' => Yii::t('app', 'Sport ID'),
    'title' => Yii::t('app', 'Title'),
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
    public function getSport()
    {
    return $this->hasOne(Sport::className(), ['id' => 'sport_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\SportLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\SportLangQuery(get_called_class());
}
}