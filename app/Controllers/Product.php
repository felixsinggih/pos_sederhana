<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Product extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $currentpage = $this->request->getVar('page_product') ? $this->request->getVar('page_product') : 1;
        $product = $this->productModel;
        $keyword = $this->request->getVar('keyword');
        $data = [
            'title' => 'Data Produk',
            'product'  => $product->paginate(25, 'product'),
            'pager' => $this->productModel->pager,
            'act'   => ['product', ''],
            'currentPage' => $currentpage,
            'keyword' => $keyword,
        ];
        return view('admin/product/index', $data);
    }

    public function pencarian()
    {
        $keyword = $this->request->getVar('keyword');
        return redirect()->to(base_url('/product/search/' . $keyword))->withInput();
    }

    public function cari($keyword)
    {
        $currentpage = $this->request->getVar('page_product') ? $this->request->getVar('page_product') : 1;
        $product = $this->productModel->cari($keyword);
        $data = [
            'title' => 'Data Produk',
            'product'  => $product->paginate(25, 'product'),
            'pager' => $this->productModel->pager,
            'act'   => ['product', ''],
            'currentPage' => $currentpage,
            'keyword' => $keyword,
        ];
        return view('admin/product/index', $data);
    }

    public function detail($barcode)
    {
        $product = $this->productModel->find($barcode);

        if (empty($product)) {
            session()->setflashdata('failed', 'Oops... Data tidak ditemukan. Silahkan pilih data.');
            return redirect()->to(base_url('/product'))->withInput();
        }

        $data = [
            'title' => 'Detail Produk',
            'product' => $product,
            'act'   => ['product', ''],
        ];
        return view('admin/product/detail', $data);
    }

    public function tambah()
    {
        if (session()->get('level') != "Admin") {
            session()->setflashdata('failed', 'Maaf, hanya admin yang dapat mengakses fitur ini!');
            return redirect()->to(base_url('product'));
        }

        $data = [
            'title' => 'Tambah Produk',
            'act'   => ['product', ''],
            'validation' => \Config\Services::validation()
        ];
        return view('admin/product/add', $data);
    }

    public function simpan()
    {
        if (!$this->validate([
            'barcode' => [
                'rules' => 'required|is_unique[produk.barcode]',
                'errors' => [
                    'required' => 'Barcode wajib diisi!',
                    'is_unique' => 'Barcode sudah digunakan!'
                ]
            ],
            'nm_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk wajib diisi!',
                ]
            ],
            'harga_jual' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga jual wajib diisi!'
                ]
            ],
        ])) {
            return redirect()->to(base_url('/product/add'))->withInput();
        }

        $data = [
            'barcode' => $this->request->getVar('barcode'),
            'nm_produk' => $this->request->getVar('nm_produk'),
            'harga_jual' => $this->request->getVar('harga_jual'),
            'keterangan' => $this->request->getVar('keterangan'),
        ];

        $this->db->transStart();
        $this->productModel->insert($data);
        $this->db->transComplete();

        if ($this->db->transStatus() == false) {
            session()->setflashdata('failed', 'Produk gagal ditambah.');
            return redirect()->to(base_url('product/add'));
        } elseif ($this->db->transStatus() == true) {
            session()->setflashdata('success', 'Produk berhasil ditambah.');
            return redirect()->to(base_url('product'));
        }
    }

    public function ubah($barcode)
    {
        if (session()->get('level') != "Admin") {
            session()->setflashdata('failed', 'Maaf, hanya admin yang dapat mengakses fitur ini!');
            return redirect()->to(base_url('product'));
        }

        $product = $this->productModel->find($barcode);
        if (empty($product)) {
            session()->setflashdata('failed', 'Oops... Data tidak ditemukan. Silahkan pilih data.');
            return redirect()->to(base_url('/product'))->withInput();
        }

        $data = [
            'title' => 'Edit Produk',
            'product'  => $product,
            'act'   => ['product', ''],
            'validation' => \Config\Services::validation()
        ];
        return view('admin/product/edit', $data);
    }

    public function ubah_data($barcode)
    {
        if (!$this->validate([
            'nm_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk wajib diisi!'
                ]
            ],
            'harga_jual' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga jual wajib diisi!'
                ]
            ],
        ])) {
            return redirect()->to(base_url('/product/edit/' . $barcode))->withInput();
        }

        $product = $this->productModel->find($barcode);

        $data = [
            'barcode' => $product['barcode'],
            'nm_produk' => $this->request->getVar('nm_produk'),
            'harga_jual' => $this->request->getVar('harga_jual'),
            'keterangan' => $this->request->getVar('keterangan'),
        ];

        $this->db->transStart();
        $this->productModel->update($product['barcode'], $data);
        $this->db->transComplete();

        if ($this->db->transStatus() == false) {
            session()->setflashdata('failed', 'Data produk gagal diubah.');
            return redirect()->to(base_url('product'));
        } elseif ($this->db->transStatus() == true) {
            session()->setflashdata('success', 'Data produk berhasil diubah.');
            return redirect()->to(base_url('product/' . $data['barcode']));
        }
    }
}
