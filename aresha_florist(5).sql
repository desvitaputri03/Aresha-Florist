-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jan 2026 pada 09.51
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aresha_florist`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `is_combined_order` tinyint(1) NOT NULL DEFAULT 0,
  `combined_quantity` int(11) DEFAULT NULL,
  `combined_with_product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `combined_custom_request` text DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `is_combined_order`, `combined_quantity`, `combined_with_product_id`, `combined_custom_request`, `session_id`, `created_at`, `updated_at`) VALUES
(13, NULL, 10, 1, 0, NULL, NULL, NULL, 'OHRwDb90MVorWExi3qZnJGggydaCU5kHhDdMBK0o', '2026-01-03 08:29:44', '2026-01-03 08:29:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `warna` varchar(255) DEFAULT NULL,
  `ikon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `deskripsi`, `slug`, `warna`, `ikon`, `is_active`, `created_at`, `updated_at`) VALUES
(10, 'Papan Rustic', 'Koleksi papan bunga kayu bergaya rustic yang estetik.', 'papan-rustic', NULL, NULL, 1, '2026-01-03 08:10:10', '2026-01-03 08:10:10'),
(11, 'Akrilik', 'Papan ucapan modern dengan bahan akrilik mewah.', 'akrilik', NULL, NULL, 1, '2026-01-03 08:10:10', '2026-01-03 08:10:10'),
(12, 'Box Bunga', 'Rangkaian bunga eksklusif dalam kotak premium.', 'box-bunga', NULL, NULL, 1, '2026-01-03 08:10:10', '2026-01-03 08:10:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `regency_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `districts`
--

INSERT INTO `districts` (`id`, `regency_id`, `name`, `postal_code`, `created_at`, `updated_at`) VALUES
(1, 1, 'Padang Barat', '25112', '2026-01-02 10:17:29', '2026-01-02 10:17:29'),
(2, 1, 'Kuranji', '25152', '2026-01-02 10:17:29', '2026-01-02 10:17:29'),
(3, 2, 'Guguk Panjang', '26136', '2026-01-02 10:17:29', '2026-01-02 10:17:29'),
(4, 3, 'Coblong', '40132', '2026-01-02 10:17:29', '2026-01-02 10:17:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_15_033338_create_categories_table', 1),
(5, '2025_09_15_033338_create_products_table', 1),
(6, '2025_09_27_132139_update_categories_table_structure', 1),
(7, '2025_10_07_000000_add_is_admin_to_users_table', 1),
(8, '2025_10_14_161014_add_missing_columns_to_categories_table', 1),
(9, '2025_10_14_161837_create_carts_table', 1),
(10, '2025_10_14_163252_create_orders_table', 1),
(11, '2025_10_14_163258_create_order_items_table', 1),
(12, '2025_11_06_013340_add_proof_of_transfer_image_to_orders_table', 1),
(13, '2025_11_10_123227_update_payment_status_column_in_orders_table', 1),
(14, '2025_11_10_125441_update_order_status_column_in_orders_table', 1),
(15, '2025_11_10_132108_add_combinable_options_to_carts_table', 1),
(16, '2025_11_12_095506_create_settings_table', 1),
(17, '2025_11_12_095545_create_store_settings_table', 1),
(18, '2025_11_12_095852_create_bookings_table', 1),
(19, '2025_11_12_103245_add_delivery_date_to_orders_table', 1),
(20, '2025_11_12_104211_add_custom_order_fields_to_orders_table', 1),
(21, '2025_11_12_105215_add_custom_message_to_orders_table', 1),
(22, '2025_11_12_110637_add_key_value_to_settings_table', 1),
(23, '2025_11_12_155100_add_correct_combinable_options_to_products_table', 1),
(24, '2025_11_27_094559_create_provinces_table', 1),
(25, '2025_11_27_094633_create_regencies_table', 1),
(26, '2025_11_27_094723_create_districts_table', 1),
(27, '2025_12_11_173829_create_product_images_table', 1),
(28, '2025_12_11_174612_create_store_images_table', 1),
(29, '2025_12_11_180350_add_details_to_store_settings_table', 1),
(30, '2025_12_11_183152_add_payment_gateway_fields_to_orders_table', 1),
(31, '2025_12_30_172328_add_nullable_to_combinable_multiplier_in_products_table', 1),
(32, '2025_12_31_000000_update_payment_method_column_in_orders_table', 2),
(33, '2025_12_31_120000_add_combined_product_fields_to_carts_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_address` text NOT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `custom_message` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'transfer',
  `payment_gateway_order_id` varchar(255) DEFAULT NULL,
  `payment_gateway_status` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) NOT NULL DEFAULT 'pending',
  `order_status` varchar(50) NOT NULL DEFAULT 'pending',
  `delivery_date` date DEFAULT NULL,
  `proof_of_transfer_image` varchar(255) DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `admin_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `recipient_name`, `event_type`, `custom_message`, `notes`, `payment_method`, `payment_gateway_order_id`, `payment_gateway_status`, `payment_status`, `order_status`, `delivery_date`, `proof_of_transfer_image`, `total_amount`, `shipping_cost`, `grand_total`, `created_at`, `updated_at`) VALUES
(1, 'ORD202601020001', 2, 1, 'Desvita Putri', 'noreply@areshaflorist.com', '082386471756', 'Jalan bandes binuang pauh', 'Shinta', 'Wisuda', 'Happy Graduation', NULL, 'transfer', NULL, NULL, 'paid', 'processing', '2026-01-09', 'payment_proofs/iNOR0ZBk27WGcL5fSJnPZ6IuLbII11blK2jPwJnp.jpg', 1690000.00, 0.00, 1690000.00, '2026-01-02 10:50:16', '2026-01-02 10:52:35'),
(2, 'ORD202601020002', 2, 1, 'desvita', 'noreply@areshaflorist.com', '083184946889', 'padang', 'vita', 'wedding', 'hwd', NULL, 'transfer', NULL, NULL, 'pending_transfer', 'pending_payment', '2026-01-22', NULL, 650000.00, 0.00, 650000.00, '2026-01-02 11:42:28', '2026-01-02 11:42:28'),
(3, 'ORD202601020003', NULL, 1, 'Desvita Putri', 'noreply@areshaflorist.com', '082386471756', 'Padang Selatan', 'Diana', 'Wedding', 'Happy Wedding', NULL, 'cod', NULL, NULL, 'pending_cod', 'pending_cod_verification', '2026-01-07', NULL, 200000.00, 0.00, 200000.00, '2026-01-02 14:12:04', '2026-01-02 14:12:04'),
(4, 'ORD202601020004', NULL, 1, 'Desvita', 'noreply@areshaflorist.com', '082386471756', 'padang barat', 'dika', 'wisuda', 'congrats', NULL, 'cod', NULL, NULL, 'pending_cod', 'pending_cod_verification', '2026-01-08', NULL, 550000.00, 0.00, 550000.00, '2026-01-02 14:19:12', '2026-01-02 14:19:12'),
(5, 'ORD202601020005', 2, 1, 'devita', 'noreply@areshaflorist.com', '083184946889', 'padang barat', 'kintan', 'wisuda', 'graduation', NULL, 'cod', NULL, NULL, 'pending_cod', 'pending_cod_verification', '2026-01-08', NULL, 200000.00, 0.00, 200000.00, '2026-01-02 14:20:58', '2026-01-02 14:20:58'),
(6, 'ORD202601020006', 2, 1, 'siska', 'noreply@areshaflorist.com', '083184946889', 'padang', 'dini', 'wisuda', 'hgd', NULL, 'cash', NULL, NULL, 'pending', 'pending', '2026-01-13', NULL, 550000.00, 0.00, 550000.00, '2026-01-02 14:22:31', '2026-01-02 14:22:31'),
(7, 'ORD202601020007', 2, 1, 'yuni', 'noreply@areshaflorist.com', '083184946889', 'padang', 'fina', 'weding', 'hwd', NULL, 'transfer', NULL, NULL, 'paid', 'processing', '2026-01-09', 'payment_proofs/FzCSqOQCU7SLtIPcdnbjJxpW9ZtgQc4wT2VxkpcE.jpg', 650000.00, 0.00, 650000.00, '2026-01-02 14:23:37', '2026-01-02 14:26:48'),
(8, 'ORD202601020008', 2, 1, 'siska', 'noreply@areshaflorist.com', '082386577', 'rrr', 'dea', 'ff', 'ff', NULL, 'cash', NULL, NULL, 'paid', 'pending', '2026-01-07', NULL, 650000.00, 0.00, 650000.00, '2026-01-02 15:01:42', '2026-01-03 08:12:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `harga_diskon` decimal(12,2) DEFAULT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `is_combinable` tinyint(1) NOT NULL DEFAULT 0,
  `combinable_multiplier` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `deskripsi`, `harga`, `harga_diskon`, `id_kategori`, `gambar`, `stok`, `is_combinable`, `combinable_multiplier`, `created_at`, `updated_at`) VALUES
(9, 'Karangan Bunga Box', NULL, 130000.00, NULL, 12, NULL, 12, 0, NULL, '2026-01-03 08:20:37', '2026-01-03 08:20:37'),
(10, 'Papan Bunga Wisuda Premium', NULL, 220000.00, NULL, 11, NULL, 15, 0, NULL, '2026-01-03 08:23:41', '2026-01-03 08:23:41'),
(11, 'Papan Rustic Wisuda', 'Kayu kokoh dan bahan tahan lama.', 150000.00, NULL, 10, NULL, 25, 0, NULL, '2026-01-03 08:30:25', '2026-01-03 08:31:24'),
(12, 'Papan Bunga Dukacita', 'Papan bunga dukacita bergaya rustic yang dirangkai dengan sentuhan alami dan elegan untuk menyampaikan rasa belasungkawa secara tulus.', 150000.00, NULL, 10, NULL, 23, 0, NULL, '2026-01-03 08:40:17', '2026-01-03 08:40:17'),
(13, 'Papan Bunga Selamat Wisuda', NULL, 130000.00, 13.00, 12, NULL, 30, 0, NULL, '2026-01-03 08:44:00', '2026-01-03 08:44:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `order`, `created_at`, `updated_at`) VALUES
(13, 9, 'products/lRc0q4MYukLvX4T4LTb1DUJcqYBXhHtH2MvYpQnD.jpg', 0, '2026-01-03 08:20:37', '2026-01-03 08:20:37'),
(14, 10, 'products/PwaqiqTJN27H0IowdljjK1pW56XjCF86vDqjWcjK.jpg', 0, '2026-01-03 08:23:41', '2026-01-03 08:23:41'),
(15, 11, 'products/0NZje1zG6LdB4T7zrOqfJQfNwoqwZJZNhdH6YsvH.jpg', 0, '2026-01-03 08:30:25', '2026-01-03 08:30:25'),
(16, 12, 'products/25Z3OFj3hQICbXht5RelK4lgG5Ct2gqAEXhhSdVy.jpg', 0, '2026-01-03 08:40:17', '2026-01-03 08:40:17'),
(17, 13, 'products/5RFGtXwJEtLKtWJKLOqDMsLcxnIM79YOrU2Uf9Q0.jpg', 0, '2026-01-03 08:44:01', '2026-01-03 08:44:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Sumatera Barat', '2026-01-02 10:17:29', '2026-01-02 10:17:29'),
(2, 'Jawa Barat', '2026-01-02 10:17:29', '2026-01-02 10:17:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `regencies`
--

CREATE TABLE `regencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `province_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `regencies`
--

INSERT INTO `regencies` (`id`, `province_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kota Padang', '2026-01-02 10:17:29', '2026-01-02 10:17:29'),
(2, 1, 'Kota Bukittinggi', '2026-01-02 10:17:29', '2026-01-02 10:17:29'),
(3, 2, 'Kota Bandung', '2026-01-02 10:17:29', '2026-01-02 10:17:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('OHRwDb90MVorWExi3qZnJGggydaCU5kHhDdMBK0o', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMHlhUDJXWjAyeldrSXVVS3FkOTRXZzJ0bXFySUFnOGR3WU5rQWNnUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXJ0L2NoZWNrb3V0Ijt9fQ==', 1767429330),
('pxRLeQtZiDe6149SFk3rGNk5TqqQIVehrUbsvvmJ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia2pRV0JEcGlhS3pReWxvVk11aUpTcWtWWVozcjRaeDN3WmRnaFpGZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXJ0L2NvdW50Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1767429853);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'bank_account_number', '724101020773555', '2026-01-02 10:58:53', '2026-01-02 10:58:53'),
(2, 'bank_name', 'BRI', '2026-01-02 10:58:53', '2026-01-02 10:58:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `store_images`
--

CREATE TABLE `store_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `store_settings`
--

CREATE TABLE `store_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `operating_hours` varchar(255) DEFAULT NULL,
  `google_maps_link` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `about_us_description` text DEFAULT NULL,
  `history` text DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `mission` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `store_settings`
--

INSERT INTO `store_settings` (`id`, `created_at`, `updated_at`, `address`, `phone_number`, `email`, `operating_hours`, `google_maps_link`, `whatsapp_number`, `about_us_description`, `history`, `vision`, `mission`) VALUES
(1, '2026-01-02 10:20:14', '2026-01-02 10:20:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Aresha Florist', 'admin@areshaflorist.com', NULL, '$2y$12$S498sP6KledosX8wPbF4/ucIVI6UJ1BCeD1v0.PnGnMVYMeQirFN2', 1, NULL, '2026-01-02 10:17:31', '2026-01-02 10:17:31'),
(2, 'Desvita Putri', 'pdesvita93@gmail.com', NULL, '$2y$12$k6jf1QGJQhX.qnBeZkWpEOKIqzB8DsRpNn1mMYunQeIUsXKmxt4T2', 0, NULL, '2026-01-02 10:21:08', '2026-01-02 10:21:08'),
(3, 'Desvita Putri', 'desvita@gmail.com', NULL, '$2y$12$TdM3Dv2wMV7dvZA16HbVR.SHnT03NS2C8efm/E4qNWceV7nkyIELe', 0, NULL, '2026-01-03 05:29:07', '2026-01-03 05:29:07');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_product_id_session_id_unique` (`user_id`,`product_id`,`session_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_combined_with_product_id_foreign` (`combined_with_product_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_regency_id_foreign` (`regency_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_admin_id_foreign` (`admin_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id_kategori_foreign` (`id_kategori`);

--
-- Indeks untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `regencies`
--
ALTER TABLE `regencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regencies_province_id_foreign` (`province_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `store_images`
--
ALTER TABLE `store_images`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `store_settings`
--
ALTER TABLE `store_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `regencies`
--
ALTER TABLE `regencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `store_images`
--
ALTER TABLE `store_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `store_settings`
--
ALTER TABLE `store_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_combined_with_product_id_foreign` FOREIGN KEY (`combined_with_product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_regency_id_foreign` FOREIGN KEY (`regency_id`) REFERENCES `regencies` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `regencies`
--
ALTER TABLE `regencies`
  ADD CONSTRAINT `regencies_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
