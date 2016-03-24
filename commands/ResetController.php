<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
use yii\console\Controller;
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

        $user = User::findOne(['username' => 'claude']);
        if ($user)
            $user->delete();
        echo $this->ansiFormat("Ok reseted\n", Console::FG_YELLOW);
    }

}
