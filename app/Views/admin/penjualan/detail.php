<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<?= $this->include('admin/layout/fungsi'); ?>
<div class="row">
    <div class="col-12">
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
                                <th>Barcode</th>
                                <th>Nama</th>
                                <th style="width: 150px;">Harga</th>
                                <th style="width: 100px;">Jumlah</th>
                                <th style="width: 150px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detail as $data) : ?>
                                <tr>
                                    <td align="center"><?= $data['barcode'] ?></td>
                                    <td><?= $data['nm_produk'] ?></td>
                                    <td align="right"><?= ribuan($data['harga']) ?></td>
                                    <td align="center"><?= $data['jumlah'] ?></td>
                                    <td align="right"><?= ribuan($data['subtotal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot align="right">
                            <tr>
                                <th colspan="4">Total</th>
                                <th><?= ribuan($penjualan['total_harga']) ?></th>
                            </tr>
                            <tr>
                                <th colspan="4">Bayar</th>
                                <th><?= ribuan($penjualan['bayar']) ?></th>
                            </tr>
                            <tr>
                                <th colspan="4">Kembali</th>
                                <th><?= ribuan($penjualan['kembali']) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row no-print">
                <div class="col-12">
                    <a href="<?= base_url('sales/print/' . $penjualan['id_penjualan']) ?>" rel="noopener" target="_blank" class="btn btn-danger float-right"><i class="fas fa-print"></i> Print</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>