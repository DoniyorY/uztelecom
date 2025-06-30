<?php

use common\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\search\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Мои задачи';
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

<div class="row">
    <div class="col-xxl-3 col-sm-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">Общее количество задач</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                                        data-target="<?= $total_count ?>">0</span></h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                                                    <i class="ri-ticket-2-line"></i>
                                                </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div>
    <!--end col-->
    <div class="col-xxl-3 col-sm-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">Новые задачи</p>
                        <h2 class="mt-4 ff-secondary fw-semibold">
                            <span class="counter-value" data-target="<?= $new_count ?>">0</span>
                        </h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                                <i class="mdi mdi-timer-sand"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div>
    <!--end col-->
    <div class="col-xxl-3 col-sm-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">Завершенные задачи</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                                        data-target="<?= $completed_count ?>">0</span>
                        </h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                                                    <i class="ri-checkbox-circle-line"></i>
                                                </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div>
    <!--end col-->
    <div class="col-xxl-3 col-sm-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">Отмененные задачи</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                                        data-target="<?= $canceled_count ?>">0</span>
                        </h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-4">
                                                    <i class="ri-delete-bin-line"></i>
                                                </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="card">
    <div class="card-body border border-dashed border-end-0 border-start-0">
        <h4>Фильтр списка задач</h4>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="tasksList">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Список моих задач</h5>
                </div>
            </div>
            <!--end card-body-->
            <div class="card-body">
                <div class="table-responsive table-card mb-4">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light text-muted">
                        <tr>
                            <th>#</th>
                            <th>Задача</th>
                            <th>Дата создания</th>
                            <th>Заказчик</th>
                            <th>Исполнители</th>
                            <th>Завершить</th>
                            <th></th>
                            <th>Статус#</th>
                            <th>Приоритет</th>
                        </tr>
                        </thead>
                        <tbody class="list form-check-all">
                        <?php
                        echo ListView::widget([
                            'dataProvider' => $dataProvider,
                            'options' => false,
                            'itemOptions' => ['tag' => false],
                            'itemView' => '_item',
                            'summary' => ''
                        ]);
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->