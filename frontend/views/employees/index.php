<?php

use common\models\Employees;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\DirectoryList;

/** @var yii\web\View $this */
/** @var common\models\search\EmployeesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Карточки сотрудников';
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
                    <li class="breadcrumb-item"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col-md-10">
                <h5 class="card-title mb-0 flex-grow-1">Список всех сотрудников</h5>
            </div>
            <div class="col-md-2">
                <!-- Default Modals
                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal">
                    Импортировать сотрудников
                </button>
                -->
                <?= Html::a('Добавить сотрудника', ['create'], ['class' => 'btn btn-danger w-100']) ?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?= $this->render('_search', ['model' => $searchModel]) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pager' => Yii::$app->params['gridViewPager'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                'fullname',
                'mobile_phone',
                [
                    'attribute' => 'sex',
                    'value' => function ($data) {
                        return $data->getDirectory($data->sex);
                    },
                    'filter' => ArrayHelper::map(DirectoryList::findAll(['category_id' => 4]), 'id', 'name_ru'),
                ],
                [
                    'attribute' => 'birthday',
                    'value' => function ($data) {
                        return date('d.m.Y', $data->birthday);
                    }
                ],
                [
                    'attribute' => 'nationality',
                    'value' => function ($data) {
                        return $data->getDirectory($data->nationality);
                    },
                ],
                //'family_status',
                'passport_series',
                //'passport_pinfl',
                //'passport_inn',
                //'passport_end_date',
                //'passport_whois',
                //'citizenship',
                //'birthday_city',
                //'postcode',
                //'work_phone',
                //'city',
                //'area',
                //'address',
                //'address_registration',
                //'temporary_registration_address',
                //'tra_start_date',
                //'tra_end_date',
                //'image',
                //'created',
                //'updated',
                //'status',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Employees $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => '{view}'
                ],
            ],
        ]); ?>
    </div>
</div>
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Импорт сотрудников</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= Url::to(['employee-import']) ?>" enctype="multipart/form-data" method="post">
                <input type="text" value="<?= Yii::$app->request->csrfToken ?>"
                       name="<?= Yii::$app->request->csrfParam ?>" hidden>
                <div class="modal-body">
                    <input type="file" class="form-control" name="importFile">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary ">Импортировать</button>
                </div>
            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
