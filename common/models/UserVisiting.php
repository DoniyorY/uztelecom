<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_visiting".
 *
 * @property int $id
 * @property int $created_at
 * @property int $type
 * @property int $time_int
 * @property string $time_date
 * @property int $terminal_employee_no
 * @property int $terminal_card
 */
class UserVisiting extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_visiting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'type', 'time_int', 'time_date', 'terminal_employee_no', 'terminal_card'], 'required'],
            [['created_at', 'type', 'time_int', 'terminal_employee_no', 'terminal_card'], 'integer'],
            [['time_date'], 'string', 'max' => 255],
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
            'type' => 'Тип',
            'time_int' => 'Дата действия',
            'time_date' => 'Дата действия',
            'terminal_employee_no' => 'Номер сотрудника',
            'terminal_card' => 'Карта сотрудника',
        ];
    }

}
