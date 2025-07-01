<?php

use yii\db\Migration;

class m250701_061916_regions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('regions', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
        $this->addColumn('company', 'region_id', $this->integer());
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250701_061916_regions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250701_061916_regions cannot be reverted.\n";

        return false;
    }
    */
}
