<?php

namespace App\Http\Controllers;

use App\Exports\BackupAllExport;
use Maatwebsite\Excel\Facades\Excel;

class BackupController extends Controller
{
    public function index()
    {
        return view('backup.index'); // halaman tombol backup
    }

    public function backupAll()
    {
        return Excel::download(new BackupAllExport, 'backup_semua_data.xlsx');
    }
}
