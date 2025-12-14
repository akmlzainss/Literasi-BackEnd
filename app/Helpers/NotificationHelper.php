<?php

namespace App\Helpers;

use App\Models\Notifikasi;

class NotificationHelper
{
    /**
     * Buat notifikasi untuk artikel disetujui
     */
    public static function artikelDisetujui($siswaId, $judulArtikel, $adminId = null)
    {
        return Notifikasi::createNotification(
            $siswaId,
            'Artikel Disetujui! 🎉',
            "Selamat! Artikel Anda '{$judulArtikel}' telah disetujui dan dipublikasikan.",
            'artikel_disetujui',
            'artikel',
            null,
            $adminId
        );
    }

    /**
     * Buat notifikasi untuk artikel ditolak
     */
    public static function artikelDitolak($siswaId, $judulArtikel, $alasan, $adminId = null)
    {
        return Notifikasi::createNotification(
            $siswaId,
            'Artikel Perlu Diperbaiki',
            "Artikel Anda '{$judulArtikel}' perlu diperbaiki. Alasan: {$alasan}",
            'artikel_ditolak',
            'artikel',
            null,
            $adminId
        );
    }

    /**
     * Buat notifikasi untuk komentar baru
     */
    public static function komentarBaru($siswaId, $judulArtikel, $namaKomentator)
    {
        return Notifikasi::createNotification(
            $siswaId,
            'Komentar Baru! 💬',
            "{$namaKomentator} memberikan komentar pada artikel '{$judulArtikel}'",
            'komentar_baru',
            'artikel',
            null
        );
    }

    /**
     * Buat notifikasi untuk penghargaan
     */
    public static function penghargaan($siswaId, $jenisPenghargaan, $adminId = null)
    {
        return Notifikasi::createNotification(
            $siswaId,
            'Selamat! Anda Mendapat Penghargaan! 🏆',
            "Anda telah menerima penghargaan '{$jenisPenghargaan}' atas kontribusi Anda!",
            'penghargaan',
            'penghargaan',
            null,
            $adminId
        );
    }

    /**
     * Buat notifikasi untuk video disetujui
     */
    public static function videoDisetujui($siswaId, $judulVideo, $adminId = null)
    {
        return Notifikasi::createNotification(
            $siswaId,
            'Video Disetujui! 🎬',
            "Video Anda '{$judulVideo}' telah disetujui dan dipublikasikan.",
            'video_disetujui',
            'video',
            null,
            $adminId
        );
    }

    /**
     * Buat notifikasi untuk video ditolak
     */
    public static function videoDitolak($siswaId, $judulVideo, $alasan, $adminId = null)
    {
        return Notifikasi::createNotification(
            $siswaId,
            'Video Perlu Diperbaiki',
            "Video Anda '{$judulVideo}' perlu diperbaiki. Alasan: {$alasan}",
            'video_ditolak',
            'video',
            null,
            $adminId
        );
    }

    /**
     * Buat notifikasi sistem
     */
    public static function sistemNotifikasi($siswaId, $judul, $pesan, $adminId = null)
    {
        return Notifikasi::createNotification(
            $siswaId,
            $judul,
            $pesan,
            'sistem',
            null,
            null,
            $adminId
        );
    }

    /**
     * Buat notifikasi untuk semua siswa aktif
     */
    public static function broadcastToAllStudents($judul, $pesan, $jenis = 'sistem', $adminId = null)
    {
        $siswaAktif = \App\Models\Siswa::where('status_aktif', true)->pluck('id');

        foreach ($siswaAktif as $siswaId) {
            Notifikasi::createNotification(
                $siswaId,
                $judul,
                $pesan,
                $jenis,
                null,
                null,
                $adminId
            );
        }

        return $siswaAktif->count();
    }

    /**
     * Buat notifikasi reminder untuk siswa yang belum aktif
     */
    public static function reminderAktivitas($siswaId)
    {
        $siswa = \App\Models\Siswa::find($siswaId);
        if (!$siswa) return false;

        $artikelCount = \App\Models\Artikel::where('id_siswa', $siswaId)->count();

        if ($artikelCount == 0) {
            return self::sistemNotifikasi(
                $siswaId,
                'Yuk Mulai Menulis! ✍️',
                'Hai ' . $siswa->nama . '! Ayo mulai berbagi pengetahuan dengan menulis artikel pertama Anda di SIPENA.'
            );
        }

        return false;
    }
}
