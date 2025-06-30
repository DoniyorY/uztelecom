<?php

use yii\db\Migration;

class m250419_173021_user_visiting extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return true;
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('user_visiting', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'time_int' => $this->integer()->notNull(),
            'time_date' => $this->string(255)->notNull(),
            'terminal_employee_no' => $this->integer()->notNull(),
            'terminal_card' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250419_173021_user_visiting cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250419_173021_user_visiting cannot be reverted.\n";

        return false;
    }
    */
}
