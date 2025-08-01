<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Logic to display laporan list
        return view('laporan.laporan');
    }
}