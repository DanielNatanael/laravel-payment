# PLG Minas — Website Konservasi & Pemesanan Tiket

Website **Pusat Latihan Gajah (PLG) Minas, Riau**: pusat konservasi, pelatihan, dan edukasi gajah sumatera. Selain halaman profil dan blog, pengunjung bisa **memesan tiket masuk secara online**, membayar lewat **Midtrans**, lalu mengunduh e-tiket dalam bentuk PDF.

> Proyek ini dibuat dengan Laravel 10 dan masih berjalan di mode **sandbox** Midtrans (belum untuk transaksi nyata).

## Fitur

**Pengunjung**
- Halaman beranda, tentang kami, kontak, dan blog.
- Formulir kontak: pesan disimpan ke database dan diteruskan lewat email.
- Pemesanan tiket 3 langkah (pilih tiket → isi data → konfirmasi) dengan Livewire.
- Pembayaran online via Midtrans Snap (QRIS, GoPay, transfer bank, kartu kredit).
- Unduh / cetak e-tiket PDF setelah pembayaran berhasil.
- Registrasi, login, edit profil, dan dashboard riwayat booking.

**Admin** (`/admin`, Filament)
- Kelola Tiket, Booking, Pembayaran, dan Pengguna.
- Akses dibatasi untuk role `admin` (Spatie Permission).

## Teknologi

| Bagian | Yang dipakai |
| --- | --- |
| Backend | PHP 8.1+, Laravel 10 |
| Antarmuka dinamis | Livewire 3, Alpine.js |
| Panel admin | Filament 3 |
| Autentikasi | Laravel Breeze, Laravel Sanctum |
| Role & izin | spatie/laravel-permission |
| Pembayaran | Midtrans (midtrans-php) |
| E-tiket PDF | barryvdh/laravel-dompdf |
| Frontend build | Vite, Tailwind CSS |
| Database | MySQL / MariaDB |

## Prasyarat

- PHP 8.1 atau lebih baru (dengan ekstensi umum Laravel: `mbstring`, `xml`, `curl`, `gd`, `pdo_mysql`, dll.)
- [Composer](https://getcomposer.org/) 2
- Node.js 16+ (disarankan 18+) dan npm
- MySQL atau MariaDB

## Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/USERNAME-ANDA/NAMA-REPO.git
cd NAMA-REPO

# 2. Siapkan file environment
cp .env.example .env

# 3. Pasang dependensi
composer install
npm install

# 4. Buat application key
php artisan key:generate
```

Buat database kosong (misalnya `plg_minas`), lalu isi pengaturan database di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plg_minas
DB_USERNAME=root
DB_PASSWORD=
```

Lanjutkan:

```bash
# 5. Buat tabel dan isi data awal (role, akun admin, tiket, contoh booking)
php artisan migrate --seed

# 6. Hubungkan folder storage
php artisan storage:link

# 7. Build aset frontend
npm run build        # atau `npm run dev` saat pengembangan

# 8. Jalankan aplikasi
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Konfigurasi

### Midtrans (sandbox)

1. Daftar di [Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/) dan ambil **Server Key** serta **Client Key**.
2. Isi di `.env`:

```env
MIDTRANS_SERVER_KEY=isi-server-key-sandbox
MIDTRANS_CLIENT_KEY=isi-client-key-sandbox
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

3. Di dashboard Midtrans, atur **Payment Notification URL** ke:

```
https://domain-anda/payment/notification
```

Untuk pengujian di komputer lokal, gunakan tunnel seperti [ngrok](https://ngrok.com/) agar Midtrans bisa menjangkau aplikasi Anda.

> Jangan pernah meng-commit `.env` atau menaruh kunci asli di dalam kode. File `.env` sudah masuk `.gitignore`.

### Email (formulir kontak)

Atur SMTP di `.env`. Contoh memakai Gmail (gunakan *App Password*, bukan password akun):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email-anda@gmail.com
MAIL_PASSWORD=app-password-anda
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email-anda@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

Untuk pengembangan lokal, Anda bisa memakai [Mailpit](https://github.com/axllent/mailpit) (pengaturan bawaan di `.env.example`).

## Akun awal

Seeder membuat satu akun admin:

| | |
| --- | --- |
| URL | `/admin` |
| Email | `admin@example.com` |
| Password | `password` |

**Segera ganti password ini** sebelum aplikasi dipublikasikan. Pengunjung biasa mendaftar sendiri lewat `/register` dan otomatis berperan sebagai pelanggan.

## Alur pemesanan tiket

1. Pengguna login, lalu membuka halaman **Booking** dan memilih jenis serta jumlah tiket.
2. Pengguna mengisi data pemesan dan tanggal kunjungan, lalu mengonfirmasi.
3. Sistem membuat booking dengan kode unik berformat `PLG-XXXXXXXX`.
4. Pengguna membayar melalui Midtrans Snap.
5. Setelah pembayaran berstatus *paid*, e-tiket PDF dapat diunduh atau dicetak.

Tiket bawaan dari seeder: **Dewasa** (Rp15.000), **Anak** (Rp10.000), dan **Balita** (gratis). Harga dan kuota bisa diubah lewat panel admin.

## Struktur folder penting

```
app/
├── Filament/Resources/     # Resource panel admin (Booking, Payment, Ticket, User)
├── Http/Controllers/       # Booking, Payment, Blog, Contact, Profile, Auth
├── Http/Middleware/        # CheckAdminRole
├── Livewire/               # TicketBooking, BookingSearch
├── Models/                 # Ticket, Booking, BookingItem, Payment, Blog, Contact, ...
└── Services/MidtransService.php
config/midtrans.php         # Konfigurasi Midtrans (membaca dari .env)
database/migrations/        # Skema database
database/seeders/           # Role, admin, tiket, contoh booking
resources/views/            # Blade: halaman publik, auth, booking, payment, tiket PDF
routes/web.php              # Rute web utama
```

## Menjalankan test

```bash
php artisan test
```

## Lisensi

Dibangun di atas [Laravel](https://laravel.com), framework open-source berlisensi [MIT](https://opensource.org/licenses/MIT).
