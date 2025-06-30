<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$lang = yii::$app->language;

$this->title = 'Смена пароля пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$form = ActiveForm::begin([
    'id' => 'user-form-config',
    'action' => \yii\helpers\Url::to(['change-password']),
    'method'=>'post'
]);
?>
<div class="row">
    <div class="mb-2 col-md-6">
        <?= $form->field($user_password, 'currentPassword')->passwordInput() ?>
    </div>
    <div class="mb-2 col-md-6"></div>
    <div class="mb-2 col-md-6">
        <?= $form->field($user_password, 'newPassword')->passwordInput() ?>
    </div>
    <div class="mb-2 col-md-6">
        <?= $form->field($user_password, 'newPasswordConfirm')->passwordInput() ?>
    </div>
    <div class="col-md-12 mb-3 mt-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100']) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
