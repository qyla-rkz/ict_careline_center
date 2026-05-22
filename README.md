# 🖥️ ICT Careline Center

Sistem Web Pengurusan Aset ICT dan Laporan Kerosakan (KEW.PA-9) bersepadu untuk memudahkan pemantauan inventori jabatan, pendaftaran aset kakitangan, dan pengurusan aduan kerosakan secara elektronik.

---

## 👥 Peranan Pengguna & Ciri-Ciri Utama

Sistem ini mempunyai tiga (3) peranan utama dengan fungsi berbeza:

| Peranan | Penerangan Ciri Utama |
| :--- | :--- |
| **Kakitangan (Staff)** | <ul><li>**Pendaftaran Aset**: Mendaftar spesifikasi peralatan ICT (PC, Laptop, Printer) berserta gambar.</li><li>**Aduan Kerosakan (KEW.PA-9)**: Menghantar laporan kerosakan aset secara digital.</li><li>**Sejarah Aduan**: Memantau status aduan (Pending, In Progress, Resolved, Rejected).</li><li>**Profil & Kata Laluan**: Mengurus maklumat peribadi.</li></ul> |
| **Pentadbir (Admin)** | <ul><li>**Kelulusan Aduan**: Menyemak, meluluskan, atau menolak laporan aduan kakitangan.</li><li>**Cetak KEW.PA-9**: Mencetak terus borang KEW.PA-9 dalam format dokumen rasmi A4.</li><li>**Inventori Jabatan**: Mengurus & memantau status pecahan unit aset mengikut jabatan/unit.</li><li>**My Assets (Senarai Aset)**: Melihat keseluruhan rekod aset yang didaftarkan oleh staf.</li></ul> |
| **Pentadbir Utama (Super Admin)** | <ul><li>**Dashboard Statistik**: Analisis visual keseluruhan data sistem.</li><li>**Pengurusan Pengguna**: Tambah, padam, dan kemaskini maklumat pengguna (Staff & Admin).</li><li>**Tetapan Sistem**: Mengurus Mod Penyelenggaraan (*Maintenance Mode*).</li><li>**Log Audit (Audit Logs)**: Menjejaki aktiviti yang berlaku dalam sistem untuk tujuan keselamatan.</li></ul> |

---

## 📂 Struktur Projek

```bash
ict_careline_center/
├── admin/               # Fail antaramuka & dashboard untuk Admin
├── api/                 # API Backend PHP (Pemprosesan Data & Logik)
│   ├── superadmin/      # API khusus untuk Super Admin
│   ├── config.php       # Konfigurasi Pangkalan Data (PDO) & fungsi global
│   └── login.php        # Pengendalian log masuk berasingan mengikut peranan
├── assets/              # Aset Statik (CSS, JavaScript, Imej)
│   ├── css/             # Fail penggayaan (style.css)
│   └── js/              # Logik Frontend (global.js, main.js)
├── phpmailer/           # Pustaka PHPMailer untuk penghantaran emel
├── sql/                 # Fail skema pangkalan data MySQL
│   ├── database.sql     # Skema penuh struktur SQL
│   └── superadmin_setup.php
├── staff/               # Fail antaramuka & dashboard untuk Kakitangan (Staff)
├── superadmin/          # Fail antaramuka & dashboard untuk Super Admin
├── uploads/             # Folder simpanan imej kerosakan/aset yang dimuat naik
├── .env                 # Konfigurasi persekitaran (DB host, user, password)
├── index.html           # Halaman utama (Landing Page)
├── login.html           # Halaman Log Masuk (dengan suis peranan Staf/Admin)
└── register.html        # Halaman Pendaftaran Staf
```

---

## 🛠 Teknologi Digunakan

*   **Antaramuka (Frontend)**: HTML5, CSS3 (Vanilla CSS - Premium Glassmorphism & UI Moden), JavaScript (Vanilla - Asynchronous Fetch API).
*   **Logik Backend**: PHP Native (PDO untuk mengelakkan *SQL Injection*).
*   **Pangkalan Data**: MySQL / MariaDB.
*   **Penghantaran Emel**: PHPMailer (Tetapan semula kata laluan).

---

## ⚙️ Cara Pemasangan & Konfigurasi

### 1. Salin Projek (Clone / Copy)
Salin keseluruhan folder projek ini ke dalam direktori pelayan tempatan anda:
*   **XAMPP**: `C:\xampp\htdocs\ict_careline_center`
*   **Laragon**: `C:\laragon\www\ict_careline_center`

### 2. Konfigurasi Pangkalan Data (Database)
1. Aktifkan **Apache** dan **MySQL** pada XAMPP Control Panel.
2. Buka pelayar web dan layari `http://localhost/phpmyadmin/`.
3. Cipta pangkalan data baru bertajuk `ict_careline`.
4. Pilih pangkalan data tersebut, pergi ke tab **Import**, pilih fail `sql/database.sql` dan klik **Go** / **Import**.

### 3. Tetapan Fail Persekitaran (`.env`)
Buat fail bertajuk `.env` di dalam folder utama projek (*root directory*) dan masukkan konfigurasi pangkalan data anda:
```env
DB_HOST=localhost
DB_NAME=ict_careline
DB_USER=root
DB_PASS=            # Masukkan kata laluan MySQL anda (kosongkan jika tiada)
```

### 4. Jalankan Aplikasi
Buka pelayar web dan layari:
```text
http://localhost/ict_careline_center/
```

---

## 🔒 Langkah Keselamatan Pintar
*   **Prepared Statements (PDO)**: Menghalang serangan *SQL Injection* secara menyeluruh di semua query backend.
*   **XSS Protection**: Fungsi `sanitizeOutput()` disediakan secara terbina untuk memastikan output selamat daripada suntikan skrip berniat jahat.
*   **Akses Tertutup (`.htaccess`)**: Menghalang pengguna luar daripada membaca fail `.env` secara terus melalui pelayar web.

---

## 🔧 Penyelesaian Masalah (Troubleshooting)

### 1. Ralat VS Code: *“Cannot validate since a PHP installation could not be found...”*
Jika VS Code anda memaparkan amaran di atas, ini bermakna editor anda memerlukan laluan ke fail PHP (*PHP executable path*).
1. Tekan `Ctrl + ,` untuk membuka Settings.
2. Klik ikon **Open Settings (JSON)** di bahagian bucu atas kanan.
3. Tambah baris kod ini di dalam `{}` tetapan anda:
   ```json
   "php.validate.executablePath": "C:\\xampp\\php\\php.exe"
   ```
   *(Pastikan anda meletakkan tanda koma `,` di hujung baris sebelumnya jika ada).*

### 2. Ralat Sambungan Pangkalan Data (*Database Connection Failed*)
*   Pastikan servis MySQL pada XAMPP telah dihidupkan (*running*).
*   Semak semula fail `.env` anda untuk memastikan nama database (`DB_NAME`) dan kata laluan (`DB_PASS`) adalah betul.
