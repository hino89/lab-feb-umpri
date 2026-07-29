# Sistem Informasi Peminjaman Laboratorium - FEB UMPRI

Sistem Informasi Manajemen Peminjaman Laboratorium khusus untuk Fakultas Ekonomi dan Bisnis (FEB) Universitas Muhammadiyah Pringsewu (UMPRI). Sistem ini dikembangkan untuk memudahkan mahasiswa dan dosen dalam memesan (booking) ruang laboratorium, serta memudahkan admin/petugas dalam mengelola persetujuan peminjaman, data laboratorium, dan konten website.

## 🛠 Tech Stack

Sistem ini dibangun menggunakan teknologi modern yang berfokus pada kecepatan, keamanan, dan kemudahan _maintenance_:
- **Framework Utama:** Laravel 13 (PHP 8.3+)
- **Frontend / Styling:** Tailwind CSS v3 (JIT Mode)
- **Frontend Interactivity:** AlpineJS (Minimalist JavaScript framework, digunakan untuk _auto-refresh_ jadwal, modal gambar, *dropdowns*)
- **Database:** SQLite (default / _development_) / MySQL (siap produksi)

---

## 📌 Fitur dan Menu Sistem

Sistem dibagi menjadi 2 (dua) sisi utama, yaitu **Sisi Publik (Pengguna/Mahasiswa/Dosen)** dan **Sisi Admin**.

### Sisi Publik (Tidak perlu login)
1. **Beranda Dinamis**
   - Menampilkan *Hero Image* (3 gambar _split diagonal_) yang bisa dikustomisasi secara *real-time* oleh Admin.
   - Daftar 3 Laboratorium utama (Laboratorium Keuangan, Pemasaran, dan SDM) dalam bentuk kartu interaktif.
2. **Detail Laboratorium**
   - Menampilkan gambar-gambar ruangan dalam bentuk *Slider/Lightbox Carousel*.
   - Menyajikan informasi detail, deskripsi, lokasi, dan fasilitas ruang dengan rapi (*text-justify*).
3. **Jadwal Penggunaan (Live & Filterable)**
   - Menampilkan jadwal peminjaman yang *sudah disetujui* (Approved).
   - Terdapat filter tanggal tanpa *full page reload* (menggunakan *AlpineJS fetch DOM replacement*).
4. **Formulir Pengajuan (Booking)**
   - Form _booking_ langsung di halaman detail lab. Meminta nama, NIM/NIDN, status (Mahasiswa/Dosen), tanggal penggunaan, jam mulai/selesai, dan tujuan/keperluan.

### Sisi Admin (Memerlukan Login)
1. **Dashboard**
   - Statistik jumlah Laboratorium, total peminjaman, dan jumlah pengguna (Admin).
   - **Live Peminjaman Terbaru:** Tabel yang akan _auto-refresh_ setiap 10 detik tanpa *reload* halaman. Dilengkapi lencana/indikator "Live" berkedip.
2. **Manajemen Laboratorium**
   - Mengedit data lab (Nama, Deskripsi, Fasilitas, Lokasi, Kapasitas).
   - Mengunggah / Menghapus galeri foto untuk masing-masing lab (mendukung *multiple upload*).
3. **Manajemen Peminjaman (Booking)**
   - Menerima dan melihat detail jadwal masuk (Status awal: Menunggu).
   - Admin dapat mengeklik tombol "Setujui" (Approved) atau "Tolak" (Rejected).
   - Halaman daftar peminjaman juga mendukung *Live Polling/Auto-refresh* setiap 10 detik.
4. **Pengaturan Beranda**
   - Upload dan kelola 3 gambar utama (*Hero Image*) yang tampil di *Homepage*. Jika kosong, sistem otomatis memanggil _placeholder_ (abu-abu).
5. **Manajemen Pengguna (Admin)**
   - Menambah, mengubah, dan menghapus hak akses Admin lainnya. Sistem telah dikunci sehingga hanya role **admin** yang berlaku (tanpa role *user biasa* karena publik tidak perlu login).

---

## 💾 Struktur Database

Sistem ini memiliki tabel-tabel esensial sebagai berikut:
- `users`: Menyimpan data akses login (Nama, Email, Password). Sistem me-*lock* semuanya sebagai Admin.
- `laboratories`: Menyimpan data referensi lab (id, nama, lokasi, kapasitas, deskripsi, fasilitas, is_active).
- `laboratory_images`: Menghubungkan ID lab dengan *path* gambar yang diupload ke *storage*.
- `bookings`: Menyimpan jejak pengajuan peminjaman (id, laboratory_id, booker_name, booker_id, booker_type, purpose, start_time, end_time, status).

### Akun Bawaan (Default Credentials)
Untuk percobaan/login pertama kali ke `/login`, gunakan:
- **Email:** `admin@umpri.ac.id`
- **Password:** `password`

### Letak Penyimpanan File & Gambar (Storage)
Semua file yang diunggah dikelola dengan sistem symlink bawaan Laravel. Letak penyimpanan fisik berada di:
- **Gambar Beranda (Hero):** `storage/app/public/hero/`
- **Gambar Laboratorium:** `storage/app/public/laboratories/`

*Catatan:* Di *server* publik, file-file tersebut dapat diakses pada path url `/storage/hero/` dan `/storage/laboratories/` (berkat adanya _symlink_).

---

## 🚀 Panduan Setup & Deployment Server

Sistem ini dapat dijalankan pada **Server Fisik (Dedicated)** maupun **VPS**. Mengingat potensi penggunaan Web Server **LiteSpeed / OpenLiteSpeed** atau **Apache/Nginx**, ikuti petunjuk berikut:

### 1. Persiapan Awal
Pastikan server memiliki:
- PHP >= 8.3 (beserta ekstensi: dom, curl, libxml, mbstring, zip, pdo, sqlite3 / pdo_mysql)
- Composer 2.x
- Node.js & NPM (Opsional di server produksi, asalkan Anda sudah menjalankan `npm run build` di lokal sebelum *upload* source code).

### 2. Instalasi (Clone & Dependencies)
1. Unggah *Source Code* atau clone dari repository Git ke direktori server (contoh: `/var/www/lab-feb-umpri` atau di `/home/user/public_html/lab-feb-umpri`).
2. Masuk ke direktori tersebut lewat terminal (SSH) dan jalankan:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

### 3. Konfigurasi Lingkungan (.env)
1. Salin `cp .env.example .env`.
2. Generate key: `php artisan key:generate`.
3. Atur konfigurasi Database Anda di `.env`. 
   - Jika pakai **MySQL**, ubah `DB_CONNECTION=mysql` lalu isi `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
   - Jika pakai **SQLite** (bawaan file), biarkan `DB_CONNECTION=sqlite`. File database ada di `database/database.sqlite`.

### 4. Migrasi & Seed Database
Jalankan migrasi tabel beserta *seeder* awal (untuk membuat 3 lab FEB UMPRI dan akun admin default):
```bash
php artisan migrate --seed
php artisan db:seed --class=LabSeeder
```

### 5. Membuat Storage Link (Penting untuk Gambar)
Agar file yang diupload ke direktori `/storage/app/public/` bisa diakses melalui web browser, jalankan:
```bash
php artisan storage:link
```
*(Jika di shared hosting cPanel/LiteSpeed artisan tidak bisa dijalankan, Anda bisa membuat symlink manual atau letakkan script php kecil berisi `Artisan::call('storage:link')` di route).*

### 6. Build Aset Frontend (Tailwind CSS)
Sistem ini menggunakan kelas-kelas *Tailwind JIT* yang *dynamic*. Jika Anda baru mengubah file `.blade.php` di server (tidak disarankan), jalankan perintah:
```bash
npm install
npm run build
```
*(Direkomendasikan: Build file `public/build/` di komputer lokal, lalu upload/commit ke server tanpa perlu install Node.js di server produksi).*

### 7. Konfigurasi Web Server (Khusus LiteSpeed / Apache)
Laravel mensyaratkan **Document Root (direktori utama)** diarahkan ke dalam folder `/public`.

**Jika menggunakan VPS / Control Panel (cPanel/CyberPanel dll):**
- Arahkan konfigurasi Domain/Subdomain Document Root ke `/home/user/public_html/lab-feb-umpri/public`.
- LiteSpeed secara otomatis akan membaca file `.htaccess` bawaan Laravel yang berada di dalam folder `/public/`. Tidak perlu ada konfigurasi khusus *rewrite rule*.

**Jika server *hardcoded* dan Anda meletakkan folder project di dalam folder `public_html/` biasa (tanpa bisa ubah Document Root):**
Buatlah file `.htaccess` di *root folder* (di luar public) yang memaksa *request* masuk ke `public/`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```
Atau lebih disarankan meng-_create symlink_ dari `/public` ke public root direktori web server.

### 8. Hak Akses (Permissions)
Pastikan web server (pengguna `www-data` atau `nobody` atau *user-panel* Anda) memiliki akses tulis ke folder `storage` dan `bootstrap/cache`:
```bash
chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache
```

Sekarang sistem Anda sudah siap diakses secara online! 🎉
