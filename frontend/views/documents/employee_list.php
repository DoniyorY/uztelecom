<?php
$this->title = $company->name;
$subTitle= 'Список сотрудников';
if(array_key_exists('gender',$_GET)){
    if ($_GET['gender'] == 'male') {
        $subTitle= "Список мужчин";
    } elseif ($_GET['gender'] == 'female') {
        $subTitle= "Список женщин";
    }
}

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
                    <li class="breadcrumb-item">
                        <a href="#"><?=$subTitle?></a>
                    </li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->


<div class="card">
    <div class="card-header border-0">
        <div class="row">
            <div class="col-md-10">
                <h5><?=$subTitle?> / <?= $company->name ?></h5>
            </div>
            <div class="col-md-2">
                <button type="button" onclick="PrintElem('print-company-employees','<?= $subTitle . ' || ' . $this->title ?>')"
                        class="btn btn-primary w-100"><i class="bi bi-printer"></i> Распечатать <i
                            class="ri-printer-line"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body border border-dashed border-end-0 border-start-0">
        <!-- Accordions with Icons -->
        <div id="print-company-employees">
            <table class="table table-sm table-bordered text-center" style="border-color: black; color: black;">
                <thead style="border-color: black; color:black;">
                <tr style="vertical-align: middle">
                    <th style="width: 70px;">Таб № сотр-ка</th>
                    <th>Ф.И.О сотрудника</th>
                    <th>Пол</th>
                    <th style="width: 300px;">Серия пасспорта</th>
                    <th>Должность</th>
                    <th style="width: 400px;">Адрес</th>
                    <th>Национальность</th>
                    <th>Дата рождения</th>
                    <th>Возраст</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($query as $key => $item): ?>
                    <tr class="text-center">
                        <th colspan="9"><p style="font-size: 17px; margin: 0;"><?= $key ?></p></th>
                    </tr>
                    <?php $i = 1;
                    foreach ($item as $value): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $value['fullname'] ?></td>
                            <td><?= $value['gender'] ?></td>
                            <td><?= $value['passport_series'] . ' /<br> ' . $value['passport_whois'] ?></td>
                            <td><?= $value['position'] ?></td>
                            <td><?= $value['address'] ?></td>
                            <td><?= $value['nationality'] ?></td>
                            <td><?= date('d.m.Y', $value['birthday']) ?></td>
                            <td>
                                <?php
                                $birthDate = (new \DateTime())->setTimestamp($value['birthday']);
                                $now = new \DateTime();
                                $age = $birthDate->diff($now)->y;
                                echo $age;
                                ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>