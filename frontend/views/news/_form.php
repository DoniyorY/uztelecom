<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\News $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="tablelist-form" autocomplete="off">
    <div class="modal-body">
        <input type="hidden" id="tasksId" />
        <div class="row g-3">

            <div class="col-12 col-sm-12">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-12 col-sm-12">
                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-12 col-sm-12">
                <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
            </div>

            <div class="col-12 col-sm-12">
                <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <!--end row-->
    </div>
    <div class="modal-footer"><br/>
        <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">Закрыть</button>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','id'=>'add-btn']) ?>
            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

