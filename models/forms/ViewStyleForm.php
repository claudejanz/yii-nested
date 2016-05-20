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

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * Description of ViewStyleForm
 *
 * @author Claude
 */
class ViewStyleForm extends Model
{

    public $viewStyle;

    public function init() {
        parent::init();
        $this->viewStyle = Yii::$app->user->viewStyle;
}

    public function attributeLabels(){
        return [
            'viewStyle' => Yii::t('app', 'View style'),
        ];
    }

}
