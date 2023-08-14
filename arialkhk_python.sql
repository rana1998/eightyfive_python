-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2023 at 06:20 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arialkhk_gtron`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_report`
--

CREATE TABLE `activity_report` (
  `id` int(11) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `pkg_name` varchar(255) NOT NULL,
  `pkg_amount` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_gtron_wallet`
--

CREATE TABLE `admin_gtron_wallet` (
  `id` int(11) NOT NULL,
  `commission` float NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `sender_address` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_gtron_wallet`
--

INSERT INTO `admin_gtron_wallet` (`id`, `commission`, `transaction_type`, `sender_address`, `date`) VALUES
(1, 100, 'internal wallet transfer', 'xxxxxx', '2023-07-26 18:30:00'),
(2, 200, 'withdrawal', 'xxxxx', '2023-07-26 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_log`
--

CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `activity` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_log`
--

INSERT INTO `admin_log` (`id`, `user_name`, `activity`, `date`) VALUES
(1, 'master', 'Pending Package Approved diamond And Amount is 100', '2023-03-09 17:18:12'),
(2, 'master', 'Pending Package Approved pool And Amount is 500', '2023-03-09 17:41:51'),
(3, 'master', 'Pending Package Approved diamond And Amount is 1000', '2023-03-13 18:05:34'),
(4, 'master', 'Pending Package Approved pool And Amount is 2500', '2023-03-13 18:09:35'),
(5, 'control', 'Pending Package Approved vineet And Amount is 2500', '2023-03-14 12:07:09'),
(6, 'control', 'Email changed form contact@maxicoin.com email to vineet.miskin@mazimatic.com email', '2023-03-14 12:33:47');

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(1) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp_code` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `user_name`, `password`, `email`, `otp_code`) VALUES
(1, 'control', '$2y$10$HSX6Fk1TZYi0DUGie5wMcudvNKLJxfgV7V7RPzPHV1IcPX.IpVas2', '', 0),
(2, 'master', '$2y$10$g8YxOlPBwY6YxRJHVj6V8.XQD7Svdk4HWfzJHhgJRQpZmdncAG/RO', '2015kshitij14@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_wallet`
--

CREATE TABLE `admin_wallet` (
  `wallet_id` int(11) NOT NULL,
  `wallet_amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_wallet`
--

INSERT INTO `admin_wallet` (`wallet_id`, `wallet_amount`) VALUES
(1, 138.294);

-- --------------------------------------------------------

--
-- Table structure for table `admin_wallet_summary`
--

CREATE TABLE `admin_wallet_summary` (
  `owner_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `wallet_address` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `gtron_commission` float NOT NULL,
  `otp_code` int(30) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_wallet_summary`
--

INSERT INTO `admin_wallet_summary` (`owner_id`, `email`, `wallet_address`, `owner`, `gtron_commission`, `otp_code`, `date`) VALUES
(1, 'selvaraj@gtron.io', 'TPHyyDRvbT3LgoSmqWTHVuMUBeZB45jKvk', 'Selvaraj', 100, 476966, '2023-07-27'),
(2, 'rajesh@gtron.io', 'TJCGXFG5VbfK6UjwGsyF9s4FFtWRfsk8gY', 'Rajesh', 200, 0, '2023-07-27'),
(3, 'rajendran@gtron.io', 'TBDMNMhNPw9TbAeRsaFQL1fvHKUYQp5KNy', 'Rajendran', 100, 0, '2023-07-27'),
(4, 'project', 'project@address', 'project features', 400, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_wallet_summary_logs`
--

CREATE TABLE `admin_wallet_summary_logs` (
  `id` int(11) NOT NULL,
  `owner_id_fk` int(11) NOT NULL,
  `wallet_address` int(11) NOT NULL,
  `previous_amount` float NOT NULL,
  `new_amount` float NOT NULL,
  `gtron_commission` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `file` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `description`, `file`, `date`) VALUES
(3, 'Refer More than 4 People and Get Exciting GTRON Rewards. Offers Valid Till June 30 2023. Start Now', 'Refer More than 4 People and Get Exciting GTRON Rewards. Offers Valid Till June 30 2023. Start Now', '../member/images/announcement/ceef44d2b457df6ba08e42bf0809f5a9-Untitled Photo (4).jpg', '2023-06-10 06:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(250) NOT NULL,
  `account_title` varchar(250) NOT NULL,
  `account_number` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `bank_name`, `account_title`, `account_number`, `date`) VALUES
(5, 'Gcash', 'Gcash', '12345678', '2022-03-02 19:34:46'),
(8, 'Palawan Express', 'Palawan Express', '12345678', '2022-03-02 19:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `bonuses_details`
--

CREATE TABLE `bonuses_details` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `bonus_amount` float NOT NULL,
  `level` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bonuses_details`
--

INSERT INTO `bonuses_details` (`id`, `sender`, `receiver`, `bonus_amount`, `level`, `date`) VALUES
(1, 'Level 1 Bonus', 'MLM2', 500, 1, '2023-06-24 18:30:00'),
(2, 'Level 1 Bonus', 'MLM3', 500, 1, '2023-06-24 18:30:00'),
(3, 'Level 1 Bonus', 'MLM2', 50, 1, '2023-06-24 18:30:00'),
(4, 'Level 1 Bonus', 'MLM3', 125, 1, '2023-06-24 18:30:00'),
(5, 'Level 2 Bonus', 'MLM2', 20, 2, '2023-06-24 18:30:00'),
(6, 'Level 1 Bonus', 'MLM4', 50, 1, '2023-06-24 18:30:00'),
(7, 'Level 2 Bonus', 'MLM3', 8, 2, '2023-06-24 18:30:00'),
(8, 'Level 1 Bonus', 'MLM2', 50, 1, '2023-06-24 18:30:00'),
(9, 'Level 1 Bonus', 'MLM6', 50, 1, '2023-06-24 18:30:00'),
(10, 'Level 2 Bonus', 'MLM3', 8, 2, '2023-06-24 18:30:00'),
(11, 'Level 3 Bonus', 'MLM2', 6, 3, '2023-06-24 18:30:00'),
(12, 'Level 1 Bonus', 'MLM7', 500, 1, '2023-06-24 18:30:00'),
(13, 'Level 1 Bonus', 'MLM2', 250, 1, '2023-06-24 18:30:00'),
(14, 'Level 1 Bonus', 'MLM9', 50, 1, '2023-06-24 18:30:00'),
(15, 'Level 4 Bonus', 'MLM2', 4, 4, '2023-06-24 18:30:00'),
(16, 'Level 1 Bonus', 'MLM10', 125, 1, '2023-06-24 18:30:00'),
(17, 'Level 1 Bonus', 'MLM2', 50, 1, '2023-06-24 18:30:00'),
(18, 'Level 1 Bonus', 'MLM12', 50, 1, '2023-06-24 18:30:00'),
(19, 'Level 5 Bonus', 'MLM2', 3, 5, '2023-06-24 18:30:00'),
(20, 'Level 1 Bonus', 'MLM13', 500, 1, '2023-06-24 18:30:00'),
(21, 'Level 1 Bonus', 'MLM2', 50, 1, '2023-06-24 18:30:00'),
(22, 'Level 1 Bonus', 'MLM15', 50, 1, '2023-06-24 18:30:00'),
(23, 'Level 6 Bonus', 'MLM2', 1, 6, '2023-06-24 18:30:00'),
(24, 'Level 1 Bonus', 'MLM13', 50, 1, '2023-06-24 18:30:00'),
(25, 'Level 6 Bonus', 'MLM2', 1, 6, '2023-06-24 18:30:00'),
(26, 'Level 1 Bonus', 'MLM16', 50, 1, '2023-06-24 18:30:00'),
(27, 'Level 1 Bonus', 'MLM2', 50, 1, '2023-06-24 18:30:00'),
(28, 'Level 1 Bonus', 'MLM18', 500, 1, '2023-06-24 18:30:00'),
(29, 'Level 7 Bonus', 'MLM2', 10, 7, '2023-06-24 18:30:00'),
(30, 'Level 1 Bonus', 'MLM19', 50, 1, '2023-06-24 18:30:00'),
(31, 'Level 1 Bonus', 'MLM2', 50, 1, '2023-06-24 18:30:00'),
(32, 'Level 1 Bonus', 'MLM21', 500, 1, '2023-06-24 18:30:00'),
(33, 'Level 8 Bonus', 'MLM2', 10, 8, '2023-06-24 18:30:00'),
(34, 'Level 1 Bonus', 'MLM22', 50, 1, '2023-06-24 18:30:00'),
(35, 'Level 1 Bonus', 'MLM2', 50, 1, '2023-06-24 18:30:00'),
(36, 'Level 1 Bonus', 'MLM24', 250, 1, '2023-06-24 18:30:00'),
(37, 'Level 9 Bonus', 'MLM2', 2.5, 9, '2023-06-24 18:30:00'),
(38, 'Level 1 Bonus', 'MLM25', 50, 1, '2023-06-24 18:30:00'),
(39, 'Level 1 Bonus', 'MLM2', 50, 1, '2023-06-24 18:30:00'),
(40, 'Level 1 Bonus', 'MLM27', 50, 1, '2023-06-24 18:30:00'),
(41, 'Level 10 Bonus', 'MLM2', 0.5, 10, '2023-06-24 18:30:00'),
(42, 'Level 1 Bonus', 'MLM3', 50, 1, '2023-06-24 18:30:00'),
(43, 'Level 2 Bonus', 'MLM2', 8, 2, '2023-06-24 18:30:00'),
(44, 'Level 1 Bonus', 'MLM4', 125, 1, '2023-06-24 18:30:00'),
(45, 'Level 2 Bonus', 'MLM3', 20, 2, '2023-06-24 18:30:00'),
(46, 'Level 3 Bonus', 'MLM2', 15, 3, '2023-06-24 18:30:00'),
(47, 'Level 1 Bonus', 'MLM7', 50, 1, '2023-06-24 18:30:00'),
(48, 'Level 2 Bonus', 'MLM4', 8, 2, '2023-06-24 18:30:00'),
(49, 'Level 3 Bonus', 'MLM3', 6, 3, '2023-06-24 18:30:00'),
(50, 'Level 4 Bonus', 'MLM2', 4, 4, '2023-06-24 18:30:00'),
(51, 'Level 1 Bonus', 'MLM10', 50, 1, '2023-06-24 18:30:00'),
(52, 'Level 2 Bonus', 'MLM7', 8, 2, '2023-06-24 18:30:00'),
(53, 'Level 3 Bonus', 'MLM4', 6, 3, '2023-06-24 18:30:00'),
(54, 'Level 5 Bonus', 'MLM2', 3, 5, '2023-06-24 18:30:00'),
(55, 'Level 1 Bonus', 'MLM3', 50, 1, '2023-06-24 18:30:00'),
(56, 'Level 2 Bonus', 'MLM2', 8, 2, '2023-06-24 18:30:00'),
(57, 'Level 1 Bonus', 'MLM13', 50, 1, '2023-06-24 18:30:00'),
(58, 'Level 2 Bonus', 'MLM10', 8, 2, '2023-06-24 18:30:00'),
(59, 'Level 6 Bonus', 'MLM2', 1, 6, '2023-06-24 18:30:00'),
(60, 'Level 1 Bonus', 'MLM10', 50, 1, '2023-06-24 18:30:00'),
(61, 'Level 2 Bonus', 'MLM7', 8, 2, '2023-06-24 18:30:00'),
(62, 'Level 3 Bonus', 'MLM4', 6, 3, '2023-06-24 18:30:00'),
(63, 'Level 4 Bonus', 'MLM3', 4, 4, '2023-06-24 18:30:00'),
(64, 'Level 5 Bonus', 'MLM2', 3, 5, '2023-06-24 18:30:00'),
(65, 'Level 1 Bonus', 'MLM10', 50, 1, '2023-06-30 18:30:00'),
(66, 'Level 2 Bonus', 'MLM7', 8, 2, '2023-06-30 18:30:00'),
(67, 'Level 3 Bonus', 'MLM4', 6, 3, '2023-06-30 18:30:00'),
(68, 'Level 4 Bonus', 'MLM3', 4, 4, '2023-06-30 18:30:00'),
(69, 'Level 5 Bonus', 'MLM2', 3, 5, '2023-06-30 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `date`) VALUES
(1, 'testing', '2022-03-15 19:34:13'),
(2, 'testing1', '2022-03-15 19:35:54'),
(3, 'Electronics', '2022-03-19 07:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `commission_percentage`
--

CREATE TABLE `commission_percentage` (
  `id` int(11) NOT NULL,
  `level1` float NOT NULL,
  `level2` float NOT NULL,
  `level3` float NOT NULL,
  `level4` float NOT NULL,
  `level5` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `commission_percentage`
--

INSERT INTO `commission_percentage` (`id`, `level1`, `level2`, `level3`, `level4`, `level5`) VALUES
(1, 4, 3, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263);

-- --------------------------------------------------------

--
-- Table structure for table `cron_log`
--

CREATE TABLE `cron_log` (
  `id` int(12) NOT NULL,
  `filename` varchar(66) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `current_rates`
--

CREATE TABLE `current_rates` (
  `id` int(11) NOT NULL,
  `from_currency` varchar(250) NOT NULL,
  `to_currency` varchar(250) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donate`
--

CREATE TABLE `donate` (
  `id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `mode` varchar(250) NOT NULL,
  `bank` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `trans_id` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'Pending',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gtron_feature_project`
--

CREATE TABLE `gtron_feature_project` (
  `id` int(11) NOT NULL,
  `project_name` varchar(50) DEFAULT NULL,
  `percentage` decimal(5,2) DEFAULT NULL,
  `gtron_commision` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc`
--

CREATE TABLE `kyc` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `image1` varchar(200) NOT NULL,
  `image2` varchar(200) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `image4` varchar(250) NOT NULL,
  `id_no` varchar(255) NOT NULL,
  `doc_type` varchar(255) NOT NULL,
  `issue_date` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Pending',
  `reason` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kyc`
--

INSERT INTO `kyc` (`id`, `user_name`, `image1`, `image2`, `image3`, `image4`, `id_no`, `doc_type`, `issue_date`, `expire_date`, `status`, `reason`, `date`) VALUES
(1, 'mlm68', 'img1-64b7d56ed8002.png', 'img2-64b7d56ed800f.png', 'img3-64b7d56ed8015.png', 'img3-64b7d56ed8015.png', '12222222', 'national_id', '2023-07-07', '2023-07-19', 'Approved', '', '2023-07-19 17:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `level_percentage`
--

CREATE TABLE `level_percentage` (
  `id` int(11) NOT NULL,
  `level1` float NOT NULL,
  `level2` float NOT NULL,
  `level3` float NOT NULL,
  `level4` float NOT NULL,
  `level5` float NOT NULL,
  `level6` float NOT NULL,
  `level7` float NOT NULL,
  `level8` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `level_percentage`
--

INSERT INTO `level_percentage` (`id`, `level1`, `level2`, `level3`, `level4`, `level5`, `level6`, `level7`, `level8`) VALUES
(1, 8, 4, 1, 2, 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `ip` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `postal_code` varchar(250) NOT NULL,
  `region` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  `browser` varchar(250) NOT NULL,
  `device` varchar(250) NOT NULL,
  `os` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `user_name`, `ip`, `city`, `postal_code`, `region`, `country`, `browser`, `device`, `os`, `date`) VALUES
(8, 'mlm49', '', '', '', '', '', '', '', '', '2023-07-10 10:27:18'),
(9, 'mlm6', '', '', '', '', '', '', '', '', '2023-07-01 10:33:07'),
(10, 'mlm50', '', '', '', '', '', '', '', '', '2023-07-11 09:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `monthly_percentage`
--

CREATE TABLE `monthly_percentage` (
  `id` int(11) NOT NULL,
  `2month` float NOT NULL,
  `5month` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_share`
--

CREATE TABLE `monthly_share` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `bonus_amount` float NOT NULL,
  `level` int(11) NOT NULL,
  `temp_amount` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `old_share`
--

CREATE TABLE `old_share` (
  `id` int(11) NOT NULL,
  `old_share` float NOT NULL,
  `todays_share` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `pkg_price` varchar(250) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id`, `package_name`, `pkg_price`, `image`, `date`) VALUES
(1, 'MLM 1', '50', 'images/packageImages/765c36199e3725b9b40091849777f381-padlock.png', '2022-03-07 21:29:49'),
(2, 'MLM 2', '100', 'images/packageImages/765c36199e3725b9b40091849777f381-padlock.png', '2022-03-08 02:22:02'),
(3, 'MLM 3', '250', 'images/packageImages/cc1487436993605a04db920612a121e5-starter.png', '2022-03-08 13:04:11'),
(4, 'MLM 4', '500', NULL, '2022-05-17 14:35:19'),
(5, 'MLM 5', '1000', NULL, '2022-05-17 14:35:19'),
(7, 'testing', '600', 'images/packageImages/2b480f9abc9f68f475b21b144a40b3a0-user-profile.png.png', '2023-08-10 11:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `package_details`
--

CREATE TABLE `package_details` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `sponsor_name` varchar(255) NOT NULL,
  `pkg_id` int(250) NOT NULL DEFAULT 0,
  `pkg_name` varchar(255) NOT NULL,
  `pkg_price` float NOT NULL,
  `tax` float NOT NULL DEFAULT 0,
  `amount_after_tax` float NOT NULL DEFAULT 0,
  `mode` varchar(255) NOT NULL,
  `type` varchar(250) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `days` int(250) NOT NULL,
  `trans_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `roi_status` varchar(255) NOT NULL DEFAULT 'Inactive',
  `received_roi` float NOT NULL DEFAULT 0,
  `no_of_roi` int(255) NOT NULL DEFAULT 0,
  `reason` varchar(255) NOT NULL DEFAULT 'N/A',
  `approved_by` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `package_details`
--

INSERT INTO `package_details` (`id`, `user_name`, `sponsor_name`, `pkg_id`, `pkg_name`, `pkg_price`, `tax`, `amount_after_tax`, `mode`, `type`, `bank`, `image`, `days`, `trans_id`, `status`, `roi_status`, `received_roi`, `no_of_roi`, `reason`, `approved_by`, `date`) VALUES
(1, 'MLM1', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-6497efa9b6e52', 'Approved', 'Active', 0, 0, '', '', '2023-07-11 02:11:29'),
(2, 'MLM1', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497efcbbabe6', 'Approved', 'Active', 0, 0, '', '', '2023-07-06 02:12:03'),
(3, 'MLM2', '', 3, 'MLM 3', 250, 0, 0, '', '', '', '', 0, 'TXN-6497f0006eb9a', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 02:12:56'),
(4, 'MLM3', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-6497f0799c5ef', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 02:14:57'),
(5, 'MLM4', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-6497f0ba67940', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 02:16:02'),
(6, 'MLM5', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497f10813d80', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 02:17:20'),
(7, 'MLM6', '', 3, 'MLM 3', 250, 0, 0, '', '', '', '', 0, 'TXN-6497f16861104', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 02:18:56'),
(8, 'MLM7', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497f1e172afd', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 02:20:57'),
(9, 'MLM8', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497f2298f8e5', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 02:22:09'),
(10, 'MLM9', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497f2a292572', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 02:24:10'),
(11, 'MLM10', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-6497f2ef7f620', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 02:25:27'),
(12, 'MLM11', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-6497f337381e9', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 02:26:39'),
(13, 'MLM2', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-6497fd0e59076', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:08:38'),
(14, 'MLM12', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497fd5396839', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:09:47'),
(15, 'MLM13', '', 3, 'MLM 3', 250, 0, 0, '', '', '', '', 0, 'TXN-6497fd9a24d42', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:10:58'),
(16, 'MLM14', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497fde5e6908', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:12:13'),
(17, 'MLM15', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497fe2c3b827', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:13:24'),
(18, 'MLM16', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-6497fe77c6b4f', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:14:39'),
(19, 'MLM17', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497febf2783f', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:15:51'),
(20, 'MLM18', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497fef7deb9f', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:16:47'),
(21, 'MLM16', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497ff43a19b5', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:18:03'),
(22, 'MLM19', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6497ffed78b3c', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:20:53'),
(23, 'MLM20', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-64980082c1d19', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:23:22'),
(24, 'MLM21', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-649800f426cc6', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:25:16'),
(25, 'MLM22', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6498013ee0fef', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:26:30'),
(26, 'MLM23', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-64980182df0cc', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:27:38'),
(27, 'MLM24', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-649801b3e82ed', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:28:27'),
(28, 'MLM25', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-649801e7d0420', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:29:19'),
(29, 'MLM26', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-649802137580e', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:30:03'),
(30, 'MLM27', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-649802527349e', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:31:06'),
(31, 'MLM28', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6498029f4d797', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:32:23'),
(32, 'MLM29', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-649802f03f96f', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:33:44'),
(33, 'MLM30', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-649803670b5c1', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:35:43'),
(34, 'MLM1', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64980404eac61', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:38:20'),
(35, 'MLM31', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-649804105c21e', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:38:32'),
(36, 'MLM32', '', 3, 'MLM 3', 250, 0, 0, '', '', '', '', 0, 'TXN-6498047c39bb3', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:40:20'),
(37, 'MLM34', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6498051fc6567', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:43:03'),
(38, 'MLM35', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-64980579aec0a', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:44:33'),
(39, 'MLM36', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-649805afd5e7f', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:45:27'),
(40, 'MLM37', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-649806128cf7c', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:47:06'),
(41, 'MLM38', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-6498070e30cef', 'Approved', 'Active', 0, 0, '', '', '2023-06-25 03:51:18'),
(42, 'MLM1', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-649bc8a608c4c', 'Approved', 'Active', 0, 0, '', '', '2023-06-28 00:14:06'),
(43, 'MLM38', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-64a0291030e07', 'Approved', 'Active', 0, 0, '', '', '2023-07-01 07:54:32'),
(44, 'MLM1', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64a12deb1b0fa', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:27:31'),
(45, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a12df9dde39', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:27:45'),
(46, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a12f08e6bb9', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:32:16'),
(47, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a12f0abf549', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:32:18'),
(48, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a12f8750257', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:34:23'),
(49, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a12f8a8d8b4', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:34:26'),
(50, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a12f8c80547', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:34:28'),
(51, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a1322ba40b7', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:45:39'),
(52, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a1330ed4009', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:49:26'),
(53, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a133103496b', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:49:28'),
(54, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a1331280447', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:49:30'),
(55, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a13313e27ad', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:49:31'),
(56, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a134d87f8e2', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:57:04'),
(57, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a134dc8a80e', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:57:08'),
(58, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a134de60aea', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:57:10'),
(59, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a134dfcec7f', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 02:57:11'),
(60, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a136953e7f4', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 03:04:29'),
(61, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a136a1a73d5', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 03:04:41'),
(62, 'MLM1', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a13a6423238', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 03:20:44'),
(63, 'MLM2', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a13a6b30895', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 03:20:51'),
(64, 'MLM3', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a13f60dc193', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 03:42:00'),
(65, 'MLM3', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a14b6fc5caa', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 04:33:27'),
(66, 'MLM1', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64a157987ab88', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:25:20'),
(67, 'MLM2', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-64a157a31228d', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:25:31'),
(68, 'MLM3', '', 3, 'MLM 3', 250, 0, 0, '', '', '', '', 0, 'TXN-64a157badd2f6', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:25:54'),
(69, 'MLM40', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a158be8d50a', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:30:14'),
(70, 'MLM41', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a158cbc8245', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:30:27'),
(71, 'MLM41', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a15ba21ede1', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:42:34'),
(72, 'MLM41', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a15bb0618ad', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:42:48'),
(73, 'MLM41', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a15bda4859c', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:43:30'),
(74, 'MLM41', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a15c0d42589', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:44:21'),
(75, 'MLM41', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a15c31df789', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:44:57'),
(76, 'MLM41', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a15c5b76897', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:45:39'),
(77, 'MLM41', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a15c79e8bd0', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:46:09'),
(78, 'MLM1', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64a15cff94cdb', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:48:23'),
(79, 'MLM2', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-64a15d0774489', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:48:31'),
(80, 'MLM3', '', 3, 'MLM 3', 250, 0, 0, '', '', '', '', 0, 'TXN-64a15d0f5ff8f', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:48:39'),
(81, 'MLM40', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a15d8c91796', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:50:44'),
(82, 'MLM43', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a15d9a090c9', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:50:58'),
(83, 'MLM43', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a15eb8867ba', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 05:55:44'),
(84, 'MLM40', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a15ff431bee', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 06:01:00'),
(85, 'MLM40', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a166df1fee4', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 06:30:31'),
(86, 'MLM40', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a167209c72b', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 06:31:36'),
(87, 'MLM40', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a1675240c2a', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 06:32:26'),
(88, 'MLM40', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a16777c477d', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 06:33:03'),
(89, 'MLM1', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64a186564429a', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 08:44:46'),
(90, 'MLM45', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-64a1866b07c65', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 08:45:07'),
(91, 'MLM46', '', 3, 'MLM 3', 250, 0, 0, '', '', '', '', 0, 'TXN-64a18679af826', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 08:45:21'),
(92, 'MLM47', '', 4, 'MLM 4', 500, 0, 0, '', '', '', '', 0, 'TXN-64a187174410b', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 08:47:59'),
(93, 'MLM48', '', 5, 'MLM 5', 1000, 0, 0, '', '', '', '', 0, 'TXN-64a18726e07b3', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 08:48:14'),
(94, 'MLM45', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-64a187710ca18', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 08:49:29'),
(95, 'MLM45', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-64a1879e30b71', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 08:50:14'),
(96, 'MLM45', '', 2, 'MLM 2', 100, 0, 0, '', '', '', '', 0, 'TXN-64a187ba78870', 'Approved', 'Active', 0, 0, '', '', '2023-07-02 08:50:42'),
(97, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b246455615d', 'Approved', 'Active', 0, 0, '', '', '2023-07-15 03:39:57'),
(98, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b24f3926bcf', 'Approved', 'Active', 0, 0, '', '', '2023-07-15 04:18:09'),
(99, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b251a139251', 'Approved', 'Active', 0, 0, '', '', '2023-07-15 04:28:25'),
(100, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b251a424a98', 'Approved', 'Active', 0, 0, '', '', '2023-07-15 04:28:28'),
(101, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b2521323661', 'Approved', 'Active', 0, 0, '', '', '2023-07-15 04:30:19'),
(102, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b25c36e03d5', 'Approved', 'Active', 0, 0, '', '', '2023-07-15 05:13:34'),
(103, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b2805166154', 'Approved', 'Active', 0, 0, '', '', '2023-07-15 07:47:37'),
(104, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b28053f2d6a', 'Approved', 'Active', 0, 0, '', '', '2023-07-15 07:47:39'),
(105, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b2811f977be', 'Approved', 'Active', 0, 0, '', '', '2023-07-15 07:51:03'),
(106, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b4f3b8d5a9f', 'Approved', 'Active', 0, 0, '', '', '2023-07-17 04:24:32'),
(107, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b4f3f8e76f1', 'Approved', 'Active', 0, 0, '', '', '2023-07-17 04:25:36'),
(108, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b519ad41252', 'Approved', 'Active', 0, 0, '', '', '2023-07-17 07:06:29'),
(109, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b541a88bcf3', 'Approved', 'Active', 0, 0, '', '', '2023-07-17 09:57:04'),
(110, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b541b8dfa34', 'Approved', 'Active', 0, 0, '', '', '2023-07-17 09:57:20'),
(111, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b77cb19386c', 'Approved', 'Active', 0, 0, '', '', '2023-07-19 02:33:29'),
(112, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b77d085a5e7', 'Approved', 'Active', 0, 0, '', '', '2023-07-19 02:34:56'),
(113, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b77e639c352', 'Approved', 'Active', 0, 0, '', '', '2023-07-19 02:40:43'),
(114, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b77e8c7d1fb', 'Approved', 'Active', 0, 0, '', '', '2023-07-19 02:41:24'),
(115, 'MLM49', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64b7d37c14405', 'Approved', 'Active', 0, 0, '', '', '2023-07-19 08:43:48'),
(116, 'MLM68', '', 1, 'MLM 1', 50, 0, 0, '', '', '', '', 0, 'TXN-64bf9e56bceb8', 'Approved', 'Active', 0, 0, '', '', '2023-07-25 06:35:10');

-- --------------------------------------------------------

--
-- Table structure for table `package_old`
--

CREATE TABLE `package_old` (
  `id` int(11) NOT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `pkg_price` varchar(250) NOT NULL,
  `distribution` float NOT NULL,
  `no_of_days` int(11) DEFAULT NULL,
  `percentage_per_day` float NOT NULL DEFAULT 0,
  `min_amount` float NOT NULL DEFAULT 0,
  `max_amount` float NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `capital` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `package_old`
--

INSERT INTO `package_old` (`id`, `package_name`, `pkg_price`, `distribution`, `no_of_days`, `percentage_per_day`, `min_amount`, `max_amount`, `image`, `capital`, `status`, `date`) VALUES
(1, 'MLM 1', '50', 5, 30, 10, 20, 199, 'images/packageImages/765c36199e3725b9b40091849777f381-padlock.png', 'no', 'active', '2022-03-07 21:29:49'),
(2, 'MLM 2', '100', 12, 90, 5, 200, 499, 'images/packageImages/765c36199e3725b9b40091849777f381-padlock.png', 'no', 'active', '2022-03-08 02:22:02'),
(3, 'MLM 3', '250', 35, 180, 15, 500, 1000, 'images/packageImages/cc1487436993605a04db920612a121e5-starter.png', 'yes', 'active', '2022-03-08 13:04:11'),
(4, 'MLM 4', '500', 80, NULL, 0, 0, 0, NULL, NULL, 'active', '2022-05-17 14:35:19'),
(5, 'MLM 5', '1000', 180, NULL, 0, 0, 0, NULL, NULL, 'active', '2022-05-17 14:35:19');

-- --------------------------------------------------------

--
-- Table structure for table `package_percentage`
--

CREATE TABLE `package_percentage` (
  `id` int(11) NOT NULL,
  `starter` float NOT NULL,
  `elite` float NOT NULL,
  `premium` float NOT NULL,
  `supreme` float NOT NULL,
  `executive` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `package_percentage`
--

INSERT INTO `package_percentage` (`id`, `starter`, `elite`, `premium`, `supreme`, `executive`) VALUES
(1, 60, 61, 62, 63, 64);

-- --------------------------------------------------------

--
-- Table structure for table `payment_requests`
--

CREATE TABLE `payment_requests` (
  `id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `pkg_id` int(250) NOT NULL,
  `pkg_price` int(250) NOT NULL DEFAULT 0,
  `mode` varchar(250) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `transaction_id` varchar(250) NOT NULL,
  `transaction_address` varchar(250) NOT NULL,
  `transaction_confirms_needed` varchar(250) NOT NULL,
  `qrcode_url` text NOT NULL,
  `status_url` text NOT NULL,
  `checkout_url` text NOT NULL,
  `status` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_pacakge_amount`
--

CREATE TABLE `pending_pacakge_amount` (
  `id` int(11) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `orderid` int(11) NOT NULL,
  `expires_at` datetime NOT NULL,
  `is_expired` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_pacakge_amount`
--

INSERT INTO `pending_pacakge_amount` (`id`, `userid`, `amount`, `orderid`, `expires_at`, `is_expired`) VALUES
(1, 'MLM2', 500, 4, '2023-07-02 07:44:57', 0),
(2, 'MLM3', 500, 5, '2023-07-02 07:46:02', 0),
(3, 'MLM2', 550, 6, '2023-07-02 07:47:20', 0),
(4, 'MLM3', 625, 7, '2023-07-02 07:48:56', 0),
(5, 'MLM2', 570, 7, '2023-07-02 07:48:56', 0),
(6, 'MLM4', 50, 8, '2023-07-02 07:50:57', 0),
(7, 'MLM3', 633, 8, '2023-07-02 07:50:57', 0),
(8, 'MLM2', 620, 9, '2023-07-02 07:52:09', 0),
(9, 'MLM6', 50, 10, '2023-07-02 07:54:10', 0),
(10, 'MLM3', 641, 10, '2023-07-02 07:54:10', 0),
(11, 'MLM2', 626, 10, '2023-07-02 07:54:10', 0),
(12, 'MLM7', 200, 11, '2023-07-02 07:55:27', 0),
(13, 'MLM2', 126, 12, '2023-07-02 07:56:39', 0),
(14, 'MLM9', 50, 14, '2023-07-02 08:39:47', 0),
(15, 'MLM2', 4, 14, '2023-07-02 08:39:47', 0),
(16, 'MLM10', 125, 15, '2023-07-02 08:40:58', 0),
(17, 'MLM2', 54, 16, '2023-07-02 08:42:13', 0),
(18, 'MLM12', 50, 17, '2023-07-02 08:43:24', 0),
(19, 'MLM2', 57, 17, '2023-07-02 08:43:24', 0),
(20, 'MLM13', 500, 18, '2023-07-02 08:44:39', 0),
(21, 'MLM2', 107, 19, '2023-07-02 08:45:51', 0),
(22, 'MLM15', 50, 20, '2023-07-02 08:46:47', 0),
(23, 'MLM2', 108, 20, '2023-07-02 08:46:47', 0),
(24, 'MLM13', 550, 21, '2023-07-02 08:48:03', 0),
(25, 'MLM2', 109, 21, '2023-07-02 08:48:03', 0),
(26, 'MLM16', 50, 22, '2023-07-02 08:50:53', 0),
(27, 'MLM2', 159, 23, '2023-07-02 08:53:22', 0),
(28, 'MLM18', 200, 24, '2023-07-02 08:55:16', 0),
(29, 'MLM2', 169, 24, '2023-07-02 08:55:16', 0),
(30, 'MLM19', 50, 25, '2023-07-02 08:56:30', 0),
(31, 'MLM2', 219, 26, '2023-07-02 08:57:38', 0),
(32, 'MLM21', 500, 27, '2023-07-02 08:58:27', 0),
(33, 'MLM2', 229, 27, '2023-07-02 08:58:27', 0),
(34, 'MLM22', 50, 28, '2023-07-02 08:59:19', 0),
(35, 'MLM2', 279, 29, '2023-07-02 09:00:03', 0),
(36, 'MLM24', 250, 30, '2023-07-02 09:01:06', 0),
(37, 'MLM2', 281.5, 30, '2023-07-02 09:01:06', 0),
(38, 'MLM25', 50, 31, '2023-07-02 09:02:23', 0),
(39, 'MLM2', 331.5, 32, '2023-07-02 09:03:44', 0),
(40, 'MLM27', 50, 33, '2023-07-02 09:05:43', 0),
(41, 'MLM2', 332, 33, '2023-07-02 09:05:43', 0),
(42, 'MLM3', 691, 35, '2023-07-02 09:08:32', 0),
(43, 'MLM2', 340, 35, '2023-07-02 09:08:32', 0),
(44, 'MLM4', 175, 36, '2023-07-02 09:10:20', 0),
(45, 'MLM3', 711, 36, '2023-07-02 09:10:20', 0),
(46, 'MLM2', 355, 36, '2023-07-02 09:10:20', 0),
(47, 'MLM7', 50, 37, '2023-07-02 09:13:03', 0),
(48, 'MLM4', 8, 37, '2023-07-02 09:13:03', 0),
(49, 'MLM3', 6, 37, '2023-07-02 09:13:03', 0),
(50, 'MLM2', 4, 37, '2023-07-02 09:13:03', 0),
(51, 'MLM10', 175, 38, '2023-07-02 09:14:33', 0),
(52, 'MLM7', 308, 38, '2023-07-02 09:14:33', 0),
(53, 'MLM4', 181, 38, '2023-07-02 09:14:33', 0),
(54, 'MLM2', 358, 38, '2023-07-02 09:14:33', 0),
(55, 'MLM3', 761, 39, '2023-07-02 09:15:27', 0),
(56, 'MLM2', 366, 39, '2023-07-02 09:15:27', 0),
(57, 'MLM13', 600, 40, '2023-07-02 09:17:06', 0),
(58, 'MLM10', 183, 40, '2023-07-02 09:17:06', 0),
(59, 'MLM2', 367, 40, '2023-07-02 09:17:06', 0),
(60, 'MLM10', 233, 41, '2023-07-02 09:21:18', 0),
(61, 'MLM7', 316, 41, '2023-07-02 09:21:18', 0),
(62, 'MLM4', 187, 41, '2023-07-02 09:21:18', 0),
(63, 'MLM3', 765, 41, '2023-07-02 09:21:18', 0),
(64, 'MLM2', 370, 41, '2023-07-02 09:21:18', 0),
(65, 'MLM10', 283, 43, '2023-07-08 13:24:32', 0),
(66, 'MLM7', 324, 43, '2023-07-08 13:24:32', 0),
(67, 'MLM4', 193, 43, '2023-07-08 13:24:32', 0),
(68, 'MLM3', 769, 43, '2023-07-08 13:24:32', 0),
(69, 'MLM2', 1373, 43, '2023-07-08 13:24:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `percentages`
--

CREATE TABLE `percentages` (
  `id` int(11) NOT NULL,
  `type` varchar(250) NOT NULL,
  `percentage` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `percentages`
--

INSERT INTO `percentages` (`id`, `type`, `percentage`, `date`) VALUES
(1, 'deposit', '2', '2022-01-07 08:20:38'),
(2, 'withdrawal', '1', '2022-01-07 08:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `percentages_summary`
--

CREATE TABLE `percentages_summary` (
  `id` int(11) NOT NULL,
  `type` varchar(250) NOT NULL,
  `percentage` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `percentages_summary`
--

INSERT INTO `percentages_summary` (`id`, `type`, `percentage`, `date`) VALUES
(1, 'withdrawal', '10', '2023-06-10 06:10:33'),
(4, 'withdrawal', '10', '2023-06-25 06:35:15');

-- --------------------------------------------------------

--
-- Table structure for table `pool_share_credit_history`
--

CREATE TABLE `pool_share_credit_history` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `amount_credited` float NOT NULL,
  `amount_before_credit` float NOT NULL,
  `amount_after_credit` float NOT NULL,
  `creditdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_registration`
--

CREATE TABLE `pre_registration` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `referral_link` varchar(255) NOT NULL,
  `is_referred` int(11) NOT NULL,
  `user_referral_id` varchar(50) NOT NULL,
  `referrer_user_id` varchar(50) DEFAULT NULL,
  `reffered_user_count` int(11) NOT NULL,
  `gtron` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_24hour_later_email_sent` int(30) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pre_registration`
--

INSERT INTO `pre_registration` (`id`, `user_name`, `email`, `country`, `contact_no`, `message`, `referral_link`, `is_referred`, `user_referral_id`, `referrer_user_id`, `reffered_user_count`, `gtron`, `registration_date`, `is_24hour_later_email_sent`) VALUES
(69, 'Kshitij rana', '2015kshitij14@gmail.com', 'India', '9760492063', 'hell', 'https://gtron.io?ref=t5FCpH', 1, 't5FCpH', '', 0, 500, '2023-08-06 18:30:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `main_category` varchar(250) NOT NULL,
  `sub_category` varchar(250) NOT NULL,
  `product_title` varchar(250) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `main_category`, `sub_category`, `product_title`, `product_image`, `date`) VALUES
(2, '2', '1', 'testing title', 'images/product/0aac696c81b55721334c6027f09ff4bb-graph2.PNG', '2022-03-18 00:02:17'),
(6, '3', '2', 'iphone', 'images/product/2f8cbdbdf9d18951c47bd1b399db68de-Crypto Heaven 1.pdf', '2022-03-19 07:31:17'),
(5, '1', '1', 'ads', 'images/product/3c523e47214d9729fc1a277ce3e98658-screencapture-demo-tortoizthemes-paito-main-trading-html-2022-03-09-11_27_10.pdf', '2022-03-19 06:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `project_management`
--

CREATE TABLE `project_management` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `fav_icon` varchar(255) DEFAULT NULL,
  `otp_status` int(11) NOT NULL DEFAULT 1,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `project_management`
--

INSERT INTO `project_management` (`id`, `logo`, `fav_icon`, `otp_status`, `date`) VALUES
(1, 'images/icons/digital-wallet.png', 'images/icons/digital-wallet.png', 1, '2022-03-03 13:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `reward`
--

CREATE TABLE `reward` (
  `id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `prize` varchar(255) NOT NULL,
  `rank` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roi`
--

CREATE TABLE `roi` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `percentage` float NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Delivered',
  `type` varchar(255) NOT NULL DEFAULT 'Normal',
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roi_percentage`
--

CREATE TABLE `roi_percentage` (
  `id` int(11) NOT NULL,
  `roi_percentage` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `roi_percentage`
--

INSERT INTO `roi_percentage` (`id`, `roi_percentage`, `date`) VALUES
(1, 1, '2020-08-21 06:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `roi_percentage_summary`
--

CREATE TABLE `roi_percentage_summary` (
  `id` int(11) NOT NULL,
  `percent_age` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `main_category_id` varchar(250) NOT NULL,
  `sub_category` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `main_category_id`, `sub_category`, `date`) VALUES
(1, '2', 'sub testing', '2022-03-15 19:50:39'),
(2, '3', 'Phone', '2022-03-19 07:20:14'),
(3, '3', 'Camera', '2022-03-19 07:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE `support` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `reply` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Under Review',
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) NOT NULL,
  `type` varchar(250) NOT NULL,
  `percentage` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `type`, `percentage`) VALUES
(1, 'deposit', 5),
(2, 'withdrawal', 10);

-- --------------------------------------------------------

--
-- Table structure for table `trade_history`
--

CREATE TABLE `trade_history` (
  `id` int(11) NOT NULL,
  `buy_order` varchar(250) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `deal` varchar(250) NOT NULL,
  `profit` varchar(250) NOT NULL,
  `profit_amount` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trade_item`
--

CREATE TABLE `trade_item` (
  `id` int(11) NOT NULL,
  `item` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_pool_amount`
--

CREATE TABLE `user_pool_amount` (
  `id` int(11) NOT NULL,
  `total_pool_amount` float NOT NULL DEFAULT 0,
  `total_sale_amount` float NOT NULL DEFAULT 0,
  `old_share` float NOT NULL,
  `todays_share` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_pool_amount`
--

INSERT INTO `user_pool_amount` (`id`, `total_pool_amount`, `total_sale_amount`, `old_share`, `todays_share`) VALUES
(1, 20, 100, 18, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_pool_amount_history`
--

CREATE TABLE `user_pool_amount_history` (
  `id` int(11) NOT NULL,
  `total_pool_amount` float NOT NULL,
  `total_sale_amount` float NOT NULL,
  `pool_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_pool_amount_history`
--

INSERT INTO `user_pool_amount_history` (`id`, `total_pool_amount`, `total_sale_amount`, `pool_date`) VALUES
(1, 20, 200, '2023-07-12 06:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE `user_registration` (
  `id` int(250) NOT NULL,
  `wallet_address` varchar(1000) NOT NULL DEFAULT '0',
  `transaction_password` varchar(400) DEFAULT NULL,
  `pkg_id` int(11) NOT NULL DEFAULT 0,
  `sponsor_name` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `address` varchar(400) DEFAULT NULL,
  `current_balance` float NOT NULL DEFAULT 0,
  `iwallet` float NOT NULL DEFAULT 0,
  `pending_amount` float NOT NULL DEFAULT 0,
  `total_income` float NOT NULL DEFAULT 0,
  `max_income` float NOT NULL DEFAULT 0,
  `active_investment` float NOT NULL DEFAULT 0,
  `threex_amount_limit` float NOT NULL DEFAULT 0,
  `threex_amount` float NOT NULL DEFAULT 0,
  `eligible_shares` int(11) NOT NULL DEFAULT 0,
  `first_bonus` int(11) NOT NULL DEFAULT 0,
  `second_bonus` int(11) NOT NULL DEFAULT 0,
  `password` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `verified` int(250) NOT NULL DEFAULT 0,
  `sflag` int(2) NOT NULL DEFAULT 1,
  `usdttrc_address` varchar(250) NOT NULL,
  `email_code` varchar(100) DEFAULT NULL,
  `otp_code` int(11) DEFAULT NULL,
  `mobile` varchar(250) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'user-profile.png',
  `total_invest` float NOT NULL DEFAULT 0,
  `direct_team` int(11) NOT NULL DEFAULT 0,
  `total_team` int(11) NOT NULL DEFAULT 0,
  `d_sale` float NOT NULL DEFAULT 0,
  `l1` float NOT NULL DEFAULT 0,
  `l2` float NOT NULL DEFAULT 0,
  `l3` float NOT NULL DEFAULT 0,
  `l4` float NOT NULL DEFAULT 0,
  `l5` float NOT NULL DEFAULT 0,
  `l6` float NOT NULL DEFAULT 0,
  `l7` float NOT NULL DEFAULT 0,
  `l8` float NOT NULL DEFAULT 0,
  `l9` float NOT NULL DEFAULT 0,
  `l10` float NOT NULL DEFAULT 0,
  `s1` int(250) NOT NULL DEFAULT 0,
  `s2` int(250) NOT NULL DEFAULT 0,
  `s3` int(250) NOT NULL DEFAULT 0,
  `s4` int(250) NOT NULL DEFAULT 0,
  `s5` int(250) NOT NULL DEFAULT 0,
  `s6` int(11) NOT NULL DEFAULT 0,
  `s7` int(11) NOT NULL DEFAULT 0,
  `s8` int(250) NOT NULL DEFAULT 0,
  `s9` int(11) NOT NULL DEFAULT 0,
  `s10` int(11) NOT NULL DEFAULT 0,
  `db` float NOT NULL,
  `idb` float NOT NULL DEFAULT 0,
  `idb_weekly` float NOT NULL DEFAULT 0,
  `idb_monthly` float NOT NULL DEFAULT 0,
  `roi` float NOT NULL DEFAULT 0,
  `roi_daily` float NOT NULL,
  `roi_today` float NOT NULL,
  `roi_monthly` float NOT NULL,
  `temp_roi` float NOT NULL DEFAULT 0,
  `monthly_share` float NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `activation_fee` varchar(250) NOT NULL DEFAULT 'Unpaid',
  `login_status` varchar(100) NOT NULL DEFAULT 'Unblock',
  `withdrawal_status` varchar(255) NOT NULL DEFAULT 'on',
  `kyc` varchar(100) NOT NULL DEFAULT 'Unverified',
  `rank` int(100) NOT NULL DEFAULT 0,
  `team_sales` int(11) NOT NULL DEFAULT 0,
  `current_order_id` int(11) NOT NULL DEFAULT 0,
  `current_login` int(11) NOT NULL,
  `order_date` date DEFAULT NULL,
  `order_expires_at` date DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `package_purchase_count` int(11) NOT NULL DEFAULT 0,
  `last_updated_bonus` date DEFAULT NULL,
  `gtron_wallet` float NOT NULL DEFAULT 0,
  `current_bonus_status` enum('twoex','threeex','fourex') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_registration`
--

INSERT INTO `user_registration` (`id`, `wallet_address`, `transaction_password`, `pkg_id`, `sponsor_name`, `user_name`, `address`, `current_balance`, `iwallet`, `pending_amount`, `total_income`, `max_income`, `active_investment`, `threex_amount_limit`, `threex_amount`, `eligible_shares`, `first_bonus`, `second_bonus`, `password`, `full_name`, `email`, `verified`, `sflag`, `usdttrc_address`, `email_code`, `otp_code`, `mobile`, `street`, `city`, `state`, `postal_code`, `phone`, `country`, `profile_pic`, `total_invest`, `direct_team`, `total_team`, `d_sale`, `l1`, `l2`, `l3`, `l4`, `l5`, `l6`, `l7`, `l8`, `l9`, `l10`, `s1`, `s2`, `s3`, `s4`, `s5`, `s6`, `s7`, `s8`, `s9`, `s10`, `db`, `idb`, `idb_weekly`, `idb_monthly`, `roi`, `roi_daily`, `roi_today`, `roi_monthly`, `temp_roi`, `monthly_share`, `status`, `activation_fee`, `login_status`, `withdrawal_status`, `kyc`, `rank`, `team_sales`, `current_order_id`, `current_login`, `order_date`, `order_expires_at`, `date`, `package_purchase_count`, `last_updated_bonus`, `gtron_wallet`, `current_bonus_status`) VALUES
(44, '0xcd596d19635540c3da9c9ab7f22157c1c0e76668', NULL, 1, NULL, 'MLM1', NULL, 200, 0, 0, 0, 0, 50, 150, 100, 1, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Paid', 'Block', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 0, 'twoex'),
(45, '0x8baac7c858bcee5ff59a7607c462f57a17878f01', NULL, 2, 'mlm49', 'MLM45', NULL, 0, 0, 0, 0, 0, 100, 300, 0, 2, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 400, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 4, NULL, 0, 'twoex'),
(46, '0x8851fe7fefa4261da81457ffcf596ec49659e0b8', NULL, 3, 'mlm49', 'MLM46', NULL, 0, 0, 0, 0, 0, 250, 750, 165.501, 5, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 250, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 68.9814, 'twoex'),
(47, '0xde7ebbf403da52361e581903395fa5c7117045cb', NULL, 4, 'mlm49', 'MLM47', NULL, 0, 0, 0, 0, 0, 500, 1500, 231.001, 10, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 500, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 137.963, 'twoex'),
(48, '0xc983865188667507252e667ea6081ce4125fc10b', NULL, 5, 'mlm49', 'MLM48', NULL, 0, 0, 0, 0, 0, 1000, 3000, 462.003, 20, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 1000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 275.926, 'twoex'),
(49, '0xD1e45EB38f7B489099b7E538E3d891c6Cf0F65Ca', NULL, 1, NULL, 'mlm49', NULL, 0, 0, 0, 0, 0, 50, 150, 0, 1, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 950, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Paid', 'Unblock', 'on', 'Verified', 0, 0, 0, 2, '2023-07-19', NULL, '2023-07-27 07:36:20', 19, NULL, 8.7963, 'fourex'),
(50, 'testaddress1', NULL, 0, NULL, 'MLM50', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(51, 'testaddress2', NULL, 0, NULL, 'MLM51', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(52, 'testaddress3', NULL, 0, NULL, 'MLM52', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(53, 'testaddress4', NULL, 0, NULL, 'MLM53', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(54, 'testaddress5', NULL, 0, NULL, 'MLM54', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(55, 'testaddress6', NULL, 0, NULL, 'MLM55', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(56, 'testaddress7', NULL, 0, NULL, 'MLM56', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(57, 'testaddress7', NULL, 0, NULL, 'MLM57', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(58, 'testaddress8', NULL, 0, NULL, 'MLM58', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(59, 'newtestuser', NULL, 0, NULL, 'MLM59', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(60, 'newtestuser1', NULL, 0, NULL, 'MLM60', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(61, 'newtestuser3', NULL, 0, NULL, 'MLM61', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(62, 'newtestuser4', NULL, 0, NULL, 'MLM62', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(63, 'newtestuser5', NULL, 0, NULL, 'MLM63', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(64, 'newtestuser6', NULL, 0, NULL, 'MLM64', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(65, 'newtestuser7', NULL, 0, '', 'MLM65', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(66, 'newtestuser7', NULL, 0, 'MLM59', 'MLM66', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(67, 'newtestuser6', NULL, 0, 'mlm49', 'MLM67', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(68, 'TMshLMuGQjpBW3HvyuCCgYM2tQ7CoQSyQv', NULL, 1, NULL, 'mlm68', NULL, 0, 0, 0, 0, 0, 50, 150, 0, 1, 0, 0, NULL, NULL, NULL, 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Pending', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 1, '2023-07-25', NULL, NULL, 1, NULL, 0, 'twoex'),
(69, 'newtestuser000', NULL, 0, '0', 'MLM69', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(70, 'newtestuser6000', NULL, 0, '0', 'MLM70', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(71, 'kkkk', NULL, 0, '0', 'MLM71', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex'),
(72, 'newtestuser6000', NULL, 0, 'master', 'MLM72', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user-profile.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Approved', 'Unpaid', 'Unblock', 'on', 'Verified', 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 0, 'twoex');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_summary`
--

CREATE TABLE `wallet_summary` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `wallet_type` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gtron_wallet` float NOT NULL DEFAULT 0,
  `credit_type` enum('pool_bonus','level_bonus') NOT NULL,
  `current_bonus_status` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wallet_summary`
--

INSERT INTO `wallet_summary` (`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`, `gtron_wallet`, `credit_type`, `current_bonus_status`) VALUES
(1, 'MLM2', 500, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-07-10 18:30:00', 0, 'level_bonus', ''),
(2, 'MLM3', 500, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(3, 'MLM2', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(4, 'MLM3', 125, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(5, 'MLM2', 20, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(6, 'MLM4', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(7, 'MLM3', 8, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(8, 'MLM2', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(9, 'MLM6', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(10, 'MLM3', 8, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(11, 'MLM2', 6, 'Level 3 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(12, 'MLM7', 500, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(13, 'MLM2', 250, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(14, 'MLM9', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(15, 'MLM2', 4, 'Level 4 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(16, 'MLM10', 125, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(17, 'MLM2', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(18, 'MLM12', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(19, 'MLM2', 3, 'Level 5 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(20, 'MLM13', 500, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(21, 'MLM2', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(22, 'MLM15', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(23, 'MLM2', 1, 'Level 6 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(24, 'MLM13', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(25, 'MLM2', 1, 'Level 6 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(26, 'MLM16', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(27, 'MLM2', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(28, 'MLM18', 500, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(29, 'MLM2', 10, 'Level 7 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(30, 'MLM19', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(31, 'MLM2', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(32, 'MLM21', 500, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(33, 'MLM2', 10, 'Level 8 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(34, 'MLM22', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(35, 'MLM2', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(36, 'MLM24', 250, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(37, 'MLM2', 2.5, 'Level 9 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(38, 'MLM25', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(39, 'MLM2', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(40, 'MLM27', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(41, 'MLM2', 0.5, 'Level 10 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(42, 'MLM3', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(43, 'MLM2', 8, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(44, 'MLM4', 125, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(45, 'MLM3', 20, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(46, 'MLM2', 15, 'Level 3 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(47, 'MLM7', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(48, 'MLM4', 8, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(49, 'MLM3', 6, 'Level 3 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(50, 'MLM2', 4, 'Level 4 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(51, 'MLM10', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(52, 'MLM7', 8, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(53, 'MLM4', 6, 'Level 3 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(54, 'MLM2', 3, 'Level 5 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(55, 'MLM3', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(56, 'MLM2', 8, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(57, 'MLM13', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(58, 'MLM10', 8, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(59, 'MLM2', 1, 'Level 6 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(60, 'MLM10', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(61, 'MLM7', 8, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(62, 'MLM4', 6, 'Level 3 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(63, 'MLM3', 4, 'Level 4 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(64, 'MLM2', 3, 'Level 5 Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(65, 'MLM1', 50, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(66, 'MLM2', 1000, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(67, 'MLM5', 100, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-06-24 18:30:00', 0, 'pool_bonus', ''),
(68, 'MLM10', 50, 'Level 1 Bonus', 'Cash Wallet', 'Credit', '2023-06-30 18:30:00', 0, 'pool_bonus', ''),
(69, 'MLM7', 8, 'Level 2 Bonus', 'Cash Wallet', 'Credit', '2023-06-30 18:30:00', 0, 'pool_bonus', ''),
(70, 'MLM4', 6, 'Level 3 Bonus', 'Cash Wallet', 'Credit', '2023-06-30 18:30:00', 0, 'pool_bonus', ''),
(71, 'MLM3', 4, 'Level 4 Bonus', 'Cash Wallet', 'Credit', '2023-06-30 18:30:00', 0, 'pool_bonus', ''),
(72, 'MLM2', 3, 'Level 5 Bonus', 'Cash Wallet', 'Credit', '2023-06-30 18:30:00', 0, 'pool_bonus', ''),
(73, 'MLM2', 10, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-01 18:30:00', 0, 'pool_bonus', ''),
(74, 'MLM13', 150, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-01 18:30:00', 0, 'pool_bonus', ''),
(75, 'MLM2', 20, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-01 18:30:00', 0, 'pool_bonus', ''),
(76, 'MLM2', 10, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-01 18:30:00', 0, 'pool_bonus', ''),
(77, 'MLM2', 10, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-01 18:30:00', 0, 'pool_bonus', ''),
(78, 'MLM1', 2, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-01 18:30:00', 0, 'pool_bonus', ''),
(79, 'MLM1', -49, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-01 18:30:00', 0, 'pool_bonus', ''),
(80, 'MLM1', -49, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-01 18:30:00', 0, 'pool_bonus', ''),
(81, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(82, 'MLM46', 25, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 25, 'pool_bonus', ''),
(83, 'MLM47', 50, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 50, 'pool_bonus', ''),
(84, 'MLM48', 100, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 100, 'pool_bonus', ''),
(85, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(86, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(87, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(88, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(89, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(90, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(91, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(92, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(93, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(94, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(95, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(96, 'MLM46', 12.5, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 12.5, 'pool_bonus', ''),
(97, 'MLM47', 25, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 25, 'pool_bonus', ''),
(98, 'MLM48', 50, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 50, 'pool_bonus', ''),
(99, 'mlm49', 2.5, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 2.5, 'pool_bonus', ''),
(100, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(101, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(102, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(103, 'MLM46', 5, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 5, 'pool_bonus', ''),
(104, 'MLM47', 10, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 10, 'pool_bonus', ''),
(105, 'MLM48', 20, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 20, 'pool_bonus', ''),
(106, 'mlm49', 1, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 1, 'pool_bonus', ''),
(107, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(108, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(109, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(110, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(111, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(112, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(113, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(114, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(115, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(116, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(117, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(118, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(119, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(120, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(121, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(122, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(123, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(124, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(125, 'MLM46', 4.16667, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 4.16667, 'pool_bonus', ''),
(126, 'MLM47', 8.33333, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 8.33333, 'pool_bonus', ''),
(127, 'MLM48', 16.6667, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 16.6667, 'pool_bonus', ''),
(128, 'mlm49', 0.833333, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0.833333, 'pool_bonus', ''),
(129, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(130, 'MLM46', 6.25, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 6.25, 'pool_bonus', ''),
(131, 'MLM47', 12.5, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 12.5, 'pool_bonus', ''),
(132, 'MLM48', 25, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 25, 'pool_bonus', ''),
(133, 'mlm49', 1.25, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 1.25, 'pool_bonus', ''),
(134, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(135, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(136, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0, 'pool_bonus', ''),
(137, 'MLM46', 2.77778, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 2.77778, 'pool_bonus', ''),
(138, 'MLM47', 5.55556, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 5.55556, 'pool_bonus', ''),
(139, 'MLM48', 11.1111, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 11.1111, 'pool_bonus', ''),
(140, 'mlm49', 0.555556, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-14 18:30:00', 0.555556, 'pool_bonus', ''),
(141, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 0, 'pool_bonus', ''),
(142, 'MLM46', 2.5, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 2.5, 'pool_bonus', ''),
(143, 'MLM47', 5, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 5, 'pool_bonus', ''),
(144, 'MLM48', 10, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 10, 'pool_bonus', ''),
(145, 'mlm49', 0.5, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 0.5, 'pool_bonus', ''),
(146, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 0, 'pool_bonus', ''),
(147, 'MLM46', 2.27273, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 2.27273, 'pool_bonus', ''),
(148, 'MLM47', 4.54545, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 4.54545, 'pool_bonus', ''),
(149, 'MLM48', 9.09091, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 9.09091, 'pool_bonus', ''),
(150, 'mlm49', 0.454545, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 0.454545, 'pool_bonus', ''),
(151, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 0, 'pool_bonus', ''),
(152, 'MLM46', 2.08333, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 2.08333, 'pool_bonus', ''),
(153, 'MLM47', 4.16667, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 4.16667, 'pool_bonus', ''),
(154, 'MLM48', 8.33333, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 8.33333, 'pool_bonus', ''),
(155, 'mlm49', 0.416667, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 0.416667, 'pool_bonus', ''),
(156, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 0, 'pool_bonus', ''),
(157, 'MLM46', 3.57143, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 3.57143, 'pool_bonus', ''),
(158, 'MLM47', 7.14286, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 7.14286, 'pool_bonus', ''),
(159, 'MLM48', 14.2857, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 14.2857, 'pool_bonus', ''),
(160, 'mlm49', 0.714286, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-16 18:30:00', 0.714286, 'pool_bonus', ''),
(161, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 0, 'pool_bonus', ''),
(162, 'MLM46', 1.66667, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 1.66667, 'pool_bonus', ''),
(163, 'MLM47', 3.33333, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 3.33333, 'pool_bonus', ''),
(164, 'MLM48', 6.66667, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 6.66667, 'pool_bonus', ''),
(165, 'mlm49', 0.333333, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 0.333333, 'pool_bonus', ''),
(166, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 0, 'pool_bonus', ''),
(167, 'MLM46', 1.5625, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 1.5625, 'pool_bonus', ''),
(168, 'MLM47', 3.125, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 3.125, 'pool_bonus', ''),
(169, 'MLM48', 6.25, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 6.25, 'pool_bonus', ''),
(170, 'mlm49', 0.3125, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 0.3125, 'pool_bonus', ''),
(171, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 0, 'pool_bonus', ''),
(172, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 0, 'pool_bonus', ''),
(173, 'MLM46', 1.47059, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 1.47059, 'pool_bonus', ''),
(174, 'MLM47', 2.94118, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 2.94118, 'pool_bonus', ''),
(175, 'MLM48', 5.88235, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 5.88235, 'pool_bonus', ''),
(176, 'mlm49', 0.294118, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 0.294118, 'pool_bonus', ''),
(177, 'MLM1', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 0, 'pool_bonus', ''),
(178, 'MLM46', 1.38889, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 1.38889, 'pool_bonus', ''),
(179, 'MLM47', 2.77778, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 2.77778, 'pool_bonus', ''),
(180, 'MLM48', 5.55556, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 5.55556, 'pool_bonus', ''),
(181, 'mlm49', 0.277778, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 0.277778, 'pool_bonus', ''),
(182, 'mlm49', 0, 'Pool Bonus', 'Cash Wallet', 'Credit', '2023-07-18 18:30:00', 0, 'pool_bonus', ''),
(183, 'MLM1', 200, 'Credit By Admin', 'Cash Wallet', 'Credit', '2023-08-10 09:26:16', 0, 'pool_bonus', '');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transfer`
--

CREATE TABLE `wallet_transfer` (
  `id` int(11) NOT NULL,
  `transfer_from` varchar(255) NOT NULL,
  `transfer_to` varchar(255) NOT NULL,
  `transfer_amount` float NOT NULL,
  `transfer_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `transfer_fee_in_percentage` float NOT NULL,
  `transfer_fee_amount` float NOT NULL,
  `amount_transferred` float NOT NULL,
  `amount_after_transfer_fee_deduct` float NOT NULL,
  `sender_wallet_amount_before` float NOT NULL,
  `sender_wallet_amount_after` float NOT NULL,
  `receiver_wallet_amount_before` float NOT NULL,
  `receiver_wallet_amount_after` float NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet_transfer`
--

INSERT INTO `wallet_transfer` (`id`, `transfer_from`, `transfer_to`, `transfer_amount`, `transfer_date`, `transfer_fee_in_percentage`, `transfer_fee_amount`, `amount_transferred`, `amount_after_transfer_fee_deduct`, `sender_wallet_amount_before`, `sender_wallet_amount_after`, `receiver_wallet_amount_before`, `receiver_wallet_amount_after`, `transaction_date`) VALUES
(1, 'admin', 'test', 200, '2023-07-31 11:09:23', 5, 20, 100, 0, 0, 0, 0, 0, '2023-07-31 11:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal`
--

CREATE TABLE `withdrawal` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `desire_amount` float NOT NULL,
  `amount_after_tax` float NOT NULL,
  `tax` float NOT NULL,
  `mode` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `account_title` varchar(250) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `btc_address` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Pending',
  `reject_reason` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `transaction_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `withdrawal`
--

INSERT INTO `withdrawal` (`id`, `user_name`, `email`, `desire_amount`, `amount_after_tax`, `tax`, `mode`, `bank`, `account_title`, `account_no`, `btc_address`, `status`, `reject_reason`, `date`, `transaction_hash`) VALUES
(1, '', '', 0, 0, 0, '', '', NULL, NULL, '', 'Pending', '', '2023-07-24 15:32:10', '');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_limit`
--

CREATE TABLE `withdrawal_limit` (
  `id` int(11) NOT NULL,
  `amount` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_limit_summary`
--

CREATE TABLE `withdrawal_limit_summary` (
  `id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_report`
--
ALTER TABLE `activity_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_gtron_wallet`
--
ALTER TABLE `admin_gtron_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_log`
--
ALTER TABLE `admin_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_wallet`
--
ALTER TABLE `admin_wallet`
  ADD PRIMARY KEY (`wallet_id`);

--
-- Indexes for table `admin_wallet_summary`
--
ALTER TABLE `admin_wallet_summary`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `admin_wallet_summary_logs`
--
ALTER TABLE `admin_wallet_summary_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonuses_details`
--
ALTER TABLE `bonuses_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission_percentage`
--
ALTER TABLE `commission_percentage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_log`
--
ALTER TABLE `cron_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current_rates`
--
ALTER TABLE `current_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donate`
--
ALTER TABLE `donate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gtron_feature_project`
--
ALTER TABLE `gtron_feature_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kyc`
--
ALTER TABLE `kyc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_percentage`
--
ALTER TABLE `level_percentage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_percentage`
--
ALTER TABLE `monthly_percentage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_share`
--
ALTER TABLE `monthly_share`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `old_share`
--
ALTER TABLE `old_share`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_details`
--
ALTER TABLE `package_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trans_id` (`trans_id`);

--
-- Indexes for table `package_old`
--
ALTER TABLE `package_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_percentage`
--
ALTER TABLE `package_percentage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_requests`
--
ALTER TABLE `payment_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_pacakge_amount`
--
ALTER TABLE `pending_pacakge_amount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `percentages`
--
ALTER TABLE `percentages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `percentages_summary`
--
ALTER TABLE `percentages_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pool_share_credit_history`
--
ALTER TABLE `pool_share_credit_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_registration`
--
ALTER TABLE `pre_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_management`
--
ALTER TABLE `project_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward`
--
ALTER TABLE `reward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roi`
--
ALTER TABLE `roi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roi_percentage`
--
ALTER TABLE `roi_percentage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roi_percentage_summary`
--
ALTER TABLE `roi_percentage_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trade_history`
--
ALTER TABLE `trade_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trade_item`
--
ALTER TABLE `trade_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_pool_amount`
--
ALTER TABLE `user_pool_amount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_pool_amount_history`
--
ALTER TABLE `user_pool_amount_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_registration`
--
ALTER TABLE `user_registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `wallet_summary`
--
ALTER TABLE `wallet_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_transfer`
--
ALTER TABLE `wallet_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal`
--
ALTER TABLE `withdrawal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal_limit`
--
ALTER TABLE `withdrawal_limit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal_limit_summary`
--
ALTER TABLE `withdrawal_limit_summary`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_report`
--
ALTER TABLE `activity_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_gtron_wallet`
--
ALTER TABLE `admin_gtron_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_log`
--
ALTER TABLE `admin_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_wallet`
--
ALTER TABLE `admin_wallet`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_wallet_summary`
--
ALTER TABLE `admin_wallet_summary`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_wallet_summary_logs`
--
ALTER TABLE `admin_wallet_summary_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bonuses_details`
--
ALTER TABLE `bonuses_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `commission_percentage`
--
ALTER TABLE `commission_percentage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cron_log`
--
ALTER TABLE `cron_log`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `current_rates`
--
ALTER TABLE `current_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donate`
--
ALTER TABLE `donate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gtron_feature_project`
--
ALTER TABLE `gtron_feature_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kyc`
--
ALTER TABLE `kyc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `level_percentage`
--
ALTER TABLE `level_percentage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `monthly_percentage`
--
ALTER TABLE `monthly_percentage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_share`
--
ALTER TABLE `monthly_share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `old_share`
--
ALTER TABLE `old_share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `package_details`
--
ALTER TABLE `package_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `package_old`
--
ALTER TABLE `package_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `package_percentage`
--
ALTER TABLE `package_percentage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_requests`
--
ALTER TABLE `payment_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_pacakge_amount`
--
ALTER TABLE `pending_pacakge_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `percentages`
--
ALTER TABLE `percentages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `percentages_summary`
--
ALTER TABLE `percentages_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pool_share_credit_history`
--
ALTER TABLE `pool_share_credit_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_registration`
--
ALTER TABLE `pre_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_management`
--
ALTER TABLE `project_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reward`
--
ALTER TABLE `reward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roi`
--
ALTER TABLE `roi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roi_percentage`
--
ALTER TABLE `roi_percentage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roi_percentage_summary`
--
ALTER TABLE `roi_percentage_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `support`
--
ALTER TABLE `support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trade_history`
--
ALTER TABLE `trade_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trade_item`
--
ALTER TABLE `trade_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_pool_amount`
--
ALTER TABLE `user_pool_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_pool_amount_history`
--
ALTER TABLE `user_pool_amount_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_registration`
--
ALTER TABLE `user_registration`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `wallet_summary`
--
ALTER TABLE `wallet_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `wallet_transfer`
--
ALTER TABLE `wallet_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdrawal`
--
ALTER TABLE `withdrawal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdrawal_limit`
--
ALTER TABLE `withdrawal_limit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawal_limit_summary`
--
ALTER TABLE `withdrawal_limit_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
