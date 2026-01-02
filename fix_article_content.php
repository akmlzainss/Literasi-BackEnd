<?php

use App\Models\Artikel;

$articles = [
    [
        'judul' => 'Revolusi Industri 4.0: Peluang dan Tantangan untuk Generasi Milenial',
        'konten' => 'Industri 4.0 membawa perubahan fundamental dalam cara kita bekerja dan hidup. Dengan teknologi seperti IoT, AI, dan big data, dunia memasuki era digital yang penuh peluang.',
    ],
    [
        'judul' => 'Pentingnya Literasi Digital di Era Modern',
        'konten' => 'Literasi digital menjadi keterampilan kunci yang harus dikuasai setiap individu. Tanpa literasi digital, kita akan tertinggal dalam perkembangan zaman.',
    ],
    [
        'judul' => 'Manfaat Olahraga untuk Kesehatan Mental',
        'konten' => 'Olahraga tidak hanya baik untuk kesehatan fisik, tetapi juga sangat beneficial untuk kesehatan mental. Endorphin yang dihasilkan saat olahraga dapat meningkatkan mood.',
    ],
    [
        'judul' => 'Masa Depan Energi Terbarukan di Indonesia',
        'konten' => 'Indonesia memiliki potensi besar dalam pengembangan energi terbarukan seperti surya, angin, dan geothermal. Kebijakan pemerintah harus mendukung transformasi ini.',
    ],
    [
        'judul' => 'Peran Teknologi dalam Pendidikan Masa Depan',
        'konten' => 'Teknologi mengubah lanskap pendidikan secara drastis. Dari pembelajaran online hingga VR dalam kelas, inovasi teknologi membuka peluang baru.',
    ],
    [
        'judul' => 'Dampak Media Sosial terhadap Remaja',
        'konten' => 'Media sosial memiliki dampak positif dan negatif terhadap perkembangan remaja. Perlu kewaspadaan dalam penggunaan untuk menghindari dampak negatif.',
    ],
    [
        'judul' => 'Inovasi Kuliner Indonesia di Kancah Internasional',
        'konten' => 'Kuliner Indonesia semakin populer di dunia internasional. Dari rendang hingga gado-gado, cita rasa Indonesia memikat lidah dunia.',
    ],
    [
        'judul' => 'Strategi Belajar Efektif di Era Digital',
        'konten' => 'Dengan perkembangan teknologi, cara belajar juga harus beradaptasi. Platform digital, video pembelajaran, dan aplikasi educativo menjadi tools penting.',
    ],
    [
        'judul' => 'Kritik terhadap Sistem Pendidikan Indonesia',
        'konten' => 'Sistem pendidikan Indonesia perlu reformasi menyeluruh untuk menjawab tantangan masa depan.',
    ],
    [
        'judul' => 'Perbandingan Ekonomi Indonesia vs Negara Lain',
        'konten' => 'Analisis mendalam tentang performa ekonomi Indonesia dibandingkan dengan negara ASEAN lainnya.',
    ],
];

echo "Mulai memperbaiki konten artikel...\n";

foreach ($articles as $data) {
    $artikel = Artikel::where('judul', $data['judul'])->first();
    if ($artikel) {
        $artikel->isi = $data['konten'];
        $artikel->save();
        echo "✅ Artikel '{$data['judul']}' berhasil diperbarui.\n";
    } else {
        echo "⚠️ Artikel '{$data['judul']}' tidak ditemukan.\n";
    }
}

echo "Selesai.\n";
