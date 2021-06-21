<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<?= $this->include('admin/layout/fungsi'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cari Produk</h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('cart/add') ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group row">
                        <input type="text" class="form-control <?= ($validation->hasError('barcode')) ? 'is-invalid' : ''; ?>" id="cari" name="cari" value="<?= old('cari'); ?>" placeholder="Scan barcode or type barcode">
                        <input type="hidden" name="barcode" id="barcode">
                        <div class="invalid-feedback">
                            <?= $validation->getError('barcode'); ?>
                        </div>
                    </div>

                    <div class="float-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <?php if (empty($cart->contents())) { ?>
                    <p>Cart empty!</p>
                <?php } else { ?>
                    <p>
                        <a href="<?= base_url('cart/clear') ?>" class="btn btn-default"><i class="fas fa-times-circle"></i> Clear</a>
                    </p>

                    <table class="table table-bordered">
                        <thead>
                            <tr align="center">
                                <th style="width: 50px;">#</th>
                                <th>Nama</th>
                                <th style="width: 120px;">Jumlah</th>
                                <th style="width: 200px;">Harga</th>
                                <th style="width: 200px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart->contents() as $data) : ?>
                                <tr>
                                    <td align="center">
                                        <a href="<?= base_url('cart/delete/' . $data['rowid']) ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                    <td><?= $data['name'] ?></td>
                                    <td align="center">
                                        <form name="ubah_<?= $data['rowid'] ?>" action="<?= base_url('cart/edit') ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="rowid" value="<?= $data['rowid'] ?>">
                                            <input type="number" class="form-control" name="jumlah" min="0" value="<?= $data['qty'] ?>" onkeypress="return isNumberKeyTrue(event)" onChange="submit()">
                                        </form>
                                    </td>
                                    <td align="right"><?= ribuan($data['price']) ?></td>
                                    <td align="right"><?= ribuan($data['subtotal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <form name="frm_cart" action="<?= base_url('cart/save') ?>" method="post">
                            <?= csrf_field(); ?>
                            <tfoot>
                                <tr align="right">
                                    <th colspan="4">Total</th>
                                    <th><?= ribuan($cart->total()) ?></th>
                                </tr>
                                <tr>
                                    <th style="text-align: right;" colspan="4">Bayar</th>
                                    <th>
                                        <input type="text" class="form-control <?= ($validation->hasError('bayar')) ? 'is-invalid' : ''; ?>" name="bayar" id="bayar" value="<?= old('bayar') ?>" onfocus="startCalculate()" onblur="stopCalc()" onkeypress="return isNumberKeyTrue(event)" autocomplete="off">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('bayar'); ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align: right;" colspan="4">Kembali</th>
                                    <th>
                                        <input type="text" class="form-control" name="kembali" id="kembali" value="<?= old('kembali') ?>" readonly>
                                    </th>
                                </tr>
                            </tfoot>
                    </table><br />
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cari').autocomplete({
            minLength: 0,
            source: '<?= base_url('cart/product') ?>',
            focus: function(event, ui) {
                $('#cari').val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $('#cari').val(ui.item.label);
                $('#barcode').val(ui.item.barcode);
                return false;
            }
        })
    });

    var bayar = document.getElementById('bayar');
    bayar.addEventListener('keyup', function(e) {
        bayar.value = formatRupiah(this.value);
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? +rupiah : '');
    }

    function startCalculate() {
        interval = setInterval("Calculate()", 1);
    }

    function Calculate() {
        var total_cart = <?= $cart->total(); ?>;
        var bayar = parseInt(document.frm_cart.bayar.value.replace(".", ""));

        var kembalian = bayar - total_cart;

        var number_string = kembalian.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        document.frm_cart.kembali.value = rupiah;
    }

    function stopCalc() {
        clearInterval(interval);
    }
</script>
<?= $this->endSection(); ?>