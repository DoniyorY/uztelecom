<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\UserVisitingSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-visiting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'time_int') ?>

    <?= $form->field($model, 'time_date') ?>

    <?php // echo $form->field($model, 'terminal_employee_no') ?>

    <?php // echo $form->field($model, 'terminal_card') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
