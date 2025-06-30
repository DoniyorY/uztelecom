<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\UserSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-search mt-3">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'username') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'fullname') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status'],['prompt'=>'']); ?>
        </div>
        <div class="col-md-3 mt-4">
            <div class="form-group">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary w-50']) ?>
                <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
