<?php

use common\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\search\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Штатное расписание форма Т-3 ';
$this->params['breadcrumbs'][] = $this->title;
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
<div class="row mb-3">
    <div class="col-md-10">

    </div>
    <div class="col-md-2">
        <button type="button" onclick="PrintElem('print-sale','<?= $this->title ?>')" class="btn btn-primary w-100"><i
                    class="bi bi-printer"></i> Распечатать <i class="ri-printer-line"></i>
        </button>
    </div>
</div>
<div id="print-sale">
    <?php for ($com_id = 1; $com_id <= Yii::$app->params['company_count']; $com_id++): ?>
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1"><?php echo Yii::$app->params['company_id'][$com_id] ?></h5>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <table class="table table-bordered table-sm">
                    <tr class="text-center">
                        <th colspan="2">Структурное подразделение</th>
                        <th colspan="1">Профессия (должность)</th>
                        <th colspan="1">Количество штатных единиц</th>
                        <th colspan="1">Оклад (тарифная ставка), сум</th>
                        <th colspan="3">Надбавка, сум</th>
                        <th colspan="1">Месячный фонд заработной платы, сум</th>
                        <th colspan="1">Примечание</th>
                    </tr>
                    <tr class="text-center">
                        <th>наименование</th>
                        <th>код</th>
                        <th></th>
                        <th></th>
                        <th></th>

                        <th>За ненормированный рабочий день, до 10%</th>
                        <th>Надбавки за особый режим работы, до 20%</th>
                        <th>За режим работы, до 40%</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr class="text-center">
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                        <td>9</td>
                        <td>10</td>
                    </tr>
                    <?php $i = 1;
                    $total_bid = 0;
                    foreach ($department_list as $one_dep): ?>

                        <?php $dep_position = \common\models\Position::find()->where(['company_id' => $com_id, 'department_id' => $one_dep->id])->all(); ?>
                        <?php $total_bid_dep = 0;
                        foreach ($dep_position as $one_pos): ?>
                            <tr>
                                <th><?php echo $one_dep->name; ?></th>
                                <td><?php echo $one_dep->company_id . '00' . $i; ?></td>
                                <td><?php echo $one_pos->name; ?></td>
                                <td class="text-center"><?php echo yii::$app->formatter->asDecimal($one_pos->bid, 1); ?></td>
                                <td class="text-center"><?php echo yii::$app->formatter->asDecimal($one_pos->salary, 0) ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php $total_bid_dep = $total_bid_dep + $one_pos->bid; endforeach; ?>

                        <?php $i++;
                        $total_bid = $total_bid + $total_bid_dep; endforeach; ?>

                    <tr class="text-center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <th><?php echo yii::$app->formatter->asDecimal($total_bid, 0) ?></th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                </table>
            </div>
        </div>
    <?php endfor; ?>
</div>


