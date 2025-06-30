<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

?>
<div class="card card-height-100">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Список моих задач</h4>
        <div class="flex-shrink-0">
            <a href="<?= Url::to(['task/index']) ?>" class="btn btn-soft-primary btn-sm">Посмотреть
                весь список <i
                    class="ri-arrow-right-line align-bottom"></i></a>
        </div>
    </div><!-- end card header -->

    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                <tbody>
                <?= ListView::widget([
                    'dataProvider' => $tasks,
                    'itemView' => '_lists/_task_list',
                    'summary' => false, // отключаем авто-summary
                    'pager' => false,   // отключаем авто-pager
                    'options' => ['tag' => false],
                    'itemOptions' => ['tag' => 'tr'],
                ]) ?>
                </tbody>
            </table>
        </div>

        <div class="align-items-center mt-4 pt-2 justify-content-between d-md-flex">
            <!-- summary -->
            <div class="flex-shrink-0 mb-2 mb-md-0">
                <div class="text-muted">
                    <?php
                    $pagination = $tasks->pagination;
                    $count = $tasks->count;
                    $total = $tasks->totalCount;
                    $begin = $pagination->offset + 1;
                    $end = $pagination->offset + $count;
                    ?>
                    Показаны записи <span class="fw-semibold"><?= $begin ?></span>-<span
                        class="fw-semibold"><?= $end ?></span>
                    из <span class="fw-semibold"><?= $total ?></span>
                </div>
            </div>

            <!-- pager -->
            <?= LinkPager::widget([
                'pagination' => $pagination,
                'prevPageLabel' => '←',
                'nextPageLabel' => '→',
                'disabledPageCssClass' => 'disabled',
                'activePageCssClass' => 'active',
                'maxButtonCount' => 3,
                'linkOptions' => ['class' => 'page-link'],
                'options' => [
                    'tag' => 'ul',
                    'class' => 'pagination pagination-separated pagination-sm mb-0',
                ],
                'pageCssClass' => 'page-item',
            ]) ?>
        </div>
    </div>
</div> <!-- .card-->
