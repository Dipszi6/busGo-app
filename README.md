# 🚌 BusGo — Sistem Informasi Pemesanan Tiket Bus

**BusGo** merupakan aplikasi berbasis web yang dikembangkan sebagai sistem informasi pemesanan tiket bus secara daring. Aplikasi ini dirancang untuk memudahkan pengguna dalam mencari perjalanan, memilih jadwal keberangkatan, melakukan pemesanan tiket, serta menyelesaikan pembayaran secara digital.

Proyek ini dikembangkan sebagai penerapan materi **Rekayasa Perangkat Lunak (RPL)** dengan menerapkan metode pengembangan sistem Waterfall.

---

## 📌 Tentang Proyek

BusGo bertujuan untuk menyediakan simulasi layanan pemesanan tiket bus secara daring melalui satu platform terintegrasi.

Sistem ini dirancang dengan dua jenis pengguna utama:

- **Penumpang:** Pengguna yang melakukan pencarian perjalanan, memilih jadwal, memesan tiket, dan melakukan pembayaran.
- **Administrator:** Pengelola sistem yang bertanggung jawab terhadap pengelolaan data dan operasional layanan pemesanan tiket.

### Tujuan Pengembangan

1. Mempermudah proses pencarian rute dan jadwal keberangkatan bus.
2. Menyediakan sistem pemesanan tiket secara daring.
3. Mengintegrasikan pembayaran digital melalui payment gateway.
4. Mempermudah pengelolaan data perjalanan dan pemesanan.
5. Menerapkan konsep pengembangan perangkat lunak menggunakan framework Laravel.

---

## ✨ Teknologi dan Dependencies

| Kategori | Teknologi / Dependencies | Kegunaan |
|---|---|---|
| Backend | PHP 8.3 | Bahasa pemrograman backend |
| Framework | Laravel 13 | Framework pengembangan aplikasi |
| Frontend | Blade | Template engine |
| Frontend | Tailwind CSS | Styling antarmuka |
| Frontend | JavaScript | Interaktivitas frontend |
| Frontend | Alpine.js | Interaktivitas komponen frontend |
| Database | MySQL | Database Management System |
| Authentication | Laravel Breeze | Autentikasi pengguna |
| Payment Gateway | Midtrans PHP SDK | Integrasi pembayaran digital |
| PDF Generator | Laravel DomPDF | Pembuatan dokumen PDF |
| Asset Bundler | Vite | Pengelolaan dan bundling aset frontend |
| Tunneling | ngrok | Mengekspos server lokal melalui URL publik |
| Version Control | Git & GitHub | Pengelolaan versi kode sumber |

### Dependencies Utama

**Midtrans PHP SDK**

Package untuk mengintegrasikan aplikasi dengan layanan payment gateway Midtrans.

```bash
composer require midtrans/midtrans-php
```

Repository: https://github.com/Midtrans/midtrans-php

**Laravel DomPDF**

Package untuk menghasilkan dokumen PDF berdasarkan tampilan HTML, seperti bukti pemesanan dan tiket perjalanan.

```bash
composer require barryvdh/laravel-dompdf
```

Repository: https://github.com/barryvdh/laravel-dompdf

**ngrok**

Tools tunneling untuk menyediakan URL publik yang mengarah ke server lokal. Digunakan terutama dalam pengujian integrasi webhook atau notifikasi pembayaran Midtrans.

Website: https://ngrok.com/

---

## 🛠️ Fitur Sistem

Fitur-fitur dalam ruang lingkup pengembangan BusGo meliputi:

### Penumpang

- Registrasi dan login pengguna.
- Pencarian kota dan terminal.
- Pencarian rute perjalanan bus.
- Melihat jadwal dan informasi keberangkatan.
- Pemesanan tiket bus.
- Pemilihan kursi penumpang.
- Pembayaran tiket melalui payment gateway.
- Melihat informasi dan riwayat pemesanan.
- Mengakses bukti atau dokumen tiket.

### Administrator

- Dashboard pengelolaan sistem.
- Pengelolaan data kota.
- Pengelolaan data terminal.
- Pengelolaan rute perjalanan.
- Pengelolaan jadwal keberangkatan.
- Pengelolaan informasi bus dan kursi.
- Pengelolaan data pemesanan.
- Pemantauan transaksi pembayaran.

*Catatan: Daftar tersebut merupakan ruang lingkup fitur pengembangan. Implementasi setiap fitur mengikuti kondisi aktual aplikasi.*

---

## 🗂️ Struktur Proyek

Struktur direktori utama aplikasi BusGo:

```text
busGo-app/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   └── Providers/
│
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
├── storage/
├── tests/
│
├── .env.example
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
└── vite.config.js
```

---

## ⚙️ Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan perangkat telah memiliki:

- PHP 8.3 atau versi yang kompatibel.
- Composer.
- Node.js dan NPM.
- MySQL.
- Git.
- ngrok.
- Web server atau lingkungan pengembangan lokal seperti Laragon.

---

## 🚀 Instalasi dan Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan BusGo di lingkungan lokal.

### 1. Clone Repository

```bash
git clone https://github.com/Dipszi6/busGo-app.git
```

Masuk ke direktori proyek:

```bash
cd busGo-app
```

### 2. Install Dependencies

Install seluruh dependensi backend:

```bash
composer install
```

Install dependensi frontend:

```bash
npm install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

Windows CMD:

```bash
copy .env.example .env
```

Kemudian buat application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Buat database MySQL dengan nama:

```text
busgo
```

Sesuaikan konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=busgo
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password berdasarkan konfigurasi MySQL lokal.

### 5. Migrasi Database

Jalankan perintah berikut untuk membuat tabel database:

```bash
php artisan migrate
```

Jika tersedia data awal melalui seeder, jalankan:

```bash
php artisan db:seed
```

### 6. Konfigurasi Midtrans

BusGo menggunakan Midtrans sebagai layanan payment gateway.

Untuk mengaktifkan integrasi pembayaran pada lingkungan pengembangan:

1. Buat akun melalui [Midtrans Dashboard](https://dashboard.midtrans.com/).
2. Aktifkan lingkungan Sandbox.
3. Dapatkan Server Key dan Client Key.
4. Masukkan kredensial sesuai konfigurasi integrasi Midtrans pada aplikasi.
5. Gunakan kredensial Sandbox untuk pengujian transaksi.

Pastikan kredensial disimpan melalui environment variables dan tidak diunggah ke repository publik.

### 7. Konfigurasi ngrok

BusGo menggunakan ngrok sebagai layanan tunneling untuk mengekspos server pengembangan lokal ke internet melalui URL publik.

Penggunaan ngrok diperlukan ketika aplikasi membutuhkan endpoint publik untuk keperluan pengujian integrasi eksternal, seperti penerimaan notifikasi pembayaran (Payment Notification/Webhook) dari Midtrans.

**Langkah konfigurasi:**

1. Unduh dan instal ngrok melalui https://ngrok.com/.
2. Buat akun ngrok dan dapatkan Authtoken.
3. Hubungkan instalasi ngrok dengan akun menggunakan Authtoken.
4. Jalankan server Laravel:

```bash
php artisan serve
```

5. Buka terminal baru dan jalankan:

```bash
ngrok http 8000
```

6. Salin URL HTTPS publik yang dihasilkan ngrok.
7. Gunakan URL tersebut untuk mengonfigurasi endpoint notifikasi pembayaran pada Midtrans Dashboard.

**Catatan:** URL ngrok pada paket gratis dapat berubah ketika sesi tunneling dimulai kembali. Pastikan URL endpoint notifikasi Midtrans diperbarui apabila URL tersebut berubah.

### 8. Build Frontend Assets

Untuk membangun aset frontend:

```bash
npm run build
```

Untuk menjalankan mode pengembangan frontend:

```bash
npm run dev
```

### 9. Jalankan Aplikasi

Jalankan server Laravel:

```bash
php artisan serve
```

Akses aplikasi melalui browser:

```text
http://127.0.0.1:8000
```

---

## 💳 Integrasi Pembayaran

BusGo menggunakan **Midtrans** sebagai payment gateway untuk mendukung proses transaksi pembayaran tiket bus.

Integrasi ini dirancang untuk menyediakan proses pembayaran digital dengan lingkungan pengujian Sandbox sebelum penggunaan kredensial Production.

Pengujian integrasi pembayaran dapat melibatkan:

- Midtrans Sandbox untuk simulasi transaksi.
- Midtrans Payment Notification untuk menerima pembaruan status transaksi.
- ngrok untuk menyediakan endpoint webhook yang dapat diakses dari internet.

Dokumentasi resmi: https://docs.midtrans.com/

---

## 📄 Pembuatan Dokumen PDF

BusGo menggunakan **Laravel DomPDF** untuk menghasilkan dokumen PDF berdasarkan tampilan HTML.

Package ini dapat dimanfaatkan untuk kebutuhan dokumen aplikasi, seperti:

- Bukti pemesanan tiket.
- Informasi perjalanan.
- Dokumen tiket penumpang.

Dokumentasi: https://github.com/barryvdh/laravel-dompdf

---

## 🧪 Pengujian Sistem

Pengujian aplikasi dapat dilakukan menggunakan PHPUnit dan Pest yang tersedia dalam dependensi pengembangan proyek.

Jalankan pengujian dengan perintah:

```bash
php artisan test
```

Pengujian integrasi pembayaran dapat dilakukan menggunakan lingkungan Midtrans Sandbox.

---

## 🔒 Keamanan

Beberapa aspek keamanan yang menjadi perhatian dalam pengembangan BusGo:

- Autentikasi pengguna.
- Validasi input pada formulir.
- Pengelolaan hak akses berdasarkan peran pengguna.
- Perlindungan kredensial melalui environment variables.
- Penggunaan Midtrans Sandbox untuk pengujian pembayaran.
- Penggunaan HTTPS pada endpoint publik untuk kebutuhan integrasi eksternal.

---

## 👨‍💻 Repository

Repository GitHub:

https://github.com/Dipszi6/busGo-app

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan pembelajaran dan akademik. Penggunaan dan distribusi kode mengikuti ketentuan lisensi yang ditetapkan oleh pengembang proyek dan dependensi yang digunakan.

## Contributors

Seluruh kontributor yang telah berpartisipasi dalam pengembangan **BusGo**.

- [@nzlnfz](https://github.com/nzlnfz) | Technical Writer
- [@setiawan-7](https://github.com/setiawan-7) | UI/UX Designer
- [@zamzkhoirul-art](https://github.com/zamzkhoirul-art) | Technical Writer