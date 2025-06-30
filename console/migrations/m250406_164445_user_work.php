<?php

use yii\db\Migration;

class m250406_164445_user_work extends Migration
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
        $this->createTable('user_work', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'company_id' => $this->integer()->notNull(),
            'department_id' => $this->integer()->notNull(),
            'position_id' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'salary' => $this->integer()->notNull(),
            'one_hour' => $this->integer()->notNull(),
            'bid' => $this->double()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250406_164445_user_work cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250406_164445_user_work cannot be reverted.\n";

        return false;
    }
    */
}
