<?php echo $this->render('partials/main'); ?>

<head>

    <?php echo $this->render('partials/title-meta', array('title' => 'Apex Range Area Charts')); ?>

    <?php echo $this->render('partials/head-css'); ?>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php echo $this->render('partials/menu'); ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <?php echo $this->render('partials/page-title', array('pagetitle'=>'Apexcharts', 'title'=> 'Range Area Charts')); ?>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Basic Range Area Chart</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div id="basic_range_area" data-colors='["--vz-primary"]' class="apex-charts" dir="ltr"></div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Combo</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div>
                                        <div id="combo_range_area" data-colors='["--vz-info", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php echo $this->render('partials/footer'); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <?php echo $this->render('partials/customizer'); ?>

    <?php echo $this->render('partials/vendor-scripts'); ?>

    <!-- apexcharts -->
    <script src="/libs/apexcharts/apexcharts.min.js"></script>

    <script src="https://apexcharts.com/samples/assets/ohlc.js"></script>
    <!-- for Category x-axis chart -->
    <script src="https://img.themesbrand.com/velzon/apexchart-js/dayjs.min.js"></script>

    <!-- range-area charts init -->
    <script src="/js/pages/apexcharts-range-area.init.js"></script>

    <!-- App js -->
    <script src="/js/app.js"></script>
</body>

</html>