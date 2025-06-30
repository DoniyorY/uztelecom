<?php

use common\models\User;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Все балансы ';
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


<div class="row">
    <div class="col-lg-12">
        <div class="card" id="tasksList">
            <!--end card-body-->
            <div class="card-body">
                <div class="table-responsive table-card mb-4">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'summary' => '',
                        'tableOptions' => [
                            'id' => 'tasksTable',
                            'class' => 'table align-middle table-nowrap table-striped-columns mb-0'
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'header' => '',
                                'value' => function ($model) { return Yii::$app->params['company_id'][$model->user->department->company_id]; }
                            ],
                            [
                                'attribute' => 'user_id',
                                'value' => function ($model) {
                                    return $model->user->fullname;
                                }
                            ],
                            [
                                'header' => 'Номер телефона',
                                'value' => function ($model) { return $model->user->phone_number;}
                            ],
                            [
                                'header' => 'Отдел',
                                'value' => function ($model) { return $model->user->department->name; }
                            ],
                            [
                                'header' => 'Должность',
                                'value' => function ($model) { return $model->user->position->name;}
                            ],

                            [
                                'attribute' => 'value',
                                'value' => function ($model) {
                                    return yii::$app->formatter->asDecimal($model->value,0).' UZS';
                                },
                                'contentOptions' => ['class' => 'table-success text-center font-weight-bold'],
                            ],
                            'created_at:datetime',
                            'updated_at:datetime',
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
