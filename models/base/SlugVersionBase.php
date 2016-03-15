<?php

namespace app\models\base;

use Yii;
use app\models\Page;

/**
 * This is the model class for table "slug_version".
*
    * @property integer $id
    * @property integer $page_id
    * @property string $slug
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Page $page
    */
class SlugVersionBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'slug_version';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['page_id', 'slug'], 'required'],
            [['page_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'page_id' => Yii::t('app', 'Page ID'),
    'slug' => Yii::t('app', 'Slug'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPage()
    {
    return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}