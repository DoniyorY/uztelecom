<?php

use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<form action="<?= Url::to(['change-user-department']) ?>" method="post">
    <?= Html::input('text', Yii::$app->request->csrfParam, Yii::$app->request->csrfToken, ['hidden' => true]) ?>
    <?= Html::input('text', 'ChangePosition[user_id]', $user_id, ['hidden' => true]) ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= Html::label('Филиал', 'company_id') ?>
                <?= Html::dropDownList('ChangePosition[company_id]', '',
                    \yii\helpers\ArrayHelper::map(\common\models\Company::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
                    [
                        'class' => 'form-control',
                        'id' => 'company_id',
                        'required' => true,
                        'prompt' => 'Выберите филиал',
                    ])
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?= Html::label('Отдел', 'department_id') ?>
                <?= DepDrop::widget([
                    'name' => 'ChangePosition[department_id]',
                    'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,
                    'pluginOptions' => [
                        'depends' => ['company_id'],
                        'url' => Url::to(['department-list']),

                    ],
                    'options' => [
                        'id' => 'department_id',
                        'class' => 'form-control',
                        'placeholder' => 'Выберите отдел',
                        'required' => true,
                    ],
                ]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <?= Html::label('Должность', 'position_id') ?>
            <?= DepDrop::widget([
                'name' => 'ChangePosition[position_id]',
                'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,
                'pluginOptions' => [
                    'depends' => ['company_id', 'department_id'],
                    'url' => Url::to(['position-list']),

                ],
                'options' => [
                    'id' => 'position_id',
                    'class' => 'form-control',
                    'placeholder' => 'Выберите должность',
                    'required' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= Html::label('Ставка', 'bid_id') ?>
                <?= Html::dropDownList('ChangePosition[bid_id]', '',
                    [0 => '0.5', 1 => '1', 2 => '1.5'],
                    [
                        'class' => 'form-control',
                        'id' => 'bid_id', 'prompt' => 'Выберите ставку',
                        'required' => true,
                    ]
                ) ?>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100',]) ?>
        </div>
    </div>
</form>
