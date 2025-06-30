<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $name
 * @property int $head_id
 * @property int $created_at
 */
class Department extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'default', 'value' => null],
            [['company_id', 'created_at'], 'required'],
            [['company_id', 'head_id', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Компания',
            'name' => 'Наименование отдела',
            'head_id' => 'Руководитель отдела',
            'created_at' => 'Дата создание',
        ];
    }

    public function getDephead()
    {
        return $this->hasOne(User::class, ['id' => 'head_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'head_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    public function getInfo()
    {
        return "{$this->name} | {$this->company->name}";
    }
}
