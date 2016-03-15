<?php

namespace app\models\base;

use Yii;
use app\models\Project;

/**
 * This is the model class for table "project_lang".
*
    * @property integer $id
    * @property string $title
    * @property integer $project_id
    * @property string $language
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Project $project
    */
class ProjectLangBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'project_lang';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'project_id', 'language'], 'required'],
            [['project_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['language'], 'string', 'max' => 5],
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
    'title' => Yii::t('app', 'Title'),
    'project_id' => Yii::t('app', 'Project ID'),
    'language' => Yii::t('app', 'Language'),
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
     * @return \app\models\querys\ProjectLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\ProjectLangQuery(get_called_class());
}
}