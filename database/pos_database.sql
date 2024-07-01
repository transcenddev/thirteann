-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2024 at 01:17 PM
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
-- Database: `pos_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `product_name`, `size`, `price`, `quantity`, `total_price`) VALUES
(1, 1, 1, 'Blueberry Cheesecake', '500 ml', 49.00, 1, 49.00),
(2, 1, 6, 'Choco Cloud', '500 ml', 49.00, 2, 98.00),
(3, 2, 11, 'Cheesecake', '700 ml', 49.00, 3, 147.00),
(4, 3, 19, 'Berry Cafe', 'Regular', 49.00, 1, 49.00),
(5, 5, 24, 'Coffee Jelly', 'Regular', 49.00, 1, 49.00),
(6, 6, 3, 'Mango Cheesecake', '500 ml', 49.00, 2, 98.00),
(7, 7, 14, 'Strawberry Cheesecake', '700 ml', 59.00, 1, 59.00),
(8, 8, 22, 'Caramel Machiato', 'Regular', 49.00, 3, 147.00),
(9, 9, 28, 'Salted Toffee Nut', 'Regular', 49.00, 1, 49.00),
(10, 10, 30, 'Sunset Coffee', 'Regular', 49.00, 4, 196.00),
(11, 11, 7, 'Mango Float', '500 ml', 69.00, 1, 69.00),
(12, 12, 15, 'Choco Cloud', '700 ml', 64.00, 2, 128.00),
(13, 13, 25, 'Dirty Matcha', 'Regular', 49.00, 1, 49.00),
(14, 14, 17, 'Matcha Cloud', '700 ml', 64.00, 3, 192.00),
(15, 15, 29, 'Sparkling Coffee', 'Regular', 49.00, 4, 196.00),
(16, 16, 1, 'Blueberry Cheesecake', '500 ml', 49.00, 1, 49.00),
(17, 16, 2, 'Cheesecake', '500 ml', 39.00, 1, 39.00),
(18, 16, 3, 'Mango Cheesecake', '500 ml', 49.00, 1, 49.00),
(19, 17, 1, 'Blueberry Cheesecake', '500 ml', 147.00, 3, 147.00),
(20, 18, 10, 'Blueberry Cheesecake', '700 ml', 59.00, 2, 118.00),
(21, 18, 26, 'Himalayan Cafe', 'Regular', 64.00, 1, 64.00),
(22, 19, 14, 'Strawberry Cheesecake', '700 ml', 59.00, 3, 177.00),
(23, 19, 21, 'Cafe Mocha', 'Regular', 49.00, 2, 98.00),
(24, 20, 1, 'Blueberry Cheesecake', '500 ml', 343.00, 7, 343.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_table`
--

CREATE TABLE `order_table` (
  `order_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `receipt_id` varchar(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_received` decimal(10,2) DEFAULT NULL,
  `exact_change` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_table`
--

INSERT INTO `order_table` (`order_id`, `date`, `receipt_id`, `total_price`, `payment_received`, `exact_change`, `payment_method`) VALUES
(1, '2022-01-10', 'REC001', 98.00, 100.00, 2.00, 'Cash'),
(2, '2022-03-15', 'REC002', 142.00, 150.00, 8.00, 'Card'),
(3, '2022-05-20', 'REC003', 176.00, 180.00, 4.00, 'Cash'),
(4, '2022-08-03', 'REC004', 98.00, 100.00, 2.00, 'Card'),
(5, '2022-11-12', 'REC005', 98.00, 100.00, 2.00, 'Cash'),
(6, '2023-02-18', 'REC006', 176.00, 180.00, 4.00, 'Cash'),
(7, '2023-04-30', 'REC007', 196.00, 200.00, 4.00, 'Card'),
(8, '2023-07-08', 'REC008', 282.00, 300.00, 18.00, 'Cash'),
(9, '2023-09-22', 'REC009', 142.00, 150.00, 8.00, 'Card'),
(10, '2023-12-05', 'REC010', 224.00, 230.00, 6.00, 'Cash'),
(11, '2024-03-14', 'REC011', 176.00, 180.00, 4.00, 'Card'),
(12, '2024-06-25', 'REC012', 224.00, 230.00, 6.00, 'Cash'),
(13, '2024-09-10', 'REC013', 122.00, 130.00, 8.00, 'Card'),
(14, '2024-11-28', 'REC014', 196.00, 200.00, 4.00, 'Cash'),
(15, '2024-12-30', 'REC015', 282.00, 300.00, 18.00, 'Card'),
(16, '2024-01-25', 'REC16', 137.00, 200.00, 63.00, 'Cash'),
(17, '2024-01-25', 'REC17', 147.00, 300.00, 153.00, 'Gcash'),
(18, '2024-01-25', 'REC016', 120.00, 130.00, 10.00, 'Card'),
(19, '2023-12-25', 'REC017', 150.00, 160.00, 10.00, 'Cash'),
(20, '2024-01-26', 'REC18', 343.00, 500.00, 157.00, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `product_table`
--

CREATE TABLE `product_table` (
  `product_id` int(11) NOT NULL,
  `product_image` mediumblob DEFAULT NULL,
  `product_name` varchar(100) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_table`
--

INSERT INTO `product_table` (`product_id`, `product_image`, `product_name`, `size`, `price`, `category`) VALUES
(1, NULL, 'Blueberry Cheesecake', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(2, NULL, 'Cheesecake', '500 ml', 39.00, 'Cheesecake & Cloud Series'),
(3, NULL, 'Mango Cheesecake', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(4, NULL, 'Oreo Cheesecake', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(5, NULL, 'Strawberry Cheesecake', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(6, NULL, 'Choco Cloud', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(7, NULL, 'Mango Float', '500 ml', 69.00, 'Cheesecake & Cloud Series'),
(8, NULL, 'Matcha Cloud', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(9, NULL, 'Very Berry Snow', '500 ml', 49.00, 'Cheesecake & Cloud Series'),
(10, NULL, 'Blueberry Cheesecake', '700 ml', 59.00, 'Cheesecake & Cloud Series'),
(11, NULL, 'Cheesecake', '700 ml', 49.00, 'Cheesecake & Cloud Series'),
(12, NULL, 'Mango Cheesecake', '700 ml', 59.00, 'Cheesecake & Cloud Series'),
(13, NULL, 'Oreo Cheesecake', '700 ml', 59.00, 'Cheesecake & Cloud Series'),
(14, NULL, 'Strawberry Cheesecake', '700 ml', 59.00, 'Cheesecake & Cloud Series'),
(15, NULL, 'Choco Cloud', '700 ml', 64.00, 'Cheesecake & Cloud Series'),
(16, NULL, 'Mango Float', '700 ml', 89.00, 'Cheesecake & Cloud Series'),
(17, NULL, 'Matcha Cloud', '700 ml', 64.00, 'Cheesecake & Cloud Series'),
(18, NULL, 'Very Berry Snow', '700 ml', 64.00, 'Cheesecake & Cloud Series'),
(19, NULL, 'Berry Cafe', 'Regular', 49.00, 'Coffee Series'),
(20, NULL, 'Cafe Americano', 'Regular', 39.00, 'Coffee Series'),
(21, NULL, 'Cafe Mocha', 'Regular', 49.00, 'Coffee Series'),
(22, NULL, 'Caramel Machiato', 'Regular', 49.00, 'Coffee Series'),
(23, NULL, 'Choco Lava', 'Regular', 64.00, 'Coffee Series'),
(24, NULL, 'Coffee Jelly', 'Regular', 49.00, 'Coffee Series'),
(25, NULL, 'Dirty Matcha', 'Regular', 49.00, 'Coffee Series'),
(26, NULL, 'Himalayan Cafe', 'Regular', 64.00, 'Coffee Series'),
(27, NULL, 'Salted Caramel Machiato', 'Regular', 49.00, 'Coffee Series'),
(28, NULL, 'Salted Toffee Nut', 'Regular', 49.00, 'Coffee Series'),
(29, NULL, 'Sparkling Coffee', 'Regular', 49.00, 'Coffee Series'),
(30, NULL, 'Sunset Coffee', 'Regular', 49.00, 'Coffee Series'),
(31, NULL, 'Toffee NUT', 'Regular', 39.00, 'Coffee Series'),
(32, NULL, 'Very Berry Cafe', 'Regular', 64.00, 'Coffee Series'),
(33, NULL, 'Vintage', 'Regular', 39.00, 'Coffee Series'),
(34, NULL, 'Apple Berry', '500 ml', 29.00, 'Fruit Teas'),
(35, NULL, 'Blue Lemonade', '500 ml', 29.00, 'Fruit Teas'),
(36, NULL, 'Blue Berry', '500 ml', 29.00, 'Fruit Teas'),
(37, NULL, 'Green Apple', '500 ml', 29.00, 'Fruit Teas'),
(38, NULL, 'Lemon', '500 ml', 29.00, 'Fruit Teas'),
(39, NULL, 'Lychee', '500 ml', 29.00, 'Fruit Teas'),
(40, NULL, 'Passion Fruit', '500 ml', 29.00, 'Fruit Teas'),
(41, NULL, 'Strawberry', '500 ml', 29.00, 'Fruit Teas'),
(42, NULL, 'Apple Berry', '700 ml', 39.00, 'Fruit Teas'),
(43, NULL, 'Blue Lemonade', '700 ml', 39.00, 'Fruit Teas'),
(44, NULL, 'Blue Berry', '700 ml', 39.00, 'Fruit Teas'),
(45, NULL, 'Green Apple', '700 ml', 39.00, 'Fruit Teas'),
(46, NULL, 'Lemon', '700 ml', 39.00, 'Fruit Teas'),
(47, NULL, 'Lychee', '700 ml', 39.00, 'Fruit Teas'),
(48, NULL, 'Passion Fruit', '700 ml', 39.00, 'Fruit Teas'),
(49, NULL, 'Strawberry', '700 ml', 39.00, 'Fruit Teas'),
(50, NULL, 'Choco Matcha', '500 ml', 39.00, 'Premium Flavors'),
(51, NULL, 'Dark Choco', '500 ml', 39.00, 'Premium Flavors'),
(52, NULL, 'Dark Velvet', '500 ml', 39.00, 'Premium Flavors'),
(53, NULL, 'Double Cookies & Cream', '500 ml', 39.00, 'Premium Flavors'),
(54, NULL, 'Matcha', '500 ml', 39.00, 'Premium Flavors'),
(55, NULL, 'Matcha Red', '500 ml', 39.00, 'Premium Flavors'),
(56, NULL, 'Premium Matcha', '500 ml', 39.00, 'Premium Flavors'),
(57, NULL, 'Premium Okinawa', '500 ml', 39.00, 'Premium Flavors'),
(58, NULL, 'Premium Velvet', '500 ml', 39.00, 'Premium Flavors'),
(59, NULL, 'Strawberry & Cream', '500 ml', 39.00, 'Premium Flavors'),
(60, NULL, 'Tea Blossom', '500 ml', 39.00, 'Premium Flavors'),
(61, NULL, 'Tiger Sugar', '500 ml', 39.00, 'Premium Flavors'),
(62, NULL, 'Choco Matcha', '700 ml', 49.00, 'Premium Flavors'),
(63, NULL, 'Dark Choco', '700 ml', 49.00, 'Premium Flavors'),
(64, NULL, 'Dark Velvet', '700 ml', 49.00, 'Premium Flavors'),
(65, NULL, 'Double Cookies & Cream', '700 ml', 49.00, 'Premium Flavors'),
(66, NULL, 'Matcha', '700 ml', 49.00, 'Premium Flavors'),
(67, NULL, 'Matcha Red', '700 ml', 49.00, 'Premium Flavors'),
(68, NULL, 'Premium Matcha', '700 ml', 49.00, 'Premium Flavors'),
(69, NULL, 'Premium Okinawa', '700 ml', 49.00, 'Premium Flavors'),
(70, NULL, 'Premium Velvet', '700 ml', 49.00, 'Premium Flavors'),
(71, NULL, 'Strawberry & Cream', '700 ml', 49.00, 'Premium Flavors'),
(72, NULL, 'Tea Blossom', '700 ml', 49.00, 'Premium Flavors'),
(73, NULL, 'Tiger Sugar', '700 ml', 49.00, 'Premium Flavors'),
(74, NULL, 'BTS', '500 ml', 39.00, 'Surprise Blends Flavors'),
(75, NULL, 'Chuckie', '500 ml', 39.00, 'Surprise Blends Flavors'),
(76, NULL, 'K-Pop Oreo', '500 ml', 39.00, 'Surprise Blends Flavors'),
(77, NULL, 'Matcha Pink Drink', '500 ml', 39.00, 'Surprise Blends Flavors'),
(78, NULL, 'Meui Apollo', '500 ml', 39.00, 'Surprise Blends Flavors'),
(79, NULL, 'Melona', '500 ml', 39.00, 'Surprise Blends Flavors'),
(80, NULL, 'Mysterious Flames', '500 ml', 39.00, 'Surprise Blends Flavors'),
(81, NULL, 'Nutella', '500 ml', 39.00, 'Surprise Blends Flavors'),
(82, NULL, 'Pinoy Halo-Halo', '500 ml', 39.00, 'Surprise Blends Flavors'),
(83, NULL, 'Pistachio', '500 ml', 39.00, 'Surprise Blends Flavors'),
(84, NULL, 'Sakura Unicorn Dream', '500 ml', 39.00, 'Surprise Blends Flavors'),
(85, NULL, 'Tropical Pink Sip', '500 ml', 39.00, 'Surprise Blends Flavors'),
(86, NULL, 'BTS', '700 ml', 49.00, 'Surprise Blends Flavors'),
(87, NULL, 'Chuckie', '700 ml', 49.00, 'Surprise Blends Flavors'),
(88, NULL, 'K-Pop Oreo', '700 ml', 49.00, 'Surprise Blends Flavors'),
(89, NULL, 'Matcha Pink Drink', '700 ml', 49.00, 'Surprise Blends Flavors'),
(90, NULL, 'Meui Apollo', '700 ml', 49.00, 'Surprise Blends Flavors'),
(91, NULL, 'Melona', '700 ml', 49.00, 'Surprise Blends Flavors'),
(92, NULL, 'Mysterious Flames', '700 ml', 49.00, 'Surprise Blends Flavors'),
(93, NULL, 'Nutella', '700 ml', 49.00, 'Surprise Blends Flavors'),
(94, NULL, 'Pinoy Halo-Halo', '700 ml', 49.00, 'Surprise Blends Flavors'),
(95, NULL, 'Pistachio', '700 ml', 49.00, 'Surprise Blends Flavors'),
(96, NULL, 'Sakura Unicorn Dream', '700 ml', 49.00, 'Surprise Blends Flavors'),
(97, NULL, 'Tropical Pink Sip', '700 ml', 49.00, 'Surprise Blends Flavors'),
(98, NULL, 'Classic', '500 ml', 29.00, 'Traditional Flavors'),
(99, NULL, 'Cookies & Cream', '500 ml', 29.00, 'Traditional Flavors'),
(100, NULL, 'Okinawa', '500 ml', 29.00, 'Traditional Flavors'),
(101, NULL, 'Red Velvet', '500 ml', 29.00, 'Traditional Flavors'),
(102, NULL, 'Taro', '500 ml', 29.00, 'Traditional Flavors'),
(103, NULL, 'Wintermelon', '500 ml', 29.00, 'Traditional Flavors'),
(104, NULL, 'Classic', '700 ml', 39.00, 'Traditional Flavors'),
(105, NULL, 'Cookies & Cream', '700 ml', 39.00, 'Traditional Flavors'),
(106, NULL, 'Okinawa', '700 ml', 39.00, 'Traditional Flavors'),
(107, NULL, 'Red Velvet', '700 ml', 39.00, 'Traditional Flavors'),
(108, NULL, 'Taro', '700 ml', 39.00, 'Traditional Flavors'),
(109, NULL, 'Wintermelon', '700 ml', 39.00, 'Traditional Flavors'),
(110, NULL, 'Apple Berry Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(111, NULL, 'Blueberry Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(112, NULL, 'Green Apple Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(113, NULL, 'Lemon Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(114, NULL, 'Lychee Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(115, NULL, 'Passion Fruit Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(116, NULL, 'Strawberry Yogurt', '500 ml', 39.00, 'Yogurt Series'),
(117, NULL, 'Apple Berry Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(118, NULL, 'Blueberry Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(119, NULL, 'Green Apple Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(120, NULL, 'Lemon Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(121, NULL, 'Lychee Yogurt', '500 ml', 49.00, 'Yogurt Series'),
(122, NULL, 'Passion Fruit Yogurt', '500 ml', 49.00, 'Yogurt Series');

-- --------------------------------------------------------

--
-- Table structure for table `staff_table`
--

CREATE TABLE `staff_table` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_table`
--

INSERT INTO `staff_table` (`user_id`, `email`, `password`, `role`, `name`, `contact_number`) VALUES
(1, 'admin@example.com', '$2y$10$W9ogqXnEVAILYXiirZzfVu.KKS/fVOhh/SKwyGN1WyFbYePiiCRAm', 'Admin', 'Admin Name', '123-456-7890'),
(2, 'staff@example.com', '$2y$10$1OaWAJ5x5Hz/0rUqhrJa/OLhKoxhytKxXyBIUuC.fe48MIy6VLfPK', 'Staff', 'Staff Name', '987-654-3210');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_table`
--
ALTER TABLE `order_table`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `receipt_id` (`receipt_id`);

--
-- Indexes for table `product_table`
--
ALTER TABLE `product_table`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `staff_table`
--
ALTER TABLE `staff_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_table`
--
ALTER TABLE `order_table`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_table`
--
ALTER TABLE `product_table`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `staff_table`
--
ALTER TABLE `staff_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_table` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_table` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
