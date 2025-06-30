<?php

use common\models\Notifications;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\NotificationsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-index card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-10">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-2">
                <a href="<?= Url::to(['check-all']) ?>" class="btn btn-primary w-100"
                   data-confirm="Подтвердите действие!!!">
                    <i class="ri-checkbox-line"></i> Отметить как прочитанные
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions'=>function($model){
                if ($model->seen == 0) return ['class'=>'table-danger'];
                if ($model->seen == 1) return ['class'=>'table-success'];
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                //'user_id',
                [
                    'attribute' => 'created_at',
                    'value' => function ($data) {
                        return date('d.m.Y H:i:s', $data->created_at);
                    }
                ],
                'title',
                [
                    'attribute' => 'model_type',
                    'value' => function ($data) {
                        return Yii::$app->params['notification_model_type'][$data->model_type];
                    }
                ],
                //'model_id',
                //'seen',
                /*[
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Notifications $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],*/
            ],
        ]); ?>
    </div>
</div>
