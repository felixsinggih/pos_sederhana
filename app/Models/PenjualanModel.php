<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_penjualan', 'id_user', 'total_harga', 'bayar', 'kembali'];

    public function kodegen()
    {
        $thn = substr(date('Y'), 2, 2);
        $bln = date('m');
        $hari = date('d');
        $jam = date("H");
        $param = "TRX-" . $thn . $bln . $hari . $jam;
        $query = $this->select('max(right(id_penjualan, 3)) as kode')
            ->like('id_penjualan', $param)
            ->limit(1)
            ->orderBy('id_penjualan', 'DESC')->get()->getRowArray();
        if (!empty($query)) {
            $kode = intval($query['kode']) + 1;
        } else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
        $kodejadi = $param . $kodemax;
        return $kodejadi;
    }

    public function cari($keyword)
    {
        return $this->join('users', 'users.id_user = penjualan.id_user')
            ->like('penjualan.id_penjualan', $keyword)
            ->orLike('users.nm_user', $keyword)
            ->orderBy('penjualan.created_at', 'DESC');
    }

    public function allPenjualanUser()
    {
        return $this->join('users', 'users.id_user = penjualan.id_user')
            ->orderBy('penjualan.created_at', 'DESC');
    }

    public function penjualanUser($idPenjualan)
    {
        return $this->join('users', 'users.id_user = penjualan.id_user')
            ->where('penjualan.id_penjualan', $idPenjualan)
            ->get()->getRowArray();
    }

    public function laporan($tgl_awal, $tgl_akhir = false)
    {
        if (empty($tgl_akhir)) {
            return $this->select('*, SUM(penjualan_detail.jumlah) AS total_jml, SUM(penjualan_detail.subtotal) AS total_subtotal')
                ->join('penjualan_detail', 'penjualan_detail.id_penjualan = penjualan.id_penjualan')
                ->join('produk', 'produk.barcode = penjualan_detail.barcode')
                ->where('DATE(penjualan.created_at)', $tgl_awal)
                ->groupBy('produk.barcode')->orderBy('total_jml', 'DESC')->get()->getResultArray();
        } else {
            return $this->select('*, SUM(penjualan_detail.jumlah) AS total_jml, SUM(penjualan_detail.subtotal) AS total_subtotal')
                ->join('penjualan_detail', 'penjualan_detail.id_penjualan = penjualan.id_penjualan')
                ->join('produk', 'produk.barcode = penjualan_detail.barcode')
                ->where('DATE(penjualan.created_at) >=', $tgl_awal)
                ->where('DATE(penjualan.created_at) <=', $tgl_akhir)
                ->groupBy('produk.barcode')->orderBy('total_jml', 'DESC')->get()->getResultArray();
        }
    }

    public function produkTerjual($tgl)
    {
        return $this->select('SUM(penjualan_detail.jumlah) AS total_jml')
            ->join('penjualan_detail', 'penjualan_detail.id_penjualan = penjualan.id_penjualan')
            ->join('produk', 'produk.barcode = penjualan_detail.barcode')
            ->where('DATE(penjualan.created_at) >=', $tgl)
            ->get()->getRowArray();
    }

    public function totalPenjualan($tgl)
    {
        return $this->select('SUM(penjualan_detail.subtotal) AS total_subtotal')
            ->join('penjualan_detail', 'penjualan_detail.id_penjualan = penjualan.id_penjualan')
            ->join('produk', 'produk.barcode = penjualan_detail.barcode')
            ->where('DATE(penjualan.created_at) >=', $tgl)
            ->get()->getRowArray();
    }

    public function produkTerlaris($tgl_sekarang)
    {
        $tgl = date('Y-m-d', strtotime('-30 days', strtotime($tgl_sekarang)));
        return $this->select('*, SUM(penjualan_detail.jumlah) AS total_jml, SUM(penjualan_detail.subtotal) AS total_subtotal')
            ->join('penjualan_detail', 'penjualan_detail.id_penjualan = penjualan.id_penjualan')
            ->join('produk', 'produk.barcode = penjualan_detail.barcode')
            ->where('DATE(penjualan.created_at) >=', $tgl)
            ->where('DATE(penjualan.created_at) <=', $tgl_sekarang)
            ->groupBy('produk.barcode')->orderBy('total_jml', 'DESC')
            ->limit(5)->get()->getResultArray();
    }
}
