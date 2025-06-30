<?php

use yii\db\Migration;

class m250401_045844_create_directory_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('directory_category', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string()->notNull(),
            'name_uzkyrl' => $this->string()->notNull(),
            'name_uzlat' => $this->string()->notNull(),
        ]);

        $this->createTable('directory_list', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name_ru' => $this->string(255)->notNull(),
            'name_uzkyrl' => $this->string(255)->notNull(),
            'name_uzlat' => $this->string(255)->notNull(),
            'type' => $this->string(255)->notNull(),
            'class_name' => $this->string(255)->null(),
            'class_id' => $this->integer()->null(),
        ]);

        // Добавляем внешний ключ
        $this->addForeignKey(
            'fk-directory_list-category_id',
            'directory_list',
            'category_id',
            'directory_category',
            'id',
            'CASCADE',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250401_045844_create_directory_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250401_045844_create_directory_tables cannot be reverted.\n";

        return false;
    }
    */
}
