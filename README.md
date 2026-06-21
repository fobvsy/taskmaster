# 📋 TaskMaster — Sistem To-Do List dan Manajemen Tugas Berbasis Web

![PHP](https://img.shields.io/badge/PHP-Native-8892BF?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-Frontend-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![XAMPP](https://img.shields.io/badge/XAMPP-Local%20Server-FB7A24?style=for-the-badge&logo=xampp&logoColor=white)

> Aplikasi manajemen tugas berbasis web dengan tampilan card bergaya Trello — minimalis, modern, dan responsif.

---

## 📌 Deskripsi Proyek

**TaskMaster** adalah aplikasi web untuk membantu pengguna mencatat, mengelola, dan memantau tugas secara terstruktur. Sistem ini mengadaptasi konsep tampilan **Trello** dengan daftar tugas berbasis card, dilengkapi label prioritas, warna status, deadline, dan fitur filter.

Proyek ini dikembangkan sebagai tugas mata kuliah Rekayasa Perangkat Lunak menggunakan **PHP Native**, **MySQL**, dan **XAMPP** sebagai lingkungan pengembangan lokal.

---

## ✨ Fitur Utama

### 👤 Pengunjung
- Melihat landing page
- Registrasi akun baru
- Login ke sistem

### 🙋 User
- Dashboard ringkasan tugas
- Tambah, lihat, edit, dan hapus tugas
- Lihat detail tugas
- Ubah status tugas *(Belum Dikerjakan → Sedang Dikerjakan → Selesai)*
- Cari tugas berdasarkan kata kunci
- Filter tugas berdasarkan kategori, prioritas, status, atau deadline

### 🛡️ Admin
- Dashboard ringkasan data sistem
- Kelola data pengguna *(aktifkan / nonaktifkan / hapus)*
- Kelola kategori default tugas

---

## 🗂️ Struktur Folder

```
projekrpl/
├── assets/
│   ├── css/          # File stylesheet
│   ├── js/           # File JavaScript
│   └── img/          # Gambar dan ikon
├── config/
│   └── database.php  # Konfigurasi koneksi database
├── auth/
│   ├── login.php     # Halaman login
│   ├── register.php  # Halaman registrasi
│   └── logout.php    # Proses logout
├── user/
│   ├── dashboard.php    # Dashboard user
│   ├── tasks.php        # Daftar tugas
│   ├── add_task.php     # Tambah tugas
│   ├── edit_task.php    # Edit tugas
│   ├── detail_task.php  # Detail tugas
│   └── delete_task.php  # Hapus tugas
├── admin/
│   ├── dashboard.php    # Dashboard admin
│   ├── users.php        # Kelola pengguna
│   └── categories.php   # Kelola kategori
├── database.sql      # Skrip SQL untuk membuat database
├── index.php         # Landing page
└── README.md
```

---

## 🛠️ Tech Stack

| Komponen       | Teknologi                    |
|----------------|------------------------------|
| Backend        | PHP Native                   |
| Frontend       | HTML, CSS, JavaScript, Bootstrap |
| Database       | MySQL (MariaDB via XAMPP)    |
| Web Server     | Apache (XAMPP)               |
| DB Manager     | phpMyAdmin                   |
| Autentikasi    | Session PHP (login manual)   |

---

## 🗃️ Struktur Database

Database bernama `todo_management` terdiri dari 3 tabel utama:

### Tabel `users`
| Field        | Tipe Data | Keterangan                     |
|--------------|-----------|--------------------------------|
| `id_user`    | INT       | Primary Key, Auto Increment    |
| `nama`       | VARCHAR   | Nama pengguna                  |
| `email`      | VARCHAR   | Email (unik)                   |
| `password`   | VARCHAR   | Password pengguna              |
| `role`       | ENUM      | `user` atau `admin`            |
| `status`     | ENUM      | `aktif` atau `nonaktif`        |
| `created_at` | DATETIME  | Waktu akun dibuat              |

### Tabel `tasks`
| Field          | Tipe Data | Keterangan                                          |
|----------------|-----------|-----------------------------------------------------|
| `id_task`      | INT       | Primary Key, Auto Increment                         |
| `id_user`      | INT       | Foreign Key → `users.id_user`                       |
| `id_category`  | INT       | Foreign Key → `categories.id_category`              |
| `title`        | VARCHAR   | Judul tugas                                         |
| `description`  | TEXT      | Deskripsi tugas                                     |
| `priority`     | ENUM      | `rendah`, `sedang`, `tinggi`                        |
| `deadline`     | DATE      | Batas waktu tugas                                   |
| `status`       | ENUM      | `belum_dikerjakan`, `sedang_dikerjakan`, `selesai`  |
| `created_at`   | DATETIME  | Waktu dibuat                                        |
| `updated_at`   | DATETIME  | Waktu terakhir diperbarui                           |

### Tabel `categories`
| Field           | Tipe Data | Keterangan                  |
|-----------------|-----------|-----------------------------|
| `id_category`   | INT       | Primary Key, Auto Increment |
| `category_name` | VARCHAR   | Nama kategori (unik)        |
| `created_at`    | DATETIME  | Waktu kategori dibuat       |

**Kategori default:** Kuliah, Organisasi, Pekerjaan, Pribadi, Lainnya

---

## ⚙️ Cara Instalasi & Menjalankan

### Prasyarat
- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL aktif)
- Browser modern (Chrome, Firefox, Edge, dll.)
- Git *(opsional)*

### Langkah Instalasi

**1. Clone atau unduh repositori**
```bash
git clone https://github.com/fobvsy/taskmaster.git
```
Atau unduh sebagai ZIP lalu ekstrak.

**2. Letakkan folder di direktori XAMPP**
```
C:\xampp\htdocs\projekrpl\
```

**3. Jalankan XAMPP**
- Aktifkan modul **Apache** dan **MySQL** di XAMPP Control Panel.

**4. Import database**
- Buka browser dan akses: `http://localhost/phpmyadmin`
- Buat database baru bernama `todo_management`
- Pilih database tersebut → klik tab **Import**
- Pilih file `database.sql` dari folder proyek → klik **Go**

**5. Konfigurasi koneksi database**

Buka file `config/database.php` dan sesuaikan jika diperlukan:
```php
$host = "localhost";
$user = "root";    // username MySQL kamu
$pass = "";        // password MySQL (kosong jika default XAMPP)
$db   = "todo_management";
```

**6. Akses aplikasi**

Buka browser dan akses:
```
http://localhost/projekrpl/
```

---

## 🔐 Akun Demo

| Role  | Email              | Password  |
|-------|--------------------|-----------|
| Admin | admin@gmail.com    | admin123  |
| User  | user@gmail.com     | user123   |

> ⚠️ **Catatan Keamanan:** Password pada versi ini disimpan tanpa hash karena merupakan versi pengembangan untuk tugas kuliah. Untuk versi produksi, gunakan `password_hash()` dan `password_verify()` dari PHP.

---

## 🎨 Panduan Warna

| Elemen               | Warna         | Hex Code  |
|----------------------|---------------|-----------|
| Background utama     | Soft White    | `#F8FAFC` |
| Warna utama          | Slate Blue    | `#4F46E5` |
| Teks utama           | Dark Slate    | `#1E293B` |
| Prioritas Tinggi     | Soft Red      | `#EF4444` |
| Prioritas Sedang     | Soft Amber    | `#F59E0B` |
| Prioritas Rendah     | Soft Green    | `#22C55E` |
| Status: Todo         | Gray          | `#94A3B8` |
| Status: In Progress  | Blue          | `#3B82F6` |
| Status: Selesai      | Green         | `#16A34A` |
| Deadline Mendekati   | Orange        | `#FB923C` |

---

## 🧪 Pengujian

Dokumentasi pengujian black box tersedia di file [`desain_testing_black_box.md`](./desain_testing_black_box.md).

---

## 🔒 Hak Akses

| Fitur                  | Pengunjung | User | Admin |
|------------------------|:----------:|:----:|:-----:|
| Landing page           | ✅         | ✅   | ✅    |
| Registrasi             | ✅         | ❌   | ❌    |
| Login                  | ✅         | ✅   | ✅    |
| Dashboard user         | ❌         | ✅   | ❌    |
| Kelola tugas           | ❌         | ✅   | ❌    |
| Cari & filter tugas    | ❌         | ✅   | ❌    |
| Dashboard admin        | ❌         | ❌   | ✅    |
| Kelola pengguna        | ❌         | ❌   | ✅    |
| Kelola kategori default| ❌         | ❌   | ✅    |
| Logout                 | ❌         | ✅   | ✅    |

---

## 📄 Dokumentasi Tambahan

- [`prd.md`](./prd.md) — Product Requirements Document lengkap
- [`desain_testing_black_box.md`](./desain_testing_black_box.md) — Desain pengujian black box
- [`database.sql`](./database.sql) — Skrip SQL untuk setup database

---

## 👨‍💻 Pengembang

Made By Fobvsy and team
Proyek ini dikembangkan sebagai tugas mata kuliah **Rekayasa Perangkat Lunak**.

---

## 📜 Lisensi

Proyek ini dibuat untuk keperluan akademik. Tidak diperkenankan untuk digunakan secara komersial tanpa izin.
