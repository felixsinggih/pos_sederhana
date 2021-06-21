<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanDetailModel extends Model
{
    protected $table = 'penjualan_detail';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_penjualan', 'barcode', 'harga', 'jumlah', 'subtotal'];

    public function detailPenjualanProduk($idPenjualan)
    {
        return $this->join('produk', 'produk.barcode = penjualan_detail.barcode')
            ->where('penjualan_detail.id_penjualan', $idPenjualan)
            ->get()->getResultArray();
    }
}
