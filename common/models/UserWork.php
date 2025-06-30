<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_work".
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property int $department_id
 * @property int $position_id
 * @property int $updated_at
 * @property int $salary
 * @property int $one_hour
 * @property int $status_id
 * @property float $bid
 */
class UserWork extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_work';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'company_id', 'department_id', 'position_id', 'updated_at', 'salary', 'one_hour', 'bid'], 'required'],
            [['user_id', 'company_id', 'department_id', 'position_id', 'updated_at', 'salary', 'one_hour','status_id'], 'integer'],
            [['bid'], 'number'],
        ];
    }
    public function getUser()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'user_id']);
    }
    public function getPosition()
    {
        return $this->hasOne(\common\models\Position::class, ['id' => 'position_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'status_id'=>'status_id',
            'user_id' => 'User ID',
            'company_id' => 'Company ID',
            'department_id' => 'Department ID',
            'position_id' => 'Position ID',
            'updated_at' => 'Updated At',
            'salary' => 'Salary',
            'one_hour' => 'One Hour',
            'bid' => 'Bid',
        ];
    }

}
