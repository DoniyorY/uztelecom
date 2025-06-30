<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property int $user_id
 * @property int $created_at
 * @property string $title
 * @property int $model_type
 * @property int $model_id
 * @property int $seen
 */
class Notifications extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'title', 'model_type', 'model_id', 'seen'], 'required'],
            [['user_id', 'created_at', 'model_type', 'model_id', 'seen'], 'integer'],
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
            'user_id' => 'Сотрудник',
            'created_at' => 'Дата создания',
            'title' => 'Заголовок',
            'model_type' => 'Тип модели',
            'model_id' => 'ID Модели',
            'seen' => 'Посмотрено',
        ];
    }

}
