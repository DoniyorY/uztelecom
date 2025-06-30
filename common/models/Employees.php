<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property int $department_id
 * @property int $position_id
 * @property int $user_id
 * @property string $fullname
 * @property int $sex
 * @property int $birthday
 * @property int $nationality
 * @property int $family_status
 * @property string $passport_series
 * @property string $passport_pinfl
 * @property string|null $passport_inn
 * @property int $passport_end_date
 * @property string $passport_whois
 * @property int $citizenship
 * @property int $birthday_city
 * @property int $postcode
 * @property string $mobile_phone
 * @property string|null $work_phone
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $address_registration
 * @property string|null $temporary_registration_address
 * @property int $tra_start_date
 * @property int $tra_end_date
 * @property string $image
 * @property int $created
 * @property int $updated
 * @property int $status
 *
 */
class Employees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    public $imageFile;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname', 'sex', 'birthday', 'nationality', 'family_status', 'passport_series', 'passport_pinfl', 'passport_end_date', 'passport_whois', 'citizenship', 'birthday_city', 'postcode', 'mobile_phone', 'city', 'area', 'address', 'address_registration', 'image', 'created', 'updated', 'status'], 'required'],
            [['sex', 'birthday', 'nationality', 'family_status', 'passport_end_date', 'citizenship', 'birthday_city', 'postcode', 'created', 'updated', 'status'], 'default', 'value' => null],
            [['sex', 'nationality', 'family_status', 'citizenship', 'birthday_city', 'postcode', 'created', 'updated', 'status', 'user_id'], 'integer'],
            [['fullname', 'passport_series', 'passport_pinfl', 'passport_inn', 'passport_whois', 'mobile_phone', 'work_phone', 'city', 'area', 'address', 'address_registration', 'temporary_registration_address', 'image'], 'string', 'max' => 255],
            [['tra_start_date', 'tra_end_date', ], 'string', 'max' => 20],
            [['tra_start_date', 'tra_end_date'], 'default', 'value' => 0],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№ карточки',
            'fullname' => 'Ф.И.О',
            'sex' => 'Пол',
            'birthday' => 'Дата рождения',
            'nationality' => 'Национальность',
            'family_status' => 'Семейное положение',
            'passport_series' => 'Серия паспорта',
            'passport_pinfl' => 'ПИНФЛ',
            'passport_inn' => 'ИНН (Для иностранных граждан)',
            'passport_end_date' => 'Дата окончания паспорта',
            'passport_whois' => 'Кем выдан',
            'citizenship' => 'Гражданин какой страны',
            'birthday_city' => 'Birthday City',
            'postcode' => 'Посткод',
            'mobile_phone' => 'Номер телефона',
            'work_phone' => 'Рабочий телефон',
            'city' => 'Город',
            'area' => 'Область',
            'address' => 'Адрес',
            'address_registration' => 'Адрес регистрации',
            'temporary_registration_address' => 'Временный адрес регистрации',
            'tra_start_date' => 'Дата начала регистрации',
            'tra_end_date' => 'Дата окончания регистрации',
            'image' => 'Изображение',
            'imageFile' => 'Изображение',
            'created' => 'Дата создания',
            'updated' => 'Дата обновления',
            'status' => 'Статус',
        ];
    }


    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    public function getDirectory($id)
    {
        $lang = Yii::$app->language;
        $dir = DirectoryList::findOne($id);
        return $dir->{"name_$lang"};
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
