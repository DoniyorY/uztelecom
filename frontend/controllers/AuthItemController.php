<?php

namespace frontend\controllers;

use common\models\AuthItem;
use common\models\AuthItemChild;
use common\models\search\AuthItemSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class AuthItemController extends Controller
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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'create', 'update', 'delete','change-child'],
                            'roles' => ['admin'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all AuthItem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andFilterWhere(['type' => 1]);
        $dataProvider->query->orderBy('name ASC');
        if ($this->request->isPost) {
            $this->actionCreate();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $name Name
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        return $this->render('view', [
            'model' => $this->findModel($name),
            'children' => AuthItem::find()->where(['type' => 2])->orderBy(['name' => SORT_ASC])->all(),
        ]);
    }

    public function actionChangeChild()
    {
        //if (!\Yii::$app->user->can('admin')) throw new ForbiddenHttpException(\Yii::t('app', 'Access denied.'));
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $key_name = array_slice(array_keys($post), 2);
            AuthItemChild::deleteAll(['parent' => $post['parent_name']]);
            foreach ($key_name as $v) {
                $new_child = new AuthItemChild();
                $new_child->parent = $post['parent_name'];
                $new_child->child = $v;
                $new_child->save();
            }
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AuthItem();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->type = 1;
                $model->created_at = time();
                $model->updated_at = time();
                $model->rule_name = null;
                $model->save();
                return $this->redirect(['view', 'name' => $model->name]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }

    /* public function actionAddItems()
     {
         $i = 0;
         for ($i; $i < 4; $i++) {
             switch ($i){
                 case 0: $name='create'; break;
                 case 1: $name='view'; break;
                 case 2: $name='update'; break;
                 case 3: $name='delete'; break;
             }
             $model = new AuthItem();
             $model->type = 2;
             $model->name = $name;
             $model->created_at = time();
             $model->updated_at = time();
             $model->rule_name = 'Other';
             $model->save();
         }
     }*/

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $name Name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($name)
    {
        $model = $this->findModel($name);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'name' => $model->name]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name Name
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($name)
    {
        $this->findModel($name)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name Name
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = AuthItem::findOne(['name' => $name])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function verifyAdmin()
    {
        if (!\Yii::$app->user->can('admin')) throw new ForbiddenHttpException('Access Denied!!!');
    }
}
