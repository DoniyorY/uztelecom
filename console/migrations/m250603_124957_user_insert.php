<?php

use yii\db\Migration;

class m250603_124957_user_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $user = \common\models\User::findOne(['id' => 1]);
        if ($user) return true;
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

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250603_124957_user_insert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250603_124957_user_insert cannot be reverted.\n";

        return false;
    }
    */
}
