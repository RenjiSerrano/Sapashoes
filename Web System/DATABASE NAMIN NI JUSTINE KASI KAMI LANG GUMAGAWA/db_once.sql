-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 12:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_once`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `name`, `price`, `image`, `quantity`) VALUES
(16, 'Nike Jordan 1 High (SMC)', 12999.00, 'No Background.png', 1),
(17, 'New Balance 550 (3MIX)', 11999.00, '3mix550.png', 1),
(19, 'Nike Jordan 1 High (MiSaMo)', 12999.00, 'yellow tulips.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `method` varchar(55) NOT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` float(7,2) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0,
  `payment_status` int(11) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `phone_number`, `method`, `province`, `city`, `barangay`, `street`, `total_products`, `total_price`, `order_status`, `payment_status`, `order_date`) VALUES
(10, 'Mark Erick', '09456823067', 'cash on delivery', 'Albay', 'Libon', 'Zone 3', 'San Francisco Street', 'Nike Air Force 1 (3MIX) (1) , Nike Jordan 1 High (1) ', 21998.00, 1, 1, '2023-12-14'),
(11, 'Justine', '12345678912', 'cash on delivery', 'Albay', 'Ligao', 'Zone 1', 'bagumbayan', 'Nike Air Force 1 (3MIX) (1) , Nike Jordan 1 High (1) ', 21998.00, 1, 1, '2023-12-14'),
(12, 'Erick', '09456823067', 'gcash', 'Albay', 'Libon', 'Zone 3', 'San Francisco Street', 'Nike Air Force 1 (3MIX) (1) , Nike Jordan 1 High (1) ', 21998.00, 1, 1, '2023-12-14'),
(13, 'Mark', '09456823056', 'gcash', 'Albay', 'Libon', 'Zone 3', 'San Francisco Street', 'Nike Air Force 1 (3MIX) (1) , Nike Jordan 1 High (1) ', 21998.00, 0, 1, '2023-12-14'),
(14, 'Mark', '09456823056', 'gcash', 'Albay', 'Libon', 'Zone 3', 'San Francisco Street', 'Nike Air Force 1 (3MIX) (1) , Nike Jordan 1 High (1) ', 21998.00, 1, 1, '2023-12-14'),
(15, 'renjiyomo', '09456823067', 'gcash', 'Albay', 'Libon', 'Zone 3', 'San Francisco Street', 'Nike Jordan 1 High (1) ', 12999.00, 0, 1, '2023-12-14'),
(16, 'Lee Serra', '09167416587', 'cash on delivery', 'Albay', 'Polangui', 'Barangay bayanihan', '141er2352t', 'Nike Jordan 1 High (SMC) (1) , New Balance 550 (3MIX) (1) , Nike Jordan 1 High (MiSaMo) (1) ', 37997.00, 1, 1, '2023-12-15'),
(17, 'aila', '09456823066', 'gcash', 'Albay', 'Polangui', 'centro occidental', 'ubaliw', 'Nike Jordan 1 High (SMC) (1) , New Balance 550 (3MIX) (1) , Nike Jordan 1 High (MiSaMo) (1) ', 37997.00, 0, 0, '2023-12-15');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `price` float(7,2) NOT NULL,
  `image` varchar(55) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a' COMMENT 'a - active\r\ni - inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `status`) VALUES
(12, 'Nike Jordan 1 High (SMC)', 12999.00, 'No Background.png', 'a'),
(13, 'Nike Jordan 1 High (MiSaMo)', 12999.00, 'yellow tulips.png', 'a'),
(14, 'Nike Jordan 1 High (3Mix)', 12999.00, 'No bg (3).png', 'a'),
(15, 'New Balance 550 (3MIX)', 11999.00, '3mix550.png', 'a'),
(16, 'New Balance 550 (MiSaMo)', 11999.00, 'misamo550.png', 'a'),
(17, 'NB 550 (School Meal CLub)', 11999.00, 'smc550.png', 'a'),
(18, 'Nike Air Force 1 (3MIX)', 7999.00, 'sideview_3mix-removebg-preview.png', 'a'),
(19, 'Nike Jordan 1 High (MiSaMo ver.2)', 14999.00, 'no bg(ver 2).png', 'a'),
(20, 'Nike Air Force 1 (SMC)', 7999.00, 'school_meal_club.png', 'a'),
(21, 'Nike Air Force 1 (MiSaMo)', 7999.00, 'MISAMO-removebg-preview (1).png', 'a'),
(22, 'Vans Old School (3MIX)', 3999.00, 'hshs-removebg-preview.png', 'a'),
(23, 'Vans Old School (MiSaMo)', 3999.00, 'hshs_-_Copy__2_-removebg-preview.png', 'a'),
(27, 'Vans Old School (SMC)', 3999.00, 'SMC.jpg', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL,
  `user_type` char(1) NOT NULL DEFAULT 'u' COMMENT 'a - admin\r\nu - user',
  `user_status` char(1) NOT NULL DEFAULT 'a' COMMENT 'a - active\r\ni - inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `user_type`, `user_status`) VALUES
(1, 'mark erick serrano', 'markserrano05@gmail.com', 'dubu04', 'a', 'a'),
(3, 'Justine Bragais', 'bragz04@gmail.com', 'sanaminatozaki', 'u', 'a'),
(4, 'Lee Carter Serra', 'leecarterserra26@gmail.com', 'carter123', 'u', 'a'),
(5, 'Aila Moscoso', 'ailamoscoso@gmail.com', 'dongshancai', 'u', 'a'),
(6, 'Ken Dave Cate', 'kendave@gmail.com', 'davidbok', 'u', 'a'),
(7, 'andrey sergio', 'yerdnasergio@gmail.com', 'andreysergio', 'u', 'a'),
(8, 'Test Before Defense', 'Test@gmail.com', 'password', 'u', 'a'),
(9, 'jem casurog', 'jemcasurog@gmail.com', 'jemcasurog', 'u', 'a'),
(10, 'Aila Moscoso', 'Aila12@gmail.com', '12345678', 'u', 'a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
