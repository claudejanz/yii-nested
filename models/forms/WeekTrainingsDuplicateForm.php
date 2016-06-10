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

use app\extentions\behaviors\WeekPublishBehavior;
use app\models\Training;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Form to copy Day
 */
class WeekTrainingsDuplicateForm extends Model
{

    public $sportif_id;
    public $date;
    public $week;
    public $days;

    public function rules()
{
        return [
            [['sportif_id', 'date', 'week'], 'required'],
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
        $count = 0;
        $date =  new \app\extentions\helpers\EuroDateTime($this->date);
        if ($this->validate()) {
            foreach ($this->week->trainingsByDate as $key => $rows) {
                if($count>0){
                    $date->modify('+1day');
                }
                foreach ($rows as $training) {

                    /* @var $training Training */
                    $t = $training->colon();
                    $t->date = $date->format('Y-m-d');
                    $t->sportif_id = $this->sportif_id;
                    if (!$t->save()) {
                        return false;
                    }
                }
                $count++;
            }
            return true;
        }

        return false;
    }

}
