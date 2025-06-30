<?php

use yii\db\Migration;

class m250406_094006_employee extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('employees', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'fullname' => $this->string()->notNull(),
            'sex' => $this->integer()->notNull(),
            'birthday' => $this->integer()->notNull(),
            'nationality' => $this->integer()->notNull(), //Национальность
            'family_status' => $this->integer()->notNull(),
            'passport_series' => $this->string()->notNull(),
            'passport_pinfl' => $this->string()->notNull(),
            'passport_inn' => $this->string()->null(),
            'passport_end_date' => $this->integer()->notNull(),
            'passport_whois' => $this->string()->notNull(),
            'citizenship' => $this->integer()->notNull(), //Гражданин какой страны
            'birthday_city' => $this->integer()->notNull(), //Место рождения
            'postcode' => $this->integer()->notNull(), //Почтовый индекс
            'mobile_phone' => $this->string()->notNull(),
            'work_phone' => $this->string()->null(),
            'city' => $this->string()->notNull(), //Город
            'area' => $this->string()->notNull(), //Район
            'address' => $this->string()->notNull(),
            'address_registration' => $this->string()->notNull(), // Адрес прописки
            'temporary_registration_address' => $this->string()->null(), // Временный адрес прописки
            'tra_start_date' => $this->integer()->notNull(), // Дата начала временной прописки
            'tra_end_date' => $this->integer()->notNull(), // Дата окончания временной прописки
            'image' => $this->string()->notNull(),
            'created' => $this->integer()->notNull(),
            'updated' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('employees');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250406_094006_employee cannot be reverted.\n";

        return false;
    }
    */
}
