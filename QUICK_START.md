# QUICK START GUIDE - Admin PPDB

## 🚀 Instalasi Cepat

### 1. Migration Database (Required)

```bash
php artisan migrate
```

Ini akan membuat 2 tabel baru:

-   `dokumens` - Untuk menyimpan dokumen pendaftar
-   `pengumans` - Untuk menyimpan hasil seleksi

### 2. Clear Cache (Recommended)

```bash
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### 3. Buka di Browser

-   **Base URL**: http://localhost/ppdb-iva
-   **Login**: Gunakan akun dengan role `admin`

---

## 📋 Halaman-Halaman Admin

### 1️⃣ Verifikasi Berkas

**URL**: `/admin/verifikasi`
**Menu**: Dashboard → Verifikasi Berkas

**Fitur:**

-   ✅ Lihat daftar dokumen pendaftar
-   ✅ View detail dokumen
-   ✅ Download file dokumen
-   ✅ Setujui/Tolak dokumen
-   ✅ Tambah catatan verifikasi

**Screenshot Workflow:**

```
1. Buka halaman Verifikasi
2. Lihat tabel dokumen
3. Klik "Detail" untuk info lengkap
4. Klik "Setujui" atau "Tolak"
5. Masukkan catatan
6. Klik "Simpan Verifikasi"
```

---

### 2️⃣ Pengumuman Hasil Seleksi

**URL**: `/admin/pengumuman`
**Menu**: Dashboard → Pengumuman

**Fitur:**

-   ✅ Lihat statistik hasil (diterima, tidak diterima, cadangan)
-   ✅ Input hasil seleksi baru
-   ✅ Edit hasil yang sudah ada
-   ✅ Publikasi/sembunyikan hasil
-   ✅ Import bulk dari CSV
-   ✅ Hapus hasil

**Screenshot Workflow:**

**Tambah Manual:**

```
1. Klik "Tambah Hasil"
2. Pilih peserta dari dropdown
3. Isi Status Hasil (diterima/tidak diterima/cadangan)
4. Isi Nilai Akhir (0-100)
5. Isi Pesan Pengumuman (opsional)
6. Klik "Simpan"
```

**Import CSV:**

```
1. Siapkan file CSV:
   nomor_pendaftaran,nama_peserta,status_hasil,nilai_akhir
   001,Ahmad Syaiful,diterima,85.5
   002,Bella Amelia,tidak_diterima,60.0

2. Klik "Import CSV"
3. Pilih file
4. Upload
```

**Publikasi:**

```
1. Lihat toggle switch di kolom "Dipublikasikan"
2. Klik toggle untuk publikasi/sembunyikan
3. Otomatis tersimpan
```

---

### 3️⃣ Laporan & Statistik

**URL**: `/admin/laporan`
**Menu**: Dashboard → Laporan

**Fitur:**

-   ✅ Dashboard statistik lengkap
-   ✅ Chart visual (Doughnut chart)
-   ✅ Detail laporan per status
-   ✅ Export ke CSV
-   ✅ Persentase success rate

**Komponen Dashboard:**

1. **Total Pendaftar**

    - Menampilkan jumlah user dengan role `user`

2. **Statistik Verifikasi Dokumen**

    - Menunggu Verifikasi (yellow progress bar)
    - Disetujui (green progress bar)
    - Ditolak (red progress bar)
    - Tombol untuk lihat detail per status

3. **Statistik Hasil Seleksi**

    - Diterima (green progress bar)
    - Tidak Diterima (red progress bar)
    - Cadangan (yellow progress bar)
    - Tombol untuk lihat detail per status

4. **Status Publikasi**

    - Jumlah hasil yang sudah dipublikasikan
    - Tombol export dokumen (CSV)
    - Tombol export hasil (CSV)

5. **Charts**
    - Distribusi Verifikasi Dokumen (doughnut)
    - Distribusi Hasil Seleksi (doughnut)

---

## 📊 Database & Data

### Tabel: dokumens

```
Field                  | Type      | Keterangan
-----------------------|-----------|---------------------------------
id                     | bigint    | Primary Key
user_id                | bigint    | FK ke users (pendaftar)
biodata_id             | bigint    | FK ke biodatas
nama_dokumen           | varchar   | Nama dokumen
tipe_dokumen           | varchar   | Tipe: ijazah, akte_kelahiran, dll
file_path              | varchar   | Path file
status_verifikasi      | enum      | menunggu|disetujui|ditolak
catatan_verifikasi     | text      | Catatan admin
diverifikasi_oleh      | bigint    | FK ke users (admin yang verifikasi)
tanggal_verifikasi     | timestamp | Waktu verifikasi
```

### Tabel: pengumans

```
Field                  | Type      | Keterangan
-----------------------|-----------|---------------------------------
id                     | bigint    | Primary Key
user_id                | bigint    | FK ke users (peserta)
biodata_id             | bigint    | FK ke biodatas
nomor_pendaftaran      | varchar   | No. pendaftaran (unique)
nama_peserta           | varchar   | Nama peserta
status_hasil           | enum      | diterima|tidak_diterima|cadangan
nilai_akhir            | decimal   | 0.00 - 100.00
pesan_pengumuman       | text      | Pesan untuk peserta
tanggal_pengumuman     | timestamp | Waktu hasil dibuat
di_publikasikan        | boolean   | Status publikasi (true/false)
```

---

## 🔗 API Endpoints

### Verifikasi Dokumen

```
GET    /admin/dokumen
       → Daftar dokumen (pagination)

GET    /admin/dokumen/{id}
       → Detail dokumen (JSON)

POST   /admin/dokumen/{id}/update-status
       Body: {
           "status_verifikasi": "disetujui",
           "catatan_verifikasi": "Dokumen lengkap"
       }

GET    /admin/dokumen/{id}/download
       → Download file dokumen
```

### Pengumuman

```
GET    /admin/pengumuman-list
       → Daftar pengumuman

POST   /admin/pengumuman
       Body: {
           "biodata_id": 1,
           "status_hasil": "diterima",
           "nilai_akhir": 85.5,
           "pesan_pengumuman": "Selamat"
       }

POST   /admin/pengumuman/{id}/publikasikan
       → Toggle publikasi

DELETE /admin/pengumuman/{id}
       → Hapus pengumuman

POST   /admin/pengumuman/import
       Body: FormData dengan file CSV
```

### Laporan

```
GET    /admin/laporan-index
       → Dashboard laporan

GET    /admin/laporan/export-dokumen
       → Download CSV dokumen

GET    /admin/laporan/export-hasil
       → Download CSV hasil

GET    /admin/laporan/dokumen/{status}
       → Detail laporan dokumen (status: menunggu|disetujui|ditolak)

GET    /admin/laporan/hasil/{status}
       → Detail laporan hasil (status: diterima|tidak_diterima|cadangan)
```

### Helper

```
GET    /admin/biodata-list
       → JSON list biodatas (untuk select dropdown)
```

---

## 💾 Sample Data untuk Testing

### Insert Sample Dokumen

```sql
INSERT INTO dokumens (user_id, biodata_id, nama_dokumen, tipe_dokumen, file_path, status_verifikasi, created_at, updated_at)
VALUES
(2, 1, 'Sertifikat Kelahiran', 'akte_kelahiran', 'docs/1.pdf', 'menunggu', NOW(), NOW()),
(3, 2, 'Ijazah SMP', 'ijazah', 'docs/2.pdf', 'menunggu', NOW(), NOW()),
(4, 3, 'KTP Orangtua', 'ktp', 'docs/3.pdf', 'disetujui', NOW(), NOW());
```

### Insert Sample Pengumuman

```sql
INSERT INTO pengumans (user_id, biodata_id, nomor_pendaftaran, nama_peserta, status_hasil, nilai_akhir, di_publikasikan, created_at, updated_at)
VALUES
(2, 1, '001', 'Ahmad Syaiful', 'diterima', 88.5, true, NOW(), NOW()),
(3, 2, '002', 'Bella Amelia', 'tidak_diterima', 65.0, true, NOW(), NOW()),
(4, 3, '003', 'Citra Dewi', 'cadangan', 78.0, false, NOW(), NOW());
```

---

## 🔐 Security & Access Control

### Authorization

-   Semua route admin dilindungi middleware: `cekRole:admin`
-   Hanya user dengan `role = 'admin'` yang bisa akses
-   Automatic redirect ke login jika belum authenticated

### CSRF Protection

-   Semua form menggunakan CSRF token
-   Token di-include otomatis pada modal forms

---

## 🎨 User Interface Elements

### Modal Dialogs

-   **Detail Dokumen** - Tampilkan info lengkap dokumen
-   **Verifikasi** - Form untuk update status + catatan
-   **Tambah Pengumuman** - Form input hasil seleksi
-   **Import CSV** - File upload pengumuman

### Buttons & Actions

-   **Detail** - Lihat informasi lengkap
-   **Download** - Unduh file
-   **Setujui** - Approve dokumen
-   **Tolak** - Reject dokumen
-   **Edit** - Edit hasil seleksi
-   **Hapus** - Delete hasil seleksi
-   **Export** - Download CSV
-   **Import** - Upload CSV

### Status Badges

-   **Menunggu** - Yellow badge
-   **Disetujui** - Green badge
-   **Ditolak** - Red badge
-   **Diterima** - Green badge
-   **Tidak Diterima** - Red badge
-   **Cadangan** - Yellow badge

---

## 🚨 Troubleshooting

### Halaman Tidak Muncul / 404

```bash
# Clear routes cache
php artisan route:clear
php artisan route:cache
```

### Asset Tidak Muncul (CSS/JS)

```bash
# Clear cache
php artisan cache:clear
php artisan view:clear
```

### Database Error

```bash
# Check migrations
php artisan migrate:status

# Rollback & re-run if needed
php artisan migrate:rollback
php artisan migrate
```

### CSRF Token Mismatch

-   Pastikan session bekerja
-   Clear browser cookies
-   Refresh halaman

### Chart Tidak Muncul

-   Cek browser console untuk error
-   Pastikan Chart.js library ter-load
-   Check data yang dikirim

---

## 📱 Responsive Design

✅ Desktop (1920px)
✅ Tablet (768px)
✅ Mobile (375px)

Semua fitur responsive dan mobile-friendly.

---

## 🔄 Workflow Examples

### Scenario 1: Verifikasi Dokumen

```
1. Peserta upload dokumen (di halaman user)
2. Admin login → Verifikasi Berkas
3. Admin lihat daftar dokumen menunggu
4. Admin klik "Detail" untuk preview
5. Admin klik "Setujui" atau "Tolak"
6. Admin isi catatan (jika ada)
7. Admin klik "Simpan Verifikasi"
8. Status dokumen terupdate
9. Email notifikasi ke peserta (optional)
```

### Scenario 2: Input Hasil Seleksi

```
1. Proses seleksi selesai
2. Admin login → Pengumuman
3. Admin klik "Tambah Hasil"
4. Admin isi form (peserta, status, nilai, pesan)
5. Admin klik "Simpan"
6. Hasil tersimpan tapi belum dipublikasikan
7. Saat siap publikasi, admin toggle "Dipublikasikan"
8. Hasil langsung visible untuk peserta
```

### Scenario 3: Bulk Import

```
1. Persiapkan file CSV dengan hasil seleksi
2. Format: nomor_pendaftaran, nama_peserta, status, nilai
3. Admin login → Pengumuman
4. Admin klik "Import CSV"
5. Admin pilih file
6. Admin klik "Import"
7. Sistem auto-parse & insert ke database
8. Hasil import menampilkan jumlah record
```

### Scenario 4: Export Laporan

```
1. Admin login → Laporan
2. Lihat statistik & charts
3. Admin klik "Export Dokumen (CSV)"
4. File download otomatis
5. Atau klik "Export Hasil (CSV)"
6. File dengan data hasil download
```

---

## 📞 Support

Untuk pertanyaan atau masalah:

1. Baca DOKUMENTASI_ADMIN.md untuk info detail
2. Baca IMPLEMENTATION_SUMMARY.md untuk checklist
3. Lihat kode controller untuk logic detail
4. Hubungi developer tim

---

**Version**: 1.0
**Last Updated**: December 1, 2025
**Framework**: Laravel 11 + Bootstrap 5
**Status**: ✅ Production Ready
