<?php

use common\models\Department;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\DepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Список сотрудников отдела';
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
                    <li class="breadcrumb-item">
                        <a href="<?= \yii\helpers\Url::to(['index']) ?>">Отделы</a>
                    </li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">
                Список сотрудников: <?php echo $model->name; ?>
                (начальник: <?php echo ($model->dephead)?$model->dephead->fullname:'Пока не назначен'; ?>)
            </h5>
            <div class="flex-shrink-0">
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i
                            class=" ri-printer-fill align-bottom me-1"></i> Распечатать список
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card mb-4">

            <table class="table table-bordered table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Должность</th>
                        <th scope="col">Сотрудник</th>
                        <th scope="col">Контакты</th>
                        <th scope="col">Дата начало</th>
                        <th scope="col">Зарплата</th>
                        <th scope="col">за 1 час</th>
                        <th scope="col">Ставка</th>
                    </tr>
                </thead>
                <?php $i=1; $total_bid=0; foreach($workers_list as $one):?>
                    <tr>
                        <th><?php echo $i; ?></th>
                        <td><?php echo $one->position->name; ?></td>
                        <td><?php echo $one->user->fullname; ?></td>
                        <td><?php echo $one->user->phone_number; ?></td>
                        <td><?php echo date('j.m.Y H:i',$one->created_at); ?></td>
                        <td><?php echo yii::$app->formatter->asDecimal($one->salary,0); ?></td>
                        <td><?php echo yii::$app->formatter->asDecimal($one->one_hour,0); ?></td>
                        <td><?php echo yii::$app->formatter->asDecimal($one->bid,2); $total_bid=$total_bid+$one->bid; ?></td>
                    </tr>
                <?php $i++; endforeach;?>
                <tfoot class="table-dark">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"><?php echo yii::$app->formatter->asDecimal($total_bid,2); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
