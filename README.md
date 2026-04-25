# ICT Careline Center (E-Kewpa9)

Sistem Web Pendaftaran Aset dan Laporan Kerosakan Peralatan ICT (KEW.PA-9) untuk kakitangan. Projek ini direka bentuk bagi memudahkan pemantauan inventori jabatan, pengurusan aset kakitangan, dan penerimaan laporan kerosakan daripada kakitangan oleh Pentadbir ICT.

## 🚀 Fungsi Utama

### 1. Papan Pemuka Kakitangan (Staff)
*   **Pendaftaran Aset**: Kakitangan boleh mendaftar spesifikasi peralatan ICT (PC, Laptop, Printer, dsb.) berserta muat naik gambar.
*   **Aduan Kerosakan (E-Kewpa9)**: Menghantar laporan kerosakan aset secara automatik dalam format KEW.PA-9.
*   **Sejarah Laporan**: Melihat dan mengesan status laporan aduan yang pernah dihantar.
*   **Kemaskini Profil & Katalaluan**: Menguruskan maklumat peribadi kakitangan.

### 2. Papan Pemuka Pentadbir (Admin)
*   **Pengurusan Laporan**: Menyemak, meluluskan, atau menolak laporan aduan kakitangan. Laporan juga boleh dicetak terus mengikut format dokumen rasmi KEW.PA-9 A4.
*   **Inventori Jabatan**: Merekod dan memantau bilangan pecahan aset secara keseluruhan mengikut Jabatan.
*   **Aset Kakitangan (My Assets)**: Melihat keseluruhan senarai aset yang digunakan oleh kakitangan.

## 🛠 Teknologi Digunakan
*   **Frontend**: HTML5, CSS3 (Vanilla), JavaScript (Vanilla)
*   **Backend**: PHP Native (PDO)
*   **Pangkalan Data (Database)**: MySQL

## ⚙️ Cara Pemasangan (Setup)

1. **Clone Repository**
   Salin projek ini ke pelayan tempatan anda (cth: `htdocs` untuk XAMPP atau `www` untuk WAMP).
   ```bash
   git clone https://github.com/USERNAME_ANDA/ict_careline_center.git
   ```

2. **Tetapan Pangkalan Data (Database)**
   * Buka phpMyAdmin (atau sebarang pengurus MySQL).
   * Cipta pangkalan data baru dengan nama `ict_careline`.
   * *Import* fail `sql/database.sql` ke dalam pangkalan data tersebut.

3. **Tetapan Persekitaran (Environment Variables)**
   * Salin nama fail `.env.example` (jika ada) dan namakan semula sebagai `.env`.
   * Secara alternatif, buat fail `.env` baharu di *root directory* dan isikan maklumat sambungan pangkalan data anda:
     ```env
     DB_HOST=localhost
     DB_NAME=ict_careline
     DB_USER=root
     DB_PASS=kata_laluan_anda
     ```

4. **Jalankan Aplikasi**
   Buka pelayar web dan akses: `http://localhost/ict_careline_center/`

## 🔒 Nota Keselamatan
*   Sistem ini menggunakan perlindungan PDO *Prepared Statements* untuk mencegah *SQL Injection*.
*   Sanitasi XSS automatik disediakan untuk API dalam fungsi `jsonResponse` (fail `api/config.php`).
*   Fail `.htaccess` disediakan untuk menghalang akses melayari fail sulit `.env` di pelayan web (Apache). Pastikan Apache membenarkan override (AllowOverride All).

---
*Dibangunkan untuk memudahkan kelancaran pengurusan infrastruktur ICT.*
