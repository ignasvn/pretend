<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    // READ — tampilkan daftar user
    public function index()
    {
        // Cek role, hanya admin yang boleh akses
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'users' => $this->model->getAllUsers(),
        ];

        return view('users/index', $data);
    }

    // CREATE — tampilkan form tambah
    public function create()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        return view('users/create');
    }

    // CREATE — proses simpan data baru
    public function store()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        // Validasi input
        $rules = [
            'nama'     => 'required|min_length[3]',
            'username' => 'required|min_length[3]|is_unique[tabel_users.username]',
            'email'    => 'required|valid_email|is_unique[tabel_users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,dosen,mahasiswa]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        // Simpan ke database
        $this->model->insert([
            'nama'       => $this->request->getPost('nama'),
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'       => $this->request->getPost('role'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan!');
    }

    // UPDATE — tampilkan form edit
    public function edit(int $id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $user = $this->model->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        return view('users/edit', ['user' => $user]);
    }

    // UPDATE — proses update data
    public function update(int $id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'nama'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[tabel_users.email,id_user,{$id}]",
            'role'  => 'required|in_list[admin,dosen,mahasiswa]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $dataUpdate = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role'),
        ];

        // Update password hanya kalau diisi
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $dataUpdate['password'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        $this->model->update($id, $dataUpdate);

        return redirect()->to('/users')->with('success', 'User berhasil diupdate!');
    }

    // DELETE — hapus user
    public function delete(int $id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        // Cegah admin hapus dirinya sendiri
        if ($id === (int) session()->get('id_user')) {
            return redirect()->to('/users')->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $this->model->delete($id);

        return redirect()->to('/users')->with('success', 'User berhasil dihapus!');
    }
}