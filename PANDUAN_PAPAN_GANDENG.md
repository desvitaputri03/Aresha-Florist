# Panduan Papan Gandeng (Double/Triple)

## Cara Menjalankan Migrasi Database

### 1. Buka Terminal/Command Prompt
- Buka terminal di folder project Laravel Anda
- Atau buka Command Prompt/PowerShell dan navigasi ke folder project

### 2. Jalankan Migrasi
Masukkan perintah berikut di terminal:

```bash
cd aresha-florist
php artisan migrate
```

Atau jika Anda sudah berada di folder `aresha-florist`:

```bash
php artisan migrate
```

### 3. Verifikasi Migrasi
Setelah migrasi berhasil, Anda akan melihat output seperti:
```
Migrating: 2025_12_31_120000_add_combined_product_fields_to_carts_table
Migrated:  2025_12_31_120000_add_combined_product_fields_to_carts_table
```

---

## Cara Menggunakan Fitur Papan Gandeng

### Untuk Customer:

1. **Buka Halaman Produk**
   - Pilih produk yang memiliki opsi "Papan Gandeng" (produk dengan `is_combinable = true`)

2. **Aktifkan Papan Gandeng**
   - Centang checkbox "Pesan sebagai Papan Gandeng"
   - Form opsi akan muncul

3. **Pilih Jenis Papan Gandeng:**
   - **2 Papan (Double/Gandeng Dua)** - Untuk ukuran lebih lebar
   - **3 Papan (Triple/Gandeng Tiga)** - Untuk ukuran ekstra lebar
   - **Custom** - Untuk 4+ papan atau ukuran khusus
     - Jika pilih Custom, isi field "Permintaan Khusus"
     - Contoh: "4 papan digabung", "ukuran 2m x 8m", dll

4. **Tambahkan ke Keranjang**
   - Klik "Tambahkan ke Keranjang" atau "Beli Sekarang"
   - Item akan muncul di keranjang dengan badge "Papan Gandeng"

5. **Checkout**
   - Di halaman checkout, informasi papan gandeng akan ditampilkan
   - Untuk custom request, akan ada peringatan "Harga akan dikonfirmasi"

### Untuk Admin:

1. **Mengatur Produk sebagai Combinable**
   - Buka Admin Panel → Products → Create/Edit Product
   - Centang "Produk ini dapat digabungkan"
   - Isi "Pengali Papan Gabungan" (misalnya: 2 untuk 2x harga)

2. **Melihat Custom Request**
   - Di halaman Order Detail, akan terlihat custom request dari customer
   - Admin bisa menghubungi customer untuk konfirmasi harga

---

## Catatan Penting:

- **Papan Gandeng 2 atau 3**: Harga otomatis dihitung berdasarkan multiplier
- **Custom Request**: Harga menggunakan estimasi, admin perlu konfirmasi manual
- **Custom Request** akan tersimpan di field `combined_custom_request` di database
- Admin bisa melihat custom request di detail order untuk follow up

---

## Troubleshooting:

Jika migrasi gagal:
1. Pastikan database connection sudah benar di `.env`
2. Pastikan semua migrasi sebelumnya sudah dijalankan
3. Cek apakah tabel `carts` sudah ada

Jika ada error:
```bash
php artisan migrate:status
```
Untuk melihat status migrasi



