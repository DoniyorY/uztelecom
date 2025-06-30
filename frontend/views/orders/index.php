<?php

use common\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        [
                            'attribute' => 'user_id',
                            'value' => function ($data) {
                                return $data->user->username;
                            }
                        ],
                        [
                            'attribute' => 'employee_id',
                            'value' => function ($data) {
                                return $data->employee->fullname;
                            }
                        ],
                        'title',
                        //'content:ntext',
                        [
                            'attribute' => 'created_at',
                            'value' => function ($data) {
                                return date('d.m.Y H:i', $data->created_at);
                            }
                        ],
                        //'updated_at',
                        [
                            'attribute' => 'status',
                            'value' => function ($data) {
                                return Yii::$app->params['order_status'][$data->status];
                            }
                        ],
                        [
                            'attribute' => 'department_id',
                            'value' => function ($data) {
                                return $data->department->name;
                            }
                        ],
                        //'position_id',
                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, Orders $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                            'template' => '{view}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>


</div>
