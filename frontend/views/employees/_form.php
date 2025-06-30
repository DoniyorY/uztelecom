<?php
//passport-sample-data-personal-page-female-vector-28278160.jpg
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\DirectoryList;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var common\models\Employees $model */
/** @var yii\widgets\ActiveForm $form */
$baseUrl = Yii::$app->request->baseUrl;
?>
    <style>
        .help-block {
            color: red;
            font-size: 11px;
        }
    </style>
<?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-header border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Общая информация</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <img class="w-75" src="<?= "$baseUrl/images/users/passport-img.jpg" ?>" alt="">
                    <br/>
                    <br/>
                    <?= $form->field($model, 'imageFile')->fileInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'company_id')->widget(Select2::class, [
                                'data' => ArrayHelper::map(\common\models\Company::find()->all(), 'id', 'name'),
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                'options' => [
                                    'id' => 'company_id',
                                    'placeholder' => 'Выберите компанию...'
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'department_id')->widget(\kartik\depdrop\DepDrop::class, [
                                'type' => DepDrop::TYPE_SELECT2,
                                'options' => ['id' => 'department_id'],
                                'pluginOptions' => [
                                    'depends' => ['company_id'],
                                    'placeholder' => 'Выберите отдел...',
                                    'url' => Url::to(['department'])
                                ]
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'position_id')->widget(DepDrop::class, [
                                'type' => DepDrop::TYPE_SELECT2,
                                'pluginOptions' => [
                                    'depends' => ['company_id', 'department_id'],
                                    'placeholder' => 'Выберите должность...',
                                    'url' => Url::to(['position'])
                                ]
                            ]) ?>
                        </div>
                        <div class="col-md-12">  <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?> </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'sex')->dropDownList(\yii\helpers\ArrayHelper::map(DirectoryList::findAll(['category_id' => 4]), 'id', 'name_ru'), ['prompt' => 'Выберите пол']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'birthday')->textInput(['type' => 'date']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'nationality')->widget(Select2::classname(), [
                                'data' => \yii\helpers\ArrayHelper::map(\common\models\DirectoryList::findAll(['category_id' => 3]), 'id', 'name_ru'),
                                'options' => ['placeholder' => 'Выберите национальность ...', 'value' => 108],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'family_status')->widget(Select2::classname(), [
                                'data' => \yii\helpers\ArrayHelper::map(DirectoryList::findAll(['category_id' => 7]), 'id', 'name_ru'),
                                'options' => ['placeholder' => 'Выберите статус ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'citizenship')->widget(Select2::classname(), [
                                'data' => \yii\helpers\ArrayHelper::map(DirectoryList::findAll(['category_id' => 8]), 'id', 'name_ru'),
                                'options' => ['placeholder' => 'Выберите город ...', 'value' => 2785],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'birthday_city')->widget(Select2::classname(), [
                                'data' => \yii\helpers\ArrayHelper::map(DirectoryList::findAll(['category_id' => 8]), 'id', 'name_ru'),
                                'options' => ['placeholder' => 'Выберите город ...', 'value' => 2785],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'work_phone')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Паспортные данные</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'passport_series')->widget(
                        \yii\widgets\MaskedInput::class, ['mask' => 'AA 9999999']
                    ) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'passport_pinfl')->widget(
                        MaskedInput::class, ['mask' => '99999999999999']
                    ) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'passport_inn')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'passport_end_date')->textInput(['type' => 'date']) ?>
                </div>
                <div class="col-md-8">
                    <?= $form->field($model, 'passport_whois')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Информация об адресе</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"> <?= $form->field($model, 'postcode')->textInput(['value' => 140001]) ?></div>
                <div class="col-md-5"> <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-5"> <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-12"> <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?> </div>
                <div class="col-md-12"> <?= $form->field($model, 'address_registration')->textInput(['maxlength' => true]) ?> </div>
                <div class="col-md-12"> <?= $form->field($model, 'temporary_registration_address')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-4"><?= $form->field($model, 'tra_start_date')->textInput(['type' => 'date']) ?></div>
                <div class="col-md-4"><?= $form->field($model, 'tra_end_date')->textInput(['type' => 'date']) ?></div>
            </div>
        </div>
    </div>

    <div class="form-group mb-5">
        <?= Html::submitButton('Сохранить', ['class' => 'w-100 btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>