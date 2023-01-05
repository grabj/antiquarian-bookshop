-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql106.byetcluster.com
-- Generation Time: Jan 04, 2023 at 07:33 PM
-- Server version: 10.3.27-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_33318956_antiquarian_bookshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `password`) VALUES
(1, 'SuperAdmin', '$2y$10$6M2FiRr869PQgra6f/UPcu2suvaZxcbA8D2ORCaCzu5hM8MHF.BLW');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'Journalism'),
(8, 'Biography'),
(16, 'History'),
(17, 'Poetry'),
(24, 'Literary fiction'),
(25, 'Philosophy'),
(26, 'Textbook'),
(27, 'Science fiction');

-- --------------------------------------------------------

--
-- Table structure for table `condition`
--

CREATE TABLE `condition` (
  `condition_id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `condition`
--

INSERT INTO `condition` (`condition_id`, `name`, `description`) VALUES
(1, 'Mint', 'Book is in the state that it should have been in when it left the publisher.'),
(2, 'Fine', 'Book is \"as new\" but allowing for the normal effects of time on an unused book that has been protected. A fine book shows no damage.'),
(3, 'Very good', 'Book that is worn but untorn. For many collectors this is the minimum acceptable condition for all but the rarest items. Any defects must be noted.'),
(4, 'Good', 'Book is in the condition of an average used worn book that is complete. Any defects must be noted.'),
(5, 'Fair', 'Book shows wear and tear but all the text pages and illustrations or maps are present. It may lack endpapers, half-title, and even the title page. All defects must be noted.'),
(6, 'Poor', 'Book that has the complete text but is so damaged that it is only of interest to a buyer who seeks a reading copy.');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `author` tinytext NOT NULL,
  `release_year` year(4) DEFAULT NULL,
  `isbn` bigint(13) DEFAULT NULL,
  `publisher` tinytext DEFAULT NULL,
  `category` tinytext NOT NULL,
  `photo` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `condition` tinytext NOT NULL,
  `description` text DEFAULT NULL,
  `insert_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `title`, `author`, `release_year`, `isbn`, `publisher`, `category`, `photo`, `price`, `condition`, `description`, `insert_date`, `status`) VALUES
(1, 'The Dispossessed', 'Le Guin Ursula', 1991, 9780575016781, 'Orion Publishing Co', '27', 'guin-dissposessed-orion.jpg', 3.5, 'Fair', 'Book is worn but readable.', '2023-01-03 22:51:17', 1),
(3, 'The Myth of Sisyphus', 'Camus Albert', 2005, 9780141023991, 'Penguin Books', '25', 'Camus-myth.png', 4.25, 'Good', 'Cover is a little damaged.', '2023-01-03 23:01:23', 1),
(8, 'The Island of Dr Moreau', 'Wells H. G.', 1967, 140005714, 'Penguin Books', '24', 'Wells_dr_island.jpg', 10, 'Fair', 'Binding remains firm. Moderate tanning to pages throughout. Paper cover has moderate edgewear with small tears and creasing. Slight curling to corners. Wear marks overall. ', '2023-01-04 21:57:42', 1),
(13, 'Lives of the Noble Romans', 'Plutarch ', 1959, 0, 'Dell', '16', 'plutarch_YES.jpg', 8.9, 'Fair', 'Yellowed pages. Visible wear and tear on the cover.', '2023-01-05 01:44:16', 1),
(14, 'Jałowa ziemia', 'Eliot T. S.', 1989, 8308020658, 'Wydawnictwo Literackie', '17', 'Jalowa-ziemia-T-S-Eliot.jpg', 19.5, 'Good', 'Paper exterior cover is visibly damaged, although interior is intact.', '2023-01-04 21:50:57', 1),
(15, 'As I Lay Dying', 'Faulkner William', 1957, 0, 'Random House', '24', 'as_i_faulkner.jpg', 19.9, 'Very good', 'Cloth boards in good condition. good binding, no marks, bends or tears.', '2023-01-03 22:36:31', 1),
(16, 'The Conquest of Bread', 'Kropotkin Peter', 0000, 9781926878003, 'Black Cat Press', '25', 'bread_book.jpg', 5, 'Fine', '', '2023-01-04 21:57:42', 1),
(17, 'Obcy', 'Foster Alan Dean', 2019, 9788377314401, 'Vesper', '27', 'obcy_vesperpng.png', 12.5, 'Fine', '', '2023-01-04 21:49:01', 1),
(18, 'Living my life', 'Goldman Emma', 1934, 0, 'Alfred A. Knopf ', '8', 'goldman_bio1tom.jpg', 2500, 'Poor', 'Hardcover. Signed by Goldman on second blank page, dated March 22, 1938. Bound in publisher\'s gray cloth with gilt and red spine lettering. Near Fine with light wear, former owner\'s stamp on front free endpaper, in a Good original dust jacket with chips along edges (largest at head), vertical crease to front panel, sunned spine panel, tape stains to verso. ', '2023-01-04 21:59:17', 1),
(19, 'C#', 'Lis Marcin', 2016, 9788328314566, 'Helion', '26', 'csharp.jpg', 3.1, 'Good', 'Complete, undamaged.', '2023-01-04 21:59:33', 1),
(21, 'The Book of Disquiet', 'Pessoa Fernando', 2002, 9780141183046, 'Penguin Classics', '24', 'pessoa_disquiet.jpg', 3.75, 'Poor', '', '2023-01-04 22:32:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` tinytext NOT NULL,
  `last_name` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `password`, `first_name`, `last_name`, `email`, `creation_date`) VALUES
(1, '$2y$10$zdKi4/782NyTWIH6C6g4x.aehvRMbHmgSkY0/FfRjFs0A7uLWfTjK', 'Xena', 'The Warrior Princess', 'xyz@interia.pl', '2023-01-02 15:18:40'),
(42, '$2y$10$OQSYrGv4cXF.451LE6LoIePsGM7N.JrIUAdGmB0ihMafhUpvxZ8JO', 'Dobromir', 'Nowak', 'mail@o2.pl', '2023-01-05 01:09:42');

-- --------------------------------------------------------

--
-- Table structure for table `user_order`
--

CREATE TABLE `user_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_price` float NOT NULL,
  `total_products` int(11) NOT NULL,
  `status` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `condition`
--
ALTER TABLE `condition`
  ADD PRIMARY KEY (`condition_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `condition`
--
ALTER TABLE `condition`
  MODIFY `condition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user_order`
--
ALTER TABLE `user_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
