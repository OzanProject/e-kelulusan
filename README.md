# E-Kelulusan: Sistem Informasi Kelulusan Sekolah

**E-Kelulusan** adalah platform berbasis web modern yang dirancang untuk mendigitalisasi proses pengumuman kelulusan siswa, pencetakan Surat Keterangan Lulus (SKL) secara otomatis, dan manajemen data nilai yang efisien. Sistem ini dibangun menggunakan framework **Laravel 13** dengan antarmuka yang mengadopsi standar **Material Design 3** untuk sisi siswa dan **AdminLTE 3** untuk sisi administrasi.

---

## ✨ Fitur Utama

### 👨‍🎓 Sisi Siswa (Frontend)
- **Cek Kelulusan Real-time**: Pencarian status kelulusan berdasarkan NISN atau Nomor Peserta.
- **Countdown Timer**: Penghitung mundur otomatis hingga waktu pengumuman dibuka.
- **Download SKL Mandiri**: Siswa yang dinyatakan LULUS dapat mengunduh SKL dalam format PDF secara mandiri.
- **Verifikasi QR Code**: SKL dilengkapi dengan QR Code untuk verifikasi keaslian dokumen secara digital.
- **Responsive Design**: Tampilan optimal di semua perangkat (Desktop, Tablet, Mobile).

### 🛠 Sisi Administrator (Backend)
- **Dashboard Analytics**: Statistik cepat mengenai total siswa, persentase kelulusan, dan log akses.
- **Manajemen Siswa & Nilai**: 
    - Import data siswa dan nilai secara masal via Excel.
    - Export data kelulusan ke Excel.
    - Bulk Action: Cetak SKL masal dan hapus data masal.
- **Manajemen Mata Pelajaran**: Pengaturan dinamis mata pelajaran yang muncul di SKL.
- **Pengaturan Identitas Sekolah**: 
    - Upload Logo Sekolah, Kop Surat, Scan Tanda Tangan, dan Stempel.
    - Pengaturan Nama Kepala Sekolah, NIP, dan Format Nomor SKL.
- **Penjadwalan Pengumuman**: Fitur buka/tutup portal secara otomatis berdasarkan tanggal dan jam yang ditentukan.
- **Manajemen Pengguna**: Sistem Role-Based Access Control (Admin & Petugas).
- **Audit Logs**: Mencatat setiap kali siswa mengakses data mereka (IP & User Agent).

---

## 🚀 Teknologi yang Digunakan
- **Framework**: Laravel 13 (PHP 8.3+)
- **Database**: MySQL / MariaDB
- **UI Frontend**: Tailwind CSS, Material Design 3 Components
- **UI Backend**: AdminLTE 3 (Bootstrap 5)
- **Library Utama**:
    - `barryvdh/laravel-dompdf`: Untuk generate PDF SKL.
    - `maatwebsite/excel`: Untuk import/export data Excel.
    - `simplesoftwareio/simple-qrcode`: Untuk generate QR Code verifikasi.
    - `sweetalert2`: Untuk notifikasi interaktif.

---

## 📊 Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    USERS {
        bigint id PK
        string name
        string email UK
        string password
        enum role "admin, petugas"
        timestamp created_at
    }

    STUDENTS {
        bigint id PK
        string nama_lengkap
        string nisn UK
        string nomor_peserta UK
        enum status_kelulusan "lulus, tidak_lulus, ditunda"
        json nilai_ujian "Mata Pelajaran & Nilai"
        timestamp created_at
    }

    SUBJECTS {
        bigint id PK
        string nama
        string kode UK
        int urutan
        boolean aktif
    }

    SETTINGS {
        bigint id PK
        string school_name
        string school_address_city
        string school_logo
        string principal_name
        string principal_nip
        string kop_surat
        string signature
        string stamp
        text skl_template
        datetime announcement_date
        boolean announcement_status
        json agendas "Timeline Agenda"
        string contact_email
        string contact_phone
        text contact_address
    }

    ACCESS_LOGS {
        bigint id PK
        bigint student_id FK
        string ip_address
        string user_agent
        timestamp created_at
    }

    STUDENTS ||--o{ ACCESS_LOGS : "diakses_oleh"
```

---

## 🛠 Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/ozanproject/e-kelulusan.git
   cd e-kelulusan
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Konfigurasi Environment**
   - Copy file `.env.example` menjadi `.env`
   - Sesuaikan konfigurasi database di `.env`
   - Jalankan `php artisan key:generate`

4. **Database Migration & Seeding**
   ```bash
   php artisan migrate --seed
   ```

5. **Simlink Storage**
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

---

## 🔐 Akun Default
- **Admin**: `admin@admin.com` / `password`
- **Petugas**: `petugas@petugas.com` / `password`

---

## ✒️ Maintainer
- **Developer**: Ozan Project
- **Website**: [ozanproject.site](https://ozanproject.site)
- **Lisensi**: MIT License

---
*Dibuat dengan ❤️ untuk kemajuan pendidikan Indonesia.*
