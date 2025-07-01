<?php

use common\models\Region;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Company $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'region_id')->widget(\kartik\select2\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(Region::find()->all(), 'id', 'name'),
        'language' => 'ru',
        'pluginOptions' => [
            'allowClear' => true
        ],
        'options' => ['placeholder' => 'Выберите регион', 'value' => ($model->region_id)?$model->region_id:''],
    ]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group mt-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
