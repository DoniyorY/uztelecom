<?php

namespace frontend\modules\mobile\controllers;

use common\models\LoginForm;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\HttpException;
use yii\web\Response;
use Yii;
use common\models\User;
use common\models\UserVisiting;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => ['post'],
                    'logout' => ['post'],
                ],
            ],
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'except' => ['login'],
            ]
        ];
    }

    public function actionLogin()
    {
        $this->request->enableCsrfValidation = false;
        $post = DefaultController::getPost(['username', 'password']);
        if (isset($post)) {
            $user = User::findOne(['username' => $post['username']]);
            if (!$user) return ['success' => false, 'status' => 401, 'message' => 'Пользователь не найден'];
            if ($user->status != 10) {
                throw new HttpException(422, 'Пользователь неактивен!!!');
            }
            if ($user->validatePassword($post['password'])) {
                return [
                    'success' => true,
                    'status' => 200,
                    'data' => [
                        'user_auth' => $user->auth_key,
                        'user' => $user
                    ]
                ];
            } else {
                return [
                    'success' => false,
                    'status' => 401,
                    'message' => 'Неправильный логин или пароль'
                ];
            }
        }
    }

    public function actionLogout()
    {
        $post = DefaultController::getPost(['token']);
        $user = User::findByToken($post['token']);
        if (!$user) return ['success' => false, 'status' => 404, 'message' => "Пользователь не найден"];
        $user->generateAuthKey();
        $user->updated_at = time();
        $user->update(false);
        return [
            'success' => true,
            'message' => 'Пользователь успешно отключён!!!'
        ];
    }

    public function actionUserBalance($token)
    {
        $user = User::findByToken($token);
        $user_balance = \common\models\UserBalance::findAll(['user_id' => $user->id]);
        return [
            'success' => true,
            'status' => 200,
            'data' => $user_balance
        ];
    }

    public function actionUserVisit($token)
    {
        $user = User::findByToken($token);
        $user_visit = UserVisiting::find()->where(['terminal_employee_no' => $user->terminal_employee_no])->orderBy(['id' => SORT_DESC])->all();

        return [
            'success' => true,
            'status' => 200,
            'data' => $user_visit
        ];
    }

}