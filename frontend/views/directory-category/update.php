<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DirectoryCategory $model */

$this->title = 'Update Directory Category: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Directory Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="directory-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
