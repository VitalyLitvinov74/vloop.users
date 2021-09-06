<?php

use yii\db\Migration;

/**
 * Class m210831_124859_add_fields_to_users_table
 */
class m210831_124859_add_fields_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vloop_users', 'login', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vloop_users');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210831_124859_add_fields_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
