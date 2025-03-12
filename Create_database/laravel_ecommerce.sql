-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 09:47 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_features`
--

CREATE TABLE `additional_features` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `additional_features`
--

INSERT INTO `additional_features` (`id`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Finish', 'finish-2', '2024-11-21 04:47:39', '2024-11-21 04:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `name`, `phone_number`, `country`, `address`, `apartment`, `city`, `state`, `zip_code`, `customer_id`, `created_at`, `updated_at`) VALUES
(16, 'Rahul Kuamr Maurya', '9878767876', 'India', 'Sigara Varanasi', NULL, 'Varanasi', 'Uttar Pradesh', '221010', 1, '2024-12-20 01:31:17', '2024-12-20 01:31:17'),
(17, 'Rahul Kumar Maurya', '6756757575', 'India', 'Sigara Varanasi 2', NULL, 'Varanasi', 'Uttar Pradesh', '221010', 1, '2024-12-30 00:28:40', '2024-12-30 01:50:23'),
(18, 'Rahul Kumar Maurya', '4565465464', 'India', 'Sigara Varanasi', 'test', 'Varanasi', 'Uttar Pradesh', '221010', 1, '2024-12-30 01:52:51', '2024-12-30 02:08:09');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `title`, `description`, `slug`, `created_at`, `updated_at`) VALUES
(18, 'Brand', NULL, 'brand', '2024-11-08 05:47:34', '2024-11-08 05:47:34'),
(19, 'Size', NULL, 'size', '2024-11-08 05:47:40', '2024-11-08 05:47:40'),
(20, 'Material', NULL, 'materialsurface', '2024-11-08 05:47:56', '2024-12-02 06:13:57'),
(21, 'Model', NULL, 'model', '2024-11-08 05:50:35', '2024-11-08 05:50:35'),
(22, 'Product Type', NULL, 'product-type', '2024-11-20 05:45:32', '2024-11-20 05:45:32'),
(23, 'Power', NULL, 'power', '2024-11-20 05:45:42', '2024-11-20 05:45:42'),
(24, 'Coating', NULL, 'coating', '2024-12-02 06:14:42', '2024-12-02 06:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `attributes_value`
--

CREATE TABLE `attributes_value` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributes_id` int(10) UNSIGNED NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes_value`
--

INSERT INTO `attributes_value` (`id`, `name`, `slug`, `attributes_id`, `sort_order`, `created_at`, `updated_at`) VALUES
(55, 'Hawkins', 'hawkins', 18, 0, '2024-11-08 05:56:01', '2024-11-08 05:56:01'),
(57, 'Aluminium', 'aluminium', 20, 0, '2024-11-08 05:56:01', '2024-11-08 05:56:01'),
(59, '2 Ltr', '2-ltr', 19, 0, '2024-11-08 05:56:01', '2024-11-08 05:56:01'),
(60, '3 Ltr', '3-ltr', 19, 0, '2024-11-08 05:56:01', '2024-11-08 05:56:01'),
(61, '5 Ltr', '5-ltr', 19, 0, '2024-11-08 05:56:01', '2024-11-08 05:56:01'),
(62, '6.5 Ltr', '65-ltr', 19, 0, '2024-11-08 05:56:01', '2024-11-08 05:56:01'),
(63, 'Contura White', 'contura-white', 21, 0, '2024-11-08 05:56:01', '2024-11-08 05:56:01'),
(64, 'Contura Black', 'contura-black', 21, 0, '2024-11-08 05:56:01', '2024-11-08 05:56:01'),
(65, 'Stainless Steel', 'stainless-steel-1', 20, 0, '2024-11-08 05:56:01', '2024-11-08 05:56:01'),
(67, '6 Ltr', '6-ltr', 19, 0, '2024-11-08 05:56:02', '2024-11-08 05:56:02'),
(68, 'Contura XT', 'contura-xt', 21, 0, '2024-11-08 05:56:02', '2024-11-08 05:56:02'),
(69, 'Milton', 'milton', 18, 0, '2024-11-08 11:32:07', '2024-11-08 11:32:07'),
(70, 'Duo', 'duo', 21, 0, '2024-11-08 11:32:07', '2024-11-08 11:32:07'),
(72, 'Hard Anodised', 'hard-anodised', 20, 0, '2024-11-11 05:42:17', '2024-11-11 05:42:17'),
(73, 'Futura', 'futura', 21, 0, '2024-11-11 05:42:46', '2024-11-11 05:42:46'),
(74, '5 L', '5-l', 19, 0, '2024-11-11 05:42:46', '2024-11-11 05:42:46'),
(75, 'Stainless Steel', 'stainless-steel', 21, 0, '2024-11-11 05:54:53', '2024-11-11 05:54:53'),
(76, 'Steel Contura', 'steel-contura', 21, 0, '2024-11-11 05:57:01', '2024-11-11 05:57:01'),
(81, 'Tri-Ply', 'tri-ply', 20, 0, '2024-12-02 06:10:00', '2024-12-02 06:10:00'),
(84, 'Non Stick', 'non-stick', 24, 0, '2024-12-02 06:15:07', '2024-12-02 06:15:07'),
(87, '22 Ltr', '22-ltr', 19, 0, '2024-12-02 07:13:20', '2024-12-02 07:13:20'),
(88, 'Big Boy', 'big-boy', 21, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(89, 'NA', 'na', 24, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(90, 'Ceramic', 'ceramic-1', 21, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(92, 'Classic', 'classic', 21, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(93, '10 Ltr', '10-ltr', 19, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(94, '12 Ltr', '12-ltr', 19, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(95, '4 Ltr', '4-ltr', 19, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(96, '8 Ltr', '8-ltr', 19, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(97, 'Triply', 'triply', 21, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(98, 'Contura Green', 'contura-green', 21, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(99, 'Contura Steel', 'contura-steel', 21, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(100, 'Contura Yellow', 'contura-yellow', 21, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(101, '7 Ltr', '7-ltr', 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(102, 'Futura Steel', 'futura-steel', 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(103, 'Heavy Base', 'heavy-base', 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(104, 'Miss Mary', 'miss-mary', 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(105, 'Miss Mary Handi', 'miss-mary-handi', 21, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(107, 'Futura', 'futura-1', 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(108, 'NA', 'na-1', 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(109, 'Cookware Set', 'cookware-set', 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(110, 'Cook n Serve', 'cook-n-serve', 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(111, '2.5 Ltr', '25-ltr', 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(112, 'Kadhai', 'kadhai', 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(113, '29 cm', '29-cm', 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(114, 'Frying Pan', 'frying-pan', 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(115, '1.5 Ltr', '15-ltr', 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(116, '1 Ltr', '1-ltr', 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(117, 'Sauce Pan', 'sauce-pan', 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(118, '8.5 Ltr', '85-ltr', 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(119, 'Stew Pot', 'stew-pot', 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(120, '22 cm', '22-cm', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(121, 'Tava', 'tava', 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(122, '26 cm', '26-cm', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(123, '24 cm', '24-cm', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(124, 'Cast Iron', 'cast-iron', 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(125, '30 cm', '30-cm', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(126, 'Die Cast', 'die-cast', 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(127, 'Grill Pan', 'grill-pan', 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(128, 'Non Stick', 'non-stick-1', 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(129, 'Multi Pan', 'multi-pan', 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(130, 'Appachatty', 'appachatty', 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(131, 'Handi', 'handi', 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(132, 'Tadka Pan', 'tadka-pan', 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(133, '240 ml', '240-ml', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(134, 'Toy', 'toy', 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(135, 'Mini', 'mini', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(136, 'Idli Stand', 'idli-stand', 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(137, 'Large', 'large', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(138, 'Set of 3', 'set-of-3', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(139, 'Set of 2', 'set-of-2', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(140, 'Wood', 'wood', 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(141, 'Spatula', 'spatula', 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(142, '3.75 Ltr', '375-ltr', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(143, '20 cm', '20-cm', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(144, '25 cm', '25-cm', 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(145, '17 cm', '17-cm', 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(146, 'Ceramic Non-Stick', 'ceramic-non-stick-1', 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(147, '28 cm', '28-cm', 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(148, '3.5 Ltr', '35-ltr', 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(149, 'Multi Purpose Pan', 'multi-purpose-pan', 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(150, 'Appe Pan', 'appe-pan', 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(151, '33 cm', '33-cm', 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(152, 'Shielded Non-Stick', 'shielded-non-stick-1', 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(153, 'Uttapam Pan', 'uttapam-pan', 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(154, 'Patila', 'patila', 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(155, '1.25 Ltr', '125-ltr', 19, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(156, 'Mixer Grinder', 'mixer-grinder', 22, 0, '2024-12-03 23:36:58', '2024-12-03 23:36:58'),
(157, 'Juicer Mixer Grinder', 'juicer-mixer-grinder', 22, 0, '2024-12-03 23:37:09', '2024-12-03 23:37:09'),
(158, 'Juicer', 'juicer', 22, 0, '2024-12-03 23:37:18', '2024-12-03 23:37:18'),
(159, 'Sujata', 'sujata', 18, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(160, '3 Jars', '3-jars', 19, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(161, '900W', '900w', 23, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(162, '2 Jars', '2-jars', 19, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(163, 'Philips', 'philips', 18, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(164, '750W', '750w', 23, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(165, 'Bottle', 'bottle', 22, 0, '2024-12-05 05:32:20', '2024-12-05 05:32:20'),
(166, 'Carafe', 'carafe', 22, 0, '2024-12-05 05:32:27', '2024-12-05 05:32:27'),
(167, '500ML', '500ml', 19, 0, '2024-12-05 11:09:01', '2024-12-05 11:09:01'),
(168, '750 ML', '750-ml', 19, 0, '2024-12-05 05:59:37', '2024-12-05 05:59:37'),
(169, '600 ML', '600-ml', 19, 0, '2024-12-05 11:37:33', '2024-12-05 11:37:33'),
(170, 'ARTESIA', 'artesia', 21, 0, '2024-12-05 11:37:33', '2024-12-05 11:37:33'),
(171, 'Yellow Gold', 'yellow-gold', 24, 0, '2025-02-06 14:03:24', '2025-02-06 14:03:24'),
(172, 'Non Stick', 'non-stick-2', 21, 0, '2025-02-06 14:03:24', '2025-02-06 14:03:24'),
(173, 'Regular', 'regular', 22, 0, '2025-02-06 14:03:24', '2025-02-06 14:03:24'),
(174, 'Gold', 'gold', 23, 0, '2025-02-06 14:03:24', '2025-02-06 14:03:24'),
(175, '12', '12', 19, 0, '2025-02-06 14:03:24', '2025-02-06 14:03:24');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path_desktop` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_desktop` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image_path_desktop`, `image_path_mobile`, `link_desktop`, `link_mobile`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Banner 1', 'images/banners/banner-1-1737704056410.webp', NULL, 'http://127.0.0.1:8000/manage-banner', NULL, 1, '2025-01-24 01:44:43', '2025-01-24 02:04:17'),
(2, 'Banner 2', 'images/banners/banner-2-1737704306198.webp', NULL, 'http://127.0.0.1:8000/manage-banner', NULL, 1, '2025-01-24 02:08:26', '2025-01-24 02:08:26'),
(3, 'Banner 3', 'images/banners/banner-3-1737704324265.webp', NULL, 'http://127.0.0.1:8000/manage-banner', NULL, 1, '2025-01-24 02:08:44', '2025-01-24 02:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `billing_addresses`
--

CREATE TABLE `billing_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `apartment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `blog_category_id` int(10) UNSIGNED DEFAULT NULL,
  `bog_description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blog_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `status`, `blog_category_id`, `bog_description`, `blog_image`, `created_at`, `updated_at`) VALUES
(21, 'How to Choose the Perfect Pressure Cooker for Your Needs', 'how-to-choose-the-perfect-pressure-cooker-for-your-needs', 0, 5, '<p>sdasd</p>', 'images/blogs/1738045040031-Untitled-design-83.webp', '2025-01-28 00:47:20', '2025-01-28 00:47:20'),
(22, 'How to Choose the Perfect Pressure Cooker for Your Needs', 'how-to-choose-the-perfect-pressure-cooker-for-your-needs', 0, 5, '<p>asdasdd</p>', 'images/blogs/GD-sons-kitchen-Varanasi-How-to-Choose-the-Perfect-Pressure-Cooker-for-Your-Needs-1738053341978.webp', '2025-01-28 03:05:42', '2025-01-28 03:05:42');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `title`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Best Products', 'best-products', 1, '2025-01-27 23:54:22', '2025-01-27 23:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `blog_paragraphs`
--

CREATE TABLE `blog_paragraphs` (
  `id` int(10) UNSIGNED NOT NULL,
  `blog_id` int(10) UNSIGNED DEFAULT NULL,
  `paragraphs_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bog_paragraph_description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bog_paragraph_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_paragraphs`
--

INSERT INTO `blog_paragraphs` (`id`, `blog_id`, `paragraphs_title`, `bog_paragraph_description`, `bog_paragraph_image`, `created_at`, `updated_at`) VALUES
(48, 21, 'Hawkins Steel Pressure Cooker 1', '<p>sdfdsff</p>', NULL, '2025-01-28 01:41:41', '2025-01-28 01:41:41'),
(49, 22, 'sddsf', '<p>sdfdsf</p>', NULL, '2025-01-28 05:57:51', '2025-01-28 05:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `blog_paragraph_product_links`
--

CREATE TABLE `blog_paragraph_product_links` (
  `id` int(10) UNSIGNED NOT NULL,
  `blog_paragraphs_id` int(10) UNSIGNED DEFAULT NULL,
  `links` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_paragraph_product_links`
--

INSERT INTO `blog_paragraph_product_links` (`id`, `blog_paragraphs_id`, `links`, `product_id`, `created_at`, `updated_at`) VALUES
(30, 48, 'UBC125G HAWKINS CASSEROLE AQUA BABY G/L 1.25L', 315, '2025-01-28 01:41:41', '2025-01-28 01:41:41'),
(31, 48, 'AK15S FUTURA KADHAI DEEP FRYPAN HA S/L 1.5L', 216, '2025-01-28 01:41:41', '2025-01-28 01:41:41'),
(32, 49, '24HAGP FUTURA HA KITCHEN GIFT PACK SET-3', 210, '2025-01-28 05:57:51', '2025-01-28 05:57:51'),
(33, 49, 'ACB50 FUTURA COOK N SERVE BOWL HA 5L', 212, '2025-01-28 05:57:51', '2025-01-28 05:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(250) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT 'Status of the item',
  `is_popular` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT 'Indicates if the item is popular',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(29, 8, 283, 1, '2025-02-19 03:50:42', '2025-02-19 03:50:42'),
(41, 1, 315, 5, '2025-03-12 01:11:55', '2025-03-12 03:08:38'),
(42, 1, 316, 1, '2025-03-12 02:06:48', '2025-03-12 03:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(250) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_heading` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hsn_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on' COMMENT 'Status of the item',
  `trending` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on' COMMENT 'Indicates if the item is treding',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `category_heading`, `hsn_code`, `description`, `slug`, `image`, `status`, `trending`, `created_at`, `updated_at`) VALUES
(4, 'Pressure Cooker', NULL, NULL, NULL, 'pressure-cooker', 'category-image-61CHpkemxeL._SX679_-04-46-55-754.webp', 'on', 'off', '2024-11-08 11:16:56', '2024-11-08 11:16:56'),
(5, 'Vacuum Flask', 'Vacuum Flask – Features, Uses, and Benefits', '9615', 'A vacuum flask, also known as a thermos, is an insulated container designed to maintain the temperature of liquids for extended periods. It consists of a double-walled structure with a vacuum between the walls, reducing heat transfer through conduction and convection.', 'vacuum-flask', 'category-image-GDSonsVaranasiKitchenmiltonduo1500ml1532-05-00-16-734.webp', 'on', 'off', '2024-11-08 11:30:18', '2025-02-12 00:33:03'),
(6, 'Kitchen Appliances', NULL, '851660', NULL, 'kitchen-appliances', 'category-image-Philips Food Processor HL 7707-05-17-09-762.webp', 'on', 'off', '2024-11-20 11:13:07', '2024-12-02 11:47:11'),
(10, 'Cookware', NULL, NULL, NULL, 'cookware', 'category-image-ASET2-05-08-59-955.webp', 'on', 'off', '2024-12-02 11:39:01', '2024-12-02 11:39:01'),
(11, 'test', NULL, NULL, 'hi', 'test', 'GD-sons-kitchen-Varanasi-test-1738415410336.webp', 'on', 'off', '2025-02-01 13:10:15', '2025-02-01 13:10:15'),
(12, 'sdffdsf', 'Vacuum Flask – Features, Uses, and Benefits', NULL, 'A vacuum flask, also known as a thermos, is an insulated container designed to maintain the temperature of liquids for extended periods. It consists of a double-walled structure with a vacuum between the walls, reducing heat transfer through conduction and convection.\r\n\r\nKey Features:\r\nTemperature Retention: Keeps liquids hot or cold for hours.\r\nDurable Build: Made from stainless steel, glass, or plastic materials.\r\nLeak-Proof Design: Prevents spills and ensures portability.\r\nVarious Capacities: Available in different sizes for personal and travel use.\r\nCommon Uses:\r\nStoring hot coffee, tea, or soup for outdoor trips.\r\nKeeping cold beverages like juice and smoothies fresh.\r\nUsed by hikers, travelers, and office-goers for convenience.', 'vaccum-flask', 'GD-sons-kitchen-Varanasi-Vaccum-Flask-1738831085597.webp', 'on', 'off', '2025-02-06 08:38:06', '2025-02-12 00:31:40');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_category_id` int(10) UNSIGNED DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `group_category_id`, `group_id`, `name`, `email`, `customer_id`, `password`, `google_id`, `profile_img`, `phone_number`, `email_verified_at`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 3, 'Rahul Kumar Maurya', 'rahulkumarmaurya464@gmail.com', NULL, '$2y$10$crwzTTH.qW1SRpxLisSjrep5hR9SbpnpxgNTzz5pSHvgJXXjT4X6q', NULL, 'customer-1-profile.webp', '1212121212', NULL, 1, NULL, '2024-12-12 07:35:02', '2025-03-11 23:11:50'),
(8, NULL, NULL, 'Dajal', 'dajal18659@lxheir.com', NULL, '$2y$10$f5TW.RbwD4WAvrLUq36L.uqtMUuQQBzTOv6w4/gM73tECjVBxYk8i', NULL, NULL, '1212121212', NULL, 1, NULL, '2025-02-18 01:05:15', '2025-02-18 01:05:15'),
(9, 1, NULL, 'John', 'john@gmail.com', 'QSDENKjohn', '$2y$10$xDSFn/vCJP7uHeHFEboS9.ao6/7beSIdrXSXBoNqueVzLkHN58vxG', NULL, NULL, '1212121212', NULL, 1, NULL, '2025-02-19 00:46:20', '2025-02-21 04:29:59'),
(10, 4, NULL, 'Abhi', 'abhi@gmail.com', 'YZYAHFabhi', '$2y$10$DDb2i0wsh9tNSvMJ7JGomemjeBzzUNBM9PTPuA25DtyQxncSpuZF6', NULL, NULL, '8776787678', NULL, 1, NULL, '2025-02-19 00:46:20', '2025-02-21 04:29:02'),
(11, 1, 1, 'Abhishek', 'abhishek@gmail.com', 'DKYBZHabhi', '$2y$10$pxSExQQ4rKqD82ij9CkcheiFhylxlDq/QLgy6AVyvnx2Vrw0sliCK', NULL, NULL, '98676545674', NULL, 1, NULL, '2025-02-19 00:46:21', '2025-03-10 05:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, '6786badf-5741-45d1-a998-a21736f90d0a', 'database', 'default', '{\"uuid\":\"6786badf-5741-45d1-a998-a21736f90d0a\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";a:3:{s:8:\\\"order_id\\\";s:10:\\\"0000000018\\\";s:18:\\\"grand_total_amount\\\";s:4:\\\"3500\\\";s:11:\\\"order_lines\\\";a:2:{i:0;a:4:{s:10:\\\"product_id\\\";s:3:\\\"322\\\";s:8:\\\"quantity\\\";s:1:\\\"8\\\";s:5:\\\"price\\\";s:1:\\\"0\\\";s:11:\\\"total_price\\\";s:1:\\\"0\\\";}i:1;a:4:{s:10:\\\"product_id\\\";s:3:\\\"140\\\";s:8:\\\"quantity\\\";s:1:\\\"7\\\";s:5:\\\"price\\\";s:3:\\\"500\\\";s:11:\\\"total_price\\\";s:4:\\\"3500\\\";}}}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'InvalidArgumentException: View [frontend.emails.order_details_mail] not found. in C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:137\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(79): Illuminate\\View\\FileViewFinder->findInPaths(\'frontend.emails...\', Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(138): Illuminate\\View\\FileViewFinder->find(\'frontend.emails...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\Factory->make(\'frontend.emails...\', Array)\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.emails...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.emails...\', NULL, NULL, Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.emails...\', Array, Object(Closure))\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 {main}', '2024-12-20 08:19:02'),
(2, 'a12215d9-7fab-4a71-8f3b-017163ba967a', 'database', 'default', '{\"uuid\":\"a12215d9-7fab-4a71-8f3b-017163ba967a\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";a:3:{s:8:\\\"order_id\\\";s:10:\\\"0000000019\\\";s:18:\\\"grand_total_amount\\\";s:4:\\\"3500\\\";s:11:\\\"order_lines\\\";a:2:{i:0;a:4:{s:10:\\\"product_id\\\";s:3:\\\"322\\\";s:8:\\\"quantity\\\";s:1:\\\"8\\\";s:5:\\\"price\\\";s:1:\\\"0\\\";s:11:\\\"total_price\\\";s:1:\\\"0\\\";}i:1;a:4:{s:10:\\\"product_id\\\";s:3:\\\"140\\\";s:8:\\\"quantity\\\";s:1:\\\"7\\\";s:5:\\\"price\\\";s:3:\\\"500\\\";s:11:\\\"total_price\\\";s:4:\\\"3500\\\";}}}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'InvalidArgumentException: View [frontend.emails.order_details_mail] not found. in C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:137\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(79): Illuminate\\View\\FileViewFinder->findInPaths(\'frontend.emails...\', Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(138): Illuminate\\View\\FileViewFinder->find(\'frontend.emails...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\Factory->make(\'frontend.emails...\', Array)\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.emails...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.emails...\', NULL, NULL, Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.emails...\', Array, Object(Closure))\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 {main}', '2024-12-20 08:21:24'),
(3, '420e9e3a-eafd-49b7-bbb8-80bbd27a6c23', 'database', 'default', '{\"uuid\":\"420e9e3a-eafd-49b7-bbb8-80bbd27a6c23\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";a:3:{s:8:\\\"order_id\\\";s:10:\\\"0000000020\\\";s:18:\\\"grand_total_amount\\\";s:4:\\\"3500\\\";s:11:\\\"order_lines\\\";a:2:{i:0;a:4:{s:10:\\\"product_id\\\";s:3:\\\"322\\\";s:8:\\\"quantity\\\";s:1:\\\"8\\\";s:5:\\\"price\\\";s:1:\\\"0\\\";s:11:\\\"total_price\\\";s:1:\\\"0\\\";}i:1;a:4:{s:10:\\\"product_id\\\";s:3:\\\"140\\\";s:8:\\\"quantity\\\";s:1:\\\"7\\\";s:5:\\\"price\\\";s:3:\\\"500\\\";s:11:\\\"total_price\\\";s:4:\\\"3500\\\";}}}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'ErrorException: Trying to get property \'order_id\' of non-object in C:\\xampp\\htdocs\\ecommerce-laravel\\storage\\framework\\views\\0ff25483707cb94f57e33e21740375bb03cb8f4a.php:8\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\storage\\framework\\views\\0ff25483707cb94f57e33e21740375bb03cb8f4a.php(8): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'C:\\\\xampp\\\\htdocs...\', 8, Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(107): require(\'C:\\\\xampp\\\\htdocs...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(108): Illuminate\\Filesystem\\Filesystem::Illuminate\\Filesystem\\{closure}()\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\PhpEngine.php(58): Illuminate\\Filesystem\\Filesystem->getRequire(\'C:\\\\xampp\\\\htdocs...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\CompilerEngine.php(61): Illuminate\\View\\Engines\\PhpEngine->evaluatePath(\'C:\\\\xampp\\\\htdocs...\', Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\facade\\ignition\\src\\Views\\Engines\\CompilerEngine.php(37): Illuminate\\View\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(139): Facade\\Ignition\\Views\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(122): Illuminate\\View\\View->getContents()\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(91): Illuminate\\View\\View->renderContents()\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\View->render()\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.emails...\', Array)\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.emails...\', NULL, NULL, Array)\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.emails...\', Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#50 {main}\n\nNext Facade\\Ignition\\Exceptions\\ViewException: Trying to get property \'order_id\' of non-object (View: C:\\xampp\\htdocs\\ecommerce-laravel\\resources\\views\\frontend\\emails\\order_details_mail.blade.php) in C:\\xampp\\htdocs\\ecommerce-laravel\\resources\\views/frontend/emails/order_details_mail.blade.php:8\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\resources\\views/frontend/emails/order_details_mail.blade.php(8): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'C:\\\\xampp\\\\htdocs...\', 8, Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(107): require(\'C:\\\\xampp\\\\htdocs...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(108): Illuminate\\Filesystem\\Filesystem::Illuminate\\Filesystem\\{closure}()\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\PhpEngine.php(58): Illuminate\\Filesystem\\Filesystem->getRequire(\'C:\\\\xampp\\\\htdocs...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\CompilerEngine.php(61): Illuminate\\View\\Engines\\PhpEngine->evaluatePath(\'C:\\\\xampp\\\\htdocs...\', Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\facade\\ignition\\src\\Views\\Engines\\CompilerEngine.php(37): Illuminate\\View\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(139): Facade\\Ignition\\Views\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(122): Illuminate\\View\\View->getContents()\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(91): Illuminate\\View\\View->renderContents()\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\View->render()\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.emails...\', Array)\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.emails...\', NULL, NULL, Array)\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.emails...\', Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#50 {main}', '2024-12-20 08:22:53');
INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(4, 'fdb43b4a-fa14-492b-9acb-40dfd706f446', 'database', 'default', '{\"uuid\":\"fdb43b4a-fa14-492b-9acb-40dfd706f446\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";a:3:{s:8:\\\"order_id\\\";N;s:18:\\\"grand_total_amount\\\";s:4:\\\"3500\\\";s:11:\\\"order_lines\\\";a:2:{i:0;a:4:{s:10:\\\"product_id\\\";s:3:\\\"322\\\";s:8:\\\"quantity\\\";s:1:\\\"8\\\";s:5:\\\"price\\\";s:1:\\\"0\\\";s:11:\\\"total_price\\\";s:1:\\\"0\\\";}i:1;a:4:{s:10:\\\"product_id\\\";s:3:\\\"140\\\";s:8:\\\"quantity\\\";s:1:\\\"7\\\";s:5:\\\"price\\\";s:3:\\\"500\\\";s:11:\\\"total_price\\\";s:4:\\\"3500\\\";}}}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'ErrorException: Trying to get property \'order_id\' of non-object in C:\\xampp\\htdocs\\ecommerce-laravel\\storage\\framework\\views\\0ff25483707cb94f57e33e21740375bb03cb8f4a.php:8\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\storage\\framework\\views\\0ff25483707cb94f57e33e21740375bb03cb8f4a.php(8): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'C:\\\\xampp\\\\htdocs...\', 8, Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(107): require(\'C:\\\\xampp\\\\htdocs...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(108): Illuminate\\Filesystem\\Filesystem::Illuminate\\Filesystem\\{closure}()\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\PhpEngine.php(58): Illuminate\\Filesystem\\Filesystem->getRequire(\'C:\\\\xampp\\\\htdocs...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\CompilerEngine.php(61): Illuminate\\View\\Engines\\PhpEngine->evaluatePath(\'C:\\\\xampp\\\\htdocs...\', Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\facade\\ignition\\src\\Views\\Engines\\CompilerEngine.php(37): Illuminate\\View\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(139): Facade\\Ignition\\Views\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(122): Illuminate\\View\\View->getContents()\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(91): Illuminate\\View\\View->renderContents()\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\View->render()\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.emails...\', Array)\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.emails...\', NULL, NULL, Array)\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.emails...\', Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#50 {main}\n\nNext Facade\\Ignition\\Exceptions\\ViewException: Trying to get property \'order_id\' of non-object (View: C:\\xampp\\htdocs\\ecommerce-laravel\\resources\\views\\frontend\\emails\\order_details_mail.blade.php) in C:\\xampp\\htdocs\\ecommerce-laravel\\resources\\views/frontend/emails/order_details_mail.blade.php:8\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\resources\\views/frontend/emails/order_details_mail.blade.php(8): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'C:\\\\xampp\\\\htdocs...\', 8, Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(107): require(\'C:\\\\xampp\\\\htdocs...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(108): Illuminate\\Filesystem\\Filesystem::Illuminate\\Filesystem\\{closure}()\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\PhpEngine.php(58): Illuminate\\Filesystem\\Filesystem->getRequire(\'C:\\\\xampp\\\\htdocs...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\CompilerEngine.php(61): Illuminate\\View\\Engines\\PhpEngine->evaluatePath(\'C:\\\\xampp\\\\htdocs...\', Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\facade\\ignition\\src\\Views\\Engines\\CompilerEngine.php(37): Illuminate\\View\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(139): Facade\\Ignition\\Views\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(122): Illuminate\\View\\View->getContents()\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(91): Illuminate\\View\\View->renderContents()\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\View->render()\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.emails...\', Array)\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.emails...\', NULL, NULL, Array)\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.emails...\', Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#50 {main}', '2024-12-20 08:24:49'),
(5, '719dbaaa-d98f-4f81-b85a-6beafccdb937', 'database', 'default', '{\"uuid\":\"719dbaaa-d98f-4f81-b85a-6beafccdb937\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Orders\\\";s:2:\\\"id\\\";i:37;s:9:\\\"relations\\\";a:6:{i:0;s:11:\\\"orderStatus\\\";i:1;s:15:\\\"shippingAddress\\\";i:2;s:14:\\\"billingAddress\\\";i:3;s:10:\\\"orderLines\\\";i:4;s:18:\\\"orderLines.product\\\";i:5;s:25:\\\"orderLines.product.images\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'InvalidArgumentException: View [frontend.mail.order_details_mail] not found. in C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:137\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(79): Illuminate\\View\\FileViewFinder->findInPaths(\'frontend.mail.o...\', Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(138): Illuminate\\View\\FileViewFinder->find(\'frontend.mail.o...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\Factory->make(\'frontend.mail.o...\', Array)\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.mail.o...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.mail.o...\', NULL, NULL, Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.mail.o...\', Array, Object(Closure))\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 {main}', '2024-12-20 08:35:28'),
(6, 'f6a6c698-b4a1-4388-a5b7-6150499bfc7b', 'database', 'default', '{\"uuid\":\"f6a6c698-b4a1-4388-a5b7-6150499bfc7b\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Orders\\\";s:2:\\\"id\\\";i:38;s:9:\\\"relations\\\";a:6:{i:0;s:11:\\\"orderStatus\\\";i:1;s:15:\\\"shippingAddress\\\";i:2;s:14:\\\"billingAddress\\\";i:3;s:10:\\\"orderLines\\\";i:4;s:18:\\\"orderLines.product\\\";i:5;s:25:\\\"orderLines.product.images\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'InvalidArgumentException: View [frontend.mail.order_details_mail] not found. in C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:137\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(79): Illuminate\\View\\FileViewFinder->findInPaths(\'frontend.mail.o...\', Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(138): Illuminate\\View\\FileViewFinder->find(\'frontend.mail.o...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\Factory->make(\'frontend.mail.o...\', Array)\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.mail.o...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.mail.o...\', NULL, NULL, Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.mail.o...\', Array, Object(Closure))\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 {main}', '2024-12-20 08:35:40');
INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(7, 'a95c2916-0229-4d2c-a4f8-bb443d606451', 'database', 'default', '{\"uuid\":\"a95c2916-0229-4d2c-a4f8-bb443d606451\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Orders\\\";s:2:\\\"id\\\";i:39;s:9:\\\"relations\\\";a:6:{i:0;s:11:\\\"orderStatus\\\";i:1;s:15:\\\"shippingAddress\\\";i:2;s:14:\\\"billingAddress\\\";i:3;s:10:\\\"orderLines\\\";i:4;s:18:\\\"orderLines.product\\\";i:5;s:25:\\\"orderLines.product.images\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'InvalidArgumentException: View [frontend.mail.order_details_mail] not found. in C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:137\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(79): Illuminate\\View\\FileViewFinder->findInPaths(\'frontend.mail.o...\', Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(138): Illuminate\\View\\FileViewFinder->find(\'frontend.mail.o...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\Factory->make(\'frontend.mail.o...\', Array)\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.mail.o...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.mail.o...\', NULL, NULL, Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.mail.o...\', Array, Object(Closure))\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 {main}', '2024-12-20 08:36:23'),
(8, '116a42cd-5765-4e07-8bc5-f7b267606423', 'database', 'default', '{\"uuid\":\"116a42cd-5765-4e07-8bc5-f7b267606423\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Orders\\\";s:2:\\\"id\\\";i:40;s:9:\\\"relations\\\";a:6:{i:0;s:11:\\\"orderStatus\\\";i:1;s:15:\\\"shippingAddress\\\";i:2;s:14:\\\"billingAddress\\\";i:3;s:10:\\\"orderLines\\\";i:4;s:18:\\\"orderLines.product\\\";i:5;s:25:\\\"orderLines.product.images\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'InvalidArgumentException: View [frontend.mail.order_details_mail] not found. in C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:137\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(79): Illuminate\\View\\FileViewFinder->findInPaths(\'frontend.mail.o...\', Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(138): Illuminate\\View\\FileViewFinder->find(\'frontend.mail.o...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\Factory->make(\'frontend.mail.o...\', Array)\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.mail.o...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.mail.o...\', NULL, NULL, Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.mail.o...\', Array, Object(Closure))\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 {main}', '2024-12-20 08:37:35'),
(9, '500b4523-79f0-4d1e-b8b9-6903c50a29b5', 'database', 'default', '{\"uuid\":\"500b4523-79f0-4d1e-b8b9-6903c50a29b5\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Orders\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:6:{i:0;s:11:\\\"orderStatus\\\";i:1;s:15:\\\"shippingAddress\\\";i:2;s:14:\\\"billingAddress\\\";i:3;s:10:\\\"orderLines\\\";i:4;s:18:\\\"orderLines.product\\\";i:5;s:25:\\\"orderLines.product.images\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'InvalidArgumentException: View [frontend.mail.order_details_mail] not found. in C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:137\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(79): Illuminate\\View\\FileViewFinder->findInPaths(\'frontend.mail.o...\', Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(138): Illuminate\\View\\FileViewFinder->find(\'frontend.mail.o...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\Factory->make(\'frontend.mail.o...\', Array)\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.mail.o...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.mail.o...\', NULL, NULL, Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.mail.o...\', Array, Object(Closure))\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 {main}', '2024-12-20 08:38:32');
INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(10, '9ae1cb07-23a9-43a3-8282-5024f93a1238', 'database', 'default', '{\"uuid\":\"9ae1cb07-23a9-43a3-8282-5024f93a1238\",\"displayName\":\"App\\\\Mail\\\\AdminResetPasswordMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:31:\\\"App\\\\Mail\\\\AdminResetPasswordMail\\\":29:{s:4:\\\"data\\\";a:1:{s:5:\\\"token\\\";s:64:\\\"uDii1U0u9v8pFnvCkOYNM342rIfwYhgWR3RY4fjMZ6v1bB4HnAkrZJe0QbLd7lDp\\\";}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'ErrorException: Undefined index: email in C:\\xampp\\htdocs\\ecommerce-laravel\\storage\\framework\\views\\4ae393a02cad8000e2ec08287a3d2c426dbbd1ce.php:4\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\storage\\framework\\views\\4ae393a02cad8000e2ec08287a3d2c426dbbd1ce.php(4): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined index...\', \'C:\\\\xampp\\\\htdocs...\', 4, Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(107): require(\'C:\\\\xampp\\\\htdocs...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(108): Illuminate\\Filesystem\\Filesystem::Illuminate\\Filesystem\\{closure}()\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\PhpEngine.php(58): Illuminate\\Filesystem\\Filesystem->getRequire(\'C:\\\\xampp\\\\htdocs...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\CompilerEngine.php(61): Illuminate\\View\\Engines\\PhpEngine->evaluatePath(\'C:\\\\xampp\\\\htdocs...\', Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\facade\\ignition\\src\\Views\\Engines\\CompilerEngine.php(37): Illuminate\\View\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(139): Facade\\Ignition\\Views\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(122): Illuminate\\View\\View->getContents()\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(91): Illuminate\\View\\View->renderContents()\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\View->render()\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'backend.mail.fo...\', Array)\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'backend.mail.fo...\', NULL, NULL, Array)\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'backend.mail.fo...\', Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(118): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#50 {main}\n\nNext Facade\\Ignition\\Exceptions\\ViewException: Undefined index: email (View: C:\\xampp\\htdocs\\ecommerce-laravel\\resources\\views\\backend\\mail\\forget-password.blade.php) in C:\\xampp\\htdocs\\ecommerce-laravel\\resources\\views/backend/mail/forget-password.blade.php:4\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce-laravel\\resources\\views/backend/mail/forget-password.blade.php(4): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined index...\', \'C:\\\\xampp\\\\htdocs...\', 4, Array)\n#1 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(107): require(\'C:\\\\xampp\\\\htdocs...\')\n#2 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(108): Illuminate\\Filesystem\\Filesystem::Illuminate\\Filesystem\\{closure}()\n#3 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\PhpEngine.php(58): Illuminate\\Filesystem\\Filesystem->getRequire(\'C:\\\\xampp\\\\htdocs...\', Array)\n#4 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\CompilerEngine.php(61): Illuminate\\View\\Engines\\PhpEngine->evaluatePath(\'C:\\\\xampp\\\\htdocs...\', Array)\n#5 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\facade\\ignition\\src\\Views\\Engines\\CompilerEngine.php(37): Illuminate\\View\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#6 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(139): Facade\\Ignition\\Views\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#7 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(122): Illuminate\\View\\View->getContents()\n#8 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(91): Illuminate\\View\\View->renderContents()\n#9 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\View->render()\n#10 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'backend.mail.fo...\', Array)\n#11 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'backend.mail.fo...\', NULL, NULL, Array)\n#12 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'backend.mail.fo...\', Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#14 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#15 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#16 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#17 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#26 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#28 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#30 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(118): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\ecommerce-laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp\\htdocs\\ecommerce-laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#50 {main}', '2025-02-13 03:11:26'),
(11, '7c47d22f-85a8-44d6-aaae-87972825af20', 'database', 'default', '{\"uuid\":\"7c47d22f-85a8-44d6-aaae-87972825af20\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Orders\\\";s:2:\\\"id\\\";i:57;s:9:\\\"relations\\\";a:6:{i:0;s:11:\\\"orderStatus\\\";i:1;s:15:\\\"shippingAddress\\\";i:2;s:14:\\\"billingAddress\\\";i:3;s:10:\\\"orderLines\\\";i:4;s:18:\\\"orderLines.product\\\";i:5;s:25:\\\"orderLines.product.images\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:29:\\\"rahulkumarmaurya464@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'ErrorException: Trying to get property \'full_name\' of non-object in C:\\xampp\\htdocs\\gd_sons_laravel\\storage\\framework\\views\\3899a3a30612b7bdfccbbb844ad67e5d61602ad5.php:192\nStack trace:\n#0 C:\\xampp\\htdocs\\gd_sons_laravel\\storage\\framework\\views\\3899a3a30612b7bdfccbbb844ad67e5d61602ad5.php(192): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'C:\\\\xampp\\\\htdocs...\', 192, Array)\n#1 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(107): require(\'C:\\\\xampp\\\\htdocs...\')\n#2 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(108): Illuminate\\Filesystem\\Filesystem::Illuminate\\Filesystem\\{closure}()\n#3 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\PhpEngine.php(58): Illuminate\\Filesystem\\Filesystem->getRequire(\'C:\\\\xampp\\\\htdocs...\', Array)\n#4 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\CompilerEngine.php(61): Illuminate\\View\\Engines\\PhpEngine->evaluatePath(\'C:\\\\xampp\\\\htdocs...\', Array)\n#5 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\facade\\ignition\\src\\Views\\Engines\\CompilerEngine.php(37): Illuminate\\View\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#6 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(139): Facade\\Ignition\\Views\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#7 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(122): Illuminate\\View\\View->getContents()\n#8 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(91): Illuminate\\View\\View->renderContents()\n#9 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\View->render()\n#10 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.emails...\', Array)\n#11 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.emails...\', NULL, NULL, Array)\n#12 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.emails...\', Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#14 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#15 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#16 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#17 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#26 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#28 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#30 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(118): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp\\htdocs\\gd_sons_laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#50 {main}\n\nNext Facade\\Ignition\\Exceptions\\ViewException: Trying to get property \'full_name\' of non-object (View: C:\\xampp\\htdocs\\gd_sons_laravel\\resources\\views\\frontend\\emails\\order_details_mail.blade.php) in C:\\xampp\\htdocs\\gd_sons_laravel\\resources\\views/frontend/emails/order_details_mail.blade.php:192\nStack trace:\n#0 C:\\xampp\\htdocs\\gd_sons_laravel\\resources\\views/frontend/emails/order_details_mail.blade.php(192): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'C:\\\\xampp\\\\htdocs...\', 192, Array)\n#1 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(107): require(\'C:\\\\xampp\\\\htdocs...\')\n#2 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(108): Illuminate\\Filesystem\\Filesystem::Illuminate\\Filesystem\\{closure}()\n#3 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\PhpEngine.php(58): Illuminate\\Filesystem\\Filesystem->getRequire(\'C:\\\\xampp\\\\htdocs...\', Array)\n#4 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\CompilerEngine.php(61): Illuminate\\View\\Engines\\PhpEngine->evaluatePath(\'C:\\\\xampp\\\\htdocs...\', Array)\n#5 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\facade\\ignition\\src\\Views\\Engines\\CompilerEngine.php(37): Illuminate\\View\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#6 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(139): Facade\\Ignition\\Views\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#7 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(122): Illuminate\\View\\View->getContents()\n#8 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(91): Illuminate\\View\\View->renderContents()\n#9 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\View->render()\n#10 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.emails...\', Array)\n#11 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.emails...\', NULL, NULL, Array)\n#12 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.emails...\', Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#14 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#15 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#16 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#17 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#26 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#28 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#30 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(118): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp\\htdocs\\gd_sons_laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#50 {main}', '2025-03-11 03:08:20');
INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(12, '782b035a-a26a-42f4-9d99-0de0543a78ab', 'database', 'default', '{\"uuid\":\"782b035a-a26a-42f4-9d99-0de0543a78ab\",\"displayName\":\"App\\\\Mail\\\\OrderDetailsMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:25:\\\"App\\\\Mail\\\\OrderDetailsMail\\\":29:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:17:\\\"App\\\\Models\\\\Orders\\\";s:2:\\\"id\\\";i:57;s:9:\\\"relations\\\";a:6:{i:0;s:11:\\\"orderStatus\\\";i:1;s:15:\\\"shippingAddress\\\";i:2;s:14:\\\"billingAddress\\\";i:3;s:10:\\\"orderLines\\\";i:4;s:18:\\\"orderLines.product\\\";i:5;s:25:\\\"orderLines.product.images\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:19:\\\"akshat@gdsons.co.in\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:7:\\\"subject\\\";N;s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 'ErrorException: Trying to get property \'full_name\' of non-object in C:\\xampp\\htdocs\\gd_sons_laravel\\storage\\framework\\views\\3899a3a30612b7bdfccbbb844ad67e5d61602ad5.php:192\nStack trace:\n#0 C:\\xampp\\htdocs\\gd_sons_laravel\\storage\\framework\\views\\3899a3a30612b7bdfccbbb844ad67e5d61602ad5.php(192): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'C:\\\\xampp\\\\htdocs...\', 192, Array)\n#1 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(107): require(\'C:\\\\xampp\\\\htdocs...\')\n#2 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(108): Illuminate\\Filesystem\\Filesystem::Illuminate\\Filesystem\\{closure}()\n#3 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\PhpEngine.php(58): Illuminate\\Filesystem\\Filesystem->getRequire(\'C:\\\\xampp\\\\htdocs...\', Array)\n#4 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\CompilerEngine.php(61): Illuminate\\View\\Engines\\PhpEngine->evaluatePath(\'C:\\\\xampp\\\\htdocs...\', Array)\n#5 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\facade\\ignition\\src\\Views\\Engines\\CompilerEngine.php(37): Illuminate\\View\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#6 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(139): Facade\\Ignition\\Views\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#7 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(122): Illuminate\\View\\View->getContents()\n#8 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(91): Illuminate\\View\\View->renderContents()\n#9 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\View->render()\n#10 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.emails...\', Array)\n#11 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.emails...\', NULL, NULL, Array)\n#12 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.emails...\', Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#14 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#15 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#16 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#17 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#26 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#28 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#30 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(118): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp\\htdocs\\gd_sons_laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#50 {main}\n\nNext Facade\\Ignition\\Exceptions\\ViewException: Trying to get property \'full_name\' of non-object (View: C:\\xampp\\htdocs\\gd_sons_laravel\\resources\\views\\frontend\\emails\\order_details_mail.blade.php) in C:\\xampp\\htdocs\\gd_sons_laravel\\resources\\views/frontend/emails/order_details_mail.blade.php:192\nStack trace:\n#0 C:\\xampp\\htdocs\\gd_sons_laravel\\resources\\views/frontend/emails/order_details_mail.blade.php(192): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'C:\\\\xampp\\\\htdocs...\', 192, Array)\n#1 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(107): require(\'C:\\\\xampp\\\\htdocs...\')\n#2 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php(108): Illuminate\\Filesystem\\Filesystem::Illuminate\\Filesystem\\{closure}()\n#3 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\PhpEngine.php(58): Illuminate\\Filesystem\\Filesystem->getRequire(\'C:\\\\xampp\\\\htdocs...\', Array)\n#4 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Engines\\CompilerEngine.php(61): Illuminate\\View\\Engines\\PhpEngine->evaluatePath(\'C:\\\\xampp\\\\htdocs...\', Array)\n#5 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\facade\\ignition\\src\\Views\\Engines\\CompilerEngine.php(37): Illuminate\\View\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#6 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(139): Facade\\Ignition\\Views\\Engines\\CompilerEngine->get(\'C:\\\\xampp\\\\htdocs...\', Array)\n#7 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(122): Illuminate\\View\\View->getContents()\n#8 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\View\\View.php(91): Illuminate\\View\\View->renderContents()\n#9 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(382): Illuminate\\View\\View->render()\n#10 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(355): Illuminate\\Mail\\Mailer->renderView(\'frontend.emails...\', Array)\n#11 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(273): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'frontend.emails...\', NULL, NULL, Array)\n#12 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(187): Illuminate\\Mail\\Mailer->send(\'frontend.emails...\', Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#14 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(188): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#15 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(65): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#16 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#17 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#26 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#28 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(122): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#30 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(428): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(378): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(172): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(118): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(653): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Command\\Command.php(298): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(1040): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(301): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\symfony\\console\\Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(94): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\gd_sons_laravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp\\htdocs\\gd_sons_laravel\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#50 {main}', '2025-03-11 03:08:20');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `groups_category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `groups_category_id`, `name`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Wizards Employees', 0, NULL, '2025-01-02 04:17:37', '2025-01-02 04:35:12'),
(2, 1, 'Gd Sons Employees', 1, NULL, '2025-01-02 04:44:38', '2025-01-02 04:44:38'),
(3, 4, 'Family Employees', 1, NULL, '2025-01-02 04:45:12', '2025-01-03 03:40:33');

-- --------------------------------------------------------

--
-- Table structure for table `groups_categories`
--

CREATE TABLE `groups_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_category_percentage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups_categories`
--

INSERT INTO `groups_categories` (`id`, `name`, `status`, `description`, `created_at`, `updated_at`, `group_category_percentage`) VALUES
(1, 'A', 1, NULL, '2025-01-02 02:01:43', '2025-01-03 05:24:26', '3.33'),
(4, 'C', 1, NULL, '2025-01-02 02:05:16', '2025-03-11 23:11:38', '2.5');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `mrp` decimal(50,0) DEFAULT NULL,
  `purchase_rate` decimal(50,0) DEFAULT NULL,
  `offer_rate` decimal(50,0) DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `product_id`, `mrp`, `purchase_rate`, `offer_rate`, `sku`, `stock_quantity`, `created_at`, `updated_at`) VALUES
(222, 315, '3440', '2000', '3000', 'SKU-674EB81D41B9B', 3, NULL, '2024-12-04 04:35:37'),
(225, 314, '2659', '2000', '2400', 'SKU-674FE1B53FDF6', 3, NULL, '2024-12-04 04:57:47'),
(228, 316, '9270', '6000', '7200', 'SKU-674FE8FF6CB5E', 4, NULL, '2024-12-04 05:03:46'),
(229, 140, '1300', '780', '1040', 'SKU-6757FD5922E10', 10, NULL, '2025-01-03 05:23:40'),
(230, 323, '1300', '780', '1040', 'SKU-67779F2A526F6', 4, NULL, NULL),
(233, 139, '1000', '750', '800', NULL, 6, '2025-01-15 01:37:26', '2025-01-27 04:36:37'),
(234, 139, '1500', '1350', '1400', NULL, 4, '2025-01-15 01:37:26', '2025-01-27 04:36:37'),
(235, 223, '12', '12', '12', 'SKU-6797566E0D594', 3, NULL, '2025-01-27 04:33:06'),
(236, 223, '23', '23', '23', 'SKU-ZL8R1POKFJ', 5, NULL, '2025-01-27 04:33:06'),
(237, 223, '45', '55', '50', 'SKU-TFON9HF34M', 7, NULL, NULL),
(238, 139, '344', '3445', '1895', 'SKU-HJP7D47F9WM', 6, NULL, NULL),
(239, 293, '12', '12', '12', 'SKU-67975BC4CC5A3', 1, NULL, NULL),
(240, 283, '232', '23', '128', 'SKU-67975BE230CCA', 2, NULL, NULL),
(241, 284, '12', '12', '12', 'SKU-67975C3F08EB7', 0, NULL, '2025-02-12 01:31:47'),
(242, 274, '1200', '1000', '1100', 'SKU-67975CC65F052', 6, NULL, '2025-03-11 23:14:21'),
(243, 273, '12', '12', '12', 'SKU-67975D0087598', -2, NULL, '2025-01-29 01:30:36');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `label`
--

CREATE TABLE `label` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Status of the item',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `label`
--

INSERT INTO `label` (`id`, `title`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(3, 'New Arrivals', 'new-arrivals', 'on', '2024-10-10 02:49:00', '2024-10-10 03:09:12'),
(4, 'Popular Product', 'popular-product', 'on', '2025-01-24 02:21:18', '2025-01-24 02:21:18'),
(5, 'Trending Product', 'trending-product', 'on', '2025-01-24 02:22:00', '2025-01-24 02:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `landing_pages`
--

CREATE TABLE `landing_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landing_pages`
--

INSERT INTO `landing_pages` (`id`, `title`, `page_url`, `image_path`, `status`, `created_at`, `updated_at`) VALUES
(5, 'The update method handles the update logic for the landing page,', 'http://127.0.0.1:8000/manage-landing-page/create', 'the-update-method-handles-the-update-logic-for-the-landing-page-1739173398.webp', 1, '2025-02-10 01:28:17', '2025-02-10 02:13:18'),
(6, 'This will check if $landingPage is not null or false.', 'http://127.0.0.1:8000/manage-landing-page/create', 'this-will-check-if-landingpage-is-not-null-or-false-1739173386.webp', 1, '2025-02-10 01:46:11', '2025-02-10 02:13:06'),
(7, 'This method will be triggered when you submit', 'http://127.0.0.1:8000/manage-landing-page/create', 'this-method-will-be-triggered-when-you-submit-1739173375.webp', 1, '2025-02-10 01:46:31', '2025-02-10 02:12:56'),
(8, 'The syntax in your @if statement is', 'http://127.0.0.1:8000/manage-landing-page/create', 'the-syntax-in-your-at-if-statement-is-1739173367.webp', 1, '2025-02-10 01:47:11', '2025-02-10 02:12:47'),
(9, 'Let me know if you need further help with this!', 'http://127.0.0.1:8000/manage-landing-page/create', 'let-me-know-if-you-need-further-help-with-this-1739173358.webp', 1, '2025-02-10 01:47:31', '2025-02-10 02:12:38'),
(10, 'Bootstrap includes a wide range of shorthand responsive margin', 'https://getbootstrap.com/docs/4.0/utilities/spacing/', 'bootstrap-includes-a-wide-range-of-shorthand-responsive-margin-1739173496.webp', 1, '2025-02-10 02:14:56', '2025-02-10 02:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `mapped_category_to_attributes_for_front`
--

CREATE TABLE `mapped_category_to_attributes_for_front` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `attributes_id` int(10) UNSIGNED NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mapped_category_to_attributes_for_front`
--

INSERT INTO `mapped_category_to_attributes_for_front` (`id`, `category_id`, `attributes_id`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(3, 10, 22, 1, 1, '2024-12-04 04:05:31', '2024-12-04 04:05:31'),
(4, 6, 18, 1, 1, '2024-12-04 04:06:03', '2024-12-04 04:06:03'),
(6, 4, 20, 1, 1, '2024-12-04 08:27:28', '2024-12-04 08:27:28'),
(7, 4, 21, 1, 1, '2024-12-04 08:27:28', '2024-12-04 08:27:28'),
(8, 5, 18, 1, 1, '2024-12-05 06:15:31', '2024-12-05 06:15:31'),
(9, 5, 22, 1, 1, '2024-12-05 06:15:31', '2024-12-05 06:15:31'),
(10, 10, 18, 1, 1, '2024-12-05 06:16:05', '2024-12-05 06:16:05'),
(11, 10, 20, 1, 1, '2024-12-05 06:16:05', '2024-12-05 06:16:05');

-- --------------------------------------------------------

--
-- Table structure for table `map_attributes_values_to_category`
--

CREATE TABLE `map_attributes_values_to_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `attributes_value_id` int(10) UNSIGNED NOT NULL,
  `attributes_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `map_attributes_values_to_category`
--

INSERT INTO `map_attributes_values_to_category` (`id`, `category_id`, `attributes_value_id`, `attributes_id`, `created_at`, `updated_at`) VALUES
(377, 4, 87, 19, '2024-12-02 07:13:20', '2024-12-02 07:13:20'),
(379, 4, 88, 21, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(380, 4, 89, 24, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(386, 4, 92, 21, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(387, 4, 93, 19, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(388, 4, 94, 19, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(389, 4, 95, 19, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(390, 4, 96, 19, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(392, 4, 97, 21, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(394, 4, 64, 21, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(395, 4, 68, 21, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(396, 4, 98, 21, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(397, 4, 99, 21, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(398, 4, 63, 21, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(399, 4, 100, 21, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(400, 4, 73, 21, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(401, 4, 101, 19, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(402, 4, 102, 21, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(403, 4, 103, 21, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(404, 4, 104, 21, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(405, 4, 67, 19, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(406, 4, 105, 21, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(407, 4, 75, 21, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(408, 4, 97, 21, '2024-12-02 07:13:29', '2024-12-02 07:24:25'),
(410, 10, 108, 19, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(412, 10, 109, 22, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(416, 10, 61, 19, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(417, 10, 111, 19, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(419, 10, 113, 19, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(422, 10, 95, 19, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(425, 10, 118, 19, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(426, 10, 119, 22, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(427, 10, 120, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(428, 10, 121, 22, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(429, 10, 122, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(431, 10, 124, 20, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(433, 10, 125, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(434, 10, 126, 20, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(435, 10, 127, 22, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(437, 10, 129, 22, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(438, 10, 130, 22, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(439, 10, 94, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(440, 10, 131, 22, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(441, 10, 132, 22, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(442, 10, 133, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(443, 10, 134, 22, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(444, 10, 135, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(446, 10, 136, 22, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(447, 10, 62, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(448, 10, 60, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(450, 10, 137, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(451, 10, 138, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(452, 10, 139, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(453, 10, 140, 20, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(454, 10, 141, 22, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(455, 10, 142, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(457, 10, 144, 19, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(460, 10, 147, 19, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(461, 10, 148, 19, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(462, 10, 149, 22, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(463, 10, 150, 22, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(464, 10, 151, 19, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(465, 10, 152, 24, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(468, 10, 154, 22, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(471, 6, 157, 22, '2024-12-03 23:37:09', '2024-12-03 23:37:09'),
(477, 6, 162, 19, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(485, 10, 67, 19, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(495, 5, 166, 22, '2024-12-05 05:32:27', '2024-12-05 05:32:27'),
(516, 10, 57, NULL, NULL, NULL),
(517, 4, 57, NULL, NULL, NULL),
(518, 10, 65, NULL, NULL, NULL),
(519, 4, 65, NULL, NULL, NULL),
(520, 10, 72, NULL, NULL, NULL),
(521, 4, 72, NULL, NULL, NULL),
(523, 4, 59, 19, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(528, 4, 60, 19, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(532, 4, 55, 18, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(533, 4, 61, 19, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(534, 4, 57, 20, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(535, 4, 90, 21, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(536, 4, 146, 24, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(538, 10, 145, 19, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(541, 10, 146, 24, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(548, 5, 168, 19, '2025-01-24 02:23:15', '2025-01-24 02:23:15'),
(551, 5, 167, 19, '2025-01-24 02:23:34', '2025-01-24 02:23:34'),
(552, 6, 163, 18, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(553, 6, 160, 19, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(554, 6, 156, 22, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(555, 6, 164, 23, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(556, 6, 159, 18, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(557, 6, 108, 19, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(558, 6, 158, 22, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(559, 6, 161, 23, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(561, 10, 155, 19, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(576, 10, 115, 19, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(577, 10, 81, 20, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(578, 10, 112, 22, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(581, 10, 123, 19, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(583, 10, 153, 22, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(586, 10, 59, 19, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(587, 10, 128, 20, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(588, 10, 110, 22, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(589, 10, 84, 24, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(590, 10, 107, 18, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(591, 10, 143, 19, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(592, 10, 72, 20, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(593, 10, 114, 22, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(596, 10, 116, 19, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(597, 10, 65, 20, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(598, 10, 117, 22, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(599, 10, 89, 24, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(600, 5, 165, 22, '2025-01-24 03:28:04', '2025-01-24 03:28:04'),
(601, 5, 69, 18, '2025-01-24 03:28:04', '2025-01-24 03:28:04'),
(602, 5, 169, 19, '2025-01-24 03:28:04', '2025-01-24 03:28:04'),
(603, 5, 170, 21, '2025-01-24 03:28:04', '2025-01-24 03:28:04'),
(604, 11, 81, NULL, NULL, NULL),
(605, 11, 109, NULL, NULL, NULL),
(606, 11, 110, NULL, NULL, NULL),
(607, 10, 57, NULL, '2025-02-06 14:03:24', '2025-02-06 14:03:24'),
(613, 10, 57, 20, '2025-02-06 14:08:38', '2025-02-06 14:08:38'),
(614, 10, 55, 18, '2025-02-06 14:08:38', '2025-02-06 14:08:38'),
(615, 10, 171, 24, '2025-02-06 14:08:38', '2025-02-06 14:08:38'),
(616, 10, 172, 21, '2025-02-06 14:08:38', '2025-02-06 14:08:38'),
(617, 10, 173, 22, '2025-02-06 14:08:38', '2025-02-06 14:08:38'),
(618, 10, 174, 23, '2025-02-06 14:08:38', '2025-02-06 14:08:38'),
(619, 10, 175, 19, '2025-02-06 14:08:38', '2025-02-06 14:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `map_category_attributes`
--

CREATE TABLE `map_category_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `attribute_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `map_category_attributes`
--

INSERT INTO `map_category_attributes` (`id`, `category_id`, `attribute_id`, `created_at`, `updated_at`) VALUES
(74, 10, 18, '2024-12-02 06:15:42', '2024-12-02 06:15:42'),
(75, 10, 19, '2024-12-02 06:15:42', '2024-12-02 06:15:42'),
(76, 10, 20, '2024-12-02 06:15:42', '2024-12-02 06:15:42'),
(77, 10, 22, '2024-12-02 06:15:42', '2024-12-02 06:15:42'),
(78, 10, 24, '2024-12-02 06:15:42', '2024-12-02 06:15:42'),
(79, 4, 18, '2024-12-02 06:15:49', '2024-12-02 06:15:49'),
(80, 4, 19, '2024-12-02 06:15:49', '2024-12-02 06:15:49'),
(81, 4, 20, '2024-12-02 06:15:49', '2024-12-02 06:15:49'),
(82, 4, 21, '2024-12-02 06:15:49', '2024-12-02 06:15:49'),
(83, 4, 24, '2024-12-02 06:15:49', '2024-12-02 06:15:49'),
(87, 6, 18, '2024-12-03 23:38:56', '2024-12-03 23:38:56'),
(88, 6, 19, '2024-12-03 23:38:56', '2024-12-03 23:38:56'),
(89, 6, 22, '2024-12-03 23:38:56', '2024-12-03 23:38:56'),
(90, 6, 23, '2024-12-03 23:38:56', '2024-12-03 23:38:56'),
(94, 11, 18, '2025-02-01 13:10:15', '2025-02-01 13:10:15'),
(95, 11, 20, '2025-02-01 13:10:15', '2025-02-01 13:10:15'),
(96, 11, 22, '2025-02-01 13:10:15', '2025-02-01 13:10:15'),
(105, 12, 18, '2025-02-12 00:31:39', '2025-02-12 00:31:39'),
(106, 12, 19, '2025-02-12 00:31:39', '2025-02-12 00:31:39'),
(107, 12, 21, '2025-02-12 00:31:39', '2025-02-12 00:31:39'),
(108, 12, 22, '2025-02-12 00:31:40', '2025-02-12 00:31:40'),
(109, 5, 18, '2025-02-12 00:33:03', '2025-02-12 00:33:03'),
(110, 5, 19, '2025-02-12 00:33:03', '2025-02-12 00:33:03'),
(111, 5, 22, '2025-02-12 00:33:03', '2025-02-12 00:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `url`, `icon`, `parent_id`, `created_at`, `updated_at`) VALUES
(0, 'Item', 'manage-item', NULL, 10, NULL, NULL),
(1, 'Dashboard', 'dashboard', 'solar:widget-5-bold-duotone', NULL, '2024-10-04 03:29:35', '2024-10-04 03:29:35'),
(2, 'Products', NULL, 'solar:t-shirt-bold-duotone', NULL, '2024-10-04 03:29:35', '2024-10-04 03:29:35'),
(3, 'Brand', 'brand', 'solar:t-shirt-bold-duotone', 2, '2024-10-04 03:29:35', '2024-10-04 03:29:35'),
(4, 'Label', 'label', NULL, 2, '2024-10-04 03:29:35', '2024-10-04 03:29:35'),
(5, 'Main Category', 'category', NULL, 2, '2024-10-04 18:30:00', '2024-10-04 18:30:00'),
(6, 'Sub Category', 'subcategory', NULL, 2, '2024-10-04 18:30:00', '2024-10-04 18:30:00'),
(7, 'Product', 'product', NULL, 2, '2024-10-04 18:30:00', '2024-10-04 18:30:00'),
(8, 'Attributes', 'attributes', NULL, 2, NULL, NULL),
(9, 'Manage Inventory', 'manage-inventory', 'solar:box-bold-duotone', NULL, '2024-11-14 18:30:00', '2024-11-14 18:30:00'),
(10, 'Manage Purchase', NULL, 'solar:card-send-bold-duotone', NULL, NULL, NULL),
(11, 'Vendor', 'manage-vendor', NULL, 10, NULL, NULL),
(12, 'Item', 'manage-item', NULL, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_permission`
--

CREATE TABLE `menu_permission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_permission`
--

INSERT INTO `menu_permission` (`id`, `menu_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(0, 11, 29, NULL, NULL),
(1, 1, 28, '2024-10-04 18:30:00', '2024-10-04 18:30:00'),
(2, 4, 29, '2024-10-04 18:30:00', '2024-10-04 18:30:00'),
(3, 2, 29, '2024-10-04 18:30:00', '2024-10-04 18:30:00'),
(4, 3, 29, '2024-10-04 18:30:00', '2024-10-04 18:30:00'),
(5, 5, 29, '2024-10-04 18:30:00', '2024-10-04 18:30:00'),
(14, 6, 29, '2024-10-04 18:30:00', '2024-10-04 18:30:00'),
(18, 7, 29, '2024-10-04 18:30:00', '2024-10-04 18:30:00'),
(19, 8, 29, NULL, NULL),
(20, 9, 29, NULL, NULL),
(21, 10, 29, NULL, NULL),
(22, 12, 29, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_role`
--

CREATE TABLE `menu_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_role`
--

INSERT INTO `menu_role` (`id`, `menu_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 10, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_10_02_142108_create_permission_tables', 1),
(6, '2024_10_04_084119_menus', 1),
(7, '2024_10_04_084819_create_menu_role_table', 1),
(8, '2024_10_04_084901_create_menu_permission_table', 1),
(9, '2024_10_09_045719_create_brand_table', 1),
(10, '2024_10_10_063403_create_label_table', 1),
(11, '2024_10_10_084703_create_category_table', 1),
(21, '2024_10_14_085503_create_attributes_table', 4),
(22, '2024_10_14_105019_create_attributes_value_table', 4),
(26, '2024_10_11_061330_create_sub_category_table', 5),
(28, '2024_10_15_053533_create_products_table', 6),
(29, '2024_10_22_145600_create_product_attributes_table', 7),
(30, '2024_10_22_150544_create_product_attributes_values_table', 8),
(32, '2024_10_22_151726_create_product_images_table', 9),
(33, '2024_10_22_152739_add_new_column_to_products_table', 10),
(34, '2024_10_23_142137_add_new_field_to_attributes_value_table', 11),
(35, '2024_10_26_053541_create_map_category_attributes_table', 12),
(36, '2024_10_27_141400_create_map_attributes_values_to_category_table', 13),
(38, '2024_11_08_060518_add_gender_and_address_to_users_table', 14),
(39, '2024_11_08_061027_create_user_logins_table', 15),
(40, '2024_11_12_053117_create_additional_features_table', 16),
(41, '2024_11_12_053620_create_product_additional_features_table', 16),
(42, '2024_11_15_090429_create_inventory_table', 17),
(43, '2024_11_15_091435_add_sku_column_to_inventory_table', 18),
(44, '2024_11_16_053544_update_inventories_table', 19),
(45, '2024_11_19_075022_add_new_column_to_category_table', 20),
(47, '2024_11_20_050148_create_vendors_table', 21),
(51, '2024_11_22_044700_create_vendor_purchase_bills_table', 22),
(52, '2024_11_22_045153_create_vendor_purchase_lines_table', 22),
(53, '2024_11_22_104046_add_new_field_to_products_table', 23),
(54, '2024_11_22_111308_add_new_field_2_to_products_table', 24),
(55, '2024_11_26_044142_add_new_column_to_map_attributes_values_to_category_table', 25),
(56, '2024_11_26_081040_create_update_hsn_gst_with_attributes_table', 25),
(57, '2024_11_29_051937_add_column_to_vendor_purchase_lines_table', 26),
(58, '2024_11_30_105811_add_new_columns_to_vendor_purchase_lines_table', 27),
(59, '2024_11_30_110234_add_new_columns_to_vendor_purchase_bills_table', 27),
(60, '2024_12_03_100709_add_title_index_to_products_table', 28),
(61, '2024_12_04_075329_create_mapped_category_to_attributes_for_front_table', 29),
(62, '2024_12_12_110241_create_customers_table', 30),
(63, '2024_12_13_101848_create_carts_table', 31),
(64, '2024_12_13_102236_create_wishlists_table', 31),
(65, '2024_12_18_080647_create_addresses_table', 32),
(66, '2024_12_19_080404_create_order_status_table', 33),
(67, '2024_12_19_081835_create_billing_addresses_table', 34),
(68, '2024_12_19_082346_create_shipping_addresses_table', 34),
(69, '2024_12_19_085434_create_orders_table', 35),
(70, '2024_12_19_091502_create_order_lines_table', 36),
(72, '2024_12_20_110741_create_jobs_table', 37),
(75, '2025_01_02_071533_create_groups_categories', 38),
(76, '2025_01_02_071643_create_groups', 39),
(77, '2025_01_02_104401_add_new_field_to_customers_table', 40),
(78, '2025_01_03_085823_add_new_field_to_groups_categories_table', 41),
(79, '2025_01_03_091359_update_group_id_foreign_key_on_customers_table', 42),
(81, '2025_01_20_045536_create_blog_categories_table', 43),
(82, '2025_01_20_045907_create_blogs_table', 43),
(83, '2025_01_20_060702_create_blog_paragraphs_table', 43),
(84, '2025_01_20_061106_create_blog_paragraph_product_links_table', 43),
(85, '2025_01_20_082440_add_new_column_to_blog_paragraphs_table', 44),
(87, '2025_01_24_065411_create_banners_table', 45),
(88, '2025_01_24_104713_create_primary_categories_table', 46),
(89, '2025_01_27_111126_add_new_column_to_blog_paragraph_product_links', 47),
(91, '2025_02_07_094418_create_visitor_tracking_table', 48),
(93, '2025_02_08_091426_create_social_media_tracking_table', 49),
(94, '2025_02_10_055831_create_landing_pages_table', 50),
(96, '2025_02_10_112433_create_whats_app_conversation_table', 51),
(97, '2025_02_11_071630_add_fulltext_index_to_whats_app_conversation_table', 52),
(98, '2025_02_12_054604_add_new_field_to_category_table', 53),
(99, '2025_02_14_071533_create_order_shipment_records_table', 54),
(101, '2025_02_20_052528_create_notifications_table', 55),
(102, '2025_03_10_111757_add_group_id_to_customers_table', 56),
(103, '2025_03_11_082312_add_new_column_to_orders_table', 57),
(104, '2025_03_11_082653_modify_shipping_address_nullable_in_orders_table', 58);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `customer_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'New Login', 'Rahul Kumar Maurya has logged in.', 1, '2025-02-20 00:58:15', '2025-02-20 05:50:54'),
(2, 8, 'New Login', 'Dajal has logged in.', 1, '2025-02-20 01:20:44', '2025-02-28 02:09:57'),
(3, 9, 'New Login', 'Current Login', 1, NULL, '2025-02-28 02:10:07'),
(4, 1, 'New Login', 'Currently Rahul Kumar Maurya has logged in.', 1, '2025-02-20 04:26:39', '2025-02-20 05:51:04'),
(5, 1, 'New Login', 'Currently Rahul Kumar Maurya has logged in.', 0, '2025-02-28 01:36:03', '2025-02-28 01:36:03'),
(6, 1, 'New Login', 'Currently Rahul Kumar Maurya has logged in.', 0, '2025-03-10 06:06:41', '2025-03-10 06:06:41'),
(7, 1, 'New Login', 'Currently Rahul Kumar Maurya has logged in.', 0, '2025-03-10 23:02:24', '2025-03-10 23:02:24'),
(8, 1, 'New Login', 'Currently Rahul Kumar Maurya has logged in.', 0, '2025-03-11 22:46:09', '2025-03-11 22:46:09'),
(9, 1, 'New Login', 'Currently Rahul Kumar Maurya has logged in.', 0, '2025-03-11 23:16:03', '2025-03-11 23:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grand_total_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_received` tinyint(1) NOT NULL DEFAULT 0,
  `pick_up_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `shipping_address_id` int(10) UNSIGNED DEFAULT NULL,
  `billing_address_id` int(10) UNSIGNED DEFAULT NULL,
  `order_status_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_date`, `order_id`, `grand_total_amount`, `payment_mode`, `payment_received`, `pick_up_status`, `customer_id`, `shipping_address_id`, `billing_address_id`, `order_status_id`, `created_at`, `updated_at`) VALUES
(13, '2024-12-20 07:31:46', '0000000002', '3500', 'cashondelivery', 1, NULL, 1, 7, NULL, 1, '2024-12-20 02:01:46', '2024-12-20 02:01:46'),
(14, '2024-12-20 07:37:22', '0000000003', '3500', 'cashondelivery', 1, NULL, 1, 8, NULL, 1, '2024-12-20 02:07:22', '2024-12-20 02:07:22'),
(16, '2024-12-20 07:45:37', '0000000005', '3500', 'cashondelivery', 1, NULL, 1, 10, NULL, 1, '2024-12-20 02:15:37', '2024-12-20 02:15:37'),
(18, '2024-12-20 07:48:24', '0000000007', '3500', 'cashondelivery', 1, NULL, 1, 12, NULL, 1, '2024-12-20 02:18:24', '2024-12-20 02:18:24'),
(19, '2024-12-20 07:50:28', '0000000008', '3500', 'cashondelivery', 1, NULL, 1, 13, NULL, 2, '2024-12-20 02:20:28', '2025-02-15 01:34:28'),
(25, '2024-12-20 08:19:03', '0000000014', '3500', 'cashondelivery', 1, NULL, 1, 19, NULL, 2, '2024-12-20 02:49:03', '2025-02-15 01:28:24'),
(29, '2024-12-20 13:33:13', '0000000015', '3500', 'Cash on Delivery', 1, NULL, 1, 23, NULL, 5, '2024-12-20 08:03:13', '2025-02-15 01:34:59'),
(56, '2025-03-11 04:37:11', '0000000016', '2408', 'Cash on Delivery', 1, NULL, 1, 50, NULL, 1, '2025-03-10 23:07:11', '2025-03-10 23:07:11'),
(57, '2025-03-11 08:38:17', '0000000017', '17240', 'Pay to GPay ID of Girdhar Das and Sons', 1, 'pick_up_store', 1, NULL, NULL, 1, '2025-03-11 03:08:17', '2025-03-11 03:08:17'),
(58, '2025-03-11 08:51:16', '0000000018', '2280', 'Pay to PayTM ID of Girdhar Das and Sons', 1, 'pick_up_store', 1, NULL, NULL, 1, '2025-03-11 03:21:16', '2025-03-11 03:21:16'),
(59, '2025-03-12 06:16:52', '0000000019', '5840', 'Cash on Delivery', 1, 'pick_up_online', 1, 51, NULL, 1, '2025-03-12 00:46:52', '2025-03-12 00:46:52'),
(60, '2025-03-12 06:16:58', '0000000020', '5840', 'Cash on Delivery', 1, 'pick_up_online', 1, 52, NULL, 1, '2025-03-12 00:46:58', '2025-03-12 00:46:58'),
(61, '2025-03-12 06:17:00', '0000000021', '5840', 'Cash on Delivery', 1, 'pick_up_online', 1, 53, NULL, 1, '2025-03-12 00:47:00', '2025-03-12 00:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_lines`
--

CREATE TABLE `order_lines` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_lines`
--

INSERT INTO `order_lines` (`id`, `order_id`, `product_id`, `quantity`, `price`, `total_price`, `created_at`, `updated_at`) VALUES
(3, 13, 322, 8, '0', '0', '2024-12-20 02:01:46', '2024-12-20 02:01:46'),
(4, 13, 140, 7, '500', '3500', '2024-12-20 02:01:46', '2024-12-20 02:01:46'),
(5, 14, 322, 8, '0', '0', '2024-12-20 02:07:22', '2024-12-20 02:07:22'),
(6, 14, 140, 7, '500', '3500', '2024-12-20 02:07:22', '2024-12-20 02:07:22'),
(9, 16, 322, 8, '0', '0', '2024-12-20 02:15:37', '2024-12-20 02:15:37'),
(10, 16, 140, 7, '500', '3500', '2024-12-20 02:15:37', '2024-12-20 02:15:37'),
(13, 18, 322, 8, '0', '0', '2024-12-20 02:18:24', '2024-12-20 02:18:24'),
(14, 18, 140, 7, '500', '3500', '2024-12-20 02:18:24', '2024-12-20 02:18:24'),
(15, 19, 322, 8, '0', '0', '2024-12-20 02:20:28', '2024-12-20 02:20:28'),
(16, 19, 140, 7, '500', '3500', '2024-12-20 02:20:28', '2024-12-20 02:20:28'),
(27, 25, 322, 8, '0', '0', '2024-12-20 02:49:03', '2024-12-20 02:49:03'),
(28, 25, 140, 7, '500', '3500', '2024-12-20 02:49:03', '2024-12-20 02:49:03'),
(35, 29, 322, 8, '0', '0', '2024-12-20 08:03:13', '2024-12-20 08:03:13'),
(36, 29, 140, 7, '500', '3500', '2024-12-20 08:03:13', '2024-12-20 08:03:13'),
(81, 56, 283, 2, '54', '108', '2025-03-10 23:07:11', '2025-03-10 23:07:11'),
(82, 56, 315, 1, '2300', '2300', '2025-03-10 23:07:11', '2025-03-10 23:07:11'),
(83, 57, 315, 2, '2280', '4560', '2025-03-11 03:08:17', '2025-03-11 03:08:17'),
(84, 57, 316, 2, '6340', '12680', '2025-03-11 03:08:17', '2025-03-11 03:08:17'),
(85, 58, 315, 1, '2280', '2280', '2025-03-11 03:21:16', '2025-03-11 03:21:16'),
(86, 59, 274, 1, '1040', '1040', '2025-03-12 00:46:52', '2025-03-12 00:46:52'),
(87, 59, 315, 2, '2400', '4800', '2025-03-12 00:46:52', '2025-03-12 00:46:52'),
(88, 60, 274, 1, '1040', '1040', '2025-03-12 00:46:58', '2025-03-12 00:46:58'),
(89, 60, 315, 2, '2400', '4800', '2025-03-12 00:46:58', '2025-03-12 00:46:58'),
(90, 61, 274, 1, '1040', '1040', '2025-03-12 00:47:00', '2025-03-12 00:47:00'),
(91, 61, 315, 2, '2400', '4800', '2025-03-12 00:47:00', '2025-03-12 00:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_shipment_records`
--

CREATE TABLE `order_shipment_records` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_status_id` int(10) UNSIGNED DEFAULT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `tracking_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courier_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipment_details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipment_date` date DEFAULT NULL,
  `receiving_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_shipment_records`
--

INSERT INTO `order_shipment_records` (`id`, `order_id`, `order_status_id`, `customer_id`, `tracking_no`, `courier_name`, `shipment_details`, `shipment_date`, `receiving_date`, `created_at`, `updated_at`) VALUES
(5, 25, 2, 1, NULL, NULL, 'Order status updated', '2025-02-15', NULL, '2025-02-15 01:28:24', '2025-02-15 01:28:24'),
(6, 29, 3, 1, NULL, NULL, 'Order status updated', '2025-02-15', NULL, '2025-02-15 01:28:43', '2025-02-15 01:28:43'),
(7, 19, 2, 1, NULL, NULL, 'Order status updated', '2025-02-15', NULL, '2025-02-15 01:34:28', '2025-02-15 01:34:28'),
(8, 29, 4, 1, NULL, NULL, 'Order status updated', '2025-02-15', NULL, '2025-02-15 01:34:51', '2025-02-15 01:34:51'),
(9, 29, 5, 1, NULL, NULL, 'Order status updated', '2025-02-15', '2025-02-15', '2025-02-15 01:34:59', '2025-02-15 01:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `status_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `status_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'New', 'Order has been placed but not yet processed.', NULL, NULL),
(2, 'Packed', 'Order has been confirmed and packed.', NULL, NULL),
(3, 'Processing', 'Order is being prepared or packed for shipment.', NULL, NULL),
(4, 'Shipped', 'Order has been shipped and is on its way.', NULL, NULL),
(5, 'Delivered', 'Order has been successfully delivered to the customer.', NULL, NULL),
(6, 'Cancelled', 'Order has been cancelled either by the customer or the admin.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('rahulkumarmaurya464@gmail.com', 'OOM8pxXuGlhm13qBjRKyKGzUDX79Dcy91PKNkZ97q5KANNaGVRLjaDqBMxvXWgng', '2025-02-13 03:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'login', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(2, 'forget.password', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(3, 'forget.password.post', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(4, 'reset.password.get', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(5, 'reset.password.post', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(6, 'logout', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(7, 'users', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(8, 'users.create', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(9, 'users.store', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(10, 'users.show', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(11, 'users.edit', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(12, 'users.update', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(13, 'users.destroy', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(14, 'roles.index', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(15, 'roles.create', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(16, 'roles.store', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(17, 'roles.show', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(18, 'roles.edit', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(19, 'roles.update', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(20, 'roles.destroy', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(21, 'permissions.index', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(22, 'permissions.create', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(23, 'permissions.store', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(24, 'permissions.show', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(25, 'permissions.edit', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(26, 'permissions.update', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(27, 'permissions.destroy', 'web', '2024-10-02 08:59:23', '2024-10-02 08:59:23'),
(28, 'manage users', 'web', '2024-10-04 03:29:35', '2024-10-04 03:29:35'),
(29, 'edit articles', 'web', '2024-10-04 03:29:35', '2024-10-04 03:29:35'),
(30, 'view reports', 'web', '2024-10-04 03:29:35', '2024-10-04 03:29:35');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `primary_categories`
--

CREATE TABLE `primary_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `primary_categories`
--

INSERT INTO `primary_categories` (`id`, `title`, `image_path`, `link`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Vegetables & Fruit', NULL, 'http://127.0.0.1:8000/', 1, '2025-01-25 00:17:14', '2025-01-25 00:17:14'),
(3, 'test', NULL, 'http://127.0.0.1:8000/', 1, '2025-01-25 01:21:15', '2025-01-25 01:21:15'),
(4, 'hawkns stinsless steekd', NULL, 'http://127.0.0.1:8000/kitchen-catalog/cookware/materialsurface/stainless-steel-1', 1, '2025-02-12 00:05:26', '2025-02-12 00:05:26'),
(5, 'Cooker category', NULL, 'http://127.0.0.1:8000/categories/cookware', 1, '2025-02-12 04:34:52', '2025-02-12 04:34:52');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hsn_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_in_per` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `subcategory_id` int(10) UNSIGNED DEFAULT NULL,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `label_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_weight` decimal(8,2) DEFAULT NULL,
  `product_stock_status` tinyint(1) NOT NULL DEFAULT 1,
  `product_tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_price` decimal(8,2) DEFAULT NULL,
  `product_sale_price` decimal(8,2) DEFAULT NULL,
  `product_status` tinyint(1) NOT NULL DEFAULT 1,
  `warranty_status` tinyint(1) NOT NULL DEFAULT 0,
  `attributes_show_status` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_specification` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `hsn_code`, `gst_in_per`, `slug`, `category_id`, `subcategory_id`, `brand_id`, `label_id`, `product_weight`, `product_stock_status`, `product_tags`, `product_price`, `product_sale_price`, `product_status`, `warranty_status`, `attributes_show_status`, `meta_title`, `meta_description`, `product_description`, `product_specification`, `created_at`, `updated_at`) VALUES
(139, 'HAWKINS PRESSURE COOKER BIG BOY 22L', '7615', '12', 'hawkins-pressure-cooker-big-boy-22l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, '1', '1', '<p>asdsadsdsadd<span class=\"ql-font-monospace\">asdadadsdsadasddasd</span></p><p><br></p><p><br></p><p><span class=\"ql-font-monospace\">adasdadsaasdas adas asd</span></p><p><span class=\"ql-font-monospace\">Dasdcasdasd</span></p>', '<p>sds asdadasdsadsadasdsadasdasdasdasdasdasdasdas awdas ads</p>', '2024-12-02 07:13:20', '2025-01-14 23:43:20'),
(140, 'HAWKINS PRESSURE COOKER CERAMIC 2L', '7615', '12', 'hawkins-pressure-cooker-ceramic-2l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, '22', '222', '<p>test</p>', '<p>sds testesdf sdfsefs sdfsd ssdf sfsdfsd </p>', '2024-12-02 07:13:21', '2024-12-27 01:19:55'),
(141, 'HAWKINS PRESSURE COOKER CERAMIC 3L', '7615', '12', 'hawkins-pressure-cooker-ceramic-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, 'dd', 'ff', '<p>test</p>', NULL, '2024-12-02 07:13:21', '2024-12-27 01:16:31'),
(142, 'HAWKINS PRESSURE COOKER CERAMIC 5L', '7615', '12', 'hawkins-pressure-cooker-ceramic-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '<p>asdadsaddasd</p>', NULL, '2024-12-02 07:13:21', '2024-12-27 01:16:31'),
(143, 'HAWKINS PRESSURE COOKER CLASSIC 1.5L', '7615', '12', 'hawkins-pressure-cooker-classic-15l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, 'test 56', NULL, '2024-12-02 07:13:21', '2024-12-27 01:16:31'),
(144, 'HAWKINS PRESSURE COOKER CLASSIC 10L', '7615', '12', 'hawkins-pressure-cooker-classic-10l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, '<p>asdasd</p>', NULL, '2024-12-02 07:13:21', '2024-12-27 01:16:31'),
(145, 'HAWKINS PRESSURE COOKER CLASSIC 12L', '7615', '12', 'hawkins-pressure-cooker-classic-12l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:21', '2024-12-02 08:14:11'),
(146, 'HAWKINS PRESSURE COOKER CLASSIC 2L', '7615', '12', 'hawkins-pressure-cooker-classic-2l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:21', '2024-12-02 08:14:11'),
(147, 'HAWKINS PRESSURE COOKER CLASSIC 3L', '7615', '12', 'hawkins-pressure-cooker-classic-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:22', '2024-12-02 08:14:11'),
(148, 'HAWKINS PRESSURE COOKER CLASSIC 3L TALL', '7615', '12', 'hawkins-pressure-cooker-classic-3l-tall', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:22', '2024-12-02 08:14:11'),
(149, 'HAWKINS PRESSURE COOKER CLASSIC 4L', '7615', '12', 'hawkins-pressure-cooker-classic-4l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:22', '2024-12-02 08:14:11'),
(150, 'HAWKINS PRESSURE COOKER CLASSIC 5L', '7615', '12', 'hawkins-pressure-cooker-classic-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:22', '2024-12-02 08:14:11'),
(151, 'HAWKINS PRESSURE COOKER CLASSIC 6.5L', '7615', '12', 'hawkins-pressure-cooker-classic-65l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:22', '2024-12-02 08:14:11'),
(152, 'HAWKINS PRESSURE COOKER CLASSIC 8L', '7615', '12', 'hawkins-pressure-cooker-classic-8l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:23', '2024-12-02 08:14:11'),
(153, 'HAWKINS PRESSURE COOKER CLASSIC 8L JUMBO', '7615', '12', 'hawkins-pressure-cooker-classic-8l-jumbo', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:23', '2024-12-02 08:14:11'),
(154, 'HAWKINS PRESSURE COOKER CLASSIC IND 3L', '7615', '12', 'hawkins-pressure-cooker-classic-ind-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:23', '2024-12-02 08:14:11'),
(155, 'HAWKINS PRESSURE COOKER CLASSIC IND 5L', '7615', '12', 'hawkins-pressure-cooker-classic-ind-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:23', '2024-12-02 08:14:11'),
(156, 'HAWKINS PRESSURE COOKER CLASSIC STEEL TRIPLY 5L', '7323', '12', 'hawkins-pressure-cooker-classic-steel-triply-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:23', '2024-12-26 08:21:14'),
(157, 'HAWKINS PRESSURE COOKER CONTURA BLACK 1.5L', '7615', '12', 'hawkins-pressure-cooker-contura-black-15l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:23', '2024-12-02 08:14:13'),
(158, 'HAWKINS PRESSURE COOKER CONTURA BLACK 2L', '7615', '12', 'hawkins-pressure-cooker-contura-black-2l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:24', '2024-12-02 08:14:13'),
(159, 'HAWKINS PRESSURE COOKER CONTURA BLACK 3.5L', '7615', '12', 'hawkins-pressure-cooker-contura-black-35l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:24', '2024-12-02 08:14:13'),
(160, 'HAWKINS PRESSURE COOKER CONTURA BLACK 3L', '7615', '12', 'hawkins-pressure-cooker-contura-black-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:24', '2024-12-02 08:14:13'),
(161, 'HAWKINS PRESSURE COOKER CONTURA BLACK 5L', '7615', '12', 'hawkins-pressure-cooker-contura-black-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:24', '2024-12-02 08:14:13'),
(162, 'HAWKINS PRESSURE COOKER CONTURA BLACK XT 1.5L', '7615', '12', 'hawkins-pressure-cooker-contura-black-xt-15l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:24', '2024-12-02 08:14:13'),
(163, 'HAWKINS PRESSURE COOKER CONTURA BLACK XT 2L', '7615', '12', 'hawkins-pressure-cooker-contura-black-xt-2l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:24', '2024-12-02 08:14:13'),
(164, 'HAWKINS PRESSURE COOKER CONTURA BLACK XT 3.5L', '7615', '12', 'hawkins-pressure-cooker-contura-black-xt-35l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:24', '2024-12-02 08:14:13'),
(165, 'HAWKINS PRESSURE COOKER CONTURA BLACK XT 3L', '7615', '12', 'hawkins-pressure-cooker-contura-black-xt-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:25', '2024-12-02 08:14:13'),
(166, 'HAWKINS PRESSURE COOKER CONTURA BLACK XT 5L', '7615', '12', 'hawkins-pressure-cooker-contura-black-xt-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:25', '2024-12-02 08:14:13'),
(167, 'HAWKINS PRESSURE COOKER CONTURA GREEN COLOR 3L', '7615', '12', 'hawkins-pressure-cooker-contura-green-color-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:25', '2024-12-02 08:14:11'),
(168, 'HAWKINS PRESSURE COOKER CONTURA STEEL 1.5L', '7323', '12', 'hawkins-pressure-cooker-contura-steel-15l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:25', '2024-12-02 08:14:12'),
(169, 'HAWKINS PRESSURE COOKER CONTURA STEEL 2L', '7323', '12', 'hawkins-pressure-cooker-contura-steel-2l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:25', '2024-12-02 08:14:12'),
(170, 'HAWKINS PRESSURE COOKER CONTURA STEEL 3.5L', '7323', '12', 'hawkins-pressure-cooker-contura-steel-35l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:25', '2024-12-02 08:14:12'),
(171, 'HAWKINS PRESSURE COOKER CONTURA STEEL 3L', '7323', '12', 'hawkins-pressure-cooker-contura-steel-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:25', '2024-12-02 08:14:12'),
(172, 'HAWKINS PRESSURE COOKER CONTURA STEEL 5L', '7323', '12', 'hawkins-pressure-cooker-contura-steel-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:25', '2024-12-02 08:14:12'),
(173, 'HAWKINS PRESSURE COOKER CONTURA WHITE 1.5L', '7615', '12', 'hawkins-pressure-cooker-contura-white-15l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:25', '2024-12-02 08:14:11'),
(174, 'HAWKINS PRESSURE COOKER CONTURA WHITE 2L', '7615', '12', 'hawkins-pressure-cooker-contura-white-2l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:26', '2024-12-02 08:14:11'),
(175, 'HAWKINS PRESSURE COOKER CONTURA WHITE 3.5L', '7615', '12', 'hawkins-pressure-cooker-contura-white-35l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:26', '2024-12-02 08:14:11'),
(176, 'HAWKINS PRESSURE COOKER CONTURA WHITE 3L', '7615', '12', 'hawkins-pressure-cooker-contura-white-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:26', '2024-12-02 08:14:11'),
(177, 'HAWKINS PRESSURE COOKER CONTURA WHITE 4L', '7615', '12', 'hawkins-pressure-cooker-contura-white-4l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:26', '2024-12-02 08:14:11'),
(178, 'HAWKINS PRESSURE COOKER CONTURA WHITE 5L', '7615', '12', 'hawkins-pressure-cooker-contura-white-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:26', '2024-12-02 08:14:11'),
(179, 'HAWKINS PRESSURE COOKER CONTURA WHITE 6.5L', '7615', '12', 'hawkins-pressure-cooker-contura-white-65l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:26', '2024-12-02 08:14:11'),
(180, 'HAWKINS PRESSURE COOKER CONTURA YELLOW COLOR 3L', '7615', '12', 'hawkins-pressure-cooker-contura-yellow-color-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:26', '2024-12-02 08:14:11'),
(181, 'HAWKINS PRESSURE COOKER FUTURA 5L', '7615', '12', 'hawkins-pressure-cooker-futura-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:26', '2024-12-02 08:14:13'),
(182, 'HAWKINS PRESSURE COOKER FUTURA BLACK 7L', '7615', '12', 'hawkins-pressure-cooker-futura-black-7l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:26', '2024-12-02 08:14:13'),
(183, 'HAWKINS PRESSURE COOKER FUTURA IND 3L', '7615', '12', 'hawkins-pressure-cooker-futura-ind-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:13'),
(184, 'HAWKINS PRESSURE COOKER FUTURA STEEL 5.5L', '7323', '12', 'hawkins-pressure-cooker-futura-steel-55l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:12'),
(185, 'HAWKINS PRESSURE COOKER HEAVY BASE 2L', '7615', '12', 'hawkins-pressure-cooker-heavy-base-2l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:11'),
(186, 'HAWKINS PRESSURE COOKER HEAVY BASE 3.5L', '7615', '12', 'hawkins-pressure-cooker-heavy-base-35l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:11'),
(187, 'HAWKINS PRESSURE COOKER HEAVY BASE 5L', '7615', '12', 'hawkins-pressure-cooker-heavy-base-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:11'),
(188, 'HAWKINS PRESSURE COOKER HEAVY BASE 6.5L', '7615', '12', 'hawkins-pressure-cooker-heavy-base-65l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:11'),
(189, 'HAWKINS PRESSURE COOKER HEAVY BASE IND 3L', '7615', '12', 'hawkins-pressure-cooker-heavy-base-ind-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:11'),
(190, 'HAWKINS PRESSURE COOKER MISS MARY 1.5L', '7615', '12', 'hawkins-pressure-cooker-miss-mary-15l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:11'),
(191, 'HAWKINS PRESSURE COOKER MISS MARY 3L', '7615', '12', 'hawkins-pressure-cooker-miss-mary-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:11'),
(192, 'HAWKINS PRESSURE COOKER MISS MARY 4L', '7615', '12', 'hawkins-pressure-cooker-miss-mary-4l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:11'),
(193, 'HAWKINS PRESSURE COOKER MISS MARY 5L', '7615', '12', 'hawkins-pressure-cooker-miss-mary-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:11'),
(194, 'HAWKINS PRESSURE COOKER MISS MARY 6L', '7615', '12', 'hawkins-pressure-cooker-miss-mary-6l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:12'),
(195, 'HAWKINS PRESSURE COOKER MISS MARY HANDI 2L', '7615', '12', 'hawkins-pressure-cooker-miss-mary-handi-2l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:27', '2024-12-02 08:14:12'),
(196, 'HAWKINS PRESSURE COOKER MISS MARY HANDI 3L', '7615', '12', 'hawkins-pressure-cooker-miss-mary-handi-3l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:28', '2024-12-02 08:14:12'),
(197, 'HAWKINS PRESSURE COOKER MISS MARY HANDI 5L', '7615', '12', 'hawkins-pressure-cooker-miss-mary-handi-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:28', '2024-12-02 08:14:12'),
(198, 'HAWKINS PRESSURE COOKER STEEL 1.5L', '7323', '12', 'hawkins-pressure-cooker-steel-15l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:28', '2024-12-02 08:14:12'),
(199, 'HAWKINS PRESSURE COOKER STEEL 10L', '7323', '12', 'hawkins-pressure-cooker-steel-10l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:28', '2024-12-02 08:14:12'),
(200, 'HAWKINS PRESSURE COOKER STEEL 2L', '7323', '12', 'hawkins-pressure-cooker-steel-2l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:28', '2024-12-02 08:14:12'),
(201, 'HAWKINS PRESSURE COOKER STEEL 3L TALL', '7323', '12', 'hawkins-pressure-cooker-steel-3l-tall', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:29', '2024-12-02 08:14:12'),
(202, 'HAWKINS PRESSURE COOKER STEEL 3L WIDE', '7323', '12', 'hawkins-pressure-cooker-steel-3l-wide', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:29', '2024-12-02 08:14:12'),
(203, 'HAWKINS PRESSURE COOKER STEEL 4L', '7323', '12', 'hawkins-pressure-cooker-steel-4l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:29', '2024-12-02 08:14:12'),
(204, 'HAWKINS PRESSURE COOKER STEEL 5L', '7323', '12', 'hawkins-pressure-cooker-steel-5l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:29', '2024-12-02 08:14:12'),
(205, 'HAWKINS PRESSURE COOKER STEEL 6L', '7323', '12', 'hawkins-pressure-cooker-steel-6l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:29', '2024-12-02 08:14:12'),
(206, 'HAWKINS PRESSURE COOKER STEEL 8L', '7323', '12', 'hawkins-pressure-cooker-steel-8l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:29', '2024-12-02 08:14:12'),
(207, 'HAWKINS PRESSURE COOKER STEEL TRIPLY 2.5L', '7323', '12', 'hawkins-pressure-cooker-steel-triply-25l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:29', '2024-12-02 08:14:12'),
(208, 'HAWKINS PRESSURE COOKER STEEL TRIPLY 3.5L', '7323', '12', 'hawkins-pressure-cooker-steel-triply-35l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:29', '2024-12-02 08:14:12'),
(209, 'HAWKINS PRESSURE COOKER STEEL TRIPLY 4.5L', '7323', '12', 'hawkins-pressure-cooker-steel-triply-45l', 4, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 07:13:29', '2024-12-02 08:14:12'),
(210, '24HAGP FUTURA HA KITCHEN GIFT PACK SET-3', '7615', '12', '24hagp-futura-ha-kitchen-gift-pack-set-3', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(211, 'ACB20 FUTURA COOK N SERVE HA 2L', '7615', '12', 'acb20-futura-cook-n-serve-ha-2l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(212, 'ACB50 FUTURA COOK N SERVE BOWL HA 5L', '7615', '12', 'acb50-futura-cook-n-serve-bowl-ha-5l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(213, 'AD25S FUTURA KADHAI DEEP FRYPAN HA S/L 2.5L', '7615', '12', 'ad25s-futura-kadhai-deep-frypan-ha-sl-25l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(214, 'AF29S FUTURA FRY PAN HA S/L 29CM', '7615', '12', 'af29s-futura-fry-pan-ha-sl-29cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(215, 'AK15G FUTURA KADHAI DEEP FRYPAN HA G/L 1.5L', '7615', '12', 'ak15g-futura-kadhai-deep-frypan-ha-gl-15l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(216, 'AK15S FUTURA KADHAI DEEP FRYPAN HA S/L 1.5L', '7615', '12', 'ak15s-futura-kadhai-deep-frypan-ha-sl-15l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(217, 'AK40S FUTURA KADHAI DEEP FRY PAN HA S/L 4L', '7615', '12', 'ak40s-futura-kadhai-deep-fry-pan-ha-sl-4l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(218, 'AK50S FUTURA KADHAI DEEP FRY PAN HA S/L 5L', '7615', '12', 'ak50s-futura-kadhai-deep-fry-pan-ha-sl-5l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(219, 'AS10S FUTURA SAUCE PAN HA S/L 1L', '7615', '12', 'as10s-futura-sauce-pan-ha-sl-1l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(220, 'AST85 FUTURA STEWPOT HA S/L 8.5L', '7615', '12', 'ast85-futura-stewpot-ha-sl-85l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(221, 'AT22 FUTURA TAVA HA 22CM', '7615', '12', 'at22-futura-tava-ha-22cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:48', '2024-12-02 08:14:00'),
(222, 'AT26 FUTURA TAVA HA 26CM', '7615', '12', 'at26-futura-tava-ha-26cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(223, 'AT26XP FUTURA TAVA HA 26CM', '7615', '12', 'at26xp-futura-tava-ha-26cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(224, 'CIF24G FUTURA FRY PAN CAST IRON G/L 24CM', '7323', '12', 'cif24g-futura-fry-pan-cast-iron-gl-24cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:27'),
(225, 'DCGP30G HAWKINS GRILL PAN DIE CAST G/L 30CM', '7615', '12', 'dcgp30g-hawkins-grill-pan-die-cast-gl-30cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:21'),
(226, 'DCM30G HAWKINS MULTI SNACK NS 30CM', '7615', '12', 'dcm30g-hawkins-multi-snack-ns-30cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:13'),
(227, 'FUTURA APPA CHATTI NONSTICK G/L 22CM', '7615', '12', 'futura-appa-chatti-nonstick-gl-22cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:13'),
(228, 'FUTURA BIGBOY BIRYANI HANDI 12L', '7615', '12', 'futura-bigboy-biryani-handi-12l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(229, 'FUTURA SAUCE PAN NS WOL 1L', '7615', '12', 'futura-sauce-pan-ns-wol-1l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:13'),
(230, 'FUTURA TADKA PAN BIG', '7615', '12', 'futura-tadka-pan-big', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(231, 'FUTURA TADKA PAN SMALL 240ML', '7615', '12', 'futura-tadka-pan-small-240ml', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(232, 'FUTURA TOY KITCHEN SET', '7615', '12', 'futura-toy-kitchen-set', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(233, 'HAWKINS CERAMIC NS MINI CASSEROLE G/L', '7615', '12', 'hawkins-ceramic-ns-mini-casserole-gl', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:13'),
(234, 'HAWKINS IDLI STAND ALUMINIUM FOR 5L', '7615', '12', 'hawkins-idli-stand-aluminium-for-5l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:58'),
(235, 'HAWKINS IDLI STAND ALUMINIUM FOR 6.5L', '7615', '12', 'hawkins-idli-stand-aluminium-for-65l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:58'),
(236, 'HAWKINS IDLI STAND FOR 3L', '7615', '12', 'hawkins-idli-stand-for-3l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:58'),
(237, 'HAWKINS IDLI STAND STEEL FOR 5L', '7323', '12', 'hawkins-idli-stand-steel-for-5l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:59'),
(238, 'HAWKINS T-PAN STEEL WOL 1L', '7323', '12', 'hawkins-t-pan-steel-wol-1l', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2025-01-24 02:25:36'),
(239, 'HAWKINS TADKAPAN HA CUP 2', '7615', '12', 'hawkins-tadkapan-ha-cup-2', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(240, 'HAWKINS TRI-PLY TADKA PAN SS 2.5CUP', '7323', '12', 'hawkins-tri-ply-tadka-pan-ss-25cup', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:59'),
(241, 'HAWKINS TRINITI SET COOKER TAVA KADHAI', '7615', '12', 'hawkins-triniti-set-cooker-tava-kadhai', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(242, 'HAWKINS TRIPLY TRINITI 22CM SET 3', '7323', '12', 'hawkins-triply-triniti-22cm-set-3', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:01'),
(243, 'HAWKINS TRIPLY TRINITY 26CM SET 3', '7323', '12', 'hawkins-triply-trinity-26cm-set-3', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:01'),
(244, 'HAWKINS TRIPLY TRINITY SET 2', '7323', '12', 'hawkins-triply-trinity-set-2', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:01'),
(245, 'HAWKINS WOODEN SPATULA', '4419', '18', 'hawkins-wooden-spatula', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:13:05'),
(246, 'IACB30 FUTURA COOK N SERVE BOWL HA 3L IB', '7615', '12', 'iacb30-futura-cook-n-serve-bowl-ha-3l-ib', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(247, 'IACH30G FUTURA HANDI CNS HA G/L 3L', '7615', '12', 'iach30g-futura-handi-cns-ha-gl-3l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(248, 'IAD25S FUTURA KADHAI DEEP F-PAN HA S/L 2.5LIB', '7615', '12', 'iad25s-futura-kadhai-deep-f-pan-ha-sl-25lib', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(249, 'IAD375G FUTURA KADHAI DEEP F-PAN HA 3.75L', '7615', '12', 'iad375g-futura-kadhai-deep-f-pan-ha-375l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(250, 'IAD375S FUTURA KADHAI DEEP F-PAN HA S/L 3.75L', '7615', '12', 'iad375s-futura-kadhai-deep-f-pan-ha-sl-375l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(251, 'IAF20S FUTURA FRY PAN HA S/L 20CM IB', '7615', '12', 'iaf20s-futura-fry-pan-ha-sl-20cm-ib', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2025-02-04 02:04:45'),
(252, 'IAF22 FUTURA FRY PAN HA 22CM IB', '7615', '12', 'iaf22-futura-fry-pan-ha-22cm-ib', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(253, 'IAF22S FUTURA FRY PAN HA S/L 22CM IB', '7615', '12', 'iaf22s-futura-fry-pan-ha-sl-22cm-ib', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(254, 'IAF25S FUTURA FRY PAN HA S/L IB 25CM', '7615', '12', 'iaf25s-futura-fry-pan-ha-sl-ib-25cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(255, 'IAK20G FUTURA KADHAI DEEP FRY PAN HA G/L 2L', '7615', '12', 'iak20g-futura-kadhai-deep-fry-pan-ha-gl-2l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2024-12-02 08:14:00'),
(256, 'IART24 FUTURA ROTI TAVA HA 24CM', '7615', '12', 'iart24-futura-roti-tava-ha-24cm', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2025-02-04 02:00:50'),
(257, 'IART26 FUTURA ROTI TAVA HA 26CM', '7615', '12', 'iart26-futura-roti-tava-ha-26cm', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:49', '2025-02-04 02:00:50'),
(258, 'IAS20S FUTURA SAUCE PAN HA S/L 2L IB', '7615', '12', 'ias20s-futura-sauce-pan-ha-sl-2l-ib', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(259, 'ICF17 HAWKINS FRY PAN NS CERAMIC 17CM', '7615', '12', 'icf17-hawkins-fry-pan-ns-ceramic-17cm', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(260, 'IGP26G HAWKINS GRILL PAN DIE CAST G/L 26CM', '7615', '12', 'igp26g-hawkins-grill-pan-die-cast-gl-26cm', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(261, 'IND25 FUTURA KADHAI DEEP FRY PAN NS 2.5L IB', '7615', '12', 'ind25-futura-kadhai-deep-fry-pan-ns-25l-ib', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(262, 'INDK25G FUTURA KADHAI DEEP FRYPAN NS G/L 2.5L', '7615', '12', 'indk25g-futura-kadhai-deep-frypan-ns-gl-25l', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(263, 'INDT28 FUTURA DOSA TAVA NS 28CM IB', '7615', '12', 'indt28-futura-dosa-tava-ns-28cm-ib', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(264, 'INDT30 FUTURA DOSA TAVA NS 30CM IB', '7615', '12', 'indt30-futura-dosa-tava-ns-30cm-ib', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(265, 'INF20 FUTURA FRY PAN NS 20CM IB', '7615', '12', 'inf20-futura-fry-pan-ns-20cm-ib', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(266, 'INF24S FUTURA FRY PAN NS S/L 24CM IB', '7615', '12', 'inf24s-futura-fry-pan-ns-sl-24cm-ib', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(267, 'INFS30S FUTURA FRY PAN NS S/L 30CM IB', '7615', '12', 'infs30s-futura-fry-pan-ns-sl-30cm-ib', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(268, 'INFT26 FUTURA FLAT TAVA NS 26CM', '7615', '12', 'inft26-futura-flat-tava-ns-26cm', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(269, 'INFT30 FUTURA FLAT TAVA NS 30CM IB', '7615', '12', 'inft30-futura-flat-tava-ns-30cm-ib', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 02:00:50'),
(270, 'INK35S FUTURA KADHAI DEEP FRYPAN NS S/L 3.5L', '7615', '12', 'ink35s-futura-kadhai-deep-frypan-ns-sl-35l', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:23:05'),
(271, 'INK50G FUTURA KADHAI DEEP FRYPAN NS G/L 5L IB', '7615', '12', 'ink50g-futura-kadhai-deep-frypan-ns-gl-5l-ib', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(272, 'IUC20G HAWKINS CASSEROLE AQUA CNS G/L 2L', '7615', '12', 'iuc20g-hawkins-casserole-aqua-cns-gl-2l', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-01-24 02:25:09'),
(273, 'IUC30G HAWKINS CASSEROLE AQUA CNS G/L 2L', '7615', '12', 'iuc30g-hawkins-casserole-aqua-cns-gl-2l', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(274, 'NAP30 FUTURA ALL PURPOSE PAN NS 3L', '7615', '12', 'nap30-futura-all-purpose-pan-ns-3l', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(275, 'NAPE22G HAWKINS APPE PAN G/L 22CM', '7615', '12', 'nape22g-hawkins-appe-pan-gl-22cm', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(276, 'NAPE26G HAWKINS APPE PAN G/L 26CM', '7615', '12', 'nape26g-hawkins-appe-pan-gl-26cm', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(277, 'NCF28G FUTURA COOK N SERVE NS G/L 3L', '7615', '12', 'ncf28g-futura-cook-n-serve-ns-gl-3l', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(278, 'NDT28 FUTURA DOSA TAVA NS 28CM', '7615', '12', 'ndt28-futura-dosa-tava-ns-28cm', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(279, 'NDT30 FUTURA DOSA TAVA NS 30CM', '7615', '12', 'ndt30-futura-dosa-tava-ns-30cm', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(280, 'NDT33 FUTURA DOSA TAVA NS 33CM', '7615', '12', 'ndt33-futura-dosa-tava-ns-33cm', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(281, 'NK25S FUTURA KADHAI DEEP FRYPAN NS S/L 2.5L', '7615', '12', 'nk25s-futura-kadhai-deep-frypan-ns-sl-25l', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(282, 'NSDK25G HAWKINS DEEP KADHAI NS T-PLY G/L 2.5L', '7323', '12', 'nsdk25g-hawkins-deep-kadhai-ns-t-ply-gl-25l', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(283, 'NSDT28 HAWKINS DOSA TAVA TRIPLY SS 28CM', '7323', '12', 'nsdt28-hawkins-dosa-tava-triply-ss-28cm', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(284, 'NSF22G HAWKINS SS FRYPAN TRIPLY G/L 22CM', '7323', '12', 'nsf22g-hawkins-ss-frypan-triply-gl-22cm', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2025-02-04 03:37:41'),
(285, 'NSPT24 HAWKINS PARATHA TAVA STEEL TRIPLY 24CM', '7323', '12', 'nspt24-hawkins-paratha-tava-steel-triply-24cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:50', '2024-12-02 08:14:01'),
(286, 'NSPT26 HAWKINS PARATHA TAVA STEEL TRIPLY 26CM', '7323', '12', 'nspt26-hawkins-paratha-tava-steel-triply-26cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(287, 'NT22 FUTURA FLAT TAVA NS 22CM', '7615', '12', 'nt22-futura-flat-tava-ns-22cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:13:13'),
(288, 'NT26 FUTURA TAVA GRIDDLE NS 26CM/4.88', '7615', '12', 'nt26-futura-tava-griddle-ns-26cm488', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:13:13'),
(289, 'NUP24G FUTURA UTTAPAM PAN G/L 24CM', '7615', '12', 'nup24g-futura-uttapam-pan-gl-24cm', 10, NULL, NULL, 5, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2025-02-04 02:00:50'),
(290, 'PNF22S FUTURA PRO FRYING PAN NS S/L 22CM', '7615', '12', 'pnf22s-futura-pro-frying-pan-ns-sl-22cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:13:13'),
(291, 'PNK25S FUTURA PRO DEEP KADHAI NS SL 2.5L', '7615', '12', 'pnk25s-futura-pro-deep-kadhai-ns-sl-25l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:13:13'),
(292, 'PSK25S HAWKINS PRO DEEP FRY PAN T-PLY 2.5L', '7323', '12', 'psk25s-hawkins-pro-deep-fry-pan-t-ply-25l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(293, 'PSK35S HAWKINS PRO DEEP FRY PAN T-PLY 3.5L', '7323', '12', 'psk35s-hawkins-pro-deep-fry-pan-t-ply-35l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(294, 'PSK60S HAWKINS PRO DEEP FRY PAN T-PLY 6L', '7323', '12', 'psk60s-hawkins-pro-deep-fry-pan-t-ply-6l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(295, 'SSCB50G HAWKINS CNS CASSEROLE SS 5L', '7323', '12', 'sscb50g-hawkins-cns-casserole-ss-5l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:13:59'),
(296, 'SSD15G HAWKINS DEEP FRYPAN TRIPLY GL 1.5L', '7323', '12', 'ssd15g-hawkins-deep-frypan-triply-gl-15l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2025-02-04 02:17:54'),
(297, 'SSD25G HAWKINS KADHAI DEEP FRYPAN T-PLY 2.5L', '7323', '12', 'ssd25g-hawkins-kadhai-deep-frypan-t-ply-25l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(298, 'SSF22G HAWKINS FRY PAN TRIPLY G/L 22CM', '7323', '12', 'ssf22g-hawkins-fry-pan-triply-gl-22cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(299, 'SSF24G HAWKINS FRY PAN TRIPLY G/L 24CM', '7323', '12', 'ssf24g-hawkins-fry-pan-triply-gl-24cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(300, 'SSH20G HAWKINS CNS HANDI TRIPLY G/L 2L', '7323', '12', 'ssh20g-hawkins-cns-handi-triply-gl-2l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(301, 'SSH30G HAWKINS CNS HANDI TRIPLY G/L 3L', '7323', '12', 'ssh30g-hawkins-cns-handi-triply-gl-3l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(302, 'SSH40G HAWKINS CNS HANDI TRIPLY G/L 4L', '7323', '12', 'ssh40g-hawkins-cns-handi-triply-gl-4l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(303, 'SSH50G HAWKINS CNS HANDI TRIPLY G/L 5L', '7323', '12', 'ssh50g-hawkins-cns-handi-triply-gl-5l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(304, 'SSK40G HAWKINS KADHAI DEEP F-PAN T-PLY G/L 4L', '7323', '12', 'ssk40g-hawkins-kadhai-deep-f-pan-t-ply-gl-4l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(305, 'SSK50G HAWKINS KADHAI DEEP F-PAN T-PLY G/L 5L', '7323', '12', 'ssk50g-hawkins-kadhai-deep-f-pan-t-ply-gl-5l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(306, 'SSP15 HAWKINS STEEL PATILA TRIPLY 1.5L', '7323', '12', 'ssp15-hawkins-steel-patila-triply-15l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(307, 'SSP20 HAWKINS STEEL PATILA TRIPLY 2L', '7323', '12', 'ssp20-hawkins-steel-patila-triply-2l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(308, 'SSP25 HAWKINS STEEL PATILA TRIPLY 2.5L', '7323', '12', 'ssp25-hawkins-steel-patila-triply-25l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:14:01'),
(309, 'SST10G HAWKINS T-PAN STEEL G/L 1L', '7323', '12', 'sst10g-hawkins-t-pan-steel-gl-1l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:51', '2024-12-02 08:13:59'),
(310, 'SST15G HAWKINS T-PAN SS G/L 1.5L', '7323', '12', 'sst15g-hawkins-t-pan-ss-gl-15l', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:52', '2025-02-04 02:04:45'),
(311, 'SST20G HAWKINS T-PAN STEEL G/L 2L', '7323', '12', 'sst20g-hawkins-t-pan-steel-gl-2l', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:52', '2025-01-24 02:24:18'),
(312, 'SSTV22 HAWKINS TAVA STEEL TRIPLY 22CM', '7323', '12', 'sstv22-hawkins-tava-steel-triply-22cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:52', '2024-12-02 08:14:01'),
(313, 'SSTV24 HAWKINS TAVA STEEL TRIPLY 24CM', '7323', '12', 'sstv24-hawkins-tava-steel-triply-24cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:52', '2024-12-02 08:14:01'),
(314, 'SSTV26 HAWKINS TAVA STEEL TRIPLY 26CM', '7323', '12', 'sstv26-hawkins-tava-steel-triply-26cm', 10, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:52', '2024-12-02 08:14:01'),
(315, 'UBC125G HAWKINS CASSEROLE AQUA BABY G/L 1.25L', '7615', '12', 'ubc125g-hawkins-casserole-aqua-baby-gl-125l', 10, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-02 08:06:52', '2025-01-24 02:24:08'),
(316, 'Sujata Mixer Grinder Dynamix 900W', '8516', '18', 'sujata-mixer-grinder-dynamix-900w', 6, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-03 23:42:45', '2024-12-04 00:00:30'),
(317, 'Sujata Mixer Grinder Supermix 900W', '8516', '18', 'sujata-mixer-grinder-supermic-900w', 6, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-03 23:42:45', '2024-12-05 01:32:47'),
(318, 'Sujata Juicer Powermatic 900W', '8516', '18', 'sujata-juicer-powermatic-900w', 6, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-03 23:42:45', '2025-02-04 02:04:45'),
(319, 'Sujata Juicer Mixer Grinder Powermatic Plus 900W', '8516', '18', 'sujata-juicer-mixer-grinder-powermatic-plus-900w', 6, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-03 23:42:45', '2024-12-04 00:00:32'),
(320, 'Philips Mixer Grinder 750W HL7757', '8516', '18', 'philips-mixer-grinder-750w-hl7757', 6, NULL, NULL, 4, NULL, 1, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-03 23:42:45', '2025-01-24 02:23:47'),
(321, 'MILTON VACUUM FLASK ANCY 500ML', '9617', '18', 'milton-vacuum-flask-ancy-500ml', 5, NULL, NULL, 4, NULL, 1, NULL, '875.00', NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-05 05:38:57', '2025-01-24 02:23:34'),
(322, 'MILTON VACUUM FLASK ANCY 750 ML', '9617', '18', 'milton-vacuum-flask-ancy-750-ml', 5, NULL, NULL, 4, NULL, 1, NULL, '1075.00', NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-05 05:59:36', '2025-01-24 02:23:15'),
(323, 'MILTON VACUUM FLASK ARTESIA 600', '9617', '18', 'milton-vacuum-flask-artesia-600', 5, NULL, NULL, NULL, NULL, 1, NULL, '845.00', NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2024-12-05 06:07:29', '2025-02-04 02:04:45');

-- --------------------------------------------------------

--
-- Table structure for table `product_additional_features`
--

CREATE TABLE `product_additional_features` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `additional_feature_id` int(10) UNSIGNED NOT NULL,
  `product_additional_featur_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `attributes_id` int(10) UNSIGNED NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `attributes_id`, `sort_order`, `created_at`, `updated_at`) VALUES
(988, 139, 18, 0, '2024-12-02 07:13:20', '2024-12-02 07:13:20'),
(989, 139, 19, 0, '2024-12-02 07:13:20', '2024-12-02 07:13:20'),
(990, 139, 20, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(991, 139, 21, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(992, 139, 24, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1008, 143, 18, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1009, 143, 19, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1010, 143, 20, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1011, 143, 21, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1012, 143, 24, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1013, 144, 18, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1014, 144, 19, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1015, 144, 20, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1016, 144, 21, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1017, 144, 24, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1018, 145, 18, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1019, 145, 19, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1020, 145, 20, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1021, 145, 21, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1022, 145, 24, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1023, 146, 18, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1024, 146, 19, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1025, 146, 20, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1026, 146, 21, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1027, 146, 24, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1028, 147, 18, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1029, 147, 19, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1030, 147, 20, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1031, 147, 21, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1032, 147, 24, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1033, 148, 18, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1034, 148, 19, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1035, 148, 20, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1036, 148, 21, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1037, 148, 24, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1038, 149, 18, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1039, 149, 19, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1040, 149, 20, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1041, 149, 21, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1042, 149, 24, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1043, 150, 18, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1044, 150, 19, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1045, 150, 20, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1046, 150, 21, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1047, 150, 24, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1048, 151, 18, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1049, 151, 19, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1050, 151, 20, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1051, 151, 21, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1052, 151, 24, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1053, 152, 18, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1054, 152, 19, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1055, 152, 20, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1056, 152, 21, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1057, 152, 24, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1058, 153, 18, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1059, 153, 19, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1060, 153, 20, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1061, 153, 21, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1062, 153, 24, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1063, 154, 18, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1064, 154, 19, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1065, 154, 20, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1066, 154, 21, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1067, 154, 24, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1068, 155, 18, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1069, 155, 19, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1070, 155, 20, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1071, 155, 21, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1072, 155, 24, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1073, 156, 18, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1074, 156, 19, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1075, 156, 20, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1076, 156, 21, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1077, 156, 24, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1078, 157, 18, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1079, 157, 19, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1080, 157, 20, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1081, 157, 21, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1082, 157, 24, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1083, 158, 18, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1084, 158, 19, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1085, 158, 20, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1086, 158, 21, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1087, 158, 24, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1088, 159, 18, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1089, 159, 19, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1090, 159, 20, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1091, 159, 21, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1092, 159, 24, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1093, 160, 18, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1094, 160, 19, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1095, 160, 20, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1096, 160, 21, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1097, 160, 24, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1098, 161, 18, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1099, 161, 19, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1100, 161, 20, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1101, 161, 21, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1102, 161, 24, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1103, 162, 18, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1104, 162, 19, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1105, 162, 20, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1106, 162, 21, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1107, 162, 24, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1108, 163, 18, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1109, 163, 19, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1110, 163, 20, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1111, 163, 21, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1112, 163, 24, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1113, 164, 18, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1114, 164, 19, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1115, 164, 20, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1116, 164, 21, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1117, 164, 24, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1118, 165, 18, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1119, 165, 19, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1120, 165, 20, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1121, 165, 21, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1122, 165, 24, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1123, 166, 18, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1124, 166, 19, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1125, 166, 20, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1126, 166, 21, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1127, 166, 24, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1128, 167, 18, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1129, 167, 19, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1130, 167, 20, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1131, 167, 21, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1132, 167, 24, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1133, 168, 18, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1134, 168, 19, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1135, 168, 20, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1136, 168, 21, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1137, 168, 24, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1138, 169, 18, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1139, 169, 19, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1140, 169, 20, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1141, 169, 21, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1142, 169, 24, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1143, 170, 18, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1144, 170, 19, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1145, 170, 20, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1146, 170, 21, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1147, 170, 24, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1148, 171, 18, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1149, 171, 19, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1150, 171, 20, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1151, 171, 21, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1152, 171, 24, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1153, 172, 18, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1154, 172, 19, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1155, 172, 20, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1156, 172, 21, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1157, 172, 24, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1158, 173, 18, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1159, 173, 19, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1160, 173, 20, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1161, 173, 21, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1162, 173, 24, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1163, 174, 18, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1164, 174, 19, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1165, 174, 20, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1166, 174, 21, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1167, 174, 24, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1168, 175, 18, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1169, 175, 19, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1170, 175, 20, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1171, 175, 21, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1172, 175, 24, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1173, 176, 18, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1174, 176, 19, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1175, 176, 20, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1176, 176, 21, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1177, 176, 24, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1178, 177, 18, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1179, 177, 19, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1180, 177, 20, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1181, 177, 21, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1182, 177, 24, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1183, 178, 18, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1184, 178, 19, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1185, 178, 20, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1186, 178, 21, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1187, 178, 24, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1188, 179, 18, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1189, 179, 19, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1190, 179, 20, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1191, 179, 21, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1192, 179, 24, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1193, 180, 18, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1194, 180, 19, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1195, 180, 20, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1196, 180, 21, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1197, 180, 24, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1198, 181, 18, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1199, 181, 19, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1200, 181, 20, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1201, 181, 21, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1202, 181, 24, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1203, 182, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1204, 182, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1205, 182, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1206, 182, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1207, 182, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1208, 183, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1209, 183, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1210, 183, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1211, 183, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1212, 183, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1213, 184, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1214, 184, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1215, 184, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1216, 184, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1217, 184, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1218, 185, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1219, 185, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1220, 185, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1221, 185, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1222, 185, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1223, 186, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1224, 186, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1225, 186, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1226, 186, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1227, 186, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1228, 187, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1229, 187, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1230, 187, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1231, 187, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1232, 187, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1233, 188, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1234, 188, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1235, 188, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1236, 188, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1237, 188, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1238, 189, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1239, 189, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1240, 189, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1241, 189, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1242, 189, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1243, 190, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1244, 190, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1245, 190, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1246, 190, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1247, 190, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1248, 191, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1249, 191, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1250, 191, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1251, 191, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1252, 191, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1253, 192, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1254, 192, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1255, 192, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1256, 192, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1257, 192, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1258, 193, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1259, 193, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1260, 193, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1261, 193, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1262, 193, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1263, 194, 18, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1264, 194, 19, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1265, 194, 20, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1266, 194, 21, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1267, 194, 24, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1268, 195, 18, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1269, 195, 19, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1270, 195, 20, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1271, 195, 21, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1272, 195, 24, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1273, 196, 18, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1274, 196, 19, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1275, 196, 20, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1276, 196, 21, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1277, 196, 24, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1278, 197, 18, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1279, 197, 19, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1280, 197, 20, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1281, 197, 21, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1282, 197, 24, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1283, 198, 18, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1284, 198, 19, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1285, 198, 20, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1286, 198, 21, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1287, 198, 24, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1288, 199, 18, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1289, 199, 19, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1290, 199, 20, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1291, 199, 21, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1292, 199, 24, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1293, 200, 18, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1294, 200, 19, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1295, 200, 20, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1296, 200, 21, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1297, 200, 24, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1298, 201, 18, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1299, 201, 19, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1300, 201, 20, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1301, 201, 21, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1302, 201, 24, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1303, 202, 18, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1304, 202, 19, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1305, 202, 20, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1306, 202, 21, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1307, 202, 24, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1308, 203, 18, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1309, 203, 19, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1310, 203, 20, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1311, 203, 21, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1312, 203, 24, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1313, 204, 18, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1314, 204, 19, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1315, 204, 20, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1316, 204, 21, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1317, 204, 24, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1318, 205, 18, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1319, 205, 19, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1320, 205, 20, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1321, 205, 21, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1322, 205, 24, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1323, 206, 18, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1324, 206, 19, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1325, 206, 20, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1326, 206, 21, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1327, 206, 24, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1328, 207, 18, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1329, 207, 19, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1330, 207, 20, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1331, 207, 21, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1332, 207, 24, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1333, 208, 18, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1334, 208, 19, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1335, 208, 20, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1336, 208, 21, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1337, 208, 24, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1338, 209, 18, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1339, 209, 19, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1340, 209, 20, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1341, 209, 21, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1342, 209, 24, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1343, 210, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1344, 210, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1345, 210, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1346, 210, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1347, 210, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1348, 211, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1349, 211, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1350, 211, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1351, 211, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1352, 211, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1353, 212, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1354, 212, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1355, 212, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1356, 212, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1357, 212, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1358, 213, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1359, 213, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1360, 213, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1361, 213, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1362, 213, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1363, 214, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1364, 214, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1365, 214, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1366, 214, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1367, 214, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1368, 215, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1369, 215, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1370, 215, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1371, 215, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1372, 215, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1373, 216, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1374, 216, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1375, 216, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1376, 216, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1377, 216, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1378, 217, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1379, 217, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1380, 217, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1381, 217, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1382, 217, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1383, 218, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1384, 218, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1385, 218, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1386, 218, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1387, 218, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1388, 219, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1389, 219, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1390, 219, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1391, 219, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1392, 219, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1393, 220, 18, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1394, 220, 19, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1395, 220, 20, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1396, 220, 22, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1397, 220, 24, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1398, 221, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1399, 221, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1400, 221, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1401, 221, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1402, 221, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1403, 222, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1404, 222, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1405, 222, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1406, 222, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1407, 222, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1408, 223, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1409, 223, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1410, 223, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1411, 223, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1412, 223, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1413, 224, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1414, 224, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1415, 224, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1416, 224, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1417, 224, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1418, 225, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1419, 225, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1420, 225, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1421, 225, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1422, 225, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1423, 226, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1424, 226, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1425, 226, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1426, 226, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1427, 226, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1428, 227, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1429, 227, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1430, 227, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1431, 227, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1432, 227, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1433, 228, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1434, 228, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1435, 228, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1436, 228, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1437, 228, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1438, 229, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1439, 229, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1440, 229, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1441, 229, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1442, 229, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1443, 230, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1444, 230, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1445, 230, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1446, 230, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1447, 230, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1448, 231, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1449, 231, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1450, 231, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1451, 231, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1452, 231, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1453, 232, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1454, 232, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1455, 232, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1456, 232, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1457, 232, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1458, 233, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1459, 233, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1460, 233, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1461, 233, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1462, 233, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1463, 234, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1464, 234, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1465, 234, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1466, 234, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1467, 234, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1468, 235, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1469, 235, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1470, 235, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1471, 235, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1472, 235, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1473, 236, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1474, 236, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1475, 236, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1476, 236, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1477, 236, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1478, 237, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1479, 237, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1480, 237, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1481, 237, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1482, 237, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1488, 239, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1489, 239, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1490, 239, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1491, 239, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1492, 239, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1493, 240, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1494, 240, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1495, 240, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1496, 240, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1497, 240, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1498, 241, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1499, 241, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1500, 241, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1501, 241, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1502, 241, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1503, 242, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1504, 242, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1505, 242, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1506, 242, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1507, 242, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1508, 243, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1509, 243, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1510, 243, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1511, 243, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1512, 243, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1513, 244, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1514, 244, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1515, 244, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1516, 244, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1517, 244, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1518, 245, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1519, 245, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1520, 245, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1521, 245, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1522, 245, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1523, 246, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1524, 246, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1525, 246, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1526, 246, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1527, 246, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1528, 247, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1529, 247, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1530, 247, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1531, 247, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1532, 247, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1533, 248, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1534, 248, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1535, 248, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1536, 248, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1537, 248, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1538, 249, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1539, 249, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1540, 249, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1541, 249, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1542, 249, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1543, 250, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1544, 250, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1545, 250, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1546, 250, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1547, 250, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1553, 252, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1554, 252, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1555, 252, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1556, 252, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1557, 252, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1558, 253, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1559, 253, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1560, 253, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1561, 253, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1562, 253, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1563, 254, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1564, 254, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1565, 254, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1566, 254, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1567, 254, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1568, 255, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1569, 255, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1570, 255, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1571, 255, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1572, 255, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1573, 256, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1574, 256, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1575, 256, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1576, 256, 22, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1577, 256, 24, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1578, 257, 18, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1579, 257, 19, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1580, 257, 20, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1581, 257, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1582, 257, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1583, 258, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1584, 258, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1585, 258, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1586, 258, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1587, 258, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1593, 260, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1594, 260, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1595, 260, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1596, 260, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1597, 260, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1598, 261, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1599, 261, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1600, 261, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1601, 261, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1602, 261, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1603, 262, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1604, 262, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1605, 262, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1606, 262, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1607, 262, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1608, 263, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1609, 263, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1610, 263, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1611, 263, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1612, 263, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1613, 264, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1614, 264, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1615, 264, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1616, 264, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1617, 264, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1618, 265, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1619, 265, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1620, 265, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1621, 265, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1622, 265, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1623, 266, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1624, 266, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1625, 266, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1626, 266, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1627, 266, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1628, 267, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1629, 267, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1630, 267, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1631, 267, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1632, 267, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1633, 268, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1634, 268, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1635, 268, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1636, 268, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1637, 268, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1638, 269, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1639, 269, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1640, 269, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1641, 269, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1642, 269, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1643, 270, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1644, 270, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1645, 270, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1646, 270, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1647, 270, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1648, 271, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1649, 271, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1650, 271, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1651, 271, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1652, 271, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1658, 273, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1659, 273, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1660, 273, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1661, 273, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1662, 273, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1663, 274, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1664, 274, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1665, 274, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1666, 274, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1667, 274, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1668, 275, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1669, 275, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1670, 275, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1671, 275, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1672, 275, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1673, 276, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1674, 276, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1675, 276, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1676, 276, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1677, 276, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1678, 277, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1679, 277, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1680, 277, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1681, 277, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1682, 277, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1683, 278, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1684, 278, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1685, 278, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1686, 278, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1687, 278, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1688, 279, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1689, 279, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1690, 279, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1691, 279, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1692, 279, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1693, 280, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1694, 280, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1695, 280, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1696, 280, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1697, 280, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1698, 281, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1699, 281, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1700, 281, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1701, 281, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1702, 281, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1703, 282, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1704, 282, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1705, 282, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1706, 282, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1707, 282, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1708, 283, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1709, 283, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1710, 283, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1711, 283, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1712, 283, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1713, 284, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1714, 284, 19, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1715, 284, 20, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1716, 284, 22, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1717, 284, 24, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1718, 285, 18, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1719, 285, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1720, 285, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1721, 285, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1722, 285, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1723, 286, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1724, 286, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1725, 286, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1726, 286, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1727, 286, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1728, 287, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1729, 287, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1730, 287, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1731, 287, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1732, 287, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1733, 288, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1734, 288, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1735, 288, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1736, 288, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1737, 288, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1743, 290, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1744, 290, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1745, 290, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1746, 290, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1747, 290, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1748, 291, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1749, 291, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1750, 291, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1751, 291, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1752, 291, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1753, 292, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1754, 292, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1755, 292, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1756, 292, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1757, 292, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1758, 293, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1759, 293, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1760, 293, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1761, 293, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1762, 293, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1768, 295, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1769, 295, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1770, 295, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1771, 295, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1772, 295, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1778, 297, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1779, 297, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1780, 297, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1781, 297, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1782, 297, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1783, 298, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1784, 298, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1785, 298, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1786, 298, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1787, 298, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1788, 299, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1789, 299, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1790, 299, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1791, 299, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1792, 299, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1793, 300, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1794, 300, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1795, 300, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1796, 300, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1797, 300, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1798, 301, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1799, 301, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1800, 301, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1801, 301, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1802, 301, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1803, 302, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1804, 302, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1805, 302, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1806, 302, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1807, 302, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1808, 303, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1809, 303, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1810, 303, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1811, 303, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1812, 303, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1813, 304, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1814, 304, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1815, 304, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1816, 304, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51');
INSERT INTO `product_attributes` (`id`, `product_id`, `attributes_id`, `sort_order`, `created_at`, `updated_at`) VALUES
(1817, 304, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1818, 305, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1819, 305, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1820, 305, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1821, 305, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1822, 305, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1823, 306, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1824, 306, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1825, 306, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1826, 306, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1827, 306, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1828, 307, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1829, 307, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1830, 307, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1831, 307, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1832, 307, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1833, 308, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1834, 308, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1835, 308, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1836, 308, 22, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1837, 308, 24, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1838, 309, 18, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1839, 309, 19, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1840, 309, 20, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1841, 309, 22, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1842, 309, 24, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1853, 312, 18, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1854, 312, 19, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1855, 312, 20, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1856, 312, 22, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1857, 312, 24, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1858, 313, 18, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1859, 313, 19, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1860, 313, 20, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1861, 313, 22, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1862, 313, 24, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1863, 314, 18, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1864, 314, 19, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1865, 314, 20, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1866, 314, 22, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1867, 314, 24, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1873, 316, 18, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1874, 316, 19, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1875, 316, 22, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1876, 316, 23, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1885, 319, 18, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1886, 319, 19, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1887, 319, 22, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1888, 319, 23, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1893, 317, 18, 0, '2024-12-05 01:32:47', '2024-12-05 01:32:47'),
(1894, 317, 19, 1, '2024-12-05 01:32:47', '2024-12-05 01:32:47'),
(1895, 317, 22, 2, '2024-12-05 01:32:47', '2024-12-05 01:32:47'),
(1896, 317, 23, 3, '2024-12-05 01:32:47', '2024-12-05 01:32:47'),
(1897, 294, 18, 0, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(1898, 294, 19, 1, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(1899, 294, 20, 2, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(1900, 294, 22, 3, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(1901, 294, 24, 4, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(1932, 140, 18, 0, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(1933, 140, 19, 1, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(1934, 140, 20, 2, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(1935, 140, 21, 3, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(1936, 140, 24, 4, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(1937, 141, 18, 0, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(1938, 141, 19, 1, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(1939, 141, 20, 2, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(1940, 141, 21, 3, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(1941, 141, 24, 4, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(1942, 142, 18, 0, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(1943, 142, 19, 1, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(1944, 142, 20, 2, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(1945, 142, 21, 3, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(1946, 142, 24, 4, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(1947, 259, 18, 0, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(1948, 259, 19, 1, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(1949, 259, 20, 2, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(1950, 259, 22, 3, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(1951, 259, 24, 4, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(1956, 322, 22, 0, '2025-01-24 02:23:15', '2025-01-24 02:23:15'),
(1957, 322, 18, 1, '2025-01-24 02:23:15', '2025-01-24 02:23:15'),
(1958, 322, 19, 2, '2025-01-24 02:23:15', '2025-01-24 02:23:15'),
(1959, 321, 22, 0, '2025-01-24 02:23:34', '2025-01-24 02:23:34'),
(1960, 321, 18, 1, '2025-01-24 02:23:34', '2025-01-24 02:23:34'),
(1961, 321, 19, 2, '2025-01-24 02:23:34', '2025-01-24 02:23:34'),
(1962, 320, 18, 0, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(1963, 320, 19, 1, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(1964, 320, 22, 2, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(1965, 320, 23, 3, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(1966, 318, 18, 0, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(1967, 318, 19, 1, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(1968, 318, 22, 2, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(1969, 318, 23, 3, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(1970, 315, 18, 0, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(1971, 315, 19, 1, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(1972, 315, 20, 2, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(1973, 315, 22, 3, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(1974, 315, 24, 4, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(1975, 311, 18, 0, '2025-01-24 02:24:18', '2025-01-24 02:24:18'),
(1976, 311, 19, 1, '2025-01-24 02:24:18', '2025-01-24 02:24:18'),
(1977, 311, 20, 2, '2025-01-24 02:24:18', '2025-01-24 02:24:18'),
(1978, 311, 22, 3, '2025-01-24 02:24:18', '2025-01-24 02:24:18'),
(1979, 311, 24, 4, '2025-01-24 02:24:18', '2025-01-24 02:24:18'),
(1980, 310, 18, 0, '2025-01-24 02:24:27', '2025-01-24 02:24:27'),
(1981, 310, 19, 1, '2025-01-24 02:24:27', '2025-01-24 02:24:27'),
(1982, 310, 20, 2, '2025-01-24 02:24:27', '2025-01-24 02:24:27'),
(1983, 310, 22, 3, '2025-01-24 02:24:27', '2025-01-24 02:24:27'),
(1984, 310, 24, 4, '2025-01-24 02:24:27', '2025-01-24 02:24:27'),
(1985, 296, 18, 0, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(1986, 296, 19, 1, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(1987, 296, 20, 2, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(1988, 296, 22, 3, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(1989, 296, 24, 4, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(1990, 289, 18, 0, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(1991, 289, 19, 1, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(1992, 289, 20, 2, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(1993, 289, 22, 3, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(1994, 289, 24, 4, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(1995, 272, 18, 0, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(1996, 272, 19, 1, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(1997, 272, 20, 2, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(1998, 272, 22, 3, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(1999, 272, 24, 4, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(2000, 251, 18, 0, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(2001, 251, 19, 1, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(2002, 251, 20, 2, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(2003, 251, 22, 3, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(2004, 251, 24, 4, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(2005, 238, 18, 0, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(2006, 238, 19, 1, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(2007, 238, 20, 2, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(2008, 238, 22, 3, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(2009, 238, 24, 4, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(2010, 323, 22, 0, '2025-01-24 03:28:04', '2025-01-24 03:28:04'),
(2011, 323, 18, 1, '2025-01-24 03:28:04', '2025-01-24 03:28:04'),
(2012, 323, 19, 2, '2025-01-24 03:28:04', '2025-01-24 03:28:04'),
(2013, 323, 21, 3, '2025-01-24 03:28:04', '2025-01-24 03:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes_values`
--

CREATE TABLE `product_attributes_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_attribute_id` int(10) UNSIGNED NOT NULL,
  `attributes_value_id` int(10) UNSIGNED NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attributes_values`
--

INSERT INTO `product_attributes_values` (`id`, `product_id`, `product_attribute_id`, `attributes_value_id`, `sort_order`, `created_at`, `updated_at`) VALUES
(1090, 139, 988, 55, 0, '2024-12-02 07:13:20', '2024-12-02 07:13:20'),
(1091, 139, 989, 87, 0, '2024-12-02 07:13:20', '2024-12-02 07:13:20'),
(1092, 139, 990, 57, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1093, 139, 991, 88, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1094, 139, 992, 89, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1110, 143, 1008, 55, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1111, 143, 1009, 61, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1112, 143, 1010, 57, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1113, 143, 1011, 92, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1114, 143, 1012, 89, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1115, 144, 1013, 55, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1116, 144, 1014, 93, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1117, 144, 1015, 57, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1118, 144, 1016, 92, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1119, 144, 1017, 89, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1120, 145, 1018, 55, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1121, 145, 1019, 94, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1122, 145, 1020, 57, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1123, 145, 1021, 92, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1124, 145, 1022, 89, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1125, 146, 1023, 55, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1126, 146, 1024, 59, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1127, 146, 1025, 57, 0, '2024-12-02 07:13:21', '2024-12-02 07:13:21'),
(1128, 146, 1026, 92, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1129, 146, 1027, 89, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1130, 147, 1028, 55, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1131, 147, 1029, 60, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1132, 147, 1030, 57, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1133, 147, 1031, 92, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1134, 147, 1032, 89, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1135, 148, 1033, 55, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1136, 148, 1034, 60, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1137, 148, 1035, 57, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1138, 148, 1036, 92, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1139, 148, 1037, 89, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1140, 149, 1038, 55, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1141, 149, 1039, 95, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1142, 149, 1040, 57, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1143, 149, 1041, 92, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1144, 149, 1042, 89, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1145, 150, 1043, 55, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1146, 150, 1044, 61, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1147, 150, 1045, 57, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1148, 150, 1046, 92, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1149, 150, 1047, 89, 0, '2024-12-02 07:13:22', '2024-12-02 07:13:22'),
(1150, 151, 1048, 55, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1151, 151, 1049, 61, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1152, 151, 1050, 57, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1153, 151, 1051, 92, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1154, 151, 1052, 89, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1155, 152, 1053, 55, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1156, 152, 1054, 96, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1157, 152, 1055, 57, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1158, 152, 1056, 92, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1159, 152, 1057, 89, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1160, 153, 1058, 55, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1161, 153, 1059, 96, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1162, 153, 1060, 57, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1163, 153, 1061, 92, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1164, 153, 1062, 89, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1165, 154, 1063, 55, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1166, 154, 1064, 60, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1167, 154, 1065, 57, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1168, 154, 1066, 92, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1169, 154, 1067, 89, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1170, 155, 1068, 55, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1171, 155, 1069, 61, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1172, 155, 1070, 57, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1173, 155, 1071, 92, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1174, 155, 1072, 89, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1175, 156, 1073, 55, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1176, 156, 1074, 61, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1177, 156, 1075, 65, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1178, 156, 1076, 97, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1179, 156, 1077, 89, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1180, 157, 1078, 55, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1181, 157, 1079, 61, 0, '2024-12-02 07:13:23', '2024-12-02 07:13:23'),
(1182, 157, 1080, 72, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1183, 157, 1081, 64, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1184, 157, 1082, 89, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1185, 158, 1083, 55, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1186, 158, 1084, 59, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1187, 158, 1085, 72, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1188, 158, 1086, 64, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1189, 158, 1087, 89, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1190, 159, 1088, 55, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1191, 159, 1089, 61, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1192, 159, 1090, 72, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1193, 159, 1091, 64, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1194, 159, 1092, 89, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1195, 160, 1093, 55, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1196, 160, 1094, 60, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1197, 160, 1095, 72, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1198, 160, 1096, 64, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1199, 160, 1097, 89, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1200, 161, 1098, 55, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1201, 161, 1099, 61, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1202, 161, 1100, 72, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1203, 161, 1101, 64, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1204, 161, 1102, 89, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1205, 162, 1103, 55, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1206, 162, 1104, 61, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1207, 162, 1105, 72, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1208, 162, 1106, 68, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1209, 162, 1107, 89, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1210, 163, 1108, 55, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1211, 163, 1109, 59, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1212, 163, 1110, 72, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1213, 163, 1111, 68, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1214, 163, 1112, 89, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1215, 164, 1113, 55, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1216, 164, 1114, 61, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1217, 164, 1115, 72, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1218, 164, 1116, 68, 0, '2024-12-02 07:13:24', '2024-12-02 07:13:24'),
(1219, 164, 1117, 89, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1220, 165, 1118, 55, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1221, 165, 1119, 60, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1222, 165, 1120, 72, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1223, 165, 1121, 68, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1224, 165, 1122, 89, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1225, 166, 1123, 55, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1226, 166, 1124, 61, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1227, 166, 1125, 72, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1228, 166, 1126, 68, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1229, 166, 1127, 89, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1230, 167, 1128, 55, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1231, 167, 1129, 60, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1232, 167, 1130, 57, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1233, 167, 1131, 98, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1234, 167, 1132, 89, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1235, 168, 1133, 55, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1236, 168, 1134, 61, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1237, 168, 1135, 65, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1238, 168, 1136, 99, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1239, 168, 1137, 89, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1240, 169, 1138, 55, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1241, 169, 1139, 59, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1242, 169, 1140, 65, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1243, 169, 1141, 99, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1244, 169, 1142, 89, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1245, 170, 1143, 55, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1246, 170, 1144, 61, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1247, 170, 1145, 65, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1248, 170, 1146, 99, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1249, 170, 1147, 89, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1250, 171, 1148, 55, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1251, 171, 1149, 60, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1252, 171, 1150, 65, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1253, 171, 1151, 99, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1254, 171, 1152, 89, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1255, 172, 1153, 55, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1256, 172, 1154, 61, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1257, 172, 1155, 65, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1258, 172, 1156, 99, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1259, 172, 1157, 89, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1260, 173, 1158, 55, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1261, 173, 1159, 61, 0, '2024-12-02 07:13:25', '2024-12-02 07:13:25'),
(1262, 173, 1160, 57, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1263, 173, 1161, 63, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1264, 173, 1162, 89, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1265, 174, 1163, 55, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1266, 174, 1164, 59, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1267, 174, 1165, 57, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1268, 174, 1166, 63, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1269, 174, 1167, 89, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1270, 175, 1168, 55, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1271, 175, 1169, 61, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1272, 175, 1170, 57, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1273, 175, 1171, 63, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1274, 175, 1172, 89, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1275, 176, 1173, 55, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1276, 176, 1174, 60, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1277, 176, 1175, 57, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1278, 176, 1176, 63, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1279, 176, 1177, 89, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1280, 177, 1178, 55, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1281, 177, 1179, 95, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1282, 177, 1180, 57, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1283, 177, 1181, 63, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1284, 177, 1182, 89, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1285, 178, 1183, 55, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1286, 178, 1184, 61, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1287, 178, 1185, 57, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1288, 178, 1186, 63, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1289, 178, 1187, 89, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1290, 179, 1188, 55, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1291, 179, 1189, 61, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1292, 179, 1190, 57, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1293, 179, 1191, 63, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1294, 179, 1192, 89, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1295, 180, 1193, 55, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1296, 180, 1194, 60, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1297, 180, 1195, 57, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1298, 180, 1196, 100, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1299, 180, 1197, 89, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1300, 181, 1198, 55, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1301, 181, 1199, 61, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1302, 181, 1200, 72, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1303, 181, 1201, 73, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1304, 181, 1202, 89, 0, '2024-12-02 07:13:26', '2024-12-02 07:13:26'),
(1305, 182, 1203, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1306, 182, 1204, 101, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1307, 182, 1205, 72, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1308, 182, 1206, 73, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1309, 182, 1207, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1310, 183, 1208, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1311, 183, 1209, 60, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1312, 183, 1210, 72, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1313, 183, 1211, 73, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1314, 183, 1212, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1315, 184, 1213, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1316, 184, 1214, 61, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1317, 184, 1215, 65, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1318, 184, 1216, 102, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1319, 184, 1217, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1320, 185, 1218, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1321, 185, 1219, 59, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1322, 185, 1220, 57, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1323, 185, 1221, 103, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1324, 185, 1222, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1325, 186, 1223, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1326, 186, 1224, 61, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1327, 186, 1225, 57, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1328, 186, 1226, 103, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1329, 186, 1227, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1330, 187, 1228, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1331, 187, 1229, 61, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1332, 187, 1230, 57, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1333, 187, 1231, 103, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1334, 187, 1232, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1335, 188, 1233, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1336, 188, 1234, 61, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1337, 188, 1235, 57, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1338, 188, 1236, 103, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1339, 188, 1237, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1340, 189, 1238, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1341, 189, 1239, 60, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1342, 189, 1240, 57, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1343, 189, 1241, 103, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1344, 189, 1242, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1345, 190, 1243, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1346, 190, 1244, 61, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1347, 190, 1245, 57, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1348, 190, 1246, 104, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1349, 190, 1247, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1350, 191, 1248, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1351, 191, 1249, 60, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1352, 191, 1250, 57, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1353, 191, 1251, 104, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1354, 191, 1252, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1355, 192, 1253, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1356, 192, 1254, 95, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1357, 192, 1255, 57, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1358, 192, 1256, 104, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1359, 192, 1257, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1360, 193, 1258, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1361, 193, 1259, 61, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1362, 193, 1260, 57, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1363, 193, 1261, 104, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1364, 193, 1262, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1365, 194, 1263, 55, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1366, 194, 1264, 67, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1367, 194, 1265, 57, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1368, 194, 1266, 104, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1369, 194, 1267, 89, 0, '2024-12-02 07:13:27', '2024-12-02 07:13:27'),
(1370, 195, 1268, 55, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1371, 195, 1269, 59, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1372, 195, 1270, 57, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1373, 195, 1271, 105, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1374, 195, 1272, 89, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1375, 196, 1273, 55, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1376, 196, 1274, 60, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1377, 196, 1275, 57, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1378, 196, 1276, 105, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1379, 196, 1277, 89, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1380, 197, 1278, 55, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1381, 197, 1279, 61, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1382, 197, 1280, 57, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1383, 197, 1281, 105, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1384, 197, 1282, 89, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1385, 198, 1283, 55, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1386, 198, 1284, 61, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1387, 198, 1285, 65, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1388, 198, 1286, 75, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1389, 198, 1287, 89, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1390, 199, 1288, 55, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1391, 199, 1289, 93, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1392, 199, 1290, 65, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1393, 199, 1291, 75, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1394, 199, 1292, 89, 0, '2024-12-02 07:13:28', '2024-12-02 07:13:28'),
(1395, 200, 1293, 55, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1396, 200, 1294, 59, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1397, 200, 1295, 65, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1398, 200, 1296, 75, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1399, 200, 1297, 89, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1400, 201, 1298, 55, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1401, 201, 1299, 60, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1402, 201, 1300, 65, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1403, 201, 1301, 75, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1404, 201, 1302, 89, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1405, 202, 1303, 55, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1406, 202, 1304, 60, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1407, 202, 1305, 65, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1408, 202, 1306, 75, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1409, 202, 1307, 89, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1410, 203, 1308, 55, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1411, 203, 1309, 95, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1412, 203, 1310, 65, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1413, 203, 1311, 75, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1414, 203, 1312, 89, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1415, 204, 1313, 55, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1416, 204, 1314, 61, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1417, 204, 1315, 65, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1418, 204, 1316, 75, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1419, 204, 1317, 89, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1420, 205, 1318, 55, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1421, 205, 1319, 67, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1422, 205, 1320, 65, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1423, 205, 1321, 75, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1424, 205, 1322, 89, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1425, 206, 1323, 55, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1426, 206, 1324, 96, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1427, 206, 1325, 65, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1428, 206, 1326, 75, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1429, 206, 1327, 89, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1430, 207, 1328, 55, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1431, 207, 1329, 61, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1432, 207, 1330, 65, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1433, 207, 1331, 97, 0, '2024-12-02 07:13:29', '2024-12-02 07:24:25'),
(1434, 207, 1332, 89, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1435, 208, 1333, 55, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1436, 208, 1334, 61, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1437, 208, 1335, 65, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1438, 208, 1336, 97, 0, '2024-12-02 07:13:29', '2024-12-02 07:24:25'),
(1439, 208, 1337, 89, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1440, 209, 1338, 55, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1441, 209, 1339, 61, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1442, 209, 1340, 65, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1443, 209, 1341, 97, 0, '2024-12-02 07:13:29', '2024-12-02 07:24:25'),
(1444, 209, 1342, 89, 0, '2024-12-02 07:13:29', '2024-12-02 07:13:29'),
(1445, 210, 1343, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1446, 210, 1344, 108, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1447, 210, 1345, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1448, 210, 1346, 109, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1449, 210, 1347, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1450, 211, 1348, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1451, 211, 1349, 59, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1452, 211, 1350, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1453, 211, 1351, 110, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1454, 211, 1352, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1455, 212, 1353, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1456, 212, 1354, 61, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1457, 212, 1355, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1458, 212, 1356, 110, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1459, 212, 1357, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1460, 213, 1358, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1461, 213, 1359, 111, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1462, 213, 1360, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1463, 213, 1361, 112, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1464, 213, 1362, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1465, 214, 1363, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1466, 214, 1364, 113, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1467, 214, 1365, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1468, 214, 1366, 114, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1469, 214, 1367, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1470, 215, 1368, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1471, 215, 1369, 115, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1472, 215, 1370, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1473, 215, 1371, 112, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1474, 215, 1372, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1475, 216, 1373, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1476, 216, 1374, 115, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1477, 216, 1375, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1478, 216, 1376, 112, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1479, 216, 1377, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1480, 217, 1378, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1481, 217, 1379, 95, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1482, 217, 1380, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1483, 217, 1381, 112, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1484, 217, 1382, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1485, 218, 1383, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1486, 218, 1384, 61, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1487, 218, 1385, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1488, 218, 1386, 112, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1489, 218, 1387, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1490, 219, 1388, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1491, 219, 1389, 116, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1492, 219, 1390, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1493, 219, 1391, 117, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1494, 219, 1392, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1495, 220, 1393, 107, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1496, 220, 1394, 118, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1497, 220, 1395, 72, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1498, 220, 1396, 119, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1499, 220, 1397, 89, 0, '2024-12-02 08:06:48', '2024-12-02 08:06:48'),
(1500, 221, 1398, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1501, 221, 1399, 120, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1502, 221, 1400, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1503, 221, 1401, 121, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1504, 221, 1402, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1505, 222, 1403, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1506, 222, 1404, 122, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1507, 222, 1405, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1508, 222, 1406, 121, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1509, 222, 1407, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1510, 223, 1408, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1511, 223, 1409, 122, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1512, 223, 1410, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1513, 223, 1411, 121, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1514, 223, 1412, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1515, 224, 1413, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1516, 224, 1414, 123, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1517, 224, 1415, 124, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1518, 224, 1416, 114, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1519, 224, 1417, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1520, 225, 1418, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1521, 225, 1419, 125, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1522, 225, 1420, 126, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1523, 225, 1421, 127, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1524, 225, 1422, 84, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1525, 226, 1423, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1526, 226, 1424, 125, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1527, 226, 1425, 128, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1528, 226, 1426, 129, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1529, 226, 1427, 84, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1530, 227, 1428, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1531, 227, 1429, 120, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1532, 227, 1430, 128, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1533, 227, 1431, 130, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1534, 227, 1432, 84, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1535, 228, 1433, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1536, 228, 1434, 94, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1537, 228, 1435, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1538, 228, 1436, 131, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1539, 228, 1437, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1540, 229, 1438, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1541, 229, 1439, 116, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1542, 229, 1440, 128, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1543, 229, 1441, 117, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1544, 229, 1442, 84, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1545, 230, 1443, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1546, 230, 1444, 108, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1547, 230, 1445, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1548, 230, 1446, 132, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1549, 230, 1447, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1550, 231, 1448, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1551, 231, 1449, 133, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1552, 231, 1450, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1553, 231, 1451, 132, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1554, 231, 1452, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1555, 232, 1453, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1556, 232, 1454, 108, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1557, 232, 1455, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1558, 232, 1456, 134, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1559, 232, 1457, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1560, 233, 1458, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1561, 233, 1459, 135, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1562, 233, 1460, 128, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1563, 233, 1461, 110, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1564, 233, 1462, 84, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1565, 234, 1463, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1566, 234, 1464, 61, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1567, 234, 1465, 57, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1568, 234, 1466, 136, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1569, 234, 1467, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1570, 235, 1468, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1571, 235, 1469, 62, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1572, 235, 1470, 57, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1573, 235, 1471, 136, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1574, 235, 1472, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1575, 236, 1473, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1576, 236, 1474, 60, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1577, 236, 1475, 57, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1578, 236, 1476, 136, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1579, 236, 1477, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1580, 237, 1478, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1581, 237, 1479, 61, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1582, 237, 1480, 65, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1583, 237, 1481, 136, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1584, 237, 1482, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1590, 239, 1488, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1591, 239, 1489, 137, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1592, 239, 1490, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1593, 239, 1491, 132, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1594, 239, 1492, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1595, 240, 1493, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1596, 240, 1494, 137, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1597, 240, 1495, 65, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1598, 240, 1496, 132, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1599, 240, 1497, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1600, 241, 1498, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1601, 241, 1499, 138, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1602, 241, 1500, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1603, 241, 1501, 132, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1604, 241, 1502, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1605, 242, 1503, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1606, 242, 1504, 138, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1607, 242, 1505, 81, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1608, 242, 1506, 109, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1609, 242, 1507, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1610, 243, 1508, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1611, 243, 1509, 138, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1612, 243, 1510, 81, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1613, 243, 1511, 109, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1614, 243, 1512, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1615, 244, 1513, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1616, 244, 1514, 139, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1617, 244, 1515, 81, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1618, 244, 1516, 109, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1619, 244, 1517, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1620, 245, 1518, 55, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1621, 245, 1519, 108, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1622, 245, 1520, 140, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1623, 245, 1521, 141, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1624, 245, 1522, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1625, 246, 1523, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1626, 246, 1524, 60, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1627, 246, 1525, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1628, 246, 1526, 110, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1629, 246, 1527, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1630, 247, 1528, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1631, 247, 1529, 60, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1632, 247, 1530, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1633, 247, 1531, 131, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1634, 247, 1532, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1635, 248, 1533, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1636, 248, 1534, 111, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1637, 248, 1535, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1638, 248, 1536, 112, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1639, 248, 1537, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1640, 249, 1538, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1641, 249, 1539, 142, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1642, 249, 1540, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1643, 249, 1541, 112, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1644, 249, 1542, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1645, 250, 1543, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1646, 250, 1544, 142, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1647, 250, 1545, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1648, 250, 1546, 112, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1649, 250, 1547, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1655, 252, 1553, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1656, 252, 1554, 120, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1657, 252, 1555, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1658, 252, 1556, 114, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1659, 252, 1557, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1660, 253, 1558, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1661, 253, 1559, 120, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1662, 253, 1560, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1663, 253, 1561, 114, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1664, 253, 1562, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1665, 254, 1563, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1666, 254, 1564, 144, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1667, 254, 1565, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1668, 254, 1566, 114, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1669, 254, 1567, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1670, 255, 1568, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1671, 255, 1569, 59, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1672, 255, 1570, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1673, 255, 1571, 112, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1674, 255, 1572, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1675, 256, 1573, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1676, 256, 1574, 123, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1677, 256, 1575, 72, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1678, 256, 1576, 121, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1679, 256, 1577, 89, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1680, 257, 1578, 107, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1681, 257, 1579, 122, 0, '2024-12-02 08:06:49', '2024-12-02 08:06:49'),
(1682, 257, 1580, 72, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1683, 257, 1581, 121, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1684, 257, 1582, 89, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1685, 258, 1583, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1686, 258, 1584, 59, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1687, 258, 1585, 72, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1688, 258, 1586, 117, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1689, 258, 1587, 89, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1695, 260, 1593, 55, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1696, 260, 1594, 122, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1697, 260, 1595, 126, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1698, 260, 1596, 127, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1699, 260, 1597, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1700, 261, 1598, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1701, 261, 1599, 111, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1702, 261, 1600, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1703, 261, 1601, 112, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1704, 261, 1602, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1705, 262, 1603, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1706, 262, 1604, 111, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1707, 262, 1605, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1708, 262, 1606, 112, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1709, 262, 1607, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1710, 263, 1608, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1711, 263, 1609, 147, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1712, 263, 1610, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1713, 263, 1611, 121, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1714, 263, 1612, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1715, 264, 1613, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1716, 264, 1614, 125, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1717, 264, 1615, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1718, 264, 1616, 121, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1719, 264, 1617, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1720, 265, 1618, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1721, 265, 1619, 143, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1722, 265, 1620, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1723, 265, 1621, 114, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1724, 265, 1622, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1725, 266, 1623, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1726, 266, 1624, 123, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1727, 266, 1625, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1728, 266, 1626, 114, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1729, 266, 1627, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1730, 267, 1628, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1731, 267, 1629, 125, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1732, 267, 1630, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1733, 267, 1631, 114, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1734, 267, 1632, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1735, 268, 1633, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1736, 268, 1634, 122, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1737, 268, 1635, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1738, 268, 1636, 121, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1739, 268, 1637, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1740, 269, 1638, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1741, 269, 1639, 125, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1742, 269, 1640, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1743, 269, 1641, 121, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1744, 269, 1642, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1745, 270, 1643, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1746, 270, 1644, 148, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1747, 270, 1645, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1748, 270, 1646, 112, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1749, 270, 1647, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1750, 271, 1648, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1751, 271, 1649, 61, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1752, 271, 1650, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1753, 271, 1651, 112, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1754, 271, 1652, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1760, 273, 1658, 55, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1761, 273, 1659, 59, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1762, 273, 1660, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1763, 273, 1661, 110, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1764, 273, 1662, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1765, 274, 1663, 55, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1766, 274, 1664, 60, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1767, 274, 1665, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1768, 274, 1666, 149, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1769, 274, 1667, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1770, 275, 1668, 55, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1771, 275, 1669, 120, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1772, 275, 1670, 126, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1773, 275, 1671, 150, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1774, 275, 1672, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1775, 276, 1673, 55, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1776, 276, 1674, 122, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1777, 276, 1675, 126, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1778, 276, 1676, 150, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1779, 276, 1677, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1780, 277, 1678, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1781, 277, 1679, 60, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1782, 277, 1680, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1783, 277, 1681, 110, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1784, 277, 1682, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1785, 278, 1683, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1786, 278, 1684, 147, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1787, 278, 1685, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1788, 278, 1686, 121, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1789, 278, 1687, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1790, 279, 1688, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1791, 279, 1689, 125, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1792, 279, 1690, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1793, 279, 1691, 121, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1794, 279, 1692, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1795, 280, 1693, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1796, 280, 1694, 151, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1797, 280, 1695, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1798, 280, 1696, 121, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1799, 280, 1697, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1800, 281, 1698, 107, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1801, 281, 1699, 111, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1802, 281, 1700, 128, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1803, 281, 1701, 112, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1804, 281, 1702, 84, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1805, 282, 1703, 55, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1806, 282, 1704, 111, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1807, 282, 1705, 81, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1808, 282, 1706, 112, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1809, 282, 1707, 152, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1810, 283, 1708, 55, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1811, 283, 1709, 147, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1812, 283, 1710, 81, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1813, 283, 1711, 121, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1814, 283, 1712, 152, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1815, 284, 1713, 55, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1816, 284, 1714, 120, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1817, 284, 1715, 81, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1818, 284, 1716, 114, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1819, 284, 1717, 152, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1820, 285, 1718, 55, 0, '2024-12-02 08:06:50', '2024-12-02 08:06:50'),
(1821, 285, 1719, 123, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1822, 285, 1720, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1823, 285, 1721, 121, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1824, 285, 1722, 152, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1825, 286, 1723, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1826, 286, 1724, 122, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1827, 286, 1725, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1828, 286, 1726, 121, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1829, 286, 1727, 152, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1830, 287, 1728, 107, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1831, 287, 1729, 120, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1832, 287, 1730, 128, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51');
INSERT INTO `product_attributes_values` (`id`, `product_id`, `product_attribute_id`, `attributes_value_id`, `sort_order`, `created_at`, `updated_at`) VALUES
(1833, 287, 1731, 121, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1834, 287, 1732, 84, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1835, 288, 1733, 107, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1836, 288, 1734, 122, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1837, 288, 1735, 128, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1838, 288, 1736, 121, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1839, 288, 1737, 84, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1845, 290, 1743, 107, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1846, 290, 1744, 120, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1847, 290, 1745, 128, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1848, 290, 1746, 114, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1849, 290, 1747, 84, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1850, 291, 1748, 107, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1851, 291, 1749, 111, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1852, 291, 1750, 128, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1853, 291, 1751, 112, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1854, 291, 1752, 84, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1855, 292, 1753, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1856, 292, 1754, 111, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1857, 292, 1755, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1858, 292, 1756, 112, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1859, 292, 1757, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1860, 293, 1758, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1861, 293, 1759, 148, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1862, 293, 1760, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1863, 293, 1761, 112, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1864, 293, 1762, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1870, 295, 1768, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1871, 295, 1769, 61, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1872, 295, 1770, 65, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1873, 295, 1771, 110, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1874, 295, 1772, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1880, 297, 1778, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1881, 297, 1779, 111, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1882, 297, 1780, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1883, 297, 1781, 112, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1884, 297, 1782, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1885, 298, 1783, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1886, 298, 1784, 120, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1887, 298, 1785, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1888, 298, 1786, 114, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1889, 298, 1787, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1890, 299, 1788, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1891, 299, 1789, 123, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1892, 299, 1790, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1893, 299, 1791, 114, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1894, 299, 1792, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1895, 300, 1793, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1896, 300, 1794, 59, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1897, 300, 1795, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1898, 300, 1796, 110, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1899, 300, 1797, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1900, 301, 1798, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1901, 301, 1799, 60, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1902, 301, 1800, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1903, 301, 1801, 110, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1904, 301, 1802, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1905, 302, 1803, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1906, 302, 1804, 95, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1907, 302, 1805, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1908, 302, 1806, 110, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1909, 302, 1807, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1910, 303, 1808, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1911, 303, 1809, 61, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1912, 303, 1810, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1913, 303, 1811, 110, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1914, 303, 1812, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1915, 304, 1813, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1916, 304, 1814, 95, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1917, 304, 1815, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1918, 304, 1816, 112, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1919, 304, 1817, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1920, 305, 1818, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1921, 305, 1819, 61, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1922, 305, 1820, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1923, 305, 1821, 112, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1924, 305, 1822, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1925, 306, 1823, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1926, 306, 1824, 115, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1927, 306, 1825, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1928, 306, 1826, 154, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1929, 306, 1827, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1930, 307, 1828, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1931, 307, 1829, 59, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1932, 307, 1830, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1933, 307, 1831, 154, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1934, 307, 1832, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1935, 308, 1833, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1936, 308, 1834, 111, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1937, 308, 1835, 81, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1938, 308, 1836, 154, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1939, 308, 1837, 89, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1940, 309, 1838, 55, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1941, 309, 1839, 116, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1942, 309, 1840, 65, 0, '2024-12-02 08:06:51', '2024-12-02 08:06:51'),
(1943, 309, 1841, 117, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1944, 309, 1842, 89, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1955, 312, 1853, 55, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1956, 312, 1854, 120, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1957, 312, 1855, 81, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1958, 312, 1856, 121, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1959, 312, 1857, 89, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1960, 313, 1858, 55, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1961, 313, 1859, 123, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1962, 313, 1860, 81, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1963, 313, 1861, 121, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1964, 313, 1862, 89, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1965, 314, 1863, 55, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1966, 314, 1864, 122, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1967, 314, 1865, 81, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1968, 314, 1866, 121, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1969, 314, 1867, 89, 0, '2024-12-02 08:06:52', '2024-12-02 08:06:52'),
(1975, 316, 1873, 159, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1976, 316, 1874, 160, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1977, 316, 1875, 156, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1978, 316, 1876, 161, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1987, 319, 1885, 159, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1988, 319, 1886, 162, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1989, 319, 1887, 157, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1990, 319, 1888, 161, 0, '2024-12-03 23:42:45', '2024-12-03 23:42:45'),
(1995, 317, 1893, 159, 0, '2024-12-05 01:32:47', '2024-12-05 01:32:47'),
(1996, 317, 1894, 160, 0, '2024-12-05 01:32:47', '2024-12-05 01:32:47'),
(1997, 317, 1895, 156, 0, '2024-12-05 01:32:47', '2024-12-05 01:32:47'),
(1998, 317, 1896, 161, 0, '2024-12-05 01:32:47', '2024-12-05 01:32:47'),
(1999, 294, 1897, 55, 0, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(2000, 294, 1898, 67, 0, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(2001, 294, 1899, 81, 0, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(2002, 294, 1900, 112, 0, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(2003, 294, 1901, 89, 0, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(2034, 140, 1932, 55, 0, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(2035, 140, 1933, 59, 0, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(2036, 140, 1934, 57, 0, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(2037, 140, 1935, 90, 0, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(2038, 140, 1936, 146, 0, '2024-12-09 04:04:51', '2024-12-09 04:04:51'),
(2039, 141, 1937, 55, 0, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(2040, 141, 1938, 60, 0, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(2041, 141, 1939, 57, 0, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(2042, 141, 1940, 90, 0, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(2043, 141, 1941, 146, 0, '2024-12-09 04:04:55', '2024-12-09 04:04:55'),
(2044, 142, 1942, 55, 0, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(2045, 142, 1943, 61, 0, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(2046, 142, 1944, 57, 0, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(2047, 142, 1945, 90, 0, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(2048, 142, 1946, 146, 0, '2024-12-09 04:04:58', '2024-12-09 04:04:58'),
(2049, 259, 1947, 55, 0, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(2050, 259, 1948, 145, 0, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(2051, 259, 1949, 128, 0, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(2052, 259, 1950, 114, 0, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(2053, 259, 1951, 146, 0, '2024-12-09 04:05:00', '2024-12-09 04:05:00'),
(2058, 322, 1956, 165, 0, '2025-01-24 02:23:15', '2025-01-24 02:23:15'),
(2059, 322, 1957, 69, 0, '2025-01-24 02:23:15', '2025-01-24 02:23:15'),
(2060, 322, 1958, 168, 0, '2025-01-24 02:23:15', '2025-01-24 02:23:15'),
(2061, 321, 1959, 165, 0, '2025-01-24 02:23:34', '2025-01-24 02:23:34'),
(2062, 321, 1960, 69, 0, '2025-01-24 02:23:34', '2025-01-24 02:23:34'),
(2063, 321, 1961, 167, 0, '2025-01-24 02:23:34', '2025-01-24 02:23:34'),
(2064, 320, 1962, 163, 0, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(2065, 320, 1963, 160, 0, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(2066, 320, 1964, 156, 0, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(2067, 320, 1965, 164, 0, '2025-01-24 02:23:47', '2025-01-24 02:23:47'),
(2068, 318, 1966, 159, 0, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(2069, 318, 1967, 108, 0, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(2070, 318, 1968, 158, 0, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(2071, 318, 1969, 161, 0, '2025-01-24 02:23:57', '2025-01-24 02:23:57'),
(2072, 315, 1970, 55, 0, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(2073, 315, 1971, 155, 0, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(2074, 315, 1972, 128, 0, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(2075, 315, 1973, 110, 0, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(2076, 315, 1974, 84, 0, '2025-01-24 02:24:08', '2025-01-24 02:24:08'),
(2077, 311, 1975, 55, 0, '2025-01-24 02:24:18', '2025-01-24 02:24:18'),
(2078, 311, 1976, 59, 0, '2025-01-24 02:24:18', '2025-01-24 02:24:18'),
(2079, 311, 1977, 65, 0, '2025-01-24 02:24:18', '2025-01-24 02:24:18'),
(2080, 311, 1978, 117, 0, '2025-01-24 02:24:18', '2025-01-24 02:24:18'),
(2081, 311, 1979, 89, 0, '2025-01-24 02:24:18', '2025-01-24 02:24:18'),
(2082, 310, 1980, 55, 0, '2025-01-24 02:24:27', '2025-01-24 02:24:27'),
(2083, 310, 1981, 115, 0, '2025-01-24 02:24:27', '2025-01-24 02:24:27'),
(2084, 310, 1982, 65, 0, '2025-01-24 02:24:27', '2025-01-24 02:24:27'),
(2085, 310, 1983, 117, 0, '2025-01-24 02:24:27', '2025-01-24 02:24:27'),
(2086, 310, 1984, 89, 0, '2025-01-24 02:24:27', '2025-01-24 02:24:27'),
(2087, 296, 1985, 55, 0, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(2088, 296, 1986, 115, 0, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(2089, 296, 1987, 81, 0, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(2090, 296, 1988, 112, 0, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(2091, 296, 1989, 89, 0, '2025-01-24 02:24:43', '2025-01-24 02:24:43'),
(2092, 289, 1990, 107, 0, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(2093, 289, 1991, 123, 0, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(2094, 289, 1992, 128, 0, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(2095, 289, 1993, 153, 0, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(2096, 289, 1994, 84, 0, '2025-01-24 02:24:58', '2025-01-24 02:24:58'),
(2097, 272, 1995, 55, 0, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(2098, 272, 1996, 59, 0, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(2099, 272, 1997, 128, 0, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(2100, 272, 1998, 110, 0, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(2101, 272, 1999, 84, 0, '2025-01-24 02:25:09', '2025-01-24 02:25:09'),
(2102, 251, 2000, 107, 0, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(2103, 251, 2001, 143, 0, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(2104, 251, 2002, 72, 0, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(2105, 251, 2003, 114, 0, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(2106, 251, 2004, 89, 0, '2025-01-24 02:25:22', '2025-01-24 02:25:22'),
(2107, 238, 2005, 55, 0, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(2108, 238, 2006, 116, 0, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(2109, 238, 2007, 65, 0, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(2110, 238, 2008, 117, 0, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(2111, 238, 2009, 89, 0, '2025-01-24 02:25:36', '2025-01-24 02:25:36'),
(2112, 323, 2010, 165, 0, '2025-01-24 03:28:04', '2025-01-24 03:28:04'),
(2113, 323, 2011, 69, 0, '2025-01-24 03:28:04', '2025-01-24 03:28:04'),
(2114, 323, 2012, 169, 0, '2025-01-24 03:28:04', '2025-01-24 03:28:04'),
(2115, 323, 2013, 170, 0, '2025-01-24 03:28:04', '2025-01-24 03:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `sort_order`, `created_at`, `updated_at`) VALUES
(39, 320, 'product-image-4a7439b1d48ad7b496237561e6f04d7f-01-53-38-798935.webp', 0, '2024-12-04 08:23:40', '2024-12-04 08:23:40'),
(40, 320, 'product-image-philips-hl7757-00-mixer-grinder-01-53-40-243021.webp', 1, '2024-12-04 08:23:42', '2024-12-04 08:23:42'),
(41, 319, 'product-image-Powermatic-Plus-New-01-55-21-078664.webp', 0, '2024-12-04 08:25:23', '2024-12-04 08:25:23'),
(42, 318, 'product-image-c5c12b69-6560-4660-a920-d8d76af903b71711172809969-SUJATA-Powermatic-900-W-Juicer-351711172809744-4-07-02-27-342208.webp', 0, '2024-12-05 01:32:28', '2024-12-05 01:32:28'),
(43, 317, 'product-image-61S_MdfS0SL._SL1500_1600x-07-03-35-698067.webp', 0, '2024-12-05 01:33:37', '2024-12-05 01:33:37'),
(44, 317, 'product-image-f76daaed-5675-4ae6-ab12-e2bfa3e49bee-07-03-37-723240.webp', 1, '2024-12-05 01:33:41', '2024-12-05 01:33:41'),
(45, 316, 'product-image-Dynamix_1600x-07-05-50-820587.webp', 0, '2024-12-05 01:35:53', '2024-12-05 01:35:53'),
(46, 315, 'product-image-ubc125g-hawkins-original-imah5z2pcs3ybhp2-07-07-20-810184.webp', 0, '2024-12-05 01:37:22', '2024-12-05 01:37:22'),
(47, 314, 'product-image-26cm1-07-12-05-520955.webp', 0, '2024-12-05 01:42:06', '2024-12-05 01:42:06'),
(48, 313, 'product-image-81iCbcN7dML-07-13-03-628822.webp', 0, '2024-12-05 01:43:08', '2024-12-05 01:43:08'),
(49, 312, 'product-image-81Oa7tyCDqL-07-13-49-639590.webp', 0, '2024-12-05 01:43:54', '2024-12-05 01:43:54'),
(50, 311, 'product-image-61jito2c1uL-07-16-16-482018.webp', 0, '2024-12-05 01:46:18', '2024-12-05 01:46:18'),
(52, 309, 'product-image-61Mxje-apOL-07-17-51-477961.webp', 0, '2024-12-05 01:47:52', '2024-12-05 01:47:52'),
(53, 308, 'product-image-619uD8PTCZL-07-20-57-849939.webp', 0, '2024-12-05 01:50:59', '2024-12-05 01:50:59'),
(54, 307, 'product-image-61ZLJs4mRKL-07-21-31-633232.webp', 0, '2024-12-05 01:51:32', '2024-12-05 01:51:32'),
(55, 306, 'product-image-91Tvp1hj-mL-07-22-20-607118.webp', 0, '2024-12-05 01:52:25', '2024-12-05 01:52:25'),
(56, 305, 'product-image-61QgbCmrNjL._AC_UF894,1000_QL80_-07-23-43-775268.webp', 0, '2024-12-05 01:53:45', '2024-12-05 01:53:45'),
(57, 304, 'product-image-61BB9MyN4pL._AC_UF1000,1000_QL80_-07-24-58-391188.webp', 0, '2024-12-05 01:54:59', '2024-12-05 01:54:59'),
(58, 303, 'product-image-Hawkins-5-Litre-Cook-n-Serve-Handi,-Triply-Stainless-Steel-Handi-with-Glass-Lid,-Induction-Sauce-Pan,-Biryani-Handi,-Saucepan,-Silver-(SSH50G)-1-1000x1000-07-26-27-414854.webp', 0, '2024-12-05 01:56:28', '2024-12-05 01:56:28'),
(59, 303, 'product-image-Hawkins-5-Litre-Cook-n-Serve-Handi,-Triply-Stainless-Steel-Handi-with-Glass-Lid,-Induction-Sauce-Pan,-Biryani-Handi,-Saucepan,-Silver-(SSH50G)-2-1000x1000-07-26-28-912253.webp', 1, '2024-12-05 01:56:30', '2024-12-05 01:56:30'),
(60, 302, 'product-image-51617hLp6ES-07-27-46-436059.webp', 0, '2024-12-05 01:57:47', '2024-12-05 01:57:47'),
(61, 302, 'product-image-81gilhLfumS-07-27-47-983444.webp', 1, '2024-12-05 01:57:52', '2024-12-05 01:57:52'),
(62, 301, 'product-image-61oEFhMZ3rS-07-28-37-840961.webp', 0, '2024-12-05 01:58:39', '2024-12-05 01:58:39'),
(63, 301, 'product-image-81iseW6CPrL-07-28-39-501337.webp', 1, '2024-12-05 01:58:43', '2024-12-05 01:58:43'),
(64, 300, 'product-image-61zNFNeg4AS._AC_UF894,1000_QL80_-07-29-53-978356.webp', 0, '2024-12-05 01:59:55', '2024-12-05 01:59:55'),
(65, 300, 'product-image-hawkins-triply-stainless-steel-handi-with-glass-lid-2-l-product-images-o493830525-p604549576-5-202309121537-07-29-55-622136.webp', 1, '2024-12-05 01:59:57', '2024-12-05 01:59:57'),
(66, 299, 'product-image-618nxAiBhuL-07-36-13-394987.webp', 0, '2024-12-05 02:06:15', '2024-12-05 02:06:15'),
(67, 299, 'product-image-61vkcFRyQZL-07-36-15-192263.webp', 1, '2024-12-05 02:06:17', '2024-12-05 02:06:17'),
(68, 298, 'product-image-81yqb4IuDoL._SL1500_1-07-38-20-867552.webp', 0, '2024-12-05 02:08:23', '2024-12-05 02:08:23'),
(69, 298, 'product-image-61Jw7Us6t3L-07-38-23-474241.webp', 1, '2024-12-05 02:08:24', '2024-12-05 02:08:24'),
(70, 297, 'product-image-hawkins-triply-silver-stainless-steel-deep-fry-pan-with-glass-lid-2-5l-product-images-o493644248-p605669080-0-202310191736-07-41-29-013039.webp', 0, '2024-12-05 02:11:30', '2024-12-05 02:11:30'),
(71, 297, 'product-image-hawkins-triply-silver-stainless-steel-deep-fry-pan-with-glass-lid-2-5l-product-images-o493644248-p605669080-6-202310191736-07-41-30-442466.webp', 1, '2024-12-05 02:11:32', '2024-12-05 02:11:32'),
(72, 296, 'product-image-hawkins-tri-ply-stainless-steel-deep-fry-pan-with-glass-lid-1-5-l-product-images-o493830519-p606583849-0-202312062053-07-43-10-870988.webp', 0, '2024-12-05 02:13:12', '2024-12-05 02:13:12'),
(73, 296, 'product-image-hawkins-tri-ply-stainless-steel-deep-fry-pan-with-glass-lid-1-5-l-product-images-o493830519-p606583849-4-202312062053-07-43-12-108719.webp', 1, '2024-12-05 02:13:13', '2024-12-05 02:13:13'),
(74, 295, 'product-image-61Zy0aJYPqL-07-44-31-165179.webp', 0, '2024-12-05 02:14:32', '2024-12-05 02:14:32'),
(75, 295, 'product-image-61reh+EzjwL-07-44-32-760320.webp', 1, '2024-12-05 02:14:34', '2024-12-05 02:14:34'),
(77, 294, 'product-image-61-3NDHXPxL-07-45-20-025612.webp', 2, '2024-12-05 02:15:22', '2024-12-05 03:06:15'),
(78, 293, 'product-image-2113821_1-07-46-24-613590.webp', 2, '2024-12-05 02:16:26', '2025-02-07 02:04:03'),
(79, 293, 'product-image-MP000000023468763_1348Wx2000H_202408291335279-07-46-26-296335.webp', 1, '2024-12-05 02:16:28', '2025-02-07 02:04:03'),
(80, 292, 'product-image-61Z3CcoB0oL-07-50-12-048577.webp', 0, '2024-12-05 02:20:14', '2024-12-05 02:20:14'),
(81, 292, 'product-image-71xV48gHMJL-(1)-07-50-14-210644.webp', 1, '2024-12-05 02:20:16', '2024-12-05 02:20:16'),
(82, 291, 'product-image-shopping-(1)-07-57-08-805867.webp', 0, '2024-12-05 02:27:09', '2024-12-05 02:27:09'),
(83, 291, 'product-image-shopping-07-57-09-751754.webp', 1, '2024-12-05 02:27:10', '2024-12-05 02:27:10'),
(84, 290, 'product-image-519VzbEO0IL-08-12-30-704857.webp', 0, '2024-12-05 02:42:32', '2024-12-05 02:42:32'),
(85, 290, 'product-image-61mm3LppYWL-08-12-32-121735.webp', 1, '2024-12-05 02:42:33', '2024-12-05 02:42:33'),
(86, 289, 'product-image-611TQ3yUA6L-08-13-39-103722.webp', 0, '2024-12-05 02:43:40', '2024-12-05 02:43:40'),
(87, 289, 'product-image-61bKK-VX8jL-08-13-40-839628.webp', 1, '2024-12-05 02:43:42', '2024-12-05 02:43:42'),
(88, 288, 'product-image-61AqoqOnX9L-08-15-10-202166.webp', 0, '2024-12-05 02:45:11', '2024-12-05 02:45:11'),
(89, 288, 'product-image-61T68oq-IWL-08-15-11-843650.webp', 1, '2024-12-05 02:45:13', '2024-12-05 02:45:13'),
(90, 287, 'product-image-hawkins-futura-non-stick-22cm-tawa-with-stainless-steel-handle-black-nt22-product-images-orvhrgx0jk0-p603500598-2-202308021317-08-16-10-973955.webp', 0, '2024-12-05 02:46:12', '2024-12-05 02:46:12'),
(91, 287, 'product-image-hawkins-futura-non-stick-22cm-tawa-with-stainless-steel-handle-black-nt22-product-images-orvhrgx0jk0-p603500598-3-202308021317-08-16-12-174757.webp', 1, '2024-12-05 02:46:13', '2024-12-05 02:46:13'),
(92, 286, 'product-image-61Yj-QCj-LL-08-17-02-373534.webp', 0, '2024-12-05 02:47:03', '2024-12-05 02:47:03'),
(93, 286, 'product-image-61kYNh0L3DL._AC_UF894,1000_QL80_-08-17-03-945189.webp', 1, '2024-12-05 02:47:05', '2024-12-05 02:47:05'),
(94, 285, 'product-image-51Gtjh-W1QL-08-17-53-859647.webp', 0, '2024-12-05 02:47:55', '2024-12-05 02:47:55'),
(95, 285, 'product-image-8901165160405_2-08-17-55-182826.webp', 1, '2024-12-05 02:47:56', '2024-12-05 02:47:56'),
(96, 284, 'product-image-61mgGjpQ1rL-08-18-51-833784.webp', 0, '2024-12-05 02:48:53', '2024-12-05 02:48:53'),
(97, 284, 'product-image-8901165161204-2-08-18-53-480715.webp', 1, '2024-12-05 02:48:55', '2024-12-05 02:48:55'),
(98, 283, 'product-image-51FEa9aPTTL-08-19-39-681112.webp', 0, '2024-12-05 02:49:41', '2024-12-05 02:49:41'),
(99, 283, 'product-image-71HreahVedL._AC_UF894,1000_QL80_-08-19-41-229842.webp', 1, '2024-12-05 02:49:43', '2024-12-05 02:49:43'),
(100, 282, 'product-image-ssk40g-hawkins-original-imag4h8bp7uzv4da-08-34-19-909033.webp', 0, '2024-12-05 03:04:21', '2024-12-05 03:04:21'),
(101, 294, 'product-image-PSK60S HAWKINS PRO DEEP FRY PAN T PLY 6L-02-08-06-197.webp', 0, '2024-12-05 08:38:10', '2024-12-05 08:38:10'),
(102, 281, 'product-image-61mYMbEecOL-08-40-04-316758.webp', 0, '2024-12-05 03:10:06', '2024-12-05 03:10:06'),
(103, 281, 'product-image-71XAY+3tN-L-08-40-06-542860.webp', 1, '2024-12-05 03:10:08', '2024-12-05 03:10:08'),
(104, 280, 'product-image-51z86biib-l-sx679--08-42-18-909688.webp', 0, '2024-12-05 03:12:20', '2024-12-05 03:12:20'),
(105, 280, 'product-image-61jiNuIJBsL-08-42-20-628259.webp', 1, '2024-12-05 03:12:22', '2024-12-05 03:12:22'),
(106, 279, 'product-image-611zxdnatql-sl1000--08-43-08-061519.webp', 0, '2024-12-05 03:13:09', '2024-12-05 03:13:09'),
(107, 279, 'product-image-hawkins-ndt30-futura-30-cm-dosa-tava-non-stick-dosa-tawa-08-43-09-620987.webp', 1, '2024-12-05 03:13:11', '2024-12-05 03:13:11'),
(108, 278, 'product-image-513eprSHtOL-08-43-54-630951.webp', 0, '2024-12-05 03:13:56', '2024-12-05 03:13:56'),
(109, 278, 'product-image-61YreWlYLQL-08-43-56-173208.webp', 1, '2024-12-05 03:13:57', '2024-12-05 03:13:57'),
(110, 277, 'product-image-51zbSFB2ZnL-08-45-32-246630.webp', 0, '2024-12-05 03:15:33', '2024-12-05 03:15:33'),
(111, 277, 'product-image-61qmH5paXiL._AC_UF894,1000_QL80_-08-45-33-599347.webp', 1, '2024-12-05 03:15:35', '2024-12-05 03:15:35'),
(112, 276, 'product-image-1-151-08-49-19-298507.webp', 0, '2024-12-05 03:19:20', '2024-12-05 03:19:20'),
(113, 276, 'product-image-5-84-08-49-20-828011.webp', 1, '2024-12-05 03:19:22', '2024-12-05 03:19:22'),
(114, 275, 'product-image-61Rh0oXtQ8S-08-50-14-132583.webp', 0, '2024-12-05 03:20:15', '2024-12-05 03:20:15'),
(115, 275, 'product-image-2-132-08-50-15-460633.webp', 1, '2024-12-05 03:20:17', '2024-12-05 03:20:17'),
(116, 274, 'product-image-images-(1)-08-51-04-643062.webp', 0, '2024-12-05 03:21:05', '2024-12-05 03:21:05'),
(117, 274, 'product-image-images-08-51-05-368134.webp', 1, '2024-12-05 03:21:06', '2024-12-05 03:21:06'),
(118, 273, 'product-image-51p1KJ4wktL._AC_UF894,1000_QL80_-08-52-30-723031.webp', 2, '2024-12-05 03:22:31', '2025-02-07 02:04:48'),
(119, 273, 'product-image-images-(2)-08-52-31-815453.webp', 1, '2024-12-05 03:22:32', '2025-02-07 02:04:48'),
(122, 272, 'product-image-51N4oRR316L-08-56-39-719559.webp', 2, '2024-12-05 03:26:40', '2025-02-07 01:56:07'),
(123, 272, 'product-image-2-litre-deep-fry-pan-aqua-casserole-with-glass-lid-light-ivory-original-imah5n6yu7xqb57y-08-56-40-983566.webp', 1, '2024-12-05 03:26:42', '2025-02-07 01:56:07'),
(125, 271, 'product-image-617Z0V2atpL._AC_UF894,1000_QL80_-08-57-39-362733.webp', 1, '2024-12-05 03:27:40', '2024-12-05 03:27:40'),
(126, 270, 'product-image-51TEA76D7sS-08-58-13-306759.webp', 0, '2024-12-05 03:28:14', '2024-12-05 03:28:14'),
(127, 270, 'product-image-616YNJCZTzL-08-58-14-705804.webp', 1, '2024-12-05 03:28:16', '2024-12-05 03:28:16'),
(128, 269, 'product-image-1_15a8280c-3446-4f17-bc36-227bd442ab54-09-00-01-914708.webp', 0, '2024-12-05 03:30:03', '2024-12-05 03:30:03'),
(129, 269, 'product-image-inft30-hawkins-original-imag4h8bmzycfzat-09-00-03-707814.webp', 1, '2024-12-05 03:30:05', '2024-12-05 03:30:05'),
(130, 268, 'product-image-12897478-09-00-43-185325.webp', 0, '2024-12-05 03:30:44', '2024-12-05 03:30:44'),
(131, 268, 'product-image-images-(3)-09-00-44-754615.webp', 1, '2024-12-05 03:30:45', '2024-12-05 03:30:45'),
(132, 267, 'product-image-61m73xzxBzL-09-02-14-904289.webp', 0, '2024-12-05 03:32:16', '2024-12-05 03:32:16'),
(133, 267, 'product-image-infs30-futura-original-imaga7wtvkyj2q3r-09-02-16-687940.webp', 1, '2024-12-05 03:32:18', '2024-12-05 03:32:18'),
(134, 266, 'product-image-517ryBl6oOS-09-15-52-755912.webp', 0, '2024-12-05 03:45:54', '2024-12-05 03:45:54'),
(135, 266, 'product-image--original-imagmpm24g5gyyhh-09-15-54-087545.webp', 1, '2024-12-05 03:45:55', '2024-12-05 03:45:55'),
(136, 265, 'product-image-51If--WFoLL-09-24-36-800528.webp', 0, '2024-12-05 03:54:38', '2024-12-05 03:54:38'),
(137, 265, 'product-image-61MXLujV-VL-09-24-38-031531.webp', 1, '2024-12-05 03:54:39', '2024-12-05 03:54:39'),
(138, 264, 'product-image-51nZyd-OsPL._AC_UF894,1000_QL80_-09-25-23-363536.webp', 0, '2024-12-05 03:55:24', '2024-12-05 03:55:24'),
(139, 264, 'product-image-61-jiK2luVL-09-25-24-871129.webp', 1, '2024-12-05 03:55:26', '2024-12-05 03:55:26'),
(140, 263, 'product-image-513eprSHtOL-(1)-09-26-48-643502.webp', 0, '2024-12-05 03:56:50', '2024-12-05 03:56:50'),
(141, 263, 'product-image-61GetJw0vfL-09-26-50-071464.webp', 1, '2024-12-05 03:56:51', '2024-12-05 03:56:51'),
(142, 262, 'product-image-61kxh8Ct7iS-09-28-01-059902.webp', 0, '2024-12-05 03:58:02', '2024-12-05 03:58:02'),
(143, 262, 'product-image-61rywhScUQL._AC_UF894,1000_QL80_-09-28-02-812741.webp', 1, '2024-12-05 03:58:04', '2024-12-05 03:58:04'),
(144, 261, 'product-image-51UlXLoiCtL._AC_UF894,1000_QL80_-09-30-37-438630.webp', 0, '2024-12-05 04:00:39', '2024-12-05 04:00:39'),
(145, 261, 'product-image-51Xu4XmQLmL-09-30-39-153385.webp', 1, '2024-12-05 04:00:40', '2024-12-05 04:00:40'),
(146, 260, 'product-image-611bflouFDL-09-31-39-638140.webp', 0, '2024-12-05 04:01:42', '2024-12-05 04:01:42'),
(147, 260, 'product-image-71HNoAqggiL-09-31-42-018726.webp', 1, '2024-12-05 04:01:44', '2024-12-05 04:01:44'),
(148, 259, 'product-image-71PDtOLMlQL-10-33-45-497656.webp', 0, '2024-12-05 05:03:48', '2024-12-05 05:03:48'),
(149, 259, 'product-image-615L8W1fIqL-10-33-48-222158.webp', 1, '2024-12-05 05:03:50', '2024-12-05 05:03:50'),
(150, 258, 'product-image-1_ebadd0cf-c0cf-4de8-a488-0572f5c667b6-10-35-17-942238.webp', 0, '2024-12-05 05:05:19', '2024-12-05 05:05:19'),
(151, 258, 'product-image-ias20-hawkins-original-imag4h8avqsnnyqr-10-35-19-019514.webp', 1, '2024-12-05 05:05:20', '2024-12-05 05:05:20'),
(152, 257, 'product-image-opki-10-36-13-027482.webp', 0, '2024-12-05 05:06:14', '2024-12-05 05:06:14'),
(153, 257, 'product-image-40230504-3_1-hawkins-futura-hard-anodised-induction-compatible-roti-tava-diameter-26-cm-thickness-488-mm-black-iart26-10-36-14-255174.webp', 1, '2024-12-05 05:06:17', '2024-12-05 05:06:17'),
(154, 256, 'product-image-51vzseW10DL-10-37-26-191353.webp', 0, '2024-12-05 05:07:27', '2024-12-05 05:07:27'),
(155, 256, 'product-image-61ppYgVT4VL-10-37-27-602572.webp', 1, '2024-12-05 05:07:29', '2024-12-05 05:07:29'),
(156, 255, 'product-image-61Y4HyxiQ7L-10-38-17-581922.webp', 0, '2024-12-05 05:08:19', '2024-12-05 05:08:19'),
(157, 255, 'product-image-71VgT5BeN7L._AC_UF894,1000_QL80_-10-38-19-344182.webp', 1, '2024-12-05 05:08:20', '2024-12-05 05:08:20'),
(158, 254, 'product-image-51AvqdFJOLS-10-40-22-368317.webp', 0, '2024-12-05 05:10:23', '2024-12-05 05:10:23'),
(159, 254, 'product-image-IAF25_1-10-40-23-547184.webp', 1, '2024-12-05 05:10:24', '2024-12-05 05:10:24'),
(160, 253, 'product-image-6175uHwlXZL-10-41-36-041232.webp', 0, '2024-12-05 05:11:37', '2024-12-05 05:11:37'),
(161, 253, 'product-image-wssl2-10-41-37-562812.webp', 1, '2024-12-05 05:11:38', '2024-12-05 05:11:38'),
(162, 252, 'product-image-6175uHwlXZL-(1)-10-42-34-284517.webp', 0, '2024-12-05 05:12:35', '2024-12-05 05:12:35'),
(163, 252, 'product-image-iaf22-hawkins-original-imag4h8bk7ve4ztd-10-42-35-542960.webp', 1, '2024-12-05 05:12:36', '2024-12-05 05:12:36'),
(164, 251, 'product-image-6175uHwlXZL-(2)-10-43-29-923956.webp', 0, '2024-12-05 05:13:31', '2024-12-05 05:13:31'),
(165, 250, 'product-image-40230480_1-hawkins-futura-hard-anodised-deep-fry-pan-flat-bottom-with-stainless-steel-lid-diameter-30-cm-thickness-406-mm-black-ad375s-10-44-21-028597.webp', 0, '2024-12-05 05:14:24', '2024-12-05 05:14:24'),
(166, 250, 'product-image-images-(4)-10-44-24-875766.webp', 1, '2024-12-05 05:14:25', '2024-12-05 05:14:25'),
(167, 249, 'product-image-61iTibD50zL-10-46-24-398736.webp', 0, '2024-12-05 05:16:26', '2024-12-05 05:16:26'),
(168, 249, 'product-image-71SeXn4g30L-10-46-26-314566.webp', 1, '2024-12-05 05:16:28', '2024-12-05 05:16:28'),
(169, 248, 'product-image-61iTibD50zL-10-50-23-009366.webp', 0, '2024-12-05 05:20:25', '2024-12-05 05:20:25'),
(170, 247, 'product-image-61DC7CO-Z2L._AC_UF894,1000_QL80_-10-51-44-562870.webp', 0, '2024-12-05 05:21:46', '2024-12-05 05:21:46'),
(171, 247, 'product-image-712u90OrL4L._AC_UF894,1000_QL80_-10-51-46-021414.webp', 1, '2024-12-05 05:21:47', '2024-12-05 05:21:47'),
(172, 246, 'product-image-61whXtL0eyS-10-52-56-637058.webp', 0, '2024-12-05 05:22:58', '2024-12-05 05:22:58'),
(173, 246, 'product-image-il60-hawkins-original-imag4h7zh7etb8ma-10-52-58-311267.webp', 1, '2024-12-05 05:22:59', '2024-12-05 05:22:59'),
(174, 245, 'product-image-wooden-serving-spoons-250x250-10-55-38-660162.webp', 0, '2024-12-05 05:25:39', '2024-12-05 05:25:39'),
(175, 244, 'product-image-61OBlMpzuRS-10-56-36-032413.webp', 0, '2024-12-05 05:26:37', '2024-12-05 05:26:37'),
(176, 244, 'product-image-81U9EnWG9+L-10-56-37-354300.webp', 1, '2024-12-05 05:26:42', '2024-12-05 05:26:42'),
(177, 243, 'product-image-40230549-3_1-hawkins-tri-ply-stainless-steel-triniti-cookware-set-frying-pan-tava-deep-fry-pan-with-glass-lid-silver-sset1-(1)-10-59-14-844225.webp', 0, '2024-12-05 05:29:18', '2024-12-05 05:29:18'),
(178, 242, 'product-image-61OBlMpzuRS-(1)-11-00-31-650865.webp', 0, '2024-12-05 05:30:32', '2024-12-05 05:30:32'),
(179, 242, 'product-image-81U9EnWG9+L-(1)-11-00-32-911004.webp', 1, '2024-12-05 05:30:37', '2024-12-05 05:30:37'),
(180, 321, 'product-image-MILTON VACUUM FLASK ANCY 500ML-04-38-57-810319.webp', 0, '2024-12-05 11:08:59', '2024-12-05 11:08:59'),
(181, 321, 'product-image-MILTON VACUUM FLASK ANCY 500ML-04-38-59-028295.webp', 1, '2024-12-05 11:09:00', '2024-12-05 11:09:00'),
(182, 321, 'product-image-MILTON VACUUM FLASK ANCY 500ML-04-39-00-115210.webp', 2, '2024-12-05 11:09:01', '2024-12-05 11:09:01'),
(183, 322, 'product-image-ancy_500_ml_-_green_1024_pxl_-_website_1200x-11-30-20-628781.webp', 0, '2024-12-05 06:00:22', '2024-12-05 06:00:22'),
(184, 322, 'product-image-ancy_500_ml_-_red_1024_pxl_-_website_1200x-11-30-22-408255.webp', 1, '2024-12-05 06:00:23', '2024-12-05 06:00:23'),
(185, 322, 'product-image-milton-stainless-steel-brown-ancy-500-thermosteel-water-bottle-520-ml-product-images-orvkpfp2j2m-p603492297-0-202308021013-11-30-23-915649.webp', 2, '2024-12-05 06:00:25', '2024-12-05 06:00:25'),
(187, 323, 'product-image-MILTON VACUUM FLASK ARTESIA 600-05-07-30-826480.webp', 1, '2024-12-05 11:37:33', '2025-03-10 04:38:34'),
(188, 323, 'product-image-MILTON VACUUM FLASK ARTESIA 600-05-08-36-495.webp', 3, '2024-12-05 11:38:37', '2025-03-10 04:38:34'),
(189, 140, 'product-image-hawkins-3-5-litre-contura-pressure-cooker-stainless-steel-inner-lid-cooker-handi-cooker-induction-cooker-silver-ssc35-product-images-o493830513-p604549621-0-202403211618-08-54-21-492513.webp', 0, '2024-12-10 03:24:22', '2024-12-10 03:24:22'),
(192, 140, 'product-image-51z8bjUc4kL._AC_UF894,1000_QL80_-08-54-25-035652.webp', 3, '2024-12-10 03:24:26', '2024-12-10 03:24:26'),
(193, 140, 'product-image-2_46-08-54-26-276973.webp', 4, '2024-12-10 03:24:27', '2024-12-10 03:24:27'),
(195, 140, 'product-image-6456af5a-f161-4d31-b834-b5254e25d57a.849155a72ba820007f594e3006d5c7a1-08-54-28-909706.webp', 6, '2024-12-10 03:24:29', '2024-12-10 03:24:29'),
(196, 143, 'product-image-hawkins-3-5-litre-contura-pressure-cooker-stainless-steel-inner-lid-cooker-handi-cooker-induction-cooker-silver-ssc35-product-images-o493830513-p604549621-0-202403211618-09-03-55-937460.webp', 0, '2024-12-10 03:33:56', '2024-12-10 03:33:56'),
(197, 143, 'product-image-61lOBAfFNfL._AC_UF894,1000_QL80_-09-03-56-678559.webp', 1, '2024-12-10 03:33:57', '2024-12-10 03:33:57'),
(198, 143, 'product-image-800x-09-03-57-746755.webp', 2, '2024-12-10 03:33:58', '2024-12-10 03:33:58'),
(199, 143, 'product-image-51z8bjUc4kL._AC_UF894,1000_QL80_-09-03-58-770571.webp', 3, '2024-12-10 03:33:59', '2024-12-10 03:33:59'),
(200, 143, 'product-image-2_46-09-03-59-942714.webp', 4, '2024-12-10 03:34:00', '2024-12-10 03:34:00'),
(201, 143, 'product-image-61hfBE4evyL-09-04-00-975699.webp', 5, '2024-12-10 03:34:02', '2024-12-10 03:34:02'),
(208, 139, 'product-1735278157-676e3e4d9648c.webp', 0, '2024-12-27 00:12:38', '2024-12-27 00:12:38'),
(209, 141, 'product-1735278159-676e3e4f01143.webp', 0, '2024-12-27 00:12:40', '2024-12-27 00:12:40'),
(210, 142, 'product-1735278407-676e3f472afc4.webp', 0, '2024-12-27 00:16:48', '2024-12-27 00:16:48'),
(211, 144, 'product-1735278408-676e3f489a389.webp', 0, '2024-12-27 00:16:50', '2024-12-27 00:16:50'),
(212, 145, 'product-image-51z8bjUc4kL._AC_UF894,1000_QL80_-05-56-00-118881.webp', 0, '2024-12-27 00:26:01', '2024-12-27 00:26:01'),
(213, 146, 'product-image-2_46-05-56-01-738212.webp', 0, '2024-12-27 00:26:02', '2024-12-27 00:26:02'),
(214, 147, 'product-image-hawkins-3-5-litre-contura-pressure-cooker-stainless-steel-inner-lid-cooker-handi-cooker-induction-cooker-silver-ssc35-product-images-o493830513-p604549621-0-202403211618-05-58-55-731822.webp', 0, '2024-12-27 00:28:56', '2024-12-27 00:28:56'),
(215, 148, 'product-image-61lOBAfFNfL._AC_UF894,1000_QL80_-06-02-37-877227.webp', 0, '2024-12-27 00:32:39', '2024-12-27 00:32:39'),
(216, 149, 'product-image-800x-06-02-39-130889.webp', 0, '2024-12-27 00:32:40', '2024-12-27 00:32:40'),
(217, 150, 'product-image-2_46-06-15-16-651176.webp', 0, '2024-12-27 00:45:17', '2024-12-27 00:45:17'),
(218, 151, 'product-image-61hfBE4evyL-06-15-17-594546.webp', 0, '2024-12-27 00:45:19', '2024-12-27 00:45:19'),
(219, 152, 'product-image-800x-06-19-23-802603.webp', 0, '2024-12-27 00:49:25', '2024-12-27 00:49:25'),
(220, 153, 'product-image-51z8bjUc4kL._AC_UF894,1000_QL80_-06-19-25-052014.webp', 0, '2024-12-27 00:49:26', '2024-12-27 00:49:26'),
(221, 154, 'product-image-61lOBAfFNfL._AC_UF894,1000_QL80_-06-25-40-135668.webp', 0, '2024-12-27 00:55:41', '2024-12-27 00:55:41'),
(222, 155, 'product-image-800x-06-25-41-303276.webp', 0, '2024-12-27 00:55:42', '2024-12-27 00:55:42'),
(223, 156, 'product-image-51z8bjUc4kL._AC_UF894,1000_QL80_-06-25-42-324074.webp', 0, '2024-12-27 00:55:43', '2024-12-27 00:55:43'),
(224, 158, 'product-image-610uN07kP-L._AC_UF894,1000_QL80_-06-33-00-355677.webp', 0, '2024-12-27 01:03:01', '2024-12-27 01:03:01'),
(225, 158, 'product-image-8901165161204-11-06-33-01-595487.webp', 0, '2024-12-27 01:03:02', '2024-12-27 01:03:02'),
(226, 237, 'product-image-Untitled-design-(83)-04-26-40-402226.webp', 2, '2025-01-14 22:56:44', '2025-03-10 04:40:04'),
(227, 237, 'product-image-financial-services-04-31-20-640189.webp', 3, '2025-01-14 23:01:22', '2025-03-10 04:40:04'),
(228, 236, 'product-image-Untitled-design-(83)-04-31-34-852547.webp', 0, '2025-01-14 23:01:39', '2025-01-14 23:01:39'),
(229, 237, 'product-image-13-04-46-04-307233.webp', 1, '2025-01-14 23:16:05', '2025-03-10 04:40:04'),
(230, 235, 'product-image-12-04-46-28-334495.webp', 0, '2025-01-14 23:16:29', '2025-01-14 23:16:29'),
(231, 234, 'product-image-3-04-46-38-896130.webp', 0, '2025-01-14 23:16:39', '2025-01-14 23:16:39'),
(256, 139, 'product-image-13-05-27-04-485589.webp', 0, '2025-01-14 23:57:05', '2025-01-14 23:57:05'),
(257, 139, 'product-image-12-05-27-05-523949.webp', 0, '2025-01-14 23:57:06', '2025-01-14 23:57:06'),
(258, 323, 'product-image-Untitled-design-(83)-08-35-25-737394.webp', 2, '2025-01-15 03:05:30', '2025-03-10 04:38:34'),
(259, 323, 'product-image-Untitled-design-(83)-08-35-30-341847.webp', 4, '2025-01-15 03:05:33', '2025-03-10 04:38:34'),
(260, 139, 'product-image-Republic_Day_best_seller_page_desktop_baaaf32a-fe0f-45a5-bbc7-0aa02db065ef_1920x-10-09-14-375347.webp', 0, '2025-01-27 04:39:16', '2025-01-27 04:39:16'),
(261, 163, 'GD-sons-kitchen-Varanasi-Untitled-design-23-1738054708455.webp', 0, '2025-01-28 03:28:29', '2025-01-28 03:28:29'),
(262, 163, 'GD-sons-kitchen-Varanasi-RepublicDaybestsellerpagedesktopbaaaf32a-fe0f-45a5-bbc7-0aa02db065ef1920x-1738054709586.webp', 1, '2025-01-28 03:28:30', '2025-01-28 03:28:30'),
(263, 164, 'GD-sons-kitchen-Varanasi-1738054811137.webp', 0, '2025-01-28 03:30:12', '2025-01-28 03:30:12'),
(264, 164, 'GD-sons-kitchen-Varanasi-1738054812371.webp', 1, '2025-01-28 03:30:13', '2025-01-28 03:30:13'),
(265, 209, 'GD-sons-kitchen-Varanasi-1738841384424.jpg', 0, '2025-02-06 05:59:50', '2025-02-06 05:59:50'),
(266, 209, 'GD-sons-kitchen-Varanasi-1738841390356.jpg', 1, '2025-02-06 05:59:51', '2025-02-06 05:59:51'),
(270, 241, 'GD-sons-kitchen-Varanasi-HAWKINS-TRINITI-SET-COOKER-TAVA-KADHAI-1738849607645.webp', 1, '2025-02-06 08:16:48', '2025-02-06 08:16:48'),
(274, 157, 'GD-sons-kitchen-Varanasi-HAWKINS-PRESSURE-COOKER-CONTURA-BLACK-15L-1738919531088.webp', 0, '2025-02-07 03:42:12', '2025-02-07 03:42:12');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2024-10-04 03:29:35', '2024-10-04 03:29:35'),
(2, 'editor', 'web', '2024-10-04 03:29:35', '2024-10-04 03:29:35');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `apartment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `customer_id`, `full_name`, `phone_number`, `email_id`, `country`, `full_address`, `apartment`, `city_name`, `state`, `pin_code`, `created_at`, `updated_at`) VALUES
(7, 1, 'Rahul Kuamr Maurya', '9878767876', NULL, 'India', 'Sigara Varanasi', NULL, 'Varanasi', 'Uttar Pradesh', '221010', '2024-12-20 02:01:46', '2024-12-20 02:01:46'),
(8, 1, 'Rahul Kuamr Maurya', '9878767876', NULL, 'India', 'Sigara Varanasi', NULL, 'Varanasi', 'Uttar Pradesh', '221010', '2024-12-20 02:07:22', '2024-12-20 02:07:22'),
(10, 1, 'Rahul Kuamr Maurya', '9878767876', NULL, 'India', 'Sigara Varanasi', NULL, 'Varanasi', 'Uttar Pradesh', '221010', '2024-12-20 02:15:37', '2024-12-20 02:15:37'),
(12, 1, 'Rahul Kuamr Maurya', '9878767876', NULL, 'India', 'Sigara Varanasi', NULL, 'Varanasi', 'Uttar Pradesh', '221010', '2024-12-20 02:18:24', '2024-12-20 02:18:24'),
(13, 1, 'Rahul Kuamr Maurya', '9878767876', NULL, 'India', 'Sigara Varanasi', NULL, 'Varanasi', 'Uttar Pradesh', '221010', '2024-12-20 02:20:28', '2024-12-20 02:20:28'),
(19, 1, 'Rahul Kuamr Maurya', '9878767876', NULL, 'India', 'Sigara Varanasi', NULL, 'Varanasi', 'Uttar Pradesh', '221010', '2024-12-20 02:49:03', '2024-12-20 02:49:03'),
(23, 1, 'Rahul Kuamr Maurya', '9878767876', NULL, 'India', 'Sigara Varanasi', NULL, 'Varanasi', 'Uttar Pradesh', '221010', '2024-12-20 08:03:13', '2024-12-20 08:03:13'),
(50, 1, 'Rahul Kumar Maurya', '4565465464', NULL, 'India', 'Sigara Varanasi', 'test', 'Varanasi', 'Uttar Pradesh', '221010', '2025-03-10 23:07:11', '2025-03-10 23:07:11'),
(51, 1, 'Rahul Kumar Maurya', '4565465464', NULL, 'India', 'Sigara Varanasi', 'test', 'Varanasi', 'Uttar Pradesh', '221010', '2025-03-12 00:46:52', '2025-03-12 00:46:52'),
(52, 1, 'Rahul Kumar Maurya', '4565465464', NULL, 'India', 'Sigara Varanasi', 'test', 'Varanasi', 'Uttar Pradesh', '221010', '2025-03-12 00:46:58', '2025-03-12 00:46:58'),
(53, 1, 'Rahul Kumar Maurya', '4565465464', NULL, 'India', 'Sigara Varanasi', 'test', 'Varanasi', 'Uttar Pradesh', '221010', '2025-03-12 00:47:00', '2025-03-12 00:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `social_media_tracking`
--

CREATE TABLE `social_media_tracking` (
  `id` int(10) UNSIGNED NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`location`)),
  `visited_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_media_tracking`
--

INSERT INTO `social_media_tracking` (`id`, `source`, `method`, `identity`, `ip_address`, `browser`, `page_name`, `location`, `visited_at`, `created_at`, `updated_at`) VALUES
(1, 'WA', 'HL', '916388112769', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/?identity=916388112769&method=HL&source=WA', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-08 04:08:08', '2025-02-08 04:08:08', '2025-02-08 04:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off' COMMENT 'Status of the item',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `update_hsn_gst_with_attributes`
--

CREATE TABLE `update_hsn_gst_with_attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `attributes_id` int(10) UNSIGNED NOT NULL,
  `attributes_value_id` int(10) UNSIGNED NOT NULL,
  `hsn_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_in_per` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `update_hsn_gst_with_attributes`
--

INSERT INTO `update_hsn_gst_with_attributes` (`id`, `category_id`, `attributes_id`, `attributes_value_id`, `hsn_code`, `gst_in_per`, `created_at`, `updated_at`) VALUES
(1, 10, 20, 57, '7615', '12', '2024-12-02 06:11:36', '2024-12-02 06:11:36'),
(2, 10, 20, 65, '7323', '12', '2024-12-02 06:11:44', '2024-12-02 06:11:44'),
(3, 10, 20, 72, '7615', '12', '2024-12-02 06:11:51', '2024-12-02 06:11:51'),
(4, 10, 20, 81, '7323', '12', '2024-12-02 06:12:00', '2024-12-02 06:12:00'),
(7, 4, 20, 57, '7615', '12', '2024-12-02 06:12:39', '2024-12-02 06:12:39'),
(8, 4, 20, 65, '7323', '12', '2024-12-02 06:12:46', '2024-12-02 06:12:46'),
(9, 4, 20, 72, '7615', '12', '2024-12-02 06:12:52', '2024-12-02 06:12:52'),
(10, 4, 20, 81, '7323', '12', '2024-12-02 06:12:57', '2024-12-02 06:12:57'),
(11, 10, 20, 140, '4419', '18', '2024-12-02 08:13:05', '2024-12-02 08:13:05'),
(12, 10, 20, 128, '7615', '12', '2024-12-02 08:13:13', '2024-12-02 08:13:13'),
(13, 10, 20, 126, '7615', '12', '2024-12-02 08:13:21', '2024-12-02 08:13:21'),
(14, 10, 20, 124, '7323', '12', '2024-12-02 08:13:27', '2024-12-02 08:13:27'),
(15, 6, 22, 156, '8516', '18', '2024-12-03 23:37:40', '2024-12-03 23:37:40'),
(16, 6, 22, 157, '8516', '18', '2024-12-03 23:37:47', '2024-12-03 23:37:47'),
(17, 6, 22, 158, '8516', '18', '2024-12-03 23:37:54', '2024-12-03 23:37:54'),
(18, 5, 22, 165, '9617', '18', '2024-12-05 05:33:07', '2024-12-05 05:33:07'),
(19, 5, 22, 166, '9617', '18', '2024-12-05 05:33:13', '2024-12-05 05:33:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_id`, `password`, `profile_img`, `phone_number`, `gender`, `address`, `email_verified_at`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'rahulkumarmaurya464@gmail.com', 'Admin', '$2y$10$KMgF2cTDxbOiWXuOhiuLf.phuQVnF.n3h0kmn47lyu3jNibVNMUBa', 'profile-image-admin.webp', '9867656765', 'Male', 'Sigara Varanasi', NULL, 1, NULL, '2024-10-05 02:16:39', '2025-02-13 03:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` int(20) UNSIGNED NOT NULL,
  `user_id` int(20) UNSIGNED NOT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_logins`
--

INSERT INTO `user_logins` (`id`, `user_id`, `last_login_at`, `ip_address`, `created_at`, `updated_at`) VALUES
(71, 1, '2024-12-16 04:37:35', '127.0.0.1', '2024-12-16 04:37:35', '2024-12-16 04:37:35'),
(72, 1, '2024-12-16 04:48:37', '127.0.0.1', '2024-12-16 04:48:37', '2024-12-16 04:48:37'),
(73, 1, '2024-12-17 00:34:48', '127.0.0.1', '2024-12-17 00:34:48', '2024-12-17 00:34:48'),
(74, 1, '2024-12-17 00:42:06', '127.0.0.1', '2024-12-17 00:42:06', '2024-12-17 00:42:06'),
(75, 1, '2024-12-17 22:53:25', '127.0.0.1', '2024-12-17 22:53:25', '2024-12-17 22:53:25'),
(76, 1, '2024-12-18 23:11:12', '127.0.0.1', '2024-12-18 23:11:12', '2024-12-18 23:11:12'),
(77, 1, '2024-12-19 22:49:24', '127.0.0.1', '2024-12-19 22:49:24', '2024-12-19 22:49:24'),
(78, 1, '2024-12-20 07:50:53', '127.0.0.1', '2024-12-20 07:50:53', '2024-12-20 07:50:53'),
(79, 1, '2024-12-22 07:03:59', '127.0.0.1', '2024-12-22 07:03:59', '2024-12-22 07:03:59'),
(80, 1, '2024-12-22 22:47:34', '127.0.0.1', '2024-12-22 22:47:34', '2024-12-22 22:47:34'),
(81, 1, '2024-12-23 01:55:53', '127.0.0.1', '2024-12-23 01:55:53', '2024-12-23 01:55:53'),
(82, 1, '2024-12-23 22:46:04', '127.0.0.1', '2024-12-23 22:46:04', '2024-12-23 22:46:04'),
(83, 1, '2024-12-24 03:12:01', '127.0.0.1', '2024-12-24 03:12:01', '2024-12-24 03:12:01'),
(84, 1, '2024-12-25 00:40:04', '127.0.0.1', '2024-12-25 00:40:04', '2024-12-25 00:40:04'),
(85, 1, '2024-12-25 01:13:11', '127.0.0.1', '2024-12-25 01:13:11', '2024-12-25 01:13:11'),
(86, 1, '2024-12-26 00:02:08', '127.0.0.1', '2024-12-26 00:02:08', '2024-12-26 00:02:08'),
(87, 1, '2024-12-26 00:06:21', '127.0.0.1', '2024-12-26 00:06:21', '2024-12-26 00:06:21'),
(88, 1, '2024-12-26 02:10:57', '127.0.0.1', '2024-12-26 02:10:57', '2024-12-26 02:10:57'),
(89, 1, '2024-12-26 07:44:47', '127.0.0.1', '2024-12-26 07:44:47', '2024-12-26 07:44:47'),
(90, 1, '2024-12-26 22:56:01', '127.0.0.1', '2024-12-26 22:56:01', '2024-12-26 22:56:01'),
(91, 1, '2024-12-28 00:45:20', '127.0.0.1', '2024-12-28 00:45:21', '2024-12-28 00:45:21'),
(92, 1, '2024-12-28 04:37:34', '127.0.0.1', '2024-12-28 04:37:34', '2024-12-28 04:37:34'),
(93, 1, '2024-12-28 04:48:06', '127.0.0.1', '2024-12-28 04:48:06', '2024-12-28 04:48:06'),
(94, 1, '2024-12-29 23:20:38', '127.0.0.1', '2024-12-29 23:20:38', '2024-12-29 23:20:38'),
(95, 1, '2024-12-30 01:37:04', '127.0.0.1', '2024-12-30 01:37:04', '2024-12-30 01:37:04'),
(96, 1, '2024-12-30 01:57:35', '127.0.0.1', '2024-12-30 01:57:35', '2024-12-30 01:57:35'),
(97, 1, '2024-12-30 23:07:29', '127.0.0.1', '2024-12-30 23:07:29', '2024-12-30 23:07:29'),
(98, 1, '2025-01-01 22:47:21', '127.0.0.1', '2025-01-01 22:47:22', '2025-01-01 22:47:22'),
(99, 1, '2025-01-02 22:55:21', '127.0.0.1', '2025-01-02 22:55:21', '2025-01-02 22:55:21'),
(100, 1, '2025-01-02 23:05:55', '127.0.0.1', '2025-01-02 23:05:55', '2025-01-02 23:05:55'),
(101, 1, '2025-01-03 01:24:55', '127.0.0.1', '2025-01-03 01:24:55', '2025-01-03 01:24:55'),
(102, 1, '2025-01-03 04:35:06', '127.0.0.1', '2025-01-03 04:35:06', '2025-01-03 04:35:06'),
(103, 1, '2025-01-03 05:44:09', '127.0.0.1', '2025-01-03 05:44:09', '2025-01-03 05:44:09'),
(104, 1, '2025-01-03 23:13:07', '127.0.0.1', '2025-01-03 23:13:07', '2025-01-03 23:13:07'),
(105, 1, '2025-01-14 22:53:00', '127.0.0.1', '2025-01-14 22:53:00', '2025-01-14 22:53:00'),
(106, 1, '2025-01-16 04:15:02', '127.0.0.1', '2025-01-16 04:15:02', '2025-01-16 04:15:02'),
(107, 1, '2025-01-19 23:06:12', '127.0.0.1', '2025-01-19 23:06:12', '2025-01-19 23:06:12'),
(108, 1, '2025-01-20 01:45:50', '127.0.0.1', '2025-01-20 01:45:50', '2025-01-20 01:45:50'),
(109, 1, '2025-01-20 22:30:36', '127.0.0.1', '2025-01-20 22:30:36', '2025-01-20 22:30:36'),
(110, 1, '2025-01-23 00:58:04', '127.0.0.1', '2025-01-23 00:58:04', '2025-01-23 00:58:04'),
(111, 1, '2025-01-24 00:59:53', '127.0.0.1', '2025-01-24 00:59:53', '2025-01-24 00:59:53'),
(112, 1, '2025-01-24 05:07:32', '127.0.0.1', '2025-01-24 05:07:32', '2025-01-24 05:07:32'),
(113, 1, '2025-01-24 23:19:25', '127.0.0.1', '2025-01-24 23:19:25', '2025-01-24 23:19:25'),
(114, 1, '2025-01-27 04:18:12', '127.0.0.1', '2025-01-27 04:18:12', '2025-01-27 04:18:12'),
(115, 1, '2025-01-27 23:24:13', '127.0.0.1', '2025-01-27 23:24:13', '2025-01-27 23:24:13'),
(116, 1, '2025-01-28 02:17:01', '127.0.0.1', '2025-01-28 02:17:01', '2025-01-28 02:17:01'),
(117, 1, '2025-01-28 05:51:15', '127.0.0.1', '2025-01-28 05:51:15', '2025-01-28 05:51:15'),
(118, 1, '2025-01-28 07:58:57', '127.0.0.1', '2025-01-28 07:58:57', '2025-01-28 07:58:57'),
(119, 1, '2025-01-29 00:21:53', '127.0.0.1', '2025-01-29 00:21:54', '2025-01-29 00:21:54'),
(120, 1, '2025-01-29 05:36:10', '127.0.0.1', '2025-01-29 05:36:10', '2025-01-29 05:36:10'),
(121, 1, '2025-01-29 23:38:35', '127.0.0.1', '2025-01-29 23:38:35', '2025-01-29 23:38:35'),
(122, 1, '2025-01-30 08:11:03', '127.0.0.1', '2025-01-30 08:11:03', '2025-01-30 08:11:03'),
(123, 1, '2025-01-31 03:55:25', '127.0.0.1', '2025-01-31 03:55:25', '2025-01-31 03:55:25'),
(124, 1, '2025-01-31 09:04:47', '127.0.0.1', '2025-01-31 09:04:47', '2025-01-31 09:04:47'),
(125, 1, '2025-01-31 23:59:44', '127.0.0.1', '2025-01-31 23:59:44', '2025-01-31 23:59:44'),
(126, 1, '2025-02-01 01:58:17', '127.0.0.1', '2025-02-01 01:58:17', '2025-02-01 01:58:17'),
(127, 1, '2025-02-01 02:02:45', '127.0.0.1', '2025-02-01 02:02:45', '2025-02-01 02:02:45'),
(128, 1, '2025-02-01 07:38:32', '127.0.0.1', '2025-02-01 07:38:32', '2025-02-01 07:38:32'),
(129, 1, '2025-02-03 23:20:46', '127.0.0.1', '2025-02-03 23:20:46', '2025-02-03 23:20:46'),
(130, 1, '2025-02-03 23:28:52', '127.0.0.1', '2025-02-03 23:28:52', '2025-02-03 23:28:52'),
(131, 1, '2025-02-04 03:37:21', '127.0.0.1', '2025-02-04 03:37:21', '2025-02-04 03:37:21'),
(132, 1, '2025-02-05 00:30:45', '127.0.0.1', '2025-02-05 00:30:45', '2025-02-05 00:30:45'),
(133, 1, '2025-02-05 05:18:14', '127.0.0.1', '2025-02-05 05:18:14', '2025-02-05 05:18:14'),
(134, 1, '2025-02-05 07:27:35', '127.0.0.1', '2025-02-05 07:27:35', '2025-02-05 07:27:35'),
(135, 1, '2025-02-05 23:20:25', '127.0.0.1', '2025-02-05 23:20:25', '2025-02-05 23:20:25'),
(136, 1, '2025-02-06 05:36:21', '127.0.0.1', '2025-02-06 05:36:21', '2025-02-06 05:36:21'),
(137, 1, '2025-02-06 07:45:28', '127.0.0.1', '2025-02-06 07:45:28', '2025-02-06 07:45:28'),
(138, 1, '2025-02-06 23:26:13', '127.0.0.1', '2025-02-06 23:26:13', '2025-02-06 23:26:13'),
(139, 1, '2025-02-06 23:47:30', '127.0.0.1', '2025-02-06 23:47:30', '2025-02-06 23:47:30'),
(140, 1, '2025-02-07 08:09:36', '127.0.0.1', '2025-02-07 08:09:36', '2025-02-07 08:09:36'),
(141, 1, '2025-02-07 22:50:41', '127.0.0.1', '2025-02-07 22:50:41', '2025-02-07 22:50:41'),
(142, 1, '2025-02-08 02:45:28', '127.0.0.1', '2025-02-08 02:45:29', '2025-02-08 02:45:29'),
(143, 1, '2025-02-08 04:13:52', '127.0.0.1', '2025-02-08 04:13:52', '2025-02-08 04:13:52'),
(144, 1, '2025-02-10 00:21:50', '127.0.0.1', '2025-02-10 00:21:50', '2025-02-10 00:21:50'),
(145, 1, '2025-02-10 04:05:31', '127.0.0.1', '2025-02-10 04:05:31', '2025-02-10 04:05:31'),
(146, 1, '2025-02-10 05:10:18', '127.0.0.1', '2025-02-10 05:10:18', '2025-02-10 05:10:18'),
(147, 1, '2025-02-10 23:19:16', '127.0.0.1', '2025-02-10 23:19:16', '2025-02-10 23:19:16'),
(148, 1, '2025-02-11 04:45:53', '127.0.0.1', '2025-02-11 04:45:53', '2025-02-11 04:45:53'),
(149, 1, '2025-02-11 23:01:04', '127.0.0.1', '2025-02-11 23:01:04', '2025-02-11 23:01:04'),
(150, 1, '2025-02-12 00:04:27', '127.0.0.1', '2025-02-12 00:04:27', '2025-02-12 00:04:27'),
(151, 1, '2025-02-12 01:07:00', '127.0.0.1', '2025-02-12 01:07:00', '2025-02-12 01:07:00'),
(152, 1, '2025-02-12 04:34:16', '127.0.0.1', '2025-02-12 04:34:16', '2025-02-12 04:34:16'),
(153, 1, '2025-02-13 04:34:17', '127.0.0.1', '2025-02-13 04:34:18', '2025-02-13 04:34:18'),
(154, 1, '2025-02-14 00:17:04', '127.0.0.1', '2025-02-14 00:17:04', '2025-02-14 00:17:04'),
(155, 1, '2025-02-14 02:45:25', '127.0.0.1', '2025-02-14 02:45:25', '2025-02-14 02:45:25'),
(156, 1, '2025-02-14 05:49:18', '127.0.0.1', '2025-02-14 05:49:18', '2025-02-14 05:49:18'),
(157, 1, '2025-02-15 00:45:05', '127.0.0.1', '2025-02-15 00:45:05', '2025-02-15 00:45:05'),
(158, 1, '2025-02-17 01:12:09', '127.0.0.1', '2025-02-17 01:12:09', '2025-02-17 01:12:09'),
(159, 1, '2025-02-17 23:29:14', '127.0.0.1', '2025-02-17 23:29:14', '2025-02-17 23:29:14'),
(160, 8, '2025-02-18 01:05:15', '127.0.0.1', '2025-02-18 01:05:15', '2025-02-18 01:05:15'),
(161, 1, '2025-02-18 01:12:22', '127.0.0.1', '2025-02-18 01:12:22', '2025-02-18 01:12:22'),
(162, 1, '2025-02-18 03:04:41', '127.0.0.1', '2025-02-18 03:04:41', '2025-02-18 03:04:41'),
(163, 1, '2025-02-19 00:41:43', '127.0.0.1', '2025-02-19 00:41:43', '2025-02-19 00:41:43'),
(164, 8, '2025-02-19 03:10:18', '127.0.0.1', '2025-02-19 03:10:19', '2025-02-19 03:10:19'),
(165, 1, '2025-02-19 04:00:19', '127.0.0.1', '2025-02-19 04:00:19', '2025-02-19 04:00:19'),
(166, 1, '2025-02-19 04:49:38', '127.0.0.1', '2025-02-19 04:49:38', '2025-02-19 04:49:38'),
(167, 1, '2025-02-19 23:06:45', '127.0.0.1', '2025-02-19 23:06:45', '2025-02-19 23:06:45'),
(168, 1, '2025-02-20 00:14:09', '127.0.0.1', '2025-02-20 00:14:09', '2025-02-20 00:14:09'),
(169, 1, '2025-02-20 00:15:55', '127.0.0.1', '2025-02-20 00:15:55', '2025-02-20 00:15:55'),
(170, 1, '2025-02-20 00:31:15', '127.0.0.1', '2025-02-20 00:31:15', '2025-02-20 00:31:15'),
(171, 1, '2025-02-20 00:58:15', '127.0.0.1', '2025-02-20 00:58:15', '2025-02-20 00:58:15'),
(172, 8, '2025-02-20 01:20:44', '127.0.0.1', '2025-02-20 01:20:44', '2025-02-20 01:20:44'),
(173, 1, '2025-02-20 04:26:39', '127.0.0.1', '2025-02-20 04:26:39', '2025-02-20 04:26:39'),
(174, 1, '2025-02-21 00:38:04', '127.0.0.1', '2025-02-21 00:38:04', '2025-02-21 00:38:04'),
(175, 1, '2025-02-21 00:38:36', '127.0.0.1', '2025-02-21 00:38:36', '2025-02-21 00:38:36'),
(176, 1, '2025-02-21 00:39:05', '127.0.0.1', '2025-02-21 00:39:05', '2025-02-21 00:39:05'),
(177, 1, '2025-02-21 00:40:42', '127.0.0.1', '2025-02-21 00:40:42', '2025-02-21 00:40:42'),
(178, 1, '2025-02-21 00:42:15', '127.0.0.1', '2025-02-21 00:42:15', '2025-02-21 00:42:15'),
(179, 1, '2025-02-21 01:41:24', '127.0.0.1', '2025-02-21 01:41:24', '2025-02-21 01:41:24'),
(180, 1, '2025-02-21 01:49:48', '127.0.0.1', '2025-02-21 01:49:48', '2025-02-21 01:49:48'),
(181, 1, '2025-02-28 01:36:03', '127.0.0.1', '2025-02-28 01:36:03', '2025-02-28 01:36:03'),
(182, 1, '2025-03-10 04:01:15', '127.0.0.1', '2025-03-10 04:01:15', '2025-03-10 04:01:15'),
(183, 1, '2025-03-10 06:06:41', '127.0.0.1', '2025-03-10 06:06:41', '2025-03-10 06:06:41'),
(184, 1, '2025-03-10 23:02:24', '127.0.0.1', '2025-03-10 23:02:24', '2025-03-10 23:02:24'),
(185, 1, '2025-03-11 03:29:38', '127.0.0.1', '2025-03-11 03:29:38', '2025-03-11 03:29:38'),
(186, 1, '2025-03-11 22:46:09', '127.0.0.1', '2025-03-11 22:46:09', '2025-03-11 22:46:09'),
(187, 1, '2025-03-11 22:46:34', '127.0.0.1', '2025-03-11 22:46:34', '2025-03-11 22:46:34'),
(188, 1, '2025-03-11 23:16:03', '127.0.0.1', '2025-03-11 23:16:03', '2025-03-11 23:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `vendor_name`, `location`, `gst_no`, `contact_no`, `created_at`, `updated_at`) VALUES
(2, 'Rahul Test', 'Sigara Varanasi', NULL, NULL, '2024-11-20 00:35:16', '2024-11-20 00:35:16'),
(3, 'Priyesh Test', 'Rathyatra Varanasi', NULL, NULL, '2024-11-20 00:36:04', '2024-11-20 00:36:04'),
(4, 'Aman', 'Mahmoorganj', NULL, '7656788765', '2024-11-20 01:10:12', '2024-11-20 03:18:02'),
(5, 'Om Prakash', 'Varanasi', '453454566545676', '6767676767', '2024-11-20 01:37:23', '2024-11-29 02:54:59'),
(6, 'S R Sales', 'SigraVaranasi', '656567767856565', '1212121212', '2024-11-20 05:41:21', '2024-11-23 02:45:16');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_purchase_bills`
--

CREATE TABLE `vendor_purchase_bills` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `bill_date` date NOT NULL,
  `bill_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grand_total_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_purchase_lines`
--

CREATE TABLE `vendor_purchase_lines` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_purchase_bill_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `inventory_id` int(10) UNSIGNED DEFAULT NULL,
  `mrp` decimal(30,2) DEFAULT NULL,
  `qty` decimal(30,2) DEFAULT NULL,
  `total_amount` decimal(30,2) DEFAULT NULL,
  `purchase_rate` decimal(30,2) NOT NULL DEFAULT 0.00,
  `offer_rate` decimal(30,2) NOT NULL DEFAULT 0.00,
  `hsn_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_dis_percentage` int(11) NOT NULL DEFAULT 0,
  `pre_gst_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_tracking`
--

CREATE TABLE `visitor_tracking` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visited_at` timestamp NULL DEFAULT current_timestamp(),
  `time_spent` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitor_tracking`
--

INSERT INTO `visitor_tracking` (`id`, `ip_address`, `browser`, `page_name`, `location`, `visited_at`, `time_spent`, `created_at`, `updated_at`) VALUES
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'http://127.0.0.1:8000', 'New Haven', '2025-02-07 23:18:52', 0, '2025-02-07 23:18:52', '2025-02-07 23:18:52'),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/materialsurface/aluminium', 'New Haven', '2025-02-07 23:19:42', 0, '2025-02-07 23:19:42', '2025-02-07 23:19:42'),
(4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/hawkins-idli-stand-aluminium-for-5l/aluminium', 'New Haven', '2025-02-07 23:21:18', 0, '2025-02-07 23:21:18', '2025-02-07 23:21:18'),
(5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/pressure-cooker/materialsurface/aluminium', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-08 00:25:11', 0, '2025-02-08 00:25:11', '2025-02-08 00:25:11'),
(6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/pressure-cooker/model/contura-black', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-08 00:25:17', 0, '2025-02-08 00:25:17', '2025-02-08 00:25:17'),
(7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/vacuum-flask/brand/milton', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-08 00:25:23', 0, '2025-02-08 00:25:23', '2025-02-08 00:25:23'),
(8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/landingpage', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-08 00:52:01', 0, '2025-02-08 00:52:01', '2025-02-08 00:52:01'),
(9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/?identity=916388112769&method=HL&source=WA', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-08 04:08:08', 0, '2025-02-08 04:08:08', '2025-02-08 04:08:08'),
(10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/philips-mixer-grinder-750w-hl7757/philips', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-08 08:15:01', 0, '2025-02-08 08:15:01', '2025-02-08 08:15:01'),
(11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/login?redirect=http%3A%2F%2F127.0.0.1%3A8000%2Fproducts%2Fphilips-mixer-grinder-750w-hl7757%2Fphilips', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-08 08:15:15', 0, '2025-02-08 08:15:15', '2025-02-08 08:15:15'),
(13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-09 23:01:19', 0, '2025-02-09 23:01:19', '2025-02-09 23:01:19'),
(14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/landingpage', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-09 23:07:01', 0, '2025-02-09 23:07:01', '2025-02-09 23:07:01'),
(15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-10 23:08:14', 0, '2025-02-10 23:08:14', '2025-02-10 23:08:14'),
(16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-11 04:05:34', 0, '2025-02-11 04:05:34', '2025-02-11 04:05:34'),
(17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/hawkins-pressure-cooker-classic-ind-3l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-11 05:05:51', 0, '2025-02-11 05:05:51', '2025-02-11 05:05:51'),
(18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/blogs/how-to-choose-the-perfect-pressure-cooker-for-your-needs', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-11 05:07:46', 0, '2025-02-11 05:07:46', '2025-02-11 05:07:46'),
(19, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/blogs/list', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-11 05:08:52', 0, '2025-02-11 05:08:52', '2025-02-11 05:08:52'),
(20, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/blogs/list/best-products', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-11 05:20:20', 0, '2025-02-11 05:20:20', '2025-02-11 05:20:20'),
(21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-11 05:28:11', 0, '2025-02-11 05:28:11', '2025-02-11 05:28:11'),
(22, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/cart', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-11 05:31:25', 0, '2025-02-11 05:31:25', '2025-02-11 05:31:25'),
(23, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-11 23:00:25', 0, '2025-02-11 23:00:25', '2025-02-11 23:00:25'),
(24, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 00:03:10', 0, '2025-02-12 00:03:10', '2025-02-12 00:03:10'),
(25, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/ncf28g-futura-cook-n-serve-ns-gl-3l/futura-1', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 00:04:44', 0, '2025-02-12 00:04:44', '2025-02-12 00:04:44'),
(26, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/materialsurface/stainless-steel-1', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 00:04:53', 0, '2025-02-12 00:04:53', '2025-02-12 00:04:53'),
(27, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/vacuum-flask', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 00:23:53', 0, '2025-02-12 00:23:53', '2025-02-12 00:23:53'),
(28, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 00:29:38', 0, '2025-02-12 00:29:38', '2025-02-12 00:29:38'),
(29, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/kitchen-appliances', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 00:29:47', 0, '2025-02-12 00:29:47', '2025-02-12 00:29:47'),
(30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/pressure-cooker', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 00:29:53', 0, '2025-02-12 00:29:53', '2025-02-12 00:29:53'),
(31, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact-us', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 00:34:54', 0, '2025-02-12 00:34:54', '2025-02-12 00:34:54'),
(32, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about-us', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 00:34:57', 0, '2025-02-12 00:34:57', '2025-02-12 00:34:57'),
(33, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/materialsurface/aluminium', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 01:07:50', 0, '2025-02-12 01:07:50', '2025-02-12 01:07:50'),
(34, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/hawkins-idli-stand-aluminium-for-65l/aluminium', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 01:07:54', 0, '2025-02-12 01:07:54', '2025-02-12 01:07:54'),
(35, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nsf22g-hawkins-ss-frypan-triply-gl-22cm/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 01:08:03', 0, '2025-02-12 01:08:03', '2025-02-12 01:08:03'),
(36, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/checkout', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 01:08:12', 0, '2025-02-12 01:08:12', '2025-02-12 01:08:12'),
(37, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/order/success?order_id=eyJpdiI6IjE0MXRHRGlJWk5aMHJwREQ5bkVjSnc9PSIsInZhbHVlIjoidDdTaFp5UExVYzJHU3I4RzJIR21pdz09IiwibWFjIjoiOWViOGU0OWNmMDZjNDVmNWE4YTYyYTEyNDQ1ZWQ2NDg4YmZjODY3YTY0NGFkYWFlODg5MTY2ZjgwNjY4NzEzMyIsInRhZyI6IiJ9&token=tBMuOKF4zyz0Omvr3WjwQ9BbT59ZD8pf', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 01:34:01', 0, '2025-02-12 01:34:01', '2025-02-12 01:34:01'),
(38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/philips-mixer-grinder-750w-hl7757/philips', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 01:34:15', 0, '2025-02-12 01:34:15', '2025-02-12 01:34:15'),
(39, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nap30-futura-all-purpose-pan-ns-3l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 01:34:20', 0, '2025-02-12 01:34:20', '2025-02-12 01:34:20'),
(40, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/order/success?order_id=eyJpdiI6Iml3OXJrcmNVc3lJenJBdkZkbzdEVFE9PSIsInZhbHVlIjoiQkEvQ2orUzNCUXpEUU4xeXVGbXpyQT09IiwibWFjIjoiMWYzZGVhOWQyODc0Nzc1ZGUyMjJhZDAxNzllYjdmYTgxYWYyZTdlYzQ2YWJkNWExYmE2NzY5YmJkM2VhYzQwMCIsInRhZyI6IiJ9&token=h5yXWTjGxGvKMOSWeuLuyFauXiWAXYRi', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 02:55:47', 0, '2025-02-12 02:55:47', '2025-02-12 02:55:47'),
(41, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/kitchen-appliances/brand/sujata', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 03:08:54', 0, '2025-02-12 03:08:54', '2025-02-12 03:08:54'),
(42, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nsdt28-hawkins-dosa-tava-triply-ss-28cm/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 03:21:43', 0, '2025-02-12 03:21:43', '2025-02-12 03:21:43'),
(43, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/order/success?order_id=eyJpdiI6Im5OeUVBSUlmS2lXUTNieXV1NDhWNFE9PSIsInZhbHVlIjoibC9xY1FRQ3pWR0ZUK2pDTFpmVnBlUT09IiwibWFjIjoiMTZkMjAwZTVkNzBiODMwMGM2NTk2MTg4YmY1ZTk5ZjIxMWZjZjJkOTcxNjVjZjY5OGQ2ODI3MjM3MTA4ZGI0ZSIsInRhZyI6IiJ9&token=S9fFF4Lb3dQyq5zLzZyt4kyvdILyfRVH', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 04:09:53', 0, '2025-02-12 04:09:53', '2025-02-12 04:09:53'),
(44, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/order', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 04:10:09', 0, '2025-02-12 04:10:09', '2025-02-12 04:10:09'),
(45, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/sujata-mixer-grinder-dynamix-900w/sujata', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 04:10:30', 0, '2025-02-12 04:10:30', '2025-02-12 04:10:30'),
(46, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/order/success?order_id=eyJpdiI6IjlXSTlaTTllYUJjTHR3UVlzN1IwQXc9PSIsInZhbHVlIjoiSDhuaXVONG9wVFN4d3k3OCtsY29VUT09IiwibWFjIjoiYjdlYjY3NGM2YWQ3MTg1NjNjN2FhMTc3OTdmN2UyYTc0MjU4MzhjNDhjOTYxMDllMWU5NmQzMDgzNmQ2MjkzMSIsInRhZyI6IiJ9&token=jpCT6oTyK3z8J4SdDD4i0lyyLPskEfvp', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 04:11:41', 0, '2025-02-12 04:11:41', '2025-02-12 04:11:41'),
(47, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/hawkins-t-pan-steel-wol-1l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 08:20:21', 0, '2025-02-12 08:20:21', '2025-02-12 08:20:21'),
(48, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 23:01:24', 0, '2025-02-12 23:01:24', '2025-02-12 23:01:24'),
(49, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/blogs/how-to-choose-the-perfect-pressure-cooker-for-your-needs', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-12 23:53:41', 0, '2025-02-12 23:53:41', '2025-02-12 23:53:41'),
(50, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-13 00:17:32', 0, '2025-02-13 00:17:32', '2025-02-13 00:17:32'),
(51, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-13 00:41:54', 0, '2025-02-13 00:41:54', '2025-02-13 00:41:54'),
(52, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-13 01:00:51', 0, '2025-02-13 01:00:51', '2025-02-13 01:00:51'),
(53, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-13 01:03:10', 0, '2025-02-13 01:03:10', '2025-02-13 01:03:10'),
(54, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-13 01:19:54', 0, '2025-02-13 01:19:54', '2025-02-13 01:19:54'),
(55, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-13 22:44:57', 0, '2025-02-13 22:44:58', '2025-02-13 22:44:58'),
(56, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nap30-futura-all-purpose-pan-ns-3l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-14 04:50:19', 0, '2025-02-14 04:50:19', '2025-02-14 04:50:19'),
(57, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-14 05:39:47', 0, '2025-02-14 05:39:47', '2025-02-14 05:39:47'),
(58, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/kitchen-appliances/brand/sujata', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-14 05:56:46', 0, '2025-02-14 05:56:46', '2025-02-14 05:56:46'),
(59, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/blogs/how-to-choose-the-perfect-pressure-cooker-for-your-needs', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-14 05:57:05', 0, '2025-02-14 05:57:05', '2025-02-14 05:57:05'),
(60, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/ubc125g-hawkins-casserole-aqua-baby-gl-125l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-14 05:58:13', 0, '2025-02-14 05:58:13', '2025-02-14 05:58:13'),
(61, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-14 22:52:08', 0, '2025-02-14 22:52:08', '2025-02-14 22:52:08'),
(62, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-14 23:31:45', 0, '2025-02-14 23:31:45', '2025-02-14 23:31:45'),
(63, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/kitchen-appliances/brand/sujata', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-14 23:35:47', 0, '2025-02-14 23:35:47', '2025-02-14 23:35:47'),
(64, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000/search?query=ha', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-14 23:35:56', 0, '2025-02-14 23:35:56', '2025-02-14 23:35:56'),
(65, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/search?query=5l', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-15 01:53:25', 0, '2025-02-15 01:53:25', '2025-02-15 01:53:25'),
(66, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-15 01:59:41', 0, '2025-02-15 01:59:41', '2025-02-15 01:59:41'),
(67, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/materialsurface/aluminium', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-15 02:40:54', 0, '2025-02-15 02:40:54', '2025-02-15 02:40:54'),
(68, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-16 22:46:14', 0, '2025-02-16 22:46:15', '2025-02-16 22:46:15'),
(69, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-17 22:51:15', 0, '2025-02-17 22:51:16', '2025-02-17 22:51:16'),
(70, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/myaccount', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-17 23:29:29', 0, '2025-02-17 23:29:29', '2025-02-17 23:29:29'),
(71, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-18 01:09:23', 0, '2025-02-18 01:09:24', '2025-02-18 01:09:24'),
(72, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/address', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-18 01:13:00', 0, '2025-02-18 01:13:00', '2025-02-18 01:13:00'),
(73, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nsdt28-hawkins-dosa-tava-triply-ss-28cm/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-18 01:48:32', 0, '2025-02-18 01:48:32', '2025-02-18 01:48:32'),
(74, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-18 02:53:23', 0, '2025-02-18 02:53:23', '2025-02-18 02:53:23'),
(75, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/materialsurface/aluminium', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-18 02:54:19', 0, '2025-02-18 02:54:19', '2025-02-18 02:54:19'),
(76, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/kitchen-appliances/brand/sujata', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-18 02:54:25', 0, '2025-02-18 02:54:25', '2025-02-18 02:54:25'),
(77, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/sujata-mixer-grinder-dynamix-900w/sujata', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-18 02:54:32', 0, '2025-02-18 02:54:32', '2025-02-18 02:54:32'),
(78, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 00:01:56', 0, '2025-02-19 00:01:56', '2025-02-19 00:01:56'),
(79, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nsdk25g-hawkins-deep-kadhai-ns-t-ply-gl-25l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 00:02:05', 0, '2025-02-19 00:02:05', '2025-02-19 00:02:05'),
(80, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/myaccount', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 03:47:07', 0, '2025-02-19 03:47:07', '2025-02-19 03:47:07'),
(81, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/contact-us', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 03:50:02', 0, '2025-02-19 03:50:02', '2025-02-19 03:50:02'),
(82, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/sst20g-hawkins-t-pan-steel-gl-2l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 03:50:11', 0, '2025-02-19 03:50:11', '2025-02-19 03:50:11'),
(83, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/iuc30g-hawkins-casserole-aqua-cns-gl-2l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 03:50:24', 0, '2025-02-19 03:50:24', '2025-02-19 03:50:24'),
(84, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nsdt28-hawkins-dosa-tava-triply-ss-28cm/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 03:50:39', 0, '2025-02-19 03:50:39', '2025-02-19 03:50:39'),
(85, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/checkout', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 03:50:47', 0, '2025-02-19 03:50:47', '2025-02-19 03:50:47'),
(86, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 05:15:36', 0, '2025-02-19 05:15:36', '2025-02-19 05:15:36'),
(87, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nsf22g-hawkins-ss-frypan-triply-gl-22cm/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 05:48:14', 0, '2025-02-19 05:48:14', '2025-02-19 05:48:14'),
(88, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/checkout', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 05:50:13', 0, '2025-02-19 05:50:13', '2025-02-19 05:50:13'),
(89, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 22:55:09', 0, '2025-02-19 22:55:09', '2025-02-19 22:55:09'),
(90, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/cart', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 23:12:26', 0, '2025-02-19 23:12:26', '2025-02-19 23:12:26'),
(91, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/myaccount', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 23:13:06', 0, '2025-02-19 23:13:06', '2025-02-19 23:13:06'),
(92, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/order', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 23:13:10', 0, '2025-02-19 23:13:10', '2025-02-19 23:13:10'),
(93, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/wishlist', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 23:13:16', 0, '2025-02-19 23:13:16', '2025-02-19 23:13:16'),
(94, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/ndt30-futura-dosa-tava-ns-30cm/futura-1', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 23:14:25', 0, '2025-02-19 23:14:25', '2025-02-19 23:14:25'),
(95, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 23:16:00', 0, '2025-02-19 23:16:00', '2025-02-19 23:16:00'),
(96, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 23:21:13', 0, '2025-02-19 23:21:13', '2025-02-19 23:21:13'),
(97, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nap30-futura-all-purpose-pan-ns-3l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 23:32:50', 0, '2025-02-19 23:32:50', '2025-02-19 23:32:50'),
(98, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nsdt28-hawkins-dosa-tava-triply-ss-28cm/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-19 23:33:07', 0, '2025-02-19 23:33:07', '2025-02-19 23:33:07'),
(99, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/psk35s-hawkins-pro-deep-fry-pan-t-ply-35l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-20 03:48:15', 0, '2025-02-20 03:48:15', '2025-02-20 03:48:15'),
(100, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/milton-vacuum-flask-ancy-750-ml/bottle', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-20 05:56:45', 0, '2025-02-20 05:56:45', '2025-02-20 05:56:45'),
(101, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-20 22:54:39', 0, '2025-02-20 22:54:39', '2025-02-20 22:54:39'),
(102, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/blogs/how-to-choose-the-perfect-pressure-cooker-for-your-needs', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-20 23:04:22', 0, '2025-02-20 23:04:23', '2025-02-20 23:04:23'),
(103, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/user-notifications', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-21 00:40:19', 0, '2025-02-21 00:40:19', '2025-02-21 00:40:19'),
(104, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-21 03:45:06', 0, '2025-02-21 03:45:06', '2025-02-21 03:45:06'),
(105, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-23 22:36:40', 0, '2025-02-23 22:36:40', '2025-02-23 22:36:40'),
(106, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/user-notifications', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-23 22:36:57', 0, '2025-02-23 22:36:57', '2025-02-23 22:36:57'),
(107, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-24 00:46:47', 0, '2025-02-24 00:46:47', '2025-02-24 00:46:47'),
(108, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/iuc30g-hawkins-casserole-aqua-cns-gl-2l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-24 00:51:20', 0, '2025-02-24 00:51:20', '2025-02-24 00:51:20'),
(109, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/dcm30g-hawkins-multi-snack-ns-30cm/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-24 01:02:18', 0, '2025-02-24 01:02:18', '2025-02-24 01:02:18'),
(110, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-25 05:13:57', 0, '2025-02-25 05:13:58', '2025-02-25 05:13:58'),
(111, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-25 05:14:07', 0, '2025-02-25 05:14:07', '2025-02-25 05:14:07'),
(112, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/psk35s-hawkins-pro-deep-fry-pan-t-ply-35l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-25 05:14:11', 0, '2025-02-25 05:14:11', '2025-02-25 05:14:11'),
(113, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/user-notifications', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-25 05:14:23', 0, '2025-02-25 05:14:23', '2025-02-25 05:14:23'),
(114, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-28 01:15:06', 0, '2025-02-28 01:15:06', '2025-02-28 01:15:06'),
(115, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/user-notifications', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-28 01:15:22', 0, '2025-02-28 01:15:22', '2025-02-28 01:15:22'),
(116, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000/products/iuc20g-hawkins-casserole-aqua-cns-gl-2l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-28 01:53:06', 0, '2025-02-28 01:53:06', '2025-02-28 01:53:06'),
(117, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000/products/iuc30g-hawkins-casserole-aqua-cns-gl-2l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-02-28 01:53:30', 0, '2025-02-28 01:53:30', '2025-02-28 01:53:30'),
(118, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-07 23:56:07', 0, '2025-03-07 23:56:07', '2025-03-07 23:56:07'),
(119, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/search?query=j', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-08 00:04:42', 0, '2025-03-08 00:04:42', '2025-03-08 00:04:42'),
(120, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-08 00:21:48', 0, '2025-03-08 00:21:48', '2025-03-08 00:21:48'),
(121, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 03:01:47', 0, '2025-03-10 03:01:47', '2025-03-10 03:01:47'),
(122, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nap30-futura-all-purpose-pan-ns-3l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 04:52:09', 0, '2025-03-10 04:52:09', '2025-03-10 04:52:09'),
(123, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 05:21:19', 0, '2025-03-10 05:21:19', '2025-03-10 05:21:19'),
(124, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/inf20-futura-fry-pan-ns-20cm-ib/futura-1', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 05:21:39', 0, '2025-03-10 05:21:39', '2025-03-10 05:21:39'),
(125, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/ak15g-futura-kadhai-deep-frypan-ha-gl-15l/futura-1', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 05:21:48', 0, '2025-03-10 05:21:48', '2025-03-10 05:21:48'),
(126, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/search?query=dd', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 05:28:26', 0, '2025-03-10 05:28:26', '2025-03-10 05:28:26');
INSERT INTO `visitor_tracking` (`id`, `ip_address`, `browser`, `page_name`, `location`, `visited_at`, `time_spent`, `created_at`, `updated_at`) VALUES
(127, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/ndt33-futura-dosa-tava-ns-33cm/futura-1', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 05:55:40', 0, '2025-03-10 05:55:40', '2025-03-10 05:55:40'),
(128, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/iuc30g-hawkins-casserole-aqua-cns-gl-2l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 05:55:54', 0, '2025-03-10 05:55:54', '2025-03-10 05:55:54'),
(129, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/ubc125g-hawkins-casserole-aqua-baby-gl-125l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 05:58:12', 0, '2025-03-10 05:58:12', '2025-03-10 05:58:12'),
(130, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 22:37:59', 0, '2025-03-10 22:37:59', '2025-03-10 22:37:59'),
(131, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 22:53:15', 0, '2025-03-10 22:53:16', '2025-03-10 22:53:16'),
(132, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 23:04:41', 0, '2025-03-10 23:04:41', '2025-03-10 23:04:41'),
(133, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/checkout', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 23:05:09', 0, '2025-03-10 23:05:09', '2025-03-10 23:05:09'),
(134, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/cart', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 23:05:15', 0, '2025-03-10 23:05:15', '2025-03-10 23:05:15'),
(135, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/order/success?order_id=eyJpdiI6IjF3a3pJOS91M0hWck0weW9MV0VpbGc9PSIsInZhbHVlIjoidjNEYmpzVFZyaFkzdHdpbmRDSVFnQT09IiwibWFjIjoiOWYzODg3Zjk1OWUwMWI1ZjQ0ZGRmYzI1MGYzY2JlNzY1MmQ1YjQ5ZTVlMmUyNjcyMTI3YTNiOTdmMDczMzQ4OCIsInRhZyI6IiJ9&token=oiDV8y9Tucqag6jFM3VyOfzWCWvUYLWf', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 23:07:12', 0, '2025-03-10 23:07:12', '2025-03-10 23:07:12'),
(136, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/blogs/how-to-choose-the-perfect-pressure-cooker-for-your-needs', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 23:08:07', 0, '2025-03-10 23:08:07', '2025-03-10 23:08:07'),
(137, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/ubc125g-hawkins-casserole-aqua-baby-gl-125l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 23:11:14', 0, '2025-03-10 23:11:14', '2025-03-10 23:11:14'),
(138, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', 'http://127.0.0.1:8000/products/ak15s-futura-kadhai-deep-frypan-ha-sl-15l/futura-1', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-10 23:17:20', 0, '2025-03-10 23:17:20', '2025-03-10 23:17:20'),
(139, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/kitchen-appliances/brand/sujata', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 00:11:55', 0, '2025-03-11 00:11:55', '2025-03-11 00:11:55'),
(140, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/sujata-mixer-grinder-dynamix-900w/sujata', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 00:11:59', 0, '2025-03-11 00:11:59', '2025-03-11 00:11:59'),
(141, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/order-param', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 00:56:33', 0, '2025-03-11 00:56:33', '2025-03-11 00:56:33'),
(142, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/pick-up-store', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 02:12:47', 0, '2025-03-11 02:12:47', '2025-03-11 02:12:47'),
(143, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/order/success?order_id=eyJpdiI6IkUwQytjNmRJdjlUVHAyOTkrbUxTTXc9PSIsInZhbHVlIjoiYlhLem5qOTVuWFV4SkZ2dlRuZVArdz09IiwibWFjIjoiMjNhNjZiOGQyM2M0MTllMmI0NDhhMjllNTdhMDA1OGQyYTdhYmIyZTFmOTdmYWY2ZGRmZGRiZTczNGFlNWJmMCIsInRhZyI6IiJ9&token=vUYkIUuIK9Jwt1cMzjWxua1JnpkYce7s', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 03:08:19', 0, '2025-03-11 03:08:19', '2025-03-11 03:08:19'),
(144, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/order/success?order_id=eyJpdiI6IlpVQWViaWJCZGhSVk1iTEVSYW85RlE9PSIsInZhbHVlIjoiWnBodVF3bUxqZEdGc1VnbmRKR250UT09IiwibWFjIjoiZTIwOGQyNTY1ZThlNzVhYmNkYTJmM2UxNDMxZTllMGVkMWI2OWJkMmU5N2RmM2VlZDE5OTM4MmZjZGMyNzRjNCIsInRhZyI6IiJ9&token=wKdZsM4xEg53QrwpV4AN85aS943BYYCP', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 03:21:17', 0, '2025-03-11 03:21:17', '2025-03-11 03:21:17'),
(145, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/myaccount', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 03:21:59', 0, '2025-03-11 03:21:59', '2025-03-11 03:21:59'),
(146, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/order', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 03:22:13', 0, '2025-03-11 03:22:13', '2025-03-11 03:22:13'),
(147, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 03:38:41', 0, '2025-03-11 03:38:41', '2025-03-11 03:38:41'),
(148, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nsdt28-hawkins-dosa-tava-triply-ss-28cm/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 03:40:47', 0, '2025-03-11 03:40:47', '2025-03-11 03:40:47'),
(149, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/order-param', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 03:41:04', 0, '2025-03-11 03:41:04', '2025-03-11 03:41:04'),
(150, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/search?query=Ubc125g%20Hawkins%20Casserole%20Aqua%20Baby%20G%2Fl%201.25l', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 03:58:20', 0, '2025-03-11 03:58:20', '2025-03-11 03:58:20'),
(151, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/ndt33-futura-dosa-tava-ns-33cm/futura-1', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 04:20:14', 0, '2025-03-11 04:20:14', '2025-03-11 04:20:14'),
(152, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nsf22g-hawkins-ss-frypan-triply-gl-22cm/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 04:20:25', 0, '2025-03-11 04:20:25', '2025-03-11 04:20:25'),
(153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/brand/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 05:31:24', 0, '2025-03-11 05:31:24', '2025-03-11 05:31:24'),
(154, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/sstv26-hawkins-tava-steel-triply-26cm/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 05:31:45', 0, '2025-03-11 05:31:45', '2025-03-11 05:31:45'),
(155, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/pick-up-store', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 05:32:06', 0, '2025-03-11 05:32:06', '2025-03-11 05:32:06'),
(156, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/cart', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 05:33:53', 0, '2025-03-11 05:33:53', '2025-03-11 05:33:53'),
(157, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/myaccount', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 05:36:13', 0, '2025-03-11 05:36:13', '2025-03-11 05:36:13'),
(158, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/materialsurface/aluminium', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 05:44:24', 0, '2025-03-11 05:44:24', '2025-03-11 05:44:24'),
(159, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 05:44:41', 0, '2025-03-11 05:44:41', '2025-03-11 05:44:41'),
(160, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/ubc125g-hawkins-casserole-aqua-baby-gl-125l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 05:44:54', 0, '2025-03-11 05:44:54', '2025-03-11 05:44:54'),
(161, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 22:42:48', 0, '2025-03-11 22:42:48', '2025-03-11 22:42:48'),
(162, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/cart', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 22:51:15', 0, '2025-03-11 22:51:15', '2025-03-11 22:51:15'),
(163, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/order-param', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 23:06:03', 0, '2025-03-11 23:06:03', '2025-03-11 23:06:03'),
(164, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/pick-up-store', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 23:06:16', 0, '2025-03-11 23:06:16', '2025-03-11 23:06:16'),
(165, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/nap30-futura-all-purpose-pan-ns-3l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 23:13:53', 0, '2025-03-11 23:13:53', '2025-03-11 23:13:53'),
(166, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/myaccount', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 23:15:05', 0, '2025-03-11 23:15:05', '2025-03-11 23:15:05'),
(167, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/ubc125g-hawkins-casserole-aqua-baby-gl-125l/hawkins', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 23:33:35', 0, '2025-03-11 23:33:35', '2025-03-11 23:33:35'),
(168, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/checkout', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-11 23:40:41', 0, '2025-03-11 23:40:41', '2025-03-11 23:40:41'),
(169, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/order/success?order_id=eyJpdiI6ImtLQ00yeXpVc3c5ZVNrUGpNOHZCemc9PSIsInZhbHVlIjoiN3Zld2hJQzMzK3BCQW5NajRXVXg3QT09IiwibWFjIjoiNTg1M2Q0YTRkMDA0NzY1NzEwMDY5YWIzNzgwNjUxYTI1MDgyOTJjYjdkM2M3OWNmOGNkNDIwOGM5N2ViNmYzOCIsInRhZyI6IiJ9&token=OwwliM0ffQhoLdrQDlnKQKNaTdgbNeno', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-12 00:46:57', 0, '2025-03-12 00:46:57', '2025-03-12 00:46:57'),
(170, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/cookware', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-12 01:09:18', 0, '2025-03-12 01:09:18', '2025-03-12 01:09:18'),
(171, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/account/wishlist', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-12 01:58:01', 0, '2025-03-12 01:58:01', '2025-03-12 01:58:01'),
(172, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/kitchen-catalog/cookware/materialsurface/aluminium', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-12 02:06:35', 0, '2025-03-12 02:06:35', '2025-03-12 02:06:35'),
(173, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/categories/kitchen-appliances', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-12 02:06:42', 0, '2025-03-12 02:06:42', '2025-03-12 02:06:42'),
(174, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/products/sujata-mixer-grinder-dynamix-900w/sujata', '{\"city\":\"New Haven\",\"country\":\"United States\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"currency\":\"USD\"}', '2025-03-12 02:06:45', 0, '2025-03-12 02:06:45', '2025-03-12 02:06:45');

-- --------------------------------------------------------

--
-- Table structure for table `whats_app_conversation`
--

CREATE TABLE `whats_app_conversation` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversation_message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `whats_app_conversation`
--

INSERT INTO `whats_app_conversation` (`id`, `name`, `mobile_number`, `conversation_message`, `created_at`, `updated_at`) VALUES
(1, 'Rahul Test', '8767546789', 'If the migration has already been applied, you can either:', '2025-02-11 01:12:35', '2025-02-11 01:12:35'),
(2, 'Aman test', '2323232323', 'If the migration has already been applied, you can either:', '2025-02-11 01:12:47', '2025-02-11 01:12:47'),
(3, 'Priyesh Rai', '8756432345', 'If the migration has already been applied, you can either:', '2025-02-11 01:13:06', '2025-02-11 01:13:06'),
(4, 'Rahul test', '5643234567', 'If the migration has already been applied, you can either:', '2025-02-11 01:13:24', '2025-02-11 01:13:24'),
(5, 'Akshat test', '9999999999', 'test', '2025-02-11 04:49:31', '2025-02-11 04:49:31'),
(6, 'test aman', '8888888888', 'sdfsf', '2025-02-11 04:50:15', '2025-02-11 04:50:15'),
(7, 'Rahul Test', '7651982401', 'NSDK25G HAWKINS DEEP KADHAI NS T-PLY G/L 2.5L', '2025-02-19 00:31:47', '2025-02-19 00:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `customer_id`, `product_id`, `created_at`, `updated_at`) VALUES
(47, 1, 322, '2025-01-28 07:48:29', '2025-01-28 07:48:29'),
(51, 1, 283, '2025-02-20 03:47:37', '2025-02-20 03:47:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_features`
--
ALTER TABLE `additional_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes_value`
--
ALTER TABLE `attributes_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attributes_value_attributes_id_foreign` (`attributes_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_addresses`
--
ALTER TABLE `billing_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_addresses_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogs_blog_category_id_foreign` (`blog_category_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_paragraphs`
--
ALTER TABLE `blog_paragraphs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_paragraphs_blog_id_foreign` (`blog_id`);

--
-- Indexes for table `blog_paragraph_product_links`
--
ALTER TABLE `blog_paragraph_product_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_paragraph_product_links_blog_paragraphs_id_foreign` (`blog_paragraphs_id`),
  ADD KEY `blog_paragraph_product_links_product_id_foreign` (`product_id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_customer_id_foreign` (`customer_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_customer_id_unique` (`customer_id`),
  ADD KEY `customers_group_category_id_foreign` (`group_category_id`),
  ADD KEY `customers_group_id_foreign` (`group_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_groups_category_id_foreign` (`groups_category_id`);

--
-- Indexes for table `groups_categories`
--
ALTER TABLE `groups_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventories_product_id_mrp_unique` (`product_id`,`mrp`),
  ADD UNIQUE KEY `inventories_sku_unique` (`sku`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `label`
--
ALTER TABLE `label`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mapped_category_to_attributes_for_front`
--
ALTER TABLE `mapped_category_to_attributes_for_front`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mapped_category_to_attributes_for_front_category_id_foreign` (`category_id`),
  ADD KEY `mapped_category_to_attributes_for_front_attributes_id_foreign` (`attributes_id`);

--
-- Indexes for table `map_attributes_values_to_category`
--
ALTER TABLE `map_attributes_values_to_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `map_attributes_values_to_category_category_id_foreign` (`category_id`),
  ADD KEY `map_attributes_values_to_category_attributes_value_id_foreign` (`attributes_value_id`),
  ADD KEY `map_attributes_values_to_category_attributes_id_foreign` (`attributes_id`);

--
-- Indexes for table `map_category_attributes`
--
ALTER TABLE `map_category_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `map_category_attributes_category_id_foreign` (`category_id`),
  ADD KEY `map_category_attributes_attribute_id_foreign` (`attribute_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `menu_permission`
--
ALTER TABLE `menu_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_permission_menu_id_foreign` (`menu_id`),
  ADD KEY `menu_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `menu_role`
--
ALTER TABLE `menu_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_role_menu_id_foreign` (`menu_id`),
  ADD KEY `menu_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_id_unique` (`order_id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_shipping_address_id_foreign` (`shipping_address_id`),
  ADD KEY `orders_billing_address_id_foreign` (`billing_address_id`),
  ADD KEY `orders_order_status_id_foreign` (`order_status_id`);

--
-- Indexes for table `order_lines`
--
ALTER TABLE `order_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_lines_order_id_foreign` (`order_id`),
  ADD KEY `order_lines_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_shipment_records`
--
ALTER TABLE `order_shipment_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_shipment_records_tracking_no_unique` (`tracking_no`),
  ADD KEY `order_shipment_records_order_id_foreign` (`order_id`),
  ADD KEY `order_shipment_records_order_status_id_foreign` (`order_status_id`),
  ADD KEY `order_shipment_records_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_status_status_name_unique` (`status_name`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `primary_categories`
--
ALTER TABLE `primary_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_label_id_foreign` (`label_id`);
ALTER TABLE `products` ADD FULLTEXT KEY `title` (`title`);

--
-- Indexes for table `product_additional_features`
--
ALTER TABLE `product_additional_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_additional_features_product_id_foreign` (`product_id`),
  ADD KEY `product_additional_features_additional_feature_id_foreign` (`additional_feature_id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_attributes_product_id_foreign` (`product_id`),
  ADD KEY `product_attributes_attributes_id_foreign` (`attributes_id`);

--
-- Indexes for table `product_attributes_values`
--
ALTER TABLE `product_attributes_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_attributes_values_product_id_foreign` (`product_id`),
  ADD KEY `product_attributes_values_product_attribute_id_foreign` (`product_attribute_id`),
  ADD KEY `product_attributes_values_attributes_value_id_foreign` (`attributes_value_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_addresses_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `social_media_tracking`
--
ALTER TABLE `social_media_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_category_category_id_foreign` (`category_id`);

--
-- Indexes for table `update_hsn_gst_with_attributes`
--
ALTER TABLE `update_hsn_gst_with_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `update_hsn_gst_with_attributes_category_id_foreign` (`category_id`),
  ADD KEY `update_hsn_gst_with_attributes_attributes_id_foreign` (`attributes_id`),
  ADD KEY `update_hsn_gst_with_attributes_attributes_value_id_foreign` (`attributes_value_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_logins_user_id_foreign` (`user_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_purchase_bills`
--
ALTER TABLE `vendor_purchase_bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_purchase_bills_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `vendor_purchase_lines`
--
ALTER TABLE `vendor_purchase_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_purchase_lines_inventory_id_foreign` (`inventory_id`),
  ADD KEY `vendor_purchase_lines_vendor_purchase_bill_id_index` (`vendor_purchase_bill_id`),
  ADD KEY `vendor_purchase_lines_product_id_index` (`product_id`);

--
-- Indexes for table `visitor_tracking`
--
ALTER TABLE `visitor_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whats_app_conversation`
--
ALTER TABLE `whats_app_conversation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `whats_app_conversation_name_index` (`name`),
  ADD KEY `whats_app_conversation_mobile_number_index` (`mobile_number`);
ALTER TABLE `whats_app_conversation` ADD FULLTEXT KEY `whats_app_conversation_name_mobile_number_fulltext` (`name`,`mobile_number`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_customer_id_foreign` (`customer_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_features`
--
ALTER TABLE `additional_features`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `attributes_value`
--
ALTER TABLE `attributes_value`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `billing_addresses`
--
ALTER TABLE `billing_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `blog_paragraphs`
--
ALTER TABLE `blog_paragraphs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `blog_paragraph_product_links`
--
ALTER TABLE `blog_paragraph_product_links`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(250) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(250) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `groups_categories`
--
ALTER TABLE `groups_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `label`
--
ALTER TABLE `label`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `landing_pages`
--
ALTER TABLE `landing_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mapped_category_to_attributes_for_front`
--
ALTER TABLE `mapped_category_to_attributes_for_front`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `map_attributes_values_to_category`
--
ALTER TABLE `map_attributes_values_to_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=620;

--
-- AUTO_INCREMENT for table `map_category_attributes`
--
ALTER TABLE `map_category_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `order_lines`
--
ALTER TABLE `order_lines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `order_shipment_records`
--
ALTER TABLE `order_shipment_records`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `primary_categories`
--
ALTER TABLE `primary_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT for table `product_additional_features`
--
ALTER TABLE `product_additional_features`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2028;

--
-- AUTO_INCREMENT for table `product_attributes_values`
--
ALTER TABLE `product_attributes_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2130;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `social_media_tracking`
--
ALTER TABLE `social_media_tracking`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `update_hsn_gst_with_attributes`
--
ALTER TABLE `update_hsn_gst_with_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vendor_purchase_bills`
--
ALTER TABLE `vendor_purchase_bills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vendor_purchase_lines`
--
ALTER TABLE `vendor_purchase_lines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `visitor_tracking`
--
ALTER TABLE `visitor_tracking`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `whats_app_conversation`
--
ALTER TABLE `whats_app_conversation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attributes_value`
--
ALTER TABLE `attributes_value`
  ADD CONSTRAINT `attributes_value_attributes_id_foreign` FOREIGN KEY (`attributes_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `billing_addresses`
--
ALTER TABLE `billing_addresses`
  ADD CONSTRAINT `billing_addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_paragraphs`
--
ALTER TABLE `blog_paragraphs`
  ADD CONSTRAINT `blog_paragraphs_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_paragraph_product_links`
--
ALTER TABLE `blog_paragraph_product_links`
  ADD CONSTRAINT `blog_paragraph_product_links_blog_paragraphs_id_foreign` FOREIGN KEY (`blog_paragraphs_id`) REFERENCES `blog_paragraphs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_paragraph_product_links_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_group_category_id_foreign` FOREIGN KEY (`group_category_id`) REFERENCES `groups_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customers_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_groups_category_id_foreign` FOREIGN KEY (`groups_category_id`) REFERENCES `groups_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mapped_category_to_attributes_for_front`
--
ALTER TABLE `mapped_category_to_attributes_for_front`
  ADD CONSTRAINT `mapped_category_to_attributes_for_front_attributes_id_foreign` FOREIGN KEY (`attributes_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mapped_category_to_attributes_for_front_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `map_attributes_values_to_category`
--
ALTER TABLE `map_attributes_values_to_category`
  ADD CONSTRAINT `map_attributes_values_to_category_attributes_id_foreign` FOREIGN KEY (`attributes_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `map_attributes_values_to_category_attributes_value_id_foreign` FOREIGN KEY (`attributes_value_id`) REFERENCES `attributes_value` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `map_attributes_values_to_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `map_category_attributes`
--
ALTER TABLE `map_category_attributes`
  ADD CONSTRAINT `map_category_attributes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `map_category_attributes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_billing_address_id_foreign` FOREIGN KEY (`billing_address_id`) REFERENCES `billing_addresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_order_status_id_foreign` FOREIGN KEY (`order_status_id`) REFERENCES `order_status` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `shipping_addresses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_lines`
--
ALTER TABLE `order_lines`
  ADD CONSTRAINT `order_lines_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_lines_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_shipment_records`
--
ALTER TABLE `order_shipment_records`
  ADD CONSTRAINT `order_shipment_records_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_shipment_records_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_shipment_records_order_status_id_foreign` FOREIGN KEY (`order_status_id`) REFERENCES `order_status` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_label_id_foreign` FOREIGN KEY (`label_id`) REFERENCES `label` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_additional_features`
--
ALTER TABLE `product_additional_features`
  ADD CONSTRAINT `product_additional_features_additional_feature_id_foreign` FOREIGN KEY (`additional_feature_id`) REFERENCES `additional_features` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_additional_features_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_attributes_id_foreign` FOREIGN KEY (`attributes_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_attributes_values`
--
ALTER TABLE `product_attributes_values`
  ADD CONSTRAINT `product_attributes_values_attributes_value_id_foreign` FOREIGN KEY (`attributes_value_id`) REFERENCES `attributes_value` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_values_product_attribute_id_foreign` FOREIGN KEY (`product_attribute_id`) REFERENCES `product_attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_values_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `update_hsn_gst_with_attributes`
--
ALTER TABLE `update_hsn_gst_with_attributes`
  ADD CONSTRAINT `update_hsn_gst_with_attributes_attributes_id_foreign` FOREIGN KEY (`attributes_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `update_hsn_gst_with_attributes_attributes_value_id_foreign` FOREIGN KEY (`attributes_value_id`) REFERENCES `attributes_value` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `update_hsn_gst_with_attributes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_purchase_bills`
--
ALTER TABLE `vendor_purchase_bills`
  ADD CONSTRAINT `vendor_purchase_bills_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_purchase_lines`
--
ALTER TABLE `vendor_purchase_lines`
  ADD CONSTRAINT `vendor_purchase_lines_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vendor_purchase_lines_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_purchase_lines_vendor_purchase_bill_id_foreign` FOREIGN KEY (`vendor_purchase_bill_id`) REFERENCES `vendor_purchase_bills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
