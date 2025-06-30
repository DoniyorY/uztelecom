<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Position $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="tablelist-form" autocomplete="off">
    <div class="modal-body">
        <input type="hidden" id="tasksId"/>
        <div class="row g-3">

            <div class="col-12 col-sm-12">
                <?= $form->field($model, 'company_id')->widget(\kartik\select2\Select2::class, [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Company::find()->all(), 'id', 'name'),
                    'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Выберите филиал'],
                ]) ?>
            </div>
            <div class="col-12 col-sm-12">
                <?php
                // Normal select with ActiveForm & model
                echo $form->field($model, 'department_id')
                    ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Department::find()->asArray()->orderby('name ASC')->all(),
                        'id', 'name'));
                ?>
            </div>
            <div class="col-12 col-sm-12">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-4 col-sm-4">
                <?= $form->field($model, 'salary')->textInput() ?>
            </div>
            <div class="col-4 col-sm-4">
                <?= $form->field($model, 'one_hour')->textInput() ?>
            </div>
            <div class="col-4 col-sm-4">
                <?= $form->field($model, 'bid')->textInput() ?>
            </div>
        </div>
        <!--end row-->
    </div>
    <div class="modal-footer">
        <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">Закрыть</button>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id' => 'add-btn']) ?>
            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

