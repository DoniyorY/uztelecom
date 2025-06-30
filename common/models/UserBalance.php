<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_balance".
 *
 * @property int $id
 * @property int $user_id
 * @property int $uni_code
 * @property int $created_at
 * @property int $updated_at
 * @property int $value
 */
class UserBalance extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_balance';
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'uni_code', 'created_at', 'updated_at', 'value'], 'required'],
            [['user_id', 'uni_code', 'created_at', 'updated_at', 'value'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Сотрудник',
            'uni_code' => 'Код',
            'created_at' => 'Дата создание',
            'updated_at' => 'Дата изменение',
            'value' => 'Значение',
        ];
    }

}
