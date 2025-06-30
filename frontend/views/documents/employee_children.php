<?php
$this->title = 'Дети сотрудников / ' . $company->name;

use yii\helpers\Url;

?>

<div class="card">
    <div class="card-header">
        <h5><?= $this->title ?></h5>
    </div>
    <div class="card-body">
        <table class="table table-sm table-bordered text-center" style="border-color: black">
            <thead style="border-color: black">
            <tr style="vertical-align: middle">
                <th style="width: 20px;">#</th>
                <th style="width: 70px;">Таб № сотр-ка</th>
                <th>Ф.И.О сотрудника</th>
                <th>Ф.И.О ребенка</th>
                <th>Год рождения</th>
                <th style="width: 130px;">Возраст ребенка</th>
                <th style="width: 130px;">Кол-во детей у сотрудника</th>
            </tr>
            </thead>
            <tbody style="vertical-align: middle">
            <?php $i = 1;
            foreach ($children as $key => $item): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $item[0]['parent_id'] ?></td>
                    <td><?= $key ?></td>
                    <td class="text-start">
                        <?php $m=1; foreach ($item as $val) {
                            echo $m.') '.$val['fullname'] . " <br>";
                        $m++; } ?>
                    </td>
                    <td>
                        <?php foreach ($item as $val) {
                            echo date('d.m.Y', $val['birthday']) . " <br>";
                        } ?>
                    </td>
                    <td>
                        <?php foreach ($item as $val){
                            echo $val['child_age'] . " <br>";
                        }?>
                    </td>
                    <td>
                        <?=count($item)?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
