# 11. Desain Testing Black Box

## 11.1 Tujuan Testing

Desain testing black box digunakan untuk menguji fungsi Sistem To-Do List dan Manajemen Tugas Berbasis Web berdasarkan input dan output yang dihasilkan oleh sistem. Pada pengujian ini, tester tidak perlu melihat source code atau struktur internal program, tetapi cukup menguji apakah fitur yang tersedia pada antarmuka sistem sudah berjalan sesuai kebutuhan.

Tujuan dari pengujian ini adalah memastikan bahwa setiap fitur utama, seperti registrasi, login, pengelolaan tugas, pencarian, filter, pengelolaan kategori, pengelolaan pengguna, dan logout dapat berjalan dengan benar. Selain itu, testing juga digunakan untuk menemukan kesalahan fungsi, validasi input, serta memastikan output sistem sesuai dengan hasil yang diharapkan.

## 11.2 Ruang Lingkup Testing

Ruang lingkup black box testing pada sistem ini mencakup pengujian terhadap fitur yang digunakan oleh tiga aktor utama, yaitu Pengunjung, User, dan Admin.

| No | Aktor | Fitur yang Diuji |
| --- | --- | --- |
| 1 | Pengunjung | Registrasi akun dan login |
| 2 | User | Dashboard, tambah tugas, lihat tugas, detail tugas, edit tugas, hapus tugas, ubah status, pencarian, filter, dan logout |
| 3 | Admin | Login admin, dashboard admin, kelola pengguna, kelola kategori default, dan logout |

## 11.3 Metode Pengujian

Metode yang digunakan adalah Black Box Testing, yaitu teknik pengujian yang berfokus pada fungsi sistem dari sisi pengguna. Pengujian dilakukan dengan cara memberikan input tertentu pada sistem, kemudian membandingkan output yang muncul dengan output yang diharapkan.

Pengujian ini termasuk dalam pengujian fungsional karena fokus utamanya adalah memastikan fitur sistem berjalan sesuai kebutuhan. Jenis pengujian dilakukan secara manual dengan menjalankan setiap skenario pengujian melalui antarmuka aplikasi web.

## 11.4 Rancangan Test Case Black Box

| No | Kode Test | Fitur yang Diuji | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Status |
| --- | --- | --- | --- | --- | --- | --- |
| 1 | TC-01 | Registrasi Akun | Pengunjung melakukan registrasi dengan data lengkap | Nama: User Demo, Email: user@gmail.com, Password: user123 | Sistem menyimpan akun baru dan mengarahkan pengguna ke halaman login | Belum diuji |
| 2 | TC-02 | Registrasi Akun | Pengunjung mengosongkan salah satu data registrasi | Nama/email/password kosong | Sistem menampilkan pesan bahwa data wajib diisi | Belum diuji |
| 3 | TC-03 | Registrasi Akun | Pengunjung menggunakan email yang sudah terdaftar | Email yang sudah ada di database | Sistem menampilkan pesan bahwa email sudah digunakan | Belum diuji |
| 4 | TC-04 | Login User | User login dengan data yang benar | Email dan password valid | Sistem mengarahkan user ke dashboard user | Belum diuji |
| 5 | TC-05 | Login User | User login dengan password salah | Email benar, password salah | Sistem menampilkan pesan email atau password salah | Belum diuji |
| 6 | TC-06 | Login User | User login dengan field kosong | Email/password kosong | Sistem menampilkan pesan bahwa input wajib diisi | Belum diuji |
| 7 | TC-07 | Login Admin | Admin login dengan akun admin yang valid | Email admin dan password admin | Sistem mengarahkan admin ke dashboard admin | Belum diuji |
| 8 | TC-08 | Dashboard User | User membuka dashboard setelah login | Session user aktif | Sistem menampilkan total tugas, tugas belum dikerjakan, sedang dikerjakan, dan selesai | Belum diuji |
| 9 | TC-09 | Tambah Tugas | User menambahkan tugas dengan data lengkap | Judul, deskripsi, kategori, prioritas, deadline, status | Sistem menyimpan tugas dan menampilkan tugas pada daftar tugas | Belum diuji |
| 10 | TC-10 | Tambah Tugas | User menambahkan tugas tanpa judul | Judul kosong | Sistem menampilkan pesan bahwa judul tugas wajib diisi | Belum diuji |
| 11 | TC-11 | Tambah Tugas | User menambahkan tugas tanpa deadline | Deadline kosong | Sistem menampilkan pesan bahwa deadline wajib diisi | Belum diuji |
| 12 | TC-12 | Lihat Daftar Tugas | User membuka halaman daftar tugas | Session user aktif | Sistem menampilkan daftar tugas milik user yang sedang login | Belum diuji |
| 13 | TC-13 | Lihat Daftar Tugas | User belum memiliki tugas | Data tugas kosong | Sistem menampilkan pesan bahwa belum ada tugas | Belum diuji |
| 14 | TC-14 | Detail Tugas | User membuka detail tugas | ID tugas valid | Sistem menampilkan detail tugas yang dipilih | Belum diuji |
| 15 | TC-15 | Detail Tugas | User membuka tugas yang tidak tersedia | ID tugas tidak valid | Sistem menampilkan pesan tugas tidak ditemukan | Belum diuji |
| 16 | TC-16 | Edit Tugas | User mengubah data tugas dengan data valid | Judul, deskripsi, kategori, prioritas, deadline, status baru | Sistem memperbarui data tugas dan menampilkan pesan berhasil | Belum diuji |
| 17 | TC-17 | Edit Tugas | User mengedit tugas dengan data tidak lengkap | Judul/deadline kosong | Sistem menampilkan pesan data tidak valid | Belum diuji |
| 18 | TC-18 | Hapus Tugas | User menghapus tugas dan menyetujui konfirmasi | ID tugas valid, tombol hapus ditekan | Sistem menghapus tugas dari database dan memperbarui daftar tugas | Belum diuji |
| 19 | TC-19 | Hapus Tugas | User membatalkan proses hapus tugas | Tombol batal ditekan | Sistem membatalkan penghapusan dan tugas tetap tampil | Belum diuji |
| 20 | TC-20 | Ubah Status Tugas | User mengubah status tugas menjadi selesai | Status: selesai | Sistem memperbarui status tugas menjadi selesai | Belum diuji |
| 21 | TC-21 | Ubah Status Tugas | User memilih status tidak valid | Status kosong/tidak sesuai pilihan | Sistem menampilkan pesan status tidak valid | Belum diuji |
| 22 | TC-22 | Pencarian Tugas | User mencari tugas berdasarkan kata kunci yang tersedia | Kata kunci sesuai judul tugas | Sistem menampilkan tugas yang sesuai dengan kata kunci | Belum diuji |
| 23 | TC-23 | Pencarian Tugas | User mencari tugas dengan kata kunci yang tidak tersedia | Kata kunci tidak cocok | Sistem menampilkan pesan tugas tidak ditemukan | Belum diuji |
| 24 | TC-24 | Filter Tugas | User memfilter tugas berdasarkan prioritas tinggi | Filter: prioritas tinggi | Sistem menampilkan tugas dengan prioritas tinggi | Belum diuji |
| 25 | TC-25 | Filter Tugas | User memfilter tugas berdasarkan status selesai | Filter: selesai | Sistem menampilkan daftar tugas yang sudah selesai | Belum diuji |
| 26 | TC-26 | Filter Tugas | User memfilter tugas berdasarkan kategori | Filter: kategori tertentu | Sistem menampilkan tugas sesuai kategori yang dipilih | Belum diuji |
| 27 | TC-27 | Kelola Pengguna | Admin membuka halaman kelola pengguna | Session admin aktif | Sistem menampilkan daftar pengguna | Belum diuji |
| 28 | TC-28 | Kelola Pengguna | Admin menonaktifkan akun user | ID user valid | Sistem mengubah status akun menjadi nonaktif | Belum diuji |
| 29 | TC-29 | Kelola Pengguna | Admin mengaktifkan akun user | ID user valid | Sistem mengubah status akun menjadi aktif | Belum diuji |
| 30 | TC-30 | Kelola Pengguna | Admin menghapus pengguna | ID user valid dan konfirmasi hapus | Sistem menghapus data pengguna sesuai ketentuan | Belum diuji |
| 31 | TC-31 | Kelola Kategori | Admin menambahkan kategori baru | Nama kategori valid | Sistem menyimpan kategori baru dan menampilkan pada daftar kategori | Belum diuji |
| 32 | TC-32 | Kelola Kategori | Admin menambahkan kategori dengan nama kosong | Nama kategori kosong | Sistem menampilkan pesan bahwa nama kategori wajib diisi | Belum diuji |
| 33 | TC-33 | Kelola Kategori | Admin menambahkan kategori yang sudah ada | Nama kategori duplikat | Sistem menampilkan pesan bahwa kategori sudah tersedia | Belum diuji |
| 34 | TC-34 | Kelola Kategori | Admin mengedit nama kategori | Nama kategori baru | Sistem memperbarui data kategori | Belum diuji |
| 35 | TC-35 | Kelola Kategori | Admin menghapus kategori default | ID kategori valid dan konfirmasi hapus | Sistem menghapus kategori dan memperbarui daftar kategori | Belum diuji |
| 36 | TC-36 | Logout | User atau admin menekan tombol logout | Session aktif | Sistem menghapus session dan mengarahkan pengguna ke halaman login | Belum diuji |
| 37 | TC-37 | Hak Akses User | User mencoba membuka halaman admin | Session user aktif | Sistem menolak akses dan mengarahkan user ke halaman yang sesuai | Belum diuji |
| 38 | TC-38 | Hak Akses Belum Login | Pengunjung mencoba membuka dashboard user | Belum login | Sistem mengarahkan pengguna ke halaman login | Belum diuji |

## 11.5 Pengujian Berdasarkan Aktor

### 11.5.1 Pengujian Pengunjung

Pengujian pada aktor Pengunjung dilakukan untuk memastikan bahwa pengguna yang belum login hanya dapat mengakses halaman yang diperbolehkan, yaitu landing page, registrasi, dan login. Pengunjung tidak boleh mengakses dashboard user maupun halaman admin sebelum berhasil login.

### 11.5.2 Pengujian User

Pengujian pada aktor User dilakukan untuk memastikan bahwa user dapat mengelola tugas miliknya sendiri. Fitur yang diuji meliputi melihat dashboard, menambah tugas, melihat daftar tugas, melihat detail tugas, mengedit tugas, menghapus tugas, mengubah status, mencari tugas, memfilter tugas, dan logout.

Pengujian juga harus memastikan bahwa user tidak dapat melihat atau mengubah data tugas milik user lain. Hal ini penting untuk menjaga keamanan dan privasi data pengguna.

### 11.5.3 Pengujian Admin

Pengujian pada aktor Admin dilakukan untuk memastikan bahwa fitur admin hanya dapat diakses oleh akun dengan role admin. Admin diuji dalam proses login, melihat dashboard admin, mengelola data pengguna, mengelola kategori default, dan logout.

## 11.6 Kriteria Keberhasilan Testing

Black box testing pada sistem ini dinyatakan berhasil apabila seluruh fitur menghasilkan output yang sesuai dengan input dan skenario pengujian. Sistem juga harus dapat menampilkan pesan kesalahan apabila pengguna memberikan input yang salah, kosong, atau tidak valid.

Kriteria keberhasilan testing adalah sebagai berikut:

1. Sistem dapat menjalankan semua fitur utama sesuai kebutuhan fungsional.

2. Sistem menerima input valid dan menghasilkan output yang sesuai.

3. Sistem menolak input kosong, salah, atau tidak valid.

4. Sistem menampilkan pesan kesalahan dengan jelas.

5. Sistem dapat membedakan hak akses antara Pengunjung, User, dan Admin.

6. User hanya dapat mengakses data tugas miliknya sendiri.

7. Admin hanya dapat mengakses halaman admin setelah login sebagai admin.

8. Data yang ditambahkan, diubah, atau dihapus dapat diperbarui pada database.

9. Fitur pencarian dan filter menampilkan data sesuai input pengguna.

10. Proses logout dapat menghapus session dan mengarahkan pengguna ke halaman login.

## 11.7 Kesimpulan Desain Testing

Desain testing black box pada Sistem To-Do List dan Manajemen Tugas Berbasis Web disusun berdasarkan fitur yang telah dirancang pada tahap analisis kebutuhan, use case diagram, dan activity diagram. Pengujian ini berfokus pada kesesuaian input dan output dari setiap fitur tanpa melihat kode program.

Dengan adanya rancangan test case ini, pengembang dapat menguji apakah sistem sudah berjalan sesuai kebutuhan pengguna. Jika seluruh test case menghasilkan output sesuai harapan, maka sistem dapat dinyatakan layak secara fungsional untuk digunakan pada tahap implementasi dan evaluasi.
