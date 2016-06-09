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

use app\models\Training;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Form to copy Day
 */
class DayTrainingsDuplicateForm extends Model
{

    public $sportif_id;
    public $date;
    public $day;

    public function rules()
{
        return [
            [['sportif_id', 'date','day'], 'required'],
            [['sportif_id'], 'integer'],
            [['date'], 'safe'],
            [['sportif_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sportif_id' => 'id']],
//            [['date'], 'getDays'],
        ];
}

    public function attributeLabels()
    {
        return [
            'sportif_id' => Yii::t('app', 'Sportif ID'),
            'date'       => Yii::t('app', 'Date'),
        ];
    }

    /**
     * Copys all trainings from given day
     * @return boolean if valid and copyed
     */
    public function save(){
        if ($this->validate()) {
            foreach ($this->day->trainings as $training) {
                $t = new Training();
                $t->setAttributes($training->getAttributes());
                $t->date = $this->date;
                $t->sportif_id = $this->sportif_id;
                if (!$t->save()) {
                    return false;
                }
            }
            return true;
        }

        return false;
    }


}
