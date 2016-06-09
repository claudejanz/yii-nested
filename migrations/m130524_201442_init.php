<?php

use yii\db\Schema;

class m130524_201442_init extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'firstname' => Schema::TYPE_STRING . ' NOT NULL COMMENT \'Prénom\'',
            'lastname' => Schema::TYPE_STRING . ' NOT NULL COMMENT \'Nom\'',
            'society' => Schema::TYPE_STRING . ' DEFAULT NULL COMMENT \'Société\'',
            'address' => Schema::TYPE_STRING . ' NOT NULL COMMENT \'Adresse\'',
            'npa' => Schema::TYPE_STRING . ' NOT NULL COMMENT \'NPA\'',
            'city' => Schema::TYPE_STRING . ' NOT NULL COMMENT \'Localité\'',
            'country' => Schema::TYPE_STRING . ' NOT NULL COMMENT \'Pays\'',
            'tel' => Schema::TYPE_STRING . ' NOT NULL COMMENT \'Téléphone\'',
            'username' => Schema::TYPE_STRING . ' NOT NULL COMMENT \'Nom d\\\'utilisateur\'',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'comments' => Schema::TYPE_TEXT,
            'role' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'language' => Schema::TYPE_STRING . '(5) NOT NULL',
            'trainer_id' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'birthday' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'gender' => Schema::TYPE_SMALLINT . '  NOT NULL',
            'contrat_start' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'contrat_end' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'mail_password' => Schema::TYPE_STRING . '(255) DEFAULT ""',
            'mail_host' => Schema::TYPE_STRING . '(255) DEFAULT ""',
            'mail_port' => Schema::TYPE_INTEGER.'(11)',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'updated_by' => Schema::TYPE_INTEGER . '(11) NULL DEFAULT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'UNIQUE KEY username_UNIQUE (username)',
            'UNIQUE KEY email_UNIQUE (email)',
            'INDEX index_trainer (trainer_id ASC)',
            'FOREIGN KEY (trainer_id) REFERENCES user (id) ON DELETE SET NULL ON UPDATE CASCADE ',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
