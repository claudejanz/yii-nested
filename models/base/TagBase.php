<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "tag".
*
    * @property integer $id
    * @property string $name
    * @property integer $count
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
*/
class TagBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'tag';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name'], 'required'],
            [['count', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 45],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'name' => Yii::t('app', 'Name'),
    'count' => Yii::t('app', 'Count'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}
}