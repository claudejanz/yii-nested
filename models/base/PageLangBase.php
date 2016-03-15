<?php

namespace app\models\base;

use Yii;
use app\models\Page;

/**
 * This is the model class for table "page_lang".
*
    * @property integer $id
    * @property integer $page_id
    * @property string $title
    * @property string $content
    * @property string $meta_description
    * @property string $meta_keywords
    * @property string $breadcrumb_text
    * @property string $slug
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    * @property string $language
    *
            * @property Page $page
    */
class PageLangBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'page_lang';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['page_id', 'title', 'language'], 'required'],
            [['page_id', 'created_by', 'updated_by'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'meta_description', 'meta_keywords', 'breadcrumb_text', 'slug'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 5],
            [['slug'], 'unique'],
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
    'title' => Yii::t('app', 'Title'),
    'content' => Yii::t('app', 'Content'),
    'meta_description' => Yii::t('app', 'Meta Description'),
    'meta_keywords' => Yii::t('app', 'Meta Keywords'),
    'breadcrumb_text' => Yii::t('app', 'Breadcrumb Text'),
    'slug' => Yii::t('app', 'Slug'),
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
    public function getPage()
    {
    return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\PageLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\PageLangQuery(get_called_class());
}
}