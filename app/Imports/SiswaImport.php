<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Siswa([
            'nis'      => $row['nis'],            // sesuai header di Excel
            'nama'     => $row['nama_lengkap'],   // hati-hati spasi!
            'email'    => $row['email'],
            'password' => $row['password'],
            'kelas'    => $row['kelas'],
        ]);
    }
}
