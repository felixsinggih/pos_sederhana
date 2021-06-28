<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/adminlte_dist/css/adminlte.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <!-- DatePicker -->
    <script src="<?= base_url() ?>/adminlte/plugins/datepicker/js/jquery-1.10.2.js"></script>
    <link href="<?= base_url() ?>/adminlte/plugins/datepicker/css/bootstrap-datepicker.css" rel="stylesheet" media="screen">
    <link href="<?= base_url() ?>/adminlte/plugins/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

    <!-- JQueryUI -->
    <link rel="stylesheet" href="<?= base_url() ?>/adminlte/plugins/jquery-ui/jquery-ui.min.css">

    <script>
        function isNumberKeyTrue(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (((charCode < 58) && (charCode > 47)) || (charCode == 8))
                return true;
            return false;
        }

        function isNumberKeyTrueWithSpace(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (((charCode < 58) && (charCode > 47)) || (charCode == 8) || (charCode == 32))
                return true;
            return false;
        }

        $(function() {
            $.datepicker.setDefaults({
                monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                // showButtonPanel: true,
                // currentText: "Hari Ini",
                // closeText: "Close",
                nextText: "Berikutnya",
                prevText: "Sebelum",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: "yy-mm-dd",
                yearRange: "-100:+100",
                changeYear: true,
            });
            $("#tgl1").datepicker({
                onClose: function(selectedDate) {
                    $("#tgl2").datepicker("option", "minDate", selectedDate);
                }
            });
            $("#tgl2").datepicker();
        });
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">Home</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url('dashboard') ?>" class="brand-link elevation-4">
                <img src="<?= base_url() ?>/adminlte/adminlte_dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>/adminlte/adminlte_dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php $name = session()->get('name');
                                                    $nameSplit = explode(" ", $name);
                                                    echo $nameSplit[0] . ' | ' . session()->get('level'); ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <?= $this->include('admin/layout/sidebar'); ?>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?= $title ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                                <li class="breadcrumb-item active"><?= $title ?></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12">
                            <?php if (session()->getflashdata('success')) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= session()->getflashdata('success'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (session()->getflashdata('failed')) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= session()->getflashdata('failed'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?= $this->renderSection('content'); ?>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.1.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/adminlte/adminlte_dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url() ?>/adminlte/adminlte_dist/js/demo.js"></script>
    <!-- DataTables -->
    <script src="<?= base_url() ?>/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- DatePicker -->
    <script src="<?= base_url() ?>/adminlte/plugins/datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?= base_url() ?>/adminlte/plugins/datepicker/js/bootstrap-datetimepicker.js"></script>
    <!-- JQueryUI -->
    <script src="<?= base_url() ?>/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script>
        $(function() {
            $('#dataTable1').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>