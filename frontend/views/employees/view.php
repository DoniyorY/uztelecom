<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Employees $model */

$this->title = 'Карточка № 00' . $model->id . ' | ' . $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$params = Yii::$app->params;
$birthDate = new DateTime(date('d.m.Y', $model->birthday));
$today = new DateTime();
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
                    <li class="breadcrumb-item">
                        <a href="<?= \yii\helpers\Url::to(['index']) ?>">Карточки сотрудников</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header border-0">
        <div class="d-flex align-items-center flex-wrap gap-2">
            <div class="flex-grow-1">
                <h5 class="card-title mb-0 flex-grow-1">Список всех сотрудников</h5>
            </div>
            <div class="flex-shrink-0">
                <div class="hstack text-nowrap gap-2">
                    <?= Html::a('Форма Т-2', ['documents/doc-t2', 'employee_id' => $model->id], ['class' => 'btn btn-primary']) ?>

                    <?php
                    if (Yii::$app->user->can('admin')) {
                        echo Html::a('<i class="ri-delete-bin-2-line"></i> Удалить', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger w-100',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                    ?>
                    <?= Html::a('<i class="ri-pencil-line"></i> Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary w-100']) ?>

                    <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"
                            class="btn btn-soft-info"><i class="ri-more-2-fill"></i></button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                        <li><a class="dropdown-item" href="<?= Url::to(['make-order', 'id' => $model->id]) ?>">Составить
                                трудовой договор</a></li>
                        <li><a class="dropdown-item" href="#">Last Week</a></li>
                        <li><a class="dropdown-item" href="#">Last Month</a></li>
                        <li><a class="dropdown-item" href="#">Last Year</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                <img class="w-100" src="<?= "/uploads/employees/$model->image" ?>" alt="">
                <br/>

                <div class="p-3">
                    <div class="table-responsive">
                        <table class="table table-borderless text-start mb-0">
                            <tbody>
                            <tr>
                                <th class="ps-0"
                                    scope="row"><?php echo $model->getAttributeLabel('mobile_phone'); ?></th>
                                <td class="text-muted"><?php echo $model->mobile_phone; ?></td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row"><?php echo $model->getAttributeLabel('work_phone'); ?></th>
                                <td class="text-muted"><?php echo $model->work_phone; ?></td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row"><?php echo $model->getAttributeLabel('created'); ?></th>
                                <td class="text-muted"><?php echo date('d.m.Y', $model->created); ?></td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row"><?php echo $model->getAttributeLabel('updated'); ?></th>
                                <td class="text-muted"><?php echo date('d.m.Y', $model->updated); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <p class="text-end">Типовая междуведомственная форма № Т-2</p>
                <table class="w-100 text-center">
                    <tr>
                        <th>Предприятие, организация</th>
                        <th>М/Ж</th>
                        <th>Табелный номер</th>
                        <th>Алфавит</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $model->getDirectory($model->sex); ?></td>
                        <td><?php echo date('Y', $model->created) ?></td>
                        <td>
                            <?php
                            $parts = explode(' ', trim($model->fullname));

                            if (count($parts) < 2) {
                                echo $model->fullname; // если недостаточно частей, вернуть как есть
                            }

                            if (isset($parts[0])) {
                                $initials = mb_substr($parts[0], 0, 1);
                            }
                            if (isset($parts[1])) {
                                $initials .= mb_substr($parts[1], 0, 1);
                            }
                            if (isset($parts[2])) {
                                $initials .= mb_substr($parts[2], 0, 1);
                            }

                            echo $initials;
                            ?>
                        </td>
                    </tr>
                </table>

                <h2 class="h4 mt-3 mb-3 text-center">
                    ЛИЧНАЯ КАРТОЧКА №
                    <span class="border-bottom px-5 py-1"> <?php echo $model->id; ?> </span>
                </h2>
                <h3 class="h5">I. Общие сведения</h3>
                <table class="table table-bordered table-sm text-center">
                    <tr>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('fullname'); ?></th>
                        <td><?php echo $model->fullname; ?> ( Возраст: <?= $today->diff($birthDate)->y; ?> )</td>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('sex'); ?></th>
                        <td><?php echo $model->getDirectory($model->sex); ?></td>
                    </tr>
                    <tr>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('citizenship'); ?></th>
                        <td><?php echo $model->getDirectory($model->citizenship); ?></td>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('birthday'); ?></th>
                        <td><?php echo date('d.m.Y', $model->birthday); ?>
                            / <?php echo $model->getDirectory($model->birthday_city) ?></td>
                    </tr>
                    <tr>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('nationality'); ?></th>
                        <td><?php echo $model->getDirectory($model->nationality); ?></td>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('family_status'); ?></th>
                        <td><?php echo $model->getDirectory($model->family_status); ?></td>
                    </tr>
                    <tr>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('passport_series'); ?></th>
                        <td><?php echo $model->passport_series; ?></td>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('passport_pinfl'); ?></th>
                        <td><?php echo $model->passport_pinfl; ?></td>
                    </tr>
                    <tr>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('passport_inn'); ?></th>
                        <td><?php echo $model->passport_inn; ?></td>
                        <th></th>
                        <td></td>
                    </tr>
                    <tr>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('passport_end_date'); ?></th>
                        <td><?php echo date('d.m.Y', $model->passport_end_date); ?></td>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('passport_whois'); ?></th>
                        <td><?php echo $model->passport_whois; ?></td>
                    </tr>
                </table>
                <h3 class="h5">II. Адресс проижвания</h3>
                <table class="table table-bordered table-sm text-center">
                    <tr>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('postcode'); ?></th>
                        <td><?php echo $model->postcode; ?></td>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('area'); ?></th>
                        <td><?php echo $model->area; ?></td>
                    </tr>
                    <tr>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('city'); ?></th>
                        <td><?php echo $model->city; ?></td>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('address'); ?></th>
                        <td><?php echo $model->address; ?></td>
                    </tr>
                    <tr>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('address_registration'); ?></th>
                        <td><?php echo $model->address_registration; ?></td>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('temporary_registration_address'); ?></th>
                        <td><?php echo $model->temporary_registration_address; ?></td>
                    </tr>

                    <tr>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('tra_start_date'); ?></th>
                        <td><?php echo date('d.m.Y', $model->tra_start_date); ?></td>
                        <th class="table-secondary"><?php echo $model->getAttributeLabel('tra_end_date'); ?></th>
                        <td><?php echo date('d.m.Y', $model->tra_end_date); ?></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header border-0">
        <div class="d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">Электронные файлы сотрудника</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-3">
                <div class="border p-2 border-dashed bg-secondary rounded p-0 mb-0">
                    <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>
                    <?= $form->field($model_files, 'imageFile')->fileInput(['maxlength' => true]) ?>
                    <br/>
                    <?= $form->field($model_files, 'type')->textInput(['type' => 'text']) ?>
                    <br/>
                    <?= Html::submitButton('Загрузить', ['class' => 'w-100 btn btn-success']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-12 col-sm-9">
                <div class="row g-3">

                    <?php foreach ($all_files as $one_file): ?>
                        <?php
                        $url = Yii::$app->request->baseUrl . 'uploads/files/' . $one_file->image;
                        $path = Yii::getAlias('@frontend/web/uploads/files/' . $one_file->image);
                        ?>
                        <div class="col-xxl-6 col-lg-4">
                            <div class="border rounded border-dashed p-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                <i class="ri-folder-zip-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="fs-14 mb-1"><?php echo $one_file->type; ?></h5>
                                        <div><?php echo Yii::$app->formatter->asDecimal(filesize($path) / 1024 / 1024, 2); ?>
                                            MB
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <div class="d-flex gap-1">
                                            <a type="button" href="<?php echo $url; ?>"
                                               class="btn btn-icon text-muted btn-sm fs-18">
                                                <i class="ri-download-2-line"></i>
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-icon text-muted btn-sm fs-18 dropdown"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <?= Html::a('<i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Удалить файл',
                                                            ['delete-file', 'id' => $one_file->id], [
                                                                'class' => 'dropdown-item',
                                                                'data' => [
                                                                    'confirm' => 'Вы действительно хотите удалить ?',
                                                                    'method' => 'post',
                                                                ],
                                                            ]) ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- end col -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header border-0">
        <div class="d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">Дети сотруника</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-3">
                <div class="border p-2 border-dashed bg-secondary rounded p-0 mb-0">
                    <?= $this->render('_form_children', [
                        'model' => new \common\models\EmployeesChildren(),
                        'employee_id' => $model->id
                    ]) ?>
                </div>
            </div>
            <div class="col-12 col-sm-9">
                <div class="row g-3">
                    <table class="table table-sm table-bordered table-striped text-center">
                        <thead class="bg-dark text-white">
                        <tr>
                            <th>№</th>
                            <th>Ф.И.О</th>
                            <th>Дата рождения</th>
                            <th>Возраст</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        foreach ($children as $item): ?>
                            <tr>
                                <th><?= $i++ ?></th>
                                <td><?= $item->fullname ?></td>
                                <td><?= date('d.m.Y', $item->birthday) ?></td>
                                <td>
                                    <?php
                                    $age = date('Y') - date('Y', $item->birthday);
                                    echo $age;
                                    ?>
                                </td>
                                <td>
                                    <a href="<?= Url::to(['delete-child', 'id' => $item->id]) ?>"
                                       class="btn btn-danger w-100 btn-sm"
                                       data-method="post" data-confirm="Подтвердите действие!!!">
                                        Удалить <i class="ri-delete-bin-line"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
