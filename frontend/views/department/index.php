<?php

use common\models\Department;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\DepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Отделы';
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
                                href="<?=Yii::$app->homeUrl?>">Главная</a></li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<?=\common\widgets\Alert::widget()?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="tasksList">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Список отделов</h5>
                    <div class="flex-shrink-0">
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i
                                        class="ri-add-line align-bottom me-1"></i> Добавить отдел
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
                        'tableOptions' => [
                            'id' => 'tasksTable',
                            'class' => 'table align-middle table-nowrap table-striped-columns mb-0'
                        ],
                        'pager'=>Yii::$app->params['gridViewPager'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'company_id',
                                'value' => function ($model) {
                                    return $model->company->name;
                                }
                            ],
                            //'company_id',
                            'name',
                            [
                                'attribute' => 'head_id',
                                'value' => function ($data) {
                                    if ($data->head_id != 0) {
                                        return $data->dephead->fullname;
                                    } else {
                                        return '-';
                                    }
                                }
                            ],
                            'created_at:datetime',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => ' {list} - {update}  {delete} ',
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return Html::a('<i class="ri-delete-bin-5-line"></i>', ['department/delete', 'id' => $model->id], [
                                            'title' => 'delete',
                                            'data-confirm' => 'Вы действительно хотите удалить?',
                                            'data-method' => 'post',
                                            'class' => 'link-danger',
                                        ]);
                                    },
                                    'list' => function ($url, $model, $key) {
                                        return Html::a('<i class="ri-file-list-fill"></i> cписок', ['department/list', 'id' => $model->id], [
                                            'class' => 'link-danger',
                                        ]);
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="ri-settings-4-line"></i>', ['department/update', 'id' => $model->id], [
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
                <h5 class="modal-title" id="exampleModalLabel">Добавить отдел</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>

            <?= $this->render('_form', [
                'model' => $model_one,
            ]) ?>


        </div>
    </div>
</div>
<!--end modal-->
