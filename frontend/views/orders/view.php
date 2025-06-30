<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Orders $model */

$this->title = $model->title . ' / ' . $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$params = Yii::$app->params;
?>
<div class="orders-view card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <h1><?= Html::encode($this->title) ?></h1>
                <?php $i = 0;
                foreach ($order_items as $item): ?>
                    <?php if ($item->user_role == 1) {
                        if ($i == 1) continue;
                        echo '<h4>Статус HR: <span class="' . $params['order_status_class'][$item->status] . '">' . $params['order_status'][$item->status] . '</span></h4>';
                        $i++;
                    } else {
                        echo '<h4>Руководитель отдела: <span class="' . $params['order_status_class'][$item->status] . '">' . $params['order_status'][$item->status] . '</span></h4>';
                    }
                    ?>
                <?php endforeach; ?>
            </div>
            <div class="col-md-2">
                <?php if ($model->status == 0) {
                    if ($model->user_id == Yii::$app->user->id and $model->status == 0) {
                        echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                        echo Html::a('Удалить', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                    if ($order_user) {
                        if ($order_user->status == 0) {
                            echo Html::a('Подтвердить', ['status', 'order_id' => $model->id, 'user_id' => Yii::$app->user->id, 'status' => 1],
                                ['class' => 'btn btn-success']);
                            echo Html::a('Отклонить', ['status', 'order_id' => $model->id, 'user_id' => Yii::$app->user->id, 'status' => 2],
                                ['class' => 'btn btn-danger']);
                        }
                    }
                }
                ?>
            </div>
        </div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                [
                    'attribute' => 'employee_id',
                    'value' => function ($data) {
                        return $data->employee->fullname;
                    }
                ],
                'title',
                'content:ntext',
                [
                    'attribute' => 'created_at',
                    'value' => function ($data) {
                        return date('d.m.Y', $data->created_at);
                    }
                ],
                /*[
                    'attribute' => 'updated_at',
                    'value' => function ($data) {
                        return date('d.m.Y', $data->updated_at);
                    }
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($data) {
                        return Yii::$app->params['order_status'][$data->status];
                    }
                ],*/
               /* [
                    'attribute' => 'department_id',
                    'value' => function ($data) {
                        return $data->department->name;
                    }
                ],
                [
                    'attribute' => 'position_id',
                    'value' => function ($data) {
                        return $data->position->name;
                    }
                ],*/
            ],
        ]) ?>
    </div>


</div>
