<?php

use yii\db\Migration;

/**
 * Class m210831_173329_update_password_hash_field
 */
class m210831_173329_update_password_hash_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('vloop_users', 'password_hash', $this->string());
        $this->dropIndex('name','vloop_users');
        $this->alterColumn('vloop_users', 'name', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('vloop_users', 'name', $this->string(32)->unique()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210831_173329_update_password_hash_field cannot be reverted.\n";

        return false;
    }
    */
}
