<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LogBalance $model */

$this->title = 'Update Log Balance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Balances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-balance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
