<?php

namespace frontend\controllers;

use common\models\Notifications;
use common\models\search\NotificationsSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotificationsController implements the CRUD actions for Notifications model.
 */
class NotificationsController extends Controller
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
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Notifications models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new NotificationsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andFilterWhere(['user_id' => \Yii::$app->user->id]);
        $dataProvider->query->orderBy(['created_at' => SORT_DESC]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCheckAll()
    {
        Notifications::updateAll(['seen' => 1], ['user_id' => \Yii::$app->user->id]);
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionRedirect($ntf_id)
    {
        $model = Notifications::findOne($ntf_id);
        $model->seen = 1;
        $model->update(false);
        if ($model->model_type === 0) {
            $task = Task::findOne(['id' => $model->model_id]);
            return $this->redirect(['task/view', 'id' => $task->token]);
        } elseif ($model->model_type === 1) {
            return $this->redirect(['news/index']);
        }
    }

    /**
     * Finds the Notifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Notifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notifications::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Создаёт уведомление для пользователя.
     *
     * @param int $user_id ID пользователя, которому предназначено уведомление.
     * @param string $title Заголовок уведомления.
     * @param string $model_type Тип связанной модели (например, 'Order', 'Comment' и т.д.).
     * @param int $model_id ID связанной модели.
     *
     * @return bool Возвращает true при успешном сохранении уведомления, иначе false.
     */
    public static function makeNotification($user_id, $title, $model_type, $model_id)
    {
        $model = new Notifications([
            'user_id' => $user_id,
            'created_at' => time(),
            'title' => $title,
            'model_type' => $model_type,
            'model_id' => $model_id,
            'seen' => 0,
        ]);

        if ($model->save()) {
            return true;
        }

        // Логируем ошибку, если сохранить не удалось
        \Yii::error("Не удалось создать уведомление: " . Json::encode($model->errors), __METHOD__);
        return false;
    }
}
