<?php

use yii\db\Migration;

class m250417_124049_employees_children extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('employees_children', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer(),
            'fullname' => $this->string(255)->notNull(),
            'birthday' => $this->integer()->notNull(),

        ]);
        $this->addForeignKey('fk_employees_children_employee_id',
            'employees_children',
            'employee_id',
            'employees',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_employees_children_employee_id', 'employees_children');
        $this->dropTable('employees_children');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250417_124049_employees_children cannot be reverted.\n";

        return false;
    }
    */
}
