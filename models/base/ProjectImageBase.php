<?php

namespace app\models\base;

use Yii;
use app\models\Project;

/**
 * This is the model class for table "project_image".
*
    * @property integer $id
    * @property integer $project_id
    * @property string $title
    * @property integer $homepage
    * @property integer $represent
    * @property string $url
    * @property integer $size
    * @property integer $weight
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Project $project
    */
class ProjectImageBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'project_image';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['project_id', 'title', 'size'], 'required'],
            [['project_id', 'homepage', 'represent', 'size', 'weight', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'url'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'project_id' => Yii::t('app', 'Project ID'),
    'title' => Yii::t('app', 'Title'),
    'homepage' => Yii::t('app', 'Homepage'),
    'represent' => Yii::t('app', 'Represent'),
    'url' => Yii::t('app', 'Url'),
    'size' => Yii::t('app', 'Size'),
    'weight' => Yii::t('app', 'Weight'),
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
     * @inheritdoc
     * @return \app\models\querys\ProjectImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ProjectImageQuery(get_called_class());
}
}