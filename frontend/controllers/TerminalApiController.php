<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\BadRequestHttpException;

class TerminalApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionSentEvent()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $rawBody = Yii::$app->request->getRawBody();
        $data = json_decode($rawBody, true);

        if (!is_array($data)) {
            throw new BadRequestHttpException("Ожидается JSON-массив объектов.");
        }

        $saved = 0;
        $errors = [];

        foreach ($data as $index => $item) {
            $model = new \common\models\LogTerminal();
            $model->created_at = time();
            $model->updated_at = time();
            $model->status = 1;
            $model->data = json_encode($item, JSON_UNESCAPED_UNICODE);
           // $model->data = $item['ip'];

            if ($model->validate() && $model->save()) {

                $data_from_database=json_decode($model->data, true);

                $visit_model= new \common\models\UserVisiting();
                $visit_model->created_at = time();
                $visit_model->type = $data_from_database['type'];
                $visit_model->time_date = $data_from_database['time'];
                $visit_model->time_int = strtotime($data_from_database['time']);

                $visit_model->terminal_employee_no = $data_from_database['employee_no'];
                $visit_model->terminal_card = $data_from_database['card'];
                $visit_model->save();

                $saved++;


            } else {
                $errors[$index] = $model->getErrors();
            }
        }

        return [
            'success' => true,
            'saved' => $saved,
            'errors' => $errors,
        ];
    }
}

?>