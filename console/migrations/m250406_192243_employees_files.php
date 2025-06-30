<?php

use yii\db\Migration;

class m250406_192243_employees_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('employees_files', [
            'id' => $this->primaryKey(),
            'employees_id' => $this->integer()->notNull(),
            'image' => $this->string(255)->null(),
            'type' => $this->string(255)->null(),
            'created_at' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250406_192243_employees_files cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250406_192243_employees_files cannot be reverted.\n";

        return false;
    }
    */
}
