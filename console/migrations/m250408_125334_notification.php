<?php

use yii\db\Migration;

class m250408_125334_notification extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'model_type' => $this->integer()->notNull(),
            'model_id' => $this->integer()->notNull(),
            'seen' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('notification');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250408_125334_notification cannot be reverted.\n";

        return false;
    }
    */
}
