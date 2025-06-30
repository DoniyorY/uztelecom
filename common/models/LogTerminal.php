<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_terminal".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property string|null $data
 */
class LogTerminal extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_terminal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'status'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['data'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'data' => 'Data',
        ];
    }

}
