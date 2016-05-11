<?php

/*
 * Copyright (C) 2016 Claude
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

namespace app\extentions;

use Yii;
use yii\web\User;

/**
 * Description of WebUser
 *
 * @author Claude
 * @property string $planningStyle Getter and Setter for 
 */
class WebUser extends User
{

    public function getPlanningStyle()
    {
        return $this->getViewStyle();
    }

    

    public function getPlanningLength()
    {
        switch ($this->getViewStyle()) {
            case 'short':
                return '+13days';
            case 'middle':
                return '+1month';
                break;
            case 'pdf':
                return '+6days';
                break;
            default:
                return '+13days';
                break;
        }
    }

    private $_viewStyle;

    public function setViewStyle($style)
    {
        if (!$this->_viewStyle)
            switch ($style) {
                case 'short':
                case 'middle':
                    Yii::$app->session->set('planningStyle', $style);
                    break;
                case 'pdf':
                default:
                    break;
            }
        $this->_viewStyle = $style;
        return true;
    }

    public function getViewStyle()
    {
        if (!$this->_viewStyle) {
            $this->_viewStyle = Yii::$app->session->get('planningStyle', 'short');
        }
        return $this->_viewStyle;
    }

}
