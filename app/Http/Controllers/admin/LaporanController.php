<?php

use App\Http\Controllers\Controller;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Logic to display laporan list
        return view('admin.laporan.laporan');
    }
}
