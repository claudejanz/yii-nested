<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\extentions\helpers\EuroDateTime;
use app\models\Day;
use app\models\Reporting;
use app\models\Training;
use app\models\User;
use yii\console\Controller;
use yii\db\Query;
use yii\helpers\Console;

/**
 * This command resets database for test execution.
 *
 * @author Claude Janz <claude.janz@gmail.com>
 * @since 2.0
 */
class ResetController extends Controller
{

    public function actionIndex()
    {
        $assets = [
            'user',
            'trainings',
        ];
        $sep = '----------------------------------------------' . PHP_EOL;
        $message = $sep;
        $message .= 'What do you want to clear?' . PHP_EOL;
        $valids = [];
        foreach ($assets as $key => $value) {
            $message.= $this->ansiFormat($key, Console::FG_GREY)
                    . $this->ansiFormat(' => ', Console::FG_GREEN)
                    . $this->ansiFormat($value, Console::FG_YELLOW) . PHP_EOL;
            $valids[] = $key;
        }
        $message.= $this->ansiFormat('all', Console::FG_GREY)
                . $this->ansiFormat(' => ', Console::FG_GREEN)
                . $this->ansiFormat('all', Console::FG_YELLOW) . PHP_EOL;
        $message .= $sep;

        $error = $this->ansiFormat('Not valid input', Console::FG_RED);
        $pattern = '@^((' . implode('|', $valids) . ',|all),?)+$@';
        $value = $this->prompt($message . 'Choices:', [
            'default' => '1',
            'pattern' => $pattern,
            'error'   => $error
        ]);

        $values = preg_split('@,@', $value, -1, PREG_SPLIT_NO_EMPTY);
        if (in_array('all', $values) ||in_array('1', $values)) {
            $this->chooseTime();
        }
        if (in_array('all', $values) || in_array('0', $values)) {
            $this->clearUser();
        }
        echo $sep;





    }

    public function clearUser() {
        $user = User::findOne(['username' => 'claude']);
        if ($user) {
            if ($user->delete()) {
                echo $this->ansiFormat("Ok user reseted\n", Console::FG_YELLOW);
            }
        }
        echo $this->ansiFormat("Ok user claude cleared\n", Console::FG_RED);
    }

    public function chooseTime() {
        $assets = [
            '+1Day',
            '+2Days',
            '+3Days',
            '+1Week',
            '+2Weeks',
            '+3Weeks',
        ];

        $message = $this->sep;
        $message .= 'How long?' . PHP_EOL;
        $valids = [];
        foreach ($assets as $key => $value) {
            $message.= $this->ansiFormat($key, Console::FG_GREY)
                    . $this->ansiFormat(' => ', Console::FG_GREEN)
                    . $this->ansiFormat($value, Console::FG_YELLOW) . PHP_EOL;
            $valids[] = $key;
        }
        $message .= $this->sep;

        $error = $this->ansiFormat('Not valid input', Console::FG_RED);
        $pattern = '@^(' . implode('|', $valids) . ')+$@';
        $value = $this->prompt($message . 'Choices:', [
            'default' => '3',
            'pattern' => $pattern,
            'error'   => $error
        ]);
        $date = new EuroDateTime();
        $date->modify($assets[$value]);
        $this->clearTrainings($date);
}

    public function clearTrainings($date) {
        $user = User::findOne(['username' => 'claude']);
        if ($user) {
            echo $this->sep;

            $training_ids = (new Query)->select(['id', 'date'])
                    ->from(['training'])
                    ->where(['sportif_id' => $user->id])
                    ->andWhere(['>', 'date', $date->format('Y-m-d')])
                    ->column();
            $day_ids = (new Query)->select(['id', 'date'])
                    ->from(['day'])
                    ->where(['sportif_id' => $user->id])
                    ->andWhere(['>', 'date', $date->format('Y-m-d')])
                    ->column();
            print('training: ');
            print_r($training_ids);
            print('day: ');
            print_r($day_ids);

            if ($training_ids) {
                Reporting::deleteAll(['in', 'training_id', $training_ids]);
                Training::deleteAll(['in', 'id', $training_ids]);
            }
            if ($day_ids) {
                Day::deleteAll(['in', 'id', $day_ids]);
            }
            echo $this->ansiFormat("Ok training reporting > " . $date->format('Y-m-d') . " cleared\n", Console::FG_RED);
        }
    }

    public function getSep() {
        return '----------------------------------------------' . PHP_EOL;
    }

}
