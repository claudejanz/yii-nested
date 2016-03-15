<?php

namespace app\models\base;

use Yii;
use app\models\Menu;
use app\models\Layout;
use app\models\Page;
use app\models\PageElement;
use app\models\PageLang;

/**
 * This is the model class for table "page".
*
    * @property integer $id
    * @property string $title
    * @property string $content
    * @property string $breadcrumb_text
    * @property integer $type
    * @property integer $parent_id
    * @property integer $weight
    * @property integer $layout_id
    * @property string $meta_description
    * @property string $meta_keywords
    * @property string $slug
    * @property integer $published
    * @property string $controller
    * @property string $action
    * @property string $params
    * @property integer $home_page
    * @property integer $orderable
    * @property string $root_menu
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Menu[] $menus
            * @property Layout $layout
            * @property Page $parent
            * @property Page[] $pages
            * @property PageElement[] $pageElements
            * @property PageLang[] $pageLangs
    */
class PageBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'page';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'type', 'published', 'controller', 'action'], 'required'],
            [['content'], 'string'],
            [['type', 'parent_id', 'weight', 'layout_id', 'published', 'home_page', 'orderable', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'breadcrumb_text', 'meta_description', 'meta_keywords', 'slug', 'params'], 'string', 'max' => 255],
            [['controller', 'action', 'root_menu'], 'string', 'max' => 45],
            [['slug'], 'unique'],
            [['layout_id'], 'exist', 'skipOnError' => true, 'targetClass' => Layout::className(), 'targetAttribute' => ['layout_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
    'content' => Yii::t('app', 'Content'),
    'breadcrumb_text' => Yii::t('app', 'Breadcrumb Text'),
    'type' => Yii::t('app', 'Type'),
    'parent_id' => Yii::t('app', 'Parent ID'),
    'weight' => Yii::t('app', 'Weight'),
    'layout_id' => Yii::t('app', 'Layout ID'),
    'meta_description' => Yii::t('app', 'Meta Description'),
    'meta_keywords' => Yii::t('app', 'Meta Keywords'),
    'slug' => Yii::t('app', 'Slug'),
    'published' => Yii::t('app', 'Published'),
    'controller' => Yii::t('app', 'Controller'),
    'action' => Yii::t('app', 'Action'),
    'params' => Yii::t('app', 'Params'),
    'home_page' => Yii::t('app', 'Home Page'),
    'orderable' => Yii::t('app', 'Orderable'),
    'root_menu' => Yii::t('app', 'Root Menu'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMenus()
    {
    return $this->hasMany(Menu::className(), ['page_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLayout()
    {
    return $this->hasOne(Layout::className(), ['id' => 'layout_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getParent()
    {
    return $this->hasOne(Page::className(), ['id' => 'parent_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPages()
    {
    return $this->hasMany(Page::className(), ['parent_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPageElements()
    {
    return $this->hasMany(PageElement::className(), ['page_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPageLangs()
    {
    return $this->hasMany(PageLang::className(), ['page_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\PageQuery(get_called_class());
}
}