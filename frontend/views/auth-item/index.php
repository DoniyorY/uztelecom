<?php

use common\models\AuthItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\AuthItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Роли пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Добавить роль
                </button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Auth Item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?=$this->render('_form',['model'=>new AuthItem()])?>
                    </div>
                </div>
            </div>
        </div>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                //'type',
                'description:ntext',
                'rule_name',
                'data',
                //'created_at',
                //'updated_at',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, AuthItem $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'name' => $model->name]);
                    },
                    'template'=>'{view}'
                ],
            ],
        ]); ?>
    </div>
</div>
