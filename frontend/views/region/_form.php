<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['create'])]) ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'name') ?>
    </div>
    <div class="col-md-12 mt-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
