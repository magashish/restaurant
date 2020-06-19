-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2020 at 12:48 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ptcncxkqss`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `mobile`, `email_verified_at`, `password`, `image`, `remember_token`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '7984561230', '2020-05-28 08:08:35', '9660b93a0076d5097dbd0233ef90c8cb', NULL, NULL, '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `restaurant_menu_id` bigint(20) UNSIGNED NOT NULL,
  `price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `restaurant_menu_id`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(6, 1, 3, 6.39, 1, '2020-05-24 09:09:29', '2020-05-24 09:09:29'),
(7, 1, 2, 5.49, 2, '2020-05-24 09:11:05', '2020-05-24 09:30:31'),
(9, 2, 4, 6.99, 1, '2020-05-27 00:49:52', '2020-05-27 00:49:52'),
(10, 3, 2, 5.49, 1, '2020-05-28 00:07:19', '2020-05-28 00:07:19'),
(11, 3, 3, 6.39, 1, '2020-06-03 23:25:40', '2020-06-03 23:25:40');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catimg` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `catimg`, `description`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Hamburger', 'n/a', 'Hamburger', '1', '2020-05-17 14:26:44', '2020-05-17 14:26:44'),
(5, 'Sweets', 'n/a', 'Sweets', '1', '2020-05-17 14:27:11', '2020-05-17 14:27:11'),
(6, 'Basket', 'n/a', 'Basket', '1', '2020-05-17 14:27:37', '2020-05-17 14:27:37'),
(7, 'Salads', 'n/a', 'Salads', '1', '2020-05-17 14:28:11', '2020-05-17 14:28:11'),
(8, 'Appetizers', 'n/a', 'Appetizers', '1', '2020-05-17 14:28:32', '2020-05-17 14:28:32'),
(9, 'Shakes', 'n/a', 'Shakes', '1', '2020-05-17 14:28:53', '2020-05-17 14:28:53'),
(10, 'Burgers', '1590850276.jpg', 'Test', '1', '2020-05-30 09:21:17', '2020-05-30 09:21:17');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_charges`
--

CREATE TABLE `delivery_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_location` int(11) NOT NULL,
  `to_location` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2020_05_12_112226_create_restaurants_table', 1),
(6, '2020_05_14_163623_create_restaurant_menu', 2),
(7, '2020_05_17_132705_create_categories_table', 3),
(8, '2020_05_19_163621_create_restaurant_menu_options_table', 4),
(9, '2020_05_23_120551_create_carts_table', 5),
(10, '2020_05_23_162642_create_shipping_addresses_table', 5),
(11, '2020_05_23_162706_create_orders_table', 5),
(12, '2020_05_23_162713_create_order_items_table', 5),
(13, '2020_05_24_061800_add_oid_to_orders_table', 6),
(14, '2020_05_25_193509_create_admins_table', 7),
(15, '2020_05_27_184550_create_order_addresses_table', 8),
(16, '2020_05_28_075119_add_address_to_restaurants', 8),
(17, '2020_05_28_143759_add_shipping_address_to_orders_table', 9),
(18, '2020_05_30_154706_add_email_cat_to_restaurants', 10),
(19, '2020_06_03_130314_create_restaurant_categories_table', 11),
(20, '2020_06_03_145513_create_settings_table', 11),
(21, '2020_06_04_183508_create_delivery_charges_table', 12),
(22, '2020_06_05_033247_add_lat_lng_to_restaurants_table', 12),
(23, '2020_06_06_092449_add_tax_delivery_charge', 12),
(24, '2020_06_06_092508_add_tax_delivery_charge_orders', 12),
(25, '2020_06_06_093355_add_final_total_orders', 12);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `oid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `delivery_charge` double(10,2) NOT NULL DEFAULT 0.00,
  `tax` double(10,2) NOT NULL DEFAULT 0.00,
  `final_total` double NOT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `oid`, `user_id`, `shipping_address_id`, `amount`, `delivery_charge`, `tax`, `final_total`, `shipping_address`, `billing_address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '', 1, 1, 0.00, 0.00, 0.00, 0, NULL, NULL, '2020-05-23 22:47:05', '2020-05-23 22:47:05', NULL),
(2, '#ORDER20052400000002', 1, 1, 0.00, 0.00, 0.00, 0, NULL, NULL, '2020-05-24 04:37:24', '2020-05-24 04:37:24', NULL),
(3, '#ORDER20052400000003', 1, 1, 0.00, 0.00, 0.00, 0, NULL, NULL, '2020-05-24 04:44:06', '2020-05-24 04:44:06', NULL),
(4, '#ORDER20052400000004', 1, 1, 0.00, 0.00, 0.00, 0, NULL, NULL, '2020-05-24 06:58:18', '2020-05-24 06:58:18', NULL),
(5, '#ORDER20052400000005', 1, 1, 0.00, 0.00, 0.00, 0, NULL, NULL, '2020-05-24 07:01:43', '2020-05-24 07:01:43', NULL),
(6, '#ORDER20052400000006', 1, 1, 0.00, 0.00, 0.00, 0, NULL, NULL, '2020-05-24 09:06:17', '2020-05-24 09:06:17', NULL),
(7, '#ORDER20052700000007', 2, 2, 0.00, 0.00, 0.00, 0, NULL, NULL, '2020-05-27 00:49:18', '2020-05-27 00:49:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_addresses`
--

CREATE TABLE `order_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `restaurant_menu_id` bigint(20) UNSIGNED NOT NULL,
  `price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `restaurant_menu_id`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(5, 3, 2, 5.49, 3, '2020-05-24 02:17:37', '2020-05-24 02:17:37'),
(6, 3, 3, 6.39, 1, '2020-05-24 02:17:37', '2020-05-24 02:17:37'),
(7, 4, 2, 5.49, 3, '2020-05-24 02:21:04', '2020-05-24 02:21:04'),
(8, 5, 4, 6.99, 1, '2020-05-24 03:28:41', '2020-05-24 03:28:41'),
(9, 3, 2, 5.49, 2, '2020-05-24 04:44:06', '2020-05-24 04:44:06'),
(10, 4, 2, 5.49, 1, '2020-05-24 06:58:19', '2020-05-24 06:58:19'),
(11, 4, 3, 6.39, 1, '2020-05-24 06:58:19', '2020-05-24 06:58:19'),
(12, 5, 3, 6.39, 1, '2020-05-24 07:01:43', '2020-05-24 07:01:43'),
(13, 6, 2, 5.49, 3, '2020-05-24 09:06:18', '2020-05-24 09:06:18'),
(14, 7, 2, 5.49, 1, '2020-05-27 00:49:18', '2020-05-27 00:49:18');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timings` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isopen` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortdescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isfeatured` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gmap` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addr2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addr1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `logo`, `timings`, `isopen`, `shortdescription`, `description`, `isfeatured`, `gmap`, `email`, `categories`, `phone`, `country`, `postcode`, `state`, `city`, `addr2`, `addr1`, `lat`, `lng`, `created_at`, `updated_at`) VALUES
(1, 'Red Onion', 'restaurant_logo1.png', '12:00 am - 12:00 am', '1', 'Burgers, American, Sandwiches, Fast Food, BBQ', 'Burgers, American, Sandwiches, Fast Food, BBQ', '0', '', '', '', '', '', '', '', '', '', '', NULL, NULL, '2020-05-15 04:50:06', '2020-05-15 04:50:06'),
(2, 'Red Onion 2', 'restaurant_logo1.png', '9:00 am - 12:00 pm', '1', 'Cinese restaurant', 'Cinese restaurantCinese restaurantCinese restaurant', '0', '', '', '', '', '', '', '', '', '', '', NULL, NULL, '2020-05-15 18:01:27', '2020-05-15 18:01:27'),
(3, 'Red Onion 2', 'restaurant_logo2.png', '9:00 am - 12:00 pm', '1', 'Cinese restaurant', 'Cinese restaurantCinese restaurantCinese restaurant', '0', '', '', '', '', '', '', '', '', '', '', NULL, NULL, '2020-05-15 18:01:27', '2020-05-15 18:01:27'),
(4, 'Red Onion 3', 'restaurant_logo3.png', '9:00 am - 12:00 pm', '1', 'Cinese restaurant', 'Cinese restaurantCinese restaurantCinese restaurant', '0', '', '', '', '', '', '', '', '', '', '', NULL, NULL, '2020-05-15 18:01:27', '2020-05-15 18:01:27'),
(5, 'Red Onion 4', 'restaurant_logo4.png', '9:00 am - 12:00 pm', '1', 'Cinese restaurant', 'Cinese restaurantCinese restaurantCinese restaurant', '0', '', '', '', '', '', '', '', '', '', '', NULL, NULL, '2020-05-15 18:01:27', '2020-05-15 18:01:27'),
(6, 'Red Onion 4', 'restaurant_logo4.png', '9:00 am - 12:00 pm', '1', 'Cinese restaurant', 'Cinese restaurantCinese restaurantCinese restaurant', '0', '', '', '', '', '', '', '', '', '', '', NULL, NULL, '2020-05-15 18:01:27', '2020-05-15 18:01:27'),
(7, 'Red Onion 5', 'restaurant_logo4.png', '9:00 am - 12:00 pm', '1', 'Cinese restaurant', 'Cinese restaurantCinese restaurantCinese restaurant', '1', '', '', '', '', '', '', '', '', '', '', NULL, NULL, '2020-05-15 18:01:27', '2020-05-15 18:01:27'),
(8, 'rewrwer', '1590667635.png', '12:00 am - 12:00 am', '1', 'sdsads', 'dsadsa', '1', '', '', '', 'dsadasdsad', 'US', 'dsaad', 'california', 'dasd', 'dsadsa', 'dsadsad', NULL, NULL, '2020-05-28 06:37:15', '2020-05-28 06:37:15'),
(9, 'name', '1590667768.png', '12:00 am - 12:00 am', '1', 'sd', 'D', '1', '', '', '', 'phone', 'US', 'zip', 'california', 'city', 'add2', 'add', NULL, NULL, '2020-05-28 06:39:28', '2020-05-28 06:39:28'),
(10, 'rewrwer', '1590668084.png', '12:00 am - 12:00 am', '1', 'sdsads', 'dsadsa', '0', '', '', '', 'dsadasdsad', 'US', 'dsaad', 'california', 'dasd', 'dsadsa', 'dsadsad', NULL, NULL, '2020-05-28 06:44:44', '2020-05-28 06:44:44'),
(11, 'ddsad', '1590668166.png', '12:00 am - 12:00 am', '1', 'dasdsa', 'dsadsa', '0', '', '', '', 'dsadsa', 'US', 'dsadsa', 'california', 'dsadsa', 'sdadsad', 'dsadsad', NULL, NULL, '2020-05-28 06:46:06', '2020-05-28 06:46:06'),
(12, 'Test 30520', '1590856220.jpg', '2:00 am - 4:00 am', '1', 'dsads', 'dsadsa', '1', 'sadsd', 'ashish20986@outlook.com', '\"10\"', '78946513', 'US', '90210', 'california', 'asdsa', 'dsadsad', 'dsadsa', NULL, NULL, '2020-05-30 11:00:20', '2020-05-30 11:00:20'),
(13, 'Test123', '1590856534.jpg', '1:00 am - 3:00 am', '1', 'sdsads', 'dasd', '0', 'dsasads', 'ashish20986@outlook.com', '\"10\"', '78946513000', 'US', '90211', 'california', 'dsadsa', 'dsadsa', 'dsadsa', NULL, NULL, '2020-05-30 11:05:34', '2020-05-30 11:05:34'),
(14, 'Test123', '1590856677.jpg', '1:00 am - 3:00 am', '1', 'sdsads', 'dasd', '0', 'dsasads', 'ashish20986@outlook.com', '\"10\"', '78946513000', 'US', '90211', 'california', 'dsadsa', 'dsadsa', 'dsadsa', NULL, NULL, '2020-05-30 11:07:57', '2020-05-30 11:07:57'),
(15, 'dsad', '1590857107.jpg', '1:00 am - 4:00 am', '1', 'dasds', 'dasd', '1', 'dsadsad', 'ashish20986@outlook.com', '[\"Open this select menu\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\"]', '78946513', 'US', '90210', 'california', 'dasd', 'dasd', 'ad', NULL, NULL, '2020-05-30 11:15:07', '2020-05-30 11:15:07'),
(16, 'dsad', '1590857182.jpg', '1:00 am - 4:00 am', '1', 'dasds', 'dasd', '1', 'dsadsad', 'ashish20986@outlook.com', '[\"Open this select menu\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\"]', '78946513', 'US', '90210', 'california', 'dasd', 'dasd', 'ad', NULL, NULL, '2020-05-30 11:16:22', '2020-05-30 11:16:22'),
(17, 'dsad', '1590857283.jpg', '1:00 am - 4:00 am', '1', 'dasds', 'dasd', '1', 'dsadsad', 'ashish20986@outlook.com', '[\"Open this select menu\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\"]', '78946513', 'US', '90210', 'california', 'dasd', 'dasd', 'ad', NULL, NULL, '2020-05-30 11:18:03', '2020-05-30 11:18:03'),
(18, 'dsad', '1590857338.jpg', '1:00 am - 4:00 am', '1', 'dasds', 'dasd', '1', 'dsadsad', 'ashish20986@outlook.com', '[\"Open this select menu\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\"]', '78946513', 'US', '90210', 'california', 'dasd', 'dasd', 'ad', NULL, NULL, '2020-05-30 11:18:59', '2020-05-30 11:18:59'),
(19, 'dsad', '1590857374.jpg', '1:00 am - 4:00 am', '1', 'dasds', 'dasd', '1', 'dsadsad', 'ashish20986@outlook.com', '[\"Open this select menu\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\"]', '78946513', 'US', '90210', 'california', 'dasd', 'dasd', 'ad', NULL, NULL, '2020-05-30 11:19:34', '2020-05-30 11:19:34'),
(20, 'sdsadsa', '1590857406.jpg', '12:00 am - 12:00 am', '1', 'dadasd', 'asad', '1', 'dsad', 'ashish20986@outlook.com', '[null,\"4\",\"5\",\"8\",\"9\",\"10\"]', '78946513', 'US', '90210', 'california', 'dasd', 'dsad', 'dasdsa', NULL, NULL, '2020-05-30 11:20:06', '2020-05-30 11:20:06'),
(21, 'Red Onion Test', '1590983542.jpg', '12:00 am - 12:00 am', '1', 'dsadsa', 'dasdsa', '1', 'dsdsadsasa', 'ashish20986@outlook.com', '[\"Hamburger\",\"Sweets\",\"Salads\"]', '789456120', 'US', '90210', 'california', 'sad', 'dsad', 'dsad', NULL, NULL, '2020-05-31 22:22:22', '2020-05-31 22:22:22'),
(22, 'Test642020', '1591242382.jpg', '12:00 am - 12:00 am', '1', 'dsadsd', 'asdsad', '0', 'dsadasd', 'ashish20986@outlook.com', '[\"Hamburger\",\"Sweets\",\"Basket\",\"Salads\"]', '07894651230', 'US', '90210', 'california', 'dsdsa', 'dsadsa', 'dsads', NULL, NULL, '2020-06-03 22:16:22', '2020-06-03 22:16:22');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_categories`
--

CREATE TABLE `restaurant_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `restaurant_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_categories`
--

INSERT INTO `restaurant_categories` (`id`, `restaurant_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 4, '2020-06-04 04:51:03', '2020-06-04 04:51:03'),
(2, 1, 5, '2020-06-04 04:51:03', '2020-06-04 04:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_menu`
--

CREATE TABLE `restaurant_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dishname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `restaurant_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `itemoption` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_menu`
--

INSERT INTO `restaurant_menu` (`id`, `dishname`, `restaurant_id`, `category_id`, `image`, `status`, `price`, `itemoption`, `created_at`, `updated_at`) VALUES
(2, 'Super Burger', 1, 4, '1589533240.jpg', '1', '5.49', '[\"Minus Lettuce\",\"Minus Mayo\",\"Minus Tomati\",\"Minus Mustard Sauce\",\"Minus Cheese Slice\"]', '2020-05-15 09:00:40', '2020-05-15 09:00:40'),
(3, 'Super Double', 1, 4, '1589533300.jpg', '1', '6.39', '[\"Minus Lattice\",\"Minus Sausage\",\"Minu Mayonese\",\"Minus Cheese Slice\"]', '2020-05-15 09:01:40', '2020-05-15 09:01:40'),
(4, 'Triple Burger', 1, 4, '1589533566.jpg', '1', '6.99', '[\"Minus Lattice\",\"Minu Mayonese\",\"Minus Cheese Slice\",\"Minus Sausage\"]', '2020-05-15 09:06:06', '2020-05-15 09:06:06'),
(5, 'Bacon Cheese', 1, 4, '1589533628.jpg', '1', '6.49', '[\"Minus Sausage\",\"Minus Cheese Slice\",\"Minus Lattice\",\"Minu Mayonese\"]', '2020-05-15 09:07:08', '2020-05-15 09:07:08'),
(6, 'Double Beacon', 1, 4, '1589533679.jpg', '1', '7.39', '[\"Minus Sausage\",\"Minu Mayonese\",\"Minus Cheese Slice\",\"Minus Lattice\"]', '2020-05-15 09:07:59', '2020-05-15 09:07:59'),
(7, 'Avocado Burger', 1, 4, '1589533734.jpg', '1', '6.39', '[\"Minus Sausage\",\"Minus Lattice\",\"Minu Mayonese\",\"Minus Cheese Slice\"]', '2020-05-15 09:08:54', '2020-05-15 09:08:54'),
(8, 'Burger 1', 2, 4, '1589565925.jpg', '1', '6.95', '[\"Minus Sausage\",\"Minus Cheese Slice\",\"Minus Lattice\"]', '2020-05-15 18:05:25', '2020-05-15 18:05:25'),
(9, 'Item Test', 1, 4, '1589911040.png', '1', '10.00', 'null', '2020-05-19 12:27:20', '2020-05-19 12:27:20');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_menu_options`
--

CREATE TABLE `restaurant_menu_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `restaurant_menu_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_menu_options`
--

INSERT INTO `restaurant_menu_options` (`id`, `restaurant_menu_id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(1, 9, 'lattice', 10.00, '2020-05-19 12:27:20', '2020-05-19 12:27:20'),
(2, 9, 'Sauce', 5.00, '2020-05-19 12:27:20', '2020-05-19 12:27:20'),
(3, 6, 'lattice', 10.00, '2020-05-19 12:27:20', '2020-05-19 12:27:20'),
(4, 6, 'Sauce', 5.00, '2020-05-19 12:27:20', '2020-05-19 12:27:20');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `user_id`, `first_name`, `last_name`, `email`, `mobile`, `address`, `city`, `state`, `zip`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Ashish', 'Sharma', 'ashish20986@outlook.com', '78946513', 'Test address', 'Beverly Hills', 'California', '90210', '2020-05-23 22:47:04', '2020-05-23 22:47:04', NULL),
(2, 2, 'Ashish', 'Sharma', 'test@gmail.com', '78946513', 'Test address', 'Beverly Hills', 'California', '90210', '2020-05-27 00:49:18', '2020-05-27 00:49:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ashish', 'ashish20986@outlook.com', NULL, '$2y$10$X0oGlQpkLUb9U5kOCe0uCujvN3BYF6U7xqiRE8GUKhBZ9bVws9xHy', NULL, '2020-05-23 22:28:23', '2020-05-23 22:28:23'),
(2, 'Ashish Sharma', 'test@gmail.com', NULL, '$2y$10$7PmQU3yfeXPl9qyy.bv49ORCx/NjuKzLhiuPim3gyUuHj0PRuce8C', NULL, '2020-05-27 00:49:17', '2020-05-27 00:49:17'),
(3, 'testrest', 'testrest@gmail.com', NULL, '$2y$10$lavAEkXVEvsK1nhy.qcxxeL5QpOLElU2ZvhpfPQGJqP9sFfUM1Rme', NULL, '2020-05-28 00:07:12', '2020-05-28 00:07:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_restaurant_menu_id_foreign` (`restaurant_menu_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_shipping_address_id_foreign` (`shipping_address_id`);

--
-- Indexes for table `order_addresses`
--
ALTER TABLE `order_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_addresses_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `restaurant_menu_id` (`restaurant_menu_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_categories`
--
ALTER TABLE `restaurant_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_categories_restaurant_id_foreign` (`restaurant_id`),
  ADD KEY `restaurant_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `restaurant_menu`
--
ALTER TABLE `restaurant_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_menu_restaurant_id_index` (`restaurant_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `restaurant_menu_options`
--
ALTER TABLE `restaurant_menu_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_menu_options_restaurant_menu_id_foreign` (`restaurant_menu_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_addresses_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_addresses`
--
ALTER TABLE `order_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `restaurant_categories`
--
ALTER TABLE `restaurant_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `restaurant_menu`
--
ALTER TABLE `restaurant_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `restaurant_menu_options`
--
ALTER TABLE `restaurant_menu_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_restaurant_menu_id_foreign` FOREIGN KEY (`restaurant_menu_id`) REFERENCES `restaurant_menu` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `shipping_addresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_addresses`
--
ALTER TABLE `order_addresses`
  ADD CONSTRAINT `order_addresses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restaurant_categories`
--
ALTER TABLE `restaurant_categories`
  ADD CONSTRAINT `restaurant_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `restaurant_categories_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restaurant_menu`
--
ALTER TABLE `restaurant_menu`
  ADD CONSTRAINT `restaurant_menu_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `restaurant_menu_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restaurant_menu_options`
--
ALTER TABLE `restaurant_menu_options`
  ADD CONSTRAINT `restaurant_menu_options_restaurant_menu_id_foreign` FOREIGN KEY (`restaurant_menu_id`) REFERENCES `restaurant_menu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
