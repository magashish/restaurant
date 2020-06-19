-- MariaDB dump 10.17  Distrib 10.4.8-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ptcncxkqss
-- ------------------------------------------------------
-- Server version	8.0.11

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin','admin@gmail.com','7984561230','2020-05-28 08:08:35','9660b93a0076d5097dbd0233ef90c8cb',NULL,NULL,'1',NULL,NULL,NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `restaurant_menu_id` bigint(20) unsigned NOT NULL,
  `price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_restaurant_menu_id_foreign` (`restaurant_menu_id`),
  CONSTRAINT `carts_restaurant_menu_id_foreign` FOREIGN KEY (`restaurant_menu_id`) REFERENCES `restaurant_menu` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (6,1,3,6.39,1,'2020-05-24 09:09:29','2020-05-24 09:09:29'),(7,1,2,5.49,2,'2020-05-24 09:11:05','2020-05-24 09:30:31'),(9,2,4,6.99,1,'2020-05-27 00:49:52','2020-05-27 00:49:52'),(10,3,2,5.49,1,'2020-05-28 00:07:19','2020-05-28 00:07:19'),(11,3,3,6.39,1,'2020-06-03 23:25:40','2020-06-03 23:25:40'),(12,4,2,5.49,1,'2020-06-14 02:27:11','2020-06-14 02:27:11'),(13,9,3,6.39,1,'2020-06-14 07:15:32','2020-06-14 07:15:32');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `catimg` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (4,'Hamburger','n/a','Hamburger','1','2020-05-17 14:26:44','2020-05-17 14:26:44'),(5,'Sweets','n/a','Sweets','1','2020-05-17 14:27:11','2020-05-17 14:27:11'),(6,'Basket','n/a','Basket','1','2020-05-17 14:27:37','2020-05-17 14:27:37'),(7,'Salads','n/a','Salads','1','2020-05-17 14:28:11','2020-05-17 14:28:11'),(8,'Appetizers','n/a','Appetizers','1','2020-05-17 14:28:32','2020-05-17 14:28:32'),(9,'Shakes','n/a','Shakes','1','2020-05-17 14:28:53','2020-05-17 14:28:53'),(10,'Burgers','1590850276.jpg','Test','1','2020-05-30 09:21:17','2020-05-30 09:21:17');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_charges`
--

DROP TABLE IF EXISTS `delivery_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_charges` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from_location` int(11) NOT NULL,
  `to_location` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_charges`
--

LOCK TABLES `delivery_charges` WRITE;
/*!40000 ALTER TABLE `delivery_charges` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_charges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2020_05_12_112226_create_restaurants_table',1),(6,'2020_05_14_163623_create_restaurant_menu',2),(7,'2020_05_17_132705_create_categories_table',3),(8,'2020_05_19_163621_create_restaurant_menu_options_table',4),(9,'2020_05_23_120551_create_carts_table',5),(10,'2020_05_23_162642_create_shipping_addresses_table',5),(11,'2020_05_23_162706_create_orders_table',5),(12,'2020_05_23_162713_create_order_items_table',5),(13,'2020_05_24_061800_add_oid_to_orders_table',6),(14,'2020_05_25_193509_create_admins_table',7),(15,'2020_05_27_184550_create_order_addresses_table',8),(16,'2020_05_28_075119_add_address_to_restaurants',8),(17,'2020_05_28_143759_add_shipping_address_to_orders_table',9),(18,'2020_05_30_154706_add_email_cat_to_restaurants',10),(19,'2020_06_03_130314_create_restaurant_categories_table',11),(20,'2020_06_03_145513_create_settings_table',11),(21,'2020_06_04_183508_create_delivery_charges_table',12),(22,'2020_06_05_033247_add_lat_lng_to_restaurants_table',12),(23,'2020_06_06_092449_add_tax_delivery_charge',12),(24,'2020_06_06_092508_add_tax_delivery_charge_orders',12),(25,'2020_06_06_093355_add_final_total_orders',12),(26,'2020_06_14_052316_create_payments_table',13),(27,'2020_06_14_052459_create_sessions_table',13),(28,'2020_06_14_052620_alert_user_tables20200614',13),(29,'2020_06_14_060145_alert_restaurant_tables20200614',14);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_addresses`
--

DROP TABLE IF EXISTS `order_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_addresses_order_id_foreign` (`order_id`),
  CONSTRAINT `order_addresses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_addresses`
--

LOCK TABLES `order_addresses` WRITE;
/*!40000 ALTER TABLE `order_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `restaurant_menu_id` bigint(20) unsigned NOT NULL,
  `price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `restaurant_menu_id` (`restaurant_menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (5,3,2,5.49,3,'2020-05-24 02:17:37','2020-05-24 02:17:37'),(6,3,3,6.39,1,'2020-05-24 02:17:37','2020-05-24 02:17:37'),(7,4,2,5.49,3,'2020-05-24 02:21:04','2020-05-24 02:21:04'),(8,5,4,6.99,1,'2020-05-24 03:28:41','2020-05-24 03:28:41'),(9,3,2,5.49,2,'2020-05-24 04:44:06','2020-05-24 04:44:06'),(10,4,2,5.49,1,'2020-05-24 06:58:19','2020-05-24 06:58:19'),(11,4,3,6.39,1,'2020-05-24 06:58:19','2020-05-24 06:58:19'),(12,5,3,6.39,1,'2020-05-24 07:01:43','2020-05-24 07:01:43'),(13,6,2,5.49,3,'2020-05-24 09:06:18','2020-05-24 09:06:18'),(14,7,2,5.49,1,'2020-05-27 00:49:18','2020-05-27 00:49:18');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `shipping_address_id` bigint(20) unsigned DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `delivery_charge` double(10,2) NOT NULL DEFAULT '0.00',
  `tax` double(10,2) NOT NULL DEFAULT '0.00',
  `final_total` double NOT NULL,
  `shipping_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `billing_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_shipping_address_id_foreign` (`shipping_address_id`),
  CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `shipping_addresses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'',1,1,0.00,0.00,0.00,0,NULL,NULL,'2020-05-23 22:47:05','2020-05-23 22:47:05',NULL),(2,'#ORDER20052400000002',1,1,0.00,0.00,0.00,0,NULL,NULL,'2020-05-24 04:37:24','2020-05-24 04:37:24',NULL),(3,'#ORDER20052400000003',1,1,0.00,0.00,0.00,0,NULL,NULL,'2020-05-24 04:44:06','2020-05-24 04:44:06',NULL),(4,'#ORDER20052400000004',1,1,0.00,0.00,0.00,0,NULL,NULL,'2020-05-24 06:58:18','2020-05-24 06:58:18',NULL),(5,'#ORDER20052400000005',1,1,0.00,0.00,0.00,0,NULL,NULL,'2020-05-24 07:01:43','2020-05-24 07:01:43',NULL),(6,'#ORDER20052400000006',1,1,0.00,0.00,0.00,0,NULL,NULL,'2020-05-24 09:06:17','2020-05-24 09:06:17',NULL),(7,'#ORDER20052700000007',2,2,0.00,0.00,0.00,0,NULL,NULL,'2020-05-27 00:49:18','2020-05-27 00:49:18',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `restaurant_menu_id` bigint(20) unsigned NOT NULL,
  `stripe_charge_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_out` double(8,2) NOT NULL,
  `fees_collected` double(8,2) NOT NULL,
  `refunded` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_customer_id_foreign` (`customer_id`),
  KEY `payments_restaurant_menu_id_foreign` (`restaurant_menu_id`),
  CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  CONSTRAINT `payments_restaurant_menu_id_foreign` FOREIGN KEY (`restaurant_menu_id`) REFERENCES `restaurant_menu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurant_categories`
--

DROP TABLE IF EXISTS `restaurant_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurant_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_categories_restaurant_id_foreign` (`restaurant_id`),
  KEY `restaurant_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `restaurant_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `restaurant_categories_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurant_categories`
--

LOCK TABLES `restaurant_categories` WRITE;
/*!40000 ALTER TABLE `restaurant_categories` DISABLE KEYS */;
INSERT INTO `restaurant_categories` VALUES (1,1,4,'2020-06-04 04:51:03','2020-06-04 04:51:03'),(2,1,5,'2020-06-04 04:51:03','2020-06-04 04:51:03');
/*!40000 ALTER TABLE `restaurant_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurant_menu`
--

DROP TABLE IF EXISTS `restaurant_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurant_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dishname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `restaurant_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `itemoption` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_menu_restaurant_id_index` (`restaurant_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `restaurant_menu_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `restaurant_menu_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurant_menu`
--

LOCK TABLES `restaurant_menu` WRITE;
/*!40000 ALTER TABLE `restaurant_menu` DISABLE KEYS */;
INSERT INTO `restaurant_menu` VALUES (2,'Super Burger',1,4,'1589533240.jpg','1',5.49,'[\"Minus Lettuce\",\"Minus Mayo\",\"Minus Tomati\",\"Minus Mustard Sauce\",\"Minus Cheese Slice\"]','2020-05-15 09:00:40','2020-05-15 09:00:40'),(3,'Super Double',1,4,'1589533300.jpg','1',6.39,'[\"Minus Lattice\",\"Minus Sausage\",\"Minu Mayonese\",\"Minus Cheese Slice\"]','2020-05-15 09:01:40','2020-05-15 09:01:40'),(4,'Triple Burger',1,4,'1589533566.jpg','1',6.99,'[\"Minus Lattice\",\"Minu Mayonese\",\"Minus Cheese Slice\",\"Minus Sausage\"]','2020-05-15 09:06:06','2020-05-15 09:06:06'),(5,'Bacon Cheese',1,4,'1589533628.jpg','1',6.49,'[\"Minus Sausage\",\"Minus Cheese Slice\",\"Minus Lattice\",\"Minu Mayonese\"]','2020-05-15 09:07:08','2020-05-15 09:07:08'),(6,'Double Beacon',1,4,'1589533679.jpg','1',7.39,'[\"Minus Sausage\",\"Minu Mayonese\",\"Minus Cheese Slice\",\"Minus Lattice\"]','2020-05-15 09:07:59','2020-05-15 09:07:59'),(7,'Avocado Burger',1,4,'1589533734.jpg','1',6.39,'[\"Minus Sausage\",\"Minus Lattice\",\"Minu Mayonese\",\"Minus Cheese Slice\"]','2020-05-15 09:08:54','2020-05-15 09:08:54'),(8,'Burger 1',2,4,'1589565925.jpg','1',6.95,'[\"Minus Sausage\",\"Minus Cheese Slice\",\"Minus Lattice\"]','2020-05-15 18:05:25','2020-05-15 18:05:25'),(9,'Item Test',1,4,'1589911040.png','1',10.00,'null','2020-05-19 12:27:20','2020-05-19 12:27:20');
/*!40000 ALTER TABLE `restaurant_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurant_menu_options`
--

DROP TABLE IF EXISTS `restaurant_menu_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurant_menu_options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `restaurant_menu_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_menu_options_restaurant_menu_id_foreign` (`restaurant_menu_id`),
  CONSTRAINT `restaurant_menu_options_restaurant_menu_id_foreign` FOREIGN KEY (`restaurant_menu_id`) REFERENCES `restaurant_menu` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurant_menu_options`
--

LOCK TABLES `restaurant_menu_options` WRITE;
/*!40000 ALTER TABLE `restaurant_menu_options` DISABLE KEYS */;
INSERT INTO `restaurant_menu_options` VALUES (1,9,'lattice',10.00,'2020-05-19 12:27:20','2020-05-19 12:27:20'),(2,9,'Sauce',5.00,'2020-05-19 12:27:20','2020-05-19 12:27:20'),(3,6,'lattice',10.00,'2020-05-19 12:27:20','2020-05-19 12:27:20'),(4,6,'Sauce',5.00,'2020-05-19 12:27:20','2020-05-19 12:27:20');
/*!40000 ALTER TABLE `restaurant_menu_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint(20) unsigned NOT NULL DEFAULT '1',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `timings` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isopen` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortdescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isfeatured` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gmap` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `addr2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `addr1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurants_seller_id_foreign` (`seller_id`),
  CONSTRAINT `restaurants_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (1,1,'Red Onion','restaurant_logo1.png','12:00 am - 12:00 am','1','Burgers, American, Sandwiches, Fast Food, BBQ','Burgers, American, Sandwiches, Fast Food, BBQ','0','','','','','','','','','','',NULL,NULL,'2020-05-15 04:50:06','2020-05-15 04:50:06'),(2,1,'Red Onion 2','restaurant_logo1.png','9:00 am - 12:00 pm','1','Cinese restaurant','Cinese restaurantCinese restaurantCinese restaurant','0','','','','','','','','','','',NULL,NULL,'2020-05-15 18:01:27','2020-05-15 18:01:27'),(3,1,'Red Onion 2','restaurant_logo2.png','9:00 am - 12:00 pm','1','Cinese restaurant','Cinese restaurantCinese restaurantCinese restaurant','0','','','','','','','','','','',NULL,NULL,'2020-05-15 18:01:27','2020-05-15 18:01:27'),(4,1,'Red Onion 3','restaurant_logo3.png','9:00 am - 12:00 pm','1','Cinese restaurant','Cinese restaurantCinese restaurantCinese restaurant','0','','','','','','','','','','',NULL,NULL,'2020-05-15 18:01:27','2020-05-15 18:01:27'),(5,1,'Red Onion 4','restaurant_logo4.png','9:00 am - 12:00 pm','1','Cinese restaurant','Cinese restaurantCinese restaurantCinese restaurant','0','','','','','','','','','','',NULL,NULL,'2020-05-15 18:01:27','2020-05-15 18:01:27'),(6,1,'Red Onion 4','restaurant_logo4.png','9:00 am - 12:00 pm','1','Cinese restaurant','Cinese restaurantCinese restaurantCinese restaurant','0','','','','','','','','','','',NULL,NULL,'2020-05-15 18:01:27','2020-05-15 18:01:27'),(7,1,'Red Onion 5','restaurant_logo4.png','9:00 am - 12:00 pm','1','Cinese restaurant','Cinese restaurantCinese restaurantCinese restaurant','1','','','','','','','','','','',NULL,NULL,'2020-05-15 18:01:27','2020-05-15 18:01:27'),(8,1,'rewrwer','1590667635.png','12:00 am - 12:00 am','1','sdsads','dsadsa','1','','','','dsadasdsad','US','dsaad','california','dasd','dsadsa','dsadsad',NULL,NULL,'2020-05-28 06:37:15','2020-05-28 06:37:15'),(9,1,'name','1590667768.png','12:00 am - 12:00 am','1','sd','D','1','','','','phone','US','zip','california','city','add2','add',NULL,NULL,'2020-05-28 06:39:28','2020-05-28 06:39:28'),(10,1,'rewrwer','1590668084.png','12:00 am - 12:00 am','1','sdsads','dsadsa','0','','','','dsadasdsad','US','dsaad','california','dasd','dsadsa','dsadsad',NULL,NULL,'2020-05-28 06:44:44','2020-05-28 06:44:44'),(11,1,'ddsad','1590668166.png','12:00 am - 12:00 am','1','dasdsa','dsadsa','0','','','','dsadsa','US','dsadsa','california','dsadsa','sdadsad','dsadsad',NULL,NULL,'2020-05-28 06:46:06','2020-05-28 06:46:06'),(12,1,'Test 30520','1590856220.jpg','2:00 am - 4:00 am','1','dsads','dsadsa','1','sadsd','ashish20986@outlook.com','\"10\"','78946513','US','90210','california','asdsa','dsadsad','dsadsa',NULL,NULL,'2020-05-30 11:00:20','2020-05-30 11:00:20'),(13,1,'Test123','1590856534.jpg','1:00 am - 3:00 am','1','sdsads','dasd','0','dsasads','ashish20986@outlook.com','\"10\"','78946513000','US','90211','california','dsadsa','dsadsa','dsadsa',NULL,NULL,'2020-05-30 11:05:34','2020-05-30 11:05:34'),(14,1,'Test123','1590856677.jpg','1:00 am - 3:00 am','1','sdsads','dasd','0','dsasads','ashish20986@outlook.com','\"10\"','78946513000','US','90211','california','dsadsa','dsadsa','dsadsa',NULL,NULL,'2020-05-30 11:07:57','2020-05-30 11:07:57'),(15,1,'dsad','1590857107.jpg','1:00 am - 4:00 am','1','dasds','dasd','1','dsadsad','ashish20986@outlook.com','[\"Open this select menu\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\"]','78946513','US','90210','california','dasd','dasd','ad',NULL,NULL,'2020-05-30 11:15:07','2020-05-30 11:15:07'),(16,1,'dsad','1590857182.jpg','1:00 am - 4:00 am','1','dasds','dasd','1','dsadsad','ashish20986@outlook.com','[\"Open this select menu\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\"]','78946513','US','90210','california','dasd','dasd','ad',NULL,NULL,'2020-05-30 11:16:22','2020-05-30 11:16:22'),(17,1,'dsad','1590857283.jpg','1:00 am - 4:00 am','1','dasds','dasd','1','dsadsad','ashish20986@outlook.com','[\"Open this select menu\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\"]','78946513','US','90210','california','dasd','dasd','ad',NULL,NULL,'2020-05-30 11:18:03','2020-05-30 11:18:03'),(18,1,'dsad','1590857338.jpg','1:00 am - 4:00 am','1','dasds','dasd','1','dsadsad','ashish20986@outlook.com','[\"Open this select menu\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\"]','78946513','US','90210','california','dasd','dasd','ad',NULL,NULL,'2020-05-30 11:18:59','2020-05-30 11:18:59'),(19,1,'dsad','1590857374.jpg','1:00 am - 4:00 am','1','dasds','dasd','1','dsadsad','ashish20986@outlook.com','[\"Open this select menu\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\"]','78946513','US','90210','california','dasd','dasd','ad',NULL,NULL,'2020-05-30 11:19:34','2020-05-30 11:19:34'),(20,1,'sdsadsa','1590857406.jpg','12:00 am - 12:00 am','1','dadasd','asad','1','dsad','ashish20986@outlook.com','[null,\"4\",\"5\",\"8\",\"9\",\"10\"]','78946513','US','90210','california','dasd','dsad','dasdsa',NULL,NULL,'2020-05-30 11:20:06','2020-05-30 11:20:06'),(21,1,'Red Onion Test','1590983542.jpg','12:00 am - 12:00 am','1','dsadsa','dasdsa','1','dsdsadsasa','ashish20986@outlook.com','[\"Hamburger\",\"Sweets\",\"Salads\"]','789456120','US','90210','california','sad','dsad','dsad',NULL,NULL,'2020-05-31 22:22:22','2020-05-31 22:22:22'),(22,1,'Test642020','1591242382.jpg','12:00 am - 12:00 am','1','dsadsd','asdsad','0','dsadasd','ashish20986@outlook.com','[\"Hamburger\",\"Sweets\",\"Basket\",\"Salads\"]','07894651230','US','90210','california','dsdsa','dsadsa','dsads',NULL,NULL,'2020-06-03 22:16:22','2020-06-03 22:16:22');
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_addresses`
--

DROP TABLE IF EXISTS `shipping_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `shipping_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_addresses`
--

LOCK TABLES `shipping_addresses` WRITE;
/*!40000 ALTER TABLE `shipping_addresses` DISABLE KEYS */;
INSERT INTO `shipping_addresses` VALUES (1,1,'Ashish','Sharma','ashish20986@outlook.com','78946513','Test address','Beverly Hills','California','90210','2020-05-23 22:47:04','2020-05-23 22:47:04',NULL),(2,2,'Ashish','Sharma','test@gmail.com','78946513','Test address','Beverly Hills','California','90210','2020-05-27 00:49:18','2020-05-27 00:49:18',NULL);
/*!40000 ALTER TABLE `shipping_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('customer','seller') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `stripe_customer_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_connect_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ashish','ashish20986@outlook.com',NULL,'$2y$10$X0oGlQpkLUb9U5kOCe0uCujvN3BYF6U7xqiRE8GUKhBZ9bVws9xHy',NULL,'2020-05-23 22:28:23','2020-05-23 22:28:23','customer',NULL,NULL),(2,'Ashish Sharma','test@gmail.com',NULL,'$2y$10$7PmQU3yfeXPl9qyy.bv49ORCx/NjuKzLhiuPim3gyUuHj0PRuce8C',NULL,'2020-05-27 00:49:17','2020-05-27 00:49:17','customer',NULL,NULL),(3,'testrest','testrest@gmail.com',NULL,'$2y$10$lavAEkXVEvsK1nhy.qcxxeL5QpOLElU2ZvhpfPQGJqP9sFfUM1Rme',NULL,'2020-05-28 00:07:12','2020-05-28 00:07:12','customer',NULL,NULL),(4,'Customer','demo12@demo.com',NULL,'$2y$10$lpBqaSPoDTUjkYy3SWaine6HAN0G2sy.BbmJiLvZH.kNKuY6Fpu/6',NULL,'2020-06-14 02:26:45','2020-06-14 02:43:16','customer','cus_HSmWyZo1WlefmN',NULL),(7,'Seller','demo@demo.com',NULL,'$2y$10$eqp4kSTuVgvANccz1ExA9egGi3hE.IDNnjrJ1llCLW8je0L5wQOyW',NULL,'2020-06-14 06:07:30','2020-06-14 06:07:30','seller',NULL,'acct_1GtrN4DhQvBHrgfq'),(8,'abc abc','demo2@demo.com',NULL,'$2y$10$BrUKBsZpII2.XZyWVKA5g.Nfp1a4byEdio0XGvfiOzuSpUX7NHpl2',NULL,'2020-06-14 07:01:06','2020-06-14 07:01:06','seller',NULL,NULL),(9,'Teach','admin@test.com',NULL,'$2y$10$xK1G4zN.Pj0yxLZw2deJ6OHxCIpeos4WlheT7l/iwTTX3igEaVcfu',NULL,'2020-06-14 07:15:18','2020-06-14 07:15:18','customer',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-14 20:24:43
