<?php
$base = Yii::$app->request->baseUrl;
$companies = \common\models\Company::find()->orderBy(['name'=>SORT_ASC])->all();
?>
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?php use yii\helpers\Url;

        echo \yii\helpers\Url::to(['site/index']); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo $base; ?>/logo/simma_hr.png" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="<?php echo $base; ?>/logo/simma_hr.png" alt="" height="50">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="<?php echo \yii\helpers\Url::to(['site/index']); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo $base; ?>/logo/uztelecom_logo.png" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="<?php echo $base; ?>/logo/uztelecom_logo.png" alt="" height="50">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Навигация</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#notificationsSidebar" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="notificationsSidebar">
                        <i class="ri-notification-2-line"></i> <span data-key="t-dashboards">События</span>
                    </a>
                    <div class="collapse menu-dropdown" id="notificationsSidebar">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo \yii\helpers\Url::to(['notifications/index']); ?>" class="nav-link"> Мои события </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-list-check-3"></i> <span data-key="t-dashboards">Мои задачи</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo \yii\helpers\Url::to(['task/index']); ?>" class="nav-link"> Мои задачи </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['task/my-tasks']) ?>">Мои распоряжения</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo \yii\helpers\Url::to(['task/create']); ?>" class="nav-link"> Новая задача</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo \yii\helpers\Url::to(['task/kanban']); ?>" class="nav-link"> Канбан </a>
                            </li>
                            <hr>
                            <h6 style="color: #a4b0bf">
                                Отчёты
                            </h6>
                            <li class="nav-item">
                                <a href="<?php echo \yii\helpers\Url::to(['report/completed-tasks']); ?>" class="nav-link"> Завершенные задачи </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-list-check-3"></i> <span data-key="t-dashboards">Заявки</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarOrders">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= Url::to(['orders/index']); ?>" class="nav-link"> Все заявки </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['orders/my-orders']) ?>">Мои заявки</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= Url::to(['orders/create']) ?>" class="nav-link">Создать заявку</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#hr_block" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-id-card-line"></i> <span data-key="t-dashboards">Отдель кадров</span>
                    </a>
                    <div class="collapse menu-dropdown" id="hr_block">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['employees/index']) ?>" class="nav-link"> Карточки сотрудников </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['department/index']) ?>" class="nav-link"> Отделы </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['position/index']) ?>" class="nav-link"> Должности </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo \yii\helpers\Url::to(['user/index']); ?>" class="nav-link"> Пользователи</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#userReports" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-file-text-line"></i> <span> Документы </span>
                    </a>
                    <div class="collapse menu-dropdown" id="userReports">
                        <ul class="nav nav-sm flex-column">
                            <?php $i = 1;
                            foreach ($companies as $key => $item): ?>
                                <li class="nav-item">
                                    <a href="#docs_<?= $i ?>" class="nav-link" data-bs-toggle="collapse" role="button"
                                       aria-expanded="false" aria-controls="sidebarEmail" data-key="t-email">
                                        <?=$item->name?>
                                    </a>
                                    <div class="collapse menu-dropdown" id="docs_<?= $i; ?>">
                                        <ul class="nav nav-sm flex-column">

                                            <li class="nav-item"><a href="<?= Url::to(['documents/employee-list', 'company_id' => $item->id]) ?>"
                                                        class="nav-link">Список сотрудников</a>
                                            </li>
                                            <li class="nav-item"><a href="<?= Url::to(['documents/employee-list', 'company_id' => $item->id, 'gender' => 'male']) ?>"
                                                        class="nav-link"> Список мужчин </a>
                                            </li>
                                            <li class="nav-item"><a href="<?= Url::to(['documents/employee-list', 'company_id' => $item->id, 'gender' => 'female']) ?>"
                                                        class="nav-link"> Список женщин </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= Url::to(['documents/employee-children', 'company_id' => $item->id]) ?>"
                                                        class="nav-link">Список детей</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo \yii\helpers\Url::to(['documents/staffing-list','company_id'=>$item->id]); ?>" class="nav-link">  Руководители cтруктур</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo \yii\helpers\Url::to(['documents/staffing-schedule','company_id'=>$item->id]); ?>" class="nav-link"> Штатное расписание </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <?php $i++; endforeach; ?>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item d-none">
                    <a class="nav-link menu-link" href="#billingSide" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-list-check-3"></i> <span data-key="t-dashboards">Биллинг</span>
                    </a>
                    <div class="collapse menu-dropdown" id="billingSide">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo \yii\helpers\Url::to(['user/balance']); ?>" class="nav-link"> Все балансы </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#extra_block" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-tools-line"></i> <span data-key="t-dashboards"> Инструменты</span>
                    </a>
                    <div class="collapse menu-dropdown" id="extra_block">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['site/transliteration']) ?>" class="nav-link"
                                > Транслитерация </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['news/index']) ?>" class="nav-link"
                                > Оповещение всех </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarApps">
                        <i class="lab la-delicious"></i> <span data-key="t-apps">Справочники</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['region/index']) ?>" class="nav-link"
                                > Регионы </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['status-list/index']) ?>" class="nav-link"
                                > Статусы cотрудников </a>
                            </li>
                            <?php $dir = \common\models\DirectoryCategory::find()->all();
                            foreach ($dir as $item): ?>
                                <li class="nav-item">
                                    <a href="<?= Url::to(['directory-category/view', 'id' => $item->id]) ?>"
                                       class="nav-link">
                                        <?= $item->name_ru ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>


                <?php if (Yii::$app->user->can('admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#settingsCollapse" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarApps">
                            <i class="lab ri-settings-4-line"></i> <span data-key="t-apps">Настройки</span>
                        </a>
                        <div class="collapse menu-dropdown" id="settingsCollapse">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="<?= \yii\helpers\Url::to(['auth-item/index']) ?>" class="nav-link"> Роли
                                        сотрудников </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= Url::to(['directory-category/index']) ?>" class="nav-link">Категории
                                        директорий</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>