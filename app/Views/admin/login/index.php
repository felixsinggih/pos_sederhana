<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in (v2)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/admin/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= base_url() ?>" class="h1">Point Of Sales</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Log in to start your session</p>

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

                <form action="<?= base_url('login') ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary btn-block">Log In</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/admin/dist/js/adminlte.min.js"></script>
</body>

</html>