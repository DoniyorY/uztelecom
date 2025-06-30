<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DirectoryCategory $model */

$this->title = 'Create Directory Category';
$this->params['breadcrumbs'][] = ['label' => 'Directory Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="directory-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
