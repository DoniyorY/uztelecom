<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin(['action' => Url::to(['add-certificate'])]) ?>
<?= $form->field($model, 'employee_id')->textInput(['value' => $employee_id, 'hidden' => 'hidden'])->label(false) ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'certificate_number')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'issue_date')->textInput(['type' => 'date']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'expiry_date')->textInput(['type' => 'date']) ?>
        </div>
        <div class="col-md-6 mt-4">
            <?=$form->field($model,'imageFile')->fileInput()?>
        </div>
        <div class="col-md-6 mt-4">
            <button type="submit" class="btn btn-success w-100">Save</button>
        </div>
    </div>
<?php ActiveForm::end() ?>