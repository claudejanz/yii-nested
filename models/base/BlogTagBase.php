<?php

namespace app\models\base;

use Yii;
use app\models\Blog;
use app\models\Tag;

/**
* This is the model class for table "blog_tag".
*
    * @property integer $blog_id
    * @property integer $tag_id
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Blog $blog
            * @property Tag $tag
    */
class BlogTagBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'blog_tag';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['blog_id', 'tag_id'], 'required'],
            [['blog_id', 'tag_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'blog_id' => Yii::t('app', 'Blog ID'),
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
    public function getBlog()
    {
    return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTag()
    {
    return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}