<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BackupAllExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Artikel' => new class implements FromCollection, WithHeadings, WithStyles {
                public function collection() {
                    return DB::table('artikel')->select(
                        'id',
                        'id_siswa',
                        'id_kategori',
                        'judul',
                        'gambar',
                        'isi',
                        'penulis_type',
                        'jenis',
                        'status',
                        'alasan_penolakan',
                        'diterbitkan_pada',
                        'updated_at',
                        'jumlah_dilihat',
                        'jumlah_suka',
                        'nilai_rata_rata',
                        'riwayat_persetujuan',
                        'usulan_kategori',
                        'created_at',
                        'deleted_at'
                    )->get();
                }

                public function headings(): array {
                    return [
                        'ID',
                        'ID Siswa',
                        'ID Kategori',
                        'Judul',
                        'Gambar',
                        'Isi',
                        'Penulis Type',
                        'Jenis',
                        'Status',
                        'Alasan Penolakan',
                        'Diterbitkan Pada',
                        'Updated At',
                        'Jumlah Dilihat',
                        'Jumlah Suka',
                        'Nilai Rata-rata',
                        'Riwayat Persetujuan',
                        'Usulan Kategori',
                        'Created At',
                        'Deleted At'
                    ];
                }

                public function styles(Worksheet $sheet) {
                    $sheet->getStyle('A1:S1')->getFont()->setBold(true);
                    foreach(range('A','S') as $col) {
                        $sheet->getColumnDimension($col)->setAutoSize(true);
                    }
                }
            },

            'Kategori' => new class implements FromCollection, WithHeadings, WithStyles {
                public function collection() {
                    return DB::table('kategori')->select(
                        'id',
                        'nama',
                        'deskripsi',
                        'dibuat_pada',
                        'deleted_at'
                    )->get();
                }

                public function headings(): array {
                    return ['ID', 'Nama', 'Deskripsi', 'Dibuat Pada', 'Deleted At'];
                }

                public function styles(Worksheet $sheet) {
                    $sheet->getStyle('A1:E1')->getFont()->setBold(true);
                    foreach(range('A','E') as $col) {
                        $sheet->getColumnDimension($col)->setAutoSize(true);
                    }
                }
            },

            'Siswa' => new class implements FromCollection, WithHeadings, WithStyles {
                public function collection() {
                    return DB::table('siswa')->select(
                        'id',
                        'nis',
                        'nama',
                        'email',
                        'password',
                        'kelas',
                        'status_aktif',
                        'created_at',
                        'updated_at',
                        'deleted_at'
                    )->get();
                }

                public function headings(): array {
                    return [
                        'ID',
                        'NIS',
                        'Nama Lengkap',
                        'Email',
                        'Password',
                        'Kelas',
                        'Status Aktif',
                        'Created At',
                        'Updated At',
                        'Deleted At'
                    ];
                }

                public function styles(Worksheet $sheet) {
                    $sheet->getStyle('A1:J1')->getFont()->setBold(true);
                    foreach(range('A','J') as $col) {
                        $sheet->getColumnDimension($col)->setAutoSize(true);
                    }
                }
            },

            'Penghargaan' => new class implements FromCollection, WithHeadings, WithStyles {
                public function collection() {
                    return DB::table('penghargaan')->select(
                        'id',
                        'id_artikel',
                        'id_siswa',
                        'id_admin',
                        'jenis',
                        'bulan_tahun',
                        'deskripsi_penghargaan',
                        'dibuat_pada',
                        'deleted_at'
                    )->get();
                }

                public function headings(): array {
                    return [
                        'ID',
                        'ID Artikel',
                        'ID Siswa',
                        'ID Admin',
                        'Jenis',
                        'Bulan/Tahun',
                        'Deskripsi Penghargaan',
                        'Dibuat Pada',
                        'Deleted At'
                    ];
                }

                public function styles(Worksheet $sheet) {
                    $sheet->getStyle('A1:I1')->getFont()->setBold(true);
                    foreach(range('A','I') as $col) {
                        $sheet->getColumnDimension($col)->setAutoSize(true);
                    }
                }
            },
        ];
    }
}
