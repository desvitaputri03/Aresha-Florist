# Panduan Deployment Aresha Florist

Dokumen ini menyediakan panduan langkah demi langkah untuk melakukan deployment aplikasi web Aresha Florist (berbasis Laravel) ke server produksi. Pastikan Anda memiliki akses ke server dengan hak akses yang memadai.

## Prasyarat Server

Pastikan server Anda memenuhi prasyarat berikut:

*   **Sistem Operasi:** Ubuntu Server 20.04+ (Direkomendasikan) atau distribusi Linux lainnya.
*   **Web Server:** Nginx atau Apache.
*   **PHP:** PHP 8.1+ dengan ekstensi berikut:
    *   `php-fpm` (untuk Nginx)
    *   `php-cli`
    *   `php-mysql`
    *   `php-mbstring`
    *   `php-xml`
    *   `php-bcmath`
    *   `php-zip`
    *   `php-gd` (untuk Image Intervention, jika digunakan)
*   **Database:** MySQL 8.0+ atau PostgreSQL.
*   **Composer:** Versi terbaru.
*   **Node.js & npm/yarn:** Jika Anda memiliki aset frontend yang perlu dikompilasi (misalnya, menggunakan Vite/Webpack).
*   **Git:** Untuk mengelola kode.
*   **OpenSSL:** Diperlukan oleh Laravel.

## Langkah-langkah Deployment

### 1. Persiapan Server

Login ke server Anda melalui SSH:

```bash
ssh user@your_server_ip
```

**A. Update Sistem & Instal Dependensi Dasar:**

```bash
sudo apt update
sudo apt upgrade -y
sudo apt install -y git curl unzip nginx php8.1-fpm php8.1-cli php8.1-mysql php8.1-mbstring php8.1-xml php8.1-bcmath php8.1-zip php8.1-gd
```

**B. Instal Composer:**

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

**C. Instal Node.js & npm (jika diperlukan untuk aset frontend):**

```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### 2. Mengunggah Kode Aplikasi

**A. Clone Repository Git Anda:**

Pindahkan kode aplikasi Anda ke server, biasanya di `/var/www/your_project_name`.

```bash
sudo git clone your_repository_url /var/www/aresha-florist
cd /var/www/aresha-florist
```

**B. Instal Dependensi PHP:**

```bash
sudo composer install --no-dev --optimize-autoloader
```

**C. Instal Dependensi JavaScript & Kompilasi Aset (jika ada):**

```bash
sudo npm install
sudo npm run build
```

### 3. Konfigurasi Lingkungan (.env)

**A. Buat file `.env`:**

```bash
sudo cp .env.example .env
sudo nano .env
```

**B. Edit `.env` dengan detail produksi:**

*   `APP_ENV=production`
*   `APP_DEBUG=false`
*   `APP_URL=https://your-domain.com`
*   **Konfigurasi Database:**
    *   `DB_DATABASE=your_database_name`
    *   `DB_USERNAME=your_database_user`
    *   `DB_PASSWORD=your_database_password`
*   **Konfigurasi Mail (penting untuk notifikasi):**
    *   Atur driver, host, port, username, password, dan encryption sesuai penyedia layanan email Anda (misalnya Mailgun, SendGrid, Gmail SMTP).
*   **Konfigurasi Google Maps API Key (jika digunakan untuk ongkir):**
    *   `GOOGLE_MAPS_API_KEY=your_google_maps_api_key`
*   **Konfigurasi Payment Gateway API Key (jika digunakan):**
    *   Tambahkan variabel lingkungan untuk kunci API payment gateway Anda.
*   **Konfigurasi WhatsApp API (jika digunakan):**
    *   `WHATSAPP_API_KEY=your_whatsapp_api_key`
    *   `WHATSAPP_API_URL=your_whatsapp_api_url`
    *   `WHATSAPP_ADMIN_PHONE_NUMBER=+62xxxxxxxxxx`

**C. Buat Application Key:**

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

**A. Buat Database & User (jika belum ada):**

Login ke MySQL/PostgreSQL dan buat database serta user untuk aplikasi Anda.

**B. Jalankan Migrasi Database:**

```bash
php artisan migrate --force
```

**C. Seed Data (opsional, jika ada data awal):**

```bash
php artisan db:seed --force
```

### 5. Pengaturan Izin Folder

Pastikan Laravel memiliki izin tulis pada folder `storage` dan `bootstrap/cache`.

```bash
sudo chown -R www-data:www-data /var/www/aresha-florist
sudo chmod -R 775 /var/www/aresha-florist/storage
sudo chmod -R 775 /var/www/aresha-florist/bootstrap/cache
```

### 6. Konfigurasi Web Server (Nginx Contoh)

**A. Buat File Konfigurasi Nginx Baru:**

```bash
sudo nano /etc/nginx/sites-available/aresha-florist
```

**B. Tambahkan Konfigurasi Berikut (sesuaikan dengan domain Anda):**

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/aresha-florist/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\\.ht {
        deny all;
    }
}
```

**C. Aktifkan Konfigurasi & Reload Nginx:**

```bash
sudo ln -s /etc/nginx/sites-available/aresha-florist /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 7. Konfigurasi SSL/TLS (HTTPS)

Sangat disarankan untuk mengamankan situs Anda dengan HTTPS menggunakan Let's Encrypt.

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d your-domain.com -d www.your-domain.com
```

Ikuti instruksi di layar.

### 8. Pengaturan Scheduler (Cron Job)

Laravel scheduler digunakan untuk menjalankan tugas terjadwal seperti queue, laporan, dll. Tambahkan entri cron job berikut:

```bash
sudo crontab -e
```

Tambahkan baris ini di bagian bawah file:

```cron
* * * * * cd /var/www/aresha-florist && php artisan schedule:run >> /dev/null 2>&1
```

### 9. Tes Aplikasi

Setelah semua langkah selesai, buka browser Anda dan akses `https://your-domain.com` untuk memverifikasi bahwa aplikasi berjalan dengan benar.

## Pemeliharaan & Pembaruan

*   **Mengupdate Kode:** Lakukan `git pull`, `composer install --no-dev --optimize-autoloader`, `npm install && npm run build` (jika ada perubahan frontend), dan `php artisan migrate --force`.
*   **Membersihkan Cache Laravel:** `php artisan optimize`, `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`.
*   **Memantau Log:** `tail -f /var/www/aresha-florist/storage/logs/laravel.log`

Ini adalah panduan dasar. Konfigurasi lebih lanjut mungkin diperlukan tergantung pada kebutuhan spesifik dan penyedia hosting Anda.

