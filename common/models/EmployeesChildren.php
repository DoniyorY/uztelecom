<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employees_children".
 *
 * @property int $id
 * @property int|null $employee_id
 * @property string $fullname
 * @property int $birthday
 *
 * @property Employees $employee
 */
class EmployeesChildren extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees_children';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id'], 'default', 'value' => null],
            [['employee_id'], 'integer'],
            [['fullname', 'birthday'], 'required'],
            [['fullname'], 'string', 'max' => 255],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::class, 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Сотрудник',
            'fullname' => 'Ф.И.О',
            'birthday' => 'Дата рождения',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employees::class, ['id' => 'employee_id']);
    }

}
