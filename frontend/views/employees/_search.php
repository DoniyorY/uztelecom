<?php

use common\models\Department;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\EmployeesSearch $model */
/** @var yii\widgets\ActiveForm $form */
$map = \yii\helpers\ArrayHelper::map(Department::find()->all(), 'id', 'info');
?>

<div class="employees-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'department_id')
                ->widget(\kartik\select2\Select2::class, [
                    'data' => $map,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'options' => ['placeholder' => 'Выберите отдел'],
                ])
                ->label('Отдел') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'fullname') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mobile_phone') ?>
        </div>
        <div class="col-md-3 mt-4">
            <div class="form-group">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>


    <?php // echo $form->field($model, 'nationality') ?>

    <?php // echo $form->field($model, 'family_status') ?>

    <?php // echo $form->field($model, 'passport_series') ?>

    <?php // echo $form->field($model, 'passport_pinfl') ?>

    <?php // echo $form->field($model, 'passport_inn') ?>

    <?php // echo $form->field($model, 'passport_end_date') ?>

    <?php // echo $form->field($model, 'passport_whois') ?>

    <?php // echo $form->field($model, 'citizenship') ?>

    <?php // echo $form->field($model, 'birthday_city') ?>

    <?php // echo $form->field($model, 'postcode') ?>

    <?php // echo $form->field($model, 'mobile_phone') ?>

    <?php // echo $form->field($model, 'work_phone') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'address_registration') ?>

    <?php // echo $form->field($model, 'temporary_registration_address') ?>

    <?php // echo $form->field($model, 'tra_start_date') ?>

    <?php // echo $form->field($model, 'tra_end_date') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'status') ?>



    <?php ActiveForm::end(); ?>

</div>
