<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id';
    public $timestamps = false; // Table tidak punya updated_at

    protected $fillable = [
        'id_siswa',
        'id_admin',
        'judul',
        'pesan',
        'jenis',
        'referensi_tipe',
        'referensi_id',
        'sudah_dibaca'
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope untuk notifikasi yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('sudah_dibaca', false);
    }

    // Scope untuk notifikasi hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Accessor untuk format waktu yang user-friendly
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // Accessor untuk icon berdasarkan jenis
    public function getIconAttribute()
    {
        $icons = [
            'artikel_disetujui' => 'fas fa-check-circle text-success',
            'artikel_ditolak' => 'fas fa-times-circle text-danger',
            'komentar_baru' => 'fas fa-comment text-primary',
            'penghargaan' => 'fas fa-trophy text-warning',
            'video_disetujui' => 'fas fa-video text-success',
            'video_ditolak' => 'fas fa-video text-danger',
            'sistem' => 'fas fa-cog text-info',
        ];

        return $icons[$this->jenis] ?? 'fas fa-bell text-secondary';
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    // Helper method untuk membuat notifikasi
    public static function createNotification($siswaId, $judul, $pesan, $jenis, $referensiTipe = null, $referensiId = null, $adminId = null)
    {
        return self::create([
            'id_siswa' => $siswaId,
            'id_admin' => $adminId,
            'judul' => $judul,
            'pesan' => $pesan,
            'jenis' => $jenis,
            'referensi_tipe' => $referensiTipe,
            'referensi_id' => $referensiId,
            'sudah_dibaca' => false,
        ]);
    }
}
