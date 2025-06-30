<?php

namespace frontend\modules\mobile\controllers;

use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;
use common\models\Task;
use common\models\User;
use common\models\TaskMembers;
use common\models\TaskComment;
use common\models\TaskResult;
use Yii;

class TasksController extends Controller
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
                    'create-comments' => ['post'],
                ],
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
            ]
        ];
    }

    public function actionIndex($task_status, $token)
    {
        $user = User::findByToken($token);
        $tasks = Task::find()
            ->joinWith('members')
            ->andFilterWhere(['status_id' => $task_status])
            ->andFilterWhere([
                'or',
                ['task.user_id' => $user->id],
                ['task_members.user_id' => $user->id],
            ])
            ->orderBy(['created_at' => SORT_DESC]);

        return [
            'success' => true,
            'status' => 200,
            'data' => $tasks->all()
        ];
    }

    public function actionMyTasks($token)
    {
        $user = User::findByToken($token);
        $tasks = Task::find()
            ->where(['by_user_id' => $user->id])
            ->orderBy(['created_at' => SORT_DESC]);

        return [
            'success' => true,
            'status' => 200,
            'data' => $tasks->all()
        ];
    }

    public function actionView($token)
    {
        $params = \Yii::$app->params;
        $model = Task::find()
            ->andFilterWhere(['token' => $token])
            ->one();

        $task = [
            'id' => $model->id,
            'token' => $model->token,
            'company_id' => $params['company_id'][$model->company_id],
            'created_at' => date('d.m.Y H:i', $model->created_at),
            'by_user_id' => $model->byUser->id,
            'by_user_fullname' => $model->byUser->fullname,
            'by_user_avatar' => \Yii::$app->request->baseUrl . '/uploads/users/' . $model->byUser->image,
            'user_id' => $model->user->id,
            'user_fullname' => $model->user->fullname,
            'user_avatar' => \Yii::$app->request->baseUrl . '/uploads/users/' . $model->user->image,
            'title' => $model->title,
            'content' => $model->content,
            'priority' => $model->level_id,
            'dead_line' => date('d.m.Y H:i', $model->dead_line),
            'status_id' => $model->status_id,
            'finish_time' => date('d.m.Y H:i', $model->finish_time),
            'has_task_result' => false,
            'members' => []
        ];

        $members = TaskMembers::findAll(['task_id' => $model->id]);
        $result = \common\models\TaskResult::findAll(['task_id' => $model->id]);

        if (isset($result)) $task['has_task_result'] = true;

        foreach ($members as $member) {
            $task['members'][] = [
                'user_id' => $member->user->id,
                'user_fullname' => $member->user->fullname,
                'user_avatar' => \Yii::$app->request->baseUrl . '/uploads/users/' . $member->user->image,
            ];
        }

        return [
            'success' => true,
            'status' => 200,
            'data' => $task,
        ];
    }

    public function actionCreate()
    {
        $post = \Yii::$app->request->getBodyParams();
        \Yii::info('Данные из POST: ' . print_r($post, true), 'api');

        $tok1 = \Yii::$app->security->generateRandomString(3);
        $tok2 = \Yii::$app->security->generateRandomString(3);
        $tok3 = \Yii::$app->security->generateRandomString(3);
        $tok4 = \Yii::$app->security->generateRandomString(3);
        $model = new Task();
        $user = User::findOne(['id' => $post['by_user_id']]);
        $model->title = $post['title'];
        $model->content = $post['description'];
        if (intval($post['priority']) == 0 or intval($post['priority']) > 4) {
            return [
                'success' => false,
                'status' => 400,
                'message' => 'Приоритет должен быть от 1 до 4'
            ];
        }
        $model->level_id = $post['priority'];
        $model->dead_line = strtotime($post['dead_line']);
        $model->by_user_id = $post['by_user_id'];
        $model->user_id = $post['user_id'];
        $model->position_id = 0;
        $model->created_at = time();
        $model->finish_time = 0;
        $model->status_id = 0;
        $model->company_id = $user->department->company_id;
        $model->token = $tok1 . '-' . $tok2 . '-' . $tok3 . '-' . $tok4;
        if ($model->save(false)) {
            \frontend\controllers\NotificationsController::makeNotification($model->user_id, "Вас добавили в задачу ({$model->title})", 0, $model->id);

            $members = json_decode($post['members'], true);
            if (isset($members)) {
                foreach ($members as $item) {
                    $member = new \common\models\TaskMembers();
                    $member->task_id = $model->id;
                    $member->user_id = $item;
                    if (!$member->save()) {
                        return [
                            'success' => false,
                            'status' => 500,
                            'message' => 'Ошибка при создании участников'
                        ];
                    } else {
                        \frontend\controllers\NotificationsController::makeNotification($member->id, "Вас добавили в задачу ({$model->title})", 0, $model->id);
                    }
                }
            }
        }
        return [
            'success' => true,
            'status' => 200,
            'data' => $model,
        ];


    }

    public function actionFindOwner($query = null)
    {
        $users = User::find();

        if ($query) {
            $users->where(['like', 'fullname', $query]);
        }
        $arr = [];
        foreach ($users->all() as $user) {
            $arr[] = [
                'user_id' => $user->id,
                'fullname' => $user->fullname,
            ];
        }

        return [
            'success' => true,
            'status' => 200,
            'data' => $arr,
        ];
    }

    public function actionTaskCounts($user_token)
    {
        $user = User::findByToken($user_token);
        $arr = [
            'new' => 0,
            'in_process' => 0,
            'success' => 0,
            'rejected' => 0,
            'expired' => 0,
        ];
        for ($i = 0; $i < 4; $i++) {
            $tasks = Task::find()
                ->joinWith('members')
                ->andFilterWhere(['status_id' => $i])
                ->andFilterWhere([
                    'or',
                    ['task.user_id' => $user->id],
                    ['task_members.user_id' => $user->id],
                ])->count();
            switch ($i) {
                case 0:
                    $arr['new'] = $tasks;
                    break;
                case 1:
                    $arr['in_process'] = $tasks;
                    break;
                case 2:
                    $arr['success'] = $tasks;
                    break;
                case 3:
                    $arr['rejected'] = $tasks;
                    break;
                case 4:
                    $arr['expired'] = $tasks;
                    break;
            }
        }
        return [
            'success' => true,
            'status' => 200,
            'data' => $arr,
        ];

    }

    public function actionComments($task_token)
    {
        $model = Task::findOne(['token' => $task_token]);
        $comments = TaskComment::findAll(['task_id' => $model->id]);

        return [
            'success' => true,
            'status' => 200,
            'data' => $comments,
        ];

    }

    public function actionCreateComment()
    {
        $post = DefaultController::getPost(['task_token', 'comment', 'user_id']);
        $task = Task::findOne(['token' => $post['task_token']]);
        $comment = new TaskComment([
            'task_id' => $task->id,
            'user_id' => $post['user_id'],
            'content' => $post['comment'],
            'created_at' => time(),
        ]);
        if (!$comment->save()) {
            return [
                'success' => false,
                'status' => 500,
                'message' => $comment->getErrors(),
            ];
        }
        return [
            'success' => true,
            'status' => 200,
        ];
    }

    public function actionResults($task_token)
    {
        $model = Task::findOne(['token' => $task_token]);
        $comments = TaskResult::findAll(['task_id' => $model->id]);

        return [
            'success' => true,
            'status' => 200,
            'data' => $comments,
        ];

    }

    public function actionCreateResult()
    {
        $post = DefaultController::getPost(['task_token', 'comment', 'user_id']);
        $task = Task::findOne(['token' => $post['task_token']]);
        $comment = new TaskResult([
            'task_id' => $task->id,
            'user_id' => $post['user_id'],
            'content' => $post['comment'],
            'created_at' => time(),
        ]);
        if (!$comment->save()) {
            return [
                'success' => false,
                'status' => 500,
                'message' => $comment->getErrors(),
            ];
        }
        return [
            'success' => true,
            'status' => 200,
            'data' => $comment,
        ];
    }

    public function actionStatus($token, $status)
    {
        $model = Task::findOne(['token' => $token]);
        if ($status == 2) $model->finish_time = time();
        $model->status_id = $status;
        $model->position_id = $status;
        if ($model->update(false)) {
            return [
                'success' => true,
                'status' => 200,
                'message' => 'Статус успешно изменен!!!'
            ];
        }
        return [
            'success' => false,
            'status' => 500,
            'message' => "Ошибка при изменении статуса"
        ];
    }


}