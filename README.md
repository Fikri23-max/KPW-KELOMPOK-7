# Sistem Pemesanan Makanan (Laravel 13 + Blade)

Aplikasi web pemesanan makanan sederhana:
- **Pelanggan**: lihat menu per kategori, cari menu, tambah ke keranjang, checkout, lihat riwayat pesanan.
- **Admin**: dashboard ringkasan, kelola kategori, kelola menu (+ upload gambar), kelola status pesanan.

Dibangun dengan Laravel 13 + Blade template (tanpa build Node.js — Tailwind CSS dimuat lewat CDN agar ringan dijalankan di Termux).

## Struktur file yang disertakan

```
app/Models/            -> User, Category, Menu, Order, OrderItem
app/Http/Controllers/  -> Auth, Menu, Cart, Order, Admin/*
app/Http/Middleware/   -> AdminMiddleware.php
database/migrations/   -> tabel categories, menus, orders, order_items, +role di users
database/seeders/      -> akun admin & contoh menu
routes/web.php         -> semua route
resources/views/       -> semua tampilan Blade
bootstrap/app.php      -> contoh pendaftaran middleware 'admin'
```

## Cara instalasi di Termux

### 1. Siapkan Termux
```bash
pkg update && pkg upgrade -y
pkg install php php-fpm composer sqlite git -y
```
> Gunakan SQLite agar tidak perlu setup MySQL di Termux (lebih ringan).

### 2. Buat proyek Laravel baru
```bash
cd ~
composer create-project laravel/laravel:^13.29 pesanmakan
cd pesanmakan
```

### 3. Timpa/salin file dari paket ini
Ekstrak file zip yang saya berikan, lalu salin **isi foldernya** ke dalam folder proyek `pesanmakan` yang baru dibuat composer tadi (timpa file yang sama, seperti `routes/web.php` dan `bootstrap/app.php`).

Struktur akhirnya harus menyatu dengan proyek Laravel standar (folder `vendor/`, `artisan`, `composer.json`, dll tetap dari hasil `composer create-project`).

### 4. Konfigurasi environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`, arahkan koneksi database ke SQLite:
```
DB_CONNECTION=sqlite
# hapus/comment baris DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

Buat file database SQLite:
```bash
touch database/database.sqlite
```

### 5. Migrasi & seed data awal
```bash
php artisan migrate --seed
```

Ini akan membuat:
- Admin: `admin@resto.test` / `password`
- Pelanggan contoh: `pelanggan@resto.test` / `password`
- 3 kategori + 8 menu contoh

### 6. Buat symlink storage (agar gambar menu tampil)
```bash
php artisan storage:link
```

### 7. Jalankan server
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Buka browser di HP: `http://127.0.0.1:8000`

## Alur pemakaian

1. Daftar/masuk sebagai pelanggan → buka **Menu** → tambah item ke **Keranjang** → checkout.
2. Masuk sebagai admin (`admin@resto.test`) → menu **Admin** akan muncul di navbar → kelola kategori, menu, dan status pesanan yang masuk.

## Update: 5 Produk Baru + Kolom "Produk Pilihan"

Ditambahkan:
- Migration `2026_01_02_000001_add_is_featured_to_menus_table.php` → menambah kolom `is_featured` pada tabel `menus`.
- Seeder `database/seeders/ProdukBaruSeeder.php` → menambahkan 5 produk baru (Sate Ayam Madura, Rendang Sapi, Roti Bakar Coklat Keju, Es Cendol, Jus Alpukat) yang otomatis ditandai sebagai ⭐ Produk Pilihan.
- Admin bisa mencentang "Jadikan Produk Pilihan" saat tambah/ubah menu.

### Jika proyek Laravel SUDAH terinstal sebelumnya di Termux

1. Salin file baru ke proyek (timpa yang sama):
   - `database/migrations/2026_01_02_000001_add_is_featured_to_menus_table.php`
   - `database/seeders/ProdukBaruSeeder.php`
   - `database/seeders/DatabaseSeeder.php`
   - `app/Models/Menu.php`
   - `app/Http/Controllers/Admin/MenuController.php`
   - `resources/views/menu/index.blade.php`
   - `resources/views/admin/menus/_form.blade.php`

2. Pastikan aplikasi sudah tersambung ke database. Cek isi `.env`:
   ```
   DB_CONNECTION=sqlite
   ```
   (atau ganti ke `mysql` jika menggunakan MySQL — lihat bagian "Koneksi Database" di bawah).

3. Jalankan migrasi kolom baru (tanpa menghapus data lama):
   ```bash
   cd ~/pesanmakan
   php artisan migrate
   ```

4. Jalankan seeder produk baru saja:
   ```bash
   php artisan db:seed --class=Database\\Seeders\\ProdukBaruSeeder
   ```
   (Aman dijalankan berkali-kali karena pakai `firstOrCreate` — tidak akan duplikat.)

5. Refresh halaman `/menu` di browser, 5 produk baru akan muncul dengan badge ⭐ Pilihan.

### Jika ingin instal ulang dari nol
```bash
php artisan migrate:fresh --seed
```
Ini akan membuat ulang semua tabel + menjalankan seluruh seeder (termasuk `ProdukBaruSeeder`) sekaligus.

## Update: Template AdminLTE & Tampilan Baru

**Panel Admin** sekarang menggunakan template **AdminLTE 3** (dimuat via CDN — tidak perlu `npm install`):
- Sidebar navigasi gelap dengan ikon (Font Awesome 6)
- Widget statistik (`small-box`) di dashboard
- Tabel & form bergaya Bootstrap 4 yang rapi
- Badge notifikasi jumlah pesanan pending di sidebar
- Warna aksen disesuaikan jadi oranye (`#d35400`) agar senada dengan tema resto

**Halaman Pelanggan** dipercantik dengan:
- Font Google **Poppins**
- Navbar sticky transparan dengan efek blur
- Hero banner gradient di halaman menu
- Kartu menu dengan efek hover mengambang (`card-hover`)
- Badge jumlah item di ikon keranjang pada navbar
- Ikon Font Awesome di berbagai tempat (tombol, status, dsb.)

Semua CDN yang dipakai (Tailwind, AdminLTE, Bootstrap, Font Awesome, Google Fonts) butuh **koneksi internet saat halaman dibuka** — pastikan HP/perangkat yang mengakses browser terhubung ke internet. Tidak ada perubahan pada backend/database dari update ini.

### Menerapkan ke proyek yang sudah ada
Salin/timpa folder `resources/views/` secara keseluruhan ke proyek Laravel Anda. Tidak perlu migrasi ulang — ini murni perubahan tampilan.

## Update: Ilustrasi Gambar Menu & Penyempurnaan Aplikasi

**Gambar produk** — Setiap 13 menu (8 awal + 5 baru) kini punya ilustrasi SVG orisinal yang menyesuaikan bentuk & warna makanannya sendiri (nasi goreng dengan telur mata sapi, sate dengan tusukan, gelas es teh dengan es batu, dst). Keunggulannya:
- **Tidak perlu internet/download** — file SVG disimpan langsung di `public/images/menu/` dan ikut ter-bundle dalam proyek.
- Tidak melanggar hak cipta foto pihak lain (ilustrasi vektor buatan sendiri).
- Admin tetap bisa **mengganti dengan foto asli** kapan saja lewat form "Ubah Menu" (upload gambar) — sistem otomatis mendeteksi mana gambar bawaan dan mana hasil upload lewat accessor `image_url` di model `Menu`.

**Penyempurnaan lain:**
- Thumbnail produk kini juga tampil di halaman **Keranjang**.
- Pagination di panel admin diperbaiki agar bergaya Bootstrap (sebelumnya salah tema/Tailwind).
- Ditambahkan halaman error kustom bertema resto: `404` (halaman tidak ada), `403` (akses ditolak), `500` (server error).
- Favicon 🍽️ dan meta description ditambahkan untuk SEO dasar.

### Menerapkan ke proyek yang sudah ada
1. Salin folder `public/images/menu/` ke proyek Anda.
2. Timpa `app/Models/Menu.php`, `app/Http/Controllers/CartController.php`, `database/seeders/*.php`, dan `resources/views/` dengan file terbaru.
3. Jalankan ulang seeder agar path gambar tersimpan ke data yang sudah ada:
   ```bash
   php artisan db:seed
   ```
   (Aman dijalankan berkali-kali — data lama akan **diperbarui** gambarnya, bukan diduplikasi, berkat `updateOrCreate`.)

Aplikasi ini terhubung ke database melalui file `.env` + `config/database.php` bawaan Laravel. Tidak ada kode khusus yang perlu diubah — cukup atur `.env`:

**Opsi A — SQLite (disarankan untuk Termux, tanpa server DB terpisah):**
```
DB_CONNECTION=sqlite
```
Kosongkan/hapus baris `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, lalu:
```bash
touch database/database.sqlite
php artisan migrate --seed
```

**Opsi B — MySQL/MariaDB (jika sudah instal `pkg install mariadb`):**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pesanmakan
DB_USERNAME=root
DB_PASSWORD=
```
Buat database dulu:
```bash
mysql -u root -e "CREATE DATABASE pesanmakan"
```
Lalu migrasi seperti biasa:
```bash
php artisan migrate --seed
```

Cek koneksi berhasil dengan:
```bash
php artisan tinker
>>> \App\Models\Menu::count();
```
Jika muncul angka (bukan error), berarti aplikasi sudah tersambung ke database dengan benar.

- Tambahkan validasi stok/kuantitas menu.
- Tambahkan integrasi payment gateway (Midtrans/Xendit) untuk QRIS asli.
- Tambahkan notifikasi real-time status pesanan (Laravel Reverb/Pusher).
- Tambahkan role "kasir" terpisah dari admin.
