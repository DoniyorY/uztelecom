<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LogTerminal $model */

$this->title = 'Update Log Terminal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Terminals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-terminal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
