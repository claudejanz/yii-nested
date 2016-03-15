<?php

namespace app\models\base;

use Yii;
use app\models\Service;
use app\models\Tag;

/**
* This is the model class for table "service_tag".
*
    * @property integer $service_id
    * @property integer $tag_id
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Service $service
            * @property Tag $tag
    */
class ServiceTagBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'service_tag';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['service_id', 'tag_id'], 'required'],
            [['service_id', 'tag_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'service_id' => Yii::t('app', 'Service ID'),
    'tag_id' => Yii::t('app', 'Tag ID'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getService()
    {
    return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTag()
    {
    return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}