<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        if (session()->get('level') != "Admin") {
            session()->setflashdata('failed', 'Maaf, hanya admin yang dapat mengakses fitur ini!');
            return redirect()->to(base_url('dashboard'));
        }

        $currentpage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $keyword = $this->request->getVar('keyword');
        $user = $this->usersModel;
        $data = [
            'title' => 'Data Admin',
            'user'  => $user->paginate(10, 'user'),
            'pager' => $this->usersModel->pager,
            'act'   => ['users', ''],
            'currentPage' => $currentpage,
            'keyword' => $keyword,
        ];
        return view('admin/users/index', $data);
    }

    public function pencarian()
    {
        $keyword = $this->request->getVar('keyword');
        return redirect()->to(base_url('/users/search/' . $keyword))->withInput();
    }

    public function cari($keyword)
    {
        if (session()->get('level') != "Admin") {
            session()->setflashdata('failed', 'Maaf, hanya admin yang dapat mengakses fitur ini!');
            return redirect()->to(base_url('dashboard'));
        }

        $currentpage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $user = $this->usersModel->cari($keyword);
        $data = [
            'title' => 'Data Admin',
            'user'  => $user->paginate(10, 'user'),
            'pager' => $this->usersModel->pager,
            'act'   => ['users', ''],
            'currentPage' => $currentpage,
            'keyword' => $keyword,
        ];
        return view('admin/users/index', $data);
    }

    public function detail($idUser)
    {
        if (session()->get('level') != "Admin") {
            session()->setflashdata('failed', 'Maaf, hanya admin yang dapat mengakses fitur ini!');
            return redirect()->to(base_url('dashboard'));
        }

        $user = $this->usersModel->find($idUser);

        if (empty($user)) {
            session()->setflashdata('failed', 'Oops... Data tidak ditemukan. Silahkan pilih data.');
            return redirect()->to(base_url('/users'))->withInput();
        }

        $data = [
            'title' => 'Detail Admin',
            'user' => $user,
            'act'   => ['users', ''],
        ];
        return view('admin/users/detail', $data);
    }

    public function tambah()
    {
        if (session()->get('level') != "Admin") {
            session()->setflashdata('failed', 'Maaf, hanya admin yang dapat mengakses fitur ini!');
            return redirect()->to(base_url('dashboard'));
        }

        $data = [
            'title' => 'Tambah Admin',
            'act'   => ['users', ''],
            'validation' => \Config\Services::validation()
        ];
        return view('admin/users/add', $data);
    }

    public function simpan()
    {
        if (!$this->validate([
            'nm_user' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi!',
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Nama Lengkap wajib diisi!',
                    'is_unique' => 'Usename sudah digunakan!'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi!'
                ]
            ],
            'level' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Level wajib diisi!'
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status wajib diisi!'
                ]
            ],
        ])) {
            return redirect()->to(base_url('/users/add'))->withInput();
        }

        $idUser = $this->usersModel->kodegen();
        $password = $this->request->getVar('password');
        $pwHash = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'id_user' => $idUser,
            'nm_user' => $this->request->getVar('nm_user'),
            'password' => $pwHash,
            'username' => $this->request->getVar('username'),
            'level' => $this->request->getVar('level'),
            'status' => $this->request->getVar('status'),
        ];

        $this->db->transStart();
        $this->usersModel->insert($data);
        $this->db->transComplete();

        if ($this->db->transStatus() == false) {
            session()->setflashdata('failed', 'Data admin gagal ditambah.');
            return redirect()->to(base_url('users/add'));
        } elseif ($this->db->transStatus() == true) {
            session()->setflashdata('success', 'Data admin berhasil ditambah.');
            return redirect()->to(base_url('users'));
        }
    }

    public function ubah($idUser)
    {
        if (session()->get('level') != "Admin") {
            session()->setflashdata('failed', 'Maaf, hanya admin yang dapat mengakses fitur ini!');
            return redirect()->to(base_url('dashboard'));
        }

        $user = $this->usersModel->find($idUser);
        if (empty($user)) {
            session()->setflashdata('failed', 'Oops... Data tidak ditemukan. Silahkan pilih data.');
            return redirect()->to(base_url('/users'))->withInput();
        }

        $data = [
            'title' => 'Edit Admin',
            'user'  => $user,
            'act'   => ['users', ''],
            'validation' => \Config\Services::validation()
        ];
        return view('admin/users/edit', $data);
    }

    public function ubah_data($idUser)
    {
        if (!$this->validate([
            'nm_user' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi!',
                ]
            ],
            'level' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Level wajib diisi!'
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status wajib diisi!'
                ]
            ],
        ])) {
            return redirect()->to(base_url('/users/edit/' . $idUser))->withInput();
        }

        $user = $this->usersModel->find($idUser);
        $password = $this->request->getVar('password');

        if (empty($password)) {
            $data = [
                'id_user' => $user['id_user'],
                'nm_user' => $this->request->getVar('nm_user'),
                'level' => $this->request->getVar('level'),
                'status' => $this->request->getVar('status'),
            ];
        } else {
            $pwHash = password_hash($password, PASSWORD_DEFAULT);
            $data = [
                'id_user' => $user['id_user'],
                'nm_user' => $this->request->getVar('nm_user'),
                'password' => $pwHash,
                'level' => $this->request->getVar('level'),
                'status' => $this->request->getVar('status'),
            ];
        }

        $this->db->transStart();
        $this->usersModel->update($user['id_user'], $data);
        $this->db->transComplete();

        if ($this->db->transStatus() == false) {
            session()->setflashdata('failed', 'Data admin gagal diubah.');
            return redirect()->to(base_url('users'));
        } elseif ($this->db->transStatus() == true) {
            session()->setflashdata('success', 'Data admin berhasil diubah.');
            return redirect()->to(base_url('users/' . $user['id_user']));
        }
    }
}
