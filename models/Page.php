<?php

namespace app\models;

use app\models\base\PageBase;
use claudejanz\toolbox\models\behaviors\AutoSlugBehavior;
use claudejanz\toolbox\models\behaviors\FileBehavior;
use claudejanz\toolbox\models\behaviors\OnlyBehavior;
use claudejanz\toolbox\models\behaviors\MultilingualBehavior;
use claudejanz\toolbox\models\behaviors\MultilingualQuery;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "page".
 *
 * @property Element[] $elements
 */
class Page extends PageBase
{

    public function rules()
    {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        $controller_id = (isset(Yii::$app->controller->id)) ? Yii::$app->controller->id : null;
        $action_id = (isset(Yii::$app->controller->action->id)) ? Yii::$app->controller->action->id : null;

        return array_merge([
// all
// autoCreate set default values
            ['controller', 'default', 'value' => $controller_id, 'on' => 'autoCreate'],
            ['action', 'default', 'value' => $action_id, 'on' => 'autoCreate'],
            ['title', 'default', 'value' => ucwords($controller_id . ' ' . $action_id), 'on' => 'autoCreate'],
            ['meta_description', 'default', 'value' => ucfirst($controller_id . ' ' . $action_id), 'on' => 'autoCreate'],
            ['meta_keywords', 'default', 'value' => strtolower($controller_id . ', ' . $action_id), 'on' => 'autoCreate'],
            ['type', 'default', 'value' => self::TYPE_DYNAMIC, 'on' => 'autoCreate'],
            ['published', 'default', 'value' => PublishBehavior::PUBLISHED_ACTIF, 'on' => 'autoCreate'],
            // insert
            ['controller', 'default', 'value' => 'page', 'on' => 'insert'],
            ['action', 'default', 'value' => 'view', 'on' => 'insert'],
            ['type', 'default', 'value' => self::TYPE_STATIC, 'on' => 'insert'],
            ['published', 'default', 'value' => PublishBehavior::PUBLISHED_ACTIF, 'on' => 'insert'],
            ['breadcrumb_text', 'default', 'value' => null],
            // autoCreate and Insert
//            ['layout_id', 'default', 'value' => (in_array($action_id, ['index','planning','order','hidden'])) ? 2 : 3],
            ['layout_id', 'default', 'value' => 2],
                ], parent::rules());
    }

    public function behaviors()
    {
        return array(
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['langsNames'],
                'langClassName' => PageLang::className(), // or namespace/for/a/class/PostLang
                'langForeignKey' => 'page_id',
                'attributes' => [
                    'title',
                    'content',
                    'meta_description',
                    'meta_keywords',
                    'breadcrumb_text',
                    'slug',
                ]
            ],
            'publish' => [
                'class' => PublishBehavior::className(),
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'homepage' => [
                'class' => OnlyBehavior::className(),
                'field' => 'home_page'
            ],
            'fileBehavior' => [
                'class' => FileBehavior::className(),
                //'paths' => ['image2'=>'@webroot/images/all2/{id}/','@webroot/images/all/{id}/'],
                'paths' => '@webroot/images/pages/{id}/',
            ],
            'autoSlug' => [
                'class' => AutoSlugBehavior::className(),
                'addLanguage' => true,
            ],
        );
    }

    public static function find()
    {
        $q = new MultilingualQuery(get_called_class());
        $q->orderBy('weight');
        $q->localised();
        return $q;
    }

    const ROOT_MENU_NULL = 'No Menu';
    const ROOT_MENU_MAIN = 'Main';
    const ROOT_MENU_FOOTER = 'Footer';

    /**
     * @return array rootMenu names indexed by rootMenu IDs
     */
    public static function getRootMenuOptions($withNull = true)
    {
        $arr = array(
            self::ROOT_MENU_MAIN => Yii::t('app', 'Main Menu'),
            self::ROOT_MENU_FOOTER => Yii::t('app', 'Footer Menu'),
        );
        if ($withNull) {
            return ArrayHelper::merge($arr, [self::ROOT_MENU_NULL => Yii::t('app', 'No Menu')]);
        } else {
            return $arr;
        }
    }

    /**
     * @return string display text for the current RootMenu
     */
    public function getRootMenuLabel($id)
    {
        $rootMenuOptions = self::getRootMenuOptions();
        return isset($rootMenuOptions[$id]) ? $rootMenuOptions[$id] : "unknown rootMenu ($id)";
    }

    const TYPE_STATIC = 1;
    const TYPE_DYNAMIC = 2;

    /**
     * @return array type names indexed by type IDs
     */
    public function getTypeOptions()
    {
        return array(
            self::TYPE_STATIC => Yii::t('core', 'Static'),
            self::TYPE_DYNAMIC => Yii::t('core', 'Dynamic'),
        );
    }

    /**
     * @return string display text for the current Type
     */
    public function getTypeLabel($id)
    {
        $typeOptions = self::getTypeOptions();
        return isset($typeOptions[$id]) ? $typeOptions[$id] : "unknown type ($id)";
    }

    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    /**
     * @return array layout names 
     */
    public static function getLayoutOptions()
    {

        return ArrayHelper::map(Layout::find()->all(), 'id', 'title');
    }

    /**
     * @return array parent options for classification 
     */
    public static function getParentOptions($root_menu = self::ROOT_MENU_NULL, $parent_id = null, $indent = '')
    {
        $all = self::find()->select(['id', 'title'])->where(['root_menu' => $root_menu, 'parent_id' => $parent_id, 'orderable' => 1])->asArray()->all();
        $rows = [];
        if ($all) {
            foreach ($all as $row) {
                $rows[$row['id']] = $indent . $row['title'];
                $rows = ArrayHelper::merge($rows, self::getParentOptions($root_menu, $row['id'], $indent . '-'));
            }
        }
        return $rows;
    }

    public function getFirstChildrenLinks()
    {
        $first_page = $this->getFirstParent();
        return $first_page->getItems();
    }

    public function getSubItems()
    {
        $pages = $this->pages;
        $items = [];
        foreach ($pages as $page) {
            if ($this->root_menu == $page->root_menu)
                $items[] = ['label' => $page->getBreadcrumbsLabel(), 'url' => $page->getUrl()];
        }

        return $items;
    }

    public function getItems()
    {

        $rows = [['label' => $this->getBreadcrumbsLabel(), 'url' => $this->getUrl()]];

        $pages = $this->pages;
        foreach ($pages as $page) {
            if ($this->root_menu == $page->root_menu)
                $rows = ArrayHelper::merge($rows, $page->getItems());
        }

        return $rows;
    }

    public function getFirstParent()
    {
        $parent = $this->parent;
        if (!$parent && $this->action != 'list' && $this->controller != 'site') {
            $parent = self::find()->where(['controller' => $this->controller, 'action' => 'list'])->one();
        }
        if ($parent != null) {
            return $parent->getFirstParent();
        } else {
            return $this;
        }
    }

    /*
     * for places in theme
     */

    private $_placesByName;

    public function getElementByPlaceName($name)
    {
        if (!isset($this->_placesByName))
            $this->_placesByName = $this->layout->placesByName;
        return isset($this->_placesByName[$name]) ? $this->_placesByName[$name]->elements : null;
    }

    public static function getLabel($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Page} other{Pages}}', ['n' => $n]);
    }

    public function getBreadcrumbs()
    {
        $label = (array) $this->getBreadcrumbsLabel();
        $parents = $this->getBreadcrumbsParents();
        if ($parents) {
            return array_merge($parents, $label);
        }
        return [$this->getBreadcrumbsLabel()];
    }

    public function getBreadcrumbsParents()
    {
        $parent = $this->parent;

        // if no parent is set search index from controller
        if (!$parent && $this->action != 'index') {
            $parent = self::find()->where(['controller' => $this->controller, 'action' => 'index'])->one();
        }
        // if still no parent is set search index from site
        if (!$parent && $this->action != 'index' && $this->controller != 'site') {
            $parent = self::find()->where(['controller' => 'site', 'action' => 'index'])->one();
        }
        if (!$parent) {
            return false;
        }
        return $parent->getBreadcrumbsLinks();
    }

    public function getBreadcrumbsLinks()
    {
        $parents = $this->getBreadcrumbsParents();
        $link = $this->getBreadcrumbsLink();
        if ($parents) {
            return array_merge($parents, $link);
        }
        return $link;
    }

    public function getBreadcrumbsLabel()
    {
        return isset($this->breadcrumb_text) ? $this->breadcrumb_text : $this->title;
    }

    public function getBreadcrumbsLink()
    {
        return [['label' => $this->getBreadcrumbsLabel(), 'url' => $this->getUrl()]];
    }

    public function getUrl()
    {
        if ($this->controller == 'pages' && $this->action == 'view') {
            return ['/' . $this->controller . '/' . $this->action, 'id' => $this->id];
        }
        return ['/' . $this->controller . '/' . $this->action];
    }

    /**
     * 
     * @param ActiveRecord $model
     */
    public function setData($model)
    {
        if (isset($model->title)) {
            $this->title = $model->title;
        }

        $this->meta_keywords .= ', ' . $model->title;
    }

//    public function getImageSmall() {
//        return str_replace('@web', '@web/image-cache/small', $this->image);
//    }
//
//    public function getImageBig() {
//        return str_replace('@web', '@web/image-cache/big', $this->image);
//    }
//
//    public function getImageTiny() {
//        return str_replace('@web', '@web/image-cache/tiny', $this->image);
//    }
//
//    public function getImageSmallHtml() {
//        $return = $this->getImageSmall();
//        return (!empty($return)) ? Html::img($return) : null;
//    }
//
//    public function getImagePreviewHtml() {
//        $return = $this->getImageBig();
//        return (!empty($return)) ? Html::img($return, ['style' => 'width:auto;height:160px;']) : null;
//    }
//
//    public function getImageName() {
//        $split = preg_split('@/@', $this->image, -1, PREG_SPLIT_NO_EMPTY);
//        return $split[count($split) - 1];
//    }

    public function getTextTitle()
    {
        return strip_tags($this->title);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasMany(Place::className(), ['id' => 'layout_id'])->via('layout');
    }

    /**
     * @return ActiveQuery
     */
    public function getPlaceElements()
    {
        return $this->hasMany(PlaceElement::className(), ['id' => 'place_id'])->via('places');
    }

    /**
     * @return ActiveQuery
     */
    public function getElements()
    {
        return $this->hasMany(Element::className(), ['id' => 'element_id'])->via('pageElements');
    }

}
