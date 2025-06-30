<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $subject_id
 * @property int $user_id
 * @property int $employee_id
 * @property string $title
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property int $department_id
 * @property int $position_id
 */
class Orders extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'employee_id', 'title', 'content', 'created_at', 'updated_at', 'status', 'department_id', 'position_id'], 'required'],
            [['user_id', 'employee_id', 'created_at', 'updated_at', 'status', 'department_id', 'position_id', 'subject_id'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_id' => 'Тема заявки',
            'user_id' => 'Пользователь',
            'employee_id' => 'Сотрудник',
            'title' => 'Название',
            'content' => 'Заявление',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'status' => 'Статус',
            'department_id' => 'Отдел',
            'position_id' => 'Должность',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'user_id',
            'employee_id',
            'employee_fullname' => function () {
                return $this->employee->fullname;
            },
            'title',
            'subject_id',
            'subject_name' => function () {
                return ($this->subject) ? $this->subject->name : '';
            },
            'content',
            'created_at' => function () {
                return date('d.m.Y H:i:s', $this->created_at);
            },
            'updated_at' => function () {
                return date('d.m.Y H:i:s', $this->updated_at);
            },
            'status' => function () {
                return Yii::$app->params['order_status'][$this->status];
            },
        ];
    }

    public function getEmployee()
    {
        return $this->hasOne(Employees::class, ['id' => 'employee_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    public function getPosition()
    {
        return $this->hasOne(Position::class, ['id' => 'position_id']);
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['order_id' => 'id']);
    }

    public function getSubject()
    {
        return $this->hasOne(OrderSubjects::class, ['id' => 'subject_id']);
    }
}
