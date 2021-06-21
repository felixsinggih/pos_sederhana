<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('product/save') ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group row">
                        <label for="barcode" class="col-sm-2 col-form-label">Barcode</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('barcode')) ? 'is-invalid' : ''; ?>" id="barcode" name="barcode" value="<?= old('barcode'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('barcode'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nm_produk" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nm_produk')) ? 'is-invalid' : ''; ?>" id="nm_produk" name="nm_produk" value="<?= old('nm_produk'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nm_produk'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('harga_jual')) ? 'is-invalid' : ''; ?>" id="harga_jual" name="harga_jual" value="<?= old('harga_jual'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('harga_jual'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" name="keterangan" id="keterangan"><?= old('keterangan') ?></textarea>
                        </div>
                    </div>

                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>