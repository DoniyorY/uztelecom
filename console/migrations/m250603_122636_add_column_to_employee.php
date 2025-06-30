<?php

use yii\db\Migration;

class m250603_122636_add_column_to_employee extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('employees', 'department_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250603_122636_add_column_to_employee cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250603_122636_add_column_to_employee cannot be reverted.\n";

        return false;
    }
    */
}
