# Sistem Informasi Koperasi Persahabatan

Aplikasi web untuk mengelola operasional Koperasi Persahabatan, mencakup manajemen simpan-pinjam, transaksi toko, inventori, dan manajemen anggota.

## Fitur Utama

- **Manajemen Simpanan**: Kelola simpanan anggota dengan berbagai jenis simpanan
- **Manajemen Pinjaman**: Proses pengajuan, persetujuan, dan cicilan pinjaman dengan skema bunga
- **Manajemen Toko**: Point of Sale (POS), inventori, stok, dan supplier
- **Transaksi**: Pencatatan transaksi lengkap dengan berbagai metode pembayaran
- **Laporan**: Export laporan ke Excel dan PDF
- **Manajemen Anggota**: Data karyawan/anggota dan departemen
- **Role & Permission**: Manajemen hak akses pengguna menggunakan Spatie Permission
- **Barcode**: Generate dan print label barcode produk

## Persyaratan Sistem

- **PHP**: >= 8.0.2
- **MySQL/MariaDB**: >= 5.7 / >= 10.3
- **Composer**: >= 2.0
- **Node.js**: >= 14.x
- **NPM**: >= 6.x

## Teknologi yang Digunakan

- **Framework**: Laravel 9.x
- **Frontend**: Vite, Sass, Axios
- **Authentication**: Laravel Fortify, Laravel Sanctum
- **Database**: MySQL
- **Export**: Maatwebsite Excel, DomPDF
- **Datatables**: Yajra Laravel DataTables
- **Permission**: Spatie Laravel Permission
- **Barcode**: Milon Barcode Generator

## Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd project_koperasi_persahabatan
   ```

2. **Install dependencies PHP**
   ```bash
   composer install
   ```

3. **Install dependencies Node.js**
   ```bash
   npm install
   ```

4. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi database**
   
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=koperasi_persahabatan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Jalankan migration dan seeder**
   ```bash
   php artisan migrate --seed
   ```

6.1 **Kalo mau jalanin dari hasil backup hosting**
   ```bash
   docker compose exec -T db mysql -uroot -psecret db_rs_koperasi < database/{nama_file_backup}.sql
   ```

7. **Buat symbolic link untuk storage**
   ```bash
   php artisan storage:link
   ```

8. **Build assets**
   ```bash
   npm run build
   ```
   
   Atau untuk development:
   ```bash
   npm run dev
   ```

9. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```
   
   Aplikasi akan berjalan di `http://localhost:8000`
   

## Struktur Database

Aplikasi ini mengelola berbagai entitas utama:
- Users & Employees (Pengguna & Karyawan)
- Savings & Loans (Simpanan & Pinjaman)
- Products, Stocks, & Inventory (Produk, Stok, & Inventori)
- Transactions & Orders (Transaksi & Pesanan)
- Suppliers & Stores (Supplier & Toko)
- Payments & Company Balance (Pembayaran & Saldo Koperasi)

## Development

Untuk development dengan hot-reload:
```bash
npm run dev
```

Untuk production build:
```bash
npm run build
```

## Testing

Jalankan test dengan PHPUnit:
```bash
php artisan test
```

## Lisensi

Aplikasi ini menggunakan framework Laravel yang berlisensi [MIT license](https://opensource.org/licenses/MIT).
