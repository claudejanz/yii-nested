<?php

use yii\db\Migration;

class m160602_093512_import_sql_data extends Migration
{
    public function up()
    {
        $this->execute('DELETE FROM training_type_lang WHERE id>39');
        $this->execute('DELETE FROM training_type WHERE id>39');
        $content = file_get_contents(dirname(__FILE__).'/sqls/mwgx_coach_table_training_type.sql');
        $this->execute($content);
        $content = file_get_contents(dirname(__FILE__).'/sqls/mwgx_coach_table_training_type_lang.sql');
        $this->execute($content);
        $content = file_get_contents(dirname(__FILE__).'/sqls/mwgx_coach_table_week.sql');
        $this->execute($content);
        $content = file_get_contents(dirname(__FILE__).'/sqls/mwgx_coach_table_day.sql');
        $this->execute($content);
        $content = file_get_contents(dirname(__FILE__).'/sqls/mwgx_coach_table_competition.sql');
        $this->execute($content);
        $content = file_get_contents(dirname(__FILE__).'/sqls/mwgx_coach_table_training.sql');
        $this->execute($content);
        $content = file_get_contents(dirname(__FILE__).'/sqls/mwgx_coach_table_reporting.sql');
        $this->execute($content);
    }

    public function down()
    {

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
