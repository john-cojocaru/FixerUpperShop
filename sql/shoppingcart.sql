-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jun 30, 2025 at 10:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoppingcart`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`) VALUES
(1, 1, '2025-06-28 23:09:33'),
(2, 1, '2025-06-28 23:24:11'),
(3, 1, '2025-06-29 00:09:47'),
(4, 1, '2025-06-29 00:15:38'),
(5, 1, '2025-06-29 00:17:11'),
(6, 1, '2025-06-30 19:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 10, 1, 4.99),
(2, 1, 8, 1, 59.99),
(3, 1, 7, 3, 14.99),
(4, 2, 9, 2, 12.99),
(5, 2, 8, 1, 59.99),
(6, 3, 8, 3, 59.99),
(7, 3, 7, 2, 14.99),
(8, 4, 7, 1, 14.99),
(9, 4, 8, 2, 59.99),
(10, 5, 8, 1, 59.99),
(11, 6, 8, 1, 59.99),
(12, 6, 7, 3, 14.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
(1, 'Cordless Drill', 'A powerful drill with adjustable torque and ergonomic grip.', 79.99, 'img/drill.jpg', '2025-06-28 21:43:08'),
(2, 'Claw Hammer', 'Heavy-duty steel claw hammer with rubber grip handle.', 19.99, 'img/hammer.jpg', '2025-06-28 21:43:08'),
(3, 'Screwdriver Set', 'Set of 6 precision screwdrivers with magnetic tips.', 15.99, 'img/screwdrivers.jpg', '2025-06-28 21:43:08'),
(4, 'Toolbox', 'Durable, lockable toolbox with removable tray.', 49.99, 'img/toolbox.jpg', '2025-06-28 21:43:08'),
(5, 'Measuring Tape', '5-meter retractable tape with locking mechanism.', 5.99, 'img/tape.jpg', '2025-06-28 21:43:08'),
(6, 'Pliers Set', '3-piece universal pliers set with insulated grips.', 24.99, 'img/pliers.jpg', '2025-06-28 21:43:08'),
(7, 'Adjustable Wrench', 'Chrome-vanadium wrench for various bolt sizes.', 14.99, 'img/wrench.jpg', '2025-06-28 21:43:08'),
(8, 'Electric Sander', 'Portable electric sander for wood and metal surfaces.', 59.99, 'img/sander.jpg', '2025-06-28 21:43:08'),
(9, 'Paint Roller Kit', '9-piece roller set with tray, handles, and covers.', 12.99, 'img/roller.jpg', '2025-06-28 21:43:08'),
(10, 'Utility Knife', 'Retractable utility knife with safety lock. Perfect for cutting hard materials.', 4.99, 'img/knife.jpg', '2025-06-28 21:43:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'John', 'john@mail.com', '$2y$10$JAOBfLyjYkFOQT1rPXGDvOS9ywQ9v/YlFqcBtKD2sDDRefXKENKdm', '2025-06-28 23:05:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
