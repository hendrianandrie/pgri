-- PGRI Portal & SAKTI MySQL Database Dump
-- Generated for Production Hosting Deployment
-- Target: MySQL / MariaDB (InnoDB, utf8mb4)

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+00:00';

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_23_011649_create_sakti_contents_table', 1),
(5, '2026_09_23_011650_create_executives_table', 1),
(6, '2026_09_23_011651_create_galleries_table', 1),
(7, '2026_09_23_011652_create_contact_messages_table', 1),
(8, '2026_09_29_010231_add_school_origin_to_sakti_contents_table', 2),
(9, '2026_09_29_043027_create_settings_table', 3),
(10, '2026_09_29_140000_create_testimonials_table', 4),
(11, '2026_09_30_090000_create_news_table', 5),
(12, '2026_10_01_100000_add_role_and_details_to_users_table', 6),
(13, '2026_10_01_110000_add_cover_and_photos_to_galleries_table', 7);

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'guru',
  `school_origin` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `school_origin`, `is_active`) VALUES
(1, 'Admin PGRI Pusat', 'admin@pgri.or.id', '2026-09-23 01:18:31', '$2y$12$d7aTtz0zVpJRaxZ.eDayF.1AJXXcjH566CjzQJl.z1ZCWcn/5teYa', 'UvTzdi4tiRepWnSu5JNAzSAYBreKDLMAEjANxVLxw6bCRloyUMemmp2wNfJl', '2026-09-23 01:18:31', '2026-10-01 03:20:38', 'admin', '081234567890', 'Sekretariat PB PGRI', 1),
(5, 'zoya', 'zoya@gmail.com', NULL, '$2y$12$Ygktg10jYq/MxduY/HKX8eDDK98NMlW6MTykOLAvLFVGBkEeRO3WK', NULL, '2026-10-01 03:40:08', '2026-10-01 03:40:08', 'pengurus', NULL, 'SMPN 1 Ciamis', 1);

-- ----------------------------
-- Table structure for `password_reset_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `sessions`
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cache`
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cache_locks`
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `jobs`
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `job_batches`
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `failed_jobs`
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `sakti_contents`
-- ----------------------------
DROP TABLE IF EXISTS `sakti_contents`;
CREATE TABLE IF NOT EXISTS `sakti_contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `school_origin` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sakti_contents_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `sakti_contents`
INSERT INTO `sakti_contents` (`id`, `category`, `title`, `slug`, `summary`, `content`, `author`, `image`, `file_url`, `badge`, `views`, `is_featured`, `published_at`, `created_at`, `updated_at`, `school_origin`) VALUES
(14, 'koding_kka', 'Modul Koding AI & Machine Learning SMA/K Terupdate', 'modul-koding-ai-machine-learning-smak-terupdate-953', 'Modul kecerdasan buatan tingkat lanjut khusus jenjang SMP', 'Modul pembelajaran Koding, Computational Thinking (KKA), dan AI untuk jenjang SMP yang disusun oleh ndrie. Silakan akses materi secara langsung melalui tautan modul.', 'Ndrie', '/storage/sakti/sakti_1790596647_Ym1BVxaV.jpeg', 'https://komputasionalthink.my.canva.site/', 'SMP', 2, 1, '2026-09-28 11:57:27', '2026-09-28 11:57:27', '2026-09-29 01:09:39', 'SMPN 5 Ciamis'),
(20, 'pembelajaran_mendalam', 'Pembelajaran Mendalam di SD', 'pembelajaran-mendalam-di-sd-625', 'Materi ini adalah tentang pembelajaran mendalam di lingkungan SD', 'Modul materi Pembelajaran Mendalam untuk jenjang SMA/K yang disusun oleh Tes, S.Pd. (SDN 1 LInggasari). Silakan akses materi secara langsung melalui tautan modul.', 'Tes, S.Pd.', '/storage/sakti/sakti_1790644694_7SHTcu2f.png', 'https://drive.google.com/file/d/1sU20xhBFDqi6t6dRy7LJzd_XFL5a66as/view?usp=sharing', 'SD', 0, 0, '2026-09-29 01:18:14', '2026-09-29 01:18:14', '2026-09-29 06:34:02', 'SDN 1 LInggasari'),
(21, 'pid', 'Informasiiiiiiii', 'informasiiiiiiii-963', 'Modul Informasiiiiiiii untuk jenjang SMP, disusun oleh Zoyyy (SMPN 1 Ciamis).', 'Modul materi Pusat Informasi & Data untuk jenjang SMP yang disusun oleh Zoyyy (SMPN 1 Ciamis). Silakan akses materi secara langsung melalui tautan modul.', 'Zoyyy', '/storage/sakti/sakti_1790654049_9PSSJpiL.jpeg', 'https://komputasionalthink.my.canva.site/', 'SMP', 1, 0, '2026-09-29 03:54:09', '2026-09-29 03:54:09', '2026-09-29 03:54:24', 'SMPN 1 Ciamis');

-- ----------------------------
-- Table structure for `executives`
-- ----------------------------
DROP TABLE IF EXISTS `executives`;
CREATE TABLE IF NOT EXISTS `executives` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `unit` varchar(255) DEFAULT 'Pengurus Besar PGRI Pusat',
  `photo` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `executives`
INSERT INTO `executives` (`id`, `name`, `position`, `unit`, `photo`, `bio`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(7, 'Agus ......', 'Ketua', 'Pengurus Besar', '/storage/executives/executive_1790653697_jjDegGwG.png', NULL, 1, 1, '2026-09-29 03:48:17', '2026-09-29 03:48:17'),
(8, 'Zoyya', 'Kabid', 'Pengurus Besar', '/storage/executives/executive_1790653717_SDJ14eFQ.png', NULL, 2, 1, '2026-09-29 03:48:37', '2026-09-29 03:48:37');

-- ----------------------------
-- Table structure for `contact_messages`
-- ----------------------------
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `settings`
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'office_address', 'Jl. Jensuddddd', '2026-09-29 04:31:00', '2026-09-29 04:33:56'),
(2, 'office_phone', '(0265)7777', '2026-09-29 04:31:00', '2026-09-29 04:33:56'),
(3, 'office_email', 'sekretariat@pgri.or.id', '2026-09-29 04:31:00', '2026-09-29 04:31:00'),
(4, 'office_whatsapp', '089089089089', '2026-09-29 04:31:00', '2026-09-29 04:33:56'),
(5, 'office_hours', 'Senin - Jumat: 08:00 - 16:00 WIB', '2026-09-29 04:31:00', '2026-09-29 04:31:00'),
(6, 'hero_badge', 'Platform Transformasi Edukasi & Profesi Guru', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(7, 'hero_title', 'Mewujudkan Guru <span class="text-danger">Profesional</span>, <span class="text-success" style="color: #15803d !important;">Sejahtera</span> & <span class="text-warning" style="color: #d97706 !important;">Melek AI</span>', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(8, 'hero_description', 'Persatuan Guru Republik Indonesia (PGRI) mengabdi sejak 1945. Bersama ekosistem SAKTI PGRI, kami mendorong pembelajaran mendalam, repositori perangkat ajar, serta kemampuan Koding, KKA & AI bagi seluruh pendidik Indonesia.', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(9, 'hero_btn1_text', 'Jelajahi SAKTI PGRI', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(10, 'hero_btn1_url', '/sakti', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(11, 'hero_btn2_text', 'Profil & Sejarah', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(12, 'hero_btn2_url', '/profile', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(13, 'hero_card1_title', '500+ Modul SAKTI', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(14, 'hero_card1_subtitle', 'Deep Learning, Koding & AI', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(15, 'hero_card2_title', 'Pelatihan Koding & AI', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(16, 'hero_card2_subtitle', 'Berpikir Komputasional Guru', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(17, 'hero_stat_number', '3', '2026-09-29 04:45:49', '2026-09-29 07:43:12'),
(18, 'hero_stat_label', 'Guru & Tenaga Kependidikan Terhubung', '2026-09-29 04:45:49', '2026-09-29 04:45:49'),
(19, 'hero_image', '/storage/hero/hero_1790667887_WBKNbozY.jpeg', '2026-09-29 07:44:47', '2026-09-29 07:44:47');

-- ----------------------------
-- Table structure for `testimonials`
-- ----------------------------
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role_origin` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `quote` text NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `testimonials`
INSERT INTO `testimonials` (`id`, `name`, `role_origin`, `quote`, `rating`, `photo`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Heuhey, S.Pd.', 'Gusu SMPN ciamis', 'Pendampingan advokasi LKBH PGRI memberikan rasa tenang dan perlindungan nyata bagi kami para guru dalam menjalankan tugas pengabdian di pelosok.', 5, '/storage/testimonials/testi_1790667689_WVLXJa22.png', 2, 1, '2026-09-29 06:29:11', '2026-09-29 07:41:29'),
(3, 'Yessss, S.Pd.', 'Guru SMKN,...', 'Rumah Pendidikan SAKTI memudahkan saya menyusun perangkat ajar Deep Learning secara cepat. Repositorinya sangat lengkap dan terus diperbarui.', 5, '/storage/testimonials/testi_1790667715_vsRh7NYc.png', 3, 1, '2026-09-29 06:29:11', '2026-09-29 07:41:55'),
(5, 'Tessss, S.Pd', 'Guru PAwindannn', 'Modul Koding & AI dari SAKTI PGRI sangat aplikatif! Saya bisa mengajarkan logika berpikir komputasional kepada siswa SD dengan cara yang sangat seru.', 5, '/storage/testimonials/testi_1790667665_Imt0r702.png', 1, 1, '2026-09-29 06:32:23', '2026-09-29 07:41:05');

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `published_at` date NOT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `excerpt` varchar(500) DEFAULT NULL,
  `content` longtext NOT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `news`
INSERT INTO `news` (`id`, `title`, `slug`, `author`, `published_at`, `image`, `excerpt`, `content`, `views_count`, `is_published`, `created_at`, `updated_at`) VALUES
(2, 'Pelatihan Koding dan Kecerdasan Buatan (AI) Bagi Guru SD dan SMP se-Kabupaten Ciamis', 'pelatihan-koding-dan-kecerdasan-buatan-ai-bagi-guru-sd-dan-smp-se-kabupaten-ciamis', 'ZOYYYYYY', '2026-09-25', 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1000&q=80', 'Melalui ekosistem SAKTI PGRI, puluhan guru antusias mengikuti lokakarya intensif berpikir komputasional dan pemanfaatan generative AI untuk media belajar inovatif.', 'CIAMIS — Menjawab tantangan transformasi pendidikan abad ke-21, PGRI Cabang Ciamis melalui sayap program SAKTI menyelenggarakan Pelatihan Koding dan Pemanfaatan AI untuk guru jenjang SD dan SMP.\r\n\r\nPelatihan yang berlangsung secara interaktif ini memandu para peserta membuat algoritma visual (visual block coding) dan mengintegrasikan asisten kecerdasan buatan untuk merancang asesmen diagnostik dan modul ajar yang lebih kontekstual.\r\n\r\n"Kami ingin guru tidak sekadar menjadi konsumen teknologi, melainkan kreator dan pemandu generasi muda dalam menavigasi era digital," ujar fasilitator kegiatan. Seluruh peserta mendapatkan akses langsung ke repositori materi SAKTI Koding & AI untuk diterapkan di sekolah masing-masing.', 103, 1, '2026-09-30 01:28:59', '2026-09-30 06:21:16'),
(5, 'Tes Website', 'tes-website', 'Hendriana', '2026-09-30 00:00:00', '/storage/news/news_1790749333_OVN317Ki.jpeg', 'woowwwwwww', 'hahahahahah', 1, 1, '2026-09-30 06:22:13', '2026-09-30 06:22:17');

-- ----------------------------
-- Table structure for `galleries`
-- ----------------------------
DROP TABLE IF EXISTS `galleries`;
CREATE TABLE IF NOT EXISTS `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT 'Kegiatan PGRI',
  `event_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `cover_image` varchar(1000) DEFAULT NULL,
  `photos` longtext DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `galleries`
INSERT INTO `galleries` (`id`, `title`, `category`, `event_date`, `location`, `image`, `description`, `created_at`, `updated_at`, `cover_image`, `photos`) VALUES
(7, 'tesss', 'Kegiatan PGRI', '2026-10-01 00:00:00', 'caimiss', '/storage/galleries/covers/cover_1790830566_iV59rMlJ.jpeg', 'hahay', '2026-10-01 04:56:06', '2026-10-01 04:56:06', '/storage/galleries/covers/cover_1790830566_iV59rMlJ.jpeg',/storage\/storage\\/galleries\\/photos\\/doc_1790830566_s7sSlT8S.jpeg","\\/storage\\/galleries\\/photos\\/doc_1790830566_ZnGWBGVg.jpeg","\\/storage\\/galleries\\/photos\\/doc_1790830566_XLx0cr3s.jpeg","\\/storage\\/galleries\\/photos\\/doc_1790830566_MQANguRy.jpeg","\\/storage\\/galleries\\/photos\\/doc_1790830566_lELdCZno.jpeg"]');

SET FOREIGN_KEY_CHECKS=1;
