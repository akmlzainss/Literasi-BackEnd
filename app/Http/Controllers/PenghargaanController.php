<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenghargaanController extends Controller
{
    public function index()
    {
        // Logic to display penghargaan list
        return view('penghargaan.penghargaan');
    }
}