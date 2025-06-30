<?php
use yii\helpers\Url;
?>

<div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside"
            aria-haspopup="true" aria-expanded="false">
        <i class='bx bx-bell fs-22'></i>
        <?php if ($ntf->count() > 0): ?>
            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><?= $ntf->count() ?><span
                        class="visually-hidden">Непрочитанные сообщения</span></span>
        <?php endif; ?>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
         aria-labelledby="page-header-notifications-dropdown">

        <div class="dropdown-head bg-primary bg-pattern rounded-top">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 fs-16 fw-semibold text-white"> Уведомления </h6>
                    </div>
                    <div class="col-auto dropdown-tabs">
                        <?php if ($ntf->count() > 0): ?>
                            <span class="badge bg-light-subtle text-body fs-13"> <?= "{$ntf->count()} новых" ?> </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="px-2 pt-2">
                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                    id="notificationItemsTab" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#messages-tab" role="tab"
                           aria-selected="false">
                            Задачи
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="tab-content position-relative" id="notificationItemsTabContent">
            <div class="tab-pane fade py-2 ps-2 active show" id="messages-tab" role="tabpanel"
                 aria-labelledby="messages-tab">
                <div data-simplebar style="max-height: 300px;" class="pe-2">
                    <?php foreach ($ntf->all() as $item): ?>
                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                            <div class="d-flex">
                                <div class="avatar-xs me-3 flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="<?= Url::to(['notifications/redirect', 'ntf_id' => $item->id]) ?>"
                                       class="stretched-link">
                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold"><?= Yii::$app->params['notification_model_type'][$item->model_type] ?></h6>
                                    </a>
                                    <div class="fs-13 text-muted">
                                        <p class="mb-1">
                                            <?= $item->title ?>
                                        </p>
                                    </div>
                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                        <span><i class="mdi mdi-clock-outline"></i> <?= Yii::$app->formatter->asRelativeTime($item->created_at) ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="my-3 text-center view-all">
                        <a href="<?= \yii\helpers\Url::to(['notifications/index']) ?>" type="button"
                           class="btn btn-soft-success waves-effect waves-light">
                            View All Messages <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>