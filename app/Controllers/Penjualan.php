<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\ProductModel;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;

class Penjualan extends BaseController
{
    protected $usersModel;
    protected $productModel;
    protected $penjualanModel;
    protected $penjualanDetailModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
        $this->productModel = new ProductModel();
        $this->penjualanModel = new PenjualanModel();
        $this->penjualanDetailModel = new PenjualanDetailModel();
    }

    public function index()
    {
        $currentpage = $this->request->getVar('page_sales') ? $this->request->getVar('page_sales') : 1;
        $keyword = $this->request->getVar('keyword');
        $sales = $this->penjualanModel->allPenjualanUser();
        $data = [
            'title' => 'Data Penjualan',
            'sales'  => $sales->paginate(50, 'sales'),
            'pager' => $this->penjualanModel->pager,
            'act'   => ['sales', 'data_sales'],
            'currentPage' => $currentpage,
            'keyword' => $keyword,
        ];
        return view('admin/penjualan/index', $data);
    }

    public function pencarian()
    {
        $keyword = $this->request->getVar('keyword');
        return redirect()->to(base_url('/sales/search/' . $keyword))->withInput();
    }

    public function cari($keyword)
    {
        $currentpage = $this->request->getVar('page_sales') ? $this->request->getVar('page_sales') : 1;
        $sales = $this->penjualanModel->cari($keyword);
        $data = [
            'title' => 'Data Penjualan',
            'sales'  => $sales->paginate(50, 'sales'),
            'pager' => $this->penjualanModel->pager,
            'act'   => ['sales', 'data_sales'],
            'currentPage' => $currentpage,
            'keyword' => $keyword,
        ];
        return view('admin/penjualan/index', $data);
    }

    public function data_produk()
    {
        $request = \Config\Services::request();
        $barcode = $request->getPostGet('term');
        $product = $this->productModel->cari_produk($barcode);
        $w = array();
        foreach ($product as $a) :
            $w[] = [
                "label" => $a['barcode'] . ' - ' . $a['nm_produk'] . ' - ' . $a['harga_jual'],
                "barcode" => $a['barcode'],
            ];
        endforeach;
        echo json_encode($w);
    }

    public function transaksi()
    {
        $cart = \Config\Services::cart();

        $data = [
            'title' => 'Keranjang Belanja',
            'cart'  => $cart,
            'act'   => ['sales', 'add_sales'],
            'validation' => \Config\Services::validation()
        ];
        return view('admin/penjualan/cart', $data);
    }

    public function tambah_produk()
    {
        if (!$this->validate([
            'barcode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan lakukan pencarian!',
                ]
            ]
        ])) {
            return redirect()->to(base_url('cart'))->withInput();
        }

        $barcode = $this->request->getVar('barcode');
        $product = $this->productModel->find($barcode);

        $cart = \Config\Services::cart();
        $cart->insert(array(
            'id'      => $product['barcode'],
            'qty'     => 1,
            'price'   => $product['harga_jual'],
            'name'    => $product['nm_produk']
        ));
        return redirect()->to(base_url('cart'));
    }

    public function edit_produk()
    {
        $rowid = $this->request->getVar('rowid');
        $jumlah = $this->request->getVar('jumlah');

        if ($jumlah == 0) {
            return redirect()->to(base_url('cart/delete/' . $rowid));
        } else {
            $cart = \Config\Services::cart();
            $cart->update(array(
                'rowid'   => $rowid,
                'qty'     => $jumlah
            ));
            return redirect()->to(base_url('cart'));
        }
    }

    public function hapus_produk($rowID)
    {
        $cart = \Config\Services::cart();
        $cart->remove($rowID);
        return redirect()->to(base_url('cart'));
    }

    public function hapus_cart()
    {
        $cart = \Config\Services::cart();
        $cart->destroy();
        return redirect()->to(base_url('cart'));
    }

    public function simpan()
    {
        if (!$this->validate([
            'bayar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom ini wajib diisi!',
                ]
            ]
        ])) {
            return redirect()->to(base_url('cart'))->withInput();
        }

        $cart = \Config\Services::cart();
        $idPenjualan = $this->penjualanModel->kodegen();
        $bayar = str_replace(".", "", $this->request->getVar('bayar'));
        $kembali = str_replace(".", "", $this->request->getVar('kembali'));
        $penjualan = [
            'id_penjualan'  => $idPenjualan,
            'id_user'       => session()->get('idUser'),
            'total_harga'   => $cart->total(),
            'bayar'         => $bayar,
            'kembali'       => $kembali
        ];

        $penjualanDetail = array();
        foreach ($cart->contents() as $data) :
            $detail = [
                'id_penjualan'  => $idPenjualan,
                'barcode'       => $data['id'],
                'harga'         => $data['price'],
                'jumlah'        => $data['qty'],
                'subtotal'      => $data['subtotal']
            ];
            array_push($penjualanDetail, $detail);
        endforeach;

        $this->db->transStart();
        $this->penjualanModel->insert($penjualan);
        $this->penjualanDetailModel->insertBatch($penjualanDetail);
        $this->db->transComplete();

        if ($this->db->transStatus() == false) {
            session()->setflashdata('failed', 'Data penjualan gagal disimpan.');
            return redirect()->to(base_url('cart'));
        } elseif ($this->db->transStatus() == true) {
            $cart->destroy();
            session()->setflashdata('success', 'Data penjualan berhasil disimpan.');
            return redirect()->to(base_url('sales/' . $idPenjualan));
        }
    }

    public function detail($idPenjualan)
    {
        $penjualan = $this->penjualanModel->penjualanUser($idPenjualan);
        $penjualanDetail = $this->penjualanDetailModel->detailPenjualanProduk($idPenjualan);

        $data = [
            'title' => 'Detail Penjualan',
            'penjualan' => $penjualan,
            'detail' => $penjualanDetail,
            'act'   => ['sales', 'data_sales'],
        ];
        return view('admin/penjualan/detail', $data);
    }

    public function print($idPenjualan)
    {
        $penjualan = $this->penjualanModel->penjualanUser($idPenjualan);
        $penjualanDetail = $this->penjualanDetailModel->detailPenjualanProduk($idPenjualan);

        $data = [
            'title' => 'Invoice ' . $penjualan['id_penjualan'],
            'penjualan' => $penjualan,
            'detail' => $penjualanDetail
        ];
        return view('admin/penjualan/print', $data);
    }
}
