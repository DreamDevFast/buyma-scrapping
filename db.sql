/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.11-MariaDB : Database - buyma
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`buyma` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `buyma`;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `site_url` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `product_img` text DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_comment` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `season_` varchar(255) DEFAULT NULL,
  `theme_` varchar(255) DEFAULT NULL,
  `size_color` varchar(100) DEFAULT NULL,
  `delivery` varchar(255) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `shop_name_` varchar(255) DEFAULT NULL,
  `shipping_place` varchar(255) DEFAULT NULL,
  `product_price` float DEFAULT NULL,
  `normal_pirce_` float DEFAULT NULL,
  `price_type` varchar(10) DEFAULT NULL,
  `tariff_` varchar(255) DEFAULT NULL,
  `exhibition_memo_` text DEFAULT NULL,
  `purchase_memo_` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11273 DEFAULT CHARSET=utf8;

/*Data for the table `products` */

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('0h7EjpVroi6yQvVxqV0mY3beuVlSrrWYYyc8dn9a',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRUlPTGt1dzNQU0NEZ3JPTkFpbHoyb2h1MXFDb3R0YTl6NkROZEV2SyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2xvdWlwYWdlIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb3VpcGFnZT9wYWdlPTE0JnNrZXl3b3JkPSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCRMVUtOOUxveTR0b2FVZy9KSTRpL2Z1V3gubXZKeHNsTk9XMHVReFRObXVtbnlRci5wUVBCcSI7fQ==',1661936858),
('t5tq6mm7U6rnZz6B4ucKLQj8nXUw7vGs2lHqv4FB',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36','YToyOntzOjY6Il90b2tlbiI7czo0MDoiQTlWWnBYeDQ4ZkdabHJORXBPMjlOeWJEWVFYMURqUzlSVGZ3RHdSVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1661957125),
('tGDYyYoFX5sH6ECf0znJHDJgV1oMfpJydxpeS5o2',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWVFUYXlON29FNUVjekJmbGxQNzJtOGNJRU1nRVE2eWJlVlBLeDBzUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb3VpcGFnZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCRMVUtOOUxveTR0b2FVZy9KSTRpL2Z1V3gubXZKeHNsTk9XMHVReFRObXVtbnlRci5wUVBCcSI7fQ==',1661957171);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('producer','worker') COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cell_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`email_verified_at`,`password`,`role`,`family_name`,`cell_phone`,`created_at`,`updated_at`) values 
(1,'nonaka@gmail.com',NULL,'$2y$10$LUKN9Loy4toaUg/JI4i/fuWx.mvJxslNOW0uQxTNmumnyQr.pQPBq','producer','Nonaka',NULL,'2022-07-30 10:38:49','2022-07-30 10:38:49'),
(2,'abc@gmail.com',NULL,'$2y$10$vPEoBoA7YvQcdfepSiFyDO36JUCktXovZs.h.3tqF/pMq4GjOstNC','producer','kaito',NULL,'2022-08-01 14:08:53','2022-08-01 14:08:53'),
(3,'kaito@gmail.com',NULL,'$2y$10$ORwydBsLd3FOCUEHkS97Ru1KLLfOtr0zL7xhfmfPrUCNpaJdIXmPW','producer','kaito',NULL,'2022-08-08 23:30:42','2022-08-08 23:30:42'),
(4,'nonaka123@gmail.com',NULL,'$2y$10$LXI8V37RELYnGoOTMygQveNSuGyCWJ.BVDmdzAJ6WzTv1hPhuEZBa','producer','Moon',NULL,'2022-08-28 22:45:56','2022-08-28 22:45:56');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
