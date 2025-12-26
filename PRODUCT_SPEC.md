# Product Specification - Platform Literasi Digital

## 1. Product Overview

**Platform Literasi Digital** adalah aplikasi berbasis web yang dirancang untuk meningkatkan literasi digital siswa melalui konten artikel dan video edukatif. Platform ini memungkinkan siswa untuk membaca, menulis, dan berinteraksi dengan konten edukatif, sementara admin dapat mengelola konten dan pengguna.

### 1.1 Target Pengguna
- **Siswa**: Pengguna utama yang dapat membaca, membuat konten, dan berinteraksi
- **Admin**: Pengelola platform yang mengawasi konten dan pengguna
- **Guest/Pengunjung**: Dapat melihat artikel publik tanpa login

### 1.2 Teknologi Stack
- **Backend**: Laravel (PHP Framework)
- **Frontend**: Blade Templates + JavaScript
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Multi-Guard (Siswa & Admin)

---

## 2. User Roles & Permissions

### 2.1 Guest (Pengunjung Tidak Login)
**Akses:**
- ✅ Lihat daftar artikel publik (`/artikel-siswa`)
- ✅ Baca detail artikel publik (`/artikel-siswa/{id}`)
- ✅ Akses halaman login/register
- ❌ Tidak bisa komentar, like, atau upload konten

### 2.2 Siswa (Authenticated Student)
**Akses:**
- ✅ Semua akses Guest
- ✅ Dashboard siswa (`/dashboard-siswa`)
- ✅ Lihat dan kelola profil (`/profil`)
- ✅ Update password
- ✅ Upload artikel baru (`/upload/artikel/create`)
- ✅ Interaksi artikel: like, dislike, bookmark
- ✅ Komentar dan reply komentar artikel
- ✅ Rating artikel (1-5 bintang)
- ✅ Hapus komentar sendiri
- ✅ Upload video (`/video/create`)
- ✅ Lihat video dalam mode grid dan TikTok-style (`/video/tiktok`)
- ✅ Like dan komentar video
- ✅ Notifikasi sistem (`/notifikasi`)
- ✅ Logout

**Tidak Bisa:**
- ❌ Mengedit/hapus artikel orang lain
- ❌ Akses panel admin
- ❌ Approve/reject konten

### 2.3 Admin
**Akses:**
- ✅ Login terpisah (`/admin/login`)
- ✅ Dashboard admin dengan statistik & chart (`/admin/dashboard`)
- ✅ CRUD Artikel (`/admin/artikel`)
  - Create, Read, Update, Delete
  - Filter by status (draft, published, archived)
  - Export artikel
- ✅ CRUD Kategori (`/admin/kategori`)
  - Kelola kategori artikel dan video
  - Export kategori
  - Lihat detail artikel per kategori
- ✅ Persetujuan Video (`/admin/video/persetujuan`)
  - Approve/reject video yang diupload siswa
  - Edit metadata video
  - Hapus video
- ✅ Kelola Siswa (`/admin/siswa`)
  - CRUD data siswa
  - Import CSV siswa bulk
  - Export data siswa
  - Lihat detail aktivitas siswa
- ✅ Sistem Penghargaan (`/admin/penghargaan`)
  - Beri penghargaan ke siswa
  - Reset penghargaan bulanan
  - Kirim notifikasi penghargaan
- ✅ Pengaturan (`/admin/pengaturan`)
  - Pengaturan umum aplikasi
  - Keamanan
  - Trash (restore/permanent delete)
- ✅ Backup Data (`/admin/backup`)
- ✅ Log Aktivitas (`/admin/laporan/aktivitas`)
- ✅ Komentar artikel (tambah, edit, hapus)

**Tidak Bisa:**
- ❌ Akses area siswa dengan akun admin

---

## 3. Core Features & User Flows

### 3.1 Authentication Flow

#### 3.1.1 Siswa Registration & Login
**Endpoint:** `/login`, `/register`

**Registration Flow:**
1. Guest mengakses `/login`
2. Klik tombol/tab "Register"
3. Input data:
   - NIS (Nomor Induk Siswa)
   - Nama Lengkap
   - Email
   - Password
   - Password Confirmation
4. Submit form → POST `/register`
5. **Validasi:**
   - NIS harus unik
   - Email harus valid dan unik
   - Password min 8 karakter
6. Success → Auto login → Redirect ke `/dashboard-siswa`

**Login Flow:**
1. Input NIS/Email dan Password
2. Submit → POST `/login`
3. **Validasi:**
   - Kredensial harus cocok
   - Rate limiting (max attempts)
4. Success → Redirect ke `/dashboard-siswa`
5. Failure → Error message

**Test Cases:**
- ✅ Register dengan data valid
- ✅ Register dengan NIS duplikat (harus error)
- ✅ Register dengan email invalid
- ✅ Login dengan kredensial valid
- ✅ Login dengan kredensial invalid
- ✅ Logout berhasil

#### 3.1.2 Admin Login
**Endpoint:** `/admin/login`

**Login Flow:**
1. Akses `/admin/login`
2. Input username dan password admin
3. Submit → POST `/admin/login`
4. Success → Redirect ke `/admin/dashboard`

**Test Cases:**
- ✅ Login admin dengan kredensial valid
- ✅ Login admin dengan kredensial invalid
- ✅ Siswa tidak bisa login di halaman admin
- ✅ Logout admin berhasil

---

### 3.2 Artikel (Student Portal)

#### 3.2.1 Browse & Read Articles
**Endpoints:**
- `/artikel-siswa` - List semua artikel
- `/artikel-siswa/{id}` - Detail artikel

**Browse Flow:**
1. User (guest/siswa) akses `/artikel-siswa`
2. Lihat grid/list artikel
3. **Filter & Search:**
   - Search by keyword
   - Filter by kategori
   - Sort by (terbaru, terpopuler, rating tertinggi)
4. Klik artikel → Redirect ke detail

**Read Flow:**
1. User akses `/artikel-siswa/{id}`
2. Tampilan:
   - Judul, thumbnail, penulis, tanggal
   - Konten lengkap (support rich text/HTML)
   - Rating rata-rata
   - Jumlah views, likes, comments
   - Kategori tags
3. **Interaksi (siswa only):**
   - Like/dislike/bookmark button
   - Rating (1-5 stars)
   - Komentar section

**Test Cases:**
- ✅ Guest bisa lihat list artikel
- ✅ Guest bisa baca detail artikel
- ✅ Search artikel bekerja
- ✅ Filter kategori bekerja
- ✅ Sort artikel bekerja
- ✅ Author info ditampilkan
- ✅ View counter bertambah saat dibaca

#### 3.2.2 Upload Artikel (Siswa Only)
**Endpoints:**
- `/upload` - Pilihan upload (artikel/video)
- `/upload/artikel/create` - Form create artikel
- POST `/upload/artikel` - Submit artikel

**Upload Flow:**
1. Login siswa → Klik "Upload/Buat Konten"
2. Pilih "Artikel" di `/upload`
3. Redirect ke `/upload/artikel/create`
4. **Form Input:**
   - Judul artikel
   - Thumbnail/cover image (upload)
   - Kategori (dropdown/select)
   - Konten (Rich Text Editor - Quill)
   - Tags (optional)
5. Preview (optional)
6. Submit → POST `/upload/artikel`
7. **Validasi:**
   - Judul required, max 200 karakter
   - Thumbnail required, max 2MB, format: jpg/png/webp
   - Kategori required
   - Konten required, min 100 karakter
8. Success → Redirect ke detail artikel baru

**Test Cases:**
- ✅ Upload artikel dengan data lengkap
- ✅ Upload tanpa judul (error)
- ✅ Upload tanpa thumbnail (error)
- ✅ Upload file thumbnail > 2MB (error)
- ✅ Upload file bukan gambar (error)
- ✅ Upload tanpa kategori (error)
- ✅ Upload dengan konten < 100 karakter (error)
- ✅ Rich text editor berfungsi (bold, italic, link, image)
- ✅ Artikel muncul di profil penulis
- ✅ Siswa tidak bisa edit artikel setelah publish (atau bisa dengan approval?)

#### 3.2.3 Interaksi Artikel (Siswa Only)
**Like/Dislike/Bookmark:**
- Endpoint: POST `/artikel-siswa/{id}/interaksi`
- Body: `{ "tipe": "like" | "dislike" | "bookmark" }`
- Toggle behavior (klik lagi = unlike)

**Rating:**
- Endpoint: POST `/artikel-siswa/{id}/rate`
- Body: `{ "rating": 1-5 }`
- Satu siswa satu rating per artikel (update jika sudah rating)

**Komentar:**
- **Tambah Komentar:**
  - Endpoint: POST `/artikel-siswa/{id}/komentar`
  - Body: `{ "isi_komentar": "..." }`
- **Reply Komentar:**
  - Endpoint: POST `/artikel-siswa/{id}/komentar/{parentId}`
  - Body: `{ "isi_komentar": "..." }`
- **Hapus Komentar:**
  - Endpoint: DELETE `/artikel-siswa/komentar/{id}`
  - Hanya bisa hapus komentar sendiri

**Test Cases:**
- ✅ Like artikel (counter +1)
- ✅ Unlike artikel (toggle)
- ✅ Dislike artikel
- ✅ Bookmark artikel
- ✅ Rating artikel 1-5 bintang
- ✅ Update rating (replace previous)
- ✅ Tambah komentar
- ✅ Reply komentar
- ✅ Hapus komentar sendiri
- ✅ Tidak bisa hapus komentar orang lain
- ✅ Guest tidak bisa interaksi (button disabled/redirect login)

---

### 3.3 Video (Student Portal)

#### 3.3.1 Browse & Watch Videos
**Endpoints:**
- `/video` - Grid view semua video
- `/video/tiktok` - TikTok-style vertical scroll view

**Browse Flow (Grid):**
1. Login siswa → Akses `/video`
2. Tampilan grid video thumbnails
3. Klik video → Play in modal/inline player
4. **Filter:**
   - By kategori
   - By popularity
   - Search keyword

**TikTok-Style Flow:**
1. Akses `/video/tiktok`
2. Vertical scrolling video player
3. Auto-play saat video di viewport
4. **Interaksi per video:**
   - Like button (floating)
   - Comment button
   - Share button (optional)
5. Swipe/scroll ke video berikutnya

**Test Cases:**
- ✅ Grid view menampilkan semua video approved
- ✅ TikTok view auto-play bekerja
- ✅ Search video bekerja
- ✅ Filter kategori bekerja
- ✅ Video player controls (play, pause, volume, fullscreen)
- ✅ View counter bertambah

#### 3.3.2 Upload Video (Siswa Only)
**Endpoints:**
- `/upload` - Pilihan upload
- `/video/create` - Form upload video
- POST `/video` - Submit video

**Upload Flow:**
1. Login siswa → Klik "Upload" → Pilih "Video"
2. Redirect ke `/video/create`
3. **Form Input:**
   - File video (upload)
   - Judul video
   - Deskripsi
   - Thumbnail (auto-generate atau upload manual)
   - Kategori
   - Tags
4. Submit → POST `/video`
5. **Validasi:**
   - Video required, max 50MB, format: mp4/mov/avi
   - Judul required, max 150 karakter
   - Deskripsi optional, max 500 karakter
   - Kategori required
6. **Status:** Video masuk ke "pending approval"
7. Success → Notifikasi "Video sedang direview"

**Test Cases:**
- ✅ Upload video dengan data lengkap
- ✅ Upload tanpa file video (error)
- ✅ Upload file > 50MB (error)
- ✅ Upload file bukan video (error)
- ✅ Upload tanpa judul (error)
- ✅ Video masuk status "pending"
- ✅ Siswa menerima notifikasi saat video approved/rejected

#### 3.3.3 Interaksi Video (Siswa Only)
**Like Video:**
- Endpoint: POST `/video/{id}/interaksi`
- Body: `{ "tipe": "like" }`
- Toggle behavior

**Komentar Video:**
- **Tambah:** POST `/video/{id}/komentar`
- **Hapus:** DELETE `/video/komentar/{id}`

**Test Cases:**
- ✅ Like video (counter +1)
- ✅ Unlike video
- ✅ Komentar video
- ✅ Hapus komentar sendiri
- ✅ Tidak bisa hapus komentar orang lain

---

### 3.4 Dashboard Siswa

**Endpoint:** `/dashboard-siswa`

**Konten Dashboard:**
1. **Statistik Pribadi:**
   - Total artikel ditulis
   - Total video diupload
   - Total views
   - Total likes/interactions
   - Penghargaan yang diterima
2. **Artikel Terbaru Saya**
   - List 5 artikel terbaru dengan status
3. **Video Saya**
   - List 5 video terbaru (pending/approved/rejected)
4. **Aktivitas Terbaru**
   - Komentar yang diterima
   - Likes yang diterima
5. **Notifikasi Badge**
   - Unread notification count

**Test Cases:**
- ✅ Dashboard load dengan data benar
- ✅ Statistik akurat (artikel, video, views, likes)
- ✅ Link ke artikel/video bekerja
- ✅ Notifikasi badge update real-time

---

### 3.5 Profil Siswa

**Endpoints:**
- `/profil` - Lihat & edit profil
- POST `/profil/update` - Update profil
- POST `/profil/update-password` - Ubah password

**Profil Flow:**
1. Login siswa → Klik profil icon/nama
2. Tampilan:
   - Foto profil
   - Nama, NIS, Email, Kelas
   - Bio (optional)
   - Statistik (artikel, video, followers)
3. Klik "Edit Profil"
4. **Form Edit:**
   - Upload foto profil baru
   - Update nama
   - Update bio
   - Update email (dengan verifikasi)
5. Submit → Success message

**Update Password:**
1. Di halaman profil → Tab "Keamanan"
2. Input:
   - Password lama
   - Password baru
   - Konfirmasi password baru
3. Submit → POST `/profil/update-password`
4. **Validasi:**
   - Password lama harus cocok
   - Password baru min 8 karakter
   - Konfirmasi harus match
5. Success → Logout (optional) → Login ulang

**Test Cases:**
- ✅ View profil sendiri
- ✅ Update nama berhasil
- ✅ Update foto profil (max 2MB)
- ✅ Update email berhasil
- ✅ Update password dengan password lama benar
- ✅ Update password dengan password lama salah (error)
- ✅ Password baru < 8 karakter (error)
- ✅ Konfirmasi password tidak match (error)

---

### 3.6 Notifikasi Siswa

**Endpoints:**
- `/notifikasi` - List semua notifikasi
- POST `/notifikasi/mark-read` - Mark as read
- GET `/notifikasi/unread-count` - Get unread count (AJAX)
- GET `/notifikasi/recent` - Get recent notifications (AJAX)

**Tipe Notifikasi:**
1. **Komentar Baru** - "X mengomentari artikel Anda: [judul]"
2. **Reply Komentar** - "X membalas komentar Anda di [judul]"
3. **Like Artikel** - "X menyukai artikel Anda: [judul]"
4. **Video Approved** - "Video Anda '[judul]' telah disetujui!"
5. **Video Rejected** - "Video Anda '[judul]' ditolak. Alasan: [...]"
6. **Penghargaan** - "Selamat! Anda menerima penghargaan: [nama]"
7. **Admin Reply** - "Admin membalas komentar Anda"

**Notifikasi Flow:**
1. Badge icon di header (red dot jika ada unread)
2. Klik icon → Dropdown preview 5 notifikasi terbaru
3. Klik "Lihat Semua" → `/notifikasi`
4. List semua notifikasi (pagination)
5. Klik notifikasi → Mark as read + redirect ke konten terkait

**Test Cases:**
- ✅ Notifikasi muncul saat ada interaksi
- ✅ Badge count akurat
- ✅ Mark as read bekerja
- ✅ Link notifikasi redirect benar
- ✅ Notifikasi sorted by newest first
- ✅ Pagination bekerja

---

## 4. Admin Portal

### 4.1 Admin Dashboard

**Endpoint:** `/admin/dashboard`

**Konten Dashboard:**
1. **KPI Cards:**
   - Total siswa terdaftar
   - Total artikel (published)
   - Total video (approved)
   - Total komentar
2. **Charts (AJAX loaded):**
   - Artikel per bulan (line chart)
   - Video per kategori (pie chart)
   - Siswa aktif vs inactive (bar chart)
   - Top 10 artikel popular (table)
3. **Recent Activities:**
   - Artikel baru (pending review)
   - Video pending approval
   - Komentar terbaru
4. **Quick Actions:**
   - Tambah artikel
   - Approve video
   - Kelola siswa

**Chart AJAX:**
- Endpoint: `/admin/dashboard/chart/{type}`
- Types: `artikel_bulanan`, `video_kategori`, `siswa_aktif`, `top_artikel`

**Test Cases:**
- ✅ Dashboard load dengan data akurat
- ✅ KPI cards menampilkan angka benar
- ✅ Charts load via AJAX
- ✅ Recent activities update
- ✅ Quick action links bekerja

---

### 4.2 Kelola Artikel (Admin)

**Endpoints:**
- `/admin/artikel` - List artikel (GET)
- `/admin/artikel/create` - Form create (GET)
- `/admin/artikel` - Store artikel (POST)
- `/admin/artikel/{id}` - Show detail (GET)
- `/admin/artikel/{id}/edit` - Form edit (GET)
- `/admin/artikel/{id}` - Update artikel (PUT)
- `/admin/artikel/{id}` - Delete artikel (DELETE)
- `/admin/artikel/status/{status}` - Filter by status
- `/admin/artikel/export` - Export artikel (CSV/Excel)

**List Artikel Flow:**
1. Admin login → Sidebar → Klik "Artikel"
2. Tampilan tabel artikel:
   - Kolom: ID, Thumbnail, Judul, Penulis, Kategori, Status, Views, Likes, Tanggal, Actions
3. **Filter & Search:**
   - Search by judul/penulis
   - Filter by kategori
   - Filter by status (all, draft, published, archived)
   - Sort by (newest, popular, rating)
4. **Pagination:** 20 artikel per page
5. **Bulk Actions:** (optional)
   - Select multiple → Publish/Archive/Delete

**Create Artikel Flow:**
1. Klik "Tambah Artikel"
2. Form:
   - Judul
   - Thumbnail upload
   - Penulis (auto: Admin atau pilih siswa via Select2)
   - Kategori (dropdown)
   - Konten (Quill editor)
   - Status (draft/published)
   - Tags
3. Submit → Redirect ke detail artikel

**Edit Artikel Flow:**
1. Di list, klik icon "Edit" pada artikel
2. Form sama dengan create (pre-filled)
3. Submit → Update artikel

**Delete Artikel Flow:**
1. Klik icon "Hapus" → Konfirmasi modal
2. Submit → Soft delete (masuk trash)
3. Di trash, bisa restore atau permanent delete

**Detail Artikel Flow:**
1. Klik judul artikel di list
2. Tampilan:
   - Full preview artikel (seperti siswa lihat)
   - Statistik lengkap
   - List komentar (dengan opsi edit/hapus)
   - Activity log

**Test Cases:**
- ✅ Admin bisa lihat semua artikel (termasuk milik siswa)
- ✅ Create artikel admin berhasil
- ✅ Edit artikel berhasil
- ✅ Delete artikel (soft delete)
- ✅ Restore artikel dari trash
- ✅ Permanent delete artikel
- ✅ Search artikel bekerja
- ✅ Filter status bekerja
- ✅ Export artikel ke CSV
- ✅ Pagination bekerja
- ✅ Quill editor bekerja di admin

---

### 4.3 Kelola Komentar (Admin)

**Endpoints (dalam artikel):**
- POST `/admin/komentar/{artikel}` - Tambah komentar sebagai admin
- PUT `/admin/komentar/{komentar}` - Edit komentar
- DELETE `/admin/komentar/{komentar}` - Hapus komentar

**Komentar Management:**
1. Admin bisa **hapus komentar siapapun** (spam/inappropriate)
2. Admin bisa **edit komentar** (typo fix, moderasi)
3. Admin bisa **balas komentar sebagai admin** (badge "Admin" muncul)

**Test Cases:**
- ✅ Admin bisa tambah komentar di artikel
- ✅ Komentar admin ada badge "Admin"
- ✅ Admin bisa edit komentar siswa
- ✅ Admin bisa hapus komentar siswa
- ✅ Siswa menerima notifikasi saat admin reply komentar mereka

---

### 4.4 Persetujuan Video (Admin)

**Endpoints:**
- `/admin/video/persetujuan` - List video pending (GET)
- PUT `/admin/video/{id}/persetujuan` - Approve/reject video
- DELETE `/admin/video/persetujuan/{id}` - Delete video
- `/admin/search-kategori` - Search kategori (Select2)
- `/admin/search-siswa` - Search siswa (Select2)

**Video Approval Flow:**
1. Admin → Sidebar → "Persetujuan Video"
2. Tampilan tabel:
   - Kolom: Thumbnail, Judul, Penulis, Kategori, Durasi, Ukuran, Tanggal Upload, Status, Actions
3. **Filter:**
   - Status: Pending, Approved, Rejected
   - Kategori
   - Penulis (search Select2)
4. **Preview Video:**
   - Klik thumbnail/judul → Modal preview
   - Video player dalam modal
   - Metadata (deskripsi, tags)
5. **Approve:**
   - Klik "Approve"
   - Optional: Edit kategori/tags
   - Submit → Status jadi "approved"
   - **Trigger:** Notifikasi ke siswa penulis
6. **Reject:**
   - Klik "Reject"
   - Modal: Input alasan penolakan (required)
   - Submit → Status jadi "rejected"
   - **Trigger:** Notifikasi + alasan ke siswa
7. **Delete:**
   - Klik "Hapus" → Konfirmasi
   - Permanent delete video file + record

**Test Cases:**
- ✅ Admin lihat list video pending
- ✅ Preview video dalam modal
- ✅ Approve video berhasil
- ✅ Siswa menerima notifikasi video approved
- ✅ Reject video dengan alasan
- ✅ Siswa menerima notifikasi video rejected + alasan
- ✅ Delete video berhasil (file + DB)
- ✅ Filter status bekerja
- ✅ Search siswa (Select2) bekerja
- ✅ Search kategori (Select2) bekerja

---

### 4.5 Kelola Kategori

**Endpoints:**
- `/admin/kategori` - List kategori (GET)
- `/admin/kategori/create` - Form create (GET)
- POST `/admin/kategori` - Store kategori
- `/admin/kategori/{id}/edit` - Form edit (GET)
- PUT `/admin/kategori/{id}` - Update kategori
- DELETE `/admin/kategori/{id}` - Delete kategori
- `/admin/kategori/{id}/detail` - Detail kategori (artikel terkait)
- `/admin/kategori/export` - Export kategori

**Kategori Management:**
1. **Create Kategori:**
   - Nama kategori (required, unique)
   - Slug (auto-generate dari nama)
   - Deskripsi
   - Icon/image (optional)
   - Status (aktif/nonaktif)
2. **Edit Kategori:**
   - Update nama, deskripsi, status
3. **Delete Kategori:**
   - Validasi: Tidak bisa hapus jika ada artikel/video yang masih pakai kategori ini
   - Atau: Re-assign artikel/video ke kategori lain
4. **Detail Kategori:**
   - Lihat list semua artikel/video dalam kategori ini

**Test Cases:**
- ✅ Create kategori baru
- ✅ Kategori duplikat nama (error)
- ✅ Edit kategori berhasil
- ✅ Delete kategori yang tidak dipakai
- ✅ Delete kategori yang masih dipakai (error/warning)
- ✅ Lihat detail kategori (list artikel)
- ✅ Export kategori ke CSV

---

### 4.6 Kelola Siswa

**Endpoints:**
- `/admin/siswa` - List siswa (GET)
- POST `/admin/siswa` - Create siswa manual
- `/admin/siswa/{nis}/detail` - Detail siswa (GET)
- `/admin/siswa/{nis}/edit` - Form edit (GET)
- PUT `/admin/siswa/{nis}` - Update siswa
- DELETE `/admin/siswa/{nis}` - Delete siswa
- POST `/admin/siswa/import` - Import CSV siswa
- `/admin/siswa/export` - Export siswa (CSV)

**List Siswa Flow:**
1. Admin → Sidebar → "Kelola Siswa"
2. Tampilan tabel:
   - Kolom: NIS, Nama, Email, Kelas, Total Artikel, Total Video, Penghargaan, Status, Actions
3. **Filter & Search:**
   - Search by NIS/Nama/Email
   - Filter by kelas
   - Filter by status (aktif/nonaktif)
   - Sort by (nama, total artikel, total video)
4. **Pagination:** 50 siswa per page

**Create Siswa Manual:**
1. Klik "Tambah Siswa"
2. Form:
   - NIS (unique)
   - Nama Lengkap
   - Email (unique)
   - Kelas
   - Password (auto-generate atau manual)
3. Submit → Success + Auto-send email kredensial (optional)

**Edit Siswa:**
1. Klik "Edit" pada siswa
2. Form sama dengan create (pre-filled)
3. Bisa reset password (tanpa tahu password lama)
4. Bisa nonaktifkan akun (status = inactive)

**Delete Siswa:**
1. Klik "Hapus" → Konfirmasi
2. **Options:**
   - Soft delete (ke trash)
   - Hard delete (permanent)
   - Keep artikel/video siswa atau delete semua?

**Import CSV Siswa:**
1. Klik "Import Siswa"
2. Download template CSV
3. Upload file CSV dengan format:
   ```
   NIS, Nama, Email, Kelas, Password
   10001, Budi Santoso, budi@example.com, X-1, password123
   ```
4. Submit → Validation:
   - NIS duplikat (skip atau error)
   - Email invalid (error)
5. Success → Summary: "50 siswa berhasil, 5 gagal (lihat detail)"

**Detail Siswa:**
1. Klik nama siswa → Halaman detail
2. Tampilan:
   - **Info Pribadi:** NIS, Nama, Email, Kelas, Tanggal Daftar
   - **Statistik:**
     - Total artikel (draft/published)
     - Total video (pending/approved/rejected)
     - Total views, likes, comments
     - Penghargaan yang diterima
   - **Activity Timeline:**
     - Artikel terbaru
     - Video terbaru
     - Komentar terbaru
   - **Actions:**
     - Edit siswa
     - Reset password
     - Nonaktifkan akun
     - Hapus siswa

**Test Cases:**
- ✅ Lihat list siswa dengan pagination
- ✅ Search siswa bekerja
- ✅ Filter by kelas bekerja
- ✅ Create siswa manual berhasil
- ✅ NIS duplikat (error)
- ✅ Email duplikat (error)
- ✅ Edit siswa berhasil
- ✅ Reset password siswa
- ✅ Nonaktifkan siswa (tidak bisa login)
- ✅ Aktifkan kembali siswa
- ✅ Delete siswa (soft delete)
- ✅ Import CSV berhasil (semua valid)
- ✅ Import CSV dengan error (partial success)
- ✅ Export siswa ke CSV
- ✅ Detail siswa menampilkan data akurat

---

### 4.7 Sistem Penghargaan

**Endpoints:**
- `/admin/penghargaan` - List penghargaan (GET)
- `/admin/penghargaan/create` - Form create (GET)
- POST `/admin/penghargaan` - Store penghargaan
- `/admin/penghargaan/{id}/edit` - Form edit (GET)
- PUT `/admin/penghargaan/{id}` - Update penghargaan
- DELETE `/admin/penghargaan/{id}` - Delete penghargaan
- POST `/admin/send-award-notification` - Kirim notifikasi penghargaan
- `/admin/penghargaan/reset/{month?}` - Reset penghargaan bulanan

**Tipe Penghargaan:**
1. **Penulis Terbaik Bulan Ini** - Siswa dengan artikel terbanyak
2. **Video Creator Terbaik** - Siswa dengan video approved terbanyak
3. **Kontributor Teraktif** - Siswa dengan total komentar + interaksi terbanyak
4. **Artikel Terpopuler** - Artikel dengan views + likes tertinggi
5. **Custom Award** - Admin bisa buat penghargaan manual

**Beri Penghargaan Flow:**
1. Admin → "Penghargaan" → "Beri Penghargaan"
2. Form:
   - Pilih siswa (Select2 search)
   - Pilih jenis penghargaan (dropdown)
   - Custom pesan (optional)
   - Badge/icon (upload atau pilih dari preset)
3. Submit → POST `/admin/penghargaan`
4. **Trigger:**
   - Siswa menerima notifikasi
   - Badge muncul di profil siswa
   - Penghargaan masuk dashboard siswa

**Auto Award (Monthly):**
1. Di akhir bulan (cron job atau manual trigger)
2. Admin → "Penghargaan" → "Generate Penghargaan Bulanan"
3. Sistem auto-hitung:
   - Top 3 penulis artikel
   - Top 3 video creator
   - Top 3 kontributor aktif
4. Generate penghargaan otomatis
5. **Trigger:** Notifikasi batch ke semua penerima

**Reset Penghargaan:**
- Endpoint: GET `/admin/penghargaan/reset/{month?}`
- Reset statistik bulanan (views, likes, dll) ke 0
- Archive penghargaan bulan lalu
- Siap untuk bulan baru

**Test Cases:**
- ✅ Admin bisa beri penghargaan manual ke siswa
- ✅ Siswa menerima notifikasi penghargaan
- ✅ Badge penghargaan muncul di profil siswa
- ✅ Generate penghargaan bulanan otomatis
- ✅ Top 3 siswa dapat penghargaan (benar)
- ✅ Reset penghargaan bulanan berhasil
- ✅ Lihat history penghargaan

---

### 4.8 Pengaturan (Settings)

**Endpoints:**
- `/admin/pengaturan` - Pengaturan umum
- PATCH `/admin/pengaturan` - Update pengaturan
- `/admin/pengaturan/keamanan` - Pengaturan keamanan
- PUT `/admin/pengaturan/umum` - Update pengaturan umum
- `/admin/pengaturan/trash` - Trash (soft deleted items)
- POST `/admin/pengaturan/restore/{model}/{id}` - Restore item
- DELETE `/admin/pengaturan/force-delete/{model}/{id}` - Permanent delete

**Pengaturan Umum:**
1. **Informasi Aplikasi:**
   - Nama aplikasi
   - Logo (upload)
   - Tagline
   - Deskripsi
2. **Kontak:**
   - Email admin
   - No. Telepon
   - Alamat
3. **Upload Limits:**
   - Max ukuran gambar (MB)
   - Max ukuran video (MB)
   - Format file yang diizinkan
4. **Konten:**
   - Moderasi komentar (auto-approve atau manual)
   - Moderasi video (auto-approve atau manual)
   - Min. panjang konten artikel (karakter)
5. **Notifikasi:**
   - Email notifikasi ke admin (on/off)
   - Email notifikasi ke siswa (on/off)

**Pengaturan Keamanan:**
1. **Password Policy:**
   - Min. panjang password
   - Require uppercase/lowercase/number/symbol
2. **Session:**
   - Max login attempt (rate limiting)
   - Session timeout (minutes)
3. **Two-Factor Auth (optional):**
   - Enable 2FA untuk admin

**Trash Management:**
1. Lihat list semua item yang di-soft delete:
   - Artikel
   - Video
   - Komentar
   - Kategori
   - Siswa
2. **Actions per item:**
   - Restore (kembalikan)
   - Permanent Delete
3. **Bulk Actions:**
   - Restore all
   - Empty trash (permanent delete all)

**Test Cases:**
- ✅ Update pengaturan umum berhasil
- ✅ Upload logo aplikasi
- ✅ Update upload limits
- ✅ Update password policy
- ✅ Lihat trash items
- ✅ Restore artikel dari trash
- ✅ Permanent delete artikel
- ✅ Empty trash berhasil

---

### 4.9 Backup Data

**Endpoints:**
- `/admin/backup` - List backup yang tersedia
- `/admin/backup/all` - Trigger backup full (DB + files)

**Backup Flow:**
1. Admin → "Backup" → "Buat Backup Baru"
2. Pilih tipe:
   - **Database only** (SQL dump)
   - **Files only** (upload folder)
   - **Full backup** (DB + files)
3. Klik "Mulai Backup"
4. **Proses:**
   - Generate backup file (zip)
   - Save to storage/backups/
   - Record metadata (ukuran, tanggal, tipe)
5. Success → Download link available

**List Backup:**
- Tampilan tabel:
  - Nama file
  - Tipe (DB/Files/Full)
  - Ukuran
  - Tanggal dibuat
  - Actions (Download, Delete)

**Test Cases:**
- ✅ Backup database berhasil
- ✅ Backup files berhasil
- ✅ Full backup berhasil
- ✅ Download backup file
- ✅ Delete backup file
- ✅ Auto backup (cron job) - optional

---

### 4.10 Log Aktivitas

**Endpoint:** `/admin/laporan/aktivitas`

**Konten Log:**
- Semua aktivitas admin dicatat:
  - Login/logout
  - Create/update/delete artikel
  - Approve/reject video
  - Edit siswa
  - Beri penghargaan
  - Update pengaturan

**Log Table:**
- Kolom: Timestamp, Admin, Aktivitas, Detail, IP Address

**Filter:**
- By admin
- By tipe aktivitas
- By date range

**Test Cases:**
- ✅ Log aktivitas tercatat
- ✅ Filter by admin bekerja
- ✅ Filter by date range bekerja
- ✅ Export log ke CSV

---

## 5. Non-Functional Requirements

### 5.1 Performance
- **Page Load Time:** < 2 detik untuk halaman utama
- **Database Query:** < 100ms untuk query utama
- **Image Optimization:** Auto-compress upload (max width 1920px)
- **Video Streaming:** Support progressive playback (tidak perlu download penuh)
- **Pagination:** Implementasi untuk list > 50 items

### 5.2 Security
- **Authentication:** Secure password hashing (bcrypt)
- **CSRF Protection:** Laravel CSRF token di semua form
- **XSS Protection:** Sanitasi input, escape output
- **SQL Injection:** Use Eloquent ORM (parameterized queries)
- **File Upload:** Validasi tipe file, size, rename file (random name)
- **Rate Limiting:** Max 5 login attempts per 1 menit
- **Session:** Secure cookies, httpOnly flag

### 5.3 Usability
- **Responsive Design:** Mobile-friendly (breakpoints: 320px, 768px, 1024px, 1440px)
- **Accessibility:** Alt text untuk gambar, keyboard navigation
- **Loading States:** Skeleton/spinner saat load data
- **Error Messages:** User-friendly, actionable (bukan technical error)
- **Success Feedback:** Toast/notification setelah aksi berhasil

### 5.4 Compatibility
- **Browser Support:**
  - Chrome 90+
  - Firefox 88+
  - Safari 14+
  - Edge 90+
- **Mobile:** Android 8+, iOS 12+
- **Screen Resolution:** Min. 320px width

### 5.5 Scalability
- **User Capacity:** Support up to 10,000 siswa concurrent
- **Storage:** Efficient file storage (cloud storage optional)
- **Database:** Index pada kolom yang sering di-query
- **Caching:** Redis/Memcached untuk session & query cache

---

## 6. Testing Checklist

### 6.1 Critical Path Testing
**Must Pass:**
1. ✅ **Siswa registration & login**
2. ✅ **Admin login**
3. ✅ **Upload artikel (siswa)**
4. ✅ **Upload video (siswa)**
5. ✅ **Approve video (admin)**
6. ✅ **Read artikel (guest & siswa)**
7. ✅ **Interaksi artikel (like, comment, rating)**
8. ✅ **Notifikasi siswa**
9. ✅ **Dashboard siswa & admin**
10. ✅ **Logout (siswa & admin)**

### 6.2 Edge Cases Testing
1. ✅ **Concurrent edits** (2 admin edit artikel yang sama)
2. ✅ **File upload errors** (timeout, network error)
3. ✅ **Empty states** (no artikel, no video, no notification)
4. ✅ **Pagination edge** (page 0, page 9999)
5. ✅ **Special characters** (emoji di judul, SQL injection attempt)
6. ✅ **Large data** (artikel 10,000 kata, video 50MB)
7. ✅ **Duplicate actions** (double-click submit button)
8. ✅ **Session expiry** (expired session, auto-redirect login)

### 6.3 Security Testing
1. ✅ **Unauthorized access** (siswa akses `/admin/*` → 403)
2. ✅ **CSRF attack** (form submit tanpa token → 419)
3. ✅ **XSS attempt** (`<script>alert('xss')</script>` di komentar)
4. ✅ **SQL injection** (`' OR 1=1--` di search/login)
5. ✅ **File upload abuse** (upload .php file, rename to .jpg)
6. ✅ **Brute force login** (rate limiting aktif)

### 6.4 Performance Testing
1. ✅ **Load test** (100 concurrent users submit artikel)
2. ✅ **Stress test** (1000 siswa login bersamaan)
3. ✅ **Large file upload** (video 50MB upload time < 2 menit)
4. ✅ **Database heavy query** (list 10,000 artikel dengan join)

### 6.5 UI/UX Testing
1. ✅ **Mobile responsive** (semua halaman di 320px, 768px, 1024px)
2. ✅ **Dark mode** (jika ada)
3. ✅ **Loading states** (spinner/skeleton saat load)
4. ✅ **Error messages** (user-friendly, tidak technical)
5. ✅ **Success feedback** (toast notification)
6. ✅ **Form validation** (real-time validation)
7. ✅ **Button states** (disabled saat loading)

---

## 7. API Endpoints Summary

### 7.1 Public/Guest
- `GET /` → Redirect to `/login`
- `GET /artikel-siswa` → List artikel
- `GET /artikel-siswa/{id}` → Detail artikel

### 7.2 Siswa (Authenticated)
**Auth:**
- `GET /login` → Login form
- `POST /login` → Login submit
- `POST /register` → Register submit
- `POST /siswa/logout` → Logout

**Dashboard:**
- `GET /dashboard-siswa` → Dashboard

**Artikel:**
- `GET /upload` → Upload choice
- `GET /upload/artikel/create` → Form create artikel
- `POST /upload/artikel` → Submit artikel
- `POST /artikel-siswa/{id}/interaksi` → Like/dislike/bookmark
- `POST /artikel-siswa/{id}/rate` → Rating artikel
- `POST /artikel-siswa/{id}/komentar` → Tambah komentar
- `POST /artikel-siswa/{id}/komentar/{parentId}` → Reply komentar
- `DELETE /artikel-siswa/komentar/{id}` → Hapus komentar

**Video:**
- `GET /video` → List video (grid)
- `GET /video/tiktok` → TikTok view
- `GET /video/create` → Form upload video
- `POST /video` → Submit video
- `POST /video/{id}/interaksi` → Like video
- `POST /video/{id}/komentar` → Komentar video
- `DELETE /video/komentar/{id}` → Hapus komentar video

**Profil:**
- `GET /profil` → View profil
- `POST /profil/update` → Update profil
- `POST /profil/update-password` → Update password

**Notifikasi:**
- `GET /notifikasi` → List notifikasi
- `POST /notifikasi/mark-read` → Mark as read
- `GET /notifikasi/unread-count` → Get unread count (AJAX)
- `GET /notifikasi/recent` → Get recent notifikasi (AJAX)

### 7.3 Admin
**Auth:**
- `GET /admin/login` → Login form
- `POST /admin/login` → Login submit
- `POST /admin/logout` → Logout

**Dashboard:**
- `GET /admin/dashboard` → Dashboard
- `GET /admin/dashboard/chart/{type}` → Chart data (AJAX)

**Artikel:**
- `GET /admin/artikel` → List artikel
- `GET /admin/artikel/create` → Form create
- `POST /admin/artikel` → Store artikel
- `GET /admin/artikel/{id}` → Show detail
- `GET /admin/artikel/{id}/edit` → Form edit
- `PUT /admin/artikel/{id}` → Update artikel
- `DELETE /admin/artikel/{id}` → Delete artikel
- `GET /admin/artikel/status/{status}` → Filter by status
- `GET /admin/artikel/export` → Export CSV
- `GET /admin/artikel/get/{id}` → Get artikel by ID (AJAX)
- `POST /admin/rate` → Rate artikel

**Komentar:**
- `POST /admin/komentar/{artikel}` → Tambah komentar
- `PUT /admin/komentar/{komentar}` → Edit komentar
- `DELETE /admin/komentar/{komentar}` → Hapus komentar

**Video:**
- `GET /admin/video/persetujuan` → List video pending
- `PUT /admin/video/{id}/persetujuan` → Approve/reject video
- `DELETE /admin/video/persetujuan/{id}` → Delete video
- `GET /admin/search-kategori` → Search kategori (Select2)
- `GET /admin/search-siswa` → Search siswa (Select2)

**Kategori:**
- `GET /admin/kategori` → List kategori
- `GET /admin/kategori/create` → Form create
- `POST /admin/kategori` → Store kategori
- `GET /admin/kategori/{id}/edit` → Form edit
- `PUT /admin/kategori/{id}` → Update kategori
- `DELETE /admin/kategori/{id}` → Delete kategori
- `GET /admin/kategori/{id}/detail` → Detail kategori
- `GET /admin/kategori/export` → Export CSV

**Siswa:**
- `GET /admin/siswa` → List siswa
- `POST /admin/siswa` → Create siswa
- `GET /admin/siswa/{nis}/detail` → Detail siswa
- `GET /admin/siswa/{nis}/edit` → Form edit
- `PUT /admin/siswa/{nis}` → Update siswa
- `DELETE /admin/siswa/{nis}` → Delete siswa
- `POST /admin/siswa/import` → Import CSV
- `GET /admin/siswa/export` → Export CSV

**Penghargaan:**
- `GET /admin/penghargaan` → List penghargaan
- `GET /admin/penghargaan/create` → Form create
- `POST /admin/penghargaan` → Store penghargaan
- `GET /admin/penghargaan/{id}/edit` → Form edit
- `PUT /admin/penghargaan/{id}` → Update penghargaan
- `DELETE /admin/penghargaan/{id}` → Delete penghargaan
- `POST /admin/send-award-notification` → Kirim notifikasi
- `GET /admin/penghargaan/reset/{month?}` → Reset bulanan

**Pengaturan:**
- `GET /admin/pengaturan` → Pengaturan umum
- `PATCH /admin/pengaturan` → Update pengaturan
- `GET /admin/pengaturan/keamanan` → Keamanan
- `PUT /admin/pengaturan/umum` → Update umum
- `GET /admin/pengaturan/trash` → Trash
- `POST /admin/pengaturan/restore/{model}/{id}` → Restore
- `DELETE /admin/pengaturan/force-delete/{model}/{id}` → Permanent delete

**Backup:**
- `GET /admin/backup` → List backup
- `GET /admin/backup/all` → Trigger backup full

**Log:**
- `GET /admin/laporan/aktivitas` → Log aktivitas

---

## 8. Database Schema (Simplified)

### 8.1 Core Tables

**users (siswa):**
- id (PK)
- nis (unique)
- nama
- email (unique)
- password
- kelas
- foto_profil
- bio
- status (aktif/nonaktif)
- created_at, updated_at

**admins:**
- id (PK)
- username (unique)
- nama
- email
- password
- role (super_admin/admin)
- created_at, updated_at

**artikel:**
- id (PK)
- user_id (FK to users)
- judul
- slug
- thumbnail
- kategori_id (FK to kategori)
- konten (longtext)
- status (draft/published/archived)
- views (int, default 0)
- created_at, updated_at, deleted_at

**video:**
- id (PK)
- user_id (FK to users)
- judul
- deskripsi
- file_path
- thumbnail
- kategori_id (FK to kategori)
- durasi (seconds)
- ukuran (bytes)
- status (pending/approved/rejected)
- alasan_reject (nullable)
- views (int, default 0)
- created_at, updated_at, deleted_at

**kategori:**
- id (PK)
- nama (unique)
- slug (unique)
- deskripsi
- icon
- status (aktif/nonaktif)
- created_at, updated_at, deleted_at

**komentar:**
- id (PK)
- user_id (FK to users, nullable jika admin)
- admin_id (FK to admins, nullable)
- artikel_id (FK to artikel, nullable)
- video_id (FK to video, nullable)
- parent_id (FK to komentar, nullable - untuk reply)
- isi_komentar (text)
- created_at, updated_at, deleted_at

**interaksi:**
- id (PK)
- user_id (FK to users)
- artikel_id (FK to artikel, nullable)
- video_id (FK to video, nullable)
- tipe (like/dislike/bookmark)
- created_at, updated_at

**rating:**
- id (PK)
- user_id (FK to users)
- artikel_id (FK to artikel)
- rating (1-5)
- created_at, updated_at

**notifikasi:**
- id (PK)
- user_id (FK to users)
- tipe (komentar/reply/like/video_approved/video_rejected/penghargaan)
- judul
- pesan
- link (URL terkait)
- is_read (boolean, default false)
- created_at, updated_at

**penghargaan:**
- id (PK)
- user_id (FK to users)
- admin_id (FK to admins)
- jenis (penulis_terbaik/video_terbaik/kontributor_aktif/custom)
- nama_penghargaan
- deskripsi
- badge_icon
- bulan (int, 1-12)
- tahun (int, 2025)
- created_at, updated_at

**log_admin:**
- id (PK)
- admin_id (FK to admins)
- aktivitas (login/logout/create_artikel/etc)
- detail (JSON)
- ip_address
- created_at

**pengaturan:**
- id (PK)
- key (unique)
- value (text)
- created_at, updated_at

---

## 9. Success Metrics (KPI)

### 9.1 User Engagement
- **Daily Active Users (DAU):** Target 70% dari total siswa terdaftar
- **Weekly Active Users (WAU):** Target 90% dari total siswa
- **Avg. Session Duration:** > 10 menit per session
- **Bounce Rate:** < 30%

### 9.2 Content Metrics
- **Artikel Published per Week:** Target 50+ artikel baru
- **Video Approved per Week:** Target 30+ video baru
- **Avg. Comments per Artikel:** > 5 komentar
- **Avg. Rating:** > 4.0 bintang

### 9.3 Technical Metrics
- **Uptime:** 99.5%
- **Page Load Time:** < 2 detik (P95)
- **API Response Time:** < 200ms (P95)
- **Error Rate:** < 0.5%

---

## 10. Known Limitations & Future Enhancements

### 10.1 Current Limitations
- ❌ Tidak ada fitur private message antar siswa
- ❌ Video max 50MB (tidak support live streaming)
- ❌ Tidak ada multi-language support (hanya Bahasa Indonesia)
- ❌ Artikel tidak bisa di-edit setelah publish (tanpa approval admin)
- ❌ Tidak ada fitur "Save as Draft" untuk artikel (auto-save)

### 10.2 Future Enhancements (Nice to Have)
- 📌 **Gamification:** Badge, leaderboard, poin untuk interaksi
- 📌 **Social Features:** Follow siswa lain, feed personalized
- 📌 **AI Content Moderation:** Auto-detect inappropriate content
- 📌 **Advanced Analytics:** Dashboard analytics untuk siswa (traffic, engagement)
- 📌 **Mobile App:** Native Android/iOS app
- 📌 **Live Streaming:** Siswa bisa live streaming video edukatif
- 📌 **Quiz/Kuis:** Tambah kuis interaktif dalam artikel
- 📌 **Collaboration:** Co-author artikel (multiple penulis)
- 📌 **API Public:** REST API untuk integrasi eksternal
- 📌 **Dark Mode:** Support dark theme

---

## 11. Testing Priority (for TestSprite)

### 11.1 CRITICAL (Must Test First)
1. ✅ **Authentication flows** (siswa & admin login/register/logout)
2. ✅ **Upload artikel & video** (end-to-end)
3. ✅ **Video approval** (admin approve/reject)
4. ✅ **Interaksi artikel** (like, comment, rating)
5. ✅ **Notifikasi system** (trigger & display)
6. ✅ **CRUD operations** (admin artikel, kategori, siswa)

### 11.2 HIGH PRIORITY
7. ✅ **Dashboard data accuracy** (siswa & admin)
8. ✅ **Search & filtering** (artikel, video, siswa)
9. ✅ **Pagination** (all list pages)
10. ✅ **File upload validation** (size, type, errors)
11. ✅ **Profile management** (update profile, change password)
12. ✅ **Responsive design** (mobile, tablet, desktop)

### 11.3 MEDIUM PRIORITY
13. ✅ **Penghargaan system** (manual & auto-generate)
14. ✅ **Import/Export CSV** (siswa, artikel, kategori)
15. ✅ **Backup system**
16. ✅ **Trash & restore** (soft delete items)
17. ✅ **Settings update** (pengaturan umum, keamanan)
18. ✅ **Log aktivitas** (recording & display)

### 11.4 LOW PRIORITY (Nice to Test)
19. ✅ **Edge cases** (concurrent edits, large data, special chars)
20. ✅ **Security tests** (XSS, CSRF, SQL injection)
21. ✅ **Performance tests** (load, stress)
22. ✅ **Accessibility** (keyboard nav, screen reader)

---

## 12. Contact & Support

**Product Owner:** [Your Name]
**Email:** [your-email@example.com]
**Development Team:** [Team Name]
**TestSprite Access URL:** [https://your-app-url.test]
**Test Credentials:**
- **Admin:** username: `admin`, password: `password123`
- **Siswa:** NIS: `10001`, password: `password123`

---

**Document Version:** 1.0
**Last Updated:** 2025-12-23
**Status:** Ready for Testing

---

## Notes for TestSprite:
1. Gunakan environment **staging** untuk testing (jangan production)
2. Semua endpoints di atas bisa di-test via browser atau API client (Postman/Insomnia)
3. Untuk testing upload, gunakan file dummy (images/videos) yang valid
4. Database akan di-reset setiap hari pukul 00:00 UTC (atau sesuai kebutuhan)
5. Jika menemukan bug, report dengan format:
   - **URL:** `/admin/artikel/create`
   - **Steps to Reproduce:** 1. Login admin, 2. Klik "Tambah Artikel", 3. Submit tanpa thumbnail
   - **Expected:** Error message "Thumbnail wajib diisi"
   - **Actual:** Page crash / 500 error
   - **Screenshot:** [attach]
6. Priority levels untuk bug report: **Critical, High, Medium, Low**

**Happy Testing! 🚀**
