<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Department $model */

$this->title = 'Редактировать отдел: ' . $model->name;
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
<!-- end page title -->
<div class="department-update card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
