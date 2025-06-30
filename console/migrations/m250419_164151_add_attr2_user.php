<?php

use yii\db\Migration;

class m250419_164151_add_attr2_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'terminal_employee_no', $this->integer()->notNull());
        $this->addColumn('user', 'terminal_card', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250419_164151_add_attr2_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250419_164151_add_attr2_user cannot be reverted.\n";

        return false;
    }
    */
}
