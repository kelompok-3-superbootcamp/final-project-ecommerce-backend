-- MariaDB dump 10.19-11.2.3-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ecommerce
-- ------------------------------------------------------
-- Server version	11.2.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES
(1,'Daihatsu','https://via.placeholder.com/200x200','2024-03-23 00:17:18','2024-03-23 00:17:18'),
(2,'Toyota','https://via.placeholder.com/200x200','2024-03-23 00:17:18','2024-03-23 00:17:18'),
(3,'Wuling','https://via.placeholder.com/200x200','2024-03-23 00:17:18','2024-03-23 00:17:18'),
(4,'Isuzu','https://via.placeholder.com/200x200','2024-03-23 00:17:18','2024-03-23 00:17:18'),
(5,'Kia','https://via.placeholder.com/200x200','2024-03-23 00:17:18','2024-03-23 00:17:18'),
(6,'Suzuki','https://via.placeholder.com/200x200','2024-03-23 00:17:18','2024-03-23 00:17:18'),
(7,'Hyundai','https://via.placeholder.com/200x200','2024-03-23 00:17:18','2024-03-23 00:17:18');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `description` tinytext NOT NULL,
  `price` int(11) NOT NULL,
  `transmission` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `km` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `brand_id` bigint(20) unsigned NOT NULL,
  `type_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cars_brand_id_foreign` (`brand_id`),
  KEY `cars_type_id_foreign` (`type_id`),
  KEY `cars_user_id_foreign` (`user_id`),
  CONSTRAINT `cars_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cars_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` VALUES
(1,'Sigra','white','Mobil transmisi bensin',70000000,'automatic','West Marguerite','baru',2013,0,1,'https://via.placeholder.com/300x200',1,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(2,'Calya','maroon','Mobil transmisi hybrid',90000000,'manual','North Verdiebury','bekas',2014,200000,2,'https://via.placeholder.com/300x200',2,1,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(3,'AirEv','maroon','Mobil listrik',110000000,'automatic','East Llewellynville','baru',2015,0,3,'https://via.placeholder.com/300x200',3,4,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(4,'Panther','green','Mobil transmisi hybrid',130000000,'manual','West Desireefort','bekas',2016,400000,4,'https://via.placeholder.com/300x200',4,3,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(5,'Picanto','white','Mobil transmisi bensin',150000000,'automatic','South Myleneside','baru',2017,0,5,'https://via.placeholder.com/300x200',5,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(6,'Ertiga','navy','Mobil transmisi bensin',170000000,'automatic','Reichelview','bekas',2018,150000,6,'https://via.placeholder.com/300x200',6,4,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(7,'Ioniq 5','purple','Mobil listrik',700000000,'automatic','North Karlieville','baru',2019,0,1,'https://via.placeholder.com/300x200',7,4,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(8,'Terios','blue','Mobil transmisi bensin',170000000,'automatic','Lake Geoview','bekas',2020,5000,1,'https://via.placeholder.com/300x200',1,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(9,'Rush','gray','Mobil transmisi bensin',180000000,'manual','New Leonora','baru',2021,0,1,'https://via.placeholder.com/300x200',2,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(10,'Ayla','white','Mobil transmisi bensin',70000000,'automatic','New Dylan','bekas',2022,15000,1,'https://via.placeholder.com/300x200',6,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(11,'Agya','green','Mobil transmisi bensin',80000000,'manual','New Christy','baru',2023,0,1,'https://via.placeholder.com/300x200',5,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(12,'Karimun','olive','Mobil transmisi bensin',60000000,'automatic','West Elmotown','bekas',2024,25000,1,'https://via.placeholder.com/300x200',3,4,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(13,'Alvez','fuchsia','Mobil transmisi bensin',270000000,'manual','North Elizatown','baru',2023,0,1,'https://via.placeholder.com/300x200',7,4,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(14,'Cortez','navy','Mobil transmisi bensin',160000000,'manual','West Birdie','bekas',2024,35000,1,'https://via.placeholder.com/300x200',4,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(15,'APV','green','Mobil transmisi bensin',80000000,'automatic','Harbertown','baru',2022,0,1,'https://via.placeholder.com/300x200',6,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(16,'Carnival','silver','Mobil transmisi bensin',370000000,'automatic','West Lawrenceborough','bekas',2021,45000,1,'https://via.placeholder.com/300x200',1,3,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(17,'Carens','green','Mobil transmisi bensin',470000000,'manual','Monroeville','baru',2020,0,1,'https://via.placeholder.com/300x200',2,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(18,'Santa Fe','navy','Mobil transmisi bensin',570000000,'automatic','South Zelda','bekas',2019,50000,1,'https://via.placeholder.com/300x200',5,3,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(19,'Creta','gray','Mobil transmisi bensin',670000000,'manual','South Mireya','baru',2018,0,1,'https://via.placeholder.com/300x200',3,1,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(20,'Ioniq 6','teal','Mobil transmisi bensin',770000000,'automatic','South Chanel','bekas',2017,60000,1,'https://via.placeholder.com/300x200',4,1,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(21,'StarGazer','yellow','Mobil transmisi bensin',870000000,'manual','North Clementine','baru',2016,0,1,'https://via.placeholder.com/300x200',7,1,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(22,'Ignis','silver','Mobil transmisi bensin',970000000,'automatic','Port Mittiestad','bekas',2015,70000,1,'https://via.placeholder.com/300x200',1,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(23,'Avanza','gray','Mobil transmisi bensin',110000000,'manual','Jamirside','baru',2014,0,1,'https://via.placeholder.com/300x200',2,3,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(24,'Xenia','blue','Mobil transmisi bensin',130000000,'automatic','North Laila','bekas',2013,80000,1,'https://via.placeholder.com/300x200',5,3,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(25,'EV9','silver','Mobil transmisi bensin',140000000,'manual','Damonfurt','baru',2012,0,1,'https://via.placeholder.com/300x200',5,4,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(26,'Rocky','purple','Mobil transmisi bensin',190000000,'automatic','New Alisa','bekas',2011,90000,1,'https://via.placeholder.com/300x200',7,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(27,'Raize','blue','Mobil transmisi bensin',21000000,'manual','New Hellenland','baru',2010,0,1,'https://via.placeholder.com/300x200',7,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(28,'Sonet','green','Mobil transmisi bensin',220000000,'automatic','East Nicklaus','bekas',2009,100000,1,'https://via.placeholder.com/300x200',3,4,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(29,'EV6','fuchsia','Mobil transmisi bensin',230000000,'manual','West Antoinette','baru',2010,0,1,'https://via.placeholder.com/300x200',3,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(30,'Baleno','fuchsia','Mobil transmisi bensin',240000000,'automatic','Lake Zoieshire','bekas',2011,110000,1,'https://via.placeholder.com/300x200',5,2,1,'2024-03-23 00:17:18','2024-03-23 00:17:18');
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_reset_tokens_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2024_03_15_080129_create_brands_table',1),
(6,'2024_03_15_080541_create_types_table',1),
(7,'2024_03_15_080542_create_cars_table',1),
(8,'2024_03_15_083045_create_orders_table',1),
(9,'2024_03_15_083922_create_vouchers_table',1),
(10,'2024_03_15_084223_create_reviews_table',1),
(11,'2024_03_15_084426_create_wishlists_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_url` varchar(255) NOT NULL,
  `total_price` int(11) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `car_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_car_id_foreign` (`car_id`),
  CONSTRAINT `orders_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `star_count` int(11) NOT NULL,
  `comment` tinytext NOT NULL,
  `car_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_car_id_foreign` (`car_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES
(1,5,'Keren kk',1,1,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(2,3,'Irit bensin',1,2,'2024-03-23 00:17:18','2024-03-23 00:17:18'),
(3,4,'Mobil nya kuat',1,3,'2024-03-23 00:17:18','2024-03-23 00:17:18');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES
(1,'Hybrid','Mobil transmisi manual','2024-03-23 00:17:18','2024-03-23 00:17:18'),
(2,'Bensin','Mobil berbahan bakar bensin','2024-03-23 00:17:18','2024-03-23 00:17:18'),
(3,'Solar','Mobil berbahan bakar solar','2024-03-23 00:17:18','2024-03-23 00:17:18'),
(4,'Listrik','Mobil listrik','2024-03-23 00:17:18','2024-03-23 00:17:18');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_number_unique` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Virgil Crooks I','user','roberts.adolphus@example.com','+16825932846','2024-03-22 00:17:17','$2y$12$Em2R1NS4l5noLUyze5xaeuYUsp.mFLEqbyDrhtBvDbQ/M/076gwDy','ToJ559ZPN5','2024-03-22 00:17:17','2024-03-22 00:17:17'),
(2,'Sadie Kuphal','user','neoma83@example.com','+12408763236','2024-03-22 00:17:17','$2y$12$Em2R1NS4l5noLUyze5xaeuYUsp.mFLEqbyDrhtBvDbQ/M/076gwDy','QMZPS3V1jo','2024-03-22 00:17:17','2024-03-22 00:17:17'),
(3,'Donnie Ledner Jr.','user','elza77@example.net','+19714406166','2024-03-22 00:17:17','$2y$12$Em2R1NS4l5noLUyze5xaeuYUsp.mFLEqbyDrhtBvDbQ/M/076gwDy','9dtcxC8p7H','2024-03-22 00:17:17','2024-03-22 00:17:17'),
(4,'Name Towne','user','chaya74@example.com','+15406606341','2024-03-22 00:17:17','$2y$12$Em2R1NS4l5noLUyze5xaeuYUsp.mFLEqbyDrhtBvDbQ/M/076gwDy','jNZWuS9EK6','2024-03-22 00:17:17','2024-03-22 00:17:17'),
(5,'Prof. Lenora Koss II','user','stephon94@example.net','+12233721239','2024-03-22 00:17:17','$2y$12$Em2R1NS4l5noLUyze5xaeuYUsp.mFLEqbyDrhtBvDbQ/M/076gwDy','60uzwIEUuz','2024-03-22 00:17:17','2024-03-22 00:17:17'),
(6,'Lindsay Willms','user','jefferey.kreiger@example.org','+14783834026','2024-03-22 00:17:17','$2y$12$Em2R1NS4l5noLUyze5xaeuYUsp.mFLEqbyDrhtBvDbQ/M/076gwDy','FpqIE7he3w','2024-03-22 00:17:17','2024-03-22 00:17:17'),
(7,'Prof. Merritt Hodkiewicz','user','gdickens@example.com','+17633870627','2024-03-22 00:17:17','$2y$12$Em2R1NS4l5noLUyze5xaeuYUsp.mFLEqbyDrhtBvDbQ/M/076gwDy','69Q9j8GN45','2024-03-22 00:17:17','2024-03-22 00:17:17'),
(8,'Lexi Littel','user','beatty.heidi@example.net','+15632755752','2024-03-22 00:17:17','$2y$12$Em2R1NS4l5noLUyze5xaeuYUsp.mFLEqbyDrhtBvDbQ/M/076gwDy','e1PQeDtNyq','2024-03-22 00:17:17','2024-03-22 00:17:17'),
(9,'Antonia Roberts DVM','user','kamille.gorczany@example.net','+15188454528','2024-03-22 00:17:17','$2y$12$Em2R1NS4l5noLUyze5xaeuYUsp.mFLEqbyDrhtBvDbQ/M/076gwDy','8y6k59kNHL','2024-03-22 00:17:17','2024-03-22 00:17:17'),
(10,'Pansy Ortiz Sr.','user','imogene.langosh@example.net','+18579676006','2024-03-22 00:17:17','$2y$12$Em2R1NS4l5noLUyze5xaeuYUsp.mFLEqbyDrhtBvDbQ/M/076gwDy','dM4Ekh254v','2024-03-22 00:17:17','2024-03-22 00:17:17'),
(11,'Test User','user','test@example.com','+14096001553','2024-03-22 00:17:18','$2y$12$3fFfleJ8bmb6l8MqFAOl9uF86RhqHqQbsLNtaiJvCxJoEpiT/YtWi','XEd1du72Zo','2024-03-22 00:17:18','2024-03-22 00:17:18');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vouchers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `voucher_code` varchar(255) NOT NULL,
  `discount_value` varchar(255) NOT NULL,
  `discount_type` enum('percentage','nominal') NOT NULL,
  `quota` int(11) NOT NULL,
  `expired_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vouchers`
--

LOCK TABLES `vouchers` WRITE;
/*!40000 ALTER TABLE `vouchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `vouchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `car_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_user_id_foreign` (`user_id`),
  KEY `wishlists_car_id_foreign` (`car_id`),
  CONSTRAINT `wishlists_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-22 16:06:38
