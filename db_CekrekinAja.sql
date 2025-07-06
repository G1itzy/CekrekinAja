-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2025 at 10:03 PM
-- Server version: 10.11.13-MariaDB-cll-lve-log
-- PHP Version: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xukxmbxe_RentalKamera`
--

-- --------------------------------------------------------

--
-- Table structure for table `alats`
--

CREATE TABLE `alats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `nama_alat` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga24` int(11) NOT NULL,
  `harga12` int(11) NOT NULL,
  `harga6` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL DEFAULT 'noimage.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `spesifikasi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alats`
--

INSERT INTO `alats` (`id`, `kategori_id`, `nama_alat`, `deskripsi`, `harga24`, `harga12`, `harga6`, `gambar`, `created_at`, `updated_at`, `stok`, `spesifikasi`) VALUES
(1, 1, 'Sony a7ii', NULL, 200000, 175000, 125000, '1649951685-Sony-A7-Mark-II-Body-Only-a.jpg', NULL, '2025-07-05 10:16:36', 7, NULL),
(2, 1, 'Sony a6000', NULL, 100000, 80000, 50000, '1649951696-21833_L_1.jpg', NULL, '2025-07-05 06:27:52', 9, NULL),
(3, 1, 'Canon EOS 550D', NULL, 85000, 75000, 60000, '1649951709-550d.jpg', NULL, '2025-07-03 01:30:01', 9, NULL),
(4, 2, 'Sigma 30mm 1.4 for Sony', NULL, 100000, 80000, 50000, '1649951742-sigma 30mm.jpg', NULL, '2025-07-03 15:07:18', 10, NULL),
(5, 2, 'Sigma 16mm 1.4 for Sony', NULL, 100000, 80000, 50000, '1649951751-images.jpg', NULL, '2025-07-05 10:16:36', 9, NULL),
(6, 2, 'Canon EF 50mm 1.4 USM', NULL, 75000, 60000, 50000, '1649951760-50mm canon usm.jpg', NULL, '2025-07-03 01:30:02', 10, NULL),
(7, 3, 'Yongnuo 560 IV', NULL, 125000, 90000, 75000, '1649951771-YONGNUO-YN560-IV-a.jpg', NULL, '2025-07-05 10:16:36', 9, NULL),
(8, 4, 'DJI Ronin SC', NULL, 175000, 150000, 100000, '1649951821-dji_rsc_2_ready_gan.jpg', NULL, '2025-07-05 07:41:41', 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `alat_id` bigint(20) UNSIGNED NOT NULL,
  `harga` int(11) NOT NULL,
  `durasi` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Kamera', NULL, NULL),
(2, 'Lensa', NULL, NULL),
(3, 'Lighting', NULL, NULL),
(4, 'Stabilizer', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2022_02_15_140424_create_categories_table', 1),
(5, '2022_02_15_154902_create_alats_table', 1),
(6, '2022_04_09_065246_create_carts_table', 1),
(7, '2022_04_13_135055_create_payments_table', 1),
(8, '2022_04_13_142930_create_orders_table', 1),
(9, '2025_06_28_132654_add_stok_to_alats_table', 2),
(10, '2025_06_28_145107_add_spesifikasi_to_alats_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alat_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `durasi` int(11) NOT NULL,
  `starts` datetime NOT NULL,
  `ends` datetime NOT NULL,
  `harga` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `alat_id`, `user_id`, `payment_id`, `durasi`, `starts`, `ends`, `harga`, `status`, `created_at`, `updated_at`) VALUES
(5, 1, 562, 2, 12, '2025-06-30 18:32:00', '2025-07-01 06:32:00', 175000, 2, '2025-06-28 07:32:33', '2025-06-28 07:33:37'),
(6, 2, 562, 2, 24, '2025-06-30 18:32:00', '2025-07-01 18:32:00', 100000, 2, '2025-06-28 07:32:33', '2025-06-28 07:33:37'),
(7, 3, 562, 2, 24, '2025-06-30 18:32:00', '2025-07-01 18:32:00', 85000, 2, '2025-06-28 07:32:33', '2025-06-28 07:33:37'),
(8, 7, 562, 2, 24, '2025-06-30 18:32:00', '2025-07-01 18:32:00', 125000, 2, '2025-06-28 07:32:33', '2025-06-28 07:33:37'),
(9, 8, 562, 2, 24, '2025-06-30 18:32:00', '2025-07-01 18:32:00', 175000, 2, '2025-06-28 07:32:33', '2025-06-28 07:33:37'),
(10, 6, 562, 2, 24, '2025-06-30 18:32:00', '2025-07-01 18:32:00', 75000, 2, '2025-06-28 07:32:33', '2025-06-28 07:33:37'),
(11, 1, 562, 3, 24, '2025-06-29 18:17:00', '2025-06-30 18:17:00', 200000, 2, '2025-06-28 08:17:10', '2025-07-03 13:52:10'),
(15, 2, 566, 5, 24, '2025-07-04 20:46:00', '2025-07-05 20:46:00', 100000, 2, '2025-07-03 13:44:25', '2025-07-03 13:44:57'),
(16, 4, 567, 6, 24, '2025-07-04 12:38:00', '2025-07-05 12:38:00', 100000, 2, '2025-07-03 14:35:36', '2025-07-03 14:35:58'),
(17, 8, 567, 7, 6, '2025-07-04 22:10:00', '2025-07-05 04:10:00', 100000, 2, '2025-07-03 15:07:52', '2025-07-03 15:08:43'),
(19, 2, 568, 9, 24, '2025-07-23 08:08:00', '2025-07-24 08:08:00', 100000, 2, '2025-07-05 06:08:40', '2025-07-05 06:08:49'),
(20, 8, 568, 10, 24, '2025-07-16 13:30:00', '2025-07-17 13:30:00', 175000, 2, '2025-07-05 06:28:01', '2025-07-05 06:28:08'),
(21, 5, 568, 11, 12, '2025-07-24 18:38:00', '2025-07-25 06:38:00', 80000, 2, '2025-07-05 07:38:26', '2025-07-05 07:38:43'),
(22, 8, 568, 12, 6, '2025-07-17 14:42:00', '2025-07-17 20:42:00', 100000, 2, '2025-07-05 07:41:41', '2025-07-05 07:42:03'),
(23, 7, 568, 13, 6, '2025-07-16 14:50:00', '2025-07-16 20:50:00', 75000, 2, '2025-07-05 07:47:32', '2025-07-05 07:47:44'),
(24, 2, 568, 14, 24, '2025-07-09 18:55:00', '2025-07-10 18:55:00', 100000, 2, '2025-07-05 07:55:15', '2025-07-05 07:55:15'),
(26, 1, 569, 16, 24, '2025-07-26 08:00:00', '2025-07-27 08:00:00', 200000, 2, '2025-07-05 10:05:37', '2025-07-05 10:10:58'),
(27, 5, 569, 16, 24, '2025-07-26 08:00:00', '2025-07-27 08:00:00', 100000, 2, '2025-07-05 10:05:37', '2025-07-05 10:10:58'),
(28, 7, 569, 16, 24, '2025-07-26 08:00:00', '2025-07-27 08:00:00', 125000, 2, '2025-07-05 10:05:37', '2025-07-05 10:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('fiolaaulya@students.amikom.ac.id', 'Mo21oc1DwzyFLpGlNXuOaGDeup0NAhIyuw5RYmKnAry1i1zWRdp8But5U0UGsPyT', '2025-06-28 05:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_invoice` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total` int(11) NOT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `no_invoice`, `user_id`, `total`, `bukti`, `status`, `created_at`, `updated_at`) VALUES
(2, '562/1751095953', 562, 735000, '1751096122-Screenshot (219).png', 4, '2025-06-28 07:32:33', '2025-07-03 01:30:02'),
(3, '562/1751098630', 562, 200000, '1751628384-The-general-structure-of-the-gradient-boosting-algorithm-which-is-based-on-boosting-the.png', 4, '2025-06-28 08:17:10', '2025-07-04 11:44:47'),
(5, '566/1751550265', 566, 100000, '1751550861-Screenshot 2025-06-29 152006.png', 4, '2025-07-03 13:44:25', '2025-07-03 14:12:09'),
(6, '567/1751553336', 567, 100000, '1751554802-Screenshot 2025-06-29 152006.png', 4, '2025-07-03 14:35:36', '2025-07-03 15:07:18'),
(7, '567/1751555272', 567, 100000, '1751555356-Screenshot 2025-06-29 152006.png', 4, '2025-07-03 15:07:52', '2025-07-04 11:44:55'),
(9, '568/1751695720', 568, 100000, '1751696844-Screenshot 2025-06-29 152006.png', 4, '2025-07-05 06:08:40', '2025-07-05 06:27:52'),
(10, '568/1751696881', 568, 175000, '1751700403-Screenshot 2025-06-29 152006.png', 3, '2025-07-05 06:28:01', '2025-07-05 07:26:56'),
(11, '568/1751701106', 568, 80000, '1751701243-Screenshot 2025-06-29 152006.png', 3, '2025-07-05 07:38:26', '2025-07-05 07:40:47'),
(12, '568/1751701301', 568, 100000, '1751701359-Screenshot 2025-06-29 152006.png', 3, '2025-07-05 07:41:41', '2025-07-05 07:42:45'),
(13, '568/1751701652', 568, 75000, '1751701695-Screenshot 2025-06-29 152006.png', 3, '2025-07-05 07:47:32', '2025-07-05 07:48:24'),
(14, '568/1751702115', 568, 100000, NULL, 3, '2025-07-05 07:55:15', '2025-07-05 07:55:15'),
(16, '569/1751709937', 569, 425000, '1751710319-Screenshot 2024-10-28 123440.png', 4, '2025-07-05 10:05:37', '2025-07-05 10:16:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `telepon`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'Alif Nursetyo Vimanto', 'alifnur@test.com', NULL, '$2y$10$J2ut7fCrr40StcDCclHzeeOuDvX8EPAwINb2WQhOx6F7IP9RqoIfe', NULL, 2, NULL, NULL, NULL),
(7, 'Wahyu', 'wahyu@test.com', NULL, '$2y$10$NHt9NCHpTPdKdjvW2hULq.lr5DNJBkj1parHeO4Scvl5CaJXfXuJ2', NULL, 1, NULL, NULL, NULL),
(8, 'Nufus', 'nufus@test.com', NULL, '$2y$10$1C74se2tyryzoeFO/sexNuDN1K0.DoBOpF0.zn/8laG7df5pgxFDK', NULL, 1, NULL, NULL, '2025-07-03 01:19:13'),
(560, 'Fiola', 'fiolaaulya@students.amikom.ac.id', NULL, '$2y$10$o6zHJS85EsXamRPR9zsMuuzLHrlWth1Sjd7NyPDHiaKz732aPk.ba', '+6282285011192', 0, NULL, '2025-06-28 05:07:57', '2025-06-28 05:07:57'),
(561, 'ulin', 'ulin@test.com', NULL, '$2y$10$kwgV1fnh/P3vtzQfMneb7u8QfpLJX1EMsP2L5QPIwdU3e0xGax9H2', '+6284526489520', 0, NULL, '2025-06-28 05:19:06', '2025-06-28 05:19:06'),
(562, 'ALIF NURSETYO VIMANTO', 'alifvimanto69@gmail.com', NULL, '$2y$10$7YPV1UvDGSZSqrLLZ4xiDemvWSsuF0/HYxFXsQ.Cg/73JrwLCtJtS', '+6281385554060', 0, NULL, '2025-06-28 05:31:27', '2025-07-04 11:23:34'),
(564, 'WAHYUTRI NUR ROHMAN', 'wahyutrinurrohman@students.amikom.ac.id', NULL, '$2y$10$mMPEtJcWIxajm0UyYHO5SuWHh9uJft0ikCusdktJgQjRZgj31YGT.', '+6212343211221', 0, NULL, '2025-07-02 23:21:10', '2025-07-02 23:21:10'),
(566, 'Dimas Kusuma', 'dmz.ksm@gmail.com', NULL, '$2y$10$ASadVCw8mQtQlrm7t4347.Ivxzt5FquHtopKf07eHFqgWHiJeu6qu', '+62081512104123', 2, NULL, '2025-07-03 01:28:07', '2025-07-03 01:35:14'),
(567, 'Dimas Kusuma', 'dimas@test.com', NULL, '$2y$10$3lksv8aH9IUQ/hQAgoY9euOl/3L0lMVpmLufAGag5jOv7jNFKyzCa', '+62081512104123', 0, NULL, '2025-07-03 14:34:52', '2025-07-03 14:34:52'),
(568, 'akudimas', 'misnasastri@gmail.com', NULL, '$2y$10$aeiDmCGWteKF/pqiqP27oeteK7tl6RnXGai1YtWzIzh01zDL0bn0q', '+62121312412312', 0, NULL, '2025-07-05 06:08:20', '2025-07-05 06:08:20'),
(569, 'shafondra nufus sulthonik', 'shafondrasulthonik@students.amikom.ac.id', NULL, '$2y$10$97PCYYIFMUR8DHssDA1.VObOm9WNcNQXeuspNOtebhRLHlC81KGum', '+6281290683141', 0, NULL, '2025-07-05 08:06:43', '2025-07-05 08:06:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alats`
--
ALTER TABLE `alats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alats_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_alat_id_foreign` (`alat_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_alat_id_foreign` (`alat_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alats`
--
ALTER TABLE `alats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=570;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alats`
--
ALTER TABLE `alats`
  ADD CONSTRAINT `alats_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
