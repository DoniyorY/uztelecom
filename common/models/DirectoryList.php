<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "directory_list".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name_ru
 * @property string $name_uzkyrl
 * @property string $name_uzlat
 * @property string $type
 * @property string|null $class_name
 * @property int|null $class_id
 *
 * @property DirectoryCategory $category
 */
class DirectoryList extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'directory_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_name', 'class_id'], 'default', 'value' => null],
            [['category_id', 'name_ru', 'name_uzkyrl', 'name_uzlat', 'type'], 'required'],
            [['category_id', 'class_id'], 'integer'],
            [['name_ru', 'name_uzkyrl', 'name_uzlat', 'type', 'class_name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DirectoryCategory::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name_ru' => 'Name Ru',
            'name_uzkyrl' => 'Name Uzkyrl',
            'name_uzlat' => 'Name Uzlat',
            'type' => 'Type',
            'class_name' => 'Class Name',
            'class_id' => 'Class ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(DirectoryCategory::class, ['id' => 'category_id']);
    }

}
