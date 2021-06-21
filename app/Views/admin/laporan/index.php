<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<?= $this->include('admin/layout/fungsi'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-filter"></i> Filter</h3>
            </div>
            <form action="<?= base_url('report') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>From</label>
                                <input type="text" class="form-control" id="tgl1" name="tgl_awal" placeholder="YYYY-MM-DD" value="<?= (old('tgl_awal')) ? old('tgl_awal') : $tgl_awal ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>To</label>
                                <input type="text" class="form-control" id="tgl2" name="tgl_akhir" placeholder="YYYY-MM-DD" value="<?= (old('tgl_akhir')) ? old('tgl_akhir') : $tgl_akhir ?>">
                            </div>
                        </div>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <?php if (empty($tgl_akhir)) {
                        echo $title . ' ' . tanggal($tgl_awal);
                    } else {
                        echo $title . ' ' . tanggal($tgl_awal) . ' s.d ' . tanggal($tgl_akhir);
                    } ?>
                </h3>
            </div>
            <div class="card-body">
                <?php if ($report) {
                    if (empty($tgl_akhir)) { ?>
                        <a href="<?= base_url('report/day/' . $tgl_awal) ?>" rel="noopener" target="_blank" class="btn btn-danger"><i class="fas fa-print"></i> Cetak</a>
                    <?php } else { ?>
                        <a href="<?= base_url('report/print/' . $tgl_awal . '/' . $tgl_akhir) ?>" rel="noopener" target="_blank" class="btn btn-danger"><i class="fas fa-print"></i> Cetak</a>
                    <?php } ?>
                <?php } ?>
                <table id="dataTable1" class="table table-bordered table-hover table-striped">
                    <thead align="center">
                        <tr>
                            <td style="width: 70px;">No.</td>
                            <td>Barcode</td>
                            <td>Nama Produk</td>
                            <td>Jumlah Terjual</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        $total = 0;
                        foreach ($report as $data) : ?>
                            <tr align="center">
                                <td><?= $i++ ?></td>
                                <td><?= $data['barcode'] ?></td>
                                <td align="left"><?= $data['nm_produk'] ?></td>
                                <td><?= ribuan($data['total_jml']) ?></td>
                                <td align="right"><?= rupiah($data['total_subtotal']) ?></td>
                            </tr>
                        <?php $total = $total + $data['total_subtotal'];
                        endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr align="right">
                            <th colspan="4">TOTAL</th>
                            <th><?= rupiah($total) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>