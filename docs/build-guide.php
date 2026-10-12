<?php
/**
 * Generator Buku Panduan Pengguna (PDF) untuk Aplikasi Berita Acara UPTB Wiyung.
 * Jalankan:  C:\xampp\php\php.exe laravel_app\docs\build-guide.php
 */

require __DIR__ . '/../vendor/autoload.php';

$tmp = __DIR__ . '/tmp';
if (!is_dir($tmp)) {
    mkdir($tmp, 0777, true);
}

$tanggal = date('d F Y');
$appUrl  = 'https://lightcyan-cassowary-764104.hostingersite.com';
$imgDir  = str_replace('\\', '/', __DIR__) . '/img/';

/**
 * Bikin blok gambar yang otomatis di-skala agar muat di halaman (tanpa terpotong).
 */
function gb_shot(string $imgDir, string $file, string $caption, float $maxW = 168, float $maxH = 218): string
{
    $path = $imgDir . $file;
    $size = @getimagesize($path);
    if (!$size) {
        return '<div class="cap">[gambar tidak ditemukan: ' . htmlspecialchars($file) . ']</div>';
    }
    [$w, $h] = $size;
    $scale = min($maxW / $w, $maxH / $h);
    $W = round($w * $scale, 1);
    $H = round($h * $scale, 1);

    return '<div style="text-align:center;margin:8px 0 10px 0">'
        . '<img src="' . $path . '" style="width:' . $W . 'mm;height:' . $H . 'mm;border:1px solid #b0bec5">'
        . '<div class="cap">' . $caption . '</div></div>';
}

$shot01 = gb_shot($imgDir, '01-login.png', 'Gambar 1. Halaman Login (tampilan ponsel)');
$shot02 = gb_shot($imgDir, '02-dashboard.png', 'Gambar 2. Halaman Utama (Dashboard)');
$shot03 = gb_shot($imgDir, '03-daftar-berita-acara.png', 'Gambar 3. Daftar Berita Acara dan filter bulan');
$shot04 = gb_shot($imgDir, '04-modal-buat.png', 'Gambar 4. Jendela &ldquo;Berita Acara Baru&rdquo;');
$shot05 = gb_shot($imgDir, '05-form-buat.png', 'Gambar 5. Formulir Berita Acara');
$shot06 = gb_shot($imgDir, '06-tanda-tangan.png', 'Gambar 6. Halaman Tanda Tangan dan Simpan');
$shot07 = gb_shot($imgDir, '07-profil.png', 'Gambar 7. Halaman Profil Pengguna');

$html = <<<HTML
<style>
    body        { font-family: sans-serif; font-size: 10.5pt; color: #222; line-height: 1.5; }
    h1          { font-size: 17pt; color: #14424f; border-bottom: 2px solid #14424f; padding-bottom: 4px; margin-bottom: 12px; }
    h2          { font-size: 13pt; color: #1d6a7f; margin-top: 16px; margin-bottom: 6px; }
    h3          { font-size: 11.5pt; color: #333; margin-top: 12px; margin-bottom: 4px; }
    p           { margin: 5px 0; }
    ul, ol      { margin: 5px 0 5px 16px; }
    li          { margin-bottom: 3px; }
    table       { border-collapse: collapse; width: 100%; margin: 8px 0; }
    th, td      { border: 1px solid #b9c6cc; padding: 5px 7px; font-size: 9.5pt; vertical-align: top; }
    th          { background: #e8f1f5; text-align: left; }
    code        { background: #f2f2f2; padding: 1px 3px; font-size: 9.5pt; }
    .cover      { text-align: center; }
    .cover .t1  { font-size: 13pt; color: #1d6a7f; letter-spacing: 2px; margin-top: 120px; }
    .cover .t2  { font-size: 26pt; font-weight: bold; color: #14424f; margin-top: 10px; }
    .cover .t3  { font-size: 15pt; color: #455a64; margin-top: 6px; }
    .cover .rule{ border-top: 3px solid #14424f; width: 55%; margin: 22px 0 22px 22.5%; }
    .cover .meta{ margin-top: 150px; font-size: 11pt; color: #37474f; }
    .shot       { width: 63mm; border: 1px solid #b0bec5; }
    .shotwrap   { text-align: center; margin: 8px 0 10px 0; }
    .cap        { font-size: 8.5pt; color: #607d8b; margin-top: 2px; }
    .tip        { background: #eef7ee; border-left: 4px solid #4a8f4a; padding: 7px 9px; margin: 8px 0; }
    .warn       { background: #fdf3e7; border-left: 4px solid #d08a2c; padding: 7px 9px; margin: 8px 0; }
    .note       { background: #eef2fb; border-left: 4px solid #3b6ea5; padding: 7px 9px; margin: 8px 0; }
    .pb         { page-break-after: always; }
    .small      { font-size: 9pt; color: #607d8b; }
    .toc td     { border: none; padding: 2px 4px; font-size: 10.5pt; }
    .toc .n     { width: 8%; }
</style>

<!-- ================= COVER ================= -->
<div class="cover">
    <div class="t1">BUKU PANDUAN PENGGUNA</div>
    <div class="t2">Aplikasi Berita Acara<br>UPTB Wiyung</div>
    <div class="rule"></div>
    <div class="t3">Sistem Pencatatan Berita Acara<br>PBJT (Pajak Barang dan Jasa Tertentu) &amp; PBB</div>

    <div class="meta">
        <p><b>Versi Dokumen:</b> 1.0</p>
        <p><b>Tanggal:</b> {$tanggal}</p>
        <p><b>Alamat Aplikasi:</b><br>{$appUrl}</p>
        <p class="small">Dokumen ini ditujukan untuk petugas dan administrator<br>yang menggunakan aplikasi Berita Acara UPTB Wiyung.</p>
    </div>
</div>
<div class="pb"></div>

<!-- ================= DAFTAR ISI ================= -->
<h1>Daftar Isi</h1>
<table class="toc">
    <tr><td class="n">1.</td><td>Pendahuluan</td></tr>
    <tr><td>2.</td><td>Persiapan dan Akses Aplikasi</td></tr>
    <tr><td>3.</td><td>Masuk dan Keluar (Login &amp; Logout)</td></tr>
    <tr><td>4.</td><td>Peran Pengguna</td></tr>
    <tr><td>5.</td><td>Halaman Utama (Dashboard)</td></tr>
    <tr><td>6.</td><td>Menu Berita Acara (PBJT dan PBB)</td></tr>
    <tr><td>7.</td><td>Membuat Berita Acara Baru</td></tr>
    <tr><td>8.</td><td>Mengunggah Berita Acara (Scan/PDF)</td></tr>
    <tr><td>9.</td><td>Mencetak dan Mengunduh PDF</td></tr>
    <tr><td>10.</td><td>Mengirim Berita Acara via WhatsApp</td></tr>
    <tr><td>11.</td><td>Mengedit Berita Acara</td></tr>
    <tr><td>12.</td><td>Profil Pengguna</td></tr>
    <tr><td>13.</td><td>Menu Administrator</td></tr>
    <tr><td>14.</td><td>Tips, Kendala, dan Pertanyaan Umum (FAQ)</td></tr>
    <tr><td>15.</td><td>Bantuan dan Dukungan</td></tr>
</table>

<!-- ================= 1 ================= -->
<div class="pb"></div>
<h1>1. Pendahuluan</h1>

<h2>1.1 Tentang Aplikasi</h2>
<p>Aplikasi Berita Acara UPTB Wiyung adalah aplikasi berbasis web yang digunakan untuk
mencatat, menyimpan, mencari, dan mencetak <b>Berita Acara</b> hasil pemeriksaan Wajib Pajak
Daerah di lingkungan UPTB Wiyung. Aplikasi ini menggantikan pencatatan manual dan
memudahkan petugas menyimpan tanda tangan, membuat dokumen PDF, serta mengirim
dokumen kepada Wajib Pajak melalui WhatsApp.</p>

<h2>1.2 Fungsi Utama</h2>
<ul>
    <li>Mencatat Berita Acara untuk dua jenis pajak: <b>PBJT</b> dan <b>PBB</b>.</li>
    <li>Mencari data Wajib Pajak (NOP, Nama, Alamat) secara otomatis.</li>
    <li>Menyimpan tanda tangan Wajib Pajak secara digital pada Berita Acara.</li>
    <li>Membuat dokumen <b>PDF</b> Berita Acara secara otomatis.</li>
    <li>Menyaring data berdasarkan <b>bulan dan tahun</b> serta pencarian kata kunci.</li>
    <li>Rekapitulasi Berita Acara per petugas dan per Wajib Pajak (menu Administrator).</li>
</ul>

<h2>1.3 Istilah yang Digunakan</h2>
<table>
    <tr><th style="width:22%">Istilah</th><th>Penjelasan</th></tr>
    <tr><td><b>Berita Acara</b></td><td>Dokumen resmi hasil pemeriksaan/kunjungan kepada Wajib Pajak.</td></tr>
    <tr><td><b>PBJT</b></td><td>Pajak Barang dan Jasa Tertentu (sebelumnya dikenal sebagai pajak hotel, restoran, hiburan, dll).</td></tr>
    <tr><td><b>PBB</b></td><td>Pajak Bumi dan Bangunan.</td></tr>
    <tr><td><b>NOP</b></td><td>Nomor Objek Pajak, yaitu identitas objek pajak milik Wajib Pajak.</td></tr>
    <tr><td><b>Wajib Pajak (WP)</b></td><td>Orang atau badan yang memiliki kewajiban perpajakan.</td></tr>
    <tr><td><b>Petugas</b></td><td>Pegawai yang melakukan pemeriksaan dan dicatat pada Berita Acara.</td></tr>
    <tr><td><b>Administrator</b></td><td>Pengguna dengan hak akses tambahan untuk melihat rekapitulasi.</td></tr>
</table>

<!-- ================= 2 ================= -->
<h1>2. Persiapan dan Akses Aplikasi</h1>

<h2>2.1 Perangkat dan Browser</h2>
<p>Aplikasi dapat dibuka melalui peramban (browser) pada komputer maupun telepon pintar.</p>
<table>
    <tr><th style="width:30%">Komponen</th><th>Keterangan</th></tr>
    <tr><td>Browser yang disarankan</td><td>Google Chrome, Microsoft Edge, Mozilla Firefox, atau Safari (versi terbaru).</td></tr>
    <tr><td>Koneksi internet</td><td>Diperlukan, minimal 1 Mbps.</td></tr>
    <tr><td>Resolusi layar</td><td>Disarankan 1366 x 768 atau lebih besar. Tampilan tetap dapat digunakan pada layar kecil.</td></tr>
    <tr><td>JavaScript</td><td>Harus aktif (untuk pencarian otomatis dan tanda tangan digital).</td></tr>
</table>

<h2>2.2 Alamat Aplikasi</h2>
<p>Buka browser dan ketikkan alamat berikut:</p>
<p class="note"><b>{$appUrl}</b><br>
Simpan alamat ini sebagai <i>bookmark</i> agar mudah dibuka kembali.</p>

<h2>2.3 Akun Pengguna</h2>
<p>Akun pengguna <b>tidak dapat mendaftar sendiri</b>. Setiap petugas akan diberikan
<b>username</b> dan <b>kata sandi</b> oleh Administrator. Hubungi Administrator apabila
username atau kata sandi belum diterima.</p>

<!-- ================= 3 ================= -->
<div class="pb"></div>
<h1>3. Masuk dan Keluar (Login &amp; Logout)</h1>

<h2>3.1 Cara Masuk (Login)</h2>
{$shot01}
<ol>
    <li>Buka alamat aplikasi. Halaman <b>Login</b> akan muncul secara otomatis.</li>
    <li>Isi kolom <b>Username</b> dengan username yang diberikan Administrator
        (contoh: <code>uptb_wiyung</code>).</li>
    <li>Isi kolom <b>Password</b> dengan kata sandi Anda.</li>
    <li>(Opsional) Centang <b>Remember me</b> agar tidak perlu login ulang pada perangkat pribadi.
        <span class="small">Jangan centang pada komputer bersama.</span></li>
    <li>Klik tombol <b>Log in</b>. Jika berhasil, Anda akan diarahkan ke Halaman Utama (Dashboard).</li>
</ol>

<div class="warn">
    <b>Perhatian:</b> Demi keamanan, sistem membatasi maksimal <b>5 kali percobaan login</b> yang gagal.
    Apabila terlampaui, akun akan diblokir sementara (sekitar 1 menit) dan Anda harus menunggu
    sebelum mencoba lagi. Pastikan tombol <i>Caps Lock</i> tidak aktif.
</div>

<div class="tip">
    <b>Lupa kata sandi?</b> Fitur reset kata sandi belum tersedia pada aplikasi ini.
    Silakan hubungi Administrator untuk mengatur ulang kata sandi Anda.
</div>

<h2>3.2 Cara Keluar (Logout)</h2>
<ol>
    <li>Klik nama pengguna (<b>Hi, ...</b>) pada sudut kanan atas.</li>
    <li>Pilih menu <b>Logout</b>.</li>
</ol>
<div class="note">
    Selalu lakukan <b>Logout</b> apabila menggunakan komputer bersama orang lain, agar data tidak
    dapat diakses oleh orang yang tidak berkepentingan.
</div>

<!-- ================= 4 ================= -->
<h1>4. Peran Pengguna</h1>
<p>Aplikasi memiliki dua peran (role) pengguna:</p>
<table>
    <tr><th style="width:22%">Peran</th><th>Hak Akses</th></tr>
    <tr>
        <td><b>Petugas</b></td>
        <td>Membuat, mencari, memfilter, mengedit Berita Acara, membuat PDF, mengirim via WhatsApp,
            serta mengubah profil sendiri.</td>
    </tr>
    <tr>
        <td><b>Administrator</b></td>
        <td>Memiliki seluruh hak akses Petugas, ditambah menu rekapitulasi
            (Berita Acara Petugas, Berita Acara Wajib Pajak, dan Perbaikan Format NOP).</td>
    </tr>
</table>
<div class="note">
    Menu Administrator hanya muncul apabila akun Anda memiliki peran <b>admin</b>.
    Jika Anda merasa seharusnya memiliki akses tersebut, hubungi Administrator sistem.
</div>

<!-- ================= 5 ================= -->
<div class="pb"></div>
<h1>5. Halaman Utama (Dashboard)</h1>
<p>Setelah login, Anda akan diarahkan ke Halaman Utama. Halaman ini menampilkan ringkasan data.</p>
{$shot02}

<h2>5.1 Bagian-bagian Dashboard</h2>
<ul>
    <li><b>Sidebar (kiri)</b> &mdash; menu utama: <i>Berita Acara PBJT</i> dan <i>Berita Acara PBB</i>.</li>
    <li><b>Kartu ringkasan</b> &mdash; jumlah total Berita Acara PBJT dan PBB.</li>
    <li><b>Nama pengguna</b> (kanan atas) &mdash; berisi menu Profil dan Logout.</li>
</ul>

<div class="note">
    <b>Khusus Administrator</b>, Dashboard juga menampilkan statistik tambahan: jumlah Berita Acara
    <i>hari ini</i>, <i>minggu ini</i>, <i>bulan ini</i>, grafik batang per bulan, diagram
    perbandingan PBB &amp; PBJT, serta <i>Top 5 Petugas</i> dengan Berita Acara terbanyak.
</div>

<!-- ================= 6 ================= -->
<h1>6. Menu Berita Acara (PBJT dan PBB)</h1>
<p>Terdapat dua daftar Berita Acara yang dipisahkan berdasarkan jenis pajak. Keduanya memiliki
tampilan dan cara penggunaan yang sama:</p>
<ul>
    <li><b>Berita Acara PBJT</b> &mdash; menu <i>Berita Acara PBJT</i> pada sidebar.</li>
    <li><b>Berita Acara PBB</b> &mdash; menu <i>Berita Acara PBB</i> pada sidebar.</li>
</ul>
{$shot03}

<h2>6.1 Kolom-kolom Tabel</h2>
<table>
    <tr><th style="width:20%">Kolom</th><th>Keterangan</th></tr>
    <tr><td>No</td><td>Nomor urut data pada halaman yang sedang dibuka.</td></tr>
    <tr><td>NOP</td><td>Nomor Objek Pajak milik Wajib Pajak.</td></tr>
    <tr><td>Wajib Pajak</td><td>Nama Wajib Pajak.</td></tr>
    <tr><td>Alamat</td><td>Alamat objek pajak.</td></tr>
    <tr><td>Narasi</td><td>Uraian hasil pemeriksaan.</td></tr>
    <tr><td>Pegawai 1 / 2</td><td>Nama petugas yang melakukan pemeriksaan.</td></tr>
    <tr><td>Tanggal</td><td>Tanggal Berita Acara dibuat (format dd-mm-yyyy).</td></tr>
    <tr><td>Aksi</td><td>Tombol tindakan: WhatsApp, PDF, dan Edit (lihat bagian 6.5).</td></tr>
</table>

<h2>6.2 Pencarian</h2>
<ol>
    <li>Isi kotak <b>&ldquo;Cari NOP / Nama / Alamat / Narasi...&rdquo;</b> di atas tabel.</li>
    <li>Klik tombol <b>Cari</b>. Hasil akan otomatis disaring.</li>
    <li>Klik tombol <b>Reset</b> untuk mengembalikan ke pengaturan awal.</li>
</ol>

<h2>6.3 Filter Bulan (Bulan dan Tahun)</h2>
<p>Di samping kotak pencarian terdapat kolom <b>filter bulan</b> yang sekaligus menentukan tahun.</p>
<ul>
    <li>Secara <b>default</b>, daftar hanya menampilkan data <b>bulan berjalan</b> (bulan dan tahun saat ini).</li>
    <li>Klik kolom tersebut untuk memilih bulan dan tahun yang diinginkan, lalu klik <b>Cari</b>.</li>
    <li>Klik <b>Semua Bulan</b> untuk menampilkan <i>seluruh</i> data tanpa filter bulan.</li>
</ul>
<div class="tip">
    Apabila data yang dicari tidak muncul, periksa terlebih dahulu <b>filter bulan</b>.
    Data dari bulan lain tidak akan tampil sampai filter diubah atau tombol
    <b>Semua Bulan</b> diklik.
</div>

<h2>6.4 Perpindahan Halaman (Pagination)</h2>
<p>Daftar ditampilkan <b>25 data per halaman</b>. Gunakan tombol halaman
(<b>&laquo; Previous</b>, angka halaman, <b>Next &raquo;</b>) di bawah tabel untuk berpindah halaman.
Filter dan pencarian yang aktif akan tetap terbawa saat berpindah halaman.</p>

<h2>6.5 Tombol Aksi pada Setiap Baris</h2>
<p>Klik tombol titik tiga (<b>&#8942;</b>) pada kolom <i>Aksi</i> untuk membuka menu tindakan:</p>
<table>
    <tr><th style="width:22%">Menu</th><th>Fungsi</th></tr>
    <tr><td><b>Whatsapp</b></td><td>Membuka WhatsApp dengan pesan berisi tautan dokumen Berita Acara, untuk dikirim ke nomor Wajib Pajak.</td></tr>
    <tr><td><b>PDF</b></td><td>Membuka dokumen PDF Berita Acara. Apabila berkas hasil unggahan tersedia, berkas tersebut akan dibuka; jika tidak, PDF akan dibuat otomatis oleh sistem.</td></tr>
    <tr><td><b>Edit</b></td><td>Membuka formulir Berita Acara untuk diperbarui (lihat bagian 11).</td></tr>
    <tr><td><b>Hapus</b></td><td><b>Belum tersedia.</b> Menu ini masih dalam pengembangan dan belum berfungsi.</td></tr>
</table>

<!-- ================= 7 ================= -->
<div class="pb"></div>
<h1>7. Membuat Berita Acara Baru</h1>
<p>Pembuatan Berita Acara terdiri atas <b>tiga langkah</b>: memilih Wajib Pajak, mengisi formulir,
lalu menandatangani dan menyimpan.</p>

<h2>7.1 Langkah 1 &mdash; Pilih Wajib Pajak</h2>
<p>Pada halaman daftar (PBJT atau PBB), klik tombol <b>Buat Berita Acara PBJT</b>
(atau <b>Buat Berita Acara PBB</b>) di atas tabel.</p>
{$shot04}
<p>Jendela <b>Berita Acara Baru</b> mendukung dua cara pengisian:</p>
<h3>A. Wajib Pajak sudah terdaftar</h3>
<ol>
    <li>Ketik minimal <b>2 karakter</b> pada kolom <b>NOP</b>. Daftar Wajib Pajak akan muncul otomatis.</li>
    <li>Klik salah satu hasil pencarian. Kolom <b>Nama</b> dan <b>Alamat</b> akan terisi otomatis.</li>
    <li>Perhatikan keterangan berwarna hijau <i>&ldquo;Wajib pajak terdaftar&rdquo;</i>, lalu klik tombol
        <b>Selanjutnya</b>.</li>
</ol>
<h3>B. Wajib Pajak baru (belum terdaftar)</h3>
<ol>
    <li>Isi kolom <b>NOP</b>, <b>Nama</b>, dan <b>Alamat</b> secara manual.</li>
    <li>Sistem akan menampilkan keterangan berwarna biru
        <i>&ldquo;Wajib pajak baru &mdash; akan didaftarkan otomatis&rdquo;</i>.</li>
    <li>Klik tombol <b>Selanjutnya</b> untuk membuka formulir Berita Acara.</li>
</ol>
<div class="tip">
    Wajib Pajak baru <b>tidak perlu didaftarkan lebih dulu</b>. Data Nama dan Alamat yang Anda isi
    akan disimpan otomatis sebagai data Wajib Pajak pada saat Berita Acara disimpan
    (halaman PBJT tersimpan dengan jenis <i>OP</i>, halaman PBB dengan jenis <i>pbb</i>).
</div>
<div class="warn">
    Pastikan penulisan <b>NOP</b>, <b>Nama</b>, dan <b>Alamat</b> benar sebelum melanjutkan. NOP yang
    sudah terdaftar akan langsung memakai data Wajib Pajak yang tersimpan di sistem, sedangkan NOP
    yang belum terdaftar akan dibuat sebagai data Wajib Pajak baru.
</div>

<h2>7.2 Langkah 2 &mdash; Isi Formulir Berita Acara</h2>
{$shot05}
<table>
    <tr><th style="width:22%">Kolom</th><th>Keterangan</th></tr>
    <tr><td><b>NOP</b></td><td>Terisi otomatis dari langkah 1 (dapat dicari ulang).</td></tr>
    <tr><td><b>Nama</b></td><td>Terisi otomatis; dapat dicari ulang melalui kotak pencarian.</td></tr>
    <tr><td><b>Alamat</b></td><td>Terisi otomatis; dapat dicari ulang.</td></tr>
    <tr><td><b>Nama Responden</b></td><td><b>Wajib diisi.</b> Nama orang yang ditemui/diperiksa saat pemeriksaan.</td></tr>
    <tr><td><b>Nomer Whatsapp</b></td><td><b>Wajib diisi.</b> Nomor WhatsApp Wajib Pajak. Awali dengan <b>62</b> (contoh: 6281234567890). Nomor yang diawali <b>0</b> akan diubah otomatis menjadi 62.</td></tr>
    <tr><td><b>Narasi</b></td><td><b>Wajib diisi.</b> Uraian hasil pemeriksaan. Tersedia editor teks (tebal, miring, garis bawah, daftar bernomor, dan tabel).</td></tr>
    <tr><td><b>Petugas 1</b></td><td><b>Wajib dipilih.</b> Nama petugas utama.</td></tr>
    <tr><td><b>Petugas 2</b></td><td>Opsional. Pilih <b>&ldquo;Tidak ada&rdquo;</b> apabila pemeriksaan dilakukan oleh satu petugas.</td></tr>
</table>
<p>Setelah seluruh kolom terisi, klik tombol <b>Masukan Tanda Tangan Wajib Pajak</b>.</p>

<h2>7.3 Langkah 3 &mdash; Tanda Tangan dan Simpan</h2>
{$shot06}
<ol>
    <li>Halaman konfirmasi akan menampilkan ringkasan seluruh data yang telah diisi. Periksa kembali kebenarannya.</li>
    <li>Minta Wajib Pajak menandatangani pada area tanda tangan menggunakan mouse (komputer) atau jari (layar sentuh).</li>
    <li>Bila tanda tangan perlu diulang, klik <b>Clear Tanda Tangan</b>.</li>
    <li>Klik tombol <b>Simpan</b> untuk menyimpan Berita Acara.</li>
    <li>Setelah tersimpan, Anda akan diarahkan kembali ke daftar dengan pesan
        <i>&ldquo;Berita Acara berhasil disimpan&rdquo;</i>.</li>
</ol>
<div class="tip">
    Tanda tangan bersifat <b>opsional</b>. Apabila Wajib Pajak tidak dapat menandatangani saat itu,
    Berita Acara tetap dapat disimpan dan tanda tangan dapat ditambahkan kemudian melalui menu
    <b>Edit</b>.
</div>
<div class="warn">
    Jangan menutup browser atau berpindah halaman sebelum proses simpan selesai. Pastikan muncul
    pesan berhasil disimpan.
</div>

<!-- ================= 8 ================= -->
<div class="pb"></div>
<h1>8. Mengunggah Berita Acara (Scan/PDF)</h1>
<p>Apabila Berita Acara dibuat secara manual (tulisan tangan) lalu dipindai, berkasnya dapat
diunggah ke sistem.</p>
<ol>
    <li>Buka formulir Berita Acara (melalui tombol <b>Buat Berita Acara</b>,
        atau menu <b>Edit</b> pada data yang sudah ada).</li>
    <li>Klik tombol <b>Upload Berita Acara</b> pada sudut kanan atas formulir.</li>
    <li>Pilih berkas <b>PDF</b> yang akan diunggah (format <code>.pdf</code>).</li>
    <li>Pilih <b>Petugas 1</b> dan (bila ada) <b>Petugas 2</b>.</li>
    <li>Klik <b>Upload Berita Acara</b> untuk menyimpan.</li>
</ol>
<div class="note">
    Apabila berkas sudah pernah diunggah, sistem akan menampilkan <b>File Saat Ini</b>.
    Tombol pada jendela ini berubah menjadi <b>Update File &amp; Petugas</b> sehingga Anda dapat
    mengganti berkas lama dengan yang baru.
</div>

<h1>9. Mencetak dan Mengunduh PDF</h1>
<p>Sistem dapat membuat dokumen PDF Berita Acara secara otomatis, lengkap dengan data Wajib Pajak,
narasi, nama petugas, tanda tangan Wajib Pajak, serta gambar spesimen tanda tangan petugas.</p>
<ol>
    <li>Buka daftar Berita Acara (PBJT atau PBB).</li>
    <li>Pada baris data yang dituju, klik tombol titik tiga (<b>&#8942;</b>) pada kolom <i>Aksi</i>.</li>
    <li>Pilih <b>PDF</b>. Dokumen akan dibuka pada tab baru.</li>
    <li>Simpan atau cetak dokumen melalui menu browser
        (<b>Ctrl + S</b> untuk menyimpan, <b>Ctrl + P</b> untuk mencetak).</li>
</ol>
<div class="tip">
    Bila tombol <b>PDF</b> diarahkan ke berkas hasil unggahan, berarti Berita Acara tersebut
    menggunakan berkas pindaian, bukan dokumen yang dibuat sistem.
</div>

<h1>10. Mengirim Berita Acara via WhatsApp</h1>
<ol>
    <li>Pada kolom <i>Aksi</i>, klik titik tiga (<b>&#8942;</b>) lalu pilih <b>Whatsapp</b>.</li>
    <li>WhatsApp akan terbuka (WhatsApp Web atau aplikasi) dengan pesan yang telah berisi
        tautan dokumen Berita Acara.</li>
    <li>Periksa nomor tujuan, tambahkan pesan bila perlu, lalu klik <b>Kirim</b>.</li>
</ol>
<div class="note">
    Nomor tujuan diambil dari kolom <b>Nomer Whatsapp</b> pada Berita Acara. Pastikan nomor
    tersebut benar. Apabila belum sesuai, perbaiki melalui menu <b>Edit</b> terlebih dahulu.
</div>

<h1>11. Mengedit Berita Acara</h1>
<ol>
    <li>Pada kolom <i>Aksi</i>, klik titik tiga (<b>&#8942;</b>) lalu pilih <b>Edit</b>.</li>
    <li>Formulir akan terbuka dengan data yang sudah terisi sebelumnya.</li>
    <li>Ubah data yang diperlukan (misalnya narasi, petugas, nomor WhatsApp, atau tanda tangan).</li>
    <li>Klik <b>Masukan Tanda Tangan Wajib Pajak</b>, lalu pada halaman konfirmasi klik <b>Simpan</b>.</li>
</ol>
<div class="note">
    Untuk mengganti berkas pindaian pada data yang sudah ada, gunakan tombol
    <b>Edit Upload Berita Acara</b> pada formulir.
</div>

<!-- ================= 12 ================= -->
<div class="pb"></div>
<h1>12. Profil Pengguna</h1>
<p>Menu <b>Profile</b> digunakan untuk mengubah data akun Anda sendiri.</p>
{$shot07}
<table>
    <tr><th style="width:30%">Bagian</th><th>Fungsi</th></tr>
    <tr><td><b>Profile Information</b></td><td>Mengubah <b>Name</b> (nama tampilan) dan <b>Username</b>. Klik <b>Save</b> untuk menyimpan.</td></tr>
    <tr><td><b>Update Password</b></td><td>Mengubah kata sandi. Isi <i>Current Password</i>, <i>New Password</i>, dan <i>Confirm Password</i>, lalu klik <b>Save</b>.</td></tr>
    <tr><td><b>Delete Account</b></td><td>Menghapus akun secara permanen. <b>Gunakan dengan sangat hati-hati</b> &mdash; data tidak dapat dikembalikan.</td></tr>
</table>
<div class="warn">
    Menu <b>Delete Account</b> akan menghapus akun beserta hak aksesnya secara permanen.
    Jangan gunakan tanpa persetujuan Administrator.
</div>

<!-- ================= 13 ================= -->
<h1>13. Menu Administrator</h1>
<p>Menu berikut hanya tersedia bagi pengguna dengan peran <b>admin</b>.</p>

<h2>13.1 Berita Acara Petugas</h2>
<p>Menampilkan rekapitulasi jumlah Berita Acara yang dibuat oleh setiap petugas.</p>
<ul>
    <li>Pilih bulan melalui tab <b>Januari &ndash; Desember</b> di bagian atas halaman.</li>
    <li>Tab untuk bulan yang belum berjalan akan berwarna abu-abu dan tidak dapat diklik.</li>
    <li>Klik tombol <b>Detail</b> pada salah satu petugas untuk melihat rincian Berita Acara petugas tersebut.</li>
</ul>

<h2>13.2 Berita Acara Wajib Pajak</h2>
<p>Menampilkan rekapitulasi jumlah Berita Acara per Wajib Pajak, dikelompokkan menurut jenis
pajak (PBJT atau PBB) dan bulan.</p>
<ul>
    <li>Pilih bulan dan tahun yang diinginkan.</li>
    <li>Klik <b>Detail</b> untuk melihat rincian Berita Acara milik Wajib Pajak tersebut.</li>
</ul>

<h2>13.3 Perbaikan Format NOP</h2>
<p>Fitur ini menyeragamkan format seluruh NOP dengan mengganti tanda hubung (<code>-</code>)
menjadi titik (<code>.</code>).</p>
<div class="warn">
    <b>Hati-hati:</b> tindakan ini mengubah <b>seluruh</b> data NOP sekaligus dan bersifat massal.
    Jalankan hanya bila memang diperlukan, dan pastikan data telah dicadangkan terlebih dahulu.
</div>

<!-- ================= 14 ================= -->
<div class="pb"></div>
<h1>14. Tips, Kendala, dan Pertanyaan Umum (FAQ)</h1>

<h3>Data yang dicari tidak muncul</h3>
<p>Periksa <b>filter bulan</b> terlebih dahulu. Secara default daftar hanya menampilkan bulan
berjalan. Klik <b>Semua Bulan</b> untuk menampilkan seluruh data.</p>

<h3>NOP belum terdaftar saat membuat Berita Acara</h3>
<p>NOP yang belum terdaftar dapat langsung dipakai: isi kolom <b>NOP</b>, <b>Nama</b>, dan
<b>Alamat</b> pada jendela <b>Berita Acara Baru</b>. Sistem akan mendaftarkan Wajib Pajak baru
tersebut secara otomatis ketika Berita Acara disimpan. Pastikan Nama dan Alamat sudah benar, karena
data inilah yang tersimpan. Hubungi Administrator apabila data perlu diperbaiki setelah tersimpan.</p>

<h3>Tidak bisa login</h3>
<ul>
    <li>Periksa penulisan <i>username</i> dan kata sandi (perhatikan huruf besar/kecil).</li>
    <li>Pastikan <i>Caps Lock</i> tidak aktif.</li>
    <li>Apabila muncul peringatan percobaan login berlebih, tunggu sekitar 1 menit lalu coba lagi.</li>
    <li>Bila masih gagal, hubungi Administrator untuk pengaturan ulang kata sandi.</li>
</ul>

<h3>Tanda tangan sulit dibuat</h3>
<p>Gunakan mouse secara perlahan, atau gunakan perangkat layar sentuh (tablet/telepon pintar)
agar tanda tangan lebih rapi. Tanda tangan dapat diulang dengan tombol <b>Clear Tanda Tangan</b>.</p>

<h3>Tombol PDF tidak membuka dokumen</h3>
<p>Pastikan browser tidak memblokir <i>pop-up</i>. Coba buka kembali, atau gunakan browser lain
yang disarankan.</p>

<h3>Nomor WhatsApp tidak dapat dihubungi</h3>
<p>Periksa kembali kolom <b>Nomer Whatsapp</b> pada data tersebut. Nomor harus diawali
<b>62</b> (kode negara Indonesia) tanpa tanda <b>+</b> atau <b>0</b> di depan.</p>

<h3>Tampilan berubah atau data tidak tersimpan</h3>
<p>Muat ulang halaman (<b>Ctrl + F5</b>). Apabila masalah berlanjut, hubungi Administrator.</p>

<!-- ================= 15 ================= -->
<h1>15. Bantuan dan Dukungan</h1>
<p>Apabila Anda mengalami kendala teknis atau memerlukan akun baru, silakan menghubungi:</p>
<table>
    <tr><th style="width:30%">Keperluan</th><th>Hubungi</th></tr>
    <tr><td>Akun baru / reset kata sandi</td><td>Administrator Sistem &mdash; UPTB Wiyung</td></tr>
    <tr><td>Data Wajib Pajak belum tersedia</td><td>Administrator Sistem &mdash; UPTB Wiyung</td></tr>
    <tr><td>Kendala teknis aplikasi</td><td>Tim Teknologi Informasi &mdash; UPTB Wiyung</td></tr>
</table>
<p class="small">Dokumen ini disusun sebagai panduan resmi penggunaan Aplikasi Berita Acara UPTB Wiyung.</p>
HTML;

$mpdf = new \Mpdf\Mpdf([
    'mode'          => 'utf-8',
    'format'        => 'A4',
    'margin_left'   => 18,
    'margin_right'  => 18,
    'margin_top'    => 20,
    'margin_bottom' => 18,
    'margin_header' => 10,
    'margin_footer' => 10,
    'tempDir'       => $tmp,
    'basepath'      => __DIR__,
]);

$mpdf->SetTitle('Buku Panduan Pengguna - Aplikasi Berita Acara UPTB Wiyung');
$mpdf->SetAuthor('UPTB Wiyung');
$mpdf->SetHeader('UPTB Wiyung | Buku Panduan Pengguna | Aplikasi Berita Acara');
$mpdf->SetFooter('| Halaman {PAGENO} dari {nbpg} |');
$mpdf->WriteHTML($html);

$out = __DIR__ . '/Panduan-Pengguna-Berita-Acara-UPTB-Wiyung.pdf';
$mpdf->Output($out, \Mpdf\Output\Destination::FILE);

echo "OK -> {$out}\n";
echo 'Ukuran: ' . number_format(filesize($out) / 1024, 1) . " KB\n";
