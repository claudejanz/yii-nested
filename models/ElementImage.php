<?php

namespace app\models;

use app\models\base\ElementImageBase;
use claudejanz\toolbox\models\behaviors\FileBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Html;

class ElementImage extends ElementImageBase
{

    public $url_delete;

    public function rules()
    {
        return array_merge([
            [['url'], 'file', 'extensions' => 'jpg'],
            [['url_delete'], 'safe'],
                ], parent::rules());
    }

    public function behaviors()
    {
        return array(
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'fileBehavior' => [
                'class' => FileBehavior::className(),
                //'paths' => ['image2'=>'@webroot/images/all2/{id}/','@webroot/images/all/{id}/'],
                'paths' => '@webroot/images/elementImage/{id}/',
            ],
        );
    }

    public function getImageSmall()
    {
        return str_replace('@web', '@web/image-cache/small', $this->url);
    }

    public function getImageBig()
    {
        return str_replace('@web', '@web/image-cache/big', $this->url);
    }

    public function getImageTiny()
    {
        return str_replace('@web', '@web/image-cache/tiny', $this->url);
    }

    public function getImageList()
    {
        return str_replace('@web', '@web/image-cache/list', $this->url);
    }

    public function getImageSmallHtml()
    {
        $return = $this->getImageSmall();
        return (!empty($return)) ? Html::img($return) : null;
    }

    public function getImagePreviewHtml()
    {
        $return = $this->getImageBig();
        return (!empty($return)) ? Html::img($return, ['style' => 'width:auto;height:160px;']) : null;
    }

    public function getImageName()
    {
        $split = preg_split('@/@', $this->url, -1, PREG_SPLIT_NO_EMPTY);
        return $split[count($split) - 1];
    }

}
