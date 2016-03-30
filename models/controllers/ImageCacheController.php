<?php

namespace app\controllers;

use RuntimeException;
use Yii;
use yii\helpers\FileHelper;
use yii\image\drivers\Image;
use yii\web\Controller;

class ImageCacheController extends Controller {

    public $slideshow = ['bouteilles.jpg'];
    public $original_path = '@webroot/';
    public $original_url = '@web/';
    private $formats = ['small', 'big','list','thumb','cube'];

    public function actionIndex($format, $path) {
        $fullpath = Yii::getAlias($this->original_path . $path);
        if (!is_file($fullpath)) {
            throw new RuntimeException('Original image not found');
        }
        if (!in_array($format, $this->formats)) {
            throw new RuntimeException('Transformation format not found');
        }
        echo $this->apply($format, $path, $fullpath);
    }

    public function apply($format, $path, $fullpath) {
        $image = Yii::$app->image->load($fullpath);
        switch ($format) {
            case 'small':
                $new_img = $image->resize(360, 360);
                break;
            case 'big':
                $new_img = $image->resize(1070);
               // $new_img = $image->crop(590 - 50, 1417 - 50, 26, 26)->resize(600, 600);
                break;
            case 'list':
                $new_img = $image->resize(360);
               // $new_img = $image->crop(590 - 50, 1417 - 50, 26, 26)->resize(600, 600);
                break;
            case 'thumb':
                $new_img = $image->resize(360,360);
                break;
            case 'cube':
                $new_img = $image->resize(100,100,Image::CROP);
                break;

            default:
                $new_img = $image;
                break;
        }
        $destination_path = Yii::getAlias($this->original_path . 'image-cache/' . $format . '/' . $path);
        FileHelper::createDirectory(dirname($destination_path),02777);
        $new_img->save($destination_path);
        header("Content-Type: image/jpeg");
        return $new_img->render();
    }

}
