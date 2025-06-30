<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\DirectoryList $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="directory-list-form">

    <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['create-directory'])]); ?>

    <?= $form->field($model, 'category_id')->textInput(['value' => $category_id, 'hidden' => true])->label(false) ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_uzkyrl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_uzlat')->textInput(['maxlength' => true]) ?>

    <div class="form-group mt-2">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success w-100']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
