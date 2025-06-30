<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_comment".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property int $created_at
 * @property string|null $content
 */
class TaskComment extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_comment';
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
            [['content'], 'string', 'max' => 255],
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
            'content' => 'Комментарий',
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

    public function fields()
    {
        return [
            'id',
            'task_token' => function ($data) {
                return $this->task->token;
            },
            'user_id',
            'user_fullname' => function ($data) {
                return $this->user->fullname;
            },
            'created_at' => function ($data) {
                return date('d.m.Y H:i', $this->created_at);
            },
            'content'
        ];
    }

}
