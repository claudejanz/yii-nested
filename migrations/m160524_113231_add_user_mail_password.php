<?php

use yii\db\Migration;
use yii\db\sqlite\Schema;

class m160524_113231_add_user_mail_password extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'mail_password', Schema::TYPE_STRING . '(255) DEFAULT ""');
        return true;
    }

    public function down()
    {
       $this->dropColumn('{{%user}}', 'mail_password');
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
