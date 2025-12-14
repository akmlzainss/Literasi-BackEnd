<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\Siswa;
use App\Models\Kategori;
use App\Models\RatingArtikel;
use App\Models\InteraksiArtikel;
use Illuminate\Support\Facades\Hash;

class ArtikelSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "🚀 Starting Artikel Seeder...\n";

        // 1. Buat Kategori terlebih dahulu
        echo "📁 Creating categories...\n";
        $this->createCategories();

        // 2. Buat Siswa (jika belum ada)
        echo "👥 Creating students...\n";
        $this->createStudents();

        // 3. Buat Artikel dengan berbagai status
        echo "📝 Creating articles...\n";
        $this->createArticles();

        // 4. Buat Rating dan Interaksi
        echo "⭐ Creating ratings and interactions...\n";
        $this->createRatingsAndInteractions();

        echo "✅ Seeder completed successfully!\n";
    }

    private function createCategories()
    {
        $categories = [
            'Teknologi',
            'Pendidikan',
            'Olahraga',
            'Kesehatan',
            'Hiburan',
            'Lifestyle',
            'Budaya',
            'Ekonomi',
            'Politik',
            'Sains'
        ];

        foreach ($categories as $category) {
            Kategori::firstOrCreate(['nama' => $category]);
            echo "  ✓ Created category: $category\n";
        }
    }

    private function createStudents()
    {
        $students = [
            [
                'nis' => '2023001',
                'nama' => 'Ahmad Rizki',
                'kelas' => 'XII IPA 1',
                'email' => 'ahmad.rizki@student.sch.id',
                'password' => Hash::make('password123'),
                'status_aktif' => true,
                'foto_profil' => null
            ],
            [
                'nis' => '2023002',
                'nama' => 'Sari Indrawati',
                'kelas' => 'XII IPS 1',
                'email' => 'sari.indrawati@student.sch.id',
                'password' => Hash::make('password123'),
                'status_aktif' => true,
                'foto_profil' => null
            ],
            [
                'nis' => '2023003',
                'nama' => 'Budi Santoso',
                'kelas' => 'XI IPA 2',
                'email' => 'budi.santoso@student.sch.id',
                'password' => Hash::make('password123'),
                'status_aktif' => true,
                'foto_profil' => null
            ],
            [
                'nis' => '2023004',
                'nama' => 'Dewi Lestari',
                'kelas' => 'XII IPA 2',
                'email' => 'dewi.lestari@student.sch.id',
                'password' => Hash::make('password123'),
                'status_aktif' => true,
                'foto_profil' => null
            ],
            [
                'nis' => '2023005',
                'nama' => 'Eko Prasetyo',
                'kelas' => 'XI IPS 1',
                'email' => 'eko.prasetyo@student.sch.id',
                'password' => Hash::make('password123'),
                'status_aktif' => true,
                'foto_profil' => null
            ],
        ];

        foreach ($students as $student) {
            try {
                $siswa = Siswa::firstOrCreate(
                    ['email' => $student['email']],
                    $student
                );
                echo "  ✓ Created student: {$siswa->nama} (NIS: {$siswa->nis})\n";
            } catch (\Exception $e) {
                echo "  ❌ Error creating student {$student['nama']}: " . $e->getMessage() . "\n";
            }
        }
    }

    private function createArticles()
    {
        $articles = [
            // Artikel Published (Disetujui)
            [
                'judul' => 'Revolusi Industri 4.0: Peluang dan Tantangan untuk Generasi Milenial',
                'konten' => 'Industri 4.0 membawa perubahan fundamental dalam cara kita bekerja dan hidup. Dengan teknologi seperti IoT, AI, dan big data, dunia memasuki era digital yang penuh peluang.',
                'status' => 'disetujui',
                'kategori' => 'Teknologi',
                'siswa' => 'Ahmad Rizki',
                'views' => 1250,
                'likes' => 89,
                'published_at' => now()->subDays(5)
            ],
            [
                'judul' => 'Pentingnya Literasi Digital di Era Modern',
                'konten' => 'Literasi digital menjadi keterampilan kunci yang harus dikuasai setiap individu. Tanpa literasi digital, kita akan tertinggal dalam perkembangan zaman.',
                'status' => 'disetujui',
                'kategori' => 'Pendidikan',
                'siswa' => 'Sari Indrawati',
                'views' => 890,
                'likes' => 67,
                'published_at' => now()->subDays(3)
            ],
            [
                'judul' => 'Manfaat Olahraga untuk Kesehatan Mental',
                'konten' => 'Olahraga tidak hanya baik untuk kesehatan fisik, tetapi juga sangat beneficial untuk kesehatan mental. Endorphin yang dihasilkan saat olahraga dapat meningkatkan mood.',
                'status' => 'disetujui',
                'kategori' => 'Kesehatan',
                'siswa' => 'Budi Santoso',
                'views' => 654,
                'likes' => 45,
                'published_at' => now()->subDays(2)
            ],
            [
                'judul' => 'Masa Depan Energi Terbarukan di Indonesia',
                'konten' => 'Indonesia memiliki potensi besar dalam pengembangan energi terbarukan seperti surya, angin, dan geothermal. Kebijakan pemerintah harus mendukung transformasi ini.',
                'status' => 'disetujui',
                'kategori' => 'Sains',
                'siswa' => 'Dewi Lestari',
                'views' => 432,
                'likes' => 38,
                'published_at' => now()->subDays(1)
            ],
            [
                'judul' => 'Peran Teknologi dalam Pendidikan Masa Depan',
                'konten' => 'Teknologi mengubah lanskap pendidikan secara drastis. Dari pembelajaran online hingga VR dalam kelas, inovasi teknologi membuka peluang baru.',
                'status' => 'disetujui',
                'kategori' => 'Pendidikan',
                'siswa' => 'Eko Prasetyo',
                'views' => 567,
                'likes' => 42,
                'published_at' => now()
            ],

            // Artikel Draft
            [
                'judul' => 'Dampak Media Sosial terhadap Remaja',
                'konten' => 'Media sosial memiliki dampak positif dan negatif terhadap perkembangan remaja. Perlu kewaspadaan dalam penggunaan untuk menghindari dampak negatif.',
                'status' => 'draf',
                'kategori' => 'Lifestyle',
                'siswa' => 'Ahmad Rizki',
                'views' => 0,
                'likes' => 0,
                'published_at' => null
            ],
            [
                'judul' => 'Inovasi Kuliner Indonesia di Kancah Internasional',
                'konten' => 'Kuliner Indonesia semakin populer di dunia internasional. Dari rendang hingga gado-gado, cita rasa Indonesia memikat lidah dunia.',
                'status' => 'draf',
                'kategori' => 'Budaya',
                'siswa' => 'Sari Indrawati',
                'views' => 0,
                'likes' => 0,
                'published_at' => null
            ],
            [
                'judul' => 'Strategi Belajar Efektif di Era Digital',
                'konten' => 'Dengan perkembangan teknologi, cara belajar juga harus beradaptasi. Platform digital, video pembelajaran, dan aplikasi educativo menjadi tools penting.',
                'status' => 'draf',
                'kategori' => 'Pendidikan',
                'siswa' => 'Budi Santoso',
                'views' => 0,
                'likes' => 0,
                'published_at' => null
            ],

            // Artikel Ditolak
            [
                'judul' => 'Kritik terhadap Sistem Pendidikan Indonesia',
                'konten' => 'Sistem pendidikan Indonesia perlu reformasi menyeluruh untuk menjawab tantangan masa depan.',
                'status' => 'ditolak',
                'kategori' => 'Pendidikan',
                'siswa' => 'Dewi Lestari',
                'views' => 0,
                'likes' => 0,
                'published_at' => null,
                'rejection_reason' => 'Konten terlalu umum dan tidak memberikan solusi konstruktif'
            ],
            [
                'judul' => 'Perbandingan Ekonomi Indonesia vs Negara Lain',
                'konten' => 'Analisis mendalam tentang performa ekonomi Indonesia dibandingkan dengan negara ASEAN lainnya.',
                'status' => 'ditolak',
                'kategori' => 'Ekonomi',
                'siswa' => 'Eko Prasetyo',
                'views' => 0,
                'likes' => 0,
                'published_at' => null,
                'rejection_reason' => 'Membutuhkan data dan referensi yang lebih kredibel'
            ],
        ];

        foreach ($articles as $articleData) {
            try {
                $kategori = Kategori::where('nama', $articleData['kategori'])->first();
                $siswa = Siswa::where('nama', $articleData['siswa'])->first();

                $artikel = Artikel::create([
                    'id_siswa' => $siswa ? $siswa->id : null,
                    'id_kategori' => $kategori ? $kategori->id : null,
                    'judul' => $articleData['judul'],
                    'isi' => $articleData['konten'],
                    'gambar' => null,
                    'penulis_type' => 'siswa',

                    'status' => $articleData['status'],
                    'alasan_penolakan' => $articleData['rejection_reason'] ?? null,
                    'diterbitkan_pada' => $articleData['published_at'],
                    'jumlah_dilihat' => $articleData['views'],
                    'jumlah_suka' => $articleData['likes'],

                ]);

                echo "  ✓ Created article: {$artikel->judul}\n";
            } catch (\Exception $e) {
                echo "  ❌ Error creating article '{$articleData['judul']}': " . $e->getMessage() . "\n";
            }
        }
    }

    private function createRatingsAndInteractions()
    {
        try {
            $publishedArticles = Artikel::where('status', 'disetujui')->get();
            $students = Siswa::all();

            foreach ($publishedArticles as $article) {
                // Beri rating random dari 3-5 students
                $ratings = $students->random(rand(2, min(5, $students->count())));
                foreach ($ratings as $student) {
                    RatingArtikel::create([
                        'id_artikel' => $article->id,
                        'id_siswa' => $student->id,
                        'rating' => rand(3, 5), // Rating 1-5
                    ]);
                }

                // Beri interaksi (suka, bookmark)
                $interactions = $students->random(rand(2, min(8, $students->count())));
                foreach ($interactions as $student) {
                    $types = ['suka', 'bookmark'];
                    InteraksiArtikel::create([
                        'id_artikel' => $article->id,
                        'id_siswa' => $student->id,
                        'jenis' => $types[array_rand($types)]
                    ]);
                }
            }

            echo "  ✓ Created ratings and interactions for " . $publishedArticles->count() . " articles\n";
        } catch (\Exception $e) {
            echo "  ❌ Error creating ratings/interactions: " . $e->getMessage() . "\n";
        }
    }
}
