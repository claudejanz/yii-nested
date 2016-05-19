<?php
namespace app\models\rules;

use Yii;
use yii\rbac\Rule;

/*
 * Copyright (C) 2014 Claude Janz <claude.janz@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of OwnRule
 *
 * @author Claude Janz <claude.janz@gmail.com>
 */
class ChildRule extends Rule{
    public $name = 'isChild';
    
    public function execute($user, $item, $params) {
        return isset($params['model'])&&Yii::$app->user->identity ? $params['model']->role <= Yii::$app->user->identity->role : false;
    }
}
