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
$this->title = 'Руководители структурных подразделений';
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
<?php for($com_id=1;$com_id<=Yii::$app->params['company_count'];$com_id++):?>
<div class="card">
    <div class="card-header border-0">
        <div class="d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"><?php echo Yii::$app->params['company_id'][$com_id] ?></h5>
        </div>
    </div>
    <div class="card-body border border-dashed border-end-0 border-start-0">
        <table class="table table-bordered table-sm">
            <tr class="text-center">
                <th>#</th>
                <th>Организация</th>
                <th>Отдел</th>
                <th>Штатные единицы</th>
                <th>Руководитель</th>
                <th>Контакт</th>
            </tr>
            <?php $i=1; foreach($department_list as $one_dep): ?>
                <?php if($one_dep->company_id!=$com_id)continue; ?>
                <tr>
                    <th class="text-center"><?php echo $i; ?></th>
                    <td><?php echo Yii::$app->params['company_id'][$one_dep->company_id]; ?></td>
                    <td><?php echo $one_dep->name; ?></td>
                    <td></td>
                    <td><?php echo ($one_dep->head_id==0)?'-':$one_dep->dephead->fullname; ?></td>
                    <td><?php echo ($one_dep->head_id==0)?'-':$one_dep->dephead->phone_number; ?></td>
                </tr>
                <?php $i++; endforeach;?>
        </table>
    </div>
</div>
<?php endfor; ?>