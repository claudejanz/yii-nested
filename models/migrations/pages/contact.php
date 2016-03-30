<?php

use app\models\Address;
use app\models\Element;
use app\models\ElementText;
use app\models\Page;
use app\models\PageElement;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$page = new Page();
$page->title = 'Contact';
$page->controller = 'site';
$page->action = 'contact';
$page->breadcrumb_text = 'contact';
$page->published = PublishBehavior::PUBLISHED_ACTIF;
$page->meta_description = 'Prendre concat avec Schpfer ruedin SA';
$page->meta_keywords = $keywords_fr;
$page->type = Page::TYPE_STATIC;
$page->layout_id = 2;
//        $page->parent_id = 1;

if (!$page->save())
    var_dump(get_class($page), $page->errors);



$element = new Element();
$element->title = 'Adresse';
$element->type = Element::TYPE_TEXT;
$element->published = PublishBehavior::PUBLISHED_ACTIF;
if (!$element->save())
    var_dump(get_class($element), $element->errors);

$pw = new PageElement();
$pw->page_id = $page->id;
$pw->element_id = $element->id;
if (!$pw->save())
    var_dump(get_class($pw), $pw->errors);

$pt = new ElementText();
$pt->element_id = $element->id;
$pt->content = Html::beginTag('p') . 'N\'hésitez pas à nous contacter.' . Html::endTag('p') ;

if (!$pt->save())
    var_dump(get_class($pt), $pt->errors);

$address = new Address();
$address->setAttributes([
    'title'=>'schopfer.ruedin architectes sàrl',
    'street'=>'route de céligny 1',
    'city'=>'ch-1299 crans-près-céligny',
    'lat'=>'46.3572019',
    'lng'=>'6.2038004',
]);

if (!$address->save())
    var_dump(get_class($address), $address->errors);

$address = new Address();
$address->setAttributes([
    'title'=>'schopfer.ruedin architectes sàrl',
    'street'=>'rue du torrent 17',
    'city'=>'ch-1800 vevey',
    'lat'=>'46.4607598',
    'lng'=>'6.8400556',
]);

if (!$address->save())
    var_dump(get_class($address), $address->errors);



