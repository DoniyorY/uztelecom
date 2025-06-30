<?php

use yii\db\Migration;

class m250401_092554_add_rbac_to_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName='{{%auth_item}}';
        if ($this->db->schema->getTableSchema($tableName, true) === null) {
            echo "$tableName doesn't exist.\n Run yii2 RBAC migrations.\n {yii migrate --migrationPath=@yii/rbac/migrations}";
            return false;
        }
        for ($i = 0; $i < 4; $i++) {
            switch ($i) {
                case 0:
                    $name = 'create';
                    break;
                case 1:
                    $name = 'view';
                    break;
                case 2:
                    $name = 'update';
                    break;
                case 3:
                    $name = 'delete';
                    break;
            }
            $this->insert('{{%auth_item}}', [
                'name' => $name,
                'type' => 2,
                'description' => '',
                'rule_name' => null,
                'data' => null,
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        }
        $this->insert('{{%auth_item}}', [
            'name' => 'admin',
            'type' => 1,
            'description' => 'Admin',
            'rule_name' => null,
            'data' => null,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%auth_assignment}}', [
            'item_name' => 'admin',
            'user_id' => 1,
            'created_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250401_092554_add_rbac_to_admin cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250401_092554_add_rbac_to_admin cannot be reverted.\n";

        return false;
    }
    */
}
