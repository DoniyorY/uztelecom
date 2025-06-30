<?php

use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Task $model */
/** @var yii\widgets\ActiveForm $form */
$base = Yii::$app->request->baseUrl;
$users = \common\models\User::find()
    ->where(['status' => 10, 'department_id' => Yii::$app->user->identity->department_id])
    ->andWhere(['!=', 'id', Yii::$app->user->id])
    ->all()
?>
<!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>-->


<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-12 col-md-9">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    </div>
    <div class="col-12 col-md-3">
        <?= $form->field($model, 'company_id')->dropDownList(Yii::$app->params['company_id']) ?>
        <?= $form->field($model, 'level_id')->dropDownList(Yii::$app->params['task_level_id'], ['prompt' => '']) ?>
        <?= $form->field($model, 'dead_line')->textInput(['type' => 'datetime-local']) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
            'data' =>  ArrayHelper::map(User::find()->where(['status' => 10])->all(), 'id', 'info'),
            'options' => ['placeholder' => 'Выберите исполнителя'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'task_members[]')->widget(Select2::class, [
            //'data' => ArrayHelper::map(User::find()->select(['id', 'fullname'])->where(['status' => 10, 'department_id' => Yii::$app->user->identity->department_id])->asArray()->all(), 'id', 'username'),
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'ajax' => [
                    'url' => Url::to(['department/select-search']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) {return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(user) { return user.username; }'),
                'templateSelection' => new JsExpression('function (user) { return user.username; }'),
            ],
            'options' => [
                'placeholder' => 'Выберите сотрудника',
                'multiple' => true
            ]
        ]) ?>
    </div>
</div>
<div class="form-group mt-4">
    <?= Html::submitButton('Назначить задачу', ['class' => 'btn btn-success w-100']) ?>
</div>
<?php ActiveForm::end(); ?>
