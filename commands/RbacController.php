<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\rules\ChildRule;
use claudejanz\contextAccessFilter\rules\OwnRule;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * This command adds rbac entrys.
 *
 * @author Claude Janz <claude.janz@gmail.com>
 * @since 2.0
 */
class RbacController extends Controller
{

    public function actionIndex()
    {
        $auth = Yii::$app->authManager;

        $total = 25;
        Console::startProgress(0, $total, 'Doing Updates: ', false);
        $i = 1;


        $auth->removeAll();

        // permission créer un sportif
        $createSportifPerm = $auth->createPermission('create sportif');
        $createSportifPerm->description = 'créer un sportif';
        $auth->add($createSportifPerm);
        Console::updateProgress($i++, $total);

        // permission créer un entraineur
        $createTrainerPerm = $auth->createPermission('create trainer');
        $createTrainerPerm->description = 'créer un entraîneur';
        $auth->add($createTrainerPerm);
        Console::updateProgress($i++, $total);

        // permission mettre à jour un utilisateur
        $updateUserPerm = $auth->createPermission('update user');
        $updateUserPerm->description = 'mettre à jour un user';
        $auth->add($updateUserPerm);
        Console::updateProgress($i++, $total);

        // création de la règle "est à moi"
        $ownRule = new OwnRule(['name' => 'isSelf', 'param' => 'id']);
        $auth->add($ownRule);
        Console::updateProgress($i++, $total);

        // permission "mettre à jour mon propre utilisateur" est associer la règle "est à moi"
        $updateOwnUserPerm = $auth->createPermission('update own user');
        $updateOwnUserPerm->description = 'update own user';
        $updateOwnUserPerm->ruleName = $ownRule->name;
        $auth->add($updateOwnUserPerm);
        $auth->addChild($updateOwnUserPerm, $updateUserPerm);
        Console::updateProgress($i++, $total);

        // création de la règle "est à moi"
        $childRule = new ChildRule();
        $auth->add($childRule);
        Console::updateProgress($i++, $total);

        // permission "mettre à jour mon propre utilisateur" est associer la règle "est à moi"
        $updateChildUserPerm = $auth->createPermission('update child user');
        $updateChildUserPerm->description = 'update child user';
        $updateChildUserPerm->ruleName = $childRule->name;
        $auth->add($updateChildUserPerm);
        $auth->addChild($updateChildUserPerm, $updateUserPerm);
        Console::updateProgress($i++, $total);

        // add "report" permission
        $reportPerm = $auth->createPermission('report');
        $reportPerm->description = 'reporting';
        $auth->add($reportPerm);
        Console::updateProgress($i++, $total);



        // add "coaching" permission
        $coachingPerm = $auth->createPermission('coaching');
        $coachingPerm->description = 'coacher tous les sportif';
        $auth->add($coachingPerm);
        Console::updateProgress($i++, $total);

        // création de la règle "est mon entraîneur"
        $ownSportifRule = new OwnRule(['name' => 'isMySportif', 'param' => 'trainer_id']);
        $auth->add($ownSportifRule);
        Console::updateProgress($i++, $total);

        // permission "coacher ses propres sportifs" est associer la règle "est à moi"
        $coachOwnSportifPerm = $auth->createPermission('coach own sportif');
        $coachOwnSportifPerm->description = 'coacher ses propres sportifs';
        $coachOwnSportifPerm->ruleName = $ownSportifRule->name;
        $auth->add($coachOwnSportifPerm);
        $auth->addChild($coachOwnSportifPerm, $coachingPerm);
        Console::updateProgress($i++, $total);

        // permission "mettre à jour ses sportifs" est associer la règle "est à moi"
        $updateOwnSportifPerm = $auth->createPermission('update own sportif');
        $updateOwnSportifPerm->description = 'mettre à jour ses sportifs';
        $updateOwnSportifPerm->ruleName = $ownSportifRule->name;
        $auth->add($updateOwnSportifPerm);
        $auth->addChild($updateOwnSportifPerm, $updateUserPerm);
        Console::updateProgress($i++, $total);



        // add "publish" permission
        $updatePerm = $auth->createPermission('update');
        $updatePerm->description = 'update enregistrement';
        $auth->add($updatePerm);
        Console::updateProgress($i++, $total);
        // add "publish" permission
        $publishPerm = $auth->createPermission('publish');
        $publishPerm->description = 'publish enregistrement';
        $auth->add($publishPerm);
        Console::updateProgress($i++, $total);

        // add "delete" permission
        $deletePerm = $auth->createPermission('delete');
        $deletePerm->description = 'delete enregistrement';
        $auth->add($deletePerm);
        Console::updateProgress($i++, $total);

        // création de la règle "est créer par moi"
        $ownCreateRule = new OwnRule();
        $auth->add($ownCreateRule);
        Console::updateProgress($i++, $total);

        // add the "deleteOwn" permission and associate the rule with it.
        $deleteOwnPerm = $auth->createPermission('delete own');
        $deleteOwnPerm->description = 'delete own creation';
        $deleteOwnPerm->ruleName = $ownCreateRule->name;
        $auth->add($deleteOwnPerm);
        $auth->addChild($deleteOwnPerm, $deletePerm);
        Console::updateProgress($i++, $total);


        /**
         * USER
         */
        // add "sportif" role 
        $sportif = $auth->createRole('sportif');
        $auth->add($sportif);
        $auth->addChild($sportif, $updateOwnUserPerm);
        $auth->addChild($sportif, $reportPerm);
        Console::updateProgress($i++, $total);

        // add "editor" role
        $coach = $auth->createRole('coach');
        $auth->add($coach);
        $auth->addChild($coach, $sportif);

        $auth->addChild($coach, $createSportifPerm);
        $auth->addChild($coach, $coachOwnSportifPerm);
        $auth->addChild($coach, $updateOwnSportifPerm);
        $auth->addChild($coach, $deleteOwnPerm);
        Console::updateProgress($i++, $total);

        // add "admin" role 
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $coach);

        $auth->addChild($admin, $createTrainerPerm);
        $auth->addChild($admin, $updateChildUserPerm);
        $auth->addChild($admin, $coachingPerm);
        $auth->addChild($admin, $updatePerm);
        $auth->addChild($admin, $publishPerm);
        $auth->addChild($admin, $deletePerm);
        Console::updateProgress($i++, $total);


        // add "admin" role and give this role the "update" permission
        // as well as the permissions of the "publisher" role
        $superadmin = $auth->createRole('super admin');
        $auth->add($superadmin);
        $auth->addChild($superadmin, $updateUserPerm);
        $auth->addChild($superadmin, $admin);

        Console::updateProgress($i++, $total);

        // Assign roles to users. 10, 14 and 26 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $users = \app\models\User::find()->select('id')->where(['>', 'id', 3])->column();
        foreach ($users as $value) {

            $auth->assign($sportif, $value);
        }
        Console::updateProgress($i++, $total);
        
        $auth->assign($coach, 3);
        Console::updateProgress($i++, $total);
        $auth->assign($admin, 2);
        Console::updateProgress($i++, $total);
        $auth->assign($superadmin, 1);
        Console::updateProgress($i++, $total);

        Console::endProgress("done." . PHP_EOL);

        echo $this->ansiFormat('Structure recreated', Console::FG_YELLOW);
    }

}
