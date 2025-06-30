<?php

namespace frontend\controllers;

use Yii;
use common\models\UserBalance;
use common\models\Employees;
use common\models\search\UserBalanceSearch;
use common\models\UploadsImage;
use common\models\User;
use common\models\UserWork;
use common\models\AuthAssignment;
use common\models\search\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Position;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                        'change-password' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'position-list', 'change-password', 'balance'],
                            'roles' => ['view'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create'],
                            'roles' => ['create'],
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
                            'actions' => ['reset-password'],
                            'roles' => ['admin'],
                        ]
                    ]
                ]
            ]
        );
    }

    public function beforeAction($action)
    {
        if ($action->id == 'position-list' or $action->id == 'reset-password') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all User models.
     *
     * @return string
     */

    public function actionBalance()
    {
        $searchModel = new UserBalanceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 50;
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];
        if (!\Yii::$app->user->can('admin')) {
            $dataProvider->query->andFilterWhere([
                //      'department_id' => \Yii::$app->user->identity->department_id,
            ]);
        }
        return $this->render('balance_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 50;
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];
        if (!\Yii::$app->user->can('admin')) {
            $dataProvider->query->andFilterWhere([
                'department_id' => \Yii::$app->user->identity->department_id,
            ]);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPositionList()
    {

        if (\Yii::$app->request->isPost) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = [];
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                if ($parents != null) {
                    $cat_id = $parents[0];
                    $out = $positions = \common\models\Position::find()->select(['id', 'name'])->where(['department_id' => $cat_id])->asArray()->all();
                    return ['output' => $out, 'selected' => ''];
                }
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($token)
    {
        $model = $this->findModel($token);

        $work_history = UserWork::find()->where(['user_id' => $model->id])->all();

        $auth = AuthAssignment::findOne(['user_id' => $model->id]);
        $employee = Employees::findOne(['user_id' => $model->id]);
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->updated_at = time();
            $file = UploadedFile::getInstance($model, 'imageFile');
            $uploads = UploadsImage::uploadImage($model, $file, 'users');

            if ($uploads) {
                $model->image = $uploads;
            }

            $assignment = \Yii::$app->request->post('User')['user_assignment'];
            \common\models\AuthAssignment::deleteAll(['user_id' => $model->id]);
            $permission = new \common\models\AuthAssignment();
            $permission->user_id = $model->id;
            $permission->item_name = $assignment;
            $permission->created_at = time();

            if ($permission->save(false)) {
                $model->update(false);
                return $this->redirect(['view', 'token' => $model->token]);
            } else {
                \Yii::$app->session->setFlash('warning', 'Ошибка при редактировании сотрудника');
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }


        $user_password = yii::$app->user->identity;
        $is_saved = false;
        /*$loadedPost = $user_password->load(Yii::$app->request->post());
        if ($loadedPost && $user_password->validate()) {
            $user_password->password = $user_password->newPassword;
            if ($user_password->save(false)) {
                Yii::$app->session->setFlash('success', 'Новый пароль сохранен успешно');
                return $this->refresh();
            }
        }*/


        return $this->render('view', [
            'model' => $model,
            'auth' => $auth,
            'user_password' => $user_password,
            'work_history' => $work_history,
            'employee_id' => $employee ? $employee->id : '',
        ]);
    }

    public function actionChangePassword()
    {
        $request = Yii::$app->request;

        if ($this->request->isPost) {
            $userId = Yii::$app->user->id;
            $user = User::findOne(['id' => $userId]);
            if ($user->validatePassword($request->post('User')['currentPassword'])) {
                $post = $request->post('User');
                $user->setPassword($post['newPasswordConfirm']);
                $user->updated_at = time();
                $user->update(false);
                return $this->redirect($request->referrer);
            } else {
                Yii::$app->session->setFlash('warning', 'Пароли не совпадают!!!');
                return $this->redirect($request->referrer);
            }
        }
        Yii::$app->session->setFlash('warning', 'Ошибка при обновлении пароля!!!');
        return $this->redirect(\Yii::$app->request->referrer);

    }


    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $t1 = \Yii::$app->security->generateRandomString(3);
                $t2 = \Yii::$app->security->generateRandomString(3);
                $t3 = \Yii::$app->security->generateRandomString(3);

                $assignment = \Yii::$app->request->post('User')['user_assignment'];
                $bid = $model->user_bid;
                $model->setPassword($model->password);
                $model->generateAuthKey();
                $model->status = User::STATUS_ACTIVE;
                $model->created_at = time();
                $model->updated_at = time();
                $model->image = 0;
                $model->email = $model->username . '@com.com';
                $model->token = "$t1-$t2-$t3";
                $model->by_user_id = \Yii::$app->user->id;
                $model->rating = 0;
                if ($model->save(false)) {
                    $permission = new \common\models\AuthAssignment();
                    $permission->user_id = $model->id;
                    $permission->item_name = $assignment;
                    $permission->created_at = time();
                    if ($permission->save(false)) {

                        $user_work = new UserWork();
                        $user_work->status_id = 1;
                        $user_work->user_id = $model->id;
                        $user_work->company_id = $model->department->company_id;
                        $user_work->department_id = $model->department_id;
                        $user_work->position_id = $model->position_id;
                        $user_work->created_at = time();
                        $user_work->updated_at = time();
                        if ($bid == 0) {
                            $user_work->bid = 0.5;
                            $user_work->salary = ($model->position->salary / 2);
                            $user_work->one_hour = 0;
                        }
                        if ($bid == 1) {
                            $user_work->bid = 1;
                            $user_work->salary = ($model->position->salary);
                            $user_work->one_hour = 0;
                        }
                        if ($bid == 2) {
                            $user_work->bid = 1.5;
                            $user_work->salary = $model->position->salary + ($model->position->salary / 2);
                            $user_work->one_hour = 0;
                        }
                        if ($user_work->save(false)) {

                            $balance = new UserBalance();
                            $balance->user_id = $model->id;
                            $unicode = $user_work->company_id . $model->id;
                            $balance->uni_code = $unicode;
                            $balance->created_at = time();
                            $balance->updated_at = time();
                            $balance->value = 0;
                            if ($balance->save(false)) {
                                \Yii::$app->session->setFlash('success', 'Пользователь успешно создан: ' . $model->fullname);
                                return $this->redirect(['view', 'token' => $model->token]);
                            }

                        }

                    } else {
                        \common\models\User::deleteAll(['token' => $model->token]);
                        \Yii::$app->session->setFlash('warning', 'Can\'t set permission');
                        return $this->redirect(['index']);
                    }
                }
                \Yii::$app->session->setFlash('warning', 'Can\'t create new user!');
                return $this->redirect(\Yii::$app->request->referrer);
            }
        } else {
            $model->loadDefaultValues();
        }
    }

    public function actionResetPassword($token)
    {
        if ($this->request->isPost) {
            $model = $this->findModel($token);
            $model->setPassword('123456');
            $model->generateAuthKey();
            $model->update(false);
            \Yii::$app->session->setFlash('success', 'Сброс пароля прошла успешно!!!');
            return $this->redirect(\Yii::$app->request->referrer);
        }

    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['token' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
