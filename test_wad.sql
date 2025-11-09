-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2025 at 09:27 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_wad`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemid` int(11) NOT NULL,
  `itemname` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `unitprice` decimal(10,2) DEFAULT NULL,
  `criticalvalue` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `availability` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemid`, `itemname`, `description`, `category`, `unitprice`, `criticalvalue`, `quantity`, `availability`) VALUES
(0, 'Tempered Glass', 'CHP2020', 'Accessories', 300.00, 10, 128, ''),
(1, 'Pen', 'Atlas blue', 'Accessories', 25.00, 20, 15, 'Low Stock'),
(2, 'Pencil', 'Atlas', 'Accessories', 10.00, 20, 35, 'In Stock'),
(3, 'Exercise Book', 'A4 80 pages', 'Accessories', 150.00, 30, 100, 'In Stock'),
(4, 'Ball', 'Tennis', 'Sports', 200.00, 20, 0, 'Out of Stock'),
(5, 'Bat', 'Reebok', 'Sports', 500.00, 10, 12, 'In Stock'),
(6, 'Mouse', 'Computer USB Mouse', 'Computer Items', 1500.00, 10, 25, 'In Stock'),
(7, 'Maggie', 'Instant Noodles', 'Foods', 160.00, 30, 45, 'In Stock'),
(8, 'Keyboard', 'Computer Keyboard', 'Computer Items', 800.00, 10, 15, 'In Stock'),
(9, 'Chair', 'Chair', 'Furniture', 3000.00, 5, 2, 'Low Stock'),
(10, 'Table', 'Table', 'Furniture', 3000.00, 5, 2, 'Low Stock'),
(11, 'Table', 'Table', 'Furniture', 3000.00, 5, 2, 'Low Stock'),
(12, 'Table', 'Table', 'Furniture', 3000.00, 5, 2, 'Low Stock'),
(13, 'Table', 'Table', 'Furniture', 3000.00, 5, 2, 'Low Stock'),
(14, 'Table', 'Table', 'Furniture', 3000.00, 5, 2, 'Low Stock'),
(15, 'Table', 'Table', 'Furniture', 3000.00, 5, 2, 'Low Stock'),
(16, 'Table', 'Table', 'Furniture', 3000.00, 5, 2, 'Low Stock'),
(17, 'Watch', 'Wrist Watch', 'Accessories', 5.00, 5000, NULL, ''),
(19, 'Mobile Phone', 'Samsung Galaxy A05 ', 'Foods and Beverages', 5.00, 35000, NULL, ''),
(20, 'Tempered Glass', 'Samsung A55', 'Accessories', 300.00, 10, 150, 'In Stock'),
(21, 'Tempered Glass', 'Samsung A55', 'Accessories', 300.00, 10, 150, 'In Stock'),
(22, 'Tempered Glass', 'Samsung A10', 'Accessories', 300.00, 10, 150, 'In Stock');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderid` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `itemid` int(255) NOT NULL,
  `store_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `orderdate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderid`, `userid`, `itemid`, `store_id`, `quantity`, `orderdate`) VALUES
(1, 1, 1, 4, 10, '2025-10-25'),
(0, 1, 0, 5, 10, '2025-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `store_id` int(11) NOT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `store_name`, `contact_no`, `address`, `email`) VALUES
(4, 'Mahee Trade Center', '0772456875', 'No. 52, Galle road, Imaduwa, Galle.', 'maheetharuu@gmail.com'),
(5, 'Mahinda Trade Center', '0772456875', 'No. 52, Galle road, Imaduwa, Galle.', 'maheetharuu@gmail.com'),
(6, 'Mahinda Trade Center', '0772456875', 'No. 52, Galle road, Imaduwa, Galle.', 'maheetharuu@gmail.com'),
(7, 'Mahinda Trade Center', '0772456875', 'No. 52, Galle road, Imaduwa, Galle.', 'maheetharuu@gmail.com'),
(8, 'Hansamali Stores', '0913909831', 'No.8, Halpathota, Baddegama , Galle.', 'yasihansi@gmail.com'),
(9, 'Dewz Super Store', '0774561237', 'No.10, Temple Road, Matara.', 'dewz@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplierid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contactno` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplierid`, `name`, `contactno`, `address`) VALUES
(1, 'Kasun', '0123456789', 'Colombo');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `address`, `contact`, `email`) VALUES
(1, 'Suppier 5', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(15, 'Supplier 2', 'udapola , polahawela', '0789904877', 'Lahirulkshan129@gmail.com'),
(17, 'Suppier 5', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(18, 'Suppier 5', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(19, 'Suppier 6', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(20, 'Suppier 6', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(21, 'Suppier 7', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(22, 'Suppier 7', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(23, 'Suppier 8', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(24, 'Suppier 8', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(26, 'Suppier 9', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(27, 'Suppier 6', 'Udapola , Polgahwela.', '0789904877', 'Labtrack02@gmail.com'),
(29, 'Suppier 7', 'Udapola , Polgahwela.', '0789904877', 'Labtrack03@gmail.com'),
(30, 'Suppier 7', 'Udapola , Polgahwela.', '0789904877', 'Labtrack03@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `supply_id` int(11) NOT NULL,
  `itemid` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `supplierid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplies`
--

INSERT INTO `supplies` (`supply_id`, `itemid`, `quantity`, `supplierid`) VALUES
(2, 4, 1222, 15);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `position`, `email`) VALUES
(1, 'Ravindu', '12345', 'Customer', 'ravindu@gmail.com'),
(2, 'Bawantha', '54321', 'Customer', 'bawantha@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemid`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplierid`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`supply_id`),
  ADD KEY `itemid` (`itemid`),
  ADD KEY `supplierid` (`supplierid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `supplies`
--
ALTER TABLE `supplies`
  ADD CONSTRAINT `supplies_ibfk_1` FOREIGN KEY (`itemid`) REFERENCES `item` (`itemid`),
  ADD CONSTRAINT `supplies_ibfk_2` FOREIGN KEY (`supplierid`) REFERENCES `suppliers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
