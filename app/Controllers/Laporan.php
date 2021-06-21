<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;

class Laporan extends BaseController
{
    protected $productModel;
    protected $penjualanModel;
    protected $penjualanDetailModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->penjualanModel = new PenjualanModel();
        $this->penjualanDetailModel = new PenjualanDetailModel();
    }

    public function index()
    {
        if (session()->get('level') != "Admin") {
            session()->setflashdata('failed', 'Maaf, hanya admin yang dapat mengakses fitur ini!');
            return redirect()->to(base_url('dashboard'));
        }

        $tgl_awal = $this->request->getVar('tgl_awal');
        $tgl_akhir = $this->request->getVar('tgl_akhir');

        if ($tgl_awal && $tgl_akhir) {
            $report = $this->penjualanModel->laporan($tgl_awal, $tgl_akhir);
        } elseif ($tgl_awal) {
            $report = $this->penjualanModel->laporan($tgl_awal);
        } else {
            $tgl_awal = date('Y-m-d');
            $report = $this->penjualanModel->laporan($tgl_awal);
        }
        $data = [
            'title' => 'Laporan Penjualan',
            'report'  => $report,
            'act'   => ['report', ''],
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/laporan/index', $data);
    }

    public function cetak_hari($tgl_awal)
    {
        $report = $this->penjualanModel->laporan($tgl_awal);
        $tgl_akhir = "";
        $data = [
            'title' => 'Laporan Penjualan ' . $tgl_awal,
            'report'  => $report,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ];
        return view('admin/laporan/print', $data);
    }

    public function cetak($tgl_awal, $tgl_akhir)
    {
        $report = $this->penjualanModel->laporan($tgl_awal, $tgl_akhir);
        $data = [
            'title' => 'Laporan Penjualan ' . $tgl_awal . ' s.d ' . $tgl_akhir,
            'report'  => $report,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir
        ];
        return view('admin/laporan/print', $data);
    }
}
