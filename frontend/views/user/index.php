<?php

use common\models\User;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
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
<!-- end page title -->
<?php
echo Alert::widget() ?>
<!-- Modal -->
<div class="modal zoomIn" id="addmemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0">
            <?= $this->render('_form', ['model' => new User()]) ?>
        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->


<div class="row">
    <div class="col-lg-12">
        <div class="card" id="tasksList">
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="card-title mb-0 flex-grow-1">Список пользователей</h5>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-danger addMembers-modal" data-bs-toggle="modal"
                                data-bs-target="#addmemberModal"><i class="ri-add-fill me-1 align-bottom"></i> Новый пользователь
                        </button>
                    </div>
                    <div class="col-sm-12">
                        <?= $this->render('_search', ['model' => $searchModel]) ?>
                    </div>
                </div>
            </div>
            <!--end card-body-->
            <div class="card-body">
                <div class="table-responsive table-card mb-4">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'summary' => '',
                        'pager' => Yii::$app->params['gridViewPager'],
                        'rowOptions' => function ($data) {
                            if ($data->status == 0) {
                                return ['class' => yii::$app->params['user_status'][0]];
                            }
                            if ($data->status == 9) {
                                return ['class' => yii::$app->params['user_status'][9]];
                            }
                            if ($data->status == 10) {
                                return ['class' => yii::$app->params['user_status'][10]];
                            }

                        },
                        'tableOptions' => [
                            'id' => 'tasksTable',
                            'class' => 'table align-middle table-nowrap table-striped-columns mb-0'
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                    'attribute' => 'terminal_employee_no',
                                     'value' => function ($model) {
                                        return 'Empl:'.$model->terminal_employee_no.' | Card:'.$model->terminal_card;
                                     }
                            ],
                            'username',
                            'fullname',
                            'phone_number',
                            'gender',
                            [
                                'attribute' => 'department_id',
                                'value' => function ($data) {
                                    if ($data->department) {
                                        return $data->department->name;
                                    } else {
                                        return 'Не задано!!';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'position_id',
                                'value' => function ($data) {
                                    if ($data->position) {
                                        return $data->position->name;
                                    } else {
                                        return 'Не задано!!';
                                    }
                                }
                            ],
                            [
                                'header' => 'ЛК №',
                                'format' => 'raw',
                                'value' => function ($model) {
                                       if($model->checkCard()==false){
                                           return '-';
                                       } else {
                                           $employee_id=$model->checkCard();
                                           return Html::a('№ '.$employee_id,['employees/view','id'=>$employee_id],['class'=>'btn btn-link']);
                                       }
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'value' => function ($data) {
                                    return yii::$app->params['user_status'][$data->status];
                                },
                            ],
                            //'status',
                            //'updated_at',
                            //'token',

                            //'image',


                            //'rating',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<i class="ri-eye-line"></i> подробнее', ['view', 'token' => $model->token], [
                                            'class' => 'link-primary',
                                        ]);
                                    }
                                ],
                                'contentOptions' => ['style' => 'width:150px;', 'class' => 'text-center']
                            ],
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
