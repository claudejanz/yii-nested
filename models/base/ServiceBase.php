<?php

namespace app\models\base;

use Yii;
use app\models\ServiceTag;
use app\models\Tag;

/**
* This is the model class for table "service".
*
    * @property integer $id
    * @property string $title
    * @property string $clean_url
    * @property string $resume
    * @property string $description
    * @property string $technologies
    * @property string $url
    * @property integer $weight
    * @property integer $public
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property ServiceTag[] $serviceTags
            * @property Tag[] $tags
    */
class ServiceBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'service';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['title', 'clean_url', 'resume', 'description', 'technologies'], 'required'],
            [['resume', 'description'], 'string'],
            [['weight', 'public', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'clean_url', 'technologies', 'url'], 'string', 'max' => 255]
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
    'clean_url' => Yii::t('app', 'Clean Url'),
    'resume' => Yii::t('app', 'Resume'),
    'description' => Yii::t('app', 'Description'),
    'technologies' => Yii::t('app', 'Technologies'),
    'url' => Yii::t('app', 'Url'),
    'weight' => Yii::t('app', 'Weight'),
    'public' => Yii::t('app', 'Public'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getServiceTags()
    {
    return $this->hasMany(ServiceTag::className(), ['service_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTags()
    {
    return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('service_tag', ['service_id' => 'id']);
    }
}