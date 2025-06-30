<?php

/** @var yii\web\View $this */
/** @var string $content */
$base = Yii::$app->request->baseUrl;

use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
/*echo "<pre>";
print_r(Yii::$app->assetManager);
die();*/
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="ru" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="default"
      data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8"/>
    <title><?= ($this->title) ? $this->title : '' ?> | SIMMA SYSTEM</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="/images/favicon.ico">
    <!-- Sweet Alert css-->
    <link href="<?= $base ?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <!-- Layout config Js -->
    <script src="<?= $base ?>/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?= $base . '/css' ?>/bootstrap.min.css" rel="stylesheet" type="text<?= $base . '/css' ?>"/>
    <!-- Icons Css -->
    <link href="<?= $base . '/css' ?>/icons.min.css" rel="stylesheet" type="text<?= $base . '/css' ?>"/>
    <!-- App Css-->
    <link href="<?= $base . '/css' ?>/app.min.css" rel="stylesheet" type="text<?= $base . '/css' ?>"/>
    <!-- custom Css-->
    <link href="<?= $base . '/css' ?>/custom.css" rel="stylesheet" type="text<?= $base . '/css' ?>"/>
    <!-- Yii2 Assets -->
    <?=$this->head()?>
</head>
<body>
<?= $this->beginBody()?>
<div id="layout-wrapper">
    <?= $this->render('topbar') ?>
    <?= $this->render('left_sidebar') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>

    <?= $this->render('footer') ?>
</div>
<?= $this->render('js_scripts') ?>

<!-- list.js min js -->
<script src="/libs/list.js/list.min.js"></script>

<!--list pagination js-->
<script src="/libs/list.pagination.js/list.pagination.min.js"></script>

<!-- titcket init js -->
<!--<script src="/js/pages/tasks-list.init.js"></script>-->

<!-- Sweet Alerts js -->
<script src="/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- App js -->
<script src="/js/app.js"></script>
<script src="/js/script.js"></script>
<?=$this->endBody()?>
</body>
</html>
<?php $this->endPage() ?>
