<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Редактировать пользователя: ' . $model->username;
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= ($this->title) ? $this->title : '' ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?= Yii::$app->homeUrl ?>">Главная</a></li>
                    <li class="breadcrumb-item"><a href="<?= \yii\helpers\Url::to(['index']) ?>">Пользователи</a></li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="card" id="tasksList">
    <div class="card-header border-0">
        <div class="d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> Редактировать данные </h5>
        </div>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin() ?>
        <div class="row">
            <div class="mb-2 col-md-12">
                <?= $form->field($model, 'fullname')->textInput(['id' => 'teammembersName', 'placeholder' => 'Введите Ф.И.О', 'required' => true]) ?>
            </div>
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'phone_number')->textInput() ?>
            </div>
            <div class="col-md-6 mb-2">
                <?= $form->field($model, 'gender')->dropDownList(
                    ArrayHelper::map(\common\models\DirectoryList::find()->where(['category_id' => 4])->asArray()->all(), 'name_ru', 'name_ru'),
                    [
                        'prompt' => 'Выберите пол',
                    ]
                ) ?>
            </div>
            <div class="col-md-6 mb-3">
                <?= $form->field($model, 'user_assignment')->dropDownList(
                    ArrayHelper::map(\common\models\AuthItem::find()->where(['type' => 1])->asArray()->all(), 'name', 'name'),
                    [
                        'prompt' => 'Выберите роль',
                        'value' => $auth->item_name
                    ]
                ) ?>
            </div>
            <div class="col-md-4 mt-4 mb-3">
                <?=$form->field($model,'imageFile')->fileInput()?>
            </div>
            <div class="col-md-12 mb-3 mt-2">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
