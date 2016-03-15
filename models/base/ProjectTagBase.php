<?php

namespace app\models\base;

use Yii;
use app\models\Project;
use app\models\Tag;

/**
* This is the model class for table "project_tag".
*
    * @property integer $project_id
    * @property integer $tag_id
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Project $project
            * @property Tag $tag
    */
class ProjectTagBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'project_tag';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['project_id', 'tag_id'], 'required'],
            [['project_id', 'tag_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'project_id' => Yii::t('app', 'Project ID'),
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
    public function getProject()
    {
    return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTag()
    {
    return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}