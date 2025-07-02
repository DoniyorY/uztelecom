<?php
$this->title = $title;

use yii\helpers\Url;

?>


<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= ($this->title) ? $this->title : '' ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::$app->homeUrl ?>">Главная</a>
                    </li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-12 d-none">
                <h3>Фильтр по дате</h3>
                <form action="<?= Url::to(['birthday']) ?>" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date_begin">Дата начала</label>
                                <input type="date" class="form-control" name="Search[date_begin]" id="date_begin">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date_end">Дата окончания</label>
                                <input type="date" class="form-control" name="Search[date_end]" id="date_end">
                            </div>
                        </div>
                        <div class="col-md-2 mt-4">
                            <button class="btn btn-primary w-100" type="submit">
                                Поиск
                            </button>
                        </div>
                        <div class="col-md-2 mt-4">
                            <a href="<?= Url::to(['birthday']) ?>" class="btn btn-outline-secondary w-100">
                                Сбросить
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-sm table-bordered table-striped text-center">
            <thead>
            <tr>
                <th>#</th>
                <th>Ф.И.О</th>
                <th class="table-primary">Дата рождения</th>
                <th style="width: 10%;">Номер телефона</th>
                <th>Филиал</th>
                <th>Отдел</th>
                <th>Должность</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($query as $item): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $item['fullname'] ?></td>
                    <td class="table-primary"><?= date('d.m.Y', $item['birthday']) ?></td>
                    <td><?= $item['mobile_phone'] ?></td>
                    <td><?= $item['company_name'] ?></td>
                    <td><?= $item['department_name'] ?></td>
                    <td><?= $item['position_name'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>