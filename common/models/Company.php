<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property string $region_id
 */
class Company extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','region_id'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['region_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'region_id'=>'Регион'
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }
}
