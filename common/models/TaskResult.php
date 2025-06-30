<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_result".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property int $created_at
 * @property string|null $content
 */
class TaskResult extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'default', 'value' => null],
            [['task_id', 'user_id', 'created_at', 'content'], 'required'],
            [['task_id', 'user_id', 'created_at'], 'integer'],
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
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'created_at' => 'Дата создания',
            'content' => 'Комментарии',
        ];
    }
    public function fields()
    {
        return [
            'id',
            'task_token' => function () {
                return $this->task->token;
            },
            'user_id',
            'user_fullname' => function () {
                return $this->user->fullname;
            },
            'created_at' => function () {
                return date('d.m.Y H:i', $this->created_at);
            },
            'content'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

}
