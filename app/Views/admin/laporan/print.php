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
        <div class="row">
            <div class="col-12">
                <h3 class="card-title">
                    <?php if (empty($tgl_akhir)) {
                        echo $title . ' ' . tanggal($tgl_awal);
                    } else {
                        echo $title . ' ' . tanggal($tgl_awal) . ' s.d ' . tanggal($tgl_akhir);
                    } ?>
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr align="center">
                            <th>Barcode</th>
                            <th>Nama Produk</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah Terjual</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total_jual = 0;
                        $total_penjualan = 0;
                        foreach ($report as $data) : ?>
                            <tr align="center">
                                <td><?= $data['barcode'] ?></td>
                                <td align="left"><?= $data['nm_produk'] ?></td>
                                <td align="right"><?= rupiah($data['harga_jual']) ?></td>
                                <td><?= ribuan($data['total_jml']) ?></td>
                                <td align="right"><?= rupiah($data['total_subtotal']) ?></td>
                            </tr>
                        <?php $total_jual = $total_jual + $data['total_jml'];
                            $total_penjualan = $total_penjualan + $data['total_subtotal'];
                        endforeach; ?>
                    </tbody>
                    <tfoot align="right">
                        <tr>
                            <th colspan="3">TOTAL</th>
                            <th><?= ribuan($total_jual) ?></th>
                            <th><?= rupiah($total_penjualan) ?></th>
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