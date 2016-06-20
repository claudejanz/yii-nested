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
 * @property string $viewStyle Getter and Setter for setting view style. This property is read write.
 * @property string $planningAfterModify Getter to get length for selecting elements. This property is read-only.
 * @property string $planningBeforeModify Getter to get length for selecting elements. This property is read-only.
 * @property boolean $isCoach Getter to if user is a coach.
 */
class WebUser extends User
{

    public function getPlanningStyle()
    {
        return $this->viewStyle;
    }

    const VIEWSTYLE_NORMAL = 'normal';
    const VIEWSTYLE_COACH = 'coach';
    const VIEWSTYLE_PDF = 'pdf';

    public function getPlanningAfterModifiy()
    {
        switch ($this->viewStyle) {
            case self::VIEWSTYLE_NORMAL:
                return '+13days';
            case self::VIEWSTYLE_COACH:
                return '+13days';
                break;
            case self::VIEWSTYLE_PDF:
                return '+6days';
                break;
            default:
                return '+13days';
                break;
        }
    }

    public function getPlanningBeforeModifiy()
    {
        switch ($this->viewStyle) {
            case self::VIEWSTYLE_NORMAL:
                return '+0day';
            case self::VIEWSTYLE_COACH:
                return '-7days';
                break;
            case self::VIEWSTYLE_PDF:
                return '+0day';
                break;
            default:
                return '+0day';
                break;
        }
    }

    private $_viewStyle;

    public function setViewStyle($style)
    {
        if (!$this->_viewStyle)
            switch ($style) {
                case self::VIEWSTYLE_NORMAL:
                case self::VIEWSTYLE_COACH:
                    Yii::$app->session->set('planningStyle', $style);
                    break;
                case self::VIEWSTYLE_PDF:
                default:
                    break;
            }
        $this->_viewStyle = $style;
        return true;
    }

    public function getViewStyle()
    {
        if (!$this->_viewStyle) {
            $this->_viewStyle = Yii::$app->session->get('planningStyle', self::VIEWSTYLE_NORMAL);
        }
        return $this->_viewStyle;
    }

    public static function getViewStyleOptions() {
        return [
            self::VIEWSTYLE_COACH  => Yii::t('app', 'VIEWSTYLE_COACH'),
            self::VIEWSTYLE_NORMAL => Yii::t('app', 'VIEWSTYLE_NORMAL'),
        ];
    }

    public function getIsCoach() {
        return $this->can('coach');
       }

}
