# 🖥️ eICT Desk

Sistem web ini dibangunkan untuk membantu pengurusan aset ICT, pelaporan kerosakan, dan pemantauan aktiviti dalam organisasi. Aplikasi ini menyokong tiga peranan utama iaitu Staff, Admin dan Super Admin.

---

## ✨ Fungsi Utama

### Kakitangan (Staff)
- Daftar aset ICT seperti komputer, laptop dan printer
- Hantar aduan kerosakan melalui borang KEW.PA-9
- Semak status laporan secara online
- Lihat sejarah aduan dan kemaskini profil

### Pentadbir (Admin)
- Semak dan urus laporan yang dihantar staff
- Lihat inventori aset mengikut jabatan/unit
- Semak senarai aset staff dan status semasa
- Cetak borang KEW.PA-9

### Pentadbir Utama (Super Admin)
- Lihat dashboard statistik sistem
- Urus pengguna staff dan admin
- Tetapkan mod penyelenggaraan (maintenance mode)
- Semak log audit aktiviti sistem

---

## 📂 Struktur Projek

```text
ict_careline_center/
├── admin/                 # Halaman dan dashboard untuk Admin
├── api/                   # API PHP untuk login, profil, laporan, inventori dan tetapan
│   └── superadmin/        # Endpoint khusus untuk Super Admin
├── assets/                # CSS, JavaScript dan imej UI
├── phpmailer/             # Library PHPMailer untuk reset kata laluan
├── staff/                 # Halaman dan dashboard untuk Staff
├── superadmin/            # Halaman dan dashboard untuk Super Admin
├── uploads/               # Folder untuk gambar profil dan fail laporan
├── index.html             # Halaman utama
├── login.html             # Halaman log masuk
├── register.html          # Halaman pendaftaran staff
├── reset_password.html    # Halaman reset kata laluan
└── select-portal.html     # Halaman pemilihan portal
```

---

## 🛠 Teknologi Yang Digunakan

- Frontend: HTML, CSS dan JavaScript vanilla
- Backend: PHP Native dengan PDO
- Database: MySQL / MariaDB
- Email: PHPMailer
- Pengurusan fail upload: folder uploads dengan penyimpanan imej dan dokumen

---

## ⚙️ Cara Pemasangan

### 1. Salin projek ke folder pelayan tempatan
- XAMPP: C:\xampp\htdocs\ict_careline_center
- Laragon: C:\laragon\www\ict_careline_center

### 2. Jalankan Apache dan MySQL
Pastikan server web dan pangkalan data berjalan sebelum membuka aplikasi.

### 3. Sediakan pangkalan data
Cipta pangkalan data MySQL anda, contohnya:

```sql
CREATE DATABASE ict_careline;
```

Seterusnya, sediakan jadual yang diperlukan oleh sistem seperti users, reports, department_inventory, system_settings dan audit_logs. Jika pasukan anda mempunyai fail SQL, import fail tersebut ke pangkalan data.

### 4. Buat fail .env
Di folder utama projek, cipta fail bernama .env dengan kandungan seperti berikut:

```env
DB_HOST=localhost
DB_NAME=ict_careline
DB_USER=root
DB_PASS=
```

> Jika anda menggunakan kata laluan MySQL, masukkan nilai tersebut pada DB_PASS.

### 5. Pastikan folder upload boleh ditulis
Beri kebenaran tulis kepada folder berikut:
- uploads/profile_pictures
- uploads/reports

### 6. Jalankan aplikasi
Buka pelayar dan lawati:

```text
http://localhost/ict_careline_center/
```

---

## 🔐 Nota Penting

- Aplikasi ini menggunakan PDO untuk mengelakkan serangan SQL injection.
- Fungsi sanitasi output disediakan untuk membantu mengurangkan risiko XSS.
- Mod penyelenggaraan boleh diaktifkan melalui portal Super Admin.

---

## 🧩 Penyelesaian Masalah

### Sambungan pangkalan data gagal
- Semak sama ada Apache dan MySQL sedang berjalan
- Semak semula nilai DB_HOST, DB_NAME, DB_USER dan DB_PASS dalam .env

### Upload gambar atau laporan gagal
- Pastikan folder uploads mempunyai kebenaran tulis
- Semak saiz fail yang dimuat naik

### Halaman tidak dipaparkan
- Pastikan projek diletakkan dalam folder root pelayan yang betul
- Semak sama ada PHP telah dipasang dan dikonfigurasikan dengan betul

---

## 📌 Catatan

README ini disediakan supaya lebih selaras dengan struktur dan fungsi sebenar projek eICT Desk yang sedang dibangunkan.
