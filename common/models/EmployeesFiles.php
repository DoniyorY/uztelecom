<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employees_files".
 *
 * @property int $id
 * @property int $employees_id
 * @property string|null $image
 * @property string|null $type
 * @property int $created_at
 * @property int $user_id
 */
class EmployeesFiles extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees_files';
    }
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'type'], 'default', 'value' => null],
            [['employees_id', 'created_at', 'user_id'], 'required'],
            [['employees_id', 'created_at', 'user_id'], 'integer'],
            [['image', 'type'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employees_id' => 'Employees ID',
            'image' => 'Файл',
            'imageFile' => 'Файл',
            'type' => 'Наименование файла',
            'created_at' => 'Created At',
            'user_id' => 'User ID',
        ];
    }

}
