<?php

namespace frontend\modules\mobile\controllers;

use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;
use common\models\Orders;
use common\models\User;
use common\models\Employees;

class OrdersController extends Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                ],
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
            ]
        ];
    }

    public function actionIndex($user_token)
    {
        $users = User::findByToken($user_token);
        $orders = Orders::find()
            ->where(['user_id' => $users->id])
            ->orderBy(['id' => SORT_DESC])
            ->all();
        return [
            'success' => true,
            'status' => 200,
            'data' => $orders,
        ];
    }

    public function actionCreate()
    {
        $post = DefaultController::getPost(['title', 'subject_id', 'content', 'user_id']);
        $user = User::findOne($post['user_id']);
        $employee = Employees::findOne(['user_id' => $user->id]);
        $order = new Orders([
            'subject_id' => $post['subject_id'],
            'user_id' => $post['user_id'],
            'employee_id' => $employee->id,
            'title' => $post['title'],
            'content' => $post['content'],
            'created_at' => time(),
            'updated_at' => time(),
            'status' => 0,
            'department_id' => $user->department_id,
            'position_id' => $user->position_id,
        ]);
        if ($order->save()) {
            if (!$this->addItems($order, $user)) {
                $order->delete();
                return [
                    'success' => false,
                    'status' => 500,
                    'message' => 'Ошибка при создании заявки!!!'
                ];
            }
        } else {
            return [
                'success' => false,
                'status' => 500,
                'message' => 'Ошибка при создании заявки'
            ];
        }

        return [
            'success' => true,
            'status' => 200,
            'data' => $order,
        ];
    }
    public function actionSubject()
    {
        $subjects = \common\models\OrderSubjects::find()->all();

        return [
            'success' => true,
            'status' => 200,
            'data' => $subjects,
        ];
    }

    private function addItems($model, $user)
    {
        $hr = \common\models\AuthAssignment::findAll(['item_name' => 'HR']);
        foreach ($hr as $value) {
            $items = new \common\models\OrderItems([
                'order_id' => $model->id,
                'user_id' => $value->user_id,
                'status' => 0,
                'checked_at' => 0,
                'user_role' => 1, // HR
            ]);
            if (!$items->save()) return false;
        }
        $departments = \common\models\Department::findOne(['id' => $user->department_id]);
        $items = new \common\models\OrderItems([
            'order_id' => $model->id,
            'user_id' => $departments->head_id,
            'status' => 0,
            'checked_at' => 0,
            'user_role' => 0 // Руководитель отдела
        ]);
        if (!$items->save()) return false;
        return true;
    }
}