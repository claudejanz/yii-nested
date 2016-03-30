<?php

use app\models\Sport;
use app\models\User;
use app\models\UserSport;
use yii\db\Migration;

class m160301_115938_user_sport extends Migration
{

    public function up()
    {
        $user_ids = User::find()->select('id')->where(['>', 'id', 3])->column();
        $sports_ids = Sport::find()->select('id')->column();
        foreach ($user_ids as $user_id) {
            shuffle($sports_ids);
            $num = ceil(rand(2, 6));
            for ($index = 0; $index < $num; $index++) {
                $us = new UserSport();
                $us->setAttributes([
                    'user_id' => $user_id,
                    'sport_id' => $sports_ids[$index],
                ]);
                if (!$us->save())
                    var_dump(get_class($us), $us->errors);
            }
        }

        

        return true;
    }

    public function down()
    {
        $this->delete('user_sport');
        return true;
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
