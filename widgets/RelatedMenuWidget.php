<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\widgets;

use app\models\Page;
use kartik\icons\Icon;
use Yii;
use yii\widgets\Menu;

/**
 * Description of RelatedMenuWidget
 *
 * @author Claude
 */
class RelatedMenuWidget extends Menu
{

    public function init()
    {
        $this->options['class'] = 'nav nav-pills nav-stacked';
        $this->items = $this->getRelatedMenu();
        parent::init();
    }

    public $_relatedMenu;

    public function getRelatedMenu()
    {
        if (!isset($this->_relatedMenu)) {

            $arr = [];


            $controller = Yii::$app->controller;
            $controllerName = $controller->id;
            $actionName = $controller->action->id;




//            $page = $controller->page;
//            if ($page) {
//                if (Yii::$app->user->can('admin'))
//                    if (!($controllerName = 'pages' && $actionName == 'index'))
//                        $arr[] = ['label' => Icon::show('list') . Yii::t('app', 'List {modelClass}', ['modelClass' => $page->getLabel(2)]), 'url' => ['pages/index'], 'encode' => false];
//
//                if (Yii::$app->user->can('admin'))
//                    if (!($controllerName = 'pages' && $actionName == 'create'))
//                        $arr[] = ['label' => Icon::show('plus') . Yii::t('app', 'Create {modelClass}', ['modelClass' => $page->getLabel()]), 'url' => ['pages/create'], 'encode' => false];
//
//                if (!$page->isNewRecord)
//                    if (Yii::$app->user->can('admin'))
//                        if (!($controllerName = 'pages' && $actionName == 'update'))
//                            $arr[] = ['label' => Icon::show('pencil') . Yii::t('app', 'Update {modelClass}', ['modelClass' => $page->getLabel()]), 'url' => ['pages/update', 'id' => $page->id], 'encode' => false];
//
//                if (!$page->isNewRecord)
//                    if (Yii::$app->user->can('admin'))
//                        if (!($controllerName = 'pages' && $actionName == 'delete'))
//                            $arr[] = ['label' => Icon::show('remove') . Yii::t('app', 'Delete {modelClass}', ['modelClass' => $page->getLabel()]), 'encode' => false, 'url' => '#', 'linkOptions' => ['submit' => ['pages/delete', 'id' => $page->id], 'confirm' => Yii::t('app', 'Are you sure you want to delete this item?')]];
//            }
//            if ($controller->model && !($controller->model instanceof Page)) {
//                $rel = $controller->model;
//                $params = ($rel) ? ['model' => $rel] : [];
//
//                if (Yii::$app->user->can('admin'))
//                    if ($actionName != 'index')
//                        $arr[] = ['label' => Icon::show('list') . Yii::t('app', 'List {modelClass}', ['modelClass' => $rel->getLabel(2)]), 'url' => ['index'], 'encode' => false];
//
//                if (Yii::$app->user->can('create'))
//                    if ($actionName != 'create')
//                        $arr[] = ['label' => Icon::show('plus') . Yii::t('app', 'Create {modelClass}', ['modelClass' => $rel->getLabel()]), 'url' => ['create'], 'encode' => false];
//
//                if (!$rel->isNewRecord)
//                    if (Yii::$app->user->can('view', $params))
//                        if ($actionName != 'view')
//                            $arr[] = ['label' => Icon::show('eye-open') . Yii::t('app', 'View {modelClass}', ['modelClass' => $rel->getLabel()]), 'url' => ['view', 'id' => $rel->id], 'encode' => false];
//
//
//                if (!$rel->isNewRecord)
//                    if (Yii::$app->user->can('update', $params))
//                        if ($actionName != 'update')
//                            $arr[] = ['label' => Icon::show('pencil') . Yii::t('app', 'Update {modelClass}', ['modelClass' => $rel->getLabel()]), 'url' => ['update', 'id' => $rel->id], 'encode' => false];
//
//                if (!$rel->isNewRecord)
//                    if (Yii::$app->user->can('update', $params))
//                        if ($actionName != 'order-image')
//                            $arr[] = ['label' => Icon::show('sort') . Yii::t('app', 'Order Images {modelClass}', ['modelClass' => $rel->getLabel()]), 'url' => ['order-image', 'id' => $rel->id], 'encode' => false];
//
//
//                if (!$rel->isNewRecord)
//                    if (Yii::$app->user->can('delete', $params))
//                        if ($actionName != 'delete')
//                            $arr[] = ['label' => Icon::show('remove') . Yii::t('app', 'Delete {modelClass}', ['modelClass' => $rel->getLabel()]), 'encode' => false, 'url' => '#', 'linkOptions' => ['submit' => ['delete', 'id' => $rel->id], 'confirm' => Yii::t('app', 'Are you sure you want to delete this item?')]];
//            }
//
////                        if (Yii::$app->user->can('update', $params))
////                            if ($actionName != 'order')
////                                $arr[] = ['label' => Icon::show('sort') . Yii::t('app', 'Order {modelClass}', ['modelClass' => $rel->getLabel(2)]), 'url' => ['order', 'id' => $rel->id], 'encode' => false];
////            if ($rel)
////                if (strcasecmp($controllerName, 'Newsletter') == 0 && Yii::$app->user->can('send'))
////                    if ($actionName != 'send')
////                        $arr[] = ['label' => Yii::t('app', 'Send') . ' ' . $this->label(), 'url' => ['chooseRecivers', 'id' => $rel->id));
//
//




            $this->_relatedMenu = $arr;
        }
        return $this->_relatedMenu;
    }

}
