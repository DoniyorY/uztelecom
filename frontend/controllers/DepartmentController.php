<?php

namespace frontend\controllers;

use Yii;
use common\models\Department;
use common\models\UserWork;
use common\models\search\DepartmentSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DepartmentController implements the CRUD actions for Department model.
 */
class DepartmentController extends Controller
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
                /*'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'select-search', 'staffing-schedule', 'staffing-list', 'list'],
                            'roles' => ['view']
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['update','HR','view'],
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
                ]*/
            ]
        );
    }
    public function beforeAction($action)
    {
        if ($action->id === 'delete') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all Department models.
     *
     * @return string
     */


    public function actionStaffingList()
    {
        $department_list = Department::find()->all();
        return $this->render('staffing_list_view', [
            'department_list' => $department_list,
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new DepartmentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model_one' => new Department(),
        ]);
    }

    public function actionCreate()
    {
        $model_one = new Department();
        $model_one->created_at = time();
        if ($this->request->isPost) {
            if ($model_one->load($this->request->post()) && $model_one->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model_one->loadDefaultValues();
        }
    }

    /**
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save(false)) {
            \Yii::$app->session->setFlash('success', 'Успешно обновлено!!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionList($id)
    {
        $model = $this->findModel($id);
        $workers_list = UserWork::find()->where(['department_id' => $id])->all();
        return $this->render('list_view', [
            'model' => $model,
            'workers_list' => $workers_list,
        ]);
    }

    public function actionSelectSearch($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        if (!is_null($q)) {
            $query = (new \yii\db\Query())
                ->select(['id', 'username'])
                ->from('user')
                ->where(['status' => 10])
                ->andWhere(['like', 'username', $q])
                ->limit(10);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);;

        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => \common\models\User::findOne($id)->username];
        }
        return $out;
    }

    /**
     * Deletes an existing Department model.
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

    /**
     * Finds the Department model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Department the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Department::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
