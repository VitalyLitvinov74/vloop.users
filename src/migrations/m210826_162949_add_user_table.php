<?php

use yii\db\Migration;

/**
 * Class m210826_162949_add_user_table
 */
class m210826_162949_add_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vloop_users', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(32)->notNull()->unique(),
            'auth_key'=>$this->string(32)->notNull()->unique(),
            'password_hash' => $this->string(32)->notNull()->unique(),
            'access_token'=>$this->string(32)->notNull()->unique()
        ]);
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
        echo "m210826_162949_add_user_table cannot be reverted.\n";

        return false;
    }
    */
}
