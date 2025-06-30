<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\OrderSubjects $model */

$this->title = 'Create Order Subjects';
$this->params['breadcrumbs'][] = ['label' => 'Order Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-subjects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
