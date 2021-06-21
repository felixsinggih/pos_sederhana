<!DOCTYPE html>
<html lang="en">
<?= $this->include('admin/layout/fungsi') ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/admin/dist/css/adminlte.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    Kode Transaksi
                    <address>
                        <strong><?= $penjualan['id_penjualan'] ?></strong>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    Kasir
                    <address>
                        <strong><?= $penjualan['nm_user'] ?></strong>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    Tanggal Transasi
                    <address>
                        <strong><?= datetime($penjualan['created_at']) ?></strong>
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr align="center">
                                <th>Nama</th>
                                <th style="width: 100px;">Jumlah</th>
                                <th style="width: 150px;">Harga</th>
                                <th style="width: 150px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detail as $data) : ?>
                                <tr>
                                    <td><?= $data['nm_produk'] ?></td>
                                    <td align="center"><?= $data['jumlah'] ?></td>
                                    <td align="right"><?= ribuan($data['harga']) ?></td>
                                    <td align="right"><?= ribuan($data['subtotal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot align="right">
                            <tr>
                                <th colspan="3">Total</th>
                                <th><?= ribuan($penjualan['total_harga']) ?></th>
                            </tr>
                            <tr>
                                <th colspan="3">Bayar</th>
                                <th><?= ribuan($penjualan['bayar']) ?></th>
                            </tr>
                            <tr>
                                <th colspan="3">Kembali</th>
                                <th><?= ribuan($penjualan['kembali']) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>