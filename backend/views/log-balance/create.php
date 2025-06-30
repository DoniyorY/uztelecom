<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LogBalance $model */

$this->title = 'Create Log Balance';
$this->params['breadcrumbs'][] = ['label' => 'Log Balances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-balance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
