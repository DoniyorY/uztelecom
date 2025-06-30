<?php

namespace console\controllers;

use Faker\Factory;
use yii\console\Controller;
use common\models\User;
use common\models\Employees;
use common\models\EmployeesChildren;
use common\models\Position;
use common\models\DirectoryList;

class FactoryController extends Controller
{
    private $passportSeries = [
        'AA', // Республика Узбекистан (обычно для загранпаспортов)
        'AC', // Каракалпакстан
        'AD', // Андижан
        'AE', // Бухара
        'AF', // Джизак
        'AG', // Кашкадарья
        'AH', // Навои
        'AI', // Наманган
        'AJ', // Самарканд
        'AK', // Сурхандарья
        'AL', // Сырдарья
        'AM', // Ташкентская область
        'AN', // Фергана
        'AO', // Хорезм
        'AP', // г. Ташкент
    ];

    private function generateRandomPassport()
    {
        $series = $this->passportSeries[array_rand($this->passportSeries)];
        $number = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);

        return "$series $number";
    }

    public function actionCreateEmployee()
    {
        // 14.04.2025 - 15.04.2025
        for ($i = 0; $i < 50; $i++) {
            $t1 = \Yii::$app->security->generateRandomString(3);
            $t2 = \Yii::$app->security->generateRandomString(3);
            $t3 = \Yii::$app->security->generateRandomString(3);


            $factory = Factory::create('ru_RU');
            $user = new User();
            $user->setPassword('123123123');
            $user->generateAuthKey();
            $user->created_at = time();
            $user->updated_at = time();
            $user->fullname = $factory->name;
            $user->email = $factory->email;

            $parts = explode(' ', $user->fullname);

            if (count($parts) >= 2) {
                $login = mb_strtolower($parts[0] . '.' . $parts[1]); // фамилия.имя
            } else {
                $login = mb_strtolower(str_replace(' ', '.', $user->fullname)); // fallback
            }

            $user->username = $login;
            $user->status = 10;
            $user->token = "$t1-$t2-$t3";
            $position = Position::find()->orderBy('rand()')->one();

            $user->department_id = $position->department_id;
            $user->position_id = $position->id;
            $user->phone_number = $factory->phoneNumber;
            $user->image = "users_09.04.2025.00.31.17.jpg";
            $gender = DirectoryList::find()->where(['in', 'id', [506, 507]])->orderBy('rand()')->one();
            $user->gender = $gender->name_ru;
            $user->by_user_id = 1;
            $user->rating = 0;
            if ($user->save(false)) {
                $permission = new \common\models\AuthAssignment();
                $permission->user_id = $user->id;
                $permission->item_name = 'Гость';
                $permission->created_at = time();
                $permission->save(false);
                $emp = new Employees();
                $emp->user_id = $user->id;
                $emp->fullname = $factory->name;
                $emp->sex = $gender->id;
                $rand = rand(1970, 2005);
                $emp->birthday = strtotime("01.01.$rand");
                $nat = DirectoryList::find()->where(['category_id' => 3])->andWhere(['in', 'id', [108, 100, 84, 120, 103, 70]])->orderBy('rand()')->one();
                $emp->nationality = $nat->id;
                $list = DirectoryList::find()->where(['category_id' => 7])->orderBy('rand()')->one();
                $emp->family_status = $list->id;
                $emp->passport_series = $this->generateRandomPassport();
                $emp->passport_pinfl = $number = str_pad(rand(0, 99999999999999), 14, '0', STR_PAD_LEFT);
                $emp->passport_inn = $emp->passport_pinfl;
                $emp->passport_end_date = strtotime("01.01." . rand(2026, 2030));
                $emp->passport_whois = "Factory Generator IIB";
                $list = DirectoryList::find()->where(['category_id' => 8])->orderBy('rand()')->one();
                $emp->citizenship = $list->id;
                $emp->birthday_city = $list->id;
                $emp->postcode = 140001;
                $emp->mobile_phone = $factory->phoneNumber;
                $emp->work_phone = $factory->phoneNumber;
                $emp->city = $factory->city;
                $emp->area = $emp->city;
                $emp->address = $factory->address;
                $emp->address_registration = $emp->address;
                $emp->image = "employees_06.04.2025.20.35.41.jpg";
                $emp->created = time();
                $emp->updated = time();
                $emp->tra_start_date = time();
                $emp->tra_end_date = strtotime("+1 year");
                $emp->status = 0;
                $emp->save(false);
                $this->stdout("$i создано \n");
            }
        }
    }

    public function actionDeleteEmployee()
    {
        $begin = strtotime("14.04.2025");
        User::deleteAlL(['between', 'created_at', "{time}", "{time}"]);
        Employees::deleteAll(['between', 'created', "{time}", "{time}"]);
        $this->stdout('Успешно удалено');
    }

    public function actionCreateChildren()
    {
        $faker = Factory::create('ru_RU');
        $employee = Employees::find()->orderBy('rand()')->all();
        $k = 1;
        foreach ($employee as $item) {
            if ($k == 43) break;
            for ($i = 0; $i < 3; $i++) {
                $child = new EmployeesChildren();
                $child->fullname = $faker->name;
                $child->birthday = strtotime("01.01." . rand(2004, 2024));
                $child->employee_id = $item->id;
                $child->save(false);
            }

            $this->stdout($k++ . " Ребенок добавлен!!! \n");
        }
        $this->stdout("Дети добавлены \n");
    }

    public function actionDeleteChildren()
    {
        //$ch=EmployeesChildren::deleteAll();
    }
}