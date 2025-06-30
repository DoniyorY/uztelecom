<?php

/** @var yii\web\View $this */
/** @var string $content */
$base = Yii::$app->request->baseUrl;
use common\widgets\Alert;
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover"
      data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8"/>
    <title><?= ($this->title) ? $this->title : '' ?> | SIMMA SYSTEM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    <link href="<?= $base . '/css' ?>/custom.min.css" rel="stylesheet" type="text<?= $base . '/css' ?>"/>
</head>
<body>

<?= Alert::widget() ?>
<?= $content ?>

<?= $this->render('js_scripts') ?>

    <!-- particles js -->
    <script src="/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="/js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="/js/pages/password-addon.init.js"></script>
</body>
<?php $this->endPage() ?>
