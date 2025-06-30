<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\widgets\DetailView;
use common\widgets\Alert;

/** @var yii\web\View $this */
/** @var common\models\User $model */
$base = yii::$app->request->baseUrl;
$this->title = ($model->fullname) ? $model->fullname : $model->username;
\yii\web\YiiAsset::register($this);
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


<div class="position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg profile-setting-img">
        <img src="<?php echo $base; ?>/images/profile-bg.jpg" class="profile-wid-img" alt="">
        <div class="overlay-content">
            <div class="text-end p-3">
                <?php
                if ($model->checkCard() == false) {
                    echo Html::a('Добавить карточку', ['employees/create', 'token' => $model->token], ['class' => 'btn btn-success']);
                } else {
                    echo Html::a('Посмотреть карточку', ['employees/view', 'id' => $employee_id],['class'=>'btn btn-primary']);
                }

                if (Yii::$app->user->can('admin') and $model->id != 1) {
                    echo Html::a('Сбросить пароль',
                        ['reset-password', 'token' => $model->token],
                        [
                            'class' => 'btn btn-warning',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Подтвердите действие!!!'
                            ]
                        ]);
                }
                ?>
                <?php if (Yii::$app->user->can('admin')) {
                    echo Html::a('Удалить', ['delete', 'token' => $model->token], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]);
                } ?>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->


<div class="row">
    <div class="col-xxl-3">
        <div class="card mt-n5">
            <div class="card-body p-4">
                <div class="text-center">
                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                        <?php if (file_exists(Yii::getAlias('@frontend/web/uploads/users/' . $model->image)) and $model->image): ?>
                            <img src="<?= "$base/uploads/users/$model->image" ?>"
                                 class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                 alt="user-profile-image">
                        <?php else: ?>
                            <img src="<?php echo "$base/images/users/avatar-1.jpg"; ?>"
                                 class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                 alt="user-profile-image">
                        <?php endif; ?>
                    </div>
                    <h5 class="fs-17 mb-1"><?php echo $model->fullname; ?></h5>
                    <p class="text-muted mb-0">
                        <?php
                        if ($model->department) {
                            echo $model->department->name;
                        } else {
                            echo 'Не задано!!';
                        }
                        ?> /
                        <?php
                        if ($model->position) {
                            echo $model->position->name;
                        } else {
                            echo 'Не задано!!';
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th><?php echo $model->getAttributeLabel('username'); ?></th>
                        <td><?php echo $model->username; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $model->getAttributeLabel('by_user_id'); ?></th>
                        <td>
                            <?php
                            if ($model->byUser) {
                                echo $model->byUser->username;
                            } else {
                                echo 'Не задано!';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo $model->getAttributeLabel('phone_number'); ?></th>
                        <td><?php echo $model->phone_number; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $model->getAttributeLabel('rating'); ?></th>
                        <td><?php echo $model->rating; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $model->getAttributeLabel('created_at'); ?></th>
                        <td><?php echo date('d.m.Y', $model->created_at); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $model->getAttributeLabel('updated_at'); ?></th>
                        <td><?php echo date('d.m.Y', $model->updated_at); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-xxl-9">

        <div class="card mt-xxl-n5">
            <div class="card-header">
                <?php echo Alert::widget() ?>
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                            Информация
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#personalSettings" role="tab">
                            Настройки
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                            Сменить пароль
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">About</h5>
                                <p>Hi I'm Anna Adame, It will be as simple as Occidental; in fact, it will be
                                    Occidental. To an English person, it will seem like simplified English, as a
                                    skeptical Cambridge friend of mine told me what Occidental is European languages are
                                    members of the same family.</p>
                                <p>You always want to make sure that your fonts work well together and try to limit the
                                    number of fonts you use to three or less. Experiment and play around with the fonts
                                    that you already have in the software you’re working with reputable font websites.
                                    This may be the most commonly encountered tip I received from the designers I spoke
                                    with. They highly encourage that you use different fonts in one design, but do not
                                    over-exaggerate and go overboard.</p>
                                <div class="row">


                                    <div class="col-4 col-md-4">
                                        <div class="d-flex mt-2">
                                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary shadow">
                                                    <i class="ri-user-2-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Организация :</p>
                                                <h6 class="text-truncate mb-0"><?php echo $model->department->company->name ?></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 col-md-4">
                                        <div class="d-flex mt-2">
                                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary shadow">
                                                    <i class="ri-user-2-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><?php echo $model->getAttributeLabel('department_id'); ?>
                                                    :</p>
                                                <h6 class="text-truncate mb-0"><?= $model->department->name ?> </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 col-md-4">
                                        <div class="d-flex mt-2">
                                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary shadow">
                                                    <i class="ri-user-2-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><?php echo $model->getAttributeLabel('position_id'); ?>
                                                    :</p>
                                                <h6 class="text-truncate mb-0"><?= $model->position->name ?></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 col-md-4">
                                        <div class="d-flex mt-2">
                                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary shadow">
                                                    <i class="ri-user-2-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><?php echo $model->getAttributeLabel('terminal_employee_no'); ?>
                                                    :</p>
                                                <h6 class="text-truncate mb-0"><?= $model->terminal_employee_no; ?></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 col-md-4">
                                        <div class="d-flex mt-2">
                                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary shadow">
                                                    <i class="ri-user-2-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><?php echo $model->getAttributeLabel('terminal_card'); ?>
                                                    :</p>
                                                <h6 class="text-truncate mb-0"><?= $model->terminal_card; ?></h6>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div>

                        <?php foreach ($work_history as $work_item): ?>

                        <?php endforeach; ?>
                    </div>
                    <div class="tab-pane" id="personalSettings" role="tabpanel">
                        <?php $form = ActiveForm::begin() ?>
                        <div class="row">
                            <div class="mb-2 col-md-8">
                                <?= $form->field($model, 'fullname')->textInput(['id' => 'teammembersName', 'placeholder' => 'Введите Ф.И.О', 'required' => true]) ?>
                            </div>
                            <div class="col-md-4 mt-4 mb-3">
                                <?= $form->field($model, 'imageFile')->fileInput() ?>
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
                            <div class="col-md-4 mb-2">
                                <?= $form->field($model, 'terminal_employee_no')->textInput() ?>
                            </div>
                            <div class="col-md-4 mb-2">
                                <?= $form->field($model, 'terminal_card')->textInput() ?>
                            </div>

                            <div class="col-md-4 mb-3">
                                <?= $form->field($model, 'user_assignment')->dropDownList(
                                    ArrayHelper::map(\common\models\AuthItem::find()->where(['type' => 1])->asArray()->all(), 'name', 'name'),
                                    [
                                        'prompt' => 'Выберите роль',
                                        'value' => $auth->item_name
                                    ]
                                ) ?>
                            </div>

                            <div class="col-md-12 mb-3 mt-2">
                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="changePassword" role="tabpanel">
                        <?= $this->render('_change_password_form', [
                            'user_password' => $user_password,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
