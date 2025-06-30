<?php

use common\models\Department;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PositionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Должности';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= ($this->title) ? $this->title : '' ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a
                                href="javascript: void(0);"><?= ($this->title) ? $this->title : '' ?></a></li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="tasksList">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Список должностей</h5>
                    <div class="flex-shrink-0">
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i
                                        class="ri-add-line align-bottom me-1"></i> Добавить должность
                            </button>
                            <button class="btn btn-secondary" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                        </div>
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
                        'tableOptions' => [
                            'id' => 'tasksTable',
                            'class' => 'table align-middle table-nowrap table-striped-columns mb-0'
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'company_id',
                                'value' => function ($model) {
                                    return $model->company->name;
                                }
                            ],
                            [
                                'attribute' => 'department_id',
                                'value' => function ($model) {
                                    return $model->department->name;
                                }
                            ],
                            'name',
                            [
                                'attribute' => 'salary',
                                'value' => function ($model) {
                                    return yii::$app->formatter->asDecimal($model->salary, 0);
                                }
                            ],
                            [
                                'attribute' => 'one_hour',
                                'value' => function ($model) {
                                    return yii::$app->formatter->asDecimal($model->one_hour, 0);
                                }
                            ],
                            [
                                'attribute' => 'bid',
                                'value' => function ($model) {
                                    return yii::$app->formatter->asDecimal($model->bid, 1);
                                }
                            ],
                            'created_at:datetime',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => ' {update}  {delete} ',
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return Html::a('<i class="ri-delete-bin-5-line"></i>', ['position/delete', 'id' => $model->id], [
                                            'title' => 'delete',
                                            'data-confirm' => 'Вы действительно хотите удалить?',
                                            'data-method' => 'post',
                                            'class' => 'link-danger',
                                        ]);
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="ri-settings-4-line"></i>', ['position/update', 'id' => $model->id], [
                                            'class' => 'link-primary',
                                        ]);
                                    },
                                ],
                                //'contentOptions' => ['style'=>'width:200px;']
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


<div class="modal fade zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="exampleModalLabel">Добавить должность</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>


        </div>
    </div>
</div>
<!--end modal-->

