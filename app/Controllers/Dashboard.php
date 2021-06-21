<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;

class Dashboard extends BaseController
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
        $data = [
            'title' => 'Dashboard',
            'produkTerjual' => $this->penjualanModel->produkTerjual(date('Y-m-d')),
            'totalPenjualan' => $this->penjualanModel->totalPenjualan(date('Y-m-d')),
            'produkTerlaris' => $this->penjualanModel->produkTerlaris(date('Y-m-d')),
            'act'   => ['dashboard', ''],
        ];
        return view('admin/dashboard/index', $data);
    }
}
