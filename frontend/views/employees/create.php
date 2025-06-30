<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\User $user_id */
/** @var common\models\Employees $model */

$this->title = 'Карточка сотрудника';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
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
                    <li class="breadcrumb-item active">
                        <a href="<?= Url::to(['index']) ?>">Карточки сотрудников</a>
                    </li>
                    <li class="breadcrumb-item"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="card">
    <div class="card-header border-0">
        <div class="d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">Карточка пользователя: <?php echo $user->fullname; ?> </h5>
            <p class="text-muted mb-0">
                <?php
                if ($user->department) {
                    echo  $user->department->name;
                } else {
                    echo 'Не задано!!';
                }
                ?> /
                <?php
                if ($user->position) {
                    echo $user->position->name;
                } else {
                    echo 'Не задано!!';
                }
                ?>
            </p>
        </div>
    </div>
</div>

<?= $this->render('_form', [
    'model' => $model,
    'user'=>$user,
]) ?>


