<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\search\TaskSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-6 col-sm-4">
            <?php echo $form->field($model, 'status_id')->dropDownList(Yii::$app->params['task_status'], ['prompt' => 'Выберите статус']) ?>
        </div>
        <div class="col-6 col-sm-4">
            <?php echo $form->field($model, 'position_id')->dropDownList(Yii::$app->params['task_level_id'],['prompt'=>'Выберите приоритет']) ?>
        </div>
        <div class="col-12 col-sm-4 mt-4">
            <div class="form-group">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary w-50']) ?>
                <?= Html::a('Сбросить',['index'], ['class' => 'btn btn-outline-secondary ']) ?>
            </div>
        </div>
    </div>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'level_id') ?>

    <?php // echo $form->field($model, 'dead_line') ?>

    <?php // echo $form->field($model, 'finish_time') ?>



    <?php ActiveForm::end(); ?>

</div>
