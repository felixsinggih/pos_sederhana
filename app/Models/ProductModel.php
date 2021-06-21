<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'barcode';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['barcode', 'nm_produk', 'harga_jual', 'keterangan'];

    public function cari($keyword)
    {
        return $this->like('barcode', $keyword)->orLike('nm_produk', $keyword);
    }

    public function cari_produk($barcode)
    {
        return $this->like('barcode', $barcode)->findAll();
    }
}
