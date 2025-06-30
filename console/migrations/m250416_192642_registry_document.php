<?php

use yii\db\Migration;

class m250416_192642_registry_document extends Migration
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

        $this->createTable('registry_document', [
            'id' => $this->primaryKey(),
            'token' => $this->string(255)->null(),
            'company_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'by_user_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'doc_number' => $this->string(255)->null(),
            'doc_content' => $this->string(255)->null(),
            'doc_date' => $this->string(255)->null(),
            'file' => $this->string(255)->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250416_192642_registry_document cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250416_192642_registry_document cannot be reverted.\n";

        return false;
    }
    */
}
