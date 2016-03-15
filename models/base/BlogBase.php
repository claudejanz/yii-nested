<?php

namespace app\models\base;

use Yii;
use app\models\BlogTag;
use app\models\Tag;

/**
* This is the model class for table "blog".
*
    * @property integer $id
    * @property string $title
    * @property string $resume
    * @property string $description
    * @property string $technologies
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property BlogTag[] $blogTags
            * @property Tag[] $tags
    */
class BlogBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'blog';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['title', 'resume', 'description', 'technologies'], 'required'],
            [['resume', 'description'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'technologies'], 'string', 'max' => 255]
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
    'resume' => Yii::t('app', 'Resume'),
    'description' => Yii::t('app', 'Description'),
    'technologies' => Yii::t('app', 'Technologies'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getBlogTags()
    {
    return $this->hasMany(BlogTag::className(), ['blog_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTags()
    {
    return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('blog_tag', ['blog_id' => 'id']);
    }
}