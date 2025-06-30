<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Task;

class ReportController extends Controller
{
    public function behaviors()
    {
        return [
            /*'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['completed-tasks'],
                        'roles' => ['view'],
                    ]
                ]
            ]*/
        ];
    }

    public function actionCompletedTasks()
    {
        $user_id = \Yii::$app->user->id;
        $tasks = Task::find()
            ->joinWith('members')
            ->andFilterWhere(['status_id' => 2])
            ->andFilterWhere(['or',
                ['task.user_id' => $user_id],
                ['task_members.user_id' => $user_id],
                ['task.by_user_id' => $user_id]
            ])
            ->orderBy(['task.id' => SORT_DESC])
            ->all();
        return $this->render('completed_tasks', [
            'tasks' => $tasks,
        ]);
    }
}