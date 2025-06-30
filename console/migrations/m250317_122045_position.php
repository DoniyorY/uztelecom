<?php

use yii\db\Migration;

class m250317_122045_position extends Migration
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

        $this->createTable('position', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'department_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->null(),
            'salary' => $this->integer()->notNull(),
            'one_hour' => $this->integer()->notNull(),
            'bid' => $this->double()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250317_122045_position cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250317_122045_position cannot be reverted.\n";

        return false;
    }
    */
}
