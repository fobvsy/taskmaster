# Product Requirements Document (PRD)

## Sistem To-Do List dan Manajemen Tugas Berbasis Web

**Versi:** 1.0  
**Jenis Dokumen:** Product Requirements Document  
**Topik Software/Sistem:** Sistem To-Do List dan Manajemen Tugas Berbasis Web  

---

## 1. Ringkasan Produk

Sistem To-Do List dan Manajemen Tugas Berbasis Web adalah aplikasi berbasis web yang digunakan untuk membantu pengguna mencatat, mengelola, memantau, dan menyelesaikan tugas secara lebih terstruktur. Sistem ini dibuat untuk pengguna yang membutuhkan pengelolaan tugas harian secara sederhana, rapi, dan mudah digunakan.

Sistem ini mengadaptasi konsep tampilan seperti Trello, yaitu menggunakan tampilan berbasis card agar daftar tugas mudah dibaca dan dikelompokkan. Pengguna dapat membuat tugas, mengatur prioritas, menentukan deadline, mengubah status, mencari tugas, serta memfilter tugas berdasarkan kategori tertentu.

---

## 2. Latar Belakang

Banyak pengguna mengalami kesulitan dalam mengatur tugas karena tugas sering dicatat secara manual, tersebar di berbagai tempat, atau tidak memiliki pengelompokan yang jelas. Akibatnya, tugas penting dapat terlupakan, deadline terlewat, dan pekerjaan menjadi kurang teratur.

Sistem ini dibuat sebagai solusi untuk membantu pengguna mengelola tugas secara digital melalui aplikasi web. Dengan adanya tampilan card, label prioritas, warna status, dan fitur filter, pengguna dapat lebih mudah memahami tugas mana yang harus diprioritaskan dan diselesaikan terlebih dahulu.

---

## 3. Tujuan Produk

Tujuan utama dari sistem ini adalah menyediakan aplikasi manajemen tugas yang sederhana, modern, responsif, dan mudah digunakan untuk kebutuhan tugas pribadi maupun aktivitas harian.

Tujuan khusus sistem ini adalah:

1. Membantu pengguna mencatat tugas secara digital.
2. Membantu pengguna mengelompokkan tugas berdasarkan kategori.
3. Membantu pengguna menentukan prioritas tugas.
4. Membantu pengguna memantau deadline.
5. Membantu pengguna mengetahui status pengerjaan tugas.
6. Menyediakan tampilan tugas berbasis card agar mudah dibaca.
7. Menyediakan sistem role untuk membedakan hak akses user dan admin.
8. Menyediakan halaman admin dengan gaya tampilan yang sama seperti user agar efisien dalam pengembangan.

---

## 4. Ruang Lingkup Produk

Sistem ini berfokus pada manajemen tugas pribadi berbasis web. Sistem dapat digunakan oleh pengunjung, user, dan admin.

Ruang lingkup sistem meliputi:

- Landing page.
- Registrasi akun.
- Login dan logout.
- Dashboard user.
- Pengelolaan tugas.
- Pengaturan kategori.
- Pengaturan prioritas.
- Pengaturan deadline.
- Pengubahan status tugas.
- Pencarian dan filter tugas.
- Dashboard admin.
- Pengelolaan data pengguna.
- Pengelolaan kategori default.

Sistem ini tidak mencakup fitur API eksternal, integrasi Telegram, integrasi email, upload file, chat antar pengguna, kalender eksternal, GitHub version control, atau manajemen proyek tim yang kompleks.

---

## 5. Target Pengguna

| Pengguna | Deskripsi |
|---|---|
| Pengunjung | Pengguna yang belum login dan hanya dapat mengakses landing page, halaman registrasi, dan halaman login. |
| User | Pengguna yang sudah memiliki akun dan dapat mengelola tugas miliknya sendiri. |
| Admin | Pengguna dengan hak akses khusus untuk mengelola data pengguna dan kategori default. |

---

## 6. Style Web

### 6.1 Konsep Tampilan

Style web yang digunakan adalah **minimalis, clean productivity, dan modern**. Tampilan dibuat tidak terlalu ramai agar nyaman digunakan dalam waktu lama. Sistem tetap terlihat modern, tetapi tidak dibuat terlalu kompleks karena target pengembangan adalah tugas kuliah dengan tampilan tingkat sedang.

### 6.2 Referensi Tampilan

Referensi tampilan yang digunakan adalah **Trello**, terutama pada konsep daftar tugas berbasis card. Tugas dapat ditampilkan dalam bentuk card agar informasi seperti judul, kategori, prioritas, deadline, dan status mudah dibaca.

### 6.3 Warna Tampilan

Warna tampilan sistem menggunakan palet warna yang nyaman dilihat dalam waktu lama, tetap modern, dan sesuai dengan konsep clean productivity. Setiap warna ditentukan menggunakan kode warna HEX agar hasil desain lebih konsisten saat diimplementasikan ke dalam CSS.

| Elemen | Warna | Kode Warna | Keterangan |
|---|---|---|---|
| Background utama | Soft White | `#F8FAFC` | Warna latar utama yang bersih dan nyaman dilihat. |
| Background card | White | `#FFFFFF` | Warna card tugas agar informasi terlihat jelas. |
| Warna utama | Slate Blue | `#4F46E5` | Warna utama untuk tombol penting, link aktif, dan elemen utama. |
| Warna hover utama | Indigo Dark | `#4338CA` | Warna saat tombol utama diarahkan cursor. |
| Warna sekunder | Slate Gray | `#64748B` | Warna teks pendukung dan elemen sekunder. |
| Warna teks utama | Dark Slate | `#1E293B` | Warna teks utama agar mudah dibaca. |
| Warna border | Light Gray | `#E2E8F0` | Warna garis pembatas antar elemen. |
| Prioritas tinggi | Soft Red | `#EF4444` | Menandai tugas dengan prioritas tinggi. |
| Prioritas sedang | Soft Amber | `#F59E0B` | Menandai tugas dengan prioritas sedang. |
| Prioritas rendah | Soft Green | `#22C55E` | Menandai tugas dengan prioritas rendah. |
| Status belum dikerjakan | Gray | `#94A3B8` | Menandai tugas yang belum dimulai. |
| Status sedang dikerjakan | Blue | `#3B82F6` | Menandai tugas yang sedang dikerjakan. |
| Status selesai | Green | `#16A34A` | Menandai tugas yang sudah selesai. |
| Peringatan deadline | Orange | `#FB923C` | Menandai tugas yang mendekati deadline. |
| Error / gagal | Red | `#DC2626` | Menampilkan pesan kesalahan. |
| Success / berhasil | Green | `#15803D` | Menampilkan pesan berhasil. |

### 6.4 Variabel CSS Warna

Kode warna tersebut dapat diterapkan sebagai variabel CSS berikut agar tampilan lebih konsisten.

```css
:root {
  --color-bg-main: #F8FAFC;
  --color-bg-card: #FFFFFF;

  --color-primary: #4F46E5;
  --color-primary-hover: #4338CA;
  --color-secondary: #64748B;

  --color-text-main: #1E293B;
  --color-border: #E2E8F0;

  --color-priority-high: #EF4444;
  --color-priority-medium: #F59E0B;
  --color-priority-low: #22C55E;

  --color-status-todo: #94A3B8;
  --color-status-progress: #3B82F6;
  --color-status-done: #16A34A;

  --color-deadline-warning: #FB923C;
  --color-error: #DC2626;
  --color-success: #15803D;
}
```

### 6.5 Dark Mode

Sistem dapat mendukung **light mode** dan **dark mode**. Untuk pengembangan awal, light mode menjadi prioritas utama. Dark mode dapat dikembangkan sebagai fitur tambahan apabila waktu pengembangan mencukupi.

Jika sistem mendukung dark mode, palet warna tambahan yang dapat digunakan adalah sebagai berikut:

```css
[data-theme="dark"] {
  --color-bg-main: #0F172A;
  --color-bg-card: #1E293B;

  --color-primary: #818CF8;
  --color-primary-hover: #6366F1;
  --color-secondary: #94A3B8;

  --color-text-main: #F8FAFC;
  --color-border: #334155;
}
```

### 6.6 Bentuk Tampilan Tugas

Daftar tugas ditampilkan dalam bentuk **card**. Setiap card berisi:

- Judul tugas.
- Deskripsi singkat.
- Kategori.
- Prioritas.
- Deadline.
- Status tugas.
- Tombol detail.
- Tombol edit.
- Tombol hapus.
- Tombol ubah status.

### 6.7 Dashboard

Dashboard user dapat menampilkan ringkasan lengkap, seperti:

- Total tugas.
- Tugas belum dikerjakan.
- Tugas sedang dikerjakan.
- Tugas selesai.
- Tugas prioritas tinggi.
- Tugas yang mendekati deadline.

### 6.8 Responsivitas

Sistem **wajib responsif** dan dapat digunakan pada perangkat desktop maupun smartphone. Tampilan card harus menyesuaikan ukuran layar agar tetap mudah dibaca pada perangkat kecil.

### 6.9 Icon dan Badge

Sistem sangat disarankan menggunakan icon dan badge agar informasi tugas lebih mudah dipahami. Badge digunakan untuk menandai prioritas, kategori, dan status tugas.

Contoh badge:

- Prioritas Tinggi.
- Prioritas Sedang.
- Prioritas Rendah.
- Belum Dikerjakan.
- Sedang Dikerjakan.
- Selesai.

### 6.10 Style Admin

Tampilan halaman admin disamakan dengan style halaman user agar lebih efisien dalam pengembangan. Perbedaannya hanya pada menu dan hak akses yang tersedia.

---

## 7. Tech Stack

### 7.1 Bahasa Pemrograman

Sistem menggunakan:

- **PHP Native** sebagai backend utama.
- **Python Flask** sebagai route tambahan apabila diperlukan.

Catatan: Karena sistem dijalankan secara lokal menggunakan XAMPP, PHP Native menjadi prioritas utama. Flask dapat digunakan sebagai service terpisah apabila diperlukan untuk routing tertentu, tetapi tidak menjadi kebutuhan utama.

### 7.2 Frontend

Frontend menggunakan:

- HTML.
- CSS.
- JavaScript.
- Bootstrap atau Tailwind CSS.

Bootstrap atau Tailwind CSS digunakan untuk mempercepat pembuatan tampilan yang responsif, modern, dan rapi.

### 7.3 Backend

Backend utama menggunakan **PHP Native**. PHP digunakan untuk:

- Memproses registrasi.
- Memproses login.
- Mengelola session.
- Menambah data tugas.
- Mengedit data tugas.
- Menghapus data tugas.
- Mengubah status tugas.
- Mengelola data admin.
- Menghubungkan sistem dengan database MySQL.

### 7.4 Database

Database yang digunakan adalah **MySQL**.

Database digunakan untuk menyimpan:

- Data pengguna.
- Data tugas.
- Data kategori.
- Data prioritas.
- Data status tugas.

### 7.5 Lingkungan Pengembangan

Sistem dijalankan secara lokal menggunakan **XAMPP**.

Komponen yang digunakan:

- Apache sebagai web server.
- MySQL sebagai database server.
- phpMyAdmin untuk pengelolaan database.
- Browser untuk mengakses aplikasi.

### 7.6 Autentikasi

Autentikasi login dibuat secara manual menggunakan email dan password.

Sistem menggunakan session untuk menyimpan status login pengguna.

### 7.7 Penyimpanan Password

Pada versi tugas kuliah ini, password **tidak menggunakan hash** sesuai kebutuhan pengembangan awal. Namun, untuk pengembangan yang lebih aman atau versi produksi, password sebaiknya disimpan menggunakan hash.

### 7.8 Role Pengguna

Sistem membutuhkan role pengguna, yaitu:

- User.
- Admin.

Role digunakan untuk membedakan hak akses antar pengguna.

### 7.9 Pencarian dan Filter

Fitur pencarian dan filter tugas menggunakan query database MySQL. Sistem tidak membutuhkan API khusus untuk proses pencarian dan filter.

### 7.10 API

Sistem tidak membutuhkan API karena hanya berupa web biasa. Semua proses dilakukan melalui halaman web dan form yang diproses oleh PHP.

### 7.11 Struktur Project

Struktur project dibuat sederhana untuk kebutuhan tugas kuliah. Struktur disarankan tidak terlalu kompleks agar mudah dipahami dan dikembangkan.

Contoh struktur folder:

```text
todo-management/
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
├── config/
│   └── database.php
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── user/
│   ├── dashboard.php
│   ├── tasks.php
│   ├── add_task.php
│   ├── edit_task.php
│   └── detail_task.php
├── admin/
│   ├── dashboard.php
│   ├── users.php
│   └── categories.php
├── includes/
│   ├── header.php
│   ├── navbar.php
│   └── footer.php
├── index.php
└── README.md
```

### 7.12 Version Control

Sistem tidak menggunakan GitHub atau version control karena pengembangan difokuskan untuk tugas kuliah lokal.

---

## 8. Fitur Utama

### 8.1 Fitur Pengunjung

| Fitur | Deskripsi |
|---|---|
| Melihat landing page | Pengunjung dapat melihat informasi singkat mengenai sistem. |
| Registrasi | Pengunjung dapat membuat akun baru. |
| Login | Pengunjung dapat masuk ke sistem menggunakan akun yang sudah dibuat. |

### 8.2 Fitur User

| Fitur | Deskripsi |
|---|---|
| Dashboard user | User dapat melihat ringkasan tugas. |
| Tambah tugas | User dapat membuat tugas baru. |
| Lihat daftar tugas | User dapat melihat seluruh tugas miliknya. |
| Detail tugas | User dapat melihat informasi lengkap dari tugas. |
| Edit tugas | User dapat mengubah data tugas. |
| Hapus tugas | User dapat menghapus tugas. |
| Ubah status tugas | User dapat mengubah status menjadi belum dikerjakan, sedang dikerjakan, atau selesai. |
| Cari tugas | User dapat mencari tugas berdasarkan kata kunci. |
| Filter tugas | User dapat memfilter tugas berdasarkan kategori, prioritas, status, atau deadline. |
| Logout | User dapat keluar dari sistem. |

### 8.3 Fitur Admin

| Fitur | Deskripsi |
|---|---|
| Dashboard admin | Admin dapat melihat ringkasan data sistem. |
| Kelola pengguna | Admin dapat melihat, mengaktifkan, menonaktifkan, atau menghapus pengguna. |
| Kelola kategori default | Admin dapat menambah, mengedit, atau menghapus kategori default. |
| Logout admin | Admin dapat keluar dari sistem. |

---

## 9. Kebutuhan Fungsional

| Kode | Kebutuhan | Deskripsi |
|---|---|---|
| FR-01 | Registrasi | Sistem menyediakan fitur registrasi akun baru. |
| FR-02 | Login | Sistem menyediakan fitur login manual menggunakan email dan password. |
| FR-03 | Logout | Sistem menyediakan fitur logout. |
| FR-04 | Dashboard user | Sistem menampilkan ringkasan tugas milik user. |
| FR-05 | Tambah tugas | User dapat menambahkan tugas baru. |
| FR-06 | Lihat tugas | User dapat melihat daftar tugas miliknya. |
| FR-07 | Detail tugas | User dapat melihat detail tugas. |
| FR-08 | Edit tugas | User dapat mengubah data tugas. |
| FR-09 | Hapus tugas | User dapat menghapus tugas. |
| FR-10 | Ubah status | User dapat mengubah status tugas. |
| FR-11 | Cari tugas | User dapat mencari tugas berdasarkan kata kunci. |
| FR-12 | Filter tugas | User dapat memfilter tugas berdasarkan kategori, prioritas, status, atau deadline. |
| FR-13 | Kelola pengguna | Admin dapat mengelola data pengguna. |
| FR-14 | Kelola kategori | Admin dapat mengelola kategori default. |
| FR-15 | Validasi input | Sistem memvalidasi input yang dikirimkan pengguna. |

---

## 10. Kebutuhan Non-Fungsional

| Kode | Kebutuhan | Deskripsi |
|---|---|---|
| NFR-01 | Usability | Sistem harus mudah digunakan dan memiliki tampilan sederhana. |
| NFR-02 | Responsiveness | Sistem harus responsif pada desktop dan smartphone. |
| NFR-03 | Performance | Sistem harus dapat memproses data dalam waktu yang wajar pada server lokal. |
| NFR-04 | Compatibility | Sistem dapat berjalan pada browser modern. |
| NFR-05 | Maintainability | Struktur project harus sederhana dan mudah dipahami. |
| NFR-06 | Security | Sistem menggunakan login dan session untuk membatasi akses. |
| NFR-07 | Authorization | User hanya dapat mengakses data tugas miliknya sendiri. |
| NFR-08 | Data Integrity | Data harus tersimpan dengan benar di database. |
| NFR-09 | Error Handling | Sistem menampilkan pesan jika terjadi kesalahan input atau proses gagal. |
| NFR-10 | UI Consistency | Tampilan user dan admin menggunakan style yang sama agar efisien. |

---

## 11. Halaman yang Dibutuhkan

| No | Halaman | Deskripsi |
|---|---|---|
| 1 | Landing Page | Halaman awal sistem. |
| 2 | Register | Halaman pendaftaran akun. |
| 3 | Login | Halaman masuk ke sistem. |
| 4 | Dashboard User | Halaman ringkasan tugas user. |
| 5 | Daftar Tugas | Halaman daftar tugas berbasis card. |
| 6 | Tambah Tugas | Halaman form tambah tugas. |
| 7 | Edit Tugas | Halaman form edit tugas. |
| 8 | Detail Tugas | Halaman detail tugas. |
| 9 | Dashboard Admin | Halaman ringkasan data admin. |
| 10 | Kelola Pengguna | Halaman pengelolaan data pengguna. |
| 11 | Kelola Kategori | Halaman pengelolaan kategori default. |

---

## 12. Hak Akses

| Fitur | Pengunjung | User | Admin |
|---|---|---|---|
| Landing page | Ya | Ya | Ya |
| Registrasi | Ya | Tidak | Tidak |
| Login | Ya | Ya | Ya |
| Dashboard user | Tidak | Ya | Tidak |
| Kelola tugas | Tidak | Ya | Tidak |
| Cari dan filter tugas | Tidak | Ya | Tidak |
| Dashboard admin | Tidak | Tidak | Ya |
| Kelola pengguna | Tidak | Tidak | Ya |
| Kelola kategori default | Tidak | Tidak | Ya |
| Logout | Tidak | Ya | Ya |

---

## 13. Struktur Database Awal

### 13.1 Tabel users

| Field | Tipe Data | Keterangan |
|---|---|---|
| id_user | INT | Primary key |
| nama | VARCHAR | Nama pengguna |
| email | VARCHAR | Email pengguna |
| password | VARCHAR | Password pengguna |
| role | ENUM | user atau admin |
| status | ENUM | aktif atau nonaktif |
| created_at | DATETIME | Waktu akun dibuat |

### 13.2 Tabel tasks

| Field | Tipe Data | Keterangan |
|---|---|---|
| id_task | INT | Primary key |
| id_user | INT | Foreign key ke tabel users |
| id_category | INT | Foreign key ke tabel categories |
| title | VARCHAR | Judul tugas |
| description | TEXT | Deskripsi tugas |
| priority | ENUM | rendah, sedang, tinggi |
| deadline | DATE | Batas waktu tugas |
| status | ENUM | belum dikerjakan, sedang dikerjakan, selesai |
| created_at | DATETIME | Waktu tugas dibuat |
| updated_at | DATETIME | Waktu tugas diperbarui |

### 13.3 Tabel categories

| Field | Tipe Data | Keterangan |
|---|---|---|
| id_category | INT | Primary key |
| category_name | VARCHAR | Nama kategori |
| created_at | DATETIME | Waktu kategori dibuat |

---

## 14. Acceptance Criteria

Sistem dinyatakan berhasil apabila:

1. Pengunjung dapat melakukan registrasi.
2. User dan admin dapat login sesuai role.
3. User dapat menambah, melihat, mengedit, menghapus, dan mengubah status tugas.
4. User dapat mencari dan memfilter tugas.
5. User hanya dapat melihat data tugas miliknya sendiri.
6. Admin dapat mengelola data pengguna.
7. Admin dapat mengelola kategori default.
8. Tampilan sistem berbasis card dan responsif.
9. Sistem menampilkan badge prioritas dan status tugas.
10. Sistem dapat berjalan secara lokal menggunakan XAMPP.
11. Sistem dapat digunakan melalui browser tanpa API eksternal.
12. Sistem memiliki tampilan minimalis, clean productivity, dan modern.
13. Warna tampilan sistem menggunakan kode warna HEX yang konsisten.

---

## 15. Risiko dan Solusi

| Risiko | Dampak | Solusi |
|---|---|---|
| Tampilan terlalu ramai | Pengguna cepat lelah saat menggunakan sistem | Menggunakan desain minimalis dan warna lembut. |
| Sistem tidak responsif | Sulit digunakan pada smartphone | Menggunakan Bootstrap atau Tailwind CSS. |
| User lupa password | User tidak dapat login | Fitur reset password dapat ditambahkan pada pengembangan lanjutan. |
| Password tidak di-hash | Keamanan data rendah | Untuk versi produksi, password harus menggunakan hash. |
| Query filter tidak tepat | Data tugas tidak muncul sesuai filter | Melakukan pengujian pada setiap query pencarian dan filter. |
| Penggunaan Flask dan PHP bersamaan membingungkan | Struktur sistem menjadi lebih kompleks | PHP Native dijadikan backend utama, Flask hanya digunakan jika benar-benar diperlukan. |
| Warna tampilan tidak konsisten | Tampilan antar halaman berbeda-beda | Menggunakan variabel CSS dan kode warna HEX yang sudah ditentukan. |

---

## 16. Kesimpulan

Sistem To-Do List dan Manajemen Tugas Berbasis Web dirancang sebagai aplikasi manajemen tugas sederhana untuk kebutuhan tugas kuliah. Sistem menggunakan tampilan minimalis, clean productivity, modern, dan terinspirasi dari Trello dengan daftar tugas berbasis card.

Tech stack utama yang digunakan adalah PHP Native, MySQL, HTML, CSS, JavaScript, Bootstrap atau Tailwind CSS, dan XAMPP sebagai lingkungan pengembangan lokal. Sistem tidak membutuhkan API dan tidak menggunakan GitHub karena fokus pengembangan adalah web sederhana yang berjalan secara lokal.

PRD ini menjadi acuan dalam tahap desain, implementasi, dan pengujian sistem. Dengan adanya kode warna HEX, tampilan sistem diharapkan lebih konsisten, nyaman dilihat, dan mudah dikembangkan.
