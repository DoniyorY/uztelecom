<?php

use common\models\DirectoryCategory;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\DirectoryCategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Категория справочников';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="directory-category-index card">
    <div class="card-body">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Добавить категорию', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pager' => [
                'prevPageLabel' => '<span class="page-item">Prev</span>',
                'nextPageLabel' => '<span class="page-item">Next</span>',
                'disabledPageCssClass' => 'page-link',
                'activePageCssClass' => 'page-item active',
                'maxButtonCount' => 5,
                'linkOptions' => ['class' => 'page-link'],
                'options' => [
                    'tag' => 'ul',
                    'class' => 'pagination',
                    'style' => 'margin-left: 1px;'
                ],
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'name_ru',
                'name_uzkyrl',
                'name_uzlat',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, DirectoryCategory $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template'=>'{view}'
                ],
            ],
        ]); ?>
    </div>
</div>
