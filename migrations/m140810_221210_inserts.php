<?php

use app\models\Address;
use app\models\Element;
use app\models\Layout;
use claudejanz\toolbox\models\behaviors\CssClassBehavior;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use yii\db\Migration;

class m140810_221210_inserts extends Migration
{

    public function up()
    {
        $this->insertLayouts();
        $this->insertPages();
        $this->insertElements();
        $this->insertAddress();
    }

    public function insertPages()
    {
        Yii::$app->language = 'fr-CH';

        $keywords_fr = 'mulaff, coach, planning';
        include_once 'pages/home.php';
        include_once 'pages/sports.php';
        include_once 'pages/graphs.php';
        include_once 'pages/sport-type.php';
    }

    public function insertElements()
    {
        $element = new Element();
        $element->setAttributes(array(
            'class_css' => CssClassBehavior::CLASSCSS_PRIMARY,
            'title' => 'Naviagtion',
            'display_title' => 1,
            'type' => Element::TYPE_RELATED_MENU,
            'published' => PublishBehavior::PUBLISHED_ACTIF,
            'content' => '',
        ));
        $element->relations = ['places' => [2, 4, 5, 8]];

        if (!$element->save())
            var_dump(get_class($element), $element->errors);
    }

    public function insertLayouts()
    {
        $layout = new Layout();
        $layout->title = 'Home Page';
        $layout->path = Layout::PATH_FULL;
        if (!$layout->save())
            var_dump($layout->errors);

        $layout = new Layout();
        $layout->title = 'Layout pour: Admin';
        $layout->path = Layout::PATH_COLUMN1;
        if (!$layout->save())
            var_dump($layout->errors);

        $layout = new Layout();
        $layout->title = 'Layout pour: Create Update View Index';
        $layout->path = Layout::PATH_COLUMN2;
        if (!$layout->save())
            var_dump($layout->errors);

        $layout = new Layout();
        $layout->title = 'For test 3 Cols';
        $layout->path = Layout::PATH_COLUMN3;
        if (!$layout->save())
            var_dump($layout->errors);
    }

    public function down()
    {
//FileHelper::removeDirectory('web/images/events/');
        return true;
    }

    public function insertAddress()
    {
        $address = new Address();
        $address->setAttributes([
            'title' => 'Mulaff SA',
            'street' => 'Place Bel-Air 5',
            'city' => '1260 Nyon',
            'lat' => '46.3829236',
            'lng' => '6.2383268',
        ]);

        if (!$address->save())
            var_dump(get_class($address), $address->errors);
    }

}
