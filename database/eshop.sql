-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.29 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for eshop
CREATE DATABASE IF NOT EXISTS `eshop` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `eshop`;

-- Dumping structure for table eshop.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `email` varchar(100) NOT NULL,
  `fname` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `lname` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `verification_code` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.admin: ~0 rows (approximately)
INSERT INTO `admin` (`email`, `fname`, `lname`, `verification_code`) VALUES
	('sdachathuranga@gmail.com', 'Ayesh', 'Chathuranga', '638d887648818');

-- Dumping structure for table eshop.brand
CREATE TABLE IF NOT EXISTS `brand` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_brand_category1_idx` (`category_id`),
  CONSTRAINT `fk_brand_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.brand: ~21 rows (approximately)
INSERT INTO `brand` (`id`, `name`, `category_id`) VALUES
	(1, 'Apple', 1),
	(2, 'Samsung', 1),
	(3, 'Sony', 1),
	(4, 'Huawei', 1),
	(5, 'Vivo', 1),
	(6, 'MSI', 2),
	(7, 'ASUS', 2),
	(8, 'DELL', 2),
	(9, 'Acer', 2),
	(10, 'Microsoft', 5),
	(11, 'Sega', 5),
	(12, 'Canon', 4),
	(13, 'Nikon', 4),
	(14, 'Xiaomi', 3),
	(15, 'Apple', 2),
	(16, 'ASUS', 3),
	(17, 'Microsoft', 3),
	(18, 'Samsung', 3),
	(19, 'Apple', 3),
	(20, 'Sony', 4),
	(21, 'Sony', 5);

-- Dumping structure for table eshop.brand_has_model
CREATE TABLE IF NOT EXISTS `brand_has_model` (
  `brand_id` int NOT NULL,
  `model_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `fk_brand_has_model_model1_idx` (`model_id`),
  KEY `fk_brand_has_model_brand1_idx` (`brand_id`),
  CONSTRAINT `fk_brand_has_model_brand1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  CONSTRAINT `fk_brand_has_model_model1` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.brand_has_model: ~25 rows (approximately)
INSERT INTO `brand_has_model` (`brand_id`, `model_id`, `id`) VALUES
	(1, 1, 1),
	(2, 2, 2),
	(3, 3, 3),
	(4, 4, 4),
	(5, 5, 5),
	(1, 6, 6),
	(6, 7, 7),
	(7, 8, 8),
	(8, 9, 9),
	(9, 10, 10),
	(1, 11, 11),
	(2, 12, 12),
	(10, 13, 13),
	(7, 14, 14),
	(14, 15, 15),
	(3, 16, 16),
	(12, 17, 17),
	(13, 18, 18),
	(12, 19, 19),
	(3, 20, 20),
	(3, 21, 21),
	(10, 22, 22),
	(3, 23, 23),
	(3, 24, 24),
	(11, 25, 25),
	(2, 5, 26);

-- Dumping structure for table eshop.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `qty` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cart_product1_idx` (`product_id`),
  KEY `fk_cart_user1_idx` (`user_email`),
  CONSTRAINT `fk_cart_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_cart_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.cart: ~4 rows (approximately)
INSERT INTO `cart` (`id`, `qty`, `product_id`, `user_email`) VALUES
	(43, 1, 2, 'chathura@gmail.com'),
	(44, 2, 5, 'chathura@gmail.com'),
	(49, 1, 35, 'eshara@gmail.com'),
	(50, 2, 5, 'eshara@gmail.com');

-- Dumping structure for table eshop.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.category: ~6 rows (approximately)
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'Smartphones and Accessories'),
	(2, 'Laptops and Accessories'),
	(3, 'Tablets'),
	(4, 'Cameras'),
	(5, 'Video game consoles'),
	(59, 'Speaker'),
	(60, 'Desktop');

-- Dumping structure for table eshop.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text,
  `date_time` datetime DEFAULT NULL,
  `status` int DEFAULT NULL,
  `from` varchar(100) NOT NULL,
  `to` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_chat_user1_idx` (`from`),
  KEY `fk_chat_user2_idx` (`to`),
  CONSTRAINT `fk_chat_user1` FOREIGN KEY (`from`) REFERENCES `user` (`email`),
  CONSTRAINT `fk_chat_user2` FOREIGN KEY (`to`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=271 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.chat: ~14 rows (approximately)
INSERT INTO `chat` (`id`, `content`, `date_time`, `status`, `from`, `to`) VALUES
	(2, 'Hello', '2022-11-01 09:12:48', 1, 'chathura@gmail.com', 'sdachathuranga@gmail.com'),
	(3, 'Hi Ayesh', '2022-10-02 09:15:05', 1, 'thisara@gmail.com', 'sdachathuranga@gmail.com'),
	(6, 'Hello', '2022-11-02 11:15:36', 1, 'sdachathuranga@gmail.com', 'chathura@gmail.com'),
	(9, 'Why', '2022-11-03 09:01:57', 1, 'thisara@gmail.com', 'sdachathuranga@gmail.com'),
	(10, 'Hey', '2022-11-03 09:03:38', 1, 'sdachathuranga@gmail.com', 'thisara@gmail.com'),
	(11, 'Hi', '2022-11-03 09:05:17', 1, 'thisara@gmail.com', 'sdachathuranga@gmail.com'),
	(12, 'How are you?', '2022-11-11 23:18:50', 1, 'sdachathuranga@gmail.com', 'thisara@gmail.com'),
	(42, 'Hey', '2022-11-12 16:10:54', 1, 'sdachathuranga@gmail.com', 'chathura@gmail.com'),
	(264, 'Hi User', '2022-11-20 00:50:09', 1, 'sdachathuranga@gmail.com', 'thisara@gmail.com'),
	(265, 'Hi Admin', '2022-11-20 00:50:43', 1, 'thisara@gmail.com', 'sdachathuranga@gmail.com'),
	(266, 'Hi Thisara', '2022-11-23 12:04:27', 1, 'sdachathuranga@gmail.com', 'thisara@gmail.com'),
	(267, 'HI Ayesh', '2022-11-23 12:05:56', 1, 'thisara@gmail.com', 'sdachathuranga@gmail.com'),
	(269, 'Hi Eshara', '2022-11-23 12:15:37', 1, 'sdachathuranga@gmail.com', 'eshara@gmail.com'),
	(270, 'Hi Admin', '2022-11-23 12:15:57', 1, 'eshara@gmail.com', 'sdachathuranga@gmail.com');

-- Dumping structure for table eshop.city
CREATE TABLE IF NOT EXISTS `city` (
  `id` int NOT NULL AUTO_INCREMENT,
  `city_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `district_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_city_district1_idx` (`district_id`),
  CONSTRAINT `fk_city_district1` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.city: ~10 rows (approximately)
INSERT INTO `city` (`id`, `city_name`, `district_id`) VALUES
	(1, 'Colombo', 1),
	(2, 'Urubokka', 10),
	(3, 'Matara', 10),
	(4, 'Kamburupitiya', 10),
	(5, 'Makandura', 10),
	(6, 'Galle', 11),
	(8, 'Gampaha', 2),
	(9, 'Hambantota', 12),
	(15, 'Kalutara', 3),
	(16, 'Deniyaya', 10);

-- Dumping structure for table eshop.colour
CREATE TABLE IF NOT EXISTS `colour` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.colour: ~5 rows (approximately)
INSERT INTO `colour` (`id`, `name`) VALUES
	(1, 'Gold'),
	(2, 'Sliver'),
	(3, 'Rose Gold'),
	(4, 'Pacific Blue'),
	(5, 'Jet Black'),
	(6, 'Graphite');

-- Dumping structure for table eshop.condition
CREATE TABLE IF NOT EXISTS `condition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.condition: ~2 rows (approximately)
INSERT INTO `condition` (`id`, `name`) VALUES
	(1, 'New'),
	(2, 'Used');

-- Dumping structure for table eshop.district
CREATE TABLE IF NOT EXISTS `district` (
  `id` int NOT NULL AUTO_INCREMENT,
  `district_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `province_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_district_province1_idx` (`province_id`),
  CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.district: ~6 rows (approximately)
INSERT INTO `district` (`id`, `district_name`, `province_id`) VALUES
	(1, 'Colombo', 2),
	(2, 'Gampaha', 2),
	(3, 'Kalutara', 2),
	(10, 'Matara', 1),
	(11, 'Galle', 1),
	(12, 'Hambantota', 1);

-- Dumping structure for table eshop.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` int DEFAULT NULL,
  `feedback` text,
  `date` datetime DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_feedback_user1_idx` (`user_email`),
  KEY `fk_feedback_product1_idx` (`product_id`),
  CONSTRAINT `fk_feedback_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_feedback_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.feedback: ~7 rows (approximately)
INSERT INTO `feedback` (`id`, `type`, `feedback`, `date`, `user_email`, `product_id`) VALUES
	(1, 1, 'Superb item', '2022-11-05 09:50:58', 'sdachathuranga@gmail.com', 35),
	(2, 2, 'Good Condition', '2022-11-05 09:51:21', 'sdachathuranga@gmail.com', 5),
	(6, 3, 'Bad Item', '2022-11-05 11:33:35', 'sdachathuranga@gmail.com', 5),
	(7, 1, 'Good Product', '2022-11-06 19:14:57', 'sdachathuranga@gmail.com', 23),
	(29, 1, 'Good Product', '2022-11-13 22:42:37', 'sdachathuranga@gmail.com', 4),
	(30, 1, 'Good Product', '2022-11-17 09:09:22', 'chathura@gmail.com', 2),
	(31, 1, 'Best Phone', '2022-11-23 12:02:57', 'eshara@gmail.com', 35);

-- Dumping structure for table eshop.gender
CREATE TABLE IF NOT EXISTS `gender` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.gender: ~2 rows (approximately)
INSERT INTO `gender` (`id`, `gender_name`) VALUES
	(1, 'Male'),
	(2, 'Female');

-- Dumping structure for table eshop.images
CREATE TABLE IF NOT EXISTS `images` (
  `code` varchar(100) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`code`),
  KEY `fk_images_product1_idx` (`product_id`),
  CONSTRAINT `fk_images_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.images: ~31 rows (approximately)
INSERT INTO `images` (`code`, `product_id`) VALUES
	('resource/product_images/iPhone-13.jpg', 1),
	('resource/product_images/Samsung-S20.jpg', 2),
	('resource/product_images/Sony-Xperia-10.jpg', 3),
	('resource/product_images/Huawei P50_0_637536b7dad69.jpeg', 4),
	('resource/product_images/vivo-z1x.jpg', 5),
	('resource/product_images/MacBook-Air.jpg', 6),
	('resource/product_images/Katana-GF66.jpg', 7),
	('resource/product_images/ZenBook-13.jpg', 8),
	('resource/product_images/Latitude-7420.jpg', 9),
	('resource/product_images/Aspire-5.jpg', 10),
	('resource/product_images/iPad-Pro-12.9.jpg', 11),
	('resource/product_images/Galaxy-Tab-S8+.jpg', 12),
	('resource/product_images/Surface-Pro-8.jpg', 13),
	('resource/product_images/ZenPad-Z8s.jpg', 14),
	('resource/product_images/Xiaomi-pad-5.jpg', 15),
	('resource/product_images/Sony-A7-III.jpg', 16),
	('resource/product_images/Canon-EOS-90D.jpg', 17),
	('resource/product_images/Nikon-D3500.jpg', 18),
	('resource/product_images/Canon-EOS-7D.jpg', 19),
	('resource/product_images/Sony-Alpha-A1.jpg', 20),
	('resource/product_images/Playstation-5.jpg', 21),
	('resource/product_images/Xbox-Series-X.jpg', 22),
	('resource/product_images/PlayStation-4.jpg', 23),
	('resource/product_images/PlayStation-VR.jpg', 24),
	('resource/product_images/Genesis-Mini.jpg', 25),
	('resource/product_images/Apple iPhone 13_0_634bd7a673828.jpeg', 35),
	('resource/product_images/Apple iPhone 13_1_634bd7a676cdd.jpeg', 35),
	('resource/product_images/Apple iPhone 13_2_634bd7a67a554.jpeg', 35),
	('resource/product_images/Canon 90D_0_637dbc5743081.jpeg', 40),
	('resource/product_images/Canon 90D_1_637dbc574692f.jpeg', 40),
	('resource/product_images/Canon 90D_2_637dbc57491e0.jpeg', 40);

-- Dumping structure for table eshop.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `total` double DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_product1_idx` (`product_id`),
  KEY `fk_invoice_user1_idx` (`user_email`),
  CONSTRAINT `fk_invoice_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_invoice_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.invoice: ~19 rows (approximately)
INSERT INTO `invoice` (`id`, `order_id`, `date`, `total`, `qty`, `status`, `product_id`, `user_email`) VALUES
	(1, '636493cad7a6f', '2022-11-04 09:54:04', 10500, 1, 4, 5, 'sdachathuranga@gmail.com'),
	(2, '636494ba99e38', '2022-11-04 09:58:14', 18000, 1, 3, 4, 'sdachathuranga@gmail.com'),
	(5, '63674c94e30d4', '2022-11-06 11:27:58', 46500, 1, 3, 12, 'sdachathuranga@gmail.com'),
	(6, '636e45b5db170', '2022-11-11 18:23:42', 36600, 1, 4, 7, 'sdachathuranga@gmail.com'),
	(7, '637129ae78033', '2022-11-13 23:01:02', 15500, 1, 2, 3, 'sdachathuranga@gmail.com'),
	(8, '63712aaab19e6', '2022-11-13 23:05:12', 15500, 1, 0, 3, 'sdachathuranga@gmail.com'),
	(9, '63712dfdb26f5', '2022-11-13 23:19:19', 18000, 1, 0, 4, 'sdachathuranga@gmail.com'),
	(10, '6374626b66e52', '2022-11-16 09:40:39', 40500, 1, 0, 35, 'sdachathuranga@gmail.com'),
	(11, '637469020f306', '2022-11-16 10:08:19', 18000, 1, 0, 4, 'sdachathuranga@gmail.com'),
	(33, '6374cf34ee668', '2022-11-16 17:24:11', 15500, 1, 0, 3, 'sdachathuranga@gmail.com'),
	(34, '6374cf34ee668', '2022-11-16 17:24:11', 10500, 1, 0, 5, 'sdachathuranga@gmail.com'),
	(35, '6374cf34ee668', '2022-11-16 17:24:11', 20700, 1, 0, 2, 'sdachathuranga@gmail.com'),
	(36, '6375a706877bd', '2022-11-17 08:46:35', 20700, 1, 0, 2, 'chathura@gmail.com'),
	(37, '6375a706877bd', '2022-11-17 08:46:35', 10500, 2, 0, 5, 'chathura@gmail.com'),
	(38, '6375ab2d6457c', '2022-11-17 09:02:18', 40500, 1, 0, 35, 'chathura@gmail.com'),
	(39, '6379004e5c9df', '2022-11-19 21:42:32', 10500, 1, 0, 5, 'sdachathuranga@gmail.com'),
	(40, '637dbdbc36338', '2022-11-23 11:59:51', 13500, 1, 0, 35, 'eshara@gmail.com'),
	(41, '637dbdbc36338', '2022-11-23 11:59:51', 10500, 2, 0, 5, 'eshara@gmail.com'),
	(42, '637dbe3dabf73', '2022-11-24 12:02:03', 39500, 3, 0, 35, 'eshara@gmail.com');

-- Dumping structure for table eshop.model
CREATE TABLE IF NOT EXISTS `model` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.model: ~25 rows (approximately)
INSERT INTO `model` (`id`, `name`) VALUES
	(1, 'iPhone 13'),
	(2, 'S20'),
	(3, 'Xperia 10'),
	(4, 'P50'),
	(5, 'Z1x'),
	(6, 'MacBook Air'),
	(7, 'Katana GF66'),
	(8, 'ZenBook 13'),
	(9, 'Latitude 7420'),
	(10, 'Aspire 5'),
	(11, 'iPad Pro 12.9'),
	(12, 'Galaxy Tab S8+'),
	(13, 'Surface Pro 8'),
	(14, 'ZenPad Z8s'),
	(15, 'pad 5'),
	(16, 'A7 III'),
	(17, 'EOS 90D'),
	(18, 'D3500'),
	(19, 'EOS 7D'),
	(20, 'Alpha A1'),
	(21, 'Playstation 5'),
	(22, 'Xbox Series X'),
	(23, 'PlayStation 4'),
	(24, 'PlayStation VR'),
	(25, 'Genesis Mini');

-- Dumping structure for table eshop.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `brand_has_model_id` int NOT NULL,
  `colour_id` int NOT NULL,
  `price` double DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `description` text,
  `title` varchar(100) DEFAULT NULL,
  `condition_id` int NOT NULL,
  `status_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `datetime_added` datetime DEFAULT NULL,
  `delivery_fee_colombo` double DEFAULT NULL,
  `delivery_fee_other` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_category1_idx` (`category_id`),
  KEY `fk_product_brand_has_model1_idx` (`brand_has_model_id`),
  KEY `fk_product_colour1_idx` (`colour_id`),
  KEY `fk_product_condition1_idx` (`condition_id`),
  KEY `fk_product_status1_idx` (`status_id`),
  KEY `fk_product_user1_idx` (`user_email`),
  CONSTRAINT `fk_product_brand_has_model1` FOREIGN KEY (`brand_has_model_id`) REFERENCES `brand_has_model` (`id`),
  CONSTRAINT `fk_product_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `fk_product_colour1` FOREIGN KEY (`colour_id`) REFERENCES `colour` (`id`),
  CONSTRAINT `fk_product_condition1` FOREIGN KEY (`condition_id`) REFERENCES `condition` (`id`),
  CONSTRAINT `fk_product_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_product_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.product: ~27 rows (approximately)
INSERT INTO `product` (`id`, `category_id`, `brand_has_model_id`, `colour_id`, `price`, `qty`, `description`, `title`, `condition_id`, `status_id`, `user_email`, `datetime_added`, `delivery_fee_colombo`, `delivery_fee_other`) VALUES
	(1, 1, 1, 3, 30000, 6, '4GB 6inch 128GB 12mp', 'Apple iPhone 13', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 10:52:25', 200, 500),
	(2, 1, 2, 2, 20000, 6, '4GB 6inch 128GB 12mp', 'Samsung S20', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 10:56:41', 300, 700),
	(3, 1, 3, 1, 15000, 17, '4GB 6inch 128 GB 12mp', 'Sony Xperia 10', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 10:58:09', 200, 500),
	(4, 1, 4, 3, 17500, 11, '4GB 6inch 128 GB 12mp', 'Huawei P50', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 10:59:45', 250, 500),
	(5, 1, 5, 2, 10000, 3, '4GB 6inch 128 GB 12mp', 'Vivo Z1x', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:01:29', 200, 500),
	(6, 2, 6, 1, 17000, 6, 'i7 12GB RAM 4GB VGA', 'MacBook Air', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:44:46', 300, 600),
	(7, 2, 7, 2, 36000, 19, 'i7 12GB RAM 4GB VGA', 'Katana GF66', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:46:27', 300, 600),
	(8, 2, 8, 3, 50000, 4, 'i7 12GB RAM 4GB VGA', 'ZenBook 13', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:47:10', 300, 600),
	(9, 2, 9, 2, 65000, 8, 'i7 12GB RAM 4GB VGA', 'Latitude 7420', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:49:09', 300, 600),
	(10, 2, 10, 2, 55000, 8, 'i7 12GB RAM 4GB VGA', 'Aspire 5', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:50:20', 300, 600),
	(11, 3, 11, 2, 27000, 12, '10 inch Quad Core IPS GPS 16GB ', 'iPad Pro 12.9', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:53:39', 250, 500),
	(12, 3, 12, 1, 46000, 13, '10 inch Quad Core IPS GPS 16GB ', 'Galaxy Tab S8+', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:55:14', 250, 500),
	(13, 3, 13, 3, 64000, 11, '10 inch Quad Core IPS GPS 16GB ', 'Surface Pro 8', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:56:20', 250, 500),
	(14, 3, 14, 3, 48000, 3, '10 inch Quad Core IPS GPS 16GB ', 'ZenPad Z8s', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:57:35', 250, 500),
	(15, 3, 15, 1, 66000, 13, '10 inch Quad Core IPS GPS 16GB ', 'Xiaomi pad 5', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:58:51', 250, 500),
	(16, 4, 16, 3, 19000, 6, 'HS 12.1MP Digital Camera', 'Sony A7 III', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 11:59:58', 400, 700),
	(17, 4, 17, 2, 87000, 9, 'HS 12.1MP Digital Camera', 'Canon EOS 90D', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 12:01:43', 400, 700),
	(18, 4, 18, 1, 95000, 2, 'HS 12.1MP Digital Camera', 'Nikon D3500', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 12:04:06', 400, 700),
	(19, 4, 19, 1, 82000, 5, 'HS 12.1MP Digital Camera', 'Canon EOS 7D', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 12:05:41', 400, 700),
	(20, 4, 20, 3, 84000, 7, 'HS 12.1MP Digital Camera', 'Sony Alpha A1', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 12:07:05', 400, 700),
	(21, 5, 21, 2, 32000, 6, '15.4inch HDMI 825GB 4K', 'Playstation 5', 1, 1, 'sdachathuranga@gmail.com', '2022-10-06 12:09:07', 600, 1000),
	(22, 5, 22, 2, 45000, 9, '15.4inch HDMI 825GB 4K', 'Xbox Series X', 2, 1, 'sdachathuranga@gmail.com', '2022-10-06 12:12:20', 600, 1000),
	(23, 5, 23, 1, 36000, 4, '15.4inch HDMI 825GB 4K', 'PlayStation 4', 2, 1, 'sdachathuranga@gmail.com', '2022-10-06 12:13:18', 600, 1000),
	(24, 5, 24, 3, 25000, 10, '15.4inch HDMI 825GB 4K', 'PlayStation VR', 2, 1, 'sdachathuranga@gmail.com', '2022-10-06 12:14:25', 600, 1000),
	(25, 5, 25, 3, 23000, 0, '15.4inch HDMI 825GB 4K', 'Genesis Mini', 2, 1, 'sdachathuranga@gmail.com', '2022-10-06 12:15:21', 600, 1000),
	(35, 1, 1, 2, 13000, 0, '12GB 6inch RAM 128GB Memory 12mp', 'Apple iPhone 13', 1, 1, 'sdachathuranga@gmail.com', '2022-10-16 15:36:30', 300, 500),
	(40, 4, 17, 5, 13000, 5, 'Featuring an impressively high-resolution 32.5MP APS-C CMOS sensor, the 90D is capable of producing imagery with notable clarity and dynamic range, as well as a broad sensitivity range of ISO 100-25600 and low noise to support working in difficult lighting situations. The sensor and image processor also realize fast performance throughout the camera system, including the ability to shoot continuously at up to 10 fps, record UHD 4K30p video, or record high-speed Full HD 1080p video at 120 fps.', 'Canon 90D', 1, 1, 'eshara@gmail.com', '2022-11-23 11:52:40', 300, 600);

-- Dumping structure for table eshop.profile_image
CREATE TABLE IF NOT EXISTS `profile_image` (
  `path` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`path`),
  KEY `fk_profile_image_user1_idx` (`user_email`),
  CONSTRAINT `fk_profile_image_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.profile_image: ~4 rows (approximately)
INSERT INTO `profile_image` (`path`, `user_email`) VALUES
	('resource/profile_img/Chathura_637da8e9b9b19.jpg', 'chathura@gmail.com'),
	('resource/profile_img/Eshara_637db8b15fa0b.jpg', 'eshara@gmail.com'),
	('resource/profile_img/Ayesh_6343b2d2c576d.jpg', 'sdachathuranga@gmail.com'),
	('resource/profile_img/Ayesh_636e88b530937.png', 'thisara@gmail.com');

-- Dumping structure for table eshop.province
CREATE TABLE IF NOT EXISTS `province` (
  `id` int NOT NULL AUTO_INCREMENT,
  `province_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.province: ~9 rows (approximately)
INSERT INTO `province` (`id`, `province_name`) VALUES
	(1, 'Southern'),
	(2, 'Western'),
	(3, 'Central'),
	(4, 'Eastern'),
	(5, 'North Central'),
	(6, 'Central'),
	(7, 'Northern'),
	(10, 'North Western'),
	(11, 'Sabaragamuwa');

-- Dumping structure for table eshop.recent
CREATE TABLE IF NOT EXISTS `recent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recent_product1_idx` (`product_id`),
  KEY `fk_recent_user1_idx` (`user_email`),
  CONSTRAINT `fk_recent_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_recent_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.recent: ~61 rows (approximately)
INSERT INTO `recent` (`id`, `product_id`, `user_email`) VALUES
	(1, 2, 'sdachathuranga@gmail.com'),
	(2, 3, 'sdachathuranga@gmail.com'),
	(3, 4, 'sdachathuranga@gmail.com'),
	(4, 5, 'sdachathuranga@gmail.com'),
	(5, 35, 'sdachathuranga@gmail.com'),
	(6, 35, 'sdachathuranga@gmail.com'),
	(7, 2, 'sdachathuranga@gmail.com'),
	(8, 3, 'sdachathuranga@gmail.com'),
	(9, 5, 'sdachathuranga@gmail.com'),
	(10, 4, 'sdachathuranga@gmail.com'),
	(11, 7, 'sdachathuranga@gmail.com'),
	(12, 18, 'sdachathuranga@gmail.com'),
	(13, 3, 'sdachathuranga@gmail.com'),
	(14, 20, 'sdachathuranga@gmail.com'),
	(15, 5, 'sdachathuranga@gmail.com'),
	(16, 19, 'sdachathuranga@gmail.com'),
	(17, 35, 'sdachathuranga@gmail.com'),
	(18, 4, 'sdachathuranga@gmail.com'),
	(19, 35, 'sdachathuranga@gmail.com'),
	(20, 5, 'sdachathuranga@gmail.com'),
	(21, 8, 'sdachathuranga@gmail.com'),
	(22, 9, 'sdachathuranga@gmail.com'),
	(23, 35, 'sdachathuranga@gmail.com'),
	(24, 4, 'sdachathuranga@gmail.com'),
	(25, 5, 'sdachathuranga@gmail.com'),
	(26, 35, 'sdachathuranga@gmail.com'),
	(27, 4, 'sdachathuranga@gmail.com'),
	(28, 5, 'sdachathuranga@gmail.com'),
	(29, 5, 'sdachathuranga@gmail.com'),
	(30, 35, 'sdachathuranga@gmail.com'),
	(31, 10, 'sdachathuranga@gmail.com'),
	(32, 11, 'sdachathuranga@gmail.com'),
	(33, 9, 'sdachathuranga@gmail.com'),
	(34, 35, 'sdachathuranga@gmail.com'),
	(35, 6, 'sdachathuranga@gmail.com'),
	(36, 2, 'sdachathuranga@gmail.com'),
	(37, 8, 'sdachathuranga@gmail.com'),
	(38, 4, 'sdachathuranga@gmail.com'),
	(39, 4, 'sdachathuranga@gmail.com'),
	(40, 7, 'sdachathuranga@gmail.com'),
	(41, 13, 'sdachathuranga@gmail.com'),
	(42, 11, 'chathura@gmail.com'),
	(43, 8, 'chathura@gmail.com'),
	(44, 35, 'chathura@gmail.com'),
	(45, 9, 'chathura@gmail.com'),
	(46, 7, 'chathura@gmail.com'),
	(47, 8, 'chathura@gmail.com'),
	(48, 5, 'sdachathuranga@gmail.com'),
	(49, 11, 'sdachathuranga@gmail.com'),
	(50, 3, 'sdachathuranga@gmail.com'),
	(51, 2, 'sdachathuranga@gmail.com'),
	(52, 1, 'sdachathuranga@gmail.com'),
	(53, 35, 'sdachathuranga@gmail.com'),
	(54, 4, 'thisara@gmail.com'),
	(55, 5, 'thisara@gmail.com'),
	(56, 6, 'eshara@gmail.com'),
	(57, 11, 'eshara@gmail.com'),
	(58, 11, 'eshara@gmail.com'),
	(59, 4, 'eshara@gmail.com'),
	(60, 8, 'eshara@gmail.com'),
	(61, 35, 'eshara@gmail.com');

-- Dumping structure for table eshop.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.status: ~2 rows (approximately)
INSERT INTO `status` (`id`, `name`) VALUES
	(1, 'Active'),
	(2, 'Deactive');

-- Dumping structure for table eshop.user
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `joined_date` datetime DEFAULT NULL,
  `varification_code` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  `gender_id` int NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_user_gender_idx` (`gender_id`),
  CONSTRAINT `fk_user_gender` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.user: ~4 rows (approximately)
INSERT INTO `user` (`email`, `fname`, `lname`, `password`, `mobile`, `joined_date`, `varification_code`, `status`, `gender_id`) VALUES
	('chathura@gmail.com', 'Chathura', 'Lakshan', '789456', '0712314679', '2022-09-29 23:37:50', NULL, 1, 1),
	('eshara@gmail.com', 'Eshara', 'Ranaveera', 'eshara123', '0771235289', '2022-11-23 11:35:56', NULL, 1, 1),
	('sdachathuranga@gmail.com', 'Ayesh', 'Chathuranga', 'ayesh156', '0781234567', '2022-10-02 08:59:26', '638875bf737ba', 1, 1),
	('thisara@gmail.com', 'Thisara', 'Lakshan', '123456', '0777123145', '2022-10-11 10:07:42', NULL, 1, 1);

-- Dumping structure for table eshop.user_has_address
CREATE TABLE IF NOT EXISTS `user_has_address` (
  `user_email` varchar(100) NOT NULL,
  `city_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `line1` text,
  `line2` text,
  `postal_code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_has_city_city1_idx` (`city_id`),
  KEY `fk_user_has_city_user1_idx` (`user_email`),
  CONSTRAINT `fk_user_has_city_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `fk_user_has_city_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.user_has_address: ~4 rows (approximately)
INSERT INTO `user_has_address` (`user_email`, `city_id`, `id`, `line1`, `line2`, `postal_code`) VALUES
	('sdachathuranga@gmail.com', 3, 1, 'Diddenipotha', 'Makandura', '123'),
	('chathura@gmail.com', 2, 2, 'Rukmalgahahena', 'Mulatiyana', '456'),
	('thisara@gmail.com', 5, 3, 'Dolagawagedara', 'Hikkotawaththa', '789'),
	('eshara@gmail.com', 4, 4, 'Ellawela', 'Horapawita', '698');

-- Dumping structure for table eshop.watchlist
CREATE TABLE IF NOT EXISTS `watchlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_watchlist_product1_idx` (`product_id`),
  KEY `fk_watchlist_user1_idx` (`user_email`),
  CONSTRAINT `fk_watchlist_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_watchlist_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.watchlist: ~3 rows (approximately)
INSERT INTO `watchlist` (`id`, `product_id`, `user_email`) VALUES
	(76, 35, 'sdachathuranga@gmail.com'),
	(77, 5, 'sdachathuranga@gmail.com'),
	(79, 2, 'sdachathuranga@gmail.com');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
