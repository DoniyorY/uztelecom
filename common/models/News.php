<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $image
 * @property int $status
 * @property int $created_at
 */
class News extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'content', 'image', 'status', 'created_at'], 'required'],
            [['content'], 'string'],
            [['status', 'created_at'], 'integer'],
            [['title', 'description', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Короткое описание',
            'content' => 'Полное описание',
            'image' => 'Фото',
            'status' => 'Статус',
            'created_at' => 'Дата',
        ];
    }

}
