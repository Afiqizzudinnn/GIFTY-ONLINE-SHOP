-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2021 at 05:55 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `address` varchar(255) DEFAULT NULL,
  `tracking_num` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `uid`, `product_id`, `amount`, `status`, `address`, `tracking_num`, `date`) VALUES
(11, 4, 17, 12, 'unpaid', NULL, NULL, NULL),
(12, 4, 15, 13, 'Order Received', 'Lot 291, Lorong 2, Taman Magic, Magic Town 50222, Malaysia', 'EP821458748MY', '2021-10-18'),
(13, 4, 16, 23, 'Order Received', 'Lot 951, Lorong 1, Taman Joho, 95000 Magic Island, Malaysia', 'EP1231234552MY', '2021-10-18'),
(14, 4, 13, 17, 'Order Received', 'Lot 29, Lorong 21, Taman Alien, 92000 Magic Land, Malaysia', 'EP821458749MY', '2021-10-18');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `name`) VALUES
(9, 'Necklace'),
(10, 'Shorts'),
(11, 'Hat');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `categories_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `picture`, `price`, `description`, `categories_id`) VALUES
(13, 'Pearl Special', '20211018160708.jpeg', '800.00', 'A very nice necklace made from pearls', 9),
(14, 'Pure Diamond Necklace', '20211018160742.jpeg', '1700.00', 'A very pretty necklace made from pure diamond', 9),
(15, 'Diamond Enhanced', '20211018160833.jpeg', '5300.00', 'A special necklace made from the rarest diamond from the planet that give you extra attack power', 9),
(16, 'Cheap Fake Golden', '20211018160917.jpeg', '5.00', 'Make sure your girlfriend don\'t find it out!', 9),
(17, '4 Season Shorts (x4)', '20211018160954.jpeg', '30.00', 'Don\'t know what color to choose? Buy this!', 10),
(18, 'White Shorts', '20211018161025.jpeg', '10.00', 'A pretty white colored shorts', 10),
(19, 'Brown Shorts', '20211018164554.jpeg', '30.00', 'A very nice brown colored shorts!', 10),
(20, 'Black Shorts', '20211018170523.jpeg', '30.00', 'A very Black Shorts! Very Nice!', 9);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permission` varchar(255) DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `email`, `username`, `password`, `permission`) VALUES
(1, 'admin@gmail.com', 'System Admin', 'admin', 'System Admin'),
(4, 'cat2246@gmail.com', 'cat2246', '123456', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `categories_id` (`categories_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`categories_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
