<?php
use yii\helpers\Url;
?>
<form action="<?= Url::to(['task/kanban']) ?>" method="get">
    <div class="row g-2">
        <!--end col-->
        <div class="col-lg-3 col-auto">
            <div class="search-box">
                <input name="title" type="text" class="form-control search" id="search-task-options"
                       placeholder="Поиск задачи по названию">
                <i class="ri-search-line search-icon"></i>
            </div>
        </div>
        <!--end col-->
        <div class="col-lg-2">
            <a href="<?= Url::to(['kanban']) ?>" class="btn btn-outline-primary">Сбросить</a>
        </div>
    </div>
    <!--end row-->
</form>

