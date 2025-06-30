<?php

use yii\db\Migration;

class m250613_123700_add_column_to_employees extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('employees', 'position_id', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250613_123700_add_column_to_employees cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250613_123700_add_column_to_employees cannot be reverted.\n";

        return false;
    }
    */
}
