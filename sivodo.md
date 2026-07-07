\# 📄 PERENCANAAN APLIKASI VOTING MAHASISWA



\*\*PT Lentera Edukasi ENBI Nusantara - Kelompok 1\*\*



\---



\## DAFTAR ISI



1\. \[Analisis Kebutuhan](#1-analisis-kebutuhan)

2\. \[Use Case Diagram](#2-use-case-diagram)

3\. \[Activity Diagram](#3-activity-diagram)

4\. \[Sequence Diagram](#4-sequence-diagram)

5\. \[Class Diagram](#5-class-diagram)

6\. \[ERD](#6-erd-entity-relationship-diagram)

7\. \[Struktur Database](#7-struktur-database)

8\. \[Struktur Menu](#8-struktur-menu)

9\. \[Desain UI/UX](#9-desain-uiux)

10\. \[Pembagian Tugas Tim](#10-pembagian-tugas-tim)

11\. \[Timeline Pengerjaan](#11-timeline-pengerjaan)

12\. \[Teknologi yang Digunakan](#12-teknologi-yang-digunakan)



\---



\## 1. ANALISIS KEBUTUHAN



\### A. Informasi Proyek



| Item | Keterangan |

|------|------------|

| \*\*Nama Perusahaan\*\* | PT Lentera Edukasi ENBI Nusantara |

| \*\*Judul Aplikasi\*\* | Aplikasi Voting Mahasiswa terhadap Kinerja Dosen Selama 1 Semester |

| \*\*Tujuan\*\* | Menyediakan sistem evaluasi kinerja dosen berbasis voting mahasiswa yang terukur, terdokumentasi, dan dapat dijadikan bahan evaluasi akademik |

| \*\*Platform\*\* | Web Based |

| \*\*Framework\*\* | Laravel 12 |

| \*\*Database\*\* | MySQL |

| \*\*Frontend\*\* | Tailwind CSS, Alpine.js, Chart.js |



\### B. Tujuan Sistem



1\. \*\*Terukur\*\* - Menggunakan skala penilaian 1-5 yang jelas

2\. \*\*Terdokumentasi\*\* - Semua aktivitas tercatat dalam activity log

3\. \*\*Dapat dijadikan bahan evaluasi akademik\*\* - Menghasilkan laporan lengkap untuk pimpinan

4\. \*\*Aman\*\* - Validasi voting satu kali per mahasiswa

5\. \*\*Transparan\*\* - Hasil evaluasi dapat dilihat oleh pihak terkait

6\. \*\*Mudah digunakan\*\* - Antarmuka sederhana dan responsif



\### C. Aktor dan Hak Akses



| Aktor | Hak Akses | Menu Utama |

|-------|-----------|------------|

| \*\*Admin\*\* | Full Access (CRUD semua data) | Dashboard, Master Data, Voting, Laporan, Activity Log, Backup, Profil |

| \*\*Mahasiswa\*\* | Terbatas (hanya voting \& melihat hasil) | Dashboard, Daftar Dosen, Form Voting, Riwayat, Hasil Penilaian, Ranking, Profil |

| \*\*Pimpinan\*\* | Read Only (hanya melihat laporan) | Dashboard, Grafik, Ranking, Laporan, Profil |



\### D. Fitur yang Harus Ada



| No | Fitur | Keterangan | Status |

|----|-------|------------|--------|

| 1 | \*\*Login Multi-User\*\* | Admin, Mahasiswa, Pimpinan (3 role) | ✅ |

| 2 | \*\*Dashboard\*\* | 3 dashboard berbeda sesuai role | ✅ |

| 3 | \*\*CRUD Data\*\* | Dosen, Mahasiswa, Mata Kuliah, Semester, Pertanyaan | ✅ |

| 4 | \*\*Pencarian \& Filter\*\* | Di setiap halaman data | ✅ |

| 5 | \*\*Upload Berkas\*\* | Foto dosen, foto mahasiswa, RPS mata kuliah | ✅ |

| 6 | \*\*Laporan\*\* | PDF \& Excel dengan filter | ✅ |

| 7 | \*\*Hak Akses\*\* | Middleware per role | ✅ |

| 8 | \*\*Riwayat Aktivitas\*\* | Mencatat semua aktivitas user | ✅ |

| 9 | \*\*Backup Data\*\* | Backup, Restore, Download | ✅ |

| 10 | \*\*Mobile Friendly\*\* | Responsif dengan Tailwind CSS | ✅ |



\### E. Aturan Sistem



| No | Aturan | Penjelasan |

|----|--------|------------|

| 1 | \*\*Satu Kali Voting\*\* | 1 mahasiswa × 1 mata kuliah × 1 semester = 1 voting |

| 2 | \*\*Validasi Database\*\* | UNIQUE constraint (mahasiswa\_id + mata\_kuliah\_id + semester\_id) |

| 3 | \*\*Semester Aktif\*\* | Hanya semester aktif yang ditampilkan ke mahasiswa |

| 4 | \*\*Tidak Bisa Ubah\*\* | Setelah voting, tidak bisa mengubah jawaban |

| 5 | \*\*Anonim\*\* | Identitas mahasiswa tidak muncul di laporan |



\### F. Modul \& Fitur Detail



| Modul / Fitur | Keterangan |

|---------------|------------|

| \*\*Login\*\* | Mahasiswa, Admin, dan Pimpinan dengan 3 role berbeda |

| \*\*Master Data Dosen\*\* | Nama dosen, NIDN/NIP, program studi, mata kuliah, semester mengajar, status dosen (PNS/Yayasan/LB), foto |

| \*\*Master Data Mahasiswa\*\* | Nama, NIM, program studi, semester, kelas, validasi hak voting, foto |

| \*\*Data Mata Kuliah\*\* | Nama mata kuliah, kode, dosen pengampu, kelas, semester, RPS |

| \*\*Form Voting/Evaluasi\*\* | Penguasaan materi, cara mengajar, kedisiplinan, komunikasi, ketepatan waktu, tugas, objektivitas penilaian, kritik dan saran |

| \*\*Sistem Skor Otomatis\*\* | Skala 1-5, rata-rata dosen, ranking dosen, rekap nilai per mata kuliah, kategori penilaian |

| \*\*Keamanan Voting\*\* | Mahasiswa hanya bisa voting satu kali per dosen/mata kuliah, identitas dianonimkan dalam laporan |

| \*\*Laporan Evaluasi\*\* | Laporan per dosen, mata kuliah, program studi, grafik kinerja, export PDF/Excel |

| \*\*Dashboard Pimpinan\*\* | Dosen nilai tertinggi, dosen yang perlu pembinaan, jumlah mahasiswa voting, rata-rata kepuasan |



\---



\## 2. USE CASE DIAGRAM



```

┌─────────────────────────────────────────────────────────────────────────────┐

│                      SISTEM VOTING MAHASISWA                               │

│                                                                             │

│  ┌──────────────┐                                                          │

│  │    ADMIN     │                                                          │

│  └──────┬───────┘                                                          │

│         │                                                                   │

│         ├─── Kelola Dosen                                                   │

│         ├─── Kelola Mahasiswa                                              │

│         ├─── Kelola Mata Kuliah                                            │

│         ├─── Kelola Semester                                               │

│         ├─── Kelola Pertanyaan                                             │

│         ├─── Lihat Semua Voting                                            │

│         ├─── Cetak Laporan                                                 │

│         ├─── Lihat Activity Log                                            │

│         └─── Backup Database                                               │

│                                                                             │

│  ┌──────────────┐                                                          │

│  │  MAHASISWA   │                                                          │

│  └──────┬───────┘                                                          │

│         │                                                                   │

│         ├─── Lihat Daftar Dosen                                            │

│         ├─── Isi Kuisioner                                                 │

│         ├─── Lihat Riwayat Voting                                          │

│         ├─── Lihat Hasil Penilaian Dosen                                   │

│         └─── Lihat Ranking Dosen                                           │

│                                                                             │

│  ┌──────────────┐                                                          │

│  │  PIMPINAN    │                                                          │

│  └──────┬───────┘                                                          │

│         │                                                                   │

│         ├─── Lihat Dashboard                                               │

│         ├─── Lihat Grafik                                                  │

│         ├─── Lihat Ranking                                                 │

│         └─── Cetak Laporan                                                 │

│                                                                             │

│  ┌──────────────┐                                                          │

│  │   SISTEM     │                                                          │

│  └──────────────┘                                                          │

│         │                                                                   │

│         ├─── Autentikasi Login                                             │

│         ├─── Perhitungan Skor Otomatis                                     │

│         └─── Mencatat Activity Log                                         │

└─────────────────────────────────────────────────────────────────────────────┘

```



\### Deskripsi Use Case



| Use Case | Aktor | Deskripsi |

|----------|-------|-----------|

| Kelola Dosen | Admin | Tambah, edit, hapus, lihat data dosen |

| Kelola Mahasiswa | Admin | Tambah, edit, hapus, lihat data mahasiswa |

| Kelola Mata Kuliah | Admin | Tambah, edit, hapus, lihat data mata kuliah |

| Kelola Semester | Admin | Tambah, edit, hapus, lihat data semester |

| Kelola Pertanyaan | Admin | Tambah, edit, hapus, lihat pertanyaan kuisioner |

| Isi Kuisioner | Mahasiswa | Mengisi penilaian untuk dosen |

| Lihat Ranking | Mahasiswa, Pimpinan | Melihat peringkat dosen |

| Cetak Laporan | Admin, Pimpinan | Export PDF/Excel |



\---



\## 3. ACTIVITY DIAGRAM



\### A. Activity Diagram Login



```

┌─────────────┐

│   START     │

└──────┬──────┘

&#x20;      ▼

┌─────────────────┐

│ Buka Halaman    │

│ Login           │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Input Username  │

│ \& Password      │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Pilih Role      │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Klik Login      │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐      ┌─────────────────┐

│ Validasi Data   │──────│ Tidak Valid     │

└──────┬──────────┘      │ Tampilkan Error │

&#x20;      ▼ Valid           └─────────────────┘

┌─────────────────┐

│ Redirect ke     │

│ Dashboard       │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│   END           │

└─────────────────┘

```



\### B. Activity Diagram Voting Mahasiswa



```

┌─────────────┐

│   START     │

└──────┬──────┘

&#x20;      ▼

┌─────────────────┐

│ Mahasiswa Login │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Ke Halaman      │

│ Voting          │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────────────────────┐

│ Tampilkan Daftar Dosen          │

│ (Berdasarkan Semester Aktif)    │

└──────┬──────────┬───────────────┘

&#x20;      │          │

&#x20;      │          ▼

&#x20;      │  ┌─────────────────────────┐

&#x20;      │  │ Tampilkan Status        │

&#x20;      │  │ "Sudah Voting" /        │

&#x20;      │  │ "Belum Voting"          │

&#x20;      │  └─────────────────────────┘

&#x20;      ▼

┌─────────────────┐

│ Pilih Dosen     │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐      ┌─────────────────┐

│ Cek Apakah      │──────│ Sudah Voting    │

│ Sudah Voting?   │      │ Tampilkan       │

└──────┬──────────┘      │ "Sudah Dinilai" │

&#x20;      ▼ Belum           └─────────────────┘

┌─────────────────┐

│ Tampilkan       │

│ 9 Pertanyaan    │

│ Kuisioner       │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Pilih Nilai     │

│ 1-5             │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Isi Kritik      │

│ \& Saran         │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Klik Kirim      │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐      ┌─────────────────┐

│ Konfirmasi      │──────│ Batal           │

│ Apakah Yakin?   │      └─────────────────┘

└──────┬──────────┘

&#x20;      ▼ Ya

┌─────────────────┐

│ Simpan ke       │

│ Database        │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Hitung Skor     │

│ Otomatis        │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────────────────────┐

│ Tampilkan Hasil:               │

│ • Total Skor (misal: 40/50)    │

│ • Rata-rata (misal: 4.0)       │

│ • Kategori (Memuaskan)         │

└──────┬──────────┬───────────────┘

&#x20;      ▼

┌─────────────────┐

│   END           │

└─────────────────┘

```



\### C. Activity Diagram CRUD Admin



```

┌─────────────┐

│   START     │

└──────┬──────┘

&#x20;      ▼

┌─────────────────┐

│ Admin Login     │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Pilih Menu      │

│ (Dosen/Mhs/MK/  │

│  Semester/Pert) │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Tampilkan Data  │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────────────────────────────────────────┐

│                                                     │

│  ┌──────────┐  ┌──────────┐  ┌──────────┐         │

│  │  Tambah  │  │   Edit   │  │  Hapus   │         │

│  └────┬─────┘  └────┬─────┘  └────┬─────┘         │

│       ▼             ▼             ▼                │

│  ┌──────────┐  ┌──────────┐  ┌──────────┐         │

│  │ Form     │  │ Form     │  │ Konfir-  │         │

│  │ Input    │  │ Edit     │  │ masi     │         │

│  └────┬─────┘  └────┬─────┘  └────┬─────┘         │

│       ▼             ▼             ▼                │

│  ┌──────────┐  ┌──────────┐  ┌──────────┐         │

│  │ Simpan   │  │ Update   │  │ Hapus    │         │

│  └────┬─────┘  └────┬─────┘  └────┬─────┘         │

│       ▼             ▼             ▼                │

│  ┌─────────────────────────────────────────┐        │

│  │       Catat ke Activity Log            │        │

│  └─────────────────────────────────────────┘        │

│                                                     │

└─────────────────────────────────────────────────────┘

&#x20;      ▼

┌─────────────────┐

│ Tampilkan       │

│ Notifikasi      │

│ "Berhasil"      │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│   END           │

└─────────────────┘

```



\### D. Activity Diagram Perhitungan Skor



```

┌─────────────┐

│   START     │

└──────┬──────┘

&#x20;      ▼

┌─────────────────┐

│ Voting Dikirim  │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Ambil Nilai     │

│ dari 9          │

│ Pertanyaan      │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Total Skor =    │

│ Σ Nilai         │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Rata-rata =     │

│ Total Skor ÷ 9  │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────────────────────────────────────────┐

│ Tentukan Kategori:                                 │

│ 4.50 - 5.00 → Sangat Memuaskan                     │

│ 4.00 - 4.49 → Memuaskan                            │

│ 3.00 - 3.99 → Puas                                 │

│ 2.00 - 2.99 → Cukup                                │

│ < 2.00 → Tidak Puas                                │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Simpan ke       │

│ Database        │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│ Tampilkan ke    │

│ Mahasiswa       │

└──────┬──────────┘

&#x20;      ▼

┌─────────────────┐

│   END           │

└─────────────────┘

```



\---



\## 4. SEQUENCE DIAGRAM



\### A. Sequence Diagram Login



```

┌────────┐      ┌────────┐      ┌────────┐      ┌────────┐

│ User   │      │Login   │      │ Auth   │      │Database│

│        │      │Page    │      │Service │      │        │

└───┬────┘      └───┬────┘      └───┬────┘      └───┬────┘

&#x20;   │               │               │               │

&#x20;   │ 1. Buka       │               │               │

&#x20;   │    Halaman    │               │               │

&#x20;   │──────────────>│               │               │

&#x20;   │               │               │               │

&#x20;   │ 2. Input      │               │               │

&#x20;   │    Username   │               │               │

&#x20;   │    Password   │               │               │

&#x20;   │──────────────>│               │               │

&#x20;   │               │               │               │

&#x20;   │ 3. Klik Login │               │               │

&#x20;   │──────────────>│               │               │

&#x20;   │               │ 4. Kirim Data │               │

&#x20;   │               │──────────────>│               │

&#x20;   │               │               │ 5. Cek User   │

&#x20;   │               │               │──────────────>│

&#x20;   │               │               │               │

&#x20;   │               │               │ 6. Return     │

&#x20;   │               │               │<──────────────│

&#x20;   │               │               │               │

&#x20;   │               │ 7. Validasi  │               │

&#x20;   │               │    Role      │               │

&#x20;   │               │<──────────────│               │

&#x20;   │               │               │               │

&#x20;   │ 8. Redirect   │               │               │

&#x20;   │    Dashboard  │               │               │

&#x20;   │<──────────────│               │               │

&#x20;   │               │               │               │

```



\### B. Sequence Diagram Voting Mahasiswa



```

┌────────┐      ┌────────┐      ┌────────┐      ┌────────┐      ┌────────┐

│Mhs     │      │Voting  │      │Voting  │      │Database│      │Skor    │

│        │      │Page    │      │Service │      │        │      │Service │

└───┬────┘      └───┬────┘      └───┬────┘      └───┬────┘      └───┬────┘

&#x20;   │               │               │               │               │

&#x20;   │ 1. Buka       │               │               │               │

&#x20;   │    Halaman    │               │               │               │

&#x20;   │──────────────>│               │               │               │

&#x20;   │               │               │               │               │

&#x20;   │               │ 2. Request   │               │               │

&#x20;   │               │    Daftar    │               │               │

&#x20;   │               │    Dosen     │               │               │

&#x20;   │               │──────────────>│               │               │

&#x20;   │               │               │ 3. Get Dosen │               │

&#x20;   │               │               │──────────────>│               │

&#x20;   │               │               │               │               │

&#x20;   │               │               │ 4. Return    │               │

&#x20;   │               │               │<──────────────│               │

&#x20;   │               │               │               │               │

&#x20;   │               │ 5. Tampilkan │               │               │

&#x20;   │               │    Daftar    │               │               │

&#x20;   │<──────────────│               │               │               │

&#x20;   │               │               │               │               │

&#x20;   │ 6. Pilih      │               │               │               │

&#x20;   │    Dosen      │               │               │               │

&#x20;   │──────────────>│               │               │               │

&#x20;   │               │ 7. Request   │               │               │

&#x20;   │               │    Form      │               │               │

&#x20;   │               │──────────────>│               │               │

&#x20;   │               │               │ 8. Get       │               │

&#x20;   │               │               │    Pertanyaan│               │

&#x20;   │               │               │──────────────>│               │

&#x20;   │               │               │               │               │

&#x20;   │               │               │ 9. Return    │               │

&#x20;   │               │               │<──────────────│               │

&#x20;   │               │               │               │               │

&#x20;   │ 10. Tampilkan │               │               │               │

&#x20;   │    Form       │               │               │               │

&#x20;   │<──────────────│               │               │               │

&#x20;   │               │               │               │               │

&#x20;   │ 11. Isi       │               │               │               │

&#x20;   │    Kuisioner  │               │               │               │

&#x20;   │──────────────>│               │               │               │

&#x20;   │               │               │               │               │

&#x20;   │ 12. Klik      │               │               │               │

&#x20;   │    Kirim      │               │               │               │

&#x20;   │──────────────>│               │               │               │

&#x20;   │               │ 13. Simpan   │               │               │

&#x20;   │               │    Voting    │               │               │

&#x20;   │               │──────────────>│               │               │

&#x20;   │               │               │ 14. Insert   │               │

&#x20;   │               │               │    Voting    │               │

&#x20;   │               │               │──────────────>│               │

&#x20;   │               │               │               │               │

&#x20;   │               │               │ 15. Hitung   │               │

&#x20;   │               │               │    Skor      │               │

&#x20;   │               │               │──────────────>│               │

&#x20;   │               │               │               │               │

&#x20;   │               │               │               │ 16. Return   │

&#x20;   │               │               │               │    Hasil     │

&#x20;   │               │               │<──────────────│               │

&#x20;   │               │               │               │               │

&#x20;   │               │ 17. Return   │               │               │

&#x20;   │               │    Hasil     │               │               │

&#x20;   │<──────────────│               │               │               │

&#x20;   │               │               │               │               │

```



\### C. Sequence Diagram CRUD Admin



```

┌────────┐      ┌────────┐      ┌────────┐      ┌────────┐

│ Admin  │      │CRUD    │      │Service │      │Database│

│        │      │Page    │      │        │      │        │

└───┬────┘      └───┬────┘      └───┬────┘      └───┬────┘

&#x20;   │               │               │               │

&#x20;   │ 1. Buka       │               │               │

&#x20;   │    Halaman    │               │               │

&#x20;   │──────────────>│               │               │

&#x20;   │               │               │               │

&#x20;   │ 2. Klik       │               │               │

&#x20;   │    Tambah     │               │               │

&#x20;   │──────────────>│               │               │

&#x20;   │               │               │               │

&#x20;   │ 3. Tampilkan  │               │               │

&#x20;   │    Form       │               │               │

&#x20;   │<──────────────│               │               │

&#x20;   │               │               │               │

&#x20;   │ 4. Isi Form   │               │               │

&#x20;   │──────────────>│               │               │

&#x20;   │               │               │               │

&#x20;   │ 5. Klik       │               │               │

&#x20;   │    Simpan     │               │               │

&#x20;   │──────────────>│               │               │

&#x20;   │               │ 6. Kirim Data│               │

&#x20;   │               │──────────────>│               │

&#x20;   │               │               │ 7. Insert    │

&#x20;   │               │               │──────────────>│

&#x20;   │               │               │               │

&#x20;   │               │               │ 8. Return    │

&#x20;   │               │               │<──────────────│

&#x20;   │               │               │               │

&#x20;   │               │ 9. Return    │               │

&#x20;   │               │    Success   │               │

&#x20;   │               │<──────────────│               │

&#x20;   │               │               │               │

&#x20;   │ 10. Tampilkan │               │               │

&#x20;   │    Notifikasi │               │               │

&#x20;   │<──────────────│               │               │

&#x20;   │               │               │               │

```



\---



\## 5. CLASS DIAGRAM



```

┌─────────────────────────────────────────────────────────────────────────────────────┐

│                                   CLASS DIAGRAM                                    │

└─────────────────────────────────────────────────────────────────────────────────────┘



┌─────────────────────────────┐

│           User              │

├─────────────────────────────┤

│ - id: int                   │

│ - nama: string              │

│ - username: string          │

│ - email: string             │

│ - password: string          │

│ - role: string              │

│ - foto: string              │

│ - no\_hp: string             │

├─────────────────────────────┤

│ + login()                   │

│ + logout()                  │

│ + updateProfile()           │

└──────────────┬──────────────┘

&#x20;              │

&#x20;              │ 1

&#x20;              │

&#x20;              │ 1

&#x20;              ▼

┌─────────────────────────────┐

│         Mahasiswa           │

├─────────────────────────────┤

│ - id: int                   │

│ - user\_id: int              │

│ - nim: string               │

│ - program\_studi: string     │

│ - semester: int             │

│ - kelas: string             │

│ - hak\_voting: boolean       │

├─────────────────────────────┤

│ + getDosenBySemester()      │

│ + cekStatusVoting()         │

└──────────────┬──────────────┘

&#x20;              │

&#x20;              │ 1

&#x20;              │

&#x20;              │ N

&#x20;              ▼

┌─────────────────────────────┐

│          Voting             │

├─────────────────────────────┤

│ - id: int                   │

│ - mahasiswa\_id: int         │

│ - dosen\_id: int             │

│ - mata\_kuliah\_id: int       │

│ - semester\_id: int          │

│ - total\_skor: int           │

│ - rata\_rata: float          │

│ - kritik: text              │

│ - saran: text               │

├─────────────────────────────┤

│ + hitungSkor()              │

│ + getKategori()             │

│ + cekUniqueVoting()         │

└──────────────┬──────────────┘

&#x20;              │

&#x20;              │ 1

&#x20;              │

&#x20;              │ N

&#x20;              ▼

┌─────────────────────────────┐          ┌─────────────────────────────┐

│       VotingDetail          │          │        Pertanyaan           │

├─────────────────────────────┤          ├─────────────────────────────┤

│ - id: int                   │◄─────────│ - id: int                   │

│ - voting\_id: int            │          │ - kategori: string          │

│ - pertanyaan\_id: int        │          │ - pertanyaan: text          │

│ - nilai: int                │          │ - urutan: int               │

├─────────────────────────────┤          │ - status: boolean           │

│ + getNilaiText()            │          ├─────────────────────────────┤

└─────────────────────────────┘          │ + getKategori()             │

&#x20;                                        └─────────────────────────────┘



┌─────────────────────────────┐          ┌─────────────────────────────┐

│           Dosen             │          │        MataKuliah           │

├─────────────────────────────┤          ├─────────────────────────────┤

│ - id: int                   │          │ - id: int                   │

│ - nidn: string              │          │ - kode: string              │

│ - nama: string              │          │ - nama: string              │

│ - program\_studi: string     │          │ - semester: string          │

│ - status\_dosen: string      │          │ - kelas: string             │

│ - status\_aktif: boolean     │          │ - dosen\_id: int             │

│ - foto: string              │          │ - rps: string               │

├─────────────────────────────┤          ├─────────────────────────────┤

│ + getTotalVoting()          │          │ + getDosenPengampu()        │

│ + getRataRata()             │          └──────────────┬──────────────┘

│ + getRanking()              │                         │

└──────────────┬──────────────┘                         │

&#x20;              │                                        │

&#x20;              │ 1                                      │

&#x20;              │                                        │

&#x20;              │ N                                      │

&#x20;              ▼                                        ▼

┌─────────────────────────────┐          ┌─────────────────────────────┐

│         Semester            │          │        ActivityLog          │

├─────────────────────────────┤          ├─────────────────────────────┤

│ - id: int                   │          │ - id: int                   │

│ - tahun\_ajaran: string      │          │ - user\_id: int              │

│ - semester: string          │          │ - aktivitas: string         │

│ - status: string            │          │ - deskripsi: text           │

├─────────────────────────────┤          │ - created\_at: datetime      │

│ + getSemesterAktif()        │          ├─────────────────────────────┤

└─────────────────────────────┘          │ + logActivity()             │

&#x20;                                        └─────────────────────────────┘



┌─────────────────────────────┐

│         Laporan             │

├─────────────────────────────┤

│ - filter: array             │

│ - data: array               │

├─────────────────────────────┤

│ + generatePDF()             │

│ + generateExcel()           │

│ + getFilterData()           │

└─────────────────────────────┘

```



\### Relasi Antar Class



| Class A | Class B | Relasi | Deskripsi |

|---------|---------|--------|-----------|

| User | Mahasiswa | 1 : 1 | Satu user memiliki satu data mahasiswa |

| Mahasiswa | Voting | 1 : N | Satu mahasiswa bisa banyak voting |

| Dosen | MataKuliah | 1 : N | Satu dosen mengajar banyak mata kuliah |

| MataKuliah | Voting | 1 : N | Satu mata kuliah memiliki banyak voting |

| Semester | Voting | 1 : N | Satu semester memiliki banyak voting |

| Voting | VotingDetail | 1 : N | Satu voting memiliki banyak detail |

| Pertanyaan | VotingDetail | 1 : N | Satu pertanyaan digunakan banyak detail |

| User | ActivityLog | 1 : N | Satu user memiliki banyak aktivitas |



\---



\## 6. ERD (ENTITY RELATIONSHIP DIAGRAM)



```

┌─────────────────────────────────────────────────────────────────────────────────────┐

│                                   ERD DIAGRAM                                      │

└─────────────────────────────────────────────────────────────────────────────────────┘



&#x20;                             ┌──────────────────────┐

&#x20;                             │        USERS         │

&#x20;                             ├──────────────────────┤

&#x20;                             │ PK id                │

&#x20;                             │    nama              │

&#x20;                             │    username          │

&#x20;                             │    email             │

&#x20;                             │    password          │

&#x20;                             │    role              │

&#x20;                             │    foto              │

&#x20;                             │    no\_hp             │

&#x20;                             │    created\_at        │

&#x20;                             │    updated\_at        │

&#x20;                             └──────────┬───────────┘

&#x20;                                        │ 1

&#x20;                                        │

&#x20;                                        │ 1

&#x20;                                        ▼

&#x20;                             ┌──────────────────────┐

&#x20;                             │     MAHASISWAS       │

&#x20;                             ├──────────────────────┤

&#x20;                             │ PK id                │

&#x20;                             │ FK user\_id           │──────┐

&#x20;                             │    nim               │      │

&#x20;                             │    program\_studi     │      │

&#x20;                             │    semester          │      │

&#x20;                             │    kelas             │      │

&#x20;                             │    hak\_voting        │      │

&#x20;                             └──────────┬───────────┘      │

&#x20;                                        │ 1                │

&#x20;                                        │                  │

&#x20;                                        │ N                │

&#x20;                                        ▼                  │

&#x20;                             ┌──────────────────────┐      │

&#x20;                             │       VOTINGS        │      │

&#x20;                             ├──────────────────────┤      │

&#x20;                             │ PK id                │      │

&#x20;                             │ FK mahasiswa\_id      │──────┘

&#x20;                             │ FK dosen\_id          │──────┐

&#x20;                             │ FK mata\_kuliah\_id    │──────┤

&#x20;                             │ FK semester\_id       │──────┤

&#x20;                             │    total\_skor        │      │

&#x20;                             │    rata\_rata         │      │

&#x20;                             │    kritik            │      │

&#x20;                             │    saran             │      │

&#x20;                             │    created\_at        │      │

&#x20;                             └──────────┬───────────┘      │

&#x20;                                        │ 1                │

&#x20;                                        │                  │

&#x20;                                        │ N                │

&#x20;                                        ▼                  │

&#x20;                             ┌──────────────────────┐      │

&#x20;                             │    VOTING\_DETAILS    │      │

&#x20;                             ├──────────────────────┤      │

&#x20;                             │ PK id                │      │

&#x20;                             │ FK voting\_id         │      │

&#x20;                             │ FK pertanyaan\_id     │      │

&#x20;                             │    nilai             │      │

&#x20;                             └──────────┬───────────┘      │

&#x20;                                        │                  │

&#x20;                                        │ N                │

&#x20;                                        │                  │

&#x20;                                        │ 1                │

&#x20;                                        ▼                  │

&#x20;                             ┌──────────────────────┐      │

&#x20;                             │     PERTANYAANS      │      │

&#x20;                             ├──────────────────────┤      │

&#x20;                             │ PK id                │      │

&#x20;                             │    kategori          │      │

&#x20;                             │    pertanyaan        │      │

&#x20;                             │    urutan            │      │

&#x20;                             │    status            │      │

&#x20;                             └──────────────────────┘      │

&#x20;                                                            │

&#x20;                             ┌──────────────────────┐      │

&#x20;                             │       DOSENS         │      │

&#x20;                             ├──────────────────────┤      │

&#x20;                             │ PK id                │      │

&#x20;                             │    nidn              │      │

&#x20;                             │    nama              │      │

&#x20;                             │    program\_studi     │      │

&#x20;                             │    status\_dosen      │      │

&#x20;                             │    status\_aktif      │      │

&#x20;                             │    foto              │      │

&#x20;                             └──────────┬───────────┘      │

&#x20;                                        │ 1                │

&#x20;                                        │                  │

&#x20;                                        │ N                │

&#x20;                                        ▼                  │

&#x20;                             ┌──────────────────────┐      │

&#x20;                             │    MATA\_KULIAHS      │      │

&#x20;                             ├──────────────────────┤      │

&#x20;                             │ PK id                │      │

&#x20;                             │ FK dosen\_id          │──────┘

&#x20;                             │    kode              │

&#x20;                             │    nama              │

&#x20;                             │    semester          │

&#x20;                             │    kelas             │

&#x20;                             │    rps               │

&#x20;                             └──────────────────────┘



&#x20;                             ┌──────────────────────┐

&#x20;                             │      SEMESTERS       │

&#x20;                             ├──────────────────────┤

&#x20;                             │ PK id                │

&#x20;                             │    tahun\_ajaran      │

&#x20;                             │    semester          │

&#x20;                             │    status            │

&#x20;                             └──────────────────────┘



&#x20;                             ┌──────────────────────┐

&#x20;                             │    ACTIVITY\_LOGS     │

&#x20;                             ├──────────────────────┤

&#x20;                             │ PK id                │

&#x20;                             │ FK user\_id           │

&#x20;                             │    aktivitas         │

&#x20;                             │    deskripsi         │

&#x20;                             │    created\_at        │

&#x20;                             └──────────────────────┘



═══════════════════════════════════════════════════════════════════════════════════════



RELASI:



USERS         → MAHASISWAS   : 1 : 1 (One to One)

MAHASISWAS    → VOTINGS      : 1 : N (One to Many)

DOSENS        → MATA\_KULIAHS : 1 : N (One to Many)

MATA\_KULIAHS  → VOTINGS      : 1 : N (One to Many)

SEMESTERS     → VOTINGS      : 1 : N (One to Many)

VOTINGS       → VOTING\_DETAILS : 1 : N (One to Many)

PERTANYAANS   → VOTING\_DETAILS : 1 : N (One to Many)

USERS         → ACTIVITY\_LOGS  : 1 : N (One to Many)



UNIQUE CONSTRAINT:

VOTINGS (mahasiswa\_id + mata\_kuliah\_id + semester\_id) → UNIQUE

```



\### Penjelasan ERD



| Tabel | Primary Key | Foreign Key | Keterangan |

|-------|-------------|-------------|------------|

| \*\*users\*\* | id | - | Menyimpan semua akun pengguna (Admin, Pimpinan, Mahasiswa) |

| \*\*mahasiswas\*\* | id | user\_id | Data akademik mahasiswa (NIM, prodi, semester, kelas) |

| \*\*dosens\*\* | id | - | Data dosen (NIDN, nama, prodi, status) |

| \*\*mata\_kuliahs\*\* | id | dosen\_id | Data mata kuliah dengan dosen pengampu |

| \*\*semesters\*\* | id | - | Master semester (tahun ajaran, status) |

| \*\*pertanyaans\*\* | id | - | Master pertanyaan kuisioner (9 pertanyaan) |

| \*\*votings\*\* | id | mahasiswa\_id, dosen\_id, mata\_kuliah\_id, semester\_id | Header voting (total skor, rata-rata, kritik, saran) |

| \*\*voting\_details\*\* | id | voting\_id, pertanyaan\_id | Detail jawaban per pertanyaan |

| \*\*activity\_logs\*\* | id | user\_id | Catatan aktivitas pengguna |



\---



\## 7. STRUKTUR DATABASE



## STRUKTUR DATABASE (REVISI)

### A. Tabel: users

| Field | Type | Null | Key | Default | Keterangan |
|-------|------|------|-----|---------|------------|
| id | BIGINT UNSIGNED | NO | PRI | AUTO_INCREMENT | Primary Key |
| nama | VARCHAR(100) | NO | - | - | Nama lengkap |
| username | VARCHAR(50) | NO | UNI | - | Username login |
| email | VARCHAR(100) | NO | UNI | - | Email |
| password | VARCHAR(255) | NO | - | - | Password terenkripsi |
| role | ENUM('admin','pimpinan','mahasiswa') | NO | - | 'mahasiswa' | Role pengguna |
| foto | VARCHAR(255) | YES | - | NULL | Path foto profil |
| no_hp | VARCHAR(20) | YES | - | NULL | Nomor HP |
| created_at | TIMESTAMP | YES | - | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | - | NULL | Waktu diubah |

---

### B. Tabel: mahasiswas

| Field | Type | Null | Key | Default | Keterangan |
|-------|------|------|-----|---------|------------|
| id | BIGINT UNSIGNED | NO | PRI | AUTO_INCREMENT | Primary Key |
| user_id | BIGINT UNSIGNED | NO | FK | - | Foreign Key ke users.id |
| nim | VARCHAR(20) | NO | UNI | - | NIM |
| nama | VARCHAR(100) | NO | - | - | Nama lengkap |
| program_studi | VARCHAR(50) | NO | - | - | Program Studi |
| semester | INT | NO | - | 1 | Semester saat ini (1-14) |
| kelas | VARCHAR(10) | YES | - | NULL | Kelas |
| status_voting | ENUM('Belum','Sudah') | NO | - | 'Belum' | Status voting mahasiswa |
| created_at | TIMESTAMP | YES | - | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | - | NULL | Waktu diubah |

---

### C. Tabel: dosens

| Field | Type | Null | Key | Default | Keterangan |
|-------|------|------|-----|---------|------------|
| id | BIGINT UNSIGNED | NO | PRI | AUTO_INCREMENT | Primary Key |
| nidn | VARCHAR(20) | NO | UNI | - | NIDN/NIP |
| nama | VARCHAR(100) | NO | - | - | Nama lengkap |
| program_studi | VARCHAR(50) | NO | - | - | Program Studi |
| status_dosen | ENUM('PNS','Yayasan','Luar Biasa') | NO | - | 'Yayasan' | Status dosen |
| created_at | TIMESTAMP | YES | - | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | - | NULL | Waktu diubah |

---

### D. Tabel: mata_kuliahs

| Field | Type | Null | Key | Default | Keterangan |
|-------|------|------|-----|---------|------------|
| id | BIGINT UNSIGNED | NO | PRI | AUTO_INCREMENT | Primary Key |
| kode | VARCHAR(20) | NO | UNI | - | Kode MK |
| nama | VARCHAR(100) | NO | - | - | Nama mata kuliah |
| dosen_id | BIGINT UNSIGNED | NO | FK | - | Foreign Key ke dosens.id |
| kelas | VARCHAR(10) | YES | - | NULL | Kelas |
| semester | VARCHAR(10) | NO | - | - | Semester mengajar (Ganjil/Genap) |
| created_at | TIMESTAMP | YES | - | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | - | NULL | Waktu diubah |

---

### E. Tabel: semesters

| Field | Type | Null | Key | Default | Keterangan |
|-------|------|------|-----|---------|------------|
| id | BIGINT UNSIGNED | NO | PRI | AUTO_INCREMENT | Primary Key |
| tahun_ajaran | VARCHAR(20) | NO | - | - | Contoh: 2024/2025 |
| semester | ENUM('Ganjil','Genap') | NO | - | 'Ganjil' | Semester |
| status | ENUM('Aktif','Tidak Aktif') | NO | - | 'Tidak Aktif' | Status semester |
| created_at | TIMESTAMP | YES | - | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | - | NULL | Waktu diubah |

---

### F. Tabel: pertanyaans

| Field | Type | Null | Key | Default | Keterangan |
|-------|------|------|-----|---------|------------|
| id | BIGINT UNSIGNED | NO | PRI | AUTO_INCREMENT | Primary Key |
| kategori | VARCHAR(50) | NO | - | - | Kategori pertanyaan |
| pertanyaan | TEXT | NO | - | - | Isi pertanyaan |
| urutan | INT | NO | - | 1 | Urutan tampil |
| status | BOOLEAN | NO | - | TRUE | TRUE = aktif, FALSE = tidak aktif |
| created_at | TIMESTAMP | YES | - | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | YES | - | NULL | Waktu diubah |

**Data Awal Pertanyaan:**

| No | Kategori | Pertanyaan |
|----|----------|------------|
| 1 | Penguasaan Materi | Apakah dosen menguasai materi perkuliahan dengan baik? |
| 2 | Cara Mengajar | Apakah dosen menjelaskan materi dengan jelas dan mudah dipahami? |
| 3 | Kedisiplinan | Apakah dosen hadir sesuai jadwal perkuliahan? |
| 4 | Komunikasi | Apakah dosen mampu berkomunikasi dengan baik kepada mahasiswa? |
| 5 | Ketepatan Waktu | Apakah dosen memulai dan mengakhiri perkuliahan tepat waktu? |
| 6 | Objektivitas | Apakah dosen memberikan penilaian secara objektif? |
| 7 | Tugas | Apakah tugas yang diberikan sesuai dengan materi perkuliahan? |
| 8 | Suasana Belajar | Apakah dosen menciptakan suasana belajar yang nyaman? |
| 9 | Bimbingan | Apakah dosen memberikan bimbingan dengan baik? |

---

### G. Tabel: votings

| Field | Type | Null | Key | Default | Keterangan |
|-------|------|------|-----|---------|------------|
| id | BIGINT UNSIGNED | NO | PRI | AUTO_INCREMENT | Primary Key |
| mahasiswa_id | BIGINT UNSIGNED | NO | FK | - | Foreign Key ke mahasiswas.id |
| dosen_id | BIGINT UNSIGNED | NO | FK | - | Foreign Key ke dosens.id |
| mata_kuliah_id | BIGINT UNSIGNED | NO | FK | - | Foreign Key ke mata_kuliahs.id |
| semester_id | BIGINT UNSIGNED | NO | FK | - | Foreign Key ke semesters.id |
| total_skor | INT | NO | - | 0 | Total nilai semua pertanyaan |
| rata_rata | DECIMAL(3,2) | NO | - | 0.00 | Rata-rata nilai |
| kritik | TEXT | YES | - | NULL | Kritik |
| saran | TEXT | YES | - | NULL | Saran |
| created_at | TIMESTAMP | YES | - | NULL | Waktu dibuat |

**UNIQUE CONSTRAINT:** (mahasiswa_id, mata_kuliah_id, semester_id)

---

### H. Tabel: voting_details

| Field | Type | Null | Key | Default | Keterangan |
|-------|------|------|-----|---------|------------|
| id | BIGINT UNSIGNED | NO | PRI | AUTO_INCREMENT | Primary Key |
| voting_id | BIGINT UNSIGNED | NO | FK | - | Foreign Key ke votings.id |
| pertanyaan_id | BIGINT UNSIGNED | NO | FK | - | Foreign Key ke pertanyaans.id |
| nilai | INT | NO | - | 0 | Nilai 1-5 |
| created_at | TIMESTAMP | YES | - | NULL | Waktu dibuat |

---

### I. Tabel: activity_logs

| Field | Type | Null | Key | Default | Keterangan |
|-------|------|------|-----|---------|------------|
| id | BIGINT UNSIGNED | NO | PRI | AUTO_INCREMENT | Primary Key |
| user_id | BIGINT UNSIGNED | NO | FK | - | Foreign Key ke users.id |
| aktivitas | VARCHAR(50) | NO | - | - | Jenis aktivitas |
| deskripsi | TEXT | NO | - | - | Deskripsi detail |
| created_at | TIMESTAMP | YES | - | NULL | Waktu aktivitas |

---

## RINGKASAN PERUBAHAN

| No | Perubahan | Penjelasan |
|----|-----------|------------|
| 1 | **hak_voting → status_voting** | Pada tabel mahasiswas, ubah field `hak_voting` menjadi `status_voting` dengan ENUM('Belum','Sudah') |
| 2 | **Hapus status_aktif** | Pada tabel dosens, hapus field `status_aktif` |
| 3 | **Semester mengajar** | Pada tabel mata_kuliahs, tambahkan field `semester` untuk menyimpan semester mengajar (Ganjil/Genap) |
| 4 | **Hapus rps** | Pada tabel mata_kuliahs, hapus field `rps` |

---

## RELASI ANTAR TABEL

```
users (id)
   │
   │ 1
   │
   │ 1
   ▼
mahasiswas (user_id) ────┐
   │                     │
   │ 1                   │
   │                     │
   │ N                   │
   ▼                     │
votings (mahasiswa_id) ──┘
   │
   │ 1
   │
   │ N
   ▼
voting_details (voting_id)

dosens (id) ────┐
   │            │
   │ 1          │
   │            │
   │ N          │
   ▼            │
mata_kuliahs (dosen_id) ──┤
   │                      │
   │ 1                    │
   │                      │
   │ N                    │
   ▼                      │
votings (mata_kuliah_id) ─┘

semesters (id) ────┐
   │               │
   │ 1             │
   │               │
   │ N             │
   ▼               │
votings (semester_id) ────┘

pertanyaans (id) ────┐
   │                 │
   │ 1               │
   │                 │
   │ N               │
   ▼                 │
voting_details (pertanyaan_id) ────┘

users (id) ────┐
   │           │
   │ 1         │
   │           │
   │ N         │
   ▼           │
activity_logs (user_id) ────┘
```

---

## CATATAN

1. **Status Voting Mahasiswa**: Field `status_voting` pada tabel mahasiswas akan otomatis berubah menjadi 'Sudah' setelah mahasiswa melakukan voting, dan akan tetap 'Belum' jika belum.

2. **Semester Mengajar**: Berada di tabel mata_kuliahs, bukan di tabel dosens. Satu dosen dapat mengajar di beberapa mata kuliah dengan semester yang berbeda.

3. **Status Dosen**: Tetap ada di tabel dosens dengan pilihan PNS, Yayasan, atau Luar Biasa.

4. **Tidak Ada RPS**: Sesuai permintaan, field rps dihapus dari tabel mata_kuliahs.


\


\## 8. STRUKTUR MENU



\### A. Menu Admin



```

📊 Dashboard

&#x20;  ├── Total Dosen

&#x20;  ├── Total Mahasiswa

&#x20;  ├── Total Mata Kuliah

&#x20;  ├── Total Voting

&#x20;  └── Grafik Voting



📋 Master Data

&#x20;  ├── 📌 Data Dosen

&#x20;  │   ├── Lihat Data

&#x20;  │   ├── Tambah Dosen

&#x20;  │   ├── Edit Dosen

&#x20;  │   └── Hapus Dosen

&#x20;  │

&#x20;  ├── 📌 Data Mahasiswa

&#x20;  │   ├── Lihat Data

&#x20;  │   ├── Tambah Mahasiswa

&#x20;  │   ├── Edit Mahasiswa

&#x20;  │   └── Hapus Mahasiswa

&#x20;  │

&#x20;  ├── 📌 Data Mata Kuliah

&#x20;  │   ├── Lihat Data

&#x20;  │   ├── Tambah Mata Kuliah

&#x20;  │   ├── Edit Mata Kuliah

&#x20;  │   └── Hapus Mata Kuliah

&#x20;  │

&#x20;  ├── 📌 Data Semester

&#x20;  │   ├── Lihat Data

&#x20;  │   ├── Tambah Semester

&#x20;  │   ├── Edit Semester

&#x20;  │   └── Hapus Semester

&#x20;  │

&#x20;  └── 📌 Data Pertanyaan

&#x20;      ├── Lihat Data

&#x20;      ├── Tambah Pertanyaan

&#x20;      ├── Edit Pertanyaan

&#x20;      └── Hapus Pertanyaan



📝 Voting

&#x20;  ├── Data Voting

&#x20;  └── Detail Voting



📄 Laporan

&#x20;  ├── Laporan Dosen

&#x20;  ├── Laporan Mata Kuliah

&#x20;  ├── Laporan Program Studi

&#x20;  ├── Export PDF

&#x20;  └── Export Excel



📊 Grafik

&#x20;  ├── Kepuasan Mahasiswa

&#x20;  ├── Ranking Dosen

&#x20;  └── Voting per Prodi



📋 Activity Log

&#x20;  └── Lihat Semua Aktivitas



💾 Backup

&#x20;  ├── Backup Database

&#x20;  ├── Restore Database

&#x20;  └── Download Backup



👤 Profil

&#x20;  ├── Edit Profil

&#x20;  └── Ganti Password



🚪 Logout

```



\### B. Menu Mahasiswa



```

📊 Dashboard

&#x20;  ├── Nama Mahasiswa

&#x20;  ├── NIM

&#x20;  ├── Program Studi

&#x20;  ├── Semester

&#x20;  └── Status Voting



👨‍🏫 Daftar Dosen

&#x20;  ├── Dosen Semester Aktif

&#x20;  └── Status Voting per Dosen



📝 Voting

&#x20;  ├── Form Kuisioner

&#x20;  ├── Konfirmasi Voting

&#x20;  └── Hasil Voting



📋 Riwayat Voting

&#x20;  ├── Tanggal Voting

&#x20;  ├── Dosen

&#x20;  ├── Mata Kuliah

&#x20;  └── Status



🏆 Hasil Penilaian Dosen

&#x20;  ├── Nama Dosen

&#x20;  ├── Nilai Rata-rata

&#x20;  └── Kategori



📊 Ranking Dosen

&#x20;  ├── Peringkat

&#x20;  ├── Nama Dosen

&#x20;  └── Nilai



👤 Profil

&#x20;  ├── Edit Profil

&#x20;  └── Ganti Password



🚪 Logout

```



\### C. Menu Pimpinan



```

📊 Dashboard

&#x20;  ├── Total Voting

&#x20;  ├── Rata-rata Kepuasan

&#x20;  ├── Dosen Terbaik

&#x20;  └── Dosen Perlu Pembinaan



📊 Grafik

&#x20;  ├── Kepuasan Mahasiswa

&#x20;  ├── Ranking Dosen

&#x20;  └── Voting per Prodi



🏆 Ranking Dosen

&#x20;  ├── Peringkat

&#x20;  ├── Nama Dosen

&#x20;  └── Nilai



📄 Laporan

&#x20;  ├── Laporan Dosen

&#x20;  ├── Laporan Mata Kuliah

&#x20;  ├── Laporan Program Studi

&#x20;  ├── Export PDF

&#x20;  └── Export Excel



👤 Profil

&#x20;  ├── Edit Profil

&#x20;  └── Ganti Password



🚪 Logout

```



\---



\## 9. DESAIN UI/UX



\### A. Warna yang Digunakan


Palet Warna Aplikasi — Voting Kinerja Dosen ENBI Nusantara
🔷 Navbar & Header
Komponen	Elemen	Warna	Kode Warna
Navbar	Background	Navy Gelap	#1a2744
Navbar	Teks Institusi	Putih	#ffffff
Navbar	Sub-teks (PT. Lentera)	Biru Muda	#bfdbfe (blue-200)
Navbar	Progress Bar Track	Putih 10%	rgba(255,255,255,0.10)
Navbar	Progress Bar Fill	Gradien Gold	#c9a227 → #f0d060
Navbar	Teks Progress %	Gold	#c9a227
Navbar	Tombol Lihat Hasil	Background Gold	#c9a227
Navbar	Tombol Lihat Hasil	Teks	#1a2744

🔐 Login Page
Komponen	Elemen	Warna	Kode Warna
Login	Background Halaman	Gradien Navy	#1a2744 → #2e4a8a → #1a2744
Login	Ornamen Lingkaran	Gold 10%	rgba(201,162,39,0.10)
Login	Ornamen Pola Grid	Gold 5%	rgba(201,162,39,0.05)
Login	Logo Border	Gold	#c9a227
Login	Logo Background	Gold 15%	rgba(201,162,39,0.15)
Login	Logo Ikon	Gold	#c9a227
Login	Badge Semester	Background	rgba(201,162,39,0.20)
Login	Badge Semester	Teks	#e8c560
Login	Card Form	Background	#ffffff
Login	Label Input	Teks	#1a2744
Login	Input Field	Background	#eef0f5
Login	Input Field	Border Normal	rgba(26,39,68,0.12)
Login	Input Field	Border Fokus	#c9a227
Login	Tombol Login	Background	Gradien #1a2744 → #2e4a8a
Login	Tombol Login	Teks	#ffffff
Login	Pesan Error	Background	rgba(192,57,43,0.08)
Login	Pesan Error	Teks	#c0392b

🃏 Card Dosen
Komponen	Elemen	Warna	Kode Warna
Card	Background	Putih	#ffffff
Card	Border	Abu Tipis	rgba(26,39,68,0.12)
Card	Overlay Foto	Gradien Navy	rgba(26,39,68,0.7) → transparan
Card	Badge Selesai	Background	#10b981 (emerald-500)
Card	Badge Selesai	Teks	#ffffff
Card	Badge Prodi	Background	rgba(26,39,68,0.10)
Card	Badge Prodi	Teks	#1a2744
Card	Teks Nama	Warna	#1a2744
Card	Teks NIDN / Sub	Warna	#6b7280
Card	Link "Mulai Penilaian"	Default	#1a2744
Card	Link "Mulai Penilaian"	Hover	#c9a227
Card	Card Sudah Dinilai	Opacity	70%

⭐ Form Penilaian — Bintang Rating
Komponen	Elemen	Warna	Kode Warna
Bintang	Nilai 1 — Sangat Kurang	Merah	#c0392b
Bintang	Nilai 2 — Kurang	Oranye	#e67e22
Bintang	Nilai 3 — Cukup	Kuning	#f39c12
Bintang	Nilai 4 — Baik	Hijau	#27ae60
Bintang	Nilai 5 — Sangat Baik	Navy	#1a2744
Bintang	Belum Dipilih	Abu	#cbd5e1
Rata-rata Skor	Angka	Gold	#c9a227
Progress Bar	Fill	Gradien	#1a2744 → #c9a227

📊 Dashboard Hasil
Komponen	Elemen	Warna	Kode Warna
Peringkat #1	Badge	Gold	#c9a227
Peringkat #2	Badge	Silver	#9ca3af
Peringkat #3	Badge	Bronze	#cd7f32
Peringkat #4+	Badge	Abu Muda	#eef0f5
Radar Chart	Garis Dosen 1	Navy	#1a2744
Radar Chart	Garis Dosen 2	Gold	#c9a227
Radar Chart	Grid	Navy 10%	rgba(26,39,68,0.10)
Stat Card	Latar	Putih	#ffffff
Tab Aktif	Background	Navy	#1a2744
Tab Aktif	Teks	Putih	#ffffff
Tab Nonaktif	Teks	Abu	#6b7280

🌐 Global / Halaman
Komponen	Elemen	Warna	Kode Warna
Halaman	Background Utama	Krem Hangat	#f5f3ef
Banner Info	Background	Gold 8%	rgba(201,162,39,0.08)
Banner Info	Border	Gold 25%	rgba(201,162,39,0.25)
Banner Sukses	Background	Emerald Muda	#ecfdf5
Banner Sukses	Border	Emerald	#a7f3d0
Banner Sukses	Teks	Emerald Gelap	#065f46
Teks Body	Warna Utama	Navy	#1a2744
Teks Sekunder	Warna Sub	Abu	#6b7280
Border Umum	Garis Tipis	Navy 12%	rgba(26,39,68,0.12)
Focus Ring	Outline	Gold	#c9a227

Ringkasan 3 warna utama:

Nama	Kode	Peran
Navy	#1a2744	Primary — navbar, tombol, teks utama
Gold	#c9a227	Accent — highlight, rating, badge
Krem	#f5f3ef	Background halaman



\### B. Layout Dashboard



```

┌──────────────────────────────────────────────────────────────────────────┐

│ \[LOGO]  Aplikasi Voting Dosen          \[Search]  \[Notif]  \[Profile]  │

├─────────┬────────────────────────────────────────────────────────────────┤

│         │                                                                │

│ 📊      │  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐        │

│ Dashboard│  │ Total    │  │ Total    │  │ Total    │  │ Total    │        │

│         │  │ Dosen    │  │ Mhs      │  │ MK       │  │ Voting   │        │

│         │  │   52     │  │   820    │  │   68     │  │   790    │        │

│         │  └─────────┘  └─────────┘  └─────────┘  └─────────┘        │

│ 📋      │                                                                │

│ Master   │  ┌─────────────────────────────────┐  ┌───────────────────┐  │

│   ├ Dosen│  │     Grafik Voting              │  │   Aktivitas       │  │

│   ├ Mhs  │  │   █████████████████            │  │   • Admin tambah  │  │

│   ├ MK   │  │   ██████████                   │  │   • Mhs voting    │  │

│   ├ Sem  │  │   ████████████████████          │  │   • Rekap nilai   │  │

│   └ Pert │  └─────────────────────────────────┘  └───────────────────┘  │

│         │                                                                │

│ 📝      │                                                                │

│ Voting   │                                                                │

│         │                                                                │

│ 📄      │                                                                │

│ Laporan │                                                                │

│         │                                                                │

│ 📊      │                                                                │

│ Grafik  │                                                                │

│         │                                                                │

│ 📋      │                                                                │

│ Log     │                                                                │

│         │                                                                │

│ 💾      │                                                                │

│ Backup  │                                                                │

│         │                                                                │

│ 👤      │                                                                │

│ Profil  │                                                                │

│         │                                                                │

│ 🚪      │                                                                │

│ Logout  │                                                                │

├─────────┴────────────────────────────────────────────────────────────────┤

│ © 2024 PT Lentera Edukasi ENBI Nusantara                                │

└──────────────────────────────────────────────────────────────────────────┘

```



\### C. Desain Form Voting



```

┌──────────────────────────────────────────────────────────────────────────┐

│                        FORM VOTING DOSEN                                │

├──────────────────────────────────────────────────────────────────────────┤

│                                                                          │

│  Mata Kuliah  : \[Pemrograman Web        ▼]                             │

│  Dosen        : \[Dr. Ahmad             ▼]                             │

│                                                                          │

│  ┌──────────────────────────────────────────────────────────────────┐   │

│  │  NO  │  PERTANYAAN                        │  1 │  2 │  3 │  4 │  5 │   │

│  ├──────┼───────────────────────────────────┼────┼────┼────┼────┼────┤   │

│  │  1   │  Penguasaan Materi                │ ○  │ ○  │ ○  │ ●  │ ○  │   │

│  │  2   │  Cara Mengajar                    │ ○  │ ○  │ ○  │ ●  │ ○  │   │

│  │  3   │  Kedisiplinan                     │ ○  │ ○  │ ○  │ ○  │ ●  │   │

│  │  4   │  Komunikasi                       │ ○  │ ○  │ ○  │ ●  │ ○  │   │

│  │  5   │  Ketepatan Waktu                  │ ○  │ ○  │ ○  │ ○  │ ●  │   │

│  │  6   │  Objektivitas                     │ ○  │ ○  │ ○  │ ●  │ ○  │   │

│  │  7   │  Tugas                            │ ○  │ ○  │ ○  │ ●  │ ○  │   │

│  │  8   │  Suasana Belajar                  │ ○  │ ○  │ ○  │ ○  │ ●  │   │

│  │  9   │  Bimbingan                        │ ○  │ ○  │ ○  │ ●  │ ○  │   │

│  └──────────────────────────────────────────────────────────────────┘   │

│                                                                          │

│  Kritik :                                                               │

│  \[\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_]          │

│                                                                          │

│  Saran :                                                                │

│  \[\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_]          │

│                                                                          │

│                    \[ KIRIM VOTING ]                                     │

│                                                                          │

└──────────────────────────────────────────────────────────────────────────┘

```



\### D. Desain Hasil Voting



```

┌──────────────────────────────────────────────────────────────────────────┐

│                      HASIL VOTING                                       │

├──────────────────────────────────────────────────────────────────────────┤

│                                                                          │

│              ✅ VOTING BERHASIL                                         │

│                                                                          │

│  ┌──────────────────────────────────────────────────────────────────┐   │

│  │                                                                  │   │

│  │              📊 TOTAL SKOR                                       │   │

│  │                  40 / 50                                         │   │

│  │                                                                  │   │

│  │              📈 RATA-RATA                                        │   │

│  │                  4.0                                             │   │

│  │                                                                  │   │

│  │              🏆 KATEGORI                                        │   │

│  │                  MEMUASKAN                                       │   │

│  │                                                                  │   │

│  └──────────────────────────────────────────────────────────────────┘   │

│                                                                          │

│  Dosen : Dr. Ahmad                                                      │

│  Mata Kuliah : Pemrograman Web                                          │

│  Semester : Genap 2024/2025                                             │

│                                                                          │

│                    \[ KEMBALI ]                                          │

│                                                                          │

└──────────────────────────────────────────────────────────────────────────┘

```



\### E. Desain Ranking Dosen



```

┌──────────────────────────────────────────────────────────────────────────┐

│                         RANKING DOSEN                                   │

├──────────────────────────────────────────────────────────────────────────┤

│                                                                          │

│  Semester : \[Genap 2024/2025  ▼]                                      │

│                                                                          │

│  ┌────┬──────────────────────┬──────────┬──────────┬──────────────┐   │

│  │ #  │  Nama Dosen          │  Nilai   │  Voting  │  Kategori    │   │

│  ├────┼──────────────────────┼──────────┼──────────┼──────────────┤   │

│  │ 🥇 │  Dr. Ahmad           │  4.82    │   150    │  Sangat Baik │   │

│  │ 🥈 │  Dr. Sinta           │  4.75    │   142    │  Sangat Baik │   │

│  │ 🥉 │  Dr. Rudi            │  4.61    │   138    │  Sangat Baik │   │

│  │  4 │  Dr. Lina            │  4.52    │   130    │  Sangat Baik │   │

│  │  5 │  Dr. Budi            │  4.30    │   125    │  Baik        │   │

│  │  6 │  Dr. Citra           │  4.15    │   118    │  Baik        │   │

│  │  7 │  Dr. Dedi            │  3.85    │   110    │  Cukup       │   │

│  └────┴──────────────────────┴──────────┴──────────┴──────────────┘   │

│                                                                          │

│                    \[ EXPORT PDF ]  \[ EXPORT EXCEL ]                    │

│                                                                          │

└──────────────────────────────────────────────────────────────────────────┘

```



\### F. Desain Card Data Master



```

┌──────────────────────────────────────────────────────────────────────────┐

│                         DATA DOSEN                                      │

├──────────────────────────────────────────────────────────────────────────┤

│                                                                          │

│  Cari : \[\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_]  \[Cari]  \[+ Tambah Dosen]          │

│                                                                          │

│  ┌────────────────────────────────────────────────────────────────────┐ │

│  │ No │ NIDN    │ Nama       │ Prodi      │ Status │ Aksi            │ │

│  ├────┼─────────┼────────────┼────────────┼────────┼─────────────────┤ │

│  │ 1  │ 123456  │ Dr. Ahmad  │ Informatika│ Aktif  │ 👁 ✏️ 🗑️ │ │

│  │ 2  │ 234567  │ Dr. Sinta  │ Sistem Info│ Aktif  │ 👁 ✏️ 🗑️ │ │

│  │ 3  │ 345678  │ Dr. Rudi   │ Informatika│ Aktif  │ 👁 ✏️ 🗑️ │ │

│  │ 4  │ 456789  │ Dr. Lina   │ Manajemen  │ Nonaktif│ 👁 ✏️ 🗑️ │ │

│  └────────────────────────────────────────────────────────────────────┘ │

│                                                                          │

│  Showing 1-4 of 52 data                          \[1] \[2] \[3] ... \[13] │

│                                                                          │

└──────────────────────────────────────────────────────────────────────────┘

```



\---



\## 10. PEMBAGIAN TUGAS TIM



\### A. Identitas Tim



| No | Nama | Role |

|----|------|------|

| 1 | \*\*Abidzar Al Ghiffari\*\* | Ketua Tim |

| 2 | \*\*Mohammad Raffi Dwika\*\* | Anggota |

| 3 | \*\*Rindiani Fatika Sari\*\* | Anggota |

| 4 | \*\*Annisa Dwi Putri\*\* | Anggota |

| 5 | \*\*Hafizah Faraz\*\* | Anggota |



\### B. Pembagian Tugas



| No | Nama | Tugas |

|----|------|-------|

| 1 | \*\*Abidzar Al Ghiffari\*\* | Analisis kebutuhan, desain database (ERD), autentikasi multi-user, dashboard admin, integrasi seluruh modul, deployment, dokumentasi akhir |

| 2 | \*\*Mohammad Raffi Dwika\*\* | CRUD Master Dosen, CRUD Mata Kuliah, CRUD Semester, pencarian dan filter data, upload RPS |

| 3 | \*\*Rindiani Fatika Sari\*\* | CRUD Mahasiswa, validasi hak voting, upload data (Excel/PDF), manajemen akun pengguna, upload foto mahasiswa |

| 4 | \*\*Annisa Dwi Putri\*\* | Modul Voting Mahasiswa, validasi satu kali voting, sistem skor otomatis, kritik \& saran, antarmuka mahasiswa |

| 5 | \*\*Hafizah Faraz\*\* | Dashboard Pimpinan, laporan PDF/Excel, grafik evaluasi, ranking dosen, riwayat aktivitas, backup database, manual book dan presentasi |



\### C. Detail Tugas per Modul



| Modul | Abidzar | Raffi | Rindiani | Annisa | Hafizah |

|-------|---------|-------|----------|--------|---------|

| Analisis \& Perencanaan | ✅ | - | - | - | - |

| Database \& ERD | ✅ | - | - | - | - |

| Autentikasi Login | ✅ | - | - | - | - |

| Middleware \& Route | ✅ | - | - | - | - |

| Dashboard Admin | ✅ | - | - | - | - |

| CRUD Dosen | - | ✅ | - | - | - |

| CRUD Mata Kuliah | - | ✅ | - | - | - |

| CRUD Semester | - | ✅ | - | - | - |

| Upload RPS | - | ✅ | - | - | - |

| CRUD Mahasiswa | - | - | ✅ | - | - |

| Validasi Hak Voting | - | - | ✅ | - | - |

| Import/Export Data | - | - | ✅ | - | - |

| Upload Foto Mahasiswa | - | - | ✅ | - | - |

| Form Voting | - | - | - | ✅ | - |

| Perhitungan Skor | - | - | - | ✅ | - |

| Kritik \& Saran | - | - | - | ✅ | - |

| Dashboard Mahasiswa | - | - | - | ✅ | - |

| Dashboard Pimpinan | - | - | - | - | ✅ |

| Grafik \& Ranking | - | - | - | - | ✅ |

| Laporan PDF/Excel | - | - | - | - | ✅ |

| Activity Log | - | - | - | - | ✅ |

| Backup Database | - | - | - | - | ✅ |

| Upload Foto Dosen | - | ✅ | - | - | - |

| Manual Book | - | - | - | - | ✅ |

| Presentasi | ✅ | - | - | - | ✅ |

| Deployment | ✅ | - | - | - | - |

| Dokumentasi Sistem | ✅ | - | - | - | - |



\---



\## 11. TIMELINE PENGERJAAN



\### Minggu 1: Perencanaan \& Database



| Hari | Kegiatan | PIC |

|------|----------|-----|

| Senin | Analisis kebutuhan \& pembuatan ERD | Abidzar |

| Selasa | Desain database \& miFgration | Abidzar |

| Rabu | Membuat seeder \& model | Abidzar |

| Kamis | Setup Laravel \& konfigurasi | Abidzar |

| Jumat | Testing database \& relasi | Abidzar |



\### Minggu 2: Autentikasi \& Routing



| Hari | Kegiatan | PIC |

|------|----------|-----|

| Senin | Autentikasi multi-user | Abidzar |

| Selasa | Middleware role | Abidzar |

| Rabu | Routing \& layout | Abidzar |

| Kamis | Login page \& dashboard basic | Abidzar |

| Jumat | Testing autentikasi | Abidzar |



\### Minggu 3: CRUD Admin



| Hari | Kegiatan | PIC |

|------|----------|-----|

| Senin | CRUD Dosen | Raffi |

| Selasa | CRUD Mata Kuliah | Raffi |

| Rabu | CRUD Semester | Raffi |

| Kamis | CRUD Mahasiswa | Rindiani |

| Jumat | CRUD Pertanyaan | Rindiani |



\### Minggu 4: Modul Voting \& Skor



| Hari | Kegiatan | PIC |

|------|----------|-----|

| Senin | Tampilan daftar dosen | Annisa |

| Selasa | Form voting \& kuisioner | Annisa |

| Rabu | Validasi satu kali voting | Annisa |

| Kamis | Perhitungan skor otomatis | Annisa |

| Jumat | Kritik \& saran | Annisa |



\### Minggu 5: Dashboard \& Grafik



| Hari | Kegiatan | PIC |

|------|----------|-----|

| Senin | Dashboard Admin | Abidzar |

| Selasa | Dashboard Mahasiswa | Annisa |

| Rabu | Dashboard Pimpinan | Hafizah |

| Kamis | Grafik Chart.js | Hafizah |

| Jumat | Ranking Dosen | Hafizah |



\### Minggu 6: Laporan \& Export



| Hari | Kegiatan | PIC |

|------|----------|-----|

| Senin | Laporan PDF | Hafizah |

| Selasa | Laporan Excel | Hafizah |

| Rabu | Filter laporan | Hafizah |

| Kamis | Activity Log | Hafizah |

| Jumat | Backup Database | Hafizah |



\### Minggu 7: Upload \& Finishing



| Hari | Kegiatan | PIC |

|------|----------|-----|

| Senin | Upload foto dosen | Raffi |

| Selasa | Upload foto mahasiswa | Rindiani |

| Rabu | Upload RPS mata kuliah | Raffi |

| Kamis | Import/Export Excel | Rindiani |

| Jumat | Profil \& ganti password | Semua |



\### Minggu 8: Testing \& Dokumentasi



| Hari | Kegiatan | PIC |

|------|----------|-----|

| Senin | Testing seluruh fitur | Semua |

| Selasa | Bug fixing | Semua |

| Rabu | Manual book | Hafizah |

| Kamis | Dokumentasi sistem (diagram) | Abidzar |

| Jumat | Presentasi \& deployment | Abidzar \& Hafizah |



\---



\## 12. TEKNOLOGI YANG DIGUNAKAN



\### A. Backend



| Teknologi | Versi | Kegunaan |

|-----------|-------|----------|

| PHP | 8.2+ | Bahasa pemrograman |

| Laravel | 13.x | Framework |

| MySQL | 8.0+ | Database |

| Composer | 2.x | Dependency manager |



\### B. Frontend



| Teknologi | Versi | Kegunaan |

|-----------|-------|----------|

| Tailwind CSS | 3.x | CSS Framework |

| Alpine.js | 3.x | JavaScript untuk interaksi |

| Chart.js | 4.x | Grafik \& chart |

| Heroicons | 2.x | Ikon |



\### C. Library Tambahan



| Library | Kegunaan |

|---------|----------|

| Laravel Breeze | Autentikasi dasar |

| Spatie/laravel-permission | Manajemen role \& permission |

| Barryvdh/laravel-dompdf | Export PDF |

| Maatwebsite/laravel-excel | Export/Import Excel |

| Intervention/image | Manipulasi gambar (upload) |



\### D. Tools Pendukung



| Tool | Kegunaan |

|------|----------|

| Git | Version control |

| GitHub | Repository |

| Draw.io | ERD \& diagram |

| Figma | Desain UI/UX |

| Postman | API testing |

| Laragon/XAMPP | Local server |



\---



\## RINGKASAN PERENCANAAN



| No | Komponen | Status |

|----|----------|--------|

| 1 | Analisis Kebutuhan | ✅ Selesai |

| 2 | Use Case Diagram | ✅ Selesai |

| 3 | Activity Diagram | ✅ Selesai |

| 4 | Sequence Diagram | ✅ Selesai |

| 5 | Class Diagram | ✅ Selesai |

| 6 | ERD | ✅ Selesai |

| 7 | Struktur Database | ✅ Selesai |

| 8 | Struktur Menu | ✅ Selesai |

| 9 | Desain UI/UX | ✅ Selesai |

| 10 | Pembagian Tugas | ✅ Selesai |

| 11 | Timeline | ✅ Selesai |

| 12 | Teknologi | ✅ Selesai |



\---




\---



\*\*📌 Catatan:\*\*



1\. Dokumen ini adalah rencana awal yang dapat disesuaikan dengan kebutuhan selama proses pengembangan.

2\. Perubahan signifikan pada rencana harus dikomunikasikan dengan seluruh anggota tim.

3\. Setiap anggota wajib melaporkan progres pengerjaan setiap hari Senin dan Jumat.



\---

