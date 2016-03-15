<?php

namespace app\models\base;

use Yii;
use app\models\ProjectImage;

/**
 * This is the model class for table "project".
*
    * @property integer $id
    * @property string $title
    * @property integer $weight
    * @property string $slug
    * @property integer $published
    * @property string $keywords
    * @property string $category
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property ProjectImage[] $projectImages
    */
class ProjectBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'project';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'published'], 'required'],
            [['weight', 'published', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'keywords', 'category'], 'string', 'max' => 255],
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
    'weight' => Yii::t('app', 'Weight'),
    'slug' => Yii::t('app', 'Slug'),
    'published' => Yii::t('app', 'Published'),
    'keywords' => Yii::t('app', 'Keywords'),
    'category' => Yii::t('app', 'Category'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getProjectImages()
    {
    return $this->hasMany(ProjectImage::className(), ['project_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ProjectQuery(get_called_class());
}
}