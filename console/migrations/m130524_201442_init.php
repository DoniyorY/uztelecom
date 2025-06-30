<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addColumn('user', 'token', $this->string(50)->notNull());
        $this->addColumn('user', 'fullname', $this->string(255)->notNull());
        $this->addColumn('user', 'department_id', $this->string(255)->notNull());
        $this->addColumn('user', 'position_id', $this->string(255)->notNull());
        $this->addColumn('user', 'phone_number', $this->string(255)->notNull());
        $this->addColumn('user', 'image', $this->string(255)->notNull());
        $this->addColumn('user', 'gender', $this->string(10)->notNull());
        $this->addColumn('user', 'by_user_id', $this->string(10)->notNull());
        $this->addColumn('user', 'rating', $this->double(10)->notNull());

        $this->insert('user', [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'password_reset_token' => Yii::$app->security->generateRandomString(),
            'email' => 'admin@gmail.com',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
            'token' => Yii::$app->security->generateRandomString(6),
            'fullname' => 'Admin',
            'department_id' => 0,
            'position_id' => 0,
            'phone_number' => '+998995993603',
            'gender' => 'Мужчина',
            'by_user_id' => 1,
            'rating' => 0,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
