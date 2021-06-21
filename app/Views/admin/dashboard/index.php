<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<?= $this->include('admin/layout/fungsi') ?>
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>
                    <?php if ($produkTerjual['total_jml'] == null) echo 0;
                    else echo ribuan($produkTerjual['total_jml']) ?>
                </h3>
                <p>Total Produk Terjual Hari Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-cart-plus"></i>
            </div>
            <a href="<?= base_url('report') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>
                    <?php if ($totalPenjualan['total_subtotal'] == null) echo 0;
                    else echo rupiah($totalPenjualan['total_subtotal']) ?>
                </h3>
                <p>Total Penjualan Hari Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <a href="<?= base_url('report') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <?php if (!empty($produkTerlaris)) { ?>
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Produk Terlaris Dalam 30 Hari Terakhir</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        <?php foreach ($produkTerlaris as $data) : ?>
                            <li class="item">
                                <!-- <div class="product-img">
                                <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Samsung TV
                                    <span class="badge badge-warning float-right">$1800</span></a>
                                <span class="product-description">
                                    Samsung 32" 1080p 60Hz LED Smart HDTV.
                                </span>
                            </div> -->
                                <a href="<?= base_url('product/' . $data['barcode']) ?>"><?= $data['nm_produk'] ?></a>
                                <span class="product-description">Terjual <?= ribuan($data['total_jml']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="<?= base_url('product') ?>" class="uppercase">Lihat Semua</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?= $this->endSection(); ?>