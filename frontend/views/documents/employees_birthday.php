<?php
$this->title='Списки именинников';

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
        <table class="table table-sm table-bordered table-striped text-center">
            <thead>
            <tr>
                <th>#</th>
                <th>Ф.И.О</th>
                <th class="table-primary">Дата рождения</th>
                <th>Номер телефона</th>
                <th>Филиал</th>
                <th>Отдел</th>
                <th>Должность</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td class="table-primary"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>