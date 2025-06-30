<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Department $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="tablelist-form" autocomplete="off">
    <div class="modal-body">
        <input type="hidden" id="tasksId" />
        <div class="row g-3">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


        </div>
        <!--end row-->
    </div>
    <div class="modal-footer">
        <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">Закрыть</button>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','id'=>'add-btn']) ?>
            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
