<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // View profile
    public function index()
    {
        $id_user = session()->get('id_user');
        $user    = $this->userModel->find($id_user);

        return view('profile/index', ['user' => $user]);
    }

    // Form edit profile
    public function edit()
    {
        $id_user = session()->get('id_user');
        $user    = $this->userModel->find($id_user);

        return view('profile/edit', ['user' => $user]);
    }

    // Proses update profile
    public function update()
    {
        $id_user = session()->get('id_user');

        $rules = [
            'nama'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[tabel_users.email,id_user,{$id_user}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $dataUpdate = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
        ];

        // Update password hanya kalau diisi
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            if (strlen($newPassword) < 6) {
                return redirect()->back()
                                 ->withInput()
                                 ->with('errors', ['password' => 'Password minimal 6 karakter.']);
            }
            $dataUpdate['password'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id_user, $dataUpdate);

        // Update session nama
        session()->set('nama', $dataUpdate['nama']);

        return redirect()->to('/profile')->with('success', 'Profile berhasil diupdate!');
    }
}