<?php

use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Department $model */
/** @var yii\widgets\ActiveForm $form */
$parent = '';
if (Yii::$app->controller->action->id == 'index') {
    $parent = '#showModal';
}
$url_id = Yii::$app->controller->action->id;
if ($url_id == 'index') {
    $url = Url::to(['create']);
} else {
    $url = Url::to(['update', 'id' => $model->id]);
}
$user = User::find()
    ->alias('u')
    ->select(['u.id', 'u.fullname'])
    ->innerJoin('auth_assignment AS aa', 'aa.user_id = u.id')
    ->where(['u.status' => 10, 'aa.item_name' => 'department_head'])
    ->orWhere(['aa.item_name'=>'admin'])
    ->all();
?>

<?php $form = ActiveForm::begin(['action' => $url]); ?>
<div class="tablelist-form" autocomplete="off">
    <div class="modal-body">
        <input type="hidden" id="tasksId"/>
        <div class="row g-3">
            <?= $form->field($model, 'company_id')->widget(\kartik\select2\Select2::class, [
                'data' => ArrayHelper::map(\common\models\Company::find()->all(), 'id', 'name'),
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => $parent,
                ],
                'options' => ['placeholder' => 'Выберите Филиал']
            ])->label('Филиал') ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'head_id')->widget(\kartik\select2\Select2::class, [
                'data' => ArrayHelper::map($user, 'id', 'fullname'),
                'pluginOptions' => [
                    'allowClear' => true,
                    /*'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => Url::to(['department/select-search']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) {return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(user) {console.log(user); return user.fullname; }'),
                    'templateSelection' => new JsExpression('function (user) { return user.fullname; }'),*/
                    'dropdownParent' => $parent
                ],
                'options' => [
                    'placeholder' => 'Выберите сотрудника',
                    'value' => $model->head_id
                ]
            ]) ?>

        </div>
        <!--end row-->
    </div>
    <div class="modal-footer">
        <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">Закрыть</button>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id' => 'add-btn']) ?>
            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
