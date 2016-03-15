<?php

namespace app\models\base;

use Yii;
use app\models\Page;
use app\models\Menu;

/**
 * This is the model class for table "menu".
*
    * @property integer $id
    * @property string $title
    * @property integer $page_id
    * @property integer $menu_id
    * @property integer $weight
    * @property integer $type
    * @property string $visible
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Page $page
            * @property Menu $menu
            * @property Menu[] $menus
    */
class MenuBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'menu';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'page_id', 'visible'], 'required'],
            [['page_id', 'menu_id', 'weight', 'type', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'visible'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
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
    'page_id' => Yii::t('app', 'Page ID'),
    'menu_id' => Yii::t('app', 'Menu ID'),
    'weight' => Yii::t('app', 'Weight'),
    'type' => Yii::t('app', 'Type'),
    'visible' => Yii::t('app', 'Visible'),
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

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMenu()
    {
    return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMenus()
    {
    return $this->hasMany(Menu::className(), ['menu_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\MenuQuery(get_called_class());
}
}