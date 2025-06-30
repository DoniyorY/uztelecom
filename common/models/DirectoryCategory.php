<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "directory_category".
 *
 * @property int $id
 * @property string $name_ru
 * @property string $name_uzkyrl
 * @property string $name_uzlat
 *
 * @property DirectoryList[] $directoryLists
 */
class DirectoryCategory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'directory_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_uzkyrl', 'name_uzlat'], 'required'],
            [['name_ru', 'name_uzkyrl', 'name_uzlat'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Name Ru',
            'name_uzkyrl' => 'Name Uzkyrl',
            'name_uzlat' => 'Name Uzlat',
        ];
    }

    /**
     * Gets query for [[DirectoryLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDirectoryLists()
    {
        return $this->hasMany(DirectoryList::class, ['category_id' => 'id']);
    }

}
