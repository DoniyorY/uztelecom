<?php

use yii\db\Migration;

class m250316_122018_task extends Migration
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

        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'token' => $this->string(255)->null(),
            'company_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'by_user_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->null(),
            'content' => $this->text()->null(),
            'level_id' => $this->integer()->notNull(),
            'dead_line' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'position_id' => $this->integer()->notNull(),
            'finish_time' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250316_122018_task cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250316_122018_task cannot be reverted.\n";

        return false;
    }
    */
}
