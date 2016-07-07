<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Handles adding readed_field to table `comment`.
 */
class m160706_082301_add_readed_field_to_comment extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('week_comment', 'read', Schema::TYPE_BOOLEAN.' DEFAULT 0 AFTER content');
        Yii::$app->db->createCommand()->update('week_comment', ['read' => 1],'id < 32')->execute();
        return true;
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('week_comment', 'read');
        return true;
    }
}
