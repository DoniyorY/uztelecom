<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;

$base = yii::$app->request->baseUrl;
?>
<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="<?php echo yii::$app->homeUrl; ?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo $base; ?>/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo $base; ?>/images/logo-dark.png" alt="" height="17">
                        </span>
                    </a>

                    <a href="<?php echo yii::$app->homeUrl; ?>" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo $base; ?>/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo $base; ?>/images/logo-light.png" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                        id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>


                <div class="app-search d-none d-md-block" style="display: none;">
                    <!-- App Search-->
                </div>
            </div>

            <div class="d-flex align-items-center">

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                            data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                            class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>
                <?php
                $ntf = \common\models\Notifications::find()->where(['user_id' => yii::$app->user->id,'seen'=>0]);
                echo $this->render('topbar_notifications',[
                        'ntf'=>$ntf
                ])?>
        
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <?php $user_image = Yii::$app->user->identity->image;
                            if (file_exists(Yii::getAlias('@frontend/web/uploads/users/' . $user_image)) and $user_image):?>
                                <img class="rounded-circle header-profile-user"
                                     src="<?= "$base/uploads/users/$user_image" ?>"
                                     alt="<?php echo yii::$app->user->identity->fullname; ?>">
                            <?php else: ?>
                                <img class="rounded-circle header-profile-user"
                                     src="/images/users/avatar-1.jpg"
                                     alt="<?php echo yii::$app->user->identity->fullname; ?>">
                            <?php endif; ?>

                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    <?php echo yii::$app->user->identity->fullname; ?>
                                </span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">
                                    <?php $identity = Yii::$app->user->identity;
                                    echo ($identity->department) ? $identity->department->name : 'не задано' ?> /
                                    <?php echo ($identity->position) ? $identity->position->name : 'не задано'; ?>
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Привет!</h6>
                        <a class="dropdown-item" href="<?php echo Url::to(['task/index']); ?>">
                            <i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Мои задачи</span>
                        </a>
                        <a class="dropdown-item" href="<?php echo Url::to(['site/helpdesk']); ?>">
                            <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Помощь</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Баланс : <b>$5971.67</b></span>
                        </a>
                        <a class="dropdown-item"
                           href="<?php echo Url::to(['user/view', 'token' => yii::$app->user->identity->token]); ?>">
                            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Настройки</span>
                        </a>
                        <?php
                        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                            . Html::submitButton(
                                '<i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i><span class="align-middle" data-key="t-logout">Выход</span>',
                                ['class' => 'dropdown-item logout text-decoration-none']
                            )
                            . Html::endForm();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                               colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->