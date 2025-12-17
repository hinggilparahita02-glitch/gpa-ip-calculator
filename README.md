# Laporan Progress Project Aplikasi Web Kalkulator IPS

Aplikasi web untuk menghitung Indeks Prestasi Semester (IPS) secara otomatis berdasarkan daftar mata kuliah, nilai, dan jumlah SKS.
***
#### Nama       : Hinggil Parahita 
#### Kelas      : II RKS A 
#### NPM        : 2423102033
***

## 1. Deskripsi
Kalkulator IPS Semester adalah aplikasi web-based sederhana yang bertujuan mempermudah Taruna menghitung Indeks Prestasi Semester secara cepat dan akurat. Aplikasi ini menyelesaikan masalah konversi nilai skor (0-100) ke nilai huruf/mutu dan perhitungan rata-rata IPS yang sering memakan waktu jika dilakukan manual. Karena terbatasnya akses Taruna terhadap hasil nilai pada setiap semester membuat penulis mencoba mengembangkan aplikasi Kalkulator IPS Semester ini agar memudahkan Taruna dalam memprediksi nilai IPK yang dicapai sehingga bisa mempersiapkan segala hal, termasuk meningkatkan prestasi lebih banyak serta memberikan gambaran cepat mengenai performa akademik dan membantu perencanaan studi semester berikutnya. Kemudian, dalam penggunaannya juga sudah diimplementasikan seperti sistem DHS dari bagian Administrasi, Akademik dan Kemahasiswaan sehingga benar benar memprediksi secara keseluruhan.

## 2. User Story
Sebagai pengguna, saya ingin:

-	Saya ingin menambah dan menghapus mata kuliah di tabel agar daftar mata kuliah semester saya sesuai.
-	Saya ingin memasukkan skor akhir (0-100) untuk setiap mata kuliah agar sistem dapat mengonversi dan menghitung Nilai Mutu otomatis.
-	Saya ingin melihat nilai IPS final secara jelas agar saya bisa memprediksi hasil akademik saya.

## 3. SRS (Software Requirements Specification)
### 3.1 Lingkup Sistem
Sistem berfungsi sebagai kalkulator IPS sederhana untuk satu semester, dengan fokus pada kemudahan input data, visualisasi hasil IPS, dan pengelolaan daftar mata kuliah.<img width="550" height="397" alt="Screenshot 2025-12-16 151038" src="https://github.com/user-attachments/assets/0d6f4a61-437f-4997-96c9-b3efc3d552cc" />


### 3.2 Kebutuhan Fungsional
#### a. Manajemen Mata Kuliah
- User dapat menambahkan data mata kuliah melalui form berisi:
  - Nama mata kuliah.  
  - Nilai angka (rentang 0–100).  
  - SKS (dipilih dari opsi tertentu, misalnya 1–4 SKS).
- Data yang berhasil ditambahkan akan muncul di tabel daftar mata kuliah.
- User dapat menghapus satu baris mata kuliah melalui tombol/ikon hapus di kolom Aksi.
  
#### b. Konversi Nilai & Perhitungan IPS
- Sistem mengonversi nilai angka menjadi:
  - Nilai huruf (A, B, C, D, E) sesuai rentang nilai yang ditentukan.  
  - Nilai poin skala 0–4 (misalnya A = 4.0, B = 3.0, dst.).
- Sistem menghitung **Total Poin Kualitas** dengan rumus:  
<img width="208" height="31" alt="Screenshot 2025-12-17 104438" src="https://github.com/user-attachments/assets/56b8081c-e01f-433a-a12c-ad41c8f2ee70" />

- Sistem menghitung **IPS** dengan rumus:
  
  <img width="144" height="44" alt="Screenshot 2025-12-17 104546" src="https://github.com/user-attachments/assets/3e8b712b-ff79-488c-adcb-e00508fa5cd6" />

  dan menampilkannya dalam skala 4.0 beserta label kualitas singkat, misalnya “Sangat Baik”.

#### d. Ringkasan & Tampilan Dashboard
- Menampilkan kartu **IPS Saat Ini** yang berisi:
  - Nilai IPS (misalnya 3.75 / 4.0).  
  - Label kualitas seperti “Sangat Baik”, “Baik”, dll berdasarkan rentang IPS.
- Menampilkan kartu **Total Mata Kuliah** yang sedang dihitung pada semester tersebut.
- Menampilkan tabel daftar mata kuliah dengan kolom:
  - Nama Mata Kuliah  
  - Nilai  
  - Huruf  
  - Poin  
  - SKS  
  - Aksi (hapus)

#### e. Pengelolaan Data
- Data yang diinput disimpan dalam struktur JSON di sisi klien atau backend (misalnya Local Storage / database) agar dapat digunakan kembali selama sesi.
- Fitur **Reset Data** untuk menghapus semua data mata kuliah dan mengembalikan tampilan ke kondisi awal.
  
### 3.3 Kebutuhan Non-Fungsional
- **Usability:** Antarmuka sederhana, responsif, dan mudah dipahami pengguna baru.
- **Performance:** Perhitungan IPS dilakukan instan setelah data diubah tanpa reload penuh halaman.
- **Compatibility:** Dapat berjalan di browser modern (Chrome, Edge, Firefox, dll.) tanpa instalasi tambahan.

## 4. UML Diagram
### a. Use Case Diagram

```mermaid
graph LR
    User((User))

    subgraph Aplikasi [Aplikasi Kalkulator IPS]
        direction TB
        UC1(Tambah Mata Kuliah)
        UC2(Lihat Ringkasan IPS)
        UC3(Hapus Mata Kuliah)
        UC4(Reset Data)
    end

    User --> UC1
    User --> UC2
    User --> UC3
    User --> UC4
```


### b. Activity Diagram

```mermaid
flowchart TD
    Start((Mulai)) --> Input[Isi Nama, Nilai, dan SKS]
    Input --> Tambah{Tambah Mata Kuliah?}
    Tambah -- Ya --> Simpan[Data Disimpan ke List]
    Simpan --> Hitung[Hitung Total Poin & IPS]
    Hitung --> Tampil[Tampilkan Tabel & Ringkasan IPS]
    Tambah -- Tidak --> Selesai((Selesai))

    Tampil --> Aksi{Hapus/Reset?}
    Aksi -- Hapus --> HapusData[Hapus Baris Mata Kuliah]
    HapusData --> Hitung
    Aksi -- Reset --> ResetData[Hapus Semua Data]
    ResetData --> Tampil
```


### c. Sequence Diagram

```mermaid
sequenceDiagram
    participant User
    participant Web
    participant Calculator

    User->>Web: Input nama, nilai, SKS
    User->>Web: Klik "Tambah Mata Kuliah"
    Web->>Calculator: Kirim data mata kuliah baru
    Calculator-->>Web: Update list & hitung IPS
    Web->>User: Tampilkan tabel baru dan IPS

    User->>Web: Klik ikon hapus pada baris tertentu
    Web->>Calculator: Hapus data mata kuliah
    Calculator-->>Web: Hitung ulang IPS
    Web->>User: Tampilkan tabel & IPS yang sudah diperbarui
```


***

## 5. Mock-Up
### a. Tampilan Dashboard
- Kartu **IPS Saat Ini** di sisi kiri menampilkan angka IPS, skala 4.0.
- Kartu **Total Mata Kuliah** di sisi kanan menampilkan jumlah mata kuliah yang telah diinput.

### b. Form Tambah Mata Kuliah
- Terdapat tiga input: `Nama Mata Kuliah`, `Nilai (0–100)`, dan `SKS` (dropdown).
- Tombol berwarna ungu “+ Tambah Mata Kuliah” digunakan untuk menyimpan data ke tabel dan menghitung IPS.
  
### c. Tabel Mata Kuliah
- Tabel menampilkan setiap data mata kuliah dengan kolom:
  - Nama Mata Kuliah (misal: *etsan*, *matdis*).  
  - Nilai (contoh: 84.00, 99.00).  
  - Huruf (contoh: B, A).  
  - Poin (contoh: 3.0, 4.0).  
  - SKS (contoh: 1, 3).  
  - Aksi (ikon tempat sampah merah untuk menghapus baris).
- Desain menggunakan tema warna lembut dengan aksen ungu pada tombol dan border sehingga tampilan bersih dan modern.
<img width="612" height="361" alt="image" src="https://github.com/user-attachments/assets/a7dd8b40-6983-4d1b-bc38-463ac1a38d5b" />
<img width="550" height="397" alt="Screenshot 2025-12-16 151038" src="https://github.com/user-attachments/assets/c06ff63b-2d40-43e0-b636-23ea6c8681c1" />

