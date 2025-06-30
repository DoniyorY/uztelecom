<?php

use common\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\TaskComment;
use common\models\TaskResult;

/** @var yii\web\View $this */
/** @var common\models\Task $model */

$this->title = 'Задача #' . $model->id . ' | ' . $model->title;
$base = Yii::$app->request->baseUrl;
\yii\web\YiiAsset::register($this);
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= ($this->title) ? $this->title : '' ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?= Yii::$app->homeUrl ?>">Главная</a></li>
                    <li class="breadcrumb-item"><a href="<?= Url::to(['index']) ?>">Мои задачи</a></li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<?php echo Alert::widget() ?>
<div class="row">
    <div class="col-xxl-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="card-title mb-3 flex-grow-1 text-start">Дата истечение срока</h6>
                <div class="mb-2">
                    <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop"
                               colors="primary:#405189,secondary:#02a8b5" style="width:90px;height:90px">
                    </lord-icon>
                </div>
                <h3 class="mb-1" id="timer">9 hrs 13 min</h3>
                <hr/>
                <script>
                    function startCountdown(targetDate) {
                        function updateCountdown() {
                            const now = new Date();
                            const timeDiff = new Date(targetDate) - now;

                            if (timeDiff <= 0) {
                                document.getElementById("timer").textContent = "Время вышло!";
                                clearInterval(interval);
                                return;
                            }

                            const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((timeDiff / (1000 * 60 * 60)) % 24);
                            const minutes = Math.floor((timeDiff / (1000 * 60)) % 60);
                            const seconds = Math.floor((timeDiff / 1000) % 60);

                            document.getElementById("timer").textContent =
                                `${days} д ${hours} ч ${minutes} м ${seconds} с`;
                        }

                        updateCountdown(); // Run immediately
                        const interval = setInterval(updateCountdown, 1000);
                    }

                    // Set target date (YYYY-MM-DDTHH:MM:SS format)
                    <?php $deadline = date('Y-m-d H:s:i', $model->dead_line); ?>
                    startCountdown("<?php echo $deadline; ?>");
                </script>
            </div>
        </div>
        <!--end card-->
        <div class="card mb-3">
            <div class="card-header">
                <h5>Статусы задачи</h5>
            </div>
            <div class="card-body">
                <div class="btn-group w-100">
                    <?php
                    if ($model->by_user_id == Yii::$app->user->id or $model->user_id == Yii::$app->user->id) {
                        if ($model->status_id == 0 and $model->dead_line > time()) {
                            echo Html::a('Начать задачу', ['status', 'token' => $model->token, 'status' => 1, 'position' => 1],
                                [
                                    'class' => 'btn btn-primary w-100',
                                    'data-confirm' => 'Подтвердите действие!!!'
                                ]);
                        } elseif ($model->status_id == 1) {
                            if ($check_res) {
                                echo Html::a('Завершить задачу', ['status', 'token' => $model->token, 'status' => 2, 'position' => 2],
                                    [
                                        'class' => 'btn btn-success',
                                        'data-confirm' => 'Подтвердите действие!!!'
                                    ]);
                            }
                            echo Html::a('Отменить задачу', ['status', 'token' => $model->token, 'status' => 3, 'position' => 3],
                                [
                                    'class' => 'btn btn-danger',
                                    'data-confirm' => 'Подтвердите действие!!!'
                                ]);
                        } else {
                            echo Html::button(\Yii::$app->params['task_status'][$model->status_id], ['class' => 'btn btn-info']);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-card">
                    <table class="table mb-0">
                        <tbody>
                        <tr>
                            <td class="fw-medium">#</td>
                            <td>#<?php echo $model->id; ?></td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Заказчик</td>
                            <td>  <?php echo $model->byUser->fullname; ?></td>
                        </tr>
                        <tr>
                            <td class="fw-medium"><?php echo $model->getAttributeLabel('level_id'); ?></td>
                            <td>  <?php echo Yii::$app->params['task_level_id_style'][$model->level_id]; ?></td>
                        </tr>
                        <tr>
                            <td class="fw-medium"><?php echo $model->getAttributeLabel('status_id'); ?></td>
                            <td>  <?php echo Yii::$app->params['task_status'][$model->status_id]; ?></td>
                        </tr>
                        <tr>
                            <td class="fw-medium"><?php echo $model->getAttributeLabel('dead_line'); ?></td>
                            <td><?php echo date('j.m.Y H:i', $model->dead_line); ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <!--end table-->
                </div>
            </div>
        </div>
        <!--end card-->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <h6 class="card-title mb-0 flex-grow-1"><?= $model->getAttributeLabel('task_members') ?></h6>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#inviteMembersModal"><i class="ri-share-line me-1 align-bottom"></i>
                            Исполнители
                        </button>
                    </div>
                </div>
                <ul class="list-unstyled vstack gap-3 mb-0">
                    <?php foreach ($task_members as $item): ?>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <?php
                                    $filePath = Yii::getAlias('@web/uploads/users/' . $item->user->image);
                                    if (file_exists($filePath) and $item->user->image):?>
                                        <img src="<?= "$base/uploads/users/{$item->user->image}" ?>" alt=""
                                             class="avatar-xs rounded-circle">
                                    <?php else: ?>
                                        <img src="/images/users/user-dummy-img.jpg" alt=""
                                             class="avatar-xs rounded-circle">
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-1 fs-15"><a href="pages-profile"><?= $item->user->fullname ?></a></h6>
                                    <p class="text-muted mb-0"><?= ($item->user->position) ? $item->user->position->name : 'Не задано' ?></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="dropdown">
                                        <button class="btn btn-icon btn-sm fs-16 text-muted dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                   href="<?= Url::to(['user/view', 'token' => $item->user->token]) ?>"><i
                                                            class="ri-eye-fill text-muted me-2 align-bottom"></i>Профиль</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" data-method="post"
                                                   data-confirm="Подтвердите действие!!!"
                                                   href="<?= Url::to(['delete-member', 'id' => $item->id]) ?>">
                                                    <i class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Удалить
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <!--end card-->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Ресурсы</h5>
                <div class="vstack gap-2">
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
                                <h5 class="fs-15 mb-1"><a href="javascript:void(0);"
                                                          class="text-body text-truncate d-block">App pages.zip</a></h5>
                                <div class="text-muted">2.2MB</div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-icon text-muted btn-sm fs-18"><i
                                                class="ri-download-2-line"></i></button>
                                    <div class="dropdown">
                                        <button class="btn btn-icon text-muted btn-sm fs-18 dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Rename</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded border-dashed p-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                        <i class="ri-file-ppt-2-line"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="fs-15 mb-1"><a href="javascript:void(0);"
                                                          class="text-body text-truncate d-block">Velzon admin.ppt</a>
                                </h5>
                                <div class="text-muted">2.4MB</div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-icon text-muted btn-sm fs-18"><i
                                                class="ri-download-2-line"></i></button>
                                    <div class="dropdown">
                                        <button class="btn btn-icon text-muted btn-sm fs-18 dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Rename</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                <h5 class="fs-15 mb-1"><a href="javascript:void(0);"
                                                          class="text-body text-truncate d-block">Images.zip</a></h5>
                                <div class="text-muted">1.2MB</div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-icon text-muted btn-sm fs-18"><i
                                                class="ri-download-2-line"></i></button>
                                    <div class="dropdown">
                                        <button class="btn btn-icon text-muted btn-sm fs-18 dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Rename</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 text-center">
                        <a href="#messages-1" role="tab" type="button" class="btn btn-secondary">View more</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
    <!---end col-->
    <div class="col-xxl-9">
        <div class="card">
            <div class="card-body">

                <div class="text-muted">
                    <h6 class="mb-3 fw-semibold text-uppercase">Заголовок</h6>
                    <p><?php echo $model->title; ?></p>

                    <h6 class="mb-3 fw-semibold text-uppercase">Описание задачи</h6>
                    <p><?php echo $model->content; ?></p>
                </div>
            </div>
        </div>
        <!--end card-->
        <div class="card">
            <div class="card-header">
                <div>
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#taskResult" role="tab">
                                Результат (<?= $results_count ?>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#home-1" role="tab">
                                Обсуждения (<?= $comments_count ?>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab">
                                Исполняемые файлы (4)
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile-1" role="tab">
                                Time Entries (9 hrs 13 min)
                            </a>
                        </li>
                    </ul>
                    <!--end nav-->
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="taskResult" role="tabpanel">
                        <h5 class="card-title mb-4">Результат</h5>
                        <div data-simplebar style="max-height: 508px ;" class="px-3 mx-n3 mb-2">
                            <?php foreach ($results as $item): ?>
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        <?php $filePath = Yii::getAlias('@web/uploads/users/' . $item->user->image);
                                        if (file_exists($filePath) and $item->user->image): ?>
                                            <img src="<?= "$base/uploads/users/{$item->user->image}" ?>" alt=""
                                                 class="avatar-xs rounded-circle">
                                        <?php else: ?>
                                            <img src="/images/users/user-dummy-img.jpg" alt=""
                                                 class="avatar-xs rounded-circle">
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="fs-15"><a
                                                    href="<?= Url::to(['user/view', 'token' => $item->user->token]) ?>"><?= $item->user->fullname ?></a>
                                            <small
                                                    class="text-muted"><?= Yii::$app->formatter->asDatetime($item->created_at, 'php:d.MY - H:i:s') ?></small>
                                        </h5>
                                        <p class="text-muted"><?= $item->content ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?= $this->render('_form_comment', ['model' => new TaskResult(), 'task_id' => $model->id, 'url' => Url::to(['add-result'])]) ?>
                    </div>
                    <div class="tab-pane " id="home-1" role="tabpanel">
                        <h5 class="card-title mb-4">Обсуждения</h5>
                        <div data-simplebar style="max-height: 508px ;" class="px-3 mx-n3 mb-2">
                            <?php foreach ($comments as $item): ?>
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        <?php $filePath = Yii::getAlias('@web/uploads/users/' . $item->user->image);
                                        if (file_exists($filePath) and $item->user->image): ?>
                                            <img src="<?= "$base/uploads/users/{$item->user->image}" ?>" alt=""
                                                 class="avatar-xs rounded-circle">
                                        <?php else: ?>
                                            <img src="/images/users/user-dummy-img.jpg" alt=""
                                                 class="avatar-xs rounded-circle">
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="fs-15"><a
                                                    href="<?= Url::to(['user/view', 'token' => $item->user->token]) ?>"><?= $item->user->fullname ?></a>
                                            <small
                                                    class="text-muted"><?= Yii::$app->formatter->asDatetime($item->created_at, 'php:d.MY - H:i:s') ?></small>
                                        </h5>
                                        <p class="text-muted"><?= $item->content ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?= $this->render('_form_comment', ['model' => new TaskComment(), 'task_id' => $model->id, 'url' => Url::to(['add-comment'])]) ?>

                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="messages-1" role="tabpanel">
                        <div class="table-responsive table-card">
                            <table class="table table-borderless align-middle mb-0">
                                <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">File Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Upload Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                    <i class="ri-file-zip-fill"></i>
                                                </div>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="fs-15 mb-0"><a href="javascript:void(0)">App pages.zip</a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Zip File</td>
                                    <td>2.22 MB</td>
                                    <td>21 Dec, 2021</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="btn btn-light btn-icon"
                                               id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="ri-equalizer-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuLink1" data-popper-placement="bottom-end"
                                                style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 23px);">
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-eye-fill me-2 align-middle text-muted"></i>View</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a>
                                                </li>
                                                <li class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-danger-subtle text-danger rounded fs-20">
                                                    <i class="ri-file-pdf-fill"></i>
                                                </div>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="fs-15 mb-0"><a href="javascript:void(0);">Velzon
                                                        admin.ppt</a></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>PPT File</td>
                                    <td>2.24 MB</td>
                                    <td>25 Dec, 2021</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="btn btn-light btn-icon"
                                               id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="ri-equalizer-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuLink2" data-popper-placement="bottom-end"
                                                style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 23px);">
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-eye-fill me-2 align-middle text-muted"></i>View</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a>
                                                </li>
                                                <li class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-info-subtle text-info rounded fs-20">
                                                    <i class="ri-folder-line"></i>
                                                </div>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="fs-15 mb-0"><a href="javascript:void(0);">Images.zip</a></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>ZIP File</td>
                                    <td>1.02 MB</td>
                                    <td>28 Dec, 2021</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="btn btn-light btn-icon"
                                               id="dropdownMenuLink3" data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="ri-equalizer-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuLink3" data-popper-placement="bottom-end"
                                                style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 23px);">
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-eye-fill me-2 align-middle"></i>View</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-download-2-fill me-2 align-middle"></i>Download</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-danger-subtle text-danger rounded fs-20">
                                                    <i class="ri-image-2-fill"></i>
                                                </div>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="fs-15 mb-0"><a href="javascript:void(0);">Bg-pattern.png</a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>PNG File</td>
                                    <td>879 KB</td>
                                    <td>02 Nov 2021</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="btn btn-light btn-icon"
                                               id="dropdownMenuLink4" data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="ri-equalizer-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuLink4" data-popper-placement="bottom-end"
                                                style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 23px);">
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-eye-fill me-2 align-middle"></i>View</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-download-2-fill me-2 align-middle"></i>Download</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                    </div>

                    <!--end tab-pane-->
                    <div class="tab-pane" id="profile-1" role="tabpanel">
                        <h6 class="card-title mb-4 pb-2">Time Entries</h6>
                        <div class="table-responsive table-card">
                            <table class="table align-middle mb-0">
                                <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">Member</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Timer Idle</th>
                                    <th scope="col">Tasks Title</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="/images/users/avatar-8.jpg" alt=""
                                                 class="rounded-circle avatar-xxs">
                                            <div class="flex-grow-1 ms-2">
                                                <a href="pages-profile" class="fw-medium">Thomas Taylor</a>
                                            </div>
                                        </div>
                                    </th>
                                    <td>02 Jan, 2022</td>
                                    <td>3 hrs 12 min</td>
                                    <td>05 min</td>
                                    <td>Apps Pages</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="/images/users/avatar-10.jpg" alt=""
                                                 class="rounded-circle avatar-xxs">
                                            <div class="flex-grow-1 ms-2">
                                                <a href="pages-profile" class="fw-medium">Tonya Noble</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>28 Dec, 2021</td>
                                    <td>1 hrs 35 min</td>
                                    <td>-</td>
                                    <td>Profile Page Design</td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="/images/users/avatar-10.jpg" alt=""
                                                 class="rounded-circle avatar-xxs">
                                            <div class="flex-grow-1 ms-2">
                                                <a href="pages-profile" class="fw-medium">Tonya Noble</a>
                                            </div>
                                        </div>
                                    </th>
                                    <td>27 Dec, 2021</td>
                                    <td>4 hrs 26 min</td>
                                    <td>03 min</td>
                                    <td>Ecommerce Dashboard</td>
                                </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                    </div>
                    <!--edn tab-pane-->

                </div>
                <!--end tab-content-->
            </div>
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="modal fade" id="inviteMembersModal" tabindex="-1" aria-labelledby="inviteMembersModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 ps-4 bg-success-subtle">
                <h5 class="modal-title" id="inviteMembersModalLabel">Назначенные исполнители</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="search-box mb-3">
                    <input type="text" class="form-control bg-light border-light" placeholder="Поиск исполнителя...">
                    <i class="ri-search-line search-icon"></i>
                </div>

                <div class="mb-4 d-flex align-items-center">
                    <div class="me-2">
                        <h5 class="mb-0 fs-13">Участники :</h5>
                    </div>
                    <div class="avatar-group justify-content-center">
                        <?php foreach ($task_members as $item): ?>
                            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                               data-bs-trigger="hover" data-bs-placement="top" title="<?= $item->user->fullname ?>">
                                <div class="avatar-xs">
                                    <?php $filePath = Yii::getAlias('@web/uploads/users/' . $item->user->image);
                                    if (file_exists($filePath) and $item->user->image): ?>
                                        <img src="<?= "$base/uploads/users/{$item->user->image}" ?>" alt=""
                                             class="rounded-circle img-fluid">
                                    <?php else: ?>
                                        <img src="/images/users/user-dummy-img.jpg" alt=""
                                             class="rounded-circle img-fluid">
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="mx-n4 px-4" data-simplebar style="max-height: 225px;">
                    <div class="vstack gap-3">
                        <?php foreach ($task_users as $item): ?>
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <?php $filePath = Yii::getAlias('@web/uploads/users/' . $item->image);
                                    if (file_exists($filePath) and $item->image): ?>
                                        <img src="<?= "$base/uploads/users/{$item->image}" ?>" alt=""
                                             class="rounded-circle img-fluid">
                                    <?php else: ?>
                                        <img src="/images/users/user-dummy-img.jpg" alt=""
                                             class="rounded-circle img-fluid">
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-13 mb-0"><a href="javascript:void(0);"
                                                              class="text-body d-block"><?= $item->fullname ?></a></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="<?= Url::to(['add-member', 'user_token' => $item->token,'task_token'=>$model->token]) ?>" data-method="post"
                                       type="button" class="btn btn-light btn-sm">Добавить</a>
                                </div>
                            </div>
                            <!-- end member item -->
                        <?php endforeach; ?>
                    </div>
                    <!-- end list -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light w-xs" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success w-xs">Assigned</button>
            </div>
        </div>
        <!-- end modal-content -->
    </div>
    <!-- modal-dialog -->
</div>
<!-- end modal -->