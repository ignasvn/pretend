<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\UserModel;

class JadwalController extends BaseController
{
    protected $kelasModel;
    protected $userModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->userModel  = new UserModel();
    }

    // Cek role — hanya admin & dosen
    private function checkAccess()
    {
        if (!in_array(session()->get('role'), ['admin', 'dosen'])) {
            return redirect()->to('/dashboard');
        }
        return null;
    }

    // READ
    public function index()
    {
        if ($redirect = $this->checkAccess()) return $redirect;

        $data = [
            'kelas' => $this->kelasModel->getAllKelas(),
        ];

        return view('jadwal/index', $data);
    }

    // CREATE — form
    public function create()
    {
        if ($redirect = $this->checkAccess()) return $redirect;

        $data = [
            'dosen' => $this->userModel->getAllUsers('dosen'),
        ];

        return view('jadwal/create', $data);
    }

    // CREATE — proses
    public function store()
    {
        if ($redirect = $this->checkAccess()) return $redirect;

        $rules = [
            'nama_kelas'  => 'required|min_length[3]',
            'id_dosen'    => 'required|integer',
            'tanggal'        => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->insert([
            'nama_kelas'  => $this->request->getPost('nama_kelas'),
            'id_dosen'    => $this->request->getPost('id_dosen'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'jam_mulai'   => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/jadwal')->with('success', 'Kelas berhasil ditambahkan!');
    }

    // UPDATE — form
    public function edit(int $id)
    {
        if ($redirect = $this->checkAccess()) return $redirect;

        $kelas = $this->kelasModel->getKelasById($id);

        if (!$kelas) {
            return redirect()->to('/jadwal')->with('error', 'Kelas tidak ditemukan.');
        }

        $data = [
            'kelas' => $kelas,
            'dosen' => $this->userModel->getAllUsers('dosen'),
        ];

        return view('jadwal/edit', $data);
    }

    // UPDATE — proses
    public function update(int $id)
    {
        if ($redirect = $this->checkAccess()) return $redirect;

        $rules = [
            'nama_kelas'  => 'required|min_length[3]',
            'id_dosen'    => 'required|integer',
            'tanggal'        => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->update($id, [
            'nama_kelas'  => $this->request->getPost('nama_kelas'),
            'id_dosen'    => $this->request->getPost('id_dosen'),
            'tanggal'        => $this->request->getPost('tanggal'),
            'jam_mulai'   => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
        ]);

        return redirect()->to('/jadwal')->with('success', 'Kelas berhasil diupdate!');
    }

    // DELETE
    public function delete(int $id)
    {
        if ($redirect = $this->checkAccess()) return $redirect;

        $this->kelasModel->delete($id);

        return redirect()->to('/jadwal')->with('success', 'Kelas berhasil dihapus!');
    }
}