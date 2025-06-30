<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\AuthItem $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'w-100 btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
