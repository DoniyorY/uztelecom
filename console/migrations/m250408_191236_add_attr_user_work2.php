<?php

use yii\db\Migration;

class m250408_191236_add_attr_user_work2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user_work', 'bid'); 
        $this->addColumn('user_work', 'bid', $this->double()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250408_191236_add_attr_user_work2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250408_191236_add_attr_user_work2 cannot be reverted.\n";

        return false;
    }
    */
}
