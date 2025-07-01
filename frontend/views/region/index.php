<?php

use common\models\Region;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\RegionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Регионы';
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
                <div class="row">
                    <div class="col-md-10">
                        <h5 class="card-title mb-0 flex-grow-1">Список регионов</h5>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Добавить регион
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Новый регион</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?=$this->render('_form',['model'=>new Region()])?>
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
                        'pager' => [
                            'prevPageLabel' => '<span class="page-item">Prev</span>',
                            'nextPageLabel' => '<span class="page-item">Next</span>',
                            'disabledPageCssClass' => 'page-link',
                            'activePageCssClass' => 'page-item active',
                            'maxButtonCount' => 5,
                            'linkOptions' => ['class' => 'page-link'],
                            'options' => [
                                'tag' => 'ul',
                                'class' => 'pagination',
                                'style' => 'margin-left: 1px;'
                            ],
                        ],
                        'summary' => '',
                        'tableOptions' => [
                            'id' => 'tasksTable',
                            'class' => 'table align-middle table-nowrap table-striped-columns mb-0'
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            /*[
                                'attribute' => 'parent_id',
                                'value' => function ($data) {
                                    if ($data->parent) {
                                        return $data->parent->name;
                                    }else{
                                        return 'Не задано';
                                    }
                                },
                                'format'=>'raw',
                            ],*/
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
