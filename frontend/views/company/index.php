<?php

use common\models\Company;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\CompanySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Филиалы';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= ($this->title) ? $this->title : '' ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a
                                href="<?=Yii::$app->homeUrl?>">Главная</a></li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="company-index card">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <?= Html::a('Добавить Филиал', ['create'], ['class' => 'btn btn-primary w-100']) ?>
            </div>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Company $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template'=>'{update}',
                ],
            ],
        ]); ?>
    </div>



</div>
