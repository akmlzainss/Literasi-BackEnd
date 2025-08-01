<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaSiswaController extends Controller
{
    public function index()
    {
        // Logic to display siswa list
        return view('siswa.siswa');
    }
}