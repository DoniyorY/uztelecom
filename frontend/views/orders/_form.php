<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Employees;

/** @var yii\web\View $this */
/** @var common\models\Orders $model */
/** @var yii\widgets\ActiveForm $form */
$all = Employees::find()->asArray()->where(['user_id' => Yii::$app->user->id])->all();
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->widget(\kartik\select2\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map($all, 'id', 'fullname'),
        'pluginOptions' => [
            'allowClear' => true,
            //'disabled' => true,
        ],
        'options' => [
            'value' => $all ? $all[0]['fullname'] : null,
        ]
    ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
