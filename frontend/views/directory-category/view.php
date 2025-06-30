<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\DirectoryList;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\DirectoryCategory $model */
$lang = Yii::$app->language;
$this->title = $model->{"name_$lang"};
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
    <div class="col-lg-12">
        <div class="card" id="tasksList">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Список "<?= ($this->title) ? $this->title : '' ?>" </h5>
                    <div class="flex-shrink-0">
                        <div class="d-flex flex-wrap gap-2">
                            <?php if (\Yii::$app->user->can('admin')): ?>
                                <a href="<?= Url::to(['/directory-category/delete-all', 'id' => $model->id]) ?>" class="btn btn-danger" data-confirm="Confirm The Action!!!" data-method="post">Удалить все</a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importData">Импортировать <i class="bi bi-file-earmark-arrow-down"></i></button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDirectory">Создать категорию<i class="bi bi-plus-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-body-->
            <div class="card-body">
                <div class="table-responsive table-card mb-4">
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
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
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            'name_ru',
                            'name_uzkyrl',
                            'name_uzlat',
                            //'type',
                            //'class_name',
                            //'class_id',
                            [
                                'class' => ActionColumn::className(),
                                'urlCreator' => function ($action, DirectoryList $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                                'template' => '{delete}',
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return Html::a('<i class="ri-delete-bin-5-line"></i>', ['delete-directory', 'id' => $model->id],
                                            ['class' => 'link-danger', 'data-method' => 'post', 'data-confirm' => 'Confirm the delete action ?']);
                                    }
                                ]
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end() ?>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->


<!-- Modal Create Directory -->
<div class="modal fade" id="createDirectory" tabindex="-1" aria-labelledby="createDirectoryLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createDirectoryLabel">Create Directory</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $this->render('_form_directory', ['model' => new DirectoryList(), 'category_id' => $model->id]) ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal Import Data-->
<div class="modal fade" id="importData" tabindex="-1" aria-labelledby="importDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="importDataLabel">Import Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $this->render('_form_import_data', ['category_id' => $model->id]) ?>
            </div>
        </div>
    </div>
</div>
