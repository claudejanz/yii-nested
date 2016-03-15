<?php

namespace app\models\base;

use Yii;
use app\models\Page;
use app\models\Place;

/**
 * This is the model class for table "layout".
*
    * @property integer $id
    * @property string $title
    * @property string $path
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Page[] $pages
            * @property Place[] $places
    */
class LayoutBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'layout';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'path'], 'required'],
            [['path'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
    'path' => Yii::t('app', 'Path'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPages()
    {
    return $this->hasMany(Page::className(), ['layout_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPlaces()
    {
    return $this->hasMany(Place::className(), ['layout_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\LayoutQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\LayoutQuery(get_called_class());
}
}