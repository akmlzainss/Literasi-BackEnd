<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexSiswa()
    {
        // Logika untuk dashboard siswa (misalnya, ambil data siswa atau artikel trending)
        return view('web_siswa.dashboard');
    }
}