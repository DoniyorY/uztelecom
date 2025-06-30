<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Orders $model */

$this->title = 'Новая заявка';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create card">
    <div class="card-body">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

</div>
