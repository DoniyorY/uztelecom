<?php

use yii\db\Migration;

class m250512_110811_order_subjects extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_subjects',[
            'id' => $this->primaryKey()->notNull(),
            'name'=>$this->string()->notNull(),
        ]);
        $this->addColumn('orders','subject_id',$this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250512_110811_order_subjects cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250512_110811_order_subjects cannot be reverted.\n";

        return false;
    }
    */
}
