<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['action' => Url::to(['add-child'])]); ?>
<?= $form->field($model, 'employee_id')->textInput(['hidden' => true, 'value' => $employee_id])->label(false) ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'fullname')->textInput() ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'birthday')->textInput(['type' => 'date']) ?>
    </div>
    <div class="col-md-12 mt-4">
        <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>
