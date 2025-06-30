<?php

namespace frontend\controllers;

use common\models\AuthAssignment;
use common\models\Company;
use common\models\Department;
use common\models\Position;
use common\models\UserBalance;
use Yii;
use common\models\Employees;
use common\models\EmployeesChildren;
use common\models\search\EmployeesSearch;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\EmployeesFiles;
use common\models\UserWork;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * EmployeesController implements the CRUD actions for Employees model.
 */
class EmployeesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-child' => ['POST'],
                        'delete-file' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => [
                                'index',
                                'view',
                                'download',
                                'create',
                                'add-child',
                                'make-order',
                                'employee-import',
                                'department',
                                'position'
                            ],
                            'roles' => ['view']
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['update'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['delete'],
                            'roles' => ['delete'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create'],
                            'roles' => ['create'],
                        ]
                    ]
                ]
            ]
        );
    }

    public function beforeAction($action)
    {
        if ($action->id == 'department' || $action->id == 'position') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Employees models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EmployeesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMakeOrder($id)
    {
        $model = $this->findModel($id);

        return $this->render('make_order', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Employees model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteFile($id)
    {
        $model = EmployeesFiles::findOne($id);
        $filePath = Yii::getAlias('@frontend/uploads/files/' . $model->image);
        if (file_exists($filePath)) {
            unlink($filePath);
            if ($model->delete()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    /**
     * Controller action for uploading and importing employee data from an Excel file.
     *
     * Steps:
     * 1. Receives the uploaded file.
     * 2. Saves it temporarily.
     * 3. Passes it to the import method.
     */
    public function actionEmployeeImport()
    {
        if ($this->request->isPost) {
            $file = UploadedFile::getInstanceByName('importFile');
            //$name = 'Иштихон туман Булунғур туман Каттақўрғон шаҳар Қўшработ туман Оқдарё туман Пайариқ туман Пахтачи туман Каттақўрғон туман Самарқанд туман Ургут туман Нуробод туман Тойлоқ туман Транспорт алоқа Самарқанд транспорт Сирдарё мобил алоқа Самарқанд мобил алоқа Жиззах мобил алоқа';
            $name = 'Остальные области';
            $path = Yii::getAlias('@frontend/web/uploads/importFiles/' . $name . '.' . $file->extension);
            if (!file_exists($path)) $file->saveAs($path);
            $this->importEmployeesFromExcel($path);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Parses and imports employee records from an Excel file.
     *
     * Expected Excel format:
     * - Row 0: Headers (ignored)
     * - Row 1: Contains company name (will be used to find/create Company model)
     * - Row 2: Usually empty (ignored)
     * - All following rows contain employee or child data
     *
     * For each employee:
     * - Skips if employee already exists (based on name and birthdate)
     * - Department and position are looked up and created if missing
     * - Creates user account with unique login
     * - Assigns role and default values
     * - Links all models: User, Employee, Work, Balance, etc.
     * - Supports appending children rows to the last added employee
     *
     * Performance notes:
     * - Uses transaction for rollback safety
     * - Caches departments and positions to reduce queries
     * - Safe date parsing and logging errors
     *
     * @param string $filePath Absolute path to the Excel file
     */
    private function importEmployeesFromExcel($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $company = null;
            $departments = [];
            $positions = [];
            $lastEmployeeId = null;
            /*echo "<pre>";
            print_r($rows);
            die();*/
            foreach ($rows as $key => $row) {
                if ($key === 0) continue;

                // Ячейка с названием компании
                if ($this->isCompanyRow($row)) {
                    $company = Company::find()->where(['like', 'name', trim($row[0])])->one();
                    if (!$company) {
                        $company = new Company(['name' => trim($row[0])]);
                        $company->save(false);
                    }
                    continue;
                }

                // Дата рождения
                $date = \DateTime::createFromFormat('d.m.Y', $row[2]);
                $birthTimestamp = $date ? $date->getTimestamp() : 0;

                if (empty($row[1]) || !$birthTimestamp) {
                    if (!empty($lastEmployeeId) && !empty($row[15]) && !empty($row[16])) {
                        $this->createChild($lastEmployeeId, $row[15], $row[16]);
                    }
                    continue;
                }

                // Проверка на дубликат
                $exists = Employees::find()
                    ->where(['like', 'fullname', $row[1]])
                    ->andWhere(['birthday' => $birthTimestamp])
                    ->exists();
                if ($exists) continue;

                // Отдел
                $depKey = $company->id . ':' . $row[7];
                if (!isset($departments[$depKey])) {
                    $department = Department::find()
                        ->where(['like', 'name', $row[7]])
                        ->andWhere(['company_id' => $company->id])
                        ->one();

                    if (!$department) {
                        $department = new Department([
                            'company_id' => $company->id,
                            'name' => $row[7],
                            'head_id' => 1,
                            'created_at' => time() //strtotime('25.05.2025')
                        ]);
                        $department->save(false);
                    }
                    $departments[$depKey] = $department;
                } else {
                    $department = $departments[$depKey];
                }

                // Должность
                $posKey = $department->id . ':' . $row[8];
                if (!isset($positions[$posKey])) {
                    $position = Position::find()
                        ->where(['like', 'name', $row[8]])
                        ->andWhere(['department_id' => $department->id, 'company_id' => $company->id])
                        ->one();

                    if (!$position) {
                        $position = new Position([
                            'name' => $row[8],
                            'department_id' => $department->id,
                            'company_id' => $company->id,
                            'salary' => 1000000,
                            'one_hour' => 1000,
                            'bid' => 1,
                            'created_at' => strtotime('25.05.2025'),
                            'user_id' => 1
                        ]);
                        $position->save(false);
                    }
                    $positions[$posKey] = $position;
                } else {
                    $position = $positions[$posKey];
                }

                // Генерация уникального логина
                $baseLogin = $this->transliteration($row[1]);
                $username = $baseLogin;
                $i = 1;
                while (User::find()->where(['username' => $username])->exists()) {
                    $username = $baseLogin . $i++;
                }

                // Создание пользователя
                $user = new User([
                    'username' => $username,
                    'email' => "$username@mail.ru",
                    'status' => 10,
                    'created_at' => strtotime('25.05.2025'),
                    'updated_at' => strtotime('25.05.2025'),
                    'fullname' => $row[1],
                    'department_id' => $department->id,
                    'position_id' => $position->id,
                    'phone_number' => ($row[10]) ? $row[10] : '0',
                    'image' => '',
                    'gender' => ($row[3] == 'А') ? 'Айол' : 'Еркак',
                    'by_user_id' => 1,
                    'rating' => 0,
                    'token' => $this->generateToken(),
                ]);
                $user->setPassword('123456');
                $user->generateAuthKey();

                if (!$user->save(false)) {
                    Yii::error($user->errors, 'user');
                    continue;
                }

                // Назначение роли
                (new \common\models\AuthAssignment([
                    'user_id' => $user->id,
                    'item_name' => 'employee',
                    'created_at' => strtotime('25.05.2025')
                ]))->save(false);

                // Work
                $bid = 1;
                $salary = $position->salary * $bid;

                (new UserWork([
                    'status_id' => 1,
                    'user_id' => $user->id,
                    'company_id' => $company->id,
                    'department_id' => $department->id,
                    'position_id' => $position->id,
                    'bid' => $bid,
                    'salary' => $salary,
                    'one_hour' => 0,
                    'created_at' => time(),
                    'updated_at' => time(),
                ]))->save(false);

                // Баланс
                (new UserBalance([
                    'user_id' => $user->id,
                    'uni_code' => $company->id . $user->id,
                    'value' => 0,
                    'created_at' => time(),
                    'updated_at' => time(),
                ]))->save(false);

                // Сотрудник
                $employee = new Employees([
                    'department_id' => $department->id,
                    'user_id' => $user->id,
                    'fullname' => $row[1],
                    'sex' => ($row[3] == 'А') ? 507 : 506,
                    'birthday' => $birthTimestamp,
                    'nationality' => 108,
                    'family_status' => ($row[3] == 'А') ? 2565 : 2564,
                    'passport_series' => $row[11],
                    'passport_pinfl' => ($row[12]) ? $row[12] : '0',
                    'passport_whois' => ($row[13]) ? $row[13] : '0',
                    'passport_end_date' => strtotime($row[14]),
                    'citizenship' => 2785,
                    'birthday_city' => 2785,
                    'postcode' => 140001,
                    'mobile_phone' => ($row[10]) ? $row[10] : '0',
                    'city' => 'Самарканд обл.',
                    'area' => 'Самарканд г.',
                    'address' => $row[9],
                    'address_registration' => $row[9],
                    'image' => '0',
                    'created' => strtotime('25.05.2025'),
                    'updated' => strtotime('25.05.2025'),
                    'status' => 0,
                ]);
                if ($employee->save()) {
                    $lastEmployeeId = $employee->id;
                } else {
                    Yii::error($employee->errors, 'employee');
                }

                if (!empty($row[15]) && !empty($row[16])) {
                    $this->createChild($lastEmployeeId, $row[15], $row[16]);
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), 'import');
        }
    }

    private function isCompanyRow($row)
    {
        // Если только первый элемент непустой, остальные пустые — это компания
        foreach ($row as $index => $value) {
            if ($index === 0) continue;
            if (!empty($value) && trim($value) !== '') {
                return false;
            }
        }
        return true;
    }

    private function createChild($last_employee_id, $fullname, $age)
    {
        $employee_child = new EmployeesChildren([
            'employee_id' => $last_employee_id,
            'fullname' => $fullname,
            'birthday' => strtotime($age)
        ]);
        $employee_child->save();
    }

    private function generateToken(): string
    {
        return implode('-', [
            Yii::$app->security->generateRandomString(3),
            Yii::$app->security->generateRandomString(3),
            Yii::$app->security->generateRandomString(3),
            Yii::$app->security->generateRandomString(3),
        ]);
    }

    private function transliteration($text)
    {
        $map = [
            'А' => 'A', 'а' => 'a', 'Б' => 'B', 'б' => 'b',
            'В' => 'V', 'в' => 'v', 'Г' => 'G', 'г' => 'g',
            'Д' => 'D', 'д' => 'd', 'Е' => 'E', 'е' => 'e',
            'Ё' => 'Yo', 'ё' => 'yo', 'Ж' => 'J', 'ж' => 'j',
            'З' => 'Z', 'з' => 'z', 'И' => 'I', 'и' => 'i',
            'Й' => 'Y', 'й' => 'y', 'К' => 'K', 'к' => 'k',
            'Қ' => 'Q', 'қ' => 'q', 'Л' => 'L', 'л' => 'l',
            'М' => 'M', 'м' => 'm', 'Н' => 'N', 'н' => 'n',
            'О' => 'O', 'о' => 'o', 'П' => 'P', 'п' => 'p',
            'Р' => 'R', 'р' => 'r', 'С' => 'S', 'с' => 's',
            'Т' => 'T', 'т' => 't', 'У' => 'U', 'у' => 'u',
            'Ў' => 'O‘', 'ў' => 'o‘', 'Ф' => 'F', 'ф' => 'f',
            'Х' => 'X', 'х' => 'x', 'Ц' => 'Ts', 'ц' => 'ts',
            'Ч' => 'Ch', 'ч' => 'ch', 'Ш' => 'Sh', 'ш' => 'sh',
            'Ъ' => '', 'ъ' => '', 'Ь' => '', 'ь' => '',
            'Э' => 'E', 'э' => 'e', 'Ю' => 'Yu', 'ю' => 'yu',
            'Я' => 'Ya', 'я' => 'ya', 'Ғ' => 'G‘', 'ғ' => 'g‘',
            'Ҳ' => 'H', 'ҳ' => 'h'
        ];
        // Разделим Ф.И.О. и оставим только фамилию и имя
        $parts = explode(' ', trim($text));
        if (count($parts) < 2) {
            return 'Невалидное ФИО'; //
        }

        $surname = strtr($parts[0], $map);
        $name = strtr($parts[1], $map);

        $login = strtolower($surname . '.' . $name);
        return $login;
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model_files = $this->prepareAndSaveEmployeeFile($model->id);

        $all_files = EmployeesFiles::find()->where(['employees_id' => $model->id])->all();
        $children = EmployeesChildren::findAll(['employee_id' => $model->id]);

        return $this->render('view', [
            'model' => $model,
            'model_files' => $model_files,
            'all_files' => $all_files,
            'children' => $children,
        ]);
    }


    /**
     * Обрабатывает загрузку файла сотрудника и сохраняет его, если все проверки пройдены.
     *
     * @param int $employeeId ID сотрудника, к которому привязывается файл.
     * @return EmployeesFiles Экземпляр модели, готовый к передаче в представление (возможно, с сообщением об ошибке).
     */
    protected function prepareAndSaveEmployeeFile($employeeId)
    {
        $model_files = new EmployeesFiles();
        $model_files->employees_id = $employeeId;
        $model_files->user_id = Yii::$app->user->identity->id;
        $model_files->created_at = time();

        if ($model_files->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model_files, 'imageFile');

            if ($file && $file->tempName) {
                $model_files->imageFile = $file;

                if ($model_files->validate(['file'])) {
                    $dir = Yii::getAlias('@frontend/web/uploads/files/');
                    $fileName = time() . '.' . $model_files->imageFile->extension;

                    $model_files->imageFile->saveAs($dir . $fileName);
                    $model_files->imageFile = $fileName;
                    $model_files->image = $fileName;
                }
            }

            if ($model_files->save()) {
                return $this->redirect(Yii::$app->request->referrer);

            }
        }

        return $model_files;
    }


    /**
     * Creates a new Employees model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($token = null)
    {
        $model = new Employees();
        $user = new User();
        if ($token) {
            $user = User::findOne(['token' => $token]);
            $model->mobile_phone = $user->phone_number;
            $model->fullname = $user->fullname;
            $model->user_id = $user->id;
            $model->department_id=$user->department_id;
            $model->position_id=$user->position_id;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if (is_null($token)) {
                    $user->fullname = $model->fullname;
                    $user->username = $this->transliteration($model->fullname);
                    $user->generateAuthKey();
                    $user->setPassword('123456');
                    $user->password_reset_token = null;
                    $user->email = "{$user->username}@example.com";
                    $user->status = 10;
                    $user->created_at = time();
                    $user->updated_at = time();
                    $user->verification_token = null;
                    $user->token = $this->generateToken();

                    $user->department_id = $model->department_id;
                    $user->position_id = $model->position_id;
                    $user->phone_number = $model->mobile_phone;
                    $user->image = 0;
                    $user->gender = ($model->sex == 506) ? 'Мужчина' : 'Женщина';
                    $user->by_user_id = Yii::$app->user->id;
                    $user->rating = 0;
                    $user->terminal_employee_no=0;
                    $user->terminal_card=0;
                    if ($user->save(false)){
                        $auth = new AuthAssignment();
                        $auth->user_id = $user->id;
                        $auth->item_name='employee';
                        $auth->created_at=time();
                        $auth->save(false);
                    }
                    $model->user_id = $user->id;
                }
                $files = UploadedFile::getInstance($model, 'imageFile');
                $uploads = \common\models\UploadsImage::uploadImage($model, $files, 'employees');
                if ($uploads) {
                    $model->image = $uploads;
                }
                $model->created = time();
                $model->birthday = strtotime($model->birthday);
                $model->passport_end_date = strtotime($model->passport_end_date);
                $model->updated = time();
                $model->status = 0;
                $model->tra_start_date = strtotime($model->tra_start_date);
                $model->tra_end_date = strtotime($model->tra_end_date);
                if ($model->save(false)) {
                    $user_work = new UserWork();
                    $user_work->company_id = $user->department->company_id;
                    $user_work->user_id = $user->id;
                    $user_work->department_id = $user->department_id;
                    $user_work->position_id = $user->position_id;
                    $user_work->updated_at = time();
                    $user_work->salary = $user->position->salary;
                    $user_work->one_hour = $user->position->one_hour;
                    $user_work->bid = $user->position->bid;
                    $user_work->status_id = 0;
                    $user_work->created_at = time();
                    if ($user_work->save(false)) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                };

            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'user' => $user,
        ]);
    }


    public function actionAddChild()
    {
        $model = new EmployeesChildren();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->birthday = strtotime($model->birthday);
                $model->save();
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDownload($id)
    {
        $model = EmployeeMedicalCertificates::findOne(['id' => $id]);
        $file = \Yii::getAlias('@frontend/web/uploads/medical_certificates/' . $model->image);
        if (file_exists($file)) {
            return \Yii::$app->response->sendFile($file);
        }
        throw new NotFoundHttpException('The File does not exist.');
    }

    public function actionDepartment()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $department = Department::findAll(['company_id' => $cat_id]);
                foreach ($department as $item) {
                    $out[] = ['id' => $item->id, 'name' => $item->name];
                }
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionPosition()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $cat_id = empty($ids[0]) ? null : $ids[0];
            $subcat_id = empty($ids[1]) ? null : $ids[1];
            if ($cat_id != null) {
                $position = Position::findAll(['company_id' => $cat_id, 'department_id' => $subcat_id]);
                foreach ($position as $item) {
                    $out[] = ['id' => $item->id, 'name' => $item->name];
                }


                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * Deletes an existing Employees model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteChild($id)
    {
        $model = EmployeesChildren::findOne($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Успешно удалено!!!');
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Finds the Employees model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Employees the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employees::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
