<?php

use yii\helpers\Url;
use common\models\TaskMembers;

$this->title = 'Канбан';
$base = Yii::$app->request->baseUrl;
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

<div class="card">
    <div class="card-body">
        <?= $this->render('_search_kanban') ?>

    </div>
    <!--end card-body-->
</div>
<!--end card-->

<div class="tasks-board mb-3">
    <?php foreach ($model as $key => $value): ?>
        <div class="tasks-list" style="min-width: 380px">
            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0"><?= Yii::$app->params['task_position'][$key] ?>
                        <small class="<?=Yii::$app->params['task_position_class'][$key]?> align-bottom ms-1 totaltask-badge"><?= count($value) ?></small>
                    </h6>
                </div>
                <div class="flex-shrink-0 d-none">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <span class="fw-medium text-muted fs-13">Приоритет<i class="mdi mdi-chevron-down ms-1"></i></span
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Приоритет</a>
                            <a class="dropdown-item" href="#">Дата создания</a>
                        </div>
                    </div>
                </div>
            </div>
            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                <div id="<?= Yii::$app->params['task_position'][$key] ?>" class="tasks">
                    <?php foreach ($value as $item): $members = TaskMembers::findAll(['task_id' => $item['id']]) ?>
                        <div class="card tasks-box">
                            <div class="card-body">
                                <div class="d-flex mb-2">
                                    <div class="col-11">
                                        <div class="flex-grow-1">
                                            <h6 class="fs-16 mb-0 text-truncate task-title"><a
                                                        href="<?= Url::to(['task/view', 'id' => $item['token']]) ?>"
                                                        class="text-body d-block"><?= $item['title'] ?></a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0" style="margin-left: 10px;">
                                        <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink12"
                                           data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink12">
                                            <li><a class="dropdown-item"
                                                   href="<?= Url::to(['task/view', 'id' => $item['token']]) ?>"><i
                                                            class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    Подробнее</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="text-muted"><?= $item['content'] ?></p>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="badge bg-primary-subtle text-primary" style="line-height: 1.2;">Основной исполнитель: <br> <?=$item['main_user_fullname']?></span>
                                        <span class="badge bg-danger-subtle text-danger mt-2" style="line-height: 1.2;">Дедлайн: <br><?=date('d.m.Y H:i:s',$item['dead_line'])?></span>
                                        
                                    </div>
                                    <div class="flex-shrink-0">
                                        <p style="margin-bottom: 2px; font-size: 12px;" class="badge badge-info text-info">
                                            Исполнители:
                                        </p>
                                        <div class="avatar-group">
                                            <a href="javascript: void(0);" class="avatar-group-item"
                                               data-bs-toggle="tooltip" data-bs-trigger="hover"
                                               data-bs-placement="top"
                                               title="<?= $item['main_user_fullname'] ?>">
                                                <?php if (file_exists(Yii::getAlias("@frontend/web/uploads/users/{$item['image']}")) and $item['image']): ?>
                                                    <img src="<?= "$base/uploads/users/{$item['image']}" ?>"
                                                         alt=""
                                                         class="rounded-circle avatar-xxs">
                                                <?php else: ?>
                                                    <img src="<?= "$base/images/users/user-dummy-img.jpg" ?>" alt=""
                                                         class="rounded-circle avatar-xxs">
                                                <?php endif; ?>
                                            </a>
                                            <?php foreach ($members as $member): ?>
                                                <a href="javascript: void(0);" class="avatar-group-item"
                                                   data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                   data-bs-placement="top"
                                                   title="<?= $member->user->fullname ?>">
                                                    <?php if (file_exists(Yii::getAlias("@frontend/web/uploads/users/{$member->user->image}")) and $member->user->image): ?>
                                                        <img src="<?= "$base/uploads/users/{$member->user->image}" ?>"
                                                             alt=""
                                                             class="rounded-circle avatar-xxs">
                                                    <?php else: ?>
                                                        <img src="<?= "$base/images/users/user-dummy-img.jpg" ?>" alt=""
                                                             class="rounded-circle avatar-xxs">
                                                    <?php endif; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->
                            <div class="card-footer border-top-dashed">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i>
                                                        <?="Дата создания: ". date('d.m.Y H:i', $item['created_at']) ?></span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <ul class="link-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0)" class="text-muted"><i
                                                            class="ri-question-answer-line align-bottom"></i>
                                                    <?= \common\models\TaskComment::find()->where(['task_id' => $item['id']])->count() ?>
                                                </a>
                                            </li>
                                            <li class="list-inline-item d-none">
                                                <a href="javascript:void(0)" class="text-muted"><i
                                                            class="ri-attachment-2 align-bottom"></i> 0</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!--end tasks-list-->
    <?php endforeach; ?>

</div>
<!--end task-board-->






