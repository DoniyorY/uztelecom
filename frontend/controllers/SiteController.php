<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use frontend\models\ContactForm;
use common\models\Task;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'transliteration', 'helpdesk', 'balances', 'get-pie'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        $query = (new \yii\db\Query())
            ->select(['status_id', 'COUNT(*) AS count'])
            ->from('task')
            ->leftJoin('task_members', 'task.id = task_members.task_id')
            ->where([
                'or',
                ['task.user_id' => $userId],
                ['task_members.user_id' => $userId],
            ])
            ->groupBy('status_id');

        $results = $query->all();

        // Инициализируем счётчики по умолчанию
        $taskCounts = [
            0 => 0, // new
            1 => 0, // in process
            2 => 0, // success
            3 => 0, // rejected
            4 => 0  // просрочено
        ];

        foreach ($results as $row) {
            $taskCounts[$row['status_id']] = $row['count'];
        }

        // Общий подсчёт задач пользователя (только где он — владелец)
        $task_all = (new \yii\db\Query())
            ->from('task')
            ->leftJoin('task_members', 'task.id = task_members.task_id')
            ->where([
                'or',
                ['task.user_id' => $userId],
                ['task_members.user_id' => $userId],
            ])
            ->count();

        $tasks = new ActiveDataProvider([
            'query' => Task::find()
                ->select(['token', 'status_id', 'by_user_id', 'dead_line', 'level_id', 'title'])
                ->where([
                    'or',
                    ['task.user_id' => $userId],
                    ['exists',
                        (new Query())
                            ->from('task_members')
                            ->where('task_members.task_id = task.id')
                            ->andWhere(['task_members.user_id' => $userId])
                    ]
                ])
                ->andWhere(['!=', 'status_id', 2])->orderBy(['dead_line' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);

        return $this->render('index', [
            'task_new' => $taskCounts[0],
            'task_process' => $taskCounts[1],
            'task_success' => $taskCounts[2],
            'task_rejected' => $taskCounts[3],
            'task_overed' => $taskCounts[4],
            'task_all' => $task_all,
            'tasks' => $tasks,
        ]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'main_login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionGetPie()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $employees = (new \yii\db\Query())->select(['id', 'fullname', 'sex'])
            ->from('employees')
            ->all();

        $menCount = 0;
        $womenCount = 0;

        foreach ($employees as $e) {
            if ($e['sex'] === 506) {
                $menCount++;
            } elseif ($e['sex'] === 507) {
                $womenCount++;
            }
        }

        return ['men' => $menCount, 'women' => $womenCount];
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTransliteration()
    {
        return $this->render('transliteration');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionHelpdesk()
    {
        return $this->render('helpdesk_view');
    }
}
