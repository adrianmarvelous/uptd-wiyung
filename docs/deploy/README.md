# Deploy — Aplikasi Berita Acara UPTB Wiyung

Catatan struktur folder di server (Hostinger):

```
<domain>/
├── laravel_app/                     <- ISI REPO INI (git clone / git pull)
│   ├── app/  routes/  resources/ …
│   └── docs/                        <- panduan pengguna & skrip pendukung
└── public_html/                     <- web root (satu-satunya folder publik)
    ├── index.php                    <- SALINAN ada di docs/deploy/index.php
    ├── .htaccess
    ├── build/                       <- hasil `npm run build` (Vite)
    ├── storage -> ../laravel_app/storage/app/public   (symlink)
    └── spesimen/  templetes/  assets/
```

## 1. File `index.php`
`docs/deploy/index.php` adalah **salinan** dari `public_html/index.php` di server,
disimpan di repo agar perubahannya ikut terversi.

> ⚠️ Penting: baris *maintenance mode* harus menunjuk ke `laravel_app`, **bukan** `laravel`:
>
> ```php
> if (file_exists($maintenance = __DIR__.'/../laravel_app/storage/framework/maintenance.php')) {
> ```
>
> Kalau salah, `php artisan down` tidak akan berfungsi.

## 2. Symlink `public_html/storage`
Wajib dibuat sekali di server, agar berkas hasil unggahan (PDF & tanda tangan) bisa diakses:

```bash
cd <domain>/public_html
ln -s ../laravel_app/storage/app/public storage
```

## 3. Aset frontend (Vite)
`laravel_app/public/build/manifest.json` **harus ada**, kalau tidak halaman akan error
*“Vite manifest not found”*. Setelah clone di server:

```bash
cd laravel_app
npm ci && npm run build
```

Folder `build/` lalu juga perlu ada di web root (`public_html/build`) — di server ini
isinya identik dan bisa disalin.

## 4. Setelah setiap deploy / pull
```bash
cd laravel_app
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 5. Berkas aplikasi web (.htaccess)
Isi `public_html/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## 6. Dokumentasi
- Panduan pengguna (PDF): `docs/Panduan-Pengguna-Berita-Acara-UPTB-Wiyung.pdf`
- Buat ulang PDF: `C:\xampp\php\php.exe laravel_app\docs\build-guide.php`
- Ambil ulang screenshot mobile (butuh Chrome jalan dengan `--remote-debugging-port=9333`):
  `node laravel_app\docs\chrome-shot.js`
