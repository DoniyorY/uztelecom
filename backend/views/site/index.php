<?php

/** @var yii\web\View $this */
use kartik\depdrop\DepDrop;

$this->title = 'My Yii Application';
$model = new \common\models\User();

?>
<?php

/** @var yii\web\View $this */

use yii\helpers\ArrayHelper;

$this->title = 'My Yii Application';
$model = new \common\models\User;
?>

<?php $form=\yii\widgets\ActiveForm::begin()?>
<?= $form->field($model, 'department_id')->dropDownList(
    ArrayHelper::map(\common\models\Department::find()->asArray()->all(), 'id', 'name'),
    [
        'prompt' => 'Выберите отдел',
        'required' => true,
        'id' => 'departmentId',

    ]) ?>
<?= $form->field($model, 'position_id')->widget(DepDrop::class, [
    'options' => ['id' => 'positionId'],
    'pluginOptions' => [
        'depends' => ['departmentId'],
        'placeholder' => 'Выберите должность',
        'url' => \yii\helpers\Url::to(['user/position-list']),
        'required' => true,
    ]
]) ?>
<?php \yii\widgets\ActiveForm::end()?>



