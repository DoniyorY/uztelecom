<?php

use yii\db\Migration;

class m250630_200734_add_position_id_to_employee extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('employees', 'position_id', $this->integer()->notNull());
        $this->addColumn('employees','company_id',$this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250630_200734_add_position_id_to_employee cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250630_200734_add_position_id_to_employee cannot be reverted.\n";

        return false;
    }
    */
}
