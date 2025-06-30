<?php
/** @var yii\web\View $this */
$this->title = 'Главная';
?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= ($this->title) ? $this->title : '' ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a
                                href="javascript: void(0);"><?= ($this->title) ? $this->title : '' ?></a></li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="d-flex flex-column h-100">
            <div class="row">
                <div class="col-xl-2 col-md-6">
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200"
                                 height="120">
                                <style>
                                    .s0 {
                                        opacity: .05;
                                        fill: var(--vz-primary)
                                    }
                                </style>
                                <path id="Shape 8" class="s0"
                                      d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"/>
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Общее количество
                                        задач</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                                                          data-target="<?= $task_all ?>">0</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="total_jobs" data-colors='["--vz-success"]' class="apex-charts"
                                         dir="ltr"></div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!--end col-->
                <div class="col-xl-2 col-md-6">
                    <!-- card -->
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200"
                                 height="120">
                                <style>
                                    .s0 {
                                        opacity: .05;
                                        fill: var(--vz-primary)
                                    }
                                </style>
                                <path id="Shape 8" class="s0"
                                      d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"/>
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Завершенные
                                        задачи</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                                                          data-target="<?= $task_success ?>"></span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="apply_jobs" data-colors='["--vz-success"]' class="apex-charts"
                                         dir="ltr"></div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-2 col-md-6">
                    <!-- card -->
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200"
                                 height="120">
                                <style>
                                    .s0 {
                                        opacity: .05;
                                        fill: var(--vz-primary)
                                    }
                                </style>
                                <path id="Shape 8" class="s0"
                                      d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"/>
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Новые задачи</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                                                          data-target="<?= $task_new ?>">0</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="new_jobs_chart" data-colors='["--vz-success"]' class="apex-charts"
                                         dir="ltr"></div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-2 col-md-6">
                    <!-- card -->
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200"
                                 height="120">
                                <style>
                                    .s0 {
                                        opacity: .05;
                                        fill: var(--vz-primary)
                                    }
                                </style>
                                <path id="Shape 8" class="s0"
                                      d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"/>
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Отклоненные
                                        задачи</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                                                          data-target="<?= $task_rejected ?>">0</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="interview_chart" data-colors='["--vz-danger"]' class="apex-charts"
                                         dir="ltr"></div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-2 col-md-6">
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200"
                                 height="120">
                                <style>
                                    .s0 {
                                        opacity: .05;
                                        fill: var(--vz-primary)
                                    }
                                </style>
                                <path id="Shape 8" class="s0"
                                      d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"/>
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Задачи в
                                        процессе </p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                                                          data-target="<?= $task_process ?>">0</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="hired_chart" data-colors='["--vz-success"]' class="apex-charts"
                                         dir="ltr"></div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!--end col-->
                <div class="col-xl-2 col-md-6">
                    <!-- card -->
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200"
                                 height="120">
                                <style>
                                    .s0 {
                                        opacity: .05;
                                        fill: var(--vz-primary)
                                    }
                                </style>
                                <path id="Shape 8" class="s0"
                                      d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"/>
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Просроченные
                                        задачи</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                                                          data-target="<?= $task_overed ?>">0</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="rejected_chart" data-colors='["--vz-danger"]' class="apex-charts"
                                         dir="ltr"></div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!--end row-->
        </div>
    </div><!--end col-->
    <div class="col-xl-12">
        <?= $this->render('_tasks', ['tasks' => $tasks]) ?>
    </div><!--end col-->
</div><!--end row-->

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_employees_pie_chart') ?>
    </div>
    <div class="col-md-9">
        <?=$this->render('_employees_column_chart')?>
    </div>
</div>

<div class="row">
    <div class="col-xxl-8">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Recent Applicants</h4>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-info btn-sm">
                        <i class="ri-file-list-3-line align-bottom"></i> Generate Report
                    </button>
                </div>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                        <thead class="text-muted table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Candidate Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Rate/hr</th>
                            <th scope="col">Location</th>
                            <th scope="col">Type</th>
                            <th scope="col">Rating</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <a href="#!" class="fw-medium link-primary">#VZ2112</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <img src="/images/users/avatar-1.jpg" alt="" class="avatar-xs rounded-circle"/>
                                    </div>
                                    <div class="flex-grow-1">Nicholas Ball</div>
                                </div>
                            </td>
                            <td>Assistant / Store Keeper</td>
                            <td>
                                <span class="text-success">$109.00</span>
                            </td>
                            <td>California, US</td>
                            <td>
                                <span class="badge bg-success-subtle text-success">Full Time</span>
                            </td>
                            <td>
                                <h5 class="fs-14 fw-medium mb-0">5.0<span
                                            class="text-muted fs-11 ms-1">(245 Rating)</span></h5>
                            </td>
                        </tr><!-- end tr -->
                        <tr>
                            <td>
                                <a href="#!" class="fw-medium link-primary">#VZ2111</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <img src="/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle"/>
                                    </div>
                                    <div class="flex-grow-1">Elizabeth Allen</div>
                                </div>
                            </td>
                            <td>Education Training</td>
                            <td>
                                <span class="text-success">$149.00</span>
                            </td>
                            <td>Zuweihir, UAE</td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary">Freelancer</span>
                            </td>
                            <td>
                                <h5 class="fs-14 fw-medium mb-0">4.5<span
                                            class="text-muted fs-11 ms-1">(645 Rating)</span></h5>
                            </td>
                        </tr><!-- end tr -->
                        <tr>
                            <td>
                                <a href="#!" class="fw-medium link-primary">#VZ2109</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <img src="/images/users/avatar-3.jpg" alt="" class="avatar-xs rounded-circle"/>
                                    </div>
                                    <div class="flex-grow-1">Cassian Jenning</div>
                                </div>
                            </td>
                            <td>Graphic Designer</td>
                            <td>
                                <span class="text-success">$215.00</span>
                            </td>
                            <td>Limestone, US</td>
                            <td>
                                <span class="badge bg-danger-subtle text-danger">Part Time</span>
                            </td>
                            <td>
                                <h5 class="fs-14 fw-medium mb-0">4.9<span
                                            class="text-muted fs-11 ms-1">(89 Rating)</span></h5>
                            </td>
                        </tr><!-- end tr -->
                        <tr>
                            <td>
                                <a href="#!" class="fw-medium link-primary">#VZ2108</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <img src="/images/users/avatar-4.jpg" alt="" class="avatar-xs rounded-circle"/>
                                    </div>
                                    <div class="flex-grow-1">Scott Holt</div>
                                </div>
                            </td>
                            <td>UI/UX Designer</td>
                            <td>
                                <span class="text-success">$199.00</span>
                            </td>
                            <td>Germany</td>
                            <td>
                                <span class="badge bg-danger-subtle text-danger">Part Time</span>
                            </td>
                            <td>
                                <h5 class="fs-14 fw-medium mb-0">4.3<span
                                            class="text-muted fs-11 ms-1">(47 Rating)</span></h5>
                            </td>
                        </tr><!-- end tr -->
                        <tr>
                            <td>
                                <a href="#!" class="fw-medium link-primary">#VZ2109</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <img src="/images/users/avatar-6.jpg" alt="" class="avatar-xs rounded-circle"/>
                                    </div>
                                    <div class="flex-grow-1">Hadley Leonard</div>
                                </div>
                            </td>
                            <td>React Developer</td>
                            <td>
                                <span class="text-success">$330.00</span>
                            </td>
                            <td>Mughairah, UAE</td>
                            <td>
                                <span class="badge bg-success-subtle text-success">Full Time</span>
                            </td>
                            <td>
                                <h5 class="fs-14 fw-medium mb-0">4.7<span
                                            class="text-muted fs-11 ms-1">(161 Rating)</span></h5>
                            </td>
                        </tr><!-- end tr -->
                        <tr>
                            <td>
                                <a href="#!" class="fw-medium link-primary">#VZ2110</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <img src="/images/users/avatar-10.jpg" alt="" class="avatar-xs rounded-circle"/>
                                    </div>
                                    <div class="flex-grow-1">Harley Watkins</div>
                                </div>
                            </td>
                            <td>Project Manager</td>
                            <td>
                                <span class="text-success">$330.00</span>
                            </td>
                            <td>Texanna, US</td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary">Freelancer</span>
                            </td>
                            <td>
                                <h5 class="fs-14 fw-medium mb-0">4.7<span
                                            class="text-muted fs-11 ms-1">(3.21k Rating)</span></h5>
                            </td>
                        </tr><!-- end tr -->
                        <tr>
                            <td>
                                <a href="#!" class="fw-medium link-primary">#VZ2111</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <img src="/images/users/avatar-8.jpg" alt="" class="avatar-xs rounded-circle"/>
                                    </div>
                                    <div class="flex-grow-1">Nadia Harding</div>
                                </div>
                            </td>
                            <td>Web Designer</td>
                            <td>
                                <span class="text-success">$330.00</span>
                            </td>
                            <td>Pahoa, US</td>
                            <td>
                                <span class="badge bg-danger-subtle text-danger">Part Time</span>
                            </td>
                            <td>
                                <h5 class="fs-14 fw-medium mb-0">4.7<span
                                            class="text-muted fs-11 ms-1">(2.93k Rating)</span></h5>
                            </td>
                        </tr><!-- end tr -->
                        <tr>
                            <td>
                                <a href="#!" class="fw-medium link-primary">#VZ2112</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <img src="/images/users/avatar-9.jpg" alt="" class="avatar-xs rounded-circle"/>
                                    </div>
                                    <div class="flex-grow-1">Jenson Carlson</div>
                                </div>
                            </td>
                            <td>Product Director</td>
                            <td>
                                <span class="text-success">$330.00</span>
                            </td>
                            <td>Pahoa, US</td>
                            <td>
                                <span class="badge bg-success-subtle text-success">Full Time</span>
                            </td>
                            <td>
                                <h5 class="fs-14 fw-medium mb-0">4.7<span
                                            class="text-muted fs-11 ms-1">(4.31k Rating)</span></h5>
                            </td>
                        </tr><!-- end tr -->
                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div>
            </div>
        </div> <!-- .card-->
    </div> <!-- .col-->

</div> <!-- end row-->


<!-- apexcharts -->
<script src="/libs/apexcharts/apexcharts.min.js"></script>

<!-- App js -->
<script src="/js/app.js"></script>
<script src="/js/charts.init.js"></script>

