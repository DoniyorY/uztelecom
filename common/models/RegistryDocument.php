<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "registry_document".
 *
 * @property int $id
 * @property string|null $token
 * @property int $company_id
 * @property int $created_at
 * @property int $by_user_id
 * @property int $user_id
 * @property string|null $doc_number
 * @property string|null $doc_content
 * @property string|null $doc_date
 * @property string|null $file
 */
class RegistryDocument extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registry_document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'doc_number', 'doc_content', 'doc_date', 'file'], 'default', 'value' => null],
            [['company_id', 'created_at', 'by_user_id', 'user_id'], 'required'],
            [['company_id', 'created_at', 'by_user_id', 'user_id'], 'integer'],
            [['token', 'doc_number', 'doc_content', 'doc_date', 'file'], 'string', 'max' => 255],
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
            'company_id' => 'Company ID',
            'created_at' => 'Дата создание',
            'by_user_id' => 'Создатель',
            'user_id' => 'Для сотрудника',
            'doc_number' => 'Номер приказа',
            'doc_content' => 'Краткое содержание приказа',
            'doc_date' => 'Дата приказа ',
            'file' => 'Файл',
        ];
    }

    public function getByUser()
    {
        return $this->hasOne(User::class,['id' => 'by_user_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class,['id' => 'user_id']);
    }

}
