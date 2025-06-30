<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin(['action' => $url]) ?>
<?= $form->field($model, 'user_id')->textInput(['value' => Yii::$app->user->id, 'hidden' => true])->label(false) ?>
<?= $form->field($model, 'task_id')->textInput(['value' => $task_id, 'hidden' => true])->label(false) ?>
<div class="row g-3">
    <div class="col-lg-12">
        <?= $form->field($model, 'content')->textarea([
            'rows' => 3,
            'class' => 'form-control bg-light border-light',
            'placeholder' => 'Напишите комментарий',
            'required' => true,
        ]) ?>
    </div>
    <!--end col-->
    <div class="col-12 text-end">
        <button type="submit" class="btn btn-success">Опубликовать</button>
    </div>
</div>
<!--end row-->
<?php ActiveForm::end() ?>
