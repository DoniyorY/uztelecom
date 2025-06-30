<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $company_id
 * @property int $created_at
 * @property int $by_user_id //Создатель
 * @property int $user_id // Основной исполнитель
 * @property string|null $title
 * @property string|null $content
 * @property int $level_id
 * @property int $dead_line
 * @property int $status_id
 * @property int $position_id
 * @property int $finish_time
 */
class Task extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    public $task_members;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'default', 'value' => null],
            [['company_id', 'token', 'created_at', 'by_user_id', 'user_id', 'level_id', 'dead_line', 'status_id', 'position_id', 'finish_time'], 'required'],
            [['company_id', 'created_at', 'by_user_id', 'user_id', 'level_id', 'status_id', 'position_id', 'finish_time'], 'integer'],
            [['title', 'token'], 'string', 'max' => 255],
            [['content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Организация',
            'created_at' => 'Дата создание',
            'by_user_id' => 'Кем',
            'user_id' => 'Основной исполнитель',
            'title' => 'Заголовок',
            'content' => 'Описание задачи',
            'level_id' => 'Уровень важности',
            'dead_line' => 'Дата окончания',
            'status_id' => 'Статус задачи:',
            'position_id' => 'Позиция задачи:',
            'finish_time' => 'Конец задачи',
            'task_members' => 'Назначенные исполнители',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'token',
            'company_id' => function () {
                return Yii::$app->params['company_id'][$this->company_id];
            },
            'created_at' => function () {
                return date('d.m.Y H:i', $this->created_at);
            },
            'by_user_id',
            'by_user_fullname' => function () {
                return $this->byUser->fullname;
            },
            'by_user_avatar' => function () {
                return \Yii::$app->request->baseUrl . '/uploads/users/' . $this->byUser->image;
            },
            'user_id',
            'user_fullname' => function () {
                return $this->user->fullname;
            },
            'user_avatar' => function () {
                return \Yii::$app->request->baseUrl . '/uploads/users/'.$this->user->image;
            },
            'title',
            'content',
            'priority' => function () {
                return $this->level_id;
            },
            'dead_line' => function () {
                return date('d.m.Y H:i', $this->dead_line);
            },
            'status_id' => function () {
                return $this->status_id;
            },
            'finish_time' => function () {
                return date('d.m.Y H:i', $this->finish_time);
            }
        ];
    }

    public function getByUser()
    {
        return $this->hasOne(User::class, ['id' => 'by_user_id']);
    }

    public function getMembers()
    {
        return $this->hasMany(TaskMembers::class, ['task_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
