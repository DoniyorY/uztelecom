<?php
$this->title = 'Список выполненных задач';

?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= ($this->title) ? $this->title : '' ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?= Yii::$app->homeUrl ?>">Главная</a></li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="card">
    <div class="card-header">
        <h3><?= $this->title ?></h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-bordered table-striped text-center">
            <thead>
            <tr>
                <th>№</th>
                <th>Название задачи</th>
                <th>Дата создания</th>
                <th>Заказчик</th>
                <th>Дедлайн</th>
                <th>Время завершения</th>
                <th>Приоритет</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($tasks as $task): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $task->title ?></td>
                    <td><?= date('d.m.Y H:i', $task->created_at) ?></td>
                    <td><?= $task->byUser->fullname ?></td>
                    <td><?= date('d.m.Y H:i', $task->dead_line) ?></td>
                    <td><?= date('d.m.Y H:i', $task->finish_time) ?></td>
                    <td><?= Yii::$app->params['task_level_id'][$task->level_id] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
