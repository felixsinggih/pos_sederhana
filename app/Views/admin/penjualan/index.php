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
                <form action="<?= base_url('sales/searching') ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Kode transaksi / Nama kasir" name="keyword" value="<?= $keyword; ?>" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                        </div>
                    </div>
                </form>

                <p>
                    <a href="<?= base_url('cart') ?>" class="btn btn-primary"><i class="fas fa-cart-plus"></i> Tambah</a>
                </p>
                <table id="dataTable1" class="table table-bordered table-hover table-striped">
                    <thead align="center">
                        <tr>
                            <td style="width: 70px;">No.</td>
                            <td>Kode Transaksi</td>
                            <td>Kasir</td>
                            <td>Total</td>
                            <td>Tanggal</td>
                            <td style="width: 60px;">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 + (50 * ($currentPage - 1));
                        foreach ($sales as $data) : ?>
                            <tr align="center">
                                <td><?= $i++ ?></td>
                                <td><?= $data['id_penjualan'] ?></td>
                                <td align="left"><?= $data['nm_user'] ?></td>
                                <td align="right"><?= ribuan($data['total_harga']) ?></td>
                                <td><?= datetime($data['created_at']) ?></td>
                                <td>
                                    <a href="<?= base_url('sales/' . $data['id_penjualan']) ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <!-- <a href="<?= base_url('users/edit/' . $data['id_user']) ?>" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <i>Menampilkan 50 data per halaman.</i>
                <div class="float-right">
                    <?= $pager->links('user', 'paging_new'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>