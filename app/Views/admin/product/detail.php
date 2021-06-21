<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<?= $this->include('admin/layout/fungsi'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <p>
                    <a href="<?= base_url('product') ?>" class="btn btn-secondary"><i class="fas fa-undo"></i> Back</a>
                    <a href="<?= base_url('product/edit/' . $product['barcode']) ?>" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Edit</a>
                </p>
                <table class="table table-bordered table-hover">
                    <tr>
                        <td style="width: 20%;">Barcode</td>
                        <td><?= $product['barcode'] ?></td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td><?= $product['nm_produk'] ?></td>
                    </tr>
                    <tr>
                        <td>Harga Jual</td>
                        <td><?= rupiah($product['harga_jual']) ?></td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td><?= $product['keterangan'] ?></td>
                    </tr>
                    <tr>
                        <td>Last Update</td>
                        <td><?= datetime($product['updated_at']) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>