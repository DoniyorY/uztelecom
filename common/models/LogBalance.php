<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_balance".
 *
 * @property int $id
 * @property string $token
 * @property int $user_id
 * @property int $created_at
 * @property int $value
 * @property int $type
 * @property string $content
 */
class LogBalance extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'user_id', 'created_at', 'value', 'type', 'content'], 'required'],
            [['user_id', 'created_at', 'value', 'type'], 'integer'],
            [['token', 'content'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'value' => 'Value',
            'type' => 'Type',
            'content' => 'Content',
        ];
    }

}
