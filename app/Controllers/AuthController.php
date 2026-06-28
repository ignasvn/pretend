<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    // GET /login -> tampilkan form
    public function index()
    {
        if(session()->get('isLoggedIn')){
            return redirect()->to('/dashboard');
        }
        return view('auth/index');
    }

    // POST /login -> proses form
    public function login()
    {
        $input = $this->request->getPost('username'); // bisa username atau email
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->findByUsernameOrEmail($input);

        // Cek 1: User ketemu di database?
        if(!$user){
            return redirect()->back()->with('error', 'Username atau email tidak ditemukan.');
        }
        
        // Cek 2: Password cocok? (bandingkan input dengan hash di DB)
        if(!password_verify($password, $user['password'])){
            return redirect()->back()->with('error', 'Password salah.');
        }

        // SUKSES -> simpan data ke Session
        $sessionData = [
            'id_user' => $user['id_user'],
            'nama' => $user['nama'],
            'role' => $user['role'],
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);

        // Redirect berdasarkan Role
        return redirect()->to('/dashboard');
    }

    // GET /logout -> hapus session
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/index');
    }

}
