<?php

namespace frontend\controllers;

use common\models\Orders;
use common\models\search\OrdersSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\OrderItems;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
                            'actions' => ['index', 'my-orders', 'view', 'status'],
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
                ]*/
            ]
        );
    }

    /**
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->joinWith('orderItems');
        $dataProvider->query->andFilterWhere(['order_items.user_id' => Yii::$app->user->id]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => 'Все заявки'
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $order_items = OrderItems::find()->where(['order_id' => $id])->all();
        $order_user = OrderItems::findOne(['order_id' => $id, 'user_id' => Yii::$app->user->id]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'order_user' => $order_user,
            'order_items' => $order_items
        ]);
    }

    public function actionStatus($status, $user_id, $order_id)
    {
        $order_items = OrderItems::findOne(['order_id' => $order_id, 'user_id' => $user_id]);
        $order_items->status = $status;
        $order_items->checked_at = time();
        $order_items->order->status = 3;
        $order_items->order->update(false);
        $order_items->update(false);
        Yii::$app->session->setFlash('success', 'Заявление успешно ' . Yii::$app->params['order_status'][$status]);
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $user = User::findOne(Yii::$app->user->id);
                $model->created_at = time();
                $model->updated_at = time();
                $model->user_id = $user->id;
                $model->status = 0;
                $model->department_id = $user->department_id;
                $model->position_id = $user->position_id;
                if ($model->save()) {
                    if (!$this->addItems($model, $user)) {
                        $model->delete();
                        Yii::$app->session->setFlash('warning', 'Ошибка при создании заявки');
                        return $this->redirect(['create']);
                    }
                } else {
                    Yii::$app->session->setFlash('warning', $model->getErrors()['employee_id'][0]);
                    return $this->refresh();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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

    public function actionMyOrders()
    {
        $searchModel = new OrdersSearch();
        $searchModel->user_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => 'Мои заявки'
        ]);
    }

    /**
     * Updates an existing Orders model.
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

    /**
     * Deletes an existing Orders model.
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
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
