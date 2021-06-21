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
                <form action="<?= base_url('product/searching') ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Pencarian" name="keyword" value="<?= $keyword; ?>" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                        </div>
                    </div>
                </form>
                <?php if (session()->get('level') == "Admin") { ?>
                    <p>
                        <a href="<?= base_url('product/add') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                    </p>
                <?php } ?>
                <table id="dataTable1" class="table table-bordered table-hover table-striped">
                    <thead align="center">
                        <tr>
                            <td style="width: 70px;">No.</td>
                            <td>Barcode</td>
                            <td>Nama</td>
                            <td style="width: 120px;">Harga</td>
                            <td style="width: 60px;">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 + (25 * ($currentPage - 1));
                        foreach ($product as $data) : ?>
                            <tr align="center">
                                <td><?= $i++ ?></td>
                                <td><?= $data['barcode'] ?></td>
                                <td align="left"><?= $data['nm_produk'] ?></td>
                                <td><?= rupiah($data['harga_jual']) ?></td>
                                <td>
                                    <a href="<?= base_url('product/' . $data['barcode']) ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <?php if (session()->get('level') == "Admin") { ?>
                                        <a href="<?= base_url('product/edit/' . $data['barcode']) ?>" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <i>Menampilkan 25 data per halaman.</i>
                <div class="float-right">
                    <?= $pager->links('product', 'paging_new'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>