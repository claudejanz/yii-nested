<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\filters;

use yii\base\Behavior;
use yii\web\Controller;

/**
 * Description of PageFilter
 *
 * @author Claude Janz <claude.janz@gmail.com>
 */
class PageFilter extends Behavior {

    /**
     * @var array this property defines the allowed actions.
     * If nothing is submitted ti applies to all actions
     *
     * For example,
     *
     * ~~~
     * ['create, 'update', 'delete']
     * ~~~
     */
    public $actions = [];

    public function events() {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    public function beforeAction($event) {
        $action = $this->owner->action->id;
        
        if(!empty($this->actions) && !in_array($action, $this->actions)){
            return $event->isValid;
        }
        $this->owner->setPage();
        
    }

}
