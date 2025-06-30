<?php

namespace frontend\controllers;

use common\models\Task;
use common\models\TaskComment;
use common\models\User;
use common\models\TaskMembers;
use common\models\search\TaskSearch;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\TaskResult;
use common\models\Notifications;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
                        'delete-member' => ['POST'],
                        'add-member' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => [
                                'index',
                                'delete-member',
                                'view',
                                'add-comment',
                                'status',
                                'kanban',
                                'add-result',
                                'add-member',
                                'my-tasks',
                                'notification'
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

    /**
     * Lists all Task models.
     *
     * @return string
     */
    public function actionIndex($my_task = null)
    {
        $userId = Yii::$app->user->id;
        $isAdmin = Yii::$app->user->can('admin');

        // Поиск и фильтрация
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        $query = $dataProvider->query;

        // Фильтр "мои задачи" по автору
        if ($my_task !== null) {
            $query->andWhere(['by_user_id' => $userId]);
        }

        // Фильтрация для не админов
        if (!$isAdmin) {
            $query->andWhere([
                'or',
                ['task.user_id' => $userId],
                ['task_members.user_id' => $userId],
            ]);
        }
        $query->andFilterWhere(['!=','status_id',2]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'total_count' => 0,
            'new_count' =>  0,
            'completed_count' =>  0,
            'canceled_count' =>  0,
        ]);
    }

    public function actionMyTasks()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['by_user_id' => Yii::$app->user->id]);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'total_count' => 0,
            'new_count' =>  0,
            'completed_count' =>  0,
            'canceled_count' =>  0,
        ]);
    }


    /**
     * Displays a single Task model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $task_members = TaskMembers::find()->where(['task_id' => $model->id])->limit(5)->all();

        $task_users = User::find()
            ->where(['status' => 10])
            ->all();

        $comments_query = TaskComment::find()->where(['task_id' => $model->id]);
        $comments_count = $comments_query->count();

        $results = TaskResult::find()->where(['task_id' => $model->id]);
        $check_res = TaskResult::findOne(['task_id' => $model->id, 'user_id' => $model->user_id]);
        return $this->render('view', [
            'model' => $model,
            'task_members' => $task_members,
            'task_users' => $task_users,
            'comments_count' => $comments_count,
            'comments' => $comments_query->all(),
            'results' => $results->all(),
            'results_count' => $results->count(),
            'check_res' => $check_res,
        ]);
    }

    public function actionAddMembers($user_token, $task_token)
    {
        $user = User::findOne(['token' => $user_token]);
        $task = $this->findModel($task_token);
        $model = new TaskMembers();
        $model->user_id = $user->id;
        $model->task_id = $task->id;
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionKanban()
    {
        $query = (new Query())->select([
            'task.token',
            'task.id',
            'task.title',
            'task.content',
            'task.user_id',
            'task.by_user_id',
            'task.created_at',
            'task.position_id',
            'task.dead_line',
            'user.fullname AS main_user_fullname',
            'user.image as image'
        ])
            ->from('task')
            ->leftJoin('user', 'task.user_id = user.id')
            ->leftJoin('task_members', 'task_members.task_id = task.id');
        if (!Yii::$app->user->can('admin')) {
            $query->andWhere([
                'or',
                ['task.user_id' => Yii::$app->user->id],
                ['task_members.user_id' => Yii::$app->user->id],
            ]);
        }
        if ($title = Yii::$app->request->get('title')) {
            $query->andWhere(['like', 'task.title', $title]);
        }
        $query->groupBy(['task.id'])->limit(50);
        $arr = ArrayHelper::index($query->all(), null, 'position_id');
        ArrayHelper::multisort($arr, 'position_id', SORT_ASC);

        return $this->render('kanban', [
            'model' => $arr,
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Task();

        $tok1 = Yii::$app->security->generateRandomString(3);
        $tok2 = Yii::$app->security->generateRandomString(3);
        $tok3 = Yii::$app->security->generateRandomString(3);
        $tok4 = Yii::$app->security->generateRandomString(3);


        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->dead_line = strtotime($model->dead_line);
                $model->created_at = time();
                $model->finish_time = 0;
                $model->by_user_id = yii::$app->user->id;
                $model->status_id = 0;
                $model->position_id = 0;
                $model->token = $tok1 . '-' . $tok2 . '-' . $tok3 . '-' . $tok4;
                if ($model->save()) {
                    $this->makeNotification($model->user_id, "Вас добавили в задачу ({$model->title})", 0, $model->id);
                    if (isset($model->task_members)) {
                        foreach ($model->task_members as $item) {
                            $member = new \common\models\TaskMembers();
                            $member->task_id = $model->id;
                            $member->user_id = $item;
                            if (!$member->save()) {
                                Yii::$app->session->setFlash('warning', 'Ошибка при добавлении сотрудников!!');
                                return $this->redirect(Yii::$app->request->referrer);
                            } else {
                                $this->makeNotification($member->id, "Вас добавили в задачу ({$model->title})", 0, $model->id);
                            }
                        }
                    }
                    Yii::$app->session->setFlash('success', 'Задача успешно создана');
                    return $this->redirect(['view', 'id' => $model->token]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
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

    public function actionAddComment()
    {
        $model = new TaskComment();
        $model->created_at = time();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Комментарий добавлен!!!');
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->setFlash('warning', 'Ошибка при добавлении комментария');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    public function actionAddResult()
    {
        $model = new TaskResult();
        $model->created_at = time();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->makeNotification($model->task->by_user_id, 'Написан результат на задачу №' . $model->task_id, 0, $model->task_id);
                Yii::$app->session->setFlash('success', 'Результат добавлен!!!');
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->setFlash('warning', 'Ошибка при добавлении результата');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    public function actionStatus($token, $status, $position)
    {
        $model = $this->findModel($token);
        if ($status == 2) $model->finish_time = time();
        $model->status_id = $status;
        $model->position_id = $position;
        $model->update(false);
        Yii::$app->session->setFlash('success', 'Статус задачи изменен!!!');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing Task model.
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

    public function actionDeleteMember($id)
    {
        $model = TaskMembers::findOne($id);
        $ntf = $this->makeNotification($id, "Вас исключили из задачи: {$model->task->title} :(", 0, $model->task->id);
        if ($ntf) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Исполнител был исключён из данной задачи!!');
        }
        return $this->redirect(Yii::$app->request->referrer);
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
    protected function makeNotification($user_id, $title, $model_type, $model_id)
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


    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne(['token' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
