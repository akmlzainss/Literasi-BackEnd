<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        // Logic to display pengaturan page
        return view('pengaturan.pengaturan');
    }
}