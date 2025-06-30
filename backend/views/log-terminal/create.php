<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LogTerminal $model */

$this->title = 'Create Log Terminal';
$this->params['breadcrumbs'][] = ['label' => 'Log Terminals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-terminal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
