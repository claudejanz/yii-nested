<?php

namespace app\models;

use app\models\base\ProjectImageBase;
use app\models\querys\ProjectImageQuery;
use claudejanz\toolbox\models\behaviors\FileBehavior;
use claudejanz\toolbox\models\behaviors\OnlyBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Url;

class ProjectImage extends ProjectImageBase
{

    public $url_delete;

    public function rules()
    {
        return array_merge([
            [['url'], 'file', 'extensions' => 'jpg'],
            [['url_delete'], 'safe'],
            [['title'], 'default', 'value' => function ($model, $attribute) {
            $arr = preg_split('@(\/|\.)@', $this->url, -1, PREG_SPLIT_NO_EMPTY);
            return ucwords(preg_replace('@_|-@', ' ', $arr[count($arr) - 2]));
        }],
            [['size'], 'default', 'value' => function ($model, $attribute) {
            $file = Yii::getAlias(str_replace('@web', '@webroot', $this->url));
            if (is_file($file))
                return filesize($file);
            $file = $this->getTempFile('url');
            if (is_file($file))
                return filesize($file);
            return 0;
        }],
                ], parent::rules());
    }

    public function delete()
    {
        $url_file = str_replace('@web', '@webroot', $this->url);
        @unlink(Yii::getAlias($url_file));
        parent::delete();
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
                'paths' => '@webroot/images/projectImages/{project_id}/',
            ],
            'onlyBehavior' => [
                'class' => OnlyBehavior::className(),
                'field' => 'represent',
                'sameFields' => ['project_id']
            ],
        );
    }

    public static function find()
    {
        $q = new ProjectImageQuery(get_called_class());
        $q->orderBy('project_image.weight');
        return $q;
    }

    public function getImageSmall()
    {
        return str_replace('@web', '@web/image-cache/small', $this->url);
    }

    public function getImageBig()
    {
        return str_replace('@web', '@web/image-cache/big', $this->url);
    }

    public function getImageThumb()
    {
        return str_replace('@web', '@web/image-cache/thumb', $this->url);
    }

    public function getImageList()
    {
        return str_replace('@web', '@web/image-cache/list', $this->url);
    }

    public function getImageCube()
    {
        return str_replace('@web', '@web/image-cache/cube', $this->url);
    }

    public function getImageSmallHtml()
    {
        $return = $this->getImageSmall();
        return (!empty($return)) ? Html::img($return) : null;
    }

    public function getImageCubeHtml()
    {
        $return = $this->getImageCube();
        return (!empty($return)) ? Html::img($return) : null;
    }

    public function getImagePreviewHtml()
    {
        $return = $this->getImageSmall();
        return (!empty($return)) ? Html::img($return, ['style' => 'width:auto;height:160px;']) : null;
    }

    public function getImageName()
    {
        $split = preg_split('@/@', $this->url, -1, PREG_SPLIT_NO_EMPTY);
        return $split[count($split) - 1];
    }

    public function getFileInfo()
    {

        return [
            'id' => $this->id,
            'name' => $this->title,
            'size' => $this->size,
            'url' => $this->url,
            'homepage' => $this->homepage,
            'represent' => $this->represent,
            'thumbnailUrl' => Yii::getAlias($this->imageSmall),
            "deleteUrl" => Url::to() . '&url=' . $this->url,
            "deleteType" => "DELETE",
        ];
    }

}
