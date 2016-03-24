<?php

use app\models\Page;
use claudejanz\toolbox\models\behaviors\PublishBehavior;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$page = new Page();
$page->title = 'Training Types';
$page->controller = 'training-types';
$page->action = 'index';
$page->breadcrumb_text = 'Training types';
//$page->home_page = 1;
$page->published = PublishBehavior::PUBLISHED_ACTIF;
$page->meta_description = 'Trainig';
$page->meta_keywords = $keywords_fr;
$page->type = Page::TYPE_DYNAMIC;
$page->layout_id = 2;
$page->rights = 'coach';

if (!$page->save())
    var_dump(get_class($page), $page->errors);





   