<?php

namespace frontend\modules\mobile\controllers;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use common\models\User;
use common\models\Notifications;
use yii\web\Response;

class NotificationsController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Включаем Bearer-авторизацию
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        // JSON-ответы по умолчанию
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    public function actionIndex($token)
    {
        $user = User::findByToken($token);
        if (!$user) return ['success' => false, 'status' => 404, 'message' => 'Пользователь не найден'];
        $ntf = Notifications::findAll(['user_id' => $user->id]);
        $arr = [];
        foreach ($ntf as $item) {
            $arr[] = [
                'title' => $item->title,
                'model_id' => $item->model_id,
                'model_type' => \Yii::$app->params['notification_model_type'][$item->model_type],
                'seen' => $item->seen,
                'created_at' => date('d.m.Y', $item->created_at),
            ];
        }
        return [
            'success' => true,
            'status' => 200,
            'data' => $arr
        ];
    }
}

?>