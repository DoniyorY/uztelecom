<?php

use common\models\UserVisiting;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\UserVisitingSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Журнал посещений';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= ($this->title) ? $this->title : '' ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?= Yii::$app->homeUrl ?>">Главная</a></li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-lg-12">
        <div class="card" id="tasksList">
            <!--end card-body-->
            <div class="card-body p-3">
                <div class="table-responsive table-card mb-4">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'tableOptions' => [
                            'id' => 'event_type',
                            'class' => 'table table-sm align-middle table-nowrap table-striped-columns mb-0'
                        ],
                        'summary' => '',
                        'rowOptions' => function ($data) {
                            if ($data->type == 1) {
                                return ['class' => 'bg-success'];
                            }
                            if ($data->type == 2) {
                                return ['class' => 'bg-danger'];
                            }

                        },
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            //'created_at:datetime',
                            //'type',
                            [
                                    'attribute' => 'type',
                                    'format' => 'html',
                                    'value' => function ($data) {
                                        return Yii::$app->params['termnal_type'][$data->type];
                                    },

                            ],
                            [
                                'attribute' => 'time_int',
                                'value' => function ($data) {
                                    return date('j.m.Y',$data->time_int);
                                },

                            ],
                            [
                                'attribute' => 'time_int',
                                'value' => function ($data) {
                                    return date('H:i',$data->time_int);
                                },

                            ],

                            //'time_date',

                            'terminal_employee_no',
                            'terminal_card',
                        ],
                    ]); ?>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->
