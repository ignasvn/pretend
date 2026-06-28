<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'nama' => session()->get('nama'),
            'role' => session()->get('role'),
        ];

        return view('dashboard/index', $data);
    }
}
