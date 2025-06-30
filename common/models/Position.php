<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "position".
 *
 * @property int $id
 * @property int $company_id
 * @property int $department_id
 * @property string|null $name
 * @property int $salary
 * @property int $one_hour
 * @property float $bid
 * @property int $created_at
 * @property int $user_id
 */
class Position extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'position';
    }

    public function getDepartment()
    {
        return $this->hasOne(\common\models\Department::className(), ['id' => 'department_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'default', 'value' => null],
            [['company_id', 'department_id', 'salary', 'one_hour', 'bid', 'created_at', 'user_id'], 'required'],
            [['company_id', 'department_id', 'salary', 'one_hour', 'created_at', 'user_id'], 'integer'],
            [['bid'], 'number'],
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
            'department_id' => 'Отдел',
            'name' => 'Должность',
            'salary' => 'Оклад',
            'one_hour' => '1 час',
            'bid' => 'Штатная единица',
            'created_at' => 'Дата создание',
            'user_id' => 'Ответственный',
        ];
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

}
