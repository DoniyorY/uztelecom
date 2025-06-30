<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\widgets\Alert;


?>
<?php $this->beginPage() ?>
<?= Alert::widget() ?>
<?= $content ?>
<?php $this->endPage() ?>
