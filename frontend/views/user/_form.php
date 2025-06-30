<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
$base = Yii::$app->request->baseUrl;
?>

<div class="modal-body">
    <?php $form = ActiveForm::begin(['id' => 'memberlist-form', 'class' => 'needs-validaton','action'=>\yii\helpers\Url::to(['create'])]) ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="px-1 pt-1">
                <div class="modal-team-cover position-relative mb-0 mt-n4 mx-n4 rounded-top overflow-hidden">
                    <img src="<?= $base ?>/images/small/img-9.jpg" alt="" id="cover-img"
                         class="img-fluid">

                    <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                        <div class="flex-grow-1">
                            <h5 class="modal-title text-white"
                                id="createMemberLabel">Новый пользователей</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-3 align-items-center">
                                <button type="button"
                                        class="btn-close btn-close-white"
                                        id="createMemberBtn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-4 mt-n5 pt-2">
                <div class="position-relative d-inline-block">
                    <div class="avatar-lg">
                        <div class="avatar-title bg-light rounded-circle">
                            <img src="<?= $base ?>/images/users/user-dummy-img.jpg"
                                 id="member-img"
                                 class="avatar-md rounded-circle h-auto"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="mb-2 col-md-12">
                    <?= $form->field($model, 'fullname')->textInput(['id' => 'teammembersName', 'placeholder' => 'Введите Ф.И.О', 'required' => true]) ?>
                </div>
                <div class="mb-2 col-md-6">
                    <?= $form->field($model, 'username')->textInput(['placeholder' => 'Введите логин']) ?>
                </div>
                <div class="mb-2 col-md-6">
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите пароль']) ?>
                </div>
                <div class="mb-2 col-md-4">
                    <?= $form->field($model, 'department_id')->dropDownList(
                        ArrayHelper::map(\common\models\Department::find()->asArray()->all(), 'id', 'name'),
                        [
                            'prompt' => 'Выберите отдел',
                            'required' => true,
                            'id' => 'departmentId',
                        ]) ?>
                </div>
                <div class="mb-2 col-md-6">
                    <?= $form->field($model, 'position_id')->widget(DepDrop::class, [
                        'options' => ['id' => 'positionId'],
                        'pluginOptions' => [
                            'depends' => ['departmentId'],
                            'placeholder' => 'Выберите должность',
                            'url' => \yii\helpers\Url::to(['user/position-list']),
                            'required' => true,
                        ],
                    ]) ?>
                </div>
                <div class="mb-2 col-md-2">
                    <?= $form->field($model, 'user_bid')->dropDownList([0=>'0.5',1=>'1',2=>'1.5'],['prompt'=>'']) ?>
                </div>
                <div class="col-md-4 mb-2">
                    <?= $form->field($model, 'phone_number')->textInput() ?>
                </div>
                <div class="col-md-4 mb-2">
                    <?= $form->field($model, 'gender')->dropDownList(
                        ArrayHelper::map(\common\models\DirectoryList::find()->where(['category_id' => 4])->asArray()->all(), 'name_ru', 'name_ru'),
                        [
                            'prompt' => 'Выберите пол',
                        ]
                    ) ?>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <?= $form->field($model, 'terminal_employee_no')->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'terminal_card')->textInput() ?>
                </div>

                <div class="col-md-4 mb-2">
                    <?= $form->field($model, 'user_assignment')->dropDownList(
                        ArrayHelper::map(\common\models\AuthItem::find()->where(['type' => 1])->asArray()->all(), 'name', 'name'),
                        [
                            'prompt' => 'Выберите роль'
                        ]
                    ) ?>
                </div>
            </div>
            <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light"
                        data-bs-dismiss="modal">Закрыть
                </button>
                <button type="submit" class="btn btn-success"
                        id="addNewMember">Добавить
                </button>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
