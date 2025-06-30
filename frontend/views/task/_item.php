<?php

use yii\helpers\Url;

$base = Yii::$app->request->baseUrl;
?>
<tr>
    <td class="id">
        <a href="<?php echo Url::to(['task/view', 'id' => $model->token]); ?>"
           class="fw-medium link-primary">#<?php echo $model->id; ?></a>
    </td>
    <td class="project_name">
        <a href="<?php echo Url::to(['task/view', 'id' => $model->token]); ?>" class="fw-medium link-primary">
            <?php echo $model->title; ?>
        </a>
    </td>
    <td class="project_created">
        <?= date('d.m.Y H:i', $model->created_at) ?>
    </td>
    <td class="client_name"><?php echo $model->byUser->fullname; ?></td>
    <td class="assignedto">
        <div class="avatar-group">

            <!--Основной исполнитель-->
            
            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
               data-bs-trigger="hover" data-bs-placement="top" title="<?= $model->user->fullname ?>">
                <?php if (isset($model->image) and file_exists(Yii::getAlias('@frontend/web/uploads/users/' . $model->user->image))): ?>
                    <img src="<?= "$base/uploads/users/{$model->user->image}" ?>" alt=""
                         class="rounded-circle avatar-xxs"/>
                <?php else: ?>
                    <img src="<?= $base ?>/images/users/user-dummy-img.jpg" alt=""
                         class="rounded-circle avatar-xxs"/>
                <?php endif; ?>
            </a>
            <?php $members = \common\models\TaskMembers::find()->select(['user_id'])->where(['task_id' => $model->id])->all();
            foreach ($members as $item): ?>

                <!--Назначенные исполнители-->
                <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip"
                   data-bs-trigger="hover" data-bs-placement="top" title="<?= $item->user->username ?>">
                    <?php if (isset($item['image']) and file_exists(Yii::getAlias('@frontend/web/uploads/users/' . $item->user->image))): ?>
                        <img src="<?= "$base/uploads/users/{$item->user->image}" ?>" alt=""
                             class="rounded-circle avatar-xxs"/>
                    <?php else: ?>
                        <img src="<?= $base ?>/images/users/user-dummy-img.jpg" alt=""
                             class="rounded-circle avatar-xxs"/>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </td>
    <td class="due_date"><?php echo date('d.m.Y H:i', $model->dead_line); ?></td>
    <td>
        <?php
        $secondsInDay = 86400;
        $left_day = floor(($model->dead_line - time()) / $secondsInDay);
        $finishedDay = floor(($model->finish_time - time()) / $secondsInDay);

        // Если задача завершена и дедлайн просрочен
        if ($left_day <= 0 && $model->status_id == 2) {
            $left_day -= $finishedDay;
        }

        // Склонение слова "день"
        if (!function_exists('pluralizeDays')) {
            function pluralizeDays($n)
            {
                $n = abs($n);
                if ($n % 10 == 1 && $n % 100 != 11) {
                    return 'день';
                } elseif ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20)) {
                    return 'дня';
                } else {
                    return 'дней';
                }
            }
        }

        $daySuffix = pluralizeDays($left_day);

        // Класс кнопки
        if ($left_day > 3) {
            $class = 'btn btn-success btn-load';
        } elseif ($left_day > 0) {
            $class = 'btn btn-warning btn-load';
        } else {
            $class = 'btn btn-danger btn-load';
        }
        ?>
        <button type="button" class="<?= $class ?>">
            <span class="d-flex align-items-center">
                <span class="spinner-grow flex-shrink-0" role="status">
                    <span class="visually-hidden"> <?php echo "$left_day $daySuffix"; ?></span>
                </span>
                <span class="flex-grow-1 ms-2">
                    <?php echo "$left_day $daySuffix"; ?>
                </span>
            </span>
        </button>
    </td>
    <td class="status">
        <span class="<?= Yii::$app->params['task_status_class'][$model->status_id] ?>">
            <?php echo Yii::$app->params['task_status'][$model->status_id]; ?>
        </span>
    </td>
    <td class="priority">
        <?php echo Yii::$app->params['task_level_id_style'][$model->level_id]; ?>
    </td>
</tr>