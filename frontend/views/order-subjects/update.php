<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\OrderSubjects $model */

$this->title = 'Update Order Subjects: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Order Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-subjects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
