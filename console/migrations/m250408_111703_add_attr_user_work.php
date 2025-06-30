<?php

use yii\db\Migration;

class m250408_111703_add_attr_user_work extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_work', 'status_id', $this->integer()->notNull());
        $this->addColumn('user_work', 'created_at', $this->integer()->notNull());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250408_111703_add_attr_user_work cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250408_111703_add_attr_user_work cannot be reverted.\n";

        return false;
    }
    */
}
