<?php

namespace frontend\controllers;

use common\models\UserVisiting;
use common\models\search\UserVisitingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserVisitingController implements the CRUD actions for UserVisiting model.
 */
class UserVisitingController extends Controller
{


    /**
     * Lists all UserVisiting models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserVisitingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = UserVisiting::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
