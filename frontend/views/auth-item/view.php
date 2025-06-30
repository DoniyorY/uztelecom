<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\AuthItemChild;

/** @var yii\web\View $this */
/** @var common\models\AuthItem $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="auth-item-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('admin')): ?>
        <p>
            <?= Html::a('Delete', ['delete', 'name' => $model->name], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'type',
                    'description:ntext',
                    'rule_name',
                    'data',
                    [
                        'attribute' => 'created_at',
                        'value' => function ($data) {
                            return date('d.m.Y', $data->created_at);
                        }
                    ],
                    [
                        'attribute' => 'updated_at',
                        'value' => function ($data) {
                            return date('d.m.Y', $data->updated_at);
                        }
                    ],
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <h3>Permissions</h3>
            <form action="<?= \yii\helpers\Url::to(['auth-item/change-child']) ?>" method="post">
                <input type="text" hidden="hidden" value="<?= Yii::$app->request->csrfToken ?>"
                       name="<?= Yii::$app->request->csrfParam ?>">
                <input type="text" hidden="hidden" name="parent_name" value="<?= $model->name ?>">
                <table class="table table-sm table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Checked</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $i = 1;
                    foreach ($children as $item):
                        $child = AuthItemChild::findOne(['parent'=>$model->name,'child'=>$item->name]); ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $item->name ?></td>
                            <td>
                                <div class="form-check form-switch switch-large d-flex justify-content-center align-items-center">
                                    <input name="<?= $item->name ?>"
                                           class="form-check-input" <?= ($child) ? 'checked' : '' ?>
                                           type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-success w-100 btn-sm"> Save</button>
            </form>
        </div>
    </div>


</div>
