-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 05, 2022 at 09:43 AM
-- Server version: 5.7.34-log
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cronospay_v3`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_site`
--

CREATE TABLE `about_site` (
  `id` int(1) NOT NULL,
  `about` text,
  `terms` text,
  `privacy_policy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `about_site`
--

INSERT INTO `about_site` (`id`, `about`, `terms`, `privacy_policy`, `created_at`, `updated_at`) VALUES
(1, '<p style=\"text-align: justify;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p style=\"text-align: justify;\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humours.</p>', '<p style=\"text-align: justify;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p style=\"text-align: justify;\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humours.</p>', '<p style=\"text-align: justify;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p style=\"text-align: justify;\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humours.</p>', '2020-02-09 08:42:14', '2020-02-09 07:42:14');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(32) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `profile` int(1) DEFAULT NULL,
  `support` int(1) DEFAULT NULL,
  `promo` int(1) DEFAULT NULL,
  `message` int(1) DEFAULT NULL,
  `deposit` int(1) DEFAULT NULL,
  `settlement` int(1) DEFAULT NULL,
  `transfer` int(1) DEFAULT NULL,
  `request_money` int(1) DEFAULT NULL,
  `donation` int(1) DEFAULT NULL,
  `single_charge` int(1) DEFAULT NULL,
  `subscription` int(1) DEFAULT NULL,
  `merchant` int(1) DEFAULT NULL,
  `invoice` int(1) DEFAULT NULL,
  `charges` int(1) DEFAULT NULL,
  `store` int(1) DEFAULT NULL,
  `blog` int(1) DEFAULT NULL,
  `bill` int(1) DEFAULT NULL,
  `vcard` int(1) DEFAULT NULL,
  `crypto` int(1) DEFAULT NULL,
  `remember_token` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `password`, `username`, `profile`, `support`, `promo`, `message`, `deposit`, `settlement`, `transfer`, `request_money`, `donation`, `single_charge`, `subscription`, `merchant`, `invoice`, `charges`, `store`, `blog`, `bill`, `vcard`, `crypto`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '', '', '$2y$10$lf3reDhUvHnIDiSfK98mk.1MVF9c9guwoEo9zHzVi5NrmA.mUOoe2', 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'o6fZuTtZiJMK5kDjg2uRnQPZBJUXC3XGjo3CxvUIZ38FgWWqXwCJofXu9Yag', '2022-07-06 01:16:16', '0000-00-00 00:00:00'),
(2, 'Vagner', 'Carvalho', '$2y$10$XKuyfr13NWbzJBkPCz944eAHfwNj37VXcUKSE.W11jU6/A5ZtWnPC', 'vagner', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, '2022-07-06 00:57:02', '2022-07-06 03:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `admin_bank`
--

CREATE TABLE `admin_bank` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `bank_name` varchar(128) NOT NULL,
  `address` text NOT NULL,
  `swift` varchar(32) NOT NULL,
  `iban` varchar(32) NOT NULL,
  `acct_no` varchar(15) NOT NULL,
  `status` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_bank`
--

INSERT INTO `admin_bank` (`id`, `name`, `bank_name`, `address`, `swift`, `iban`, `acct_no`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nome do seu banco', 'Nome do seu banco', 'algum lugar no Brasil', '5444', '5678876', '12345678982', 1, '2022-07-06 00:55:20', '2022-07-06 03:55:20');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL,
  `trx` varchar(16) NOT NULL,
  `log` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `trx`, `log`, `created_at`, `updated_at`) VALUES
(1, 11, 'VG7katZFPIv9HnOE', 'Started Transfer request', '2020-09-01 19:24:19', '2020-09-01 19:24:19'),
(2, 11, 'Bt5mrUzYb95Goo1u', 'Started Transfer request', '2020-09-01 19:28:22', '2020-09-01 19:28:22'),
(3, 11, 'W2W0A0ltHEzEmh3F', 'Transfered $10 to user22@test.com', '2020-09-01 19:31:41', '2020-09-01 19:31:41'),
(4, 27, 'xm9Z1EKDZNLOo3VN', 'Created payment link Customization services', '2020-09-02 00:55:32', '2020-09-02 00:55:32'),
(5, 11, 'V7j9Tes0S5mqzGzH', 'Created payment link -  E bank customization', '2020-09-02 17:18:00', '2020-09-02 17:18:00'),
(6, 11, 'IXt7hyCR4gwtD6Ys', 'Payment for VqoMNcuujF02vI5z was successful', '2020-09-10 00:17:02', '2020-09-10 00:17:02'),
(7, 11, 'BoRFrqLxsZvZftMC', 'You just received payment for VqoMNcuujF02vI5z', '2020-09-10 00:17:02', '2020-09-10 00:17:02'),
(8, 11, 'fFsbvhXqsui1OHv7', 'Payment for VqoMNcuujF02vI5z was successful', '2020-09-10 00:18:43', '2020-09-10 00:18:43'),
(9, 11, 'WCW7Ej1ZtxeHtOGn', 'You just received payment for VqoMNcuujF02vI5z', '2020-09-10 00:18:43', '2020-09-10 00:18:43'),
(10, 11, '1dLTQxKSSvCdEv4U', 'Payment for VqoMNcuujF02vI5z was successful', '2020-09-10 00:19:10', '2020-09-10 00:19:10'),
(11, 11, '9SF4z9P2KcoMUVhZ', 'You just received payment for VqoMNcuujF02vI5z', '2020-09-10 00:19:10', '2020-09-10 00:19:10'),
(12, 11, 'uxYcwqE3PiRrRq4t', 'Payment for VqoMNcuujF02vI5z was successful', '2020-09-10 00:23:37', '2020-09-10 00:23:37'),
(13, 11, 'AUAW0SN3WhpAGSqR', 'You just received payment for VqoMNcuujF02vI5z', '2020-09-10 00:23:37', '2020-09-10 00:23:37'),
(14, 11, 'TMSS0IC0FVYPjkSk', 'Payment for VqoMNcuujF02vI5z was successful', '2020-09-10 00:32:35', '2020-09-10 00:32:35'),
(15, 11, 'gIOs0sBxCat93U0D', 'You just received payment for VqoMNcuujF02vI5z', '2020-09-10 00:32:35', '2020-09-10 00:32:35'),
(16, 11, 'b51uDOLLtIOQe5gW', 'Payment for VqoMNcuujF02vI5z was successful', '2020-09-10 01:20:20', '2020-09-10 01:20:20'),
(17, 11, 'NgUZP7b9vxwHTsP2', 'Received payment for Payment LinkVqoMNcuujF02vI5z', '2020-09-10 01:20:20', '2020-09-10 01:20:20'),
(18, 11, 'SLeq1h6fvXzttPY6', 'Payment for VqoMNcuujF02vI5z was successful', '2020-09-10 01:20:44', '2020-09-10 01:20:44'),
(19, 11, 'jeFWOICFUEQ8giFK', 'Received payment for Payment LinkVqoMNcuujF02vI5z', '2020-09-10 01:20:44', '2020-09-10 01:20:44'),
(20, 11, 'qo3zV3Ry1GSwz5vn', 'Payment for VqoMNcuujF02vI5z was successful', '2020-09-10 01:21:00', '2020-09-10 01:21:00'),
(21, 11, 'tTURugFcXNaUroPG', 'Received payment for Payment LinkVqoMNcuujF02vI5z', '2020-09-10 01:21:00', '2020-09-10 01:21:00'),
(22, 11, 'sMP342ZO0qT6N1K0', 'Created Donation Page -  Lumen Water Business', '2020-09-10 08:12:03', '2020-09-10 08:12:03'),
(23, 11, 'LrbTqKwRtJv5FM5Z', 'Donation for 1cf81JY3s3PEIb56 was successful', '2020-09-10 09:50:02', '2020-09-10 09:50:02'),
(24, 11, 'f2yiC7zts92sOamh', 'Received Donation for Payment Link1cf81JY3s3PEIb56', '2020-09-10 09:50:02', '2020-09-10 09:50:02'),
(25, 11, 'j4mdozZSlLo9d06V', 'Donation for 1cf81JY3s3PEIb56 was successful', '2020-09-10 09:53:27', '2020-09-10 09:53:27'),
(26, 11, 'ZsjypbbFVzq9ha2W', 'Received Donation for Payment Link1cf81JY3s3PEIb56', '2020-09-10 09:53:27', '2020-09-10 09:53:27'),
(27, 11, 'qRtoeQMjd9pl4qbs', 'Donation for 1cf81JY3s3PEIb56 was successful', '2020-09-10 10:00:33', '2020-09-10 10:00:33'),
(28, 11, '27rEu3dD9L5U1ul6', 'Received Donation for Payment Link1cf81JY3s3PEIb56', '2020-09-10 10:00:33', '2020-09-10 10:00:33'),
(29, 11, '9GKpom4rAiGZL9ev', 'Donation for 1cf81JY3s3PEIb56 was successful', '2020-09-10 10:14:42', '2020-09-10 10:14:42'),
(30, 11, 'Rwwd35bJoMrYcVUX', 'Received Donation for Payment Link1cf81JY3s3PEIb56', '2020-09-10 10:14:42', '2020-09-10 10:14:42'),
(31, 11, 'bCrWL11wEUX3bEKS', 'Donation for 1cf81JY3s3PEIb56 was successful', '2020-09-10 10:14:52', '2020-09-10 10:14:52'),
(32, 11, 'zpfKLFmJAUtA7JpU', 'Received Donation for Payment Link1cf81JY3s3PEIb56', '2020-09-10 10:14:52', '2020-09-10 10:14:52'),
(33, 11, 'R90f8XUgT8vPst9h', 'Created Donation Page -  Oh Ramona project', '2020-09-10 18:43:39', '2020-09-10 18:43:39'),
(34, 11, 'LNlURj5FodbfT4Tg', 'Created Donation Page -  Oh Ramona project', '2020-09-10 18:44:03', '2020-09-10 18:44:03'),
(35, 11, 'iBAVOhCAU8yQ526g', 'Donation for oUl1fw2faM8LtOhG was successful', '2020-09-10 18:44:38', '2020-09-10 18:44:38'),
(36, 11, 'Zmhp9nXbGTSK0NDP', 'Received Donation for Payment LinkoUl1fw2faM8LtOhG', '2020-09-10 18:44:38', '2020-09-10 18:44:38'),
(37, 11, 'W78Cj6wt3XWW0sHJ', 'Donation for oUl1fw2faM8LtOhG was successful', '2020-09-10 18:45:01', '2020-09-10 18:45:01'),
(38, 11, 'fWbaqDAv9SrHR6xu', 'Received Donation for Payment LinkoUl1fw2faM8LtOhG', '2020-09-10 18:45:01', '2020-09-10 18:45:01'),
(39, 11, '3w5RBu7fWIczjlmD', 'Donation for oUl1fw2faM8LtOhG was successful', '2020-09-10 18:45:21', '2020-09-10 18:45:21'),
(40, 11, 'GWOFpCzJbUmOHkti', 'Received Donation for Payment LinkoUl1fw2faM8LtOhG', '2020-09-10 18:45:21', '2020-09-10 18:45:21'),
(41, 11, 'EyDYKji36tO46zcL', 'Started Transfer request', '2020-09-10 19:38:13', '2020-09-10 19:38:13'),
(42, 11, 'UKZ29u1yAFqfb0lz', 'Transfered $1000 to e@d.com', '2020-09-10 19:38:19', '2020-09-10 19:38:19'),
(43, 11, 'Tpxmk64hEjEiIpBT', 'Created Plan -  Boompay', '2020-09-11 16:43:52', '2020-09-11 16:43:52'),
(44, 11, 'FIedOco4tiM094YV', 'Created Plan -  Apple Music', '2020-09-11 18:23:40', '2020-09-11 18:23:40'),
(45, 11, 'fdIuTNgHt0D6Vq7G', 'Payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-12 08:03:00', '2020-09-12 08:03:00'),
(46, 11, 'dV8WjZBC4NfWImbL', 'Received payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-12 08:03:00', '2020-09-12 08:03:00'),
(47, 11, 'm9S73umaQ6EDHqYR', 'Payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-12 08:04:03', '2020-09-12 08:04:03'),
(48, 11, 'FwYMgvmN5myyUJYU', 'Received payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-12 08:04:03', '2020-09-12 08:04:03'),
(49, 11, 'Tz7WnakzZi1ChdL9', 'Payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-12 08:04:21', '2020-09-12 08:04:21'),
(50, 11, 'eEADELk91F9AXvpq', 'Received payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-12 08:04:21', '2020-09-12 08:04:21'),
(51, 11, 'Yt4cbfR7VAB11Sjv', 'Payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-12 08:06:20', '2020-09-12 08:06:20'),
(52, 11, 'MW3j7F8h5WmLQgbT', 'Received payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-12 08:06:20', '2020-09-12 08:06:20'),
(53, 11, '1N1N724vqcT2qLmz', 'Payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-12 08:06:35', '2020-09-12 08:06:35'),
(54, 11, 'iZnHUntBWSqoFRWa', 'Received payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-12 08:06:35', '2020-09-12 08:06:35'),
(55, 11, 'tXNl6ZXeuxRHT2OJ', 'Payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-12 08:08:12', '2020-09-12 08:08:12'),
(56, 11, '8Ln3x1QvjG3NTgmD', 'Received payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-12 08:08:12', '2020-09-12 08:08:12'),
(57, 11, 'pEPI49amKNSEjbP5', 'Updated account details', '2020-09-12 08:29:42', '2020-09-12 08:29:42'),
(58, 11, 'Aoy7s5Bc9m7lv92k', 'Updated account details', '2020-09-12 08:29:52', '2020-09-12 08:29:52'),
(59, 11, 'oKRgz1zWcMU7CtFC', 'Updated account details', '2020-09-12 08:29:52', '2020-09-12 08:29:52'),
(60, 11, '3mFc4zrjlUAXEmwQ', 'Updated account details', '2020-09-12 08:32:51', '2020-09-12 08:32:51'),
(61, 11, 'vq0S9VYHxm3Xtv77', 'Updated account details', '2020-09-12 08:33:04', '2020-09-12 08:33:04'),
(62, 11, 'tRW9sMJPBir7jDIL', 'Updated account details', '2020-09-12 08:33:10', '2020-09-12 08:33:10'),
(63, 11, 'SRtoWzhTdl203Qhh', 'Updated account details', '2020-09-12 08:33:13', '2020-09-12 08:33:13'),
(64, 11, 'O8bACpC2XM2AHNJ5', 'Updated account details', '2020-09-12 08:33:19', '2020-09-12 08:33:19'),
(65, 40, '92CNpTPzHOnsYF6z', 'Logged out - ::1', '2020-09-19 11:50:50', '2020-09-19 11:50:50'),
(66, 11, 'BsDREVVGJq25cDkY', 'Created Funding Request of 100NGN via Flutterwave', '2020-09-19 14:45:00', '2020-09-19 14:45:00'),
(67, 11, 'MzBui8XjBOLkTyWG', 'Created Funding Request of 1000NGN via Paystack', '2020-09-19 15:44:10', '2020-09-19 15:44:10'),
(68, 11, 'UEDXOSEHlylYnEuB', 'Created Funding Request of 1000NGN via Flutterwave', '2020-09-19 15:45:11', '2020-09-19 15:45:11'),
(69, 11, '65cfVrkZH90Ya4Zc', 'Created Funding Request of 1000NGN via Flutterwave', '2020-09-19 16:01:43', '2020-09-19 16:01:43'),
(70, 11, 'KkPpLdapS70SAnns', 'Created Funding Request of 1000NGN via Perfect Money', '2020-09-19 16:01:57', '2020-09-19 16:01:57'),
(71, 11, '9ezEk3FMitHAEkiP', 'Created Funding Request of 1000NGN via Skrill', '2020-09-19 16:03:27', '2020-09-19 16:03:27'),
(72, 11, 'qPwdMBXJmLjdRa0f', 'Created Funding Request of 300NGN via Flutterwave', '2020-09-19 16:34:57', '2020-09-19 16:34:57'),
(73, 11, 'qs3m45r3dvKqxyDg', 'Created Funding Request of 1000NGN via Paystack', '2020-09-20 09:20:15', '2020-09-20 09:20:15'),
(74, 11, 'p456h1G6a6hfN2TW', 'Created Funding Request of 10000NGN via Paystack', '2020-09-20 09:21:34', '2020-09-20 09:21:34'),
(75, 11, 'tDWjjKeGFVx5VROS', 'Created Funding Request of 1000NGN via Paystack', '2020-09-20 09:23:57', '2020-09-20 09:23:57'),
(76, 11, 'bZIqKAXsswgsiCSb', 'Created Funding Request of 1000NGN via Voguepay', '2020-09-20 09:24:37', '2020-09-20 09:24:37'),
(77, 11, 'B6aceETK7fp9V1NW', 'Created Funding Request of 2000NGN via Stripe', '2020-09-20 09:26:10', '2020-09-20 09:26:10'),
(78, 11, '8H1o7CtMc3fVQJ8t', 'Created Funding Request of 4000NGN via Flutterwave', '2020-09-20 09:27:45', '2020-09-20 09:27:45'),
(79, 11, 'EcmBXUkZyZuuDv7Z', 'Created Funding Request of 1000NGN via Paystack', '2020-09-20 09:28:43', '2020-09-20 09:28:43'),
(80, 11, '1mTgbXOljHoTDsO7', 'Created Funding Request of 2000NGN via Stripe', '2020-09-20 09:38:20', '2020-09-20 09:38:20'),
(81, 11, 'kLzhjjvh5PxEGIvX', 'Created Funding Request of 2000NGN via Stripe', '2020-09-20 09:51:29', '2020-09-20 09:51:29'),
(82, 11, 'W2jU1gk0gPCXGUHs', 'Verified Funding Request of 2020NGN via Stripe', '2020-09-20 10:36:21', '2020-09-20 10:36:21'),
(83, 11, 'LOk5ORBzsPCregrL', 'Created Funding Request of 3000NGN via Stripe', '2020-09-20 10:36:41', '2020-09-20 10:36:41'),
(84, 11, 'coglW5k2mLTwU6Uu', 'Verified Funding Request of 3030NGN via Stripe', '2020-09-20 10:42:58', '2020-09-20 10:42:58'),
(85, 11, 'jTHHzWkWJ3b3yE2Z', 'Created Funding Request of 100NGN via Stripe', '2020-09-20 18:58:07', '2020-09-20 18:58:07'),
(86, 11, 'CCSaSPQJvnzMNtsz', 'Created Funding Request of 1000NGN via Paystack', '2020-09-20 19:43:45', '2020-09-20 19:43:45'),
(87, 11, 'nxx44WCIYHvJX6cM', 'Verified Funding Request of 2020NGN via Card', '2020-09-20 22:36:40', '2020-09-20 22:36:40'),
(88, 11, '5hB7dDhSwwjEy9uI', 'Created Funding Request of 4000NGN via Card', '2020-09-20 23:09:58', '2020-09-20 23:09:58'),
(89, 11, '0Jv8BGvkOtjRNkx4', 'Verified Funding Request of 4040NGN via Card', '2020-09-20 23:10:03', '2020-09-20 23:10:03'),
(90, 11, 'EmQQIoJRxJPzpRQZ', 'Created Payment Link -  Giftworld', '2020-09-21 09:29:38', '2020-09-21 09:29:38'),
(91, 11, 'VCqcGnZ0tbD4B9JG', 'Requested ₦20000 from support@boomchart.com.ng', '2020-09-21 10:01:14', '2020-09-21 10:01:14'),
(92, 11, 'mCNSopy0upqwpcVZ', 'Requested ₦20000 from support@boomchart.com.ng', '2020-09-21 10:01:20', '2020-09-21 10:01:20'),
(93, 11, '6Z2lBCERfLTdGqqT', 'Requested ₦20000 from support@boomchart.com.ng', '2020-09-21 10:02:18', '2020-09-21 10:02:18'),
(94, 11, 'uJQb29gYspNcZMPq', 'Requested ₦3000 from support@boomchart.com.ng', '2020-09-21 10:07:02', '2020-09-21 10:07:02'),
(95, 11, 'TzmTI27CgK2CUwOn', 'Started Transfer request', '2020-09-21 10:13:42', '2020-09-21 10:13:42'),
(96, 11, '0FZzGPFtrkV7WnUM', 'Transfered ₦1000 to support@boomchart.com.ng', '2020-09-21 10:15:07', '2020-09-21 10:15:07'),
(97, 11, 'jKsZP75wnh5XoTyg', 'Transfered ₦10000 to support@boomchart.com.ng', '2020-09-21 10:24:07', '2020-09-21 10:24:07'),
(98, 11, '1Kl6SxgERg0vEAJo', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-21 23:35:26', '2020-09-21 23:35:26'),
(99, 11, '2PTZtWgAcXvHuTSf', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-21 23:35:47', '2020-09-21 23:35:47'),
(100, 11, 'vSSDgSB6cLXqq06p', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-21 23:39:16', '2020-09-21 23:39:16'),
(101, 11, '5l56oUIC37jZvTEz', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-21 23:40:57', '2020-09-21 23:40:57'),
(102, 11, 'jKxJFGBCE4iRu4QF', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-21 23:41:35', '2020-09-21 23:41:35'),
(103, 11, 'M3kcP1Irgge2aDPD', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-21 23:42:42', '2020-09-21 23:42:42'),
(104, 11, 'qNmp9Hd9sCR67cia', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-21 23:44:14', '2020-09-21 23:44:14'),
(105, 11, 'mSGNkV0dMD2DfCGZ', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-22 00:04:42', '2020-09-22 00:04:42'),
(106, 11, 'K9dLM4J9xu92f1PK', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-22 00:04:42', '2020-09-22 00:04:42'),
(107, 11, 'YNRqJUcyyWDIPgjp', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-22 00:27:10', '2020-09-22 00:27:10'),
(108, 11, '7qP1J6bqeWYhlj8O', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-22 00:27:10', '2020-09-22 00:27:10'),
(109, 11, 'ogdky15w8Ntewwuh', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-22 00:27:33', '2020-09-22 00:27:33'),
(110, 11, 'womXN3X5HKY5fPeV', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-22 00:27:33', '2020-09-22 00:27:33'),
(111, 32, '24GCuWC2bLEZcBNx', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-22 00:36:50', '2020-09-22 00:36:50'),
(112, 11, 'V1Av1j6Eh4STIcsf', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-22 00:36:50', '2020-09-22 00:36:50'),
(113, 11, 'kOLhFkr0XujKEAyI', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-22 00:37:34', '2020-09-22 00:37:34'),
(114, 11, 'zzGwwzrppOkrIRvg', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-22 00:37:34', '2020-09-22 00:37:34'),
(115, 11, 'YTuea6eRkBVzpCH9', 'Created Donation Page -  Foster Home Care', '2020-09-22 00:54:54', '2020-09-22 00:54:54'),
(116, 11, 'hnl2nP2sQg7H0blM', 'Donation for fpuTgCuh3OaWiJTD was successful', '2020-09-22 01:56:43', '2020-09-22 01:56:43'),
(117, 11, 'ZZPdqZDltHrJVDkz', 'Received Donation for Payment LinkfpuTgCuh3OaWiJTD', '2020-09-22 01:56:43', '2020-09-22 01:56:43'),
(118, 32, 'zC0Jp6FET4sJphWc', 'Donation for fpuTgCuh3OaWiJTD was successful', '2020-09-22 01:57:07', '2020-09-22 01:57:07'),
(119, 11, 'UACRxaZFfx6PiAnd', 'Received Donation for Payment LinkfpuTgCuh3OaWiJTD', '2020-09-22 01:57:07', '2020-09-22 01:57:07'),
(120, 32, 'red7f5mSIiNOswhr', 'Donation for fpuTgCuh3OaWiJTD was successful', '2020-09-22 01:58:25', '2020-09-22 01:58:25'),
(121, 11, 'hUWDg5OAxEDHzXBB', 'Received Donation for Payment LinkfpuTgCuh3OaWiJTD', '2020-09-22 01:58:25', '2020-09-22 01:58:25'),
(122, 11, 'FzL65vva5TMkrKCR', 'Received Donation for Payment LinkfpuTgCuh3OaWiJTD', '2020-09-22 02:15:23', '2020-09-22 02:15:23'),
(123, 11, 'GfTs32CakQR3zhTm', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-22 07:34:03', '2020-09-22 07:34:03'),
(124, 11, 'sgGjyhxNU5kW6k07', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-22 07:34:03', '2020-09-22 07:34:03'),
(125, 11, 'IEhmCs4mWdd3ft2v', 'Donation for fpuTgCuh3OaWiJTD was successful', '2020-09-22 08:00:50', '2020-09-22 08:00:50'),
(126, 11, 'JLXEsrUFjZ7JZUht', 'Received Donation for Payment LinkfpuTgCuh3OaWiJTD', '2020-09-22 08:00:50', '2020-09-22 08:00:50'),
(127, 11, 'LYTJOSRQhQPzkmRT', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-22 21:11:40', '2020-09-22 21:11:40'),
(128, 11, 'FpkzqX6Pq5NjGIbr', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-22 21:13:22', '2020-09-22 21:13:22'),
(129, 11, 'ddPNzknYA7Ft6ivM', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-22 21:18:06', '2020-09-22 21:18:06'),
(130, 11, 'M28sRhYtYfenD2hT', 'Created Donation Page -  Wild Life Conservation', '2020-09-23 04:18:07', '2020-09-23 04:18:07'),
(131, 11, 'EZEphE07kZanfuGE', 'Created Donation Page -  Pollution Degradation', '2020-09-23 04:26:31', '2020-09-23 04:26:31'),
(132, 11, 'bECmOYgcpubVn5WN', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-23 11:48:01', '2020-09-23 11:48:01'),
(133, 11, 'Zl4bjK9fTX3e5fT3', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-23 11:48:01', '2020-09-23 11:48:01'),
(134, 11, '5sm3SlCfe91VdvAU', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-23 11:50:18', '2020-09-23 11:50:18'),
(135, 11, 'evttBwSsEn9khTOc', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-23 11:50:18', '2020-09-23 11:50:18'),
(136, 11, 'OoQmtz9EaQzlRQuz', 'Requested ₦50000 from support@boomchart.com.ng', '2020-09-23 11:57:26', '2020-09-23 11:57:26'),
(137, 11, 'R29SjdJS607f1yEz', 'Created Plan -  Cleaning service', '2020-09-23 12:04:55', '2020-09-23 12:04:55'),
(138, 11, 'nwDQ7zGgXKZk68Lz', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-23 12:05:37', '2020-09-23 12:05:37'),
(139, 11, 'UPiEQGF9BnHID7dD', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-23 12:05:37', '2020-09-23 12:05:37'),
(140, 11, '6TvwK7LK19LnLP8A', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-24 14:55:46', '2020-09-24 14:55:46'),
(141, 11, '8gfp52MOj1gYogKQ', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-24 14:55:46', '2020-09-24 14:55:46'),
(142, 11, 'gWLtE2cPIZrXn50G', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-25 13:58:25', '2020-09-25 13:58:25'),
(143, 11, 'nYmq92V4PvvpcDdZ', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-25 13:58:25', '2020-09-25 13:58:25'),
(144, 32, 'viWfq3SLkLLmjOXI', 'Payment for CWlRsWg8epPeSt97 was successful', '2020-09-25 14:22:56', '2020-09-25 14:22:56'),
(145, 32, 'upWrxHTZFkauBObS', 'Payment for CWlRsWg8epPeSt97 was successful', '2020-09-25 14:23:15', '2020-09-25 14:23:15'),
(146, 32, 'VPhWt3ZdSmSntulJ', 'Payment for CWlRsWg8epPeSt97 was successful', '2020-09-25 14:34:59', '2020-09-25 14:34:59'),
(147, 11, 'pUJmK1FwaanOj8lF', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-25 14:44:15', '2020-09-25 14:44:15'),
(148, 11, 'qLOVvWhQRSy7li9C', 'Payment for CWlRsWg8epPeSt97 was successful', '2020-09-25 14:52:37', '2020-09-25 14:52:37'),
(149, 11, 'eqhtOVehwQcIX9LT', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-25 15:26:50', '2020-09-25 15:26:50'),
(150, 11, 'AOI7o8DFYimIw0OT', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-25 15:44:31', '2020-09-25 15:44:31'),
(151, 32, 'GeVxvGkgI5g7elQq', 'Payment for NiHCrzG209klLTzW was successful', '2020-09-25 15:46:14', '2020-09-25 15:46:14'),
(152, 11, 'eLqPwtUUhdX7JnQk', 'Payment for CWlRsWg8epPeSt97 was successful', '2020-09-25 15:58:13', '2020-09-25 15:58:13'),
(153, 11, 'erYcJ85xors2KfyY', 'Payment for CWlRsWg8epPeSt97 was successful', '2020-09-25 15:59:37', '2020-09-25 15:59:37'),
(154, 11, 'QuVurWxCsZGBfdpn', 'Payment for CWlRsWg8epPeSt97 was successful', '2020-09-25 16:00:54', '2020-09-25 16:00:54'),
(155, 11, 'ONKjoG6CfvGYacAA', 'Payment for CWlRsWg8epPeSt97 was successful', '2020-09-25 16:02:00', '2020-09-25 16:02:00'),
(156, 11, 'CX8OkjlbfqOXpZyj', 'Payment for 4XgznlZBZXXCUqlK was successful', '2020-09-25 23:53:44', '2020-09-25 23:53:44'),
(157, 11, 'RZuP4TksPOliikTr', 'Created Payment Link -  Febreze', '2020-09-26 08:06:26', '2020-09-26 08:06:26'),
(158, 32, 'eL2KIhXjdguQHFLr', 'Payment for mwbUixBFLuaJYlbc was successful', '2020-09-26 08:19:10', '2020-09-26 08:19:10'),
(159, 11, 'Ut5HrFBiUZPFqBvO', 'Received payment for Payment LinkmwbUixBFLuaJYlbc', '2020-09-26 08:19:10', '2020-09-26 08:19:10'),
(160, 32, 'LSnI7JB5XDVF8Y0G', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-26 10:57:16', '2020-09-26 10:57:16'),
(161, 11, 'CcaE3iUyQdytIQPY', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-26 10:57:16', '2020-09-26 10:57:16'),
(162, 32, 'NLv03MJJNxzFNCyF', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-26 12:58:59', '2020-09-26 12:58:59'),
(163, 11, 'x3JXPGiFAG7Ljk4s', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-26 12:58:59', '2020-09-26 12:58:59'),
(164, 32, '06k0ocN3s6Ghhvq1', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-26 13:00:04', '2020-09-26 13:00:04'),
(165, 11, '9JnkGtrCOSDu2OZx', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-26 13:00:04', '2020-09-26 13:00:04'),
(166, 32, 'Cww76vn07cBuyMZX', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-26 13:00:17', '2020-09-26 13:00:17'),
(167, 11, 'i8L9LpT8JABczHK1', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-26 13:00:17', '2020-09-26 13:00:17'),
(168, 32, 'W6ZMjgRxKqKDkwOe', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-26 13:02:25', '2020-09-26 13:02:25'),
(169, 11, 'DCcWED2qGIWLSNm9', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-26 13:02:25', '2020-09-26 13:02:25'),
(170, 32, 'AtHUPOIvuAvRRlfW', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-26 13:03:53', '2020-09-26 13:03:53'),
(171, 11, 'lkVztHTlyfSks7S7', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-26 13:03:53', '2020-09-26 13:03:53'),
(172, 32, '9pldEPoQOuKhHhwW', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-26 13:13:27', '2020-09-26 13:13:27'),
(173, 11, 'upupN5tJb0rvRF4B', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-26 13:13:27', '2020-09-26 13:13:27'),
(174, 32, 'cZHaWjesXmrDo5Gx', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-26 13:14:33', '2020-09-26 13:14:33'),
(175, 11, 'oRU1gHdJXfPNFb28', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-26 13:14:33', '2020-09-26 13:14:33'),
(176, 32, 'G57P3FO9kaINJw6L', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-26 13:20:24', '2020-09-26 13:20:24'),
(177, 11, 'yyMSGjZco7seGaJK', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-26 13:20:24', '2020-09-26 13:20:24'),
(178, 11, 'Krcso6Hj73iPVifX', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-27 07:22:45', '2020-09-27 07:22:45'),
(179, 11, 'l2wmGom12tCMcMMA', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-27 07:22:45', '2020-09-27 07:22:45'),
(180, 32, 'GptMkyWluzEGdaV9', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-27 07:48:01', '2020-09-27 07:48:01'),
(181, 11, 'y9N5IHgCM5B4VkJB', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-27 07:48:01', '2020-09-27 07:48:01'),
(182, 32, '2pBRhZqpteftkUI0', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 07:49:02', '2020-09-27 07:49:02'),
(183, 11, 'hyJRqb6fcistY9Hu', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 07:49:02', '2020-09-27 07:49:02'),
(184, 32, '2ewBGcorh82xKZLI', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 07:49:28', '2020-09-27 07:49:28'),
(185, 11, 'pb9ty8G6X54bfi3H', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 07:49:28', '2020-09-27 07:49:28'),
(186, 32, 'ynXm65PY0KBGvaMI', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 07:50:06', '2020-09-27 07:50:06'),
(187, 11, 'N8NzQdKSzfiMoGDF', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 07:50:06', '2020-09-27 07:50:06'),
(188, 32, 'BZcG9DSdo5A1QsUV', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 07:50:23', '2020-09-27 07:50:23'),
(189, 11, 'j7Zaw4RP1F1aY6fE', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 07:50:23', '2020-09-27 07:50:23'),
(190, 32, 'YG7MBJ3jvJzpZhOC', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 07:52:40', '2020-09-27 07:52:40'),
(191, 11, '5N0BshpQnys6fqXx', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 07:52:40', '2020-09-27 07:52:40'),
(192, 32, 'GysAS5yqpNAFWG1w', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 07:52:59', '2020-09-27 07:52:59'),
(193, 11, 'HKNsQuBq08RCsLec', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 07:52:59', '2020-09-27 07:52:59'),
(194, 32, '2SzKjXW7qTSTSM9S', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 07:53:12', '2020-09-27 07:53:12'),
(195, 11, 'zFHRNOk2fHHkyUju', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 07:53:12', '2020-09-27 07:53:12'),
(196, 32, 'NuT1GvbvEsFdJD2F', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 07:56:46', '2020-09-27 07:56:46'),
(197, 11, 'RJzORn7IlJYH4REs', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 07:56:46', '2020-09-27 07:56:46'),
(198, 32, 'doY7UBJEIVAEQ2MW', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 08:09:59', '2020-09-27 08:09:59'),
(199, 11, '0jEuj99W8Fvby3XU', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 08:09:59', '2020-09-27 08:09:59'),
(200, 32, 'BoXbRldGD8iXxbtj', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 08:11:38', '2020-09-27 08:11:38'),
(201, 11, 'nSw3mqd932YkONK3', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 08:11:38', '2020-09-27 08:11:38'),
(202, 32, 'zibGOwvgs3ZfiLTu', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 08:13:20', '2020-09-27 08:13:20'),
(203, 11, 'ylY3wJ6K0v5hNBLz', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 08:13:20', '2020-09-27 08:13:20'),
(204, 32, 'C1WQXoXmumnHDEj7', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 08:34:13', '2020-09-27 08:34:13'),
(205, 11, 'E7cz0V4MBGwujq0E', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 08:34:13', '2020-09-27 08:34:13'),
(206, 32, 'C8jwSoJscWXRzIyc', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 08:54:39', '2020-09-27 08:54:39'),
(207, 11, 'oJGvjjvp7dVpEyZa', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 08:54:39', '2020-09-27 08:54:39'),
(208, 32, 'o9cEOnkN1pG9Cvxx', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 08:54:52', '2020-09-27 08:54:52'),
(209, 11, 'sO4vVTLuL46oJE3n', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 08:54:52', '2020-09-27 08:54:52'),
(210, 32, 'MYL1IrgjNUoSQVcF', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 08:55:27', '2020-09-27 08:55:27'),
(211, 11, 'ZIFRqOgCGUWS8myh', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 08:55:27', '2020-09-27 08:55:27'),
(212, 32, 'OGADKFKUAfdiPMUd', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 08:55:45', '2020-09-27 08:55:45'),
(213, 11, 'JYyrjLygnykpquuS', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 08:55:45', '2020-09-27 08:55:45'),
(214, 32, '66CinlZUfzJ5otvr', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 08:57:39', '2020-09-27 08:57:39'),
(215, 11, '8M4mWpmAurIlCOlw', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 08:57:39', '2020-09-27 08:57:39'),
(216, 32, '1N6SzTAipxS6I2rr', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 08:58:40', '2020-09-27 08:58:40'),
(217, 11, '0okojmBilrQyjSjY', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 08:58:40', '2020-09-27 08:58:40'),
(218, 32, 'hiQq8nqAsXojuSus', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 09:01:39', '2020-09-27 09:01:39'),
(219, 11, 'oBNxCTsKMV9VHhPX', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 09:01:39', '2020-09-27 09:01:39'),
(220, 32, 'Uo5I3bOC9QDn5Fu3', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 09:02:45', '2020-09-27 09:02:45'),
(221, 11, 'uwqel0Uqso1lYsvT', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 09:02:45', '2020-09-27 09:02:45'),
(222, 32, 'YyiJiJ8WZDKrPPVB', 'Payment for owSaV7mXYdidocr1 was successful', '2020-09-27 09:06:16', '2020-09-27 09:06:16'),
(223, 11, 'Td2BxWwmyNCYshzm', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 09:06:16', '2020-09-27 09:06:16'),
(224, 11, 'aKM228RrfYBJpxRn', 'Received payment for Payment LinkowSaV7mXYdidocr1', '2020-09-27 09:14:40', '2020-09-27 09:14:40'),
(225, 32, 'u0jZ73wKIBq71YD7', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-27 10:11:02', '2020-09-27 10:11:02'),
(226, 11, 'vCmtt7W7ARD7hecO', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-27 10:11:02', '2020-09-27 10:11:02'),
(227, 32, 'h5p0e1jEjFtDPe5t', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-27 10:34:39', '2020-09-27 10:34:39'),
(228, 11, '45oECO5QHfT0EXl7', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-27 10:34:39', '2020-09-27 10:34:39'),
(229, 32, 'lWaDsJ9MtsjUlTdN', 'Donation for FCJBLZHPFRtKFrYN was successful', '2020-09-27 10:44:29', '2020-09-27 10:44:29'),
(230, 11, 'zvnQAz4DNk4nCjIi', 'Received Donation for Payment LinkFCJBLZHPFRtKFrYN', '2020-09-27 10:44:29', '2020-09-27 10:44:29'),
(231, 11, 'k2k0N1Yn1cyZ8daY', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-27 13:50:12', '2020-09-27 13:50:12'),
(232, 11, 'IPmwejdo1bhL2gc0', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-27 13:50:12', '2020-09-27 13:50:12'),
(233, 32, 'rhWXXfT5QY4pSRoJ', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 07:34:37', '2020-09-28 07:34:37'),
(234, 11, '5XD8Whn2hOf3IWzy', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 07:34:37', '2020-09-28 07:34:37'),
(235, 32, 'l8i18gblm8h1zISZ', 'Payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-28 07:36:30', '2020-09-28 07:36:30'),
(236, 11, 'uX0ATG6wfXRV1xRk', 'Received payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-28 07:36:30', '2020-09-28 07:36:30'),
(237, 32, 'TmxT5nhigjRF1RUN', 'Payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-28 07:37:50', '2020-09-28 07:37:50'),
(238, 11, 'bCDJOsiBbMsPIHXW', 'Received payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-28 07:37:50', '2020-09-28 07:37:50'),
(239, 32, 'jiNDWUy32LqoGvGD', 'Payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-28 07:39:57', '2020-09-28 07:39:57'),
(240, 11, 'cPK5IDPgDLOtZMZc', 'Received payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-28 07:39:57', '2020-09-28 07:39:57'),
(241, 32, 'VCZvQ9R5I6QcxRvb', 'Payment for mwbUixBFLuaJYlbc was successful', '2020-09-28 07:43:15', '2020-09-28 07:43:15'),
(242, 11, 'HzVeh15hiMGiiJZo', 'Received payment for Payment LinkmwbUixBFLuaJYlbc', '2020-09-28 07:43:15', '2020-09-28 07:43:15'),
(243, 32, '4l0M4Bxei3ZxNUts', 'Payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-28 07:45:21', '2020-09-28 07:45:21'),
(244, 11, 'eT3Fi4YIkDDfKuRr', 'Received payment for subscription #ksP4sVmZz0NhejBG - Apple Music was successful', '2020-09-28 07:45:21', '2020-09-28 07:45:21'),
(245, 11, 'XALzHI8J7sJKQHVg', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:17:35', '2020-09-28 08:17:35'),
(246, 11, 'YoHZcEPL8jfMsXfh', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:17:35', '2020-09-28 08:17:35'),
(247, 11, 'nf1UVIF59WEjUkxs', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:17:35', '2020-09-28 08:17:35'),
(248, 11, 'aonejjhTSsGp2KcD', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:17:35', '2020-09-28 08:17:35'),
(249, 11, '4bQkDnuS5vXUoEdf', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:17:35', '2020-09-28 08:17:35'),
(250, 11, 'YfHFqH8CipBDwa7i', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:17:35', '2020-09-28 08:17:35'),
(251, 11, 'cIXrAEVAYAMGWNqP', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:32:04', '2020-09-28 08:32:04'),
(252, 11, 'Px5f1HiYkJNnl7yT', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:32:04', '2020-09-28 08:32:04'),
(253, 11, '0kn5ICFBm6U33Njo', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:32:04', '2020-09-28 08:32:04'),
(254, 11, 'yNB3lPiPaLMHXzIg', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:32:04', '2020-09-28 08:32:04'),
(255, 11, 'R03RZW8wofY5Rp8C', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:32:04', '2020-09-28 08:32:04'),
(256, 11, 'KDaIzuxgtCvJt1WZ', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:32:04', '2020-09-28 08:32:04'),
(257, 11, 'yQ7S9NsNrgQMwhHY', 'Payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-28 08:42:47', '2020-09-28 08:42:47'),
(258, 11, 'QPN4YEsww1hAtTuB', 'Received payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-28 08:42:47', '2020-09-28 08:42:47'),
(259, 32, 'Navlk8rilftnymgF', 'Payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-28 08:43:05', '2020-09-28 08:43:05'),
(260, 11, 'RRBOMU4q4BIW0ect', 'Received payment for subscription #QtaKGl8xQlL7FcDZ - Boompay was successful', '2020-09-28 08:43:05', '2020-09-28 08:43:05'),
(261, 32, 'chsUs9oGIxHu1b0C', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:43:40', '2020-09-28 08:43:40'),
(262, 11, 'Npi3gsaLGgJsaZ43', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-28 08:43:40', '2020-09-28 08:43:40'),
(263, 32, 'ahan9UogiYD86QzD', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-29 18:38:43', '2020-09-29 18:38:43'),
(264, 11, 'UqbGeQm4YWgRA3hx', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-29 18:38:43', '2020-09-29 18:38:43'),
(265, 32, 'XFs3rDABEcrwXLzN', 'Payment for ohiPZNvRTCF7zMIk was successful', '2020-09-29 20:51:38', '2020-09-29 20:51:38'),
(266, 32, 'IynoBRBDxyTwzcXS', 'Payment for PCwsx7mY9XDJjhVt was successful', '2020-09-29 20:54:00', '2020-09-29 20:54:00'),
(267, 11, 'gTMtRCmar8CCgDfX', 'Requested ₦40000 from support@boomchart.net', '2020-09-30 07:09:56', '2020-09-30 07:09:56'),
(268, 11, '3Yu47kfyHlM4fst5', 'Requested ₦40000 from support@boomchart.net', '2020-09-30 07:10:40', '2020-09-30 07:10:40'),
(269, 11, 'TDD8J8QHgr6D9RzQ', 'Requested ₦40000 from support@boomchart.net', '2020-09-30 07:11:06', '2020-09-30 07:11:06'),
(270, 11, 'ZWenH2b8b12l2Xr0', 'Requested ₦40000 from support@boomchart.net', '2020-09-30 07:16:32', '2020-09-30 07:16:32'),
(271, 32, 'PyXOLkizcEBGajdE', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-30 09:54:51', '2020-09-30 09:54:51'),
(272, 11, 'w4Qkn0KM9joBrm0z', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-09-30 09:54:51', '2020-09-30 09:54:51'),
(273, 11, 'ejD22XRfD9FMbokY', 'Requested ₦2000 from support@boomchart.net', '2020-09-30 09:56:45', '2020-09-30 09:56:45'),
(274, 11, 'QDw4vLWtrBuRIgQG', 'Requested ₦3000000 from support@boomchart.net', '2020-09-30 11:09:19', '2020-09-30 11:09:19'),
(275, 11, 'ciNKW7WhHFCJKilQ', 'Requested ₦3000000 from support@boomchart.net', '2020-09-30 11:09:34', '2020-09-30 11:09:34'),
(276, 11, 'rC3pteIOadb9o9T5', 'Transfered ₦3000 to support@boomchart.net', '2020-09-30 11:27:08', '2020-09-30 11:27:08'),
(277, 11, 'rwYvRO4k7Kn662lW', 'Transfered ₦3000 to support@boomchart.net', '2020-09-30 11:28:04', '2020-09-30 11:28:04'),
(278, 11, '32cjF3OZ7LmU0iE8', 'Requested ₦3000000 from support@boomchart.net', '2020-09-30 11:30:02', '2020-09-30 11:30:02'),
(279, 11, 'fEwT0HUugiL3PCHE', 'Transfered ₦1000 to support@boomchart.net', '2020-09-30 12:12:29', '2020-09-30 12:12:29'),
(280, 11, 'XaNLzOLEpz7K7JKX', 'Transfered ₦1000 to support@boomchart.net', '2020-09-30 12:12:54', '2020-09-30 12:12:54'),
(281, 11, '1TvuthGqnnQTs6Fm', 'Transfered ₦1000 to support@boomchart.net', '2020-09-30 12:13:30', '2020-09-30 12:13:30'),
(282, 11, 'VsNZTK4Ttsz9I7Ft', 'Transfered ₦1000 to support@boomchart.net', '2020-09-30 12:15:26', '2020-09-30 12:15:26'),
(283, 11, 'encbx0Bu4Rh5cfzB', 'Transfered ₦1000 to support@boomchart.net', '2020-09-30 12:15:31', '2020-09-30 12:15:31'),
(284, 11, 'Vu4AhICUeCSzn5cR', 'Transfered ₦1000 to support@boomchart.net', '2020-09-30 12:15:38', '2020-09-30 12:15:38'),
(285, 11, 'gCs64YJy7bKGet3W', 'Transfered ₦1000 to support@boomchart.net', '2020-09-30 12:15:42', '2020-09-30 12:15:42'),
(286, 11, 'ct07sF01fhYpOSjN', 'Transfered ₦60000 to support@boomchart.net', '2020-09-30 12:16:14', '2020-09-30 12:16:14'),
(287, 11, '9jBNchpXXebmIsvC', 'Transfered ₦5900 to inyamachidi355@gmail.com', '2020-09-30 12:34:30', '2020-09-30 12:34:30'),
(288, 11, 'ht0UdyI67RAhHuzR', 'Transfered ₦5900 to inyamachidi355@gmail.com', '2020-09-30 12:35:00', '2020-09-30 12:35:00'),
(289, 11, 'OJyZuLm4pSywH6OI', 'Transfered ₦5900 to inyamachidi355@gmail.com', '2020-09-30 12:35:12', '2020-09-30 12:35:12'),
(290, 11, 'lUI9IerkFkoZk9f5', 'Transfered ₦5900 to inyamachidi355@gmail.com', '2020-09-30 12:35:58', '2020-09-30 12:35:58'),
(291, 11, 'VpfRW7Zg5AKv91GY', 'Transfered ₦69000 to inyamachidi355@gmail.com', '2020-09-30 12:39:15', '2020-09-30 12:39:15'),
(292, 11, 'iGjajgSyaMCvShZb', 'Payment for mwbUixBFLuaJYlbc was successful', '2020-10-01 08:02:31', '2020-10-01 08:02:31'),
(293, 11, 'CMayJivlDWjIa7Cy', 'Received payment for Payment LinkmwbUixBFLuaJYlbc', '2020-10-01 08:02:31', '2020-10-01 08:02:31'),
(294, 32, 'fT2ApkAVCgIeuFdo', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-10-01 10:49:49', '2020-10-01 10:49:49'),
(295, 11, '5AJKjuyWgZpW8501', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-10-01 10:49:49', '2020-10-01 10:49:49'),
(296, 32, 'jfwr86rEFTeEOqdW', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-10-02 08:43:46', '2020-10-02 08:43:46'),
(297, 11, '2GSveA5nSYsq5Hsr', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-10-02 08:43:46', '2020-10-02 08:43:46'),
(298, 11, 'sl8HXpotV8tmmqfX', 'Received payment for order #1H0l5kG3s8DELwPq', '2020-10-02 17:43:39', '2020-10-02 17:43:39'),
(299, 11, 'Xnps0FRgaC7uo57S', 'Received payment for order #PP8orD0hwanUqaKG', '2020-10-02 17:44:47', '2020-10-02 17:44:47'),
(300, 11, 'EHQwTcapmn49SJgL', 'Received payment for order #PP8orD0hwanUqaKG', '2020-10-02 17:46:51', '2020-10-02 17:46:51'),
(301, 11, 'R80fUZDptgX7qnNP', 'Received payment for order #WoX29u8VcPbKlDqy', '2020-10-02 17:52:56', '2020-10-02 17:52:56'),
(302, 11, 'UPPHfG3YbRHBnqOB', 'Received payment for order #zjIGAmxEAkqBDMcI', '2020-10-02 18:21:47', '2020-10-02 18:21:47'),
(303, 11, 'iFC78hsYrLsKdP2P', 'Received payment for order #zjIGAmxEAkqBDMcI', '2020-10-02 18:22:08', '2020-10-02 18:22:08'),
(304, 11, 'gv8dOJhr166r76Hn', 'Received payment for order #zjIGAmxEAkqBDMcI', '2020-10-02 18:23:01', '2020-10-02 18:23:01'),
(305, 32, '35v20peQKhJocfjB', 'Payment for B5xm3vZ5EZhs0xcj was successful', '2020-10-02 18:38:55', '2020-10-02 18:38:55'),
(306, 32, 'roH7PP3xEdXg1Ajc', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-10-03 10:33:51', '2020-10-03 10:33:51'),
(307, 11, 'aBA4jY5qpoecBRpn', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-10-03 10:33:51', '2020-10-03 10:33:51'),
(308, 32, '2KsCCHGYl3AUXWhL', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-10-04 13:02:16', '2020-10-04 13:02:16'),
(309, 11, 'gEq7AXZDih5WOxel', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-10-04 13:02:16', '2020-10-04 13:02:16'),
(310, 32, 'J40sq5hwx2oAxufL', 'Payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-10-05 08:48:27', '2020-10-05 08:48:27'),
(311, 11, 'eccTSgR1kAmLqovD', 'Received payment for subscription #LwoEgBP2rhygeBxw - Cleaning service was successful', '2020-10-05 08:48:27', '2020-10-05 08:48:27'),
(312, 11, 'MJ7uJ9Yv8iKYLvu5', 'Logged out - ::1', '2020-10-10 10:13:44', '2020-10-10 10:13:44'),
(313, 41, 'HtjDsdwC5AhS4SRx', 'Created Payment Link -  Credit Card', '2020-10-13 15:55:56', '2020-10-13 15:55:56'),
(314, 41, '9txpAbCuEh2TbvcJ', 'Payment for pVRvxl7PF9V6f79F was successful', '2020-10-13 15:56:08', '2020-10-13 15:56:08'),
(315, 41, 'lexHn2DuynmjqpsU', 'Received payment for Payment LinkpVRvxl7PF9V6f79F', '2020-10-13 15:56:08', '2020-10-13 15:56:08'),
(316, 41, 'vsJIL28SsQ6DRO2K', 'Transfered ₦1000 to freakboss3@gmail.com', '2020-11-04 20:09:21', '2020-11-04 20:09:21'),
(317, 41, 'ruZkbUbRZWE9GBup', 'Transfered ₦1000 to info@boomchart.net', '2020-11-04 20:14:07', '2020-11-04 20:14:07'),
(318, 41, 'J2PoEsulIPmZMTvp', 'Transfered ₦2000 to freakboss3@gmail.com', '2020-11-04 20:17:49', '2020-11-04 20:17:49'),
(319, 41, '5rJWdYoeEjmN3TC3', 'Transfered ₦2000 to freakboss3@gmail.com', '2020-11-04 20:18:06', '2020-11-04 20:18:06'),
(320, 41, 'hJScsBzbOrfPtmCc', 'Transfered ₦2000 to freakboss3@gmail.com', '2020-11-04 20:20:38', '2020-11-04 20:20:38'),
(321, 41, '0fQaCPMTvkfJofYW', 'Created Donation Page -  Fish Farming', '2020-11-04 20:31:39', '2020-11-04 20:31:39'),
(322, 41, 'Uj8TtWZQGIiv89vl', 'Donation for 76BgHHh8Fvg2DNnI was successful', '2020-11-04 20:47:09', '2020-11-04 20:47:09'),
(323, 41, '8HCIEuLK91Oad1Wj', 'Received Donation for Payment Link76BgHHh8Fvg2DNnI', '2020-11-04 20:47:09', '2020-11-04 20:47:09'),
(324, 43, 'Lhcp5VzVQX1ByDM2', 'Created Payment Link -  ddddd', '2020-12-10 21:12:24', '2020-12-10 21:12:24'),
(325, 43, 'xZoXyLwG31qC4IMt', 'Received payment for Payment Linkdc2oHEL3qNENrL1u', '2020-12-10 21:33:13', '2020-12-10 21:33:13'),
(326, 43, '82Sj1yYQONBBenD5', 'Created Funding Request of 3333NGN via Card', '2020-12-10 21:42:24', '2020-12-10 21:42:24'),
(327, 43, 'q6U7x2XEFOltcUqJ', 'Verified Funding Request of 3366.33NGN via Card', '2020-12-10 21:42:28', '2020-12-10 21:42:28'),
(328, 41, 'nKnNoljfM7sif8O6', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-21 19:40:55', '2020-12-21 19:40:55'),
(329, 41, 'wdKyqLlIahrWGzjV', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-21 19:41:55', '2020-12-21 19:41:55'),
(330, 41, 'ODHLRsjebsahQ5GW', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-21 19:42:14', '2020-12-21 19:42:14'),
(331, 41, 'yVU5QVWgdqQB2ggd', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-21 19:48:57', '2020-12-21 19:48:57'),
(332, 41, 'pwK8yja4caz1Ct3q', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-21 19:49:06', '2020-12-21 19:49:06'),
(333, 41, 'AUdMJ9qsvEjj3YJo', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-21 19:49:54', '2020-12-21 19:49:54'),
(334, 41, 'Bfvc3ewoyNT0lYVx', 'Requested ₦2000 from freakboss3@gmail.com', '2020-12-22 00:16:22', '2020-12-22 00:16:22'),
(335, 41, '3lzUap6h463NXIAk', 'Created Payment Link -  Ps5', '2020-12-22 00:26:40', '2020-12-22 00:26:40'),
(336, 41, 'IEtaxnaaGuruhgDh', 'Created Payment Link -  Lhassa Apso', '2020-12-22 00:40:57', '2020-12-22 00:40:57'),
(337, 41, '1mvAhQvrTNMGyu0m', 'Created Payment Link -  Zone', '2020-12-22 00:41:34', '2020-12-22 00:41:34'),
(338, 41, 'K7aMdrsIar6Y686h', 'Payment for uLbtGuqp2UNdkDnL was successful', '2020-12-22 02:07:29', '2020-12-22 02:07:29'),
(339, 41, 'eduFe6rQ0L6GJi4o', 'Received payment for Payment LinkuLbtGuqp2UNdkDnL', '2020-12-22 02:07:29', '2020-12-22 02:07:29'),
(340, 41, 'kmP69Il8Hbip12aQ', 'Received payment for Payment LinkejE4BNdtIa2wFUKU', '2020-12-22 08:35:18', '2020-12-22 08:35:18'),
(341, 41, 'BTzeaNDDDG7eQsUY', 'Donation for 76BgHHh8Fvg2DNnI was successful', '2020-12-22 11:14:00', '2020-12-22 11:14:00'),
(342, 41, '9ttExvoSOB0GB9Ok', 'Received Donation for Payment Link76BgHHh8Fvg2DNnI', '2020-12-22 11:14:00', '2020-12-22 11:14:00'),
(343, 41, 'E9IyYKExiRSqIjJF', 'Donation for 76BgHHh8Fvg2DNnI was successful', '2020-12-22 11:35:27', '2020-12-22 11:35:27'),
(344, 41, 'Si6TObdjaXKfZUdT', 'Received Donation for Payment Link76BgHHh8Fvg2DNnI', '2020-12-22 11:35:27', '2020-12-22 11:35:27'),
(345, 41, 'GGZ13M6EVWSVA38b', 'Created Donation Page -  Apple Farm', '2020-12-22 11:54:54', '2020-12-22 11:54:54'),
(346, 41, 'BB6c21BcCrH5Hj0x', 'Donation for xufj59LTUjUS6TZ5 was successful', '2020-12-22 12:23:17', '2020-12-22 12:23:17'),
(347, 41, '2iAb71V3JyqYPUJM', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2020-12-22 12:23:17', '2020-12-22 12:23:17'),
(348, 41, 'nLeDs9R0xuoVOqBp', 'Donation for xufj59LTUjUS6TZ5 was successful', '2020-12-22 12:23:57', '2020-12-22 12:23:57'),
(349, 41, 'mTzNtjjApU2o1DsR', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2020-12-22 12:23:57', '2020-12-22 12:23:57'),
(350, 41, 'ZSAOcowpWzZZm4ug', 'Donation for xufj59LTUjUS6TZ5 was successful', '2020-12-22 12:24:17', '2020-12-22 12:24:17'),
(351, 41, 'Y9enrgCgI119hEps', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2020-12-22 12:24:17', '2020-12-22 12:24:17'),
(352, 41, 'lfav8KPP2erna4nq', 'Donation for xufj59LTUjUS6TZ5 was successful', '2020-12-22 12:24:24', '2020-12-22 12:24:24'),
(353, 41, 'mIfthlAEqM31ozaS', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2020-12-22 12:24:24', '2020-12-22 12:24:24'),
(354, 41, '5RE2cFpwwjcqcqxu', 'Donation for xufj59LTUjUS6TZ5 was successful', '2020-12-22 12:24:28', '2020-12-22 12:24:28'),
(355, 41, 'OuLydSTZOlLksopF', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2020-12-22 12:24:28', '2020-12-22 12:24:28'),
(356, 41, 'ZuLBW7gUvWF2GhxX', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2020-12-22 12:28:24', '2020-12-22 12:28:24'),
(357, 41, 'GZv35kWDmZ6Hxjhg', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2020-12-22 12:29:34', '2020-12-22 12:29:34'),
(358, 41, '2fGwxADEnT5zOuv4', 'Created Donation Page -  Macbook M1 Chip', '2020-12-22 12:38:37', '2020-12-22 12:38:37'),
(359, 41, 'md9pHDjsWzIwi03P', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:26:52', '2020-12-25 14:26:52'),
(360, 41, 'dL9DFJ1ktLiyCXUc', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:29:37', '2020-12-25 14:29:37'),
(361, 41, 'BYFOStnaXiud2i1e', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:30:49', '2020-12-25 14:30:49'),
(362, 41, 'RCA30Kvv2W2XE9Ui', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:31:20', '2020-12-25 14:31:20'),
(363, 41, 'QW8RLztsP4MsZJc8', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:33:20', '2020-12-25 14:33:20'),
(364, 41, '5uF7DisFImvxHeSY', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:34:31', '2020-12-25 14:34:31'),
(365, 41, 'espz7n56owwhZa7A', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:35:54', '2020-12-25 14:35:54'),
(366, 41, 'um3k7cJ8xyosra23', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:38:20', '2020-12-25 14:38:20'),
(367, 41, 'qejcXucgrJRWBdOo', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:38:47', '2020-12-25 14:38:47'),
(368, 41, 'iQpy6mc60zJpLSDk', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:41:03', '2020-12-25 14:41:03'),
(369, 41, 'vN0Auin6S31TtVwh', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:53:07', '2020-12-25 14:53:07'),
(370, 41, 'JwWfQO4PAwjOkkTJ', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:53:52', '2020-12-25 14:53:52'),
(371, 41, 'uYzMeRHZQQAVaAws', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:54:09', '2020-12-25 14:54:09'),
(372, 41, 'ag8vaelUMZAKgVBM', 'Created Funding Request of 1000NGN via Deposit with Card', '2020-12-25 14:54:32', '2020-12-25 14:54:32'),
(373, 41, 'Ty46ZHNrGkDOKncv', 'Created Funding Request of 2000NGN via Deposit with Card', '2020-12-25 14:55:24', '2020-12-25 14:55:24'),
(374, 41, 'yZCIbUGwYOG5wKOD', 'Created Funding Request of 100NGN via Deposit with Card', '2020-12-25 14:58:22', '2020-12-25 14:58:22'),
(375, 41, 'HAyE4J6V9eI8S3L6', 'Created Funding Request of 100NGN via Deposit with Card', '2020-12-25 14:58:43', '2020-12-25 14:58:43'),
(376, 41, 'N5L6tRkM67WeTENZ', 'Created Funding Request of 100NGN via Deposit with Card', '2020-12-25 14:59:18', '2020-12-25 14:59:18'),
(377, 41, '3JeJLMPPdEzdL7wK', 'Created Funding Request of 100NGN via Deposit with Card', '2020-12-25 15:02:33', '2020-12-25 15:02:33'),
(378, 41, 'DjlFd8Ah7mDVrPGK', 'Created Funding Request of 100NGN via Deposit with Card', '2020-12-25 15:05:10', '2020-12-25 15:05:10'),
(379, 41, '88oaDKfLoKHCl7Rw', 'Created Funding Request of 100NGN via Deposit with Card', '2020-12-25 15:05:28', '2020-12-25 15:05:28'),
(380, 41, 'EPBSJaDZLvuY1BYZ', 'Created Funding Request of 100NGN via Deposit with Card', '2020-12-25 15:06:04', '2020-12-25 15:06:04'),
(381, 41, '1JPRrxsStDJW2fTs', 'Created Funding Request of 100NGN via Deposit with Card', '2020-12-25 15:07:20', '2020-12-25 15:07:20'),
(382, 41, '4KJsCiaJwIyX3ufK', 'Created Funding Request of 200NGN via Deposit with Card', '2020-12-25 17:11:39', '2020-12-25 17:11:39'),
(383, 41, 'sClH1MIh5A3Vr7Pe', 'Created Funding Request of 200NGN via Deposit with Card', '2020-12-25 17:12:07', '2020-12-25 17:12:07'),
(384, 41, 'T6BClr5177uDXvSN', 'Created Funding Request of 200NGN via Deposit with Card', '2020-12-25 17:15:19', '2020-12-25 17:15:19'),
(385, 41, 'oXqsx2AqwHcmp0df', 'Created Funding Request of 200NGN via Deposit with Card', '2020-12-25 17:16:38', '2020-12-25 17:16:38'),
(386, 41, 'tb8Tjec4XM17iNtM', 'Created Funding Request of 200NGN via Deposit with Card', '2020-12-25 17:17:43', '2020-12-25 17:17:43');
INSERT INTO `audit_logs` (`id`, `user_id`, `trx`, `log`, `created_at`, `updated_at`) VALUES
(387, 41, 'JDUaHuLAFzWfCadK', 'Created Funding Request of 200NGN via Deposit with Card', '2020-12-25 17:19:03', '2020-12-25 17:19:03'),
(388, 41, '166LGnx61XwEMjYu', 'Created Funding Request of 200NGN via Deposit with Card', '2020-12-25 17:20:07', '2020-12-25 17:20:07'),
(389, 41, 'wfdm5zVFG7nFgw2J', 'Created Funding Request of 200NGN via Deposit with Card', '2020-12-25 17:24:59', '2020-12-25 17:24:59'),
(390, 41, 'bcQsgFPpFpEKIekN', 'Created Funding Request of 200NGN via Deposit with Card', '2020-12-25 17:26:10', '2020-12-25 17:26:10'),
(391, 41, 'Y8T2ypvFMuUXDW55', 'Verified Funding Request of 206NGN via Deposit with Card', '2020-12-25 17:26:23', '2020-12-25 17:26:23'),
(392, 41, 'ehQMaTkczO9vuF5y', 'Created Funding Request of 4000NGN via Deposit with Card', '2020-12-25 17:29:19', '2020-12-25 17:29:19'),
(393, 41, 'RdkxWFEzn8oUvNgL', 'Verified Funding Request of 4120NGN via Deposit with Card', '2020-12-25 17:29:29', '2020-12-25 17:29:29'),
(394, 41, '0DmLSEi1H1wrGXSe', 'Created Plan -  Dog food', '2020-12-26 20:12:33', '2020-12-26 20:12:33'),
(395, 41, 'pfOVNQ4MbgyRtMxZ', 'Payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2020-12-26 20:50:28', '2020-12-26 20:50:28'),
(396, 41, 'HX47cI9QhHPrufLS', 'Received payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2020-12-26 20:50:28', '2020-12-26 20:50:28'),
(397, 41, 'rXKfi1Voj2iVcRXa', 'Created Funding Request of 40NGN via Deposit with Card', '2020-12-28 21:05:24', '2020-12-28 21:05:24'),
(398, 41, 'adX8lo10bzs8gBEk', 'Created Funding Request of 3000NGN via Deposit with Card', '2020-12-28 22:39:51', '2020-12-28 22:39:51'),
(399, 41, 'Qx7eA7clXcj1hTpl', 'Created Funding Request of 3000NGN via Deposit with Card', '2020-12-28 22:43:11', '2020-12-28 22:43:11'),
(400, 41, 'OMGi773ArncffVVb', 'Created Funding Request of 3000NGN via Deposit with Card', '2020-12-28 22:43:20', '2020-12-28 22:43:20'),
(401, 41, 'knPsu56KvCRJ0vfW', 'Created Funding Request of 3000NGN via Deposit with Card', '2020-12-28 22:45:03', '2020-12-28 22:45:03'),
(402, 41, 'WMlp3Vl5XQZzSrVi', 'Created Funding Request of 3000NGN via Deposit with Card', '2020-12-28 22:46:00', '2020-12-28 22:46:00'),
(403, 41, 'O86XwuQDWS2vd2OL', 'Created Funding Request of 3000NGN via Deposit with Card', '2020-12-28 22:46:12', '2020-12-28 22:46:12'),
(404, 41, '1P7U6DHmkslav95l', 'Created Funding Request of 3000NGN via Deposit with Card', '2020-12-28 22:51:04', '2020-12-28 22:51:04'),
(405, 41, 'FjTSIoYYRMPA7NAw', 'Created Funding Request of 4000NGN via Deposit with Card', '2020-12-28 22:51:47', '2020-12-28 22:51:47'),
(406, 41, 'z6pBLII4sWoU5RGQ', 'Created Funding Request of 4000NGN via Deposit with Card', '2020-12-28 22:54:56', '2020-12-28 22:54:56'),
(407, 41, 'tF4fAnt94VKlj72N', 'Created Funding Request of 4000NGN via Deposit with Card', '2020-12-28 22:55:20', '2020-12-28 22:55:20'),
(408, 41, '4nrMsC0aN7UqIqNm', 'Created Funding Request of 4000NGN via Deposit with Card', '2020-12-28 22:56:15', '2020-12-28 22:56:15'),
(409, 41, 'jfyHonJb7bAdWWWO', 'Created Funding Request of 4000NGN via Deposit with Card', '2020-12-28 22:56:46', '2020-12-28 22:56:46'),
(410, 41, 'sEsbZQZeUOzGLKC5', 'Created Funding Request of 4000NGN via Deposit with Card', '2020-12-28 22:56:56', '2020-12-28 22:56:56'),
(411, 41, 'PaTSXUWIVIV9FPEY', 'Created Funding Request of 4000NGN via Deposit with Card', '2020-12-28 23:01:43', '2020-12-28 23:01:43'),
(412, 41, 'lsnkAOCRLqzQz3MX', 'Created Funding Request of 30000NGN via Deposit with Card', '2020-12-28 23:05:23', '2020-12-28 23:05:23'),
(413, 41, 'sefuhlbCUZYeujJs', 'Verified Funding Request of 30900NGN via Deposit with Card', '2020-12-28 23:05:35', '2020-12-28 23:05:35'),
(414, 41, 't6HqV5img6z41WkM', 'Created Funding Request of 50000NGN via Deposit with Card', '2020-12-28 23:07:32', '2020-12-28 23:07:32'),
(415, 41, 'a5PHvlmn5qP6t5eD', 'Verified Funding Request of 51500NGN via Deposit with Card', '2020-12-28 23:07:44', '2020-12-28 23:07:44'),
(416, 41, 'DMZyVwy2KLVQ5DAD', 'Created Funding Request of 400NGN via Deposit with Card', '2020-12-28 23:12:38', '2020-12-28 23:12:38'),
(417, 41, '9U7N86KdTau3rzFZ', 'Verified Funding Request of 412NGN via Deposit with Card', '2020-12-28 23:12:56', '2020-12-28 23:12:56'),
(418, 41, 'KHg71bhh3fYOudcK', 'Created Funding Request of 3444NGN via Deposit with Card', '2020-12-28 23:14:18', '2020-12-28 23:14:18'),
(419, 41, 'eVkOTVLTLTjPEac7', 'Verified Funding Request of 3547.32NGN via Deposit with Card', '2020-12-28 23:14:49', '2020-12-28 23:14:49'),
(420, 41, 'sx1k0pZOazd7hMWf', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:15:49', '2020-12-28 23:15:49'),
(421, 41, '21Wwfj1lIkbOYcny', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:16:26', '2020-12-28 23:16:26'),
(422, 41, 'bcl8tvqIngYGB7EB', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:17:42', '2020-12-28 23:17:42'),
(423, 41, '1pzElpI8DKaABewz', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:19:54', '2020-12-28 23:19:54'),
(424, 41, 'CKpQq7TV6xap4OM4', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:20:44', '2020-12-28 23:20:44'),
(425, 41, '4FPqZmKczHvgE6fa', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:21:39', '2020-12-28 23:21:39'),
(426, 41, 'uQnQl0GRBKh4TFv2', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:25:39', '2020-12-28 23:25:39'),
(427, 41, 'XbZ1lWRamvJ9mlfg', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:28:12', '2020-12-28 23:28:12'),
(428, 41, 'z6Seekc1v8UiIn01', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:29:55', '2020-12-28 23:29:55'),
(429, 41, 'mBKdKmlTuoLwlqL6', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:31:42', '2020-12-28 23:31:42'),
(430, 41, 'TsFPamzdGgdpdHa0', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:31:58', '2020-12-28 23:31:58'),
(431, 41, 'Hpm3Chp0guRChhlV', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:32:16', '2020-12-28 23:32:16'),
(432, 41, 'IR5zp73uUndoxxlo', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:34:32', '2020-12-28 23:34:32'),
(433, 41, 'QKxXOby5D68oYmZp', 'Created Funding Request of 4444NGN via Deposit with Card', '2020-12-28 23:35:44', '2020-12-28 23:35:44'),
(434, 41, 'f5h6Um7BTPBbM4Yr', 'Created Funding Request of 4000NGN via Deposit with Card', '2020-12-28 23:38:25', '2020-12-28 23:38:25'),
(435, 41, 'KnhppsiRwSIRaGrv', 'Created Funding Request of 3333NGN via Deposit with Card', '2020-12-28 23:41:20', '2020-12-28 23:41:20'),
(436, 41, 'uHqQM05BCzyzL677', 'Created Funding Request of 3333NGN via Deposit with Card', '2020-12-28 23:48:12', '2020-12-28 23:48:12'),
(437, 41, 'H5SmhDvys4E1uARG', 'Created Funding Request of 3333NGN via Deposit with Card', '2020-12-28 23:48:36', '2020-12-28 23:48:36'),
(438, 41, 'zwkxRngYqMQpxo5V', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-28 23:58:08', '2020-12-28 23:58:08'),
(439, 41, 'T8doRGHqVneepXK5', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:02:26', '2020-12-29 00:02:26'),
(440, 41, 'tosKZRFMqSqb3S38', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:07:36', '2020-12-29 00:07:36'),
(441, 41, '7VCM2oikN4OQ9bdh', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:07:59', '2020-12-29 00:07:59'),
(442, 41, '0SIZaWE4q7LAYn6b', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:08:46', '2020-12-29 00:08:46'),
(443, 41, 'FsXAlyVSp5h8qvya', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:09:43', '2020-12-29 00:09:43'),
(444, 41, '0xsgW0mgpj2n9rwH', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:10:17', '2020-12-29 00:10:17'),
(445, 41, 'e6XePShsOrQLbSxO', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:10:36', '2020-12-29 00:10:36'),
(446, 41, 'Rzap8YjRl9HB4USK', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:11:05', '2020-12-29 00:11:05'),
(447, 41, 'KjxCwJECTA152K3U', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:12:01', '2020-12-29 00:12:01'),
(448, 41, 'l9xMTtGMbHlGdBFB', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:12:54', '2020-12-29 00:12:54'),
(449, 41, 'B1x21rLiwlANTOo2', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:13:34', '2020-12-29 00:13:34'),
(450, 41, 'gvZg0FbrcRxmS6uS', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:14:09', '2020-12-29 00:14:09'),
(451, 41, 'meyHEoBwdaxhRgAU', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:14:13', '2020-12-29 00:14:13'),
(452, 41, 'VRpQTOSplq3KVjqb', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:14:53', '2020-12-29 00:14:53'),
(453, 41, 'w7VzgA4e4EP4FUj1', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:15:55', '2020-12-29 00:15:55'),
(454, 41, 'c1JXk3u7Uv4Zal1d', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:16:32', '2020-12-29 00:16:32'),
(455, 41, 'ccFp3sZkUEloDbDt', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:17:09', '2020-12-29 00:17:09'),
(456, 41, '7n91KDYTOiPewZq6', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:18:03', '2020-12-29 00:18:03'),
(457, 41, 'ZZXP2RH4PwfXEtVK', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:18:29', '2020-12-29 00:18:29'),
(458, 41, 'jFetNyZd5kzq2qFk', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:20:08', '2020-12-29 00:20:08'),
(459, 41, '8OybYgzH9cgE8q8w', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:20:48', '2020-12-29 00:20:48'),
(460, 41, '5KTmdWHj2T9jknQS', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:22:01', '2020-12-29 00:22:01'),
(461, 41, 'DqHezHauTZ4NIKYr', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:22:42', '2020-12-29 00:22:42'),
(462, 41, 'ckmaAfeaIiRvlY59', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:23:05', '2020-12-29 00:23:05'),
(463, 41, 'sayDXHWhApomD7wD', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:24:15', '2020-12-29 00:24:15'),
(464, 41, 'nMBGl8jBQ9yAQSQ2', 'Created Funding Request of 4333NGN via Deposit with Card', '2020-12-29 00:25:07', '2020-12-29 00:25:07'),
(465, 41, 'oGpd46P89wimZGrn', 'Created Funding Request of 3000NGN via Deposit with Card', '2020-12-29 09:11:12', '2020-12-29 09:11:12'),
(466, 41, 'CFZktfQQA8fLfys8', 'Verified Funding Request of 3090NGN via Deposit with Card', '2020-12-29 09:11:27', '2020-12-29 09:11:27'),
(467, 41, '32fdbU5IHzX7JEel', 'Received payment for Payment LinkuLbtGuqp2UNdkDnL', '2020-12-29 14:19:59', '2020-12-29 14:19:59'),
(468, 41, '4f9zUrDUeolpZFqx', 'Received payment for Payment LinkuLbtGuqp2UNdkDnL', '2020-12-29 14:23:35', '2020-12-29 14:23:35'),
(469, 41, 'sfKfiGlIatyEDVks', 'Received Donation for Payment LinkAivKD8mR7anHUVWV', '2020-12-29 14:28:33', '2020-12-29 14:28:33'),
(470, 41, 'srhRNby5nBY7L3xT', 'Received payment for order #2tYSgbm2pIhyz5l5', '2020-12-29 14:34:51', '2020-12-29 14:34:51'),
(471, 41, 'R59KZB0QqHUPpsuD', 'Charges for BTC purchase #71FWQbbCDamd3IxA', '2020-12-29 19:25:28', '2020-12-29 19:25:28'),
(472, 41, 'xh79JYr0Vqokr6up', 'Sent request for BTC sale #Dt9HCkRh1Ji0LvUJ', '2020-12-29 20:04:17', '2020-12-29 20:04:17'),
(473, 41, 'IIaNH5h6ecZ6UEXC', 'Sent request for BTC sale #dm7zUIJfune1xOEn', '2020-12-29 20:17:34', '2020-12-29 20:17:34'),
(474, 41, 'swXLNrU3kIAhIaUV', 'Sent request for ETH sale #Lsc5zZqE8g8vt5ZK', '2020-12-29 20:37:29', '2020-12-29 20:37:29'),
(475, 41, 'uuqeWtXzV4ZR7Awu', 'ETH purchase #KqZUVS5uwauFQMLh', '2020-12-29 20:38:56', '2020-12-29 20:38:56'),
(476, 41, 'dB9EuxP0qnmIP6cM', 'Sent request for ETH sale #8207bt5uX1TgLRPr', '2020-12-29 20:39:13', '2020-12-29 20:39:13'),
(477, 41, 'FIOSTFjUO62ASBX0', 'Sent request for ETH sale #z1jECVsYfR8tmY68', '2020-12-29 20:40:11', '2020-12-29 20:40:11'),
(478, 41, '40RkJVoXqiE6rG8T', 'Payment for 5d3rcP1lNxcfNIAL was successful', '2021-01-02 11:16:48', '2021-01-02 11:16:48'),
(479, 41, 'gqr9CpzuMxQySKep', 'Payment for qVW7obiJP5BuVaxf was successful', '2021-01-02 11:22:36', '2021-01-02 11:22:36'),
(480, 41, 'WSQxKQMKjJcPUe6b', 'Payment for 9gF5dSURbdXCfoKv was successful', '2021-01-02 11:34:02', '2021-01-02 11:34:02'),
(481, 41, 'pIWW5NbfAbuUkaS8', 'Payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-01-04 10:00:50', '2021-01-04 10:00:50'),
(482, 41, 'PV1Wme6YXNTWfgKc', 'Received payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-01-04 10:00:50', '2021-01-04 10:00:50'),
(483, 41, 'LDp6jnGj32sQdbps', 'Sent request for BTC sale #WAmuusz5vp4cq5zB', '2021-01-04 11:57:29', '2021-01-04 11:57:29'),
(484, 41, 'TR-H8eznc', 'Transfered ₦40000 to freakboss3@gmail.com', '2021-01-05 11:25:28', '2021-01-05 11:25:28'),
(485, 41, 'jxNLR6DGC7cKoeg6', 'BTC purchase #BTC-qwlp6S', '2021-01-05 11:52:51', '2021-01-05 11:52:51'),
(486, 41, 'x8Up6NT5m3AIzyfK', 'Requested ₦300 from freakboss3@gmail.com', '2021-01-05 12:00:57', '2021-01-05 12:00:57'),
(487, 41, 'o3gu6OPlofwG3pqd', 'Created Plan -  Map', '2021-01-05 12:18:18', '2021-01-05 12:18:18'),
(488, 41, 'XAo24xRQJMsOXzzn', 'Activated 2fa', '2021-01-06 19:21:37', '2021-01-06 19:21:37'),
(489, 41, 'pLmzHS1sWUpqvmCr', 'Sent request for BTC sale #BTC-I5j401', '2021-01-07 18:55:54', '2021-01-07 18:55:54'),
(490, 41, 'DWgk0k5nxWqHAAkM', 'Payment for MER-sgDbmI was successful', '2021-01-07 18:59:56', '2021-01-07 18:59:56'),
(491, 41, 'J2MFKTu0ceu5TjCf', 'ETH purchase #ETH-pq61OU', '2021-01-09 07:52:03', '2021-01-09 07:52:03'),
(492, 41, 'IU0Bxd4e8W2bk1RH', 'Requested ₦40000 from freakboss3@gmail.com', '2021-01-09 08:03:20', '2021-01-09 08:03:20'),
(493, 41, 'yjbNWvtb0QgG6MkU', 'Payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-01-10 07:51:45', '2021-01-10 07:51:45'),
(494, 41, 'dsWojD1lzJwuAzVv', 'Received payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-01-10 07:51:45', '2021-01-10 07:51:45'),
(495, 41, 'dcW93lSOsSPLTxA1', 'Payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-01-19 19:10:47', '2021-01-19 19:10:47'),
(496, 41, 'npS7RUeU0GEIZpvP', 'Received payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-01-19 19:10:47', '2021-01-19 19:10:47'),
(497, 41, 'TR-LNyPGo', 'Transfered ₦20000 to freakboss3@gmail.com', '2021-01-20 13:11:52', '2021-01-20 13:11:52'),
(498, 41, 'jQJTJYXgiRpBkBlx', 'BTC purchase #BTC-FrWmFM', '2021-01-20 13:54:39', '2021-01-20 13:54:39'),
(499, 41, 'dCqFvbjZq139z2O4', 'Sent request for BTC sale #BTC-XeXJcV', '2021-01-20 13:57:34', '2021-01-20 13:57:34'),
(500, 41, 'RQ-QBYJJD', 'Requested ₦3000 from freakboss3@gmail.com', '2021-01-20 14:18:43', '2021-01-20 14:18:43'),
(501, 41, '4km8ydUlBbEXpkwA', 'Created Payment Link - SC-525n8z', '2021-01-20 14:33:17', '2021-01-20 14:33:17'),
(502, 41, 'DN-YjbEuN', 'Created Donation Page - DN-YjbEuN', '2021-01-20 14:44:52', '2021-01-20 14:44:52'),
(503, 41, 'zzUkUVhY7SYHsAp4', 'Received payment for order #au6xy8JqzMGL7fKF', '2021-01-20 16:41:22', '2021-01-20 16:41:22'),
(504, 41, 'SC-0HvHrn', 'Received payment for Payment LinkSC-525n8z', '2021-01-20 17:13:55', '2021-01-20 17:13:55'),
(505, 41, 'rzQgzSPtUHTfsNeH', 'Received Donation for Payment LinkDN-YjbEuN', '2021-01-20 17:40:39', '2021-01-20 17:40:39'),
(506, 44, '3WsoGijKOim5ABBt', 'Donation for DN-YjbEuN was successful', '2021-01-20 17:52:31', '2021-01-20 17:52:31'),
(507, 41, 'AEqGpN5T3bOmIPXS', 'Received Donation for Payment LinkDN-YjbEuN', '2021-01-20 17:52:31', '2021-01-20 17:52:31'),
(508, 41, 'ZrbGN2XoFAk9euuO', 'Received Donation for Payment LinkDN-YjbEuN', '2021-01-20 18:01:18', '2021-01-20 18:01:18'),
(509, 41, 'cleBCCrTmEjvTA0G', 'Received Donation for Payment LinkDN-YjbEuN', '2021-01-20 18:11:50', '2021-01-20 18:11:50'),
(510, 44, 'NiRR0K880KE2VBrb', 'Donation for DN-YjbEuN was successful', '2021-01-20 18:18:20', '2021-01-20 18:18:20'),
(511, 41, 'Ge2ptufAr1v3qo59', 'Received Donation for Payment LinkDN-YjbEuN', '2021-01-20 18:18:20', '2021-01-20 18:18:20'),
(512, 41, 'XIpqiPeuFIkgXphw', 'Received Donation for Payment LinkDN-YjbEuN', '2021-01-20 18:18:47', '2021-01-20 18:18:47'),
(513, 41, 'SC-afRhSZ', 'Received payment for Payment LinkSC-525n8z', '2021-01-20 18:28:29', '2021-01-20 18:28:29'),
(514, 41, 'TR-6Jv7VJ', 'Transfered ₦40000 to info@boomchart.net', '2021-01-20 18:34:08', '2021-01-20 18:34:08'),
(515, 41, 'TR-yn8OHf', 'Transfered ₦3000 to info@boomchart.net', '2021-01-20 18:55:45', '2021-01-20 18:55:45'),
(516, 41, 'TR-Tn9LaK', 'Transfered ₦4000 to f@f.com', '2021-01-20 18:58:41', '2021-01-20 18:58:41'),
(517, 41, 'TR-VYN4im', 'Transfered ₦40000 to info@boomchart.net', '2021-01-20 19:09:01', '2021-01-20 19:09:01'),
(518, 41, 'fprBuPAI9tgr6cwa', 'Received payment for order #vh0NeXY7ZTeAe6WK', '2021-01-20 19:32:30', '2021-01-20 19:32:30'),
(519, 41, 'pENO4QtPTtbkRVBg', 'Created Funding Request of 20000NGN via Card', '2021-01-20 19:58:37', '2021-01-20 19:58:37'),
(520, 41, 'glKEOcAdbuQutVWY', 'Verified Funding Request of 20200NGN via Card', '2021-01-20 19:58:40', '2021-01-20 19:58:40'),
(521, 41, 'vJu9bD9mtYsVQy39', 'Created Funding Request of 20000NGN via Card', '2021-01-20 20:11:31', '2021-01-20 20:11:31'),
(522, 41, 'iEcpPKOU5iRoFoHa', 'Verified Funding Request of 20200NGN via Card', '2021-01-20 20:11:33', '2021-01-20 20:11:33'),
(523, 44, 'tpGvAFEignMai347', 'Updated account details', '2021-01-20 22:55:32', '2021-01-20 22:55:32'),
(524, 44, 'aLBBP32hRqEmFvc1', 'Updated account details', '2021-01-20 22:55:41', '2021-01-20 22:55:41'),
(525, 44, 'YfIeCBa41mLgqiko', 'BTC purchase #BTC-5UkIKZ', '2021-01-20 23:35:31', '2021-01-20 23:35:31'),
(526, 44, 'DN-Qbky3T', 'Created Donation Page - DN-Qbky3T', '2021-01-21 07:30:46', '2021-01-21 07:30:46'),
(527, 44, 'du0qqPucfDanWWnD', 'Created Payment Link - SC-6EUz4i', '2021-01-21 07:34:34', '2021-01-21 07:34:34'),
(528, 41, 'MER-8i0cqX', 'Payment for MER-8i0cqX was successful', '2021-01-21 11:00:00', '2021-01-21 11:00:00'),
(529, 41, 'MER-e6rF2A', 'Received Payment for MER-e6rF2A was successful', '2021-01-21 11:05:37', '2021-01-21 11:05:37'),
(530, 41, 'MER-VSXLqn', 'Payment for MER-VSXLqn was successful', '2021-01-22 22:10:21', '2021-01-22 22:10:21'),
(531, 41, 'MER-TFUIZ8', 'Received Payment for MER-TFUIZ8 was successful', '2021-01-22 22:22:10', '2021-01-22 22:22:10'),
(532, 45, 'LqaF79kNZfk8rsWH', 'Updated account details', '2021-01-24 10:07:12', '2021-01-24 10:07:12'),
(533, 41, 'L2GnBZmQ48i1ROZM', 'Donation for DN-YjbEuN was successful', '2021-01-24 18:20:26', '2021-01-24 18:20:26'),
(534, 41, 'wqq2FZ8zJYX1s0KL', 'Received Donation for Payment LinkDN-YjbEuN', '2021-01-24 18:20:26', '2021-01-24 18:20:26'),
(535, 41, 'hSuGClgmUv0e1kPv', 'BTC purchase #BTC-lg7Ooj', '2021-01-25 07:31:53', '2021-01-25 07:31:53'),
(536, 41, 'UeTpfH37sFlrfuQR', 'Received payment for order #ORD-QPlOPF', '2021-01-26 06:06:40', '2021-01-26 06:06:40'),
(537, 41, '5AD8zWezY3sMPRjC', 'Received payment for order #ORD-DA5kcd', '2021-01-26 06:41:25', '2021-01-26 06:41:25'),
(538, 41, 'e0ju3tLc2FiCELH6', 'Received payment for order #ORD-8eR6JQ', '2021-01-26 07:58:27', '2021-01-26 07:58:27'),
(539, 41, 'pAJEeRh9AHirHuT3', 'Received payment for order #ORD-bhYtqO', '2021-01-26 08:13:02', '2021-01-26 08:13:02'),
(540, 41, 'RHkgFZ99gHrs0TdV', 'Received payment for order #ORD-LrQkhA', '2021-01-26 08:19:16', '2021-01-26 08:19:16'),
(541, 41, 'BEUyUE9iXTMhAj7k', 'Received payment for order #ORD-LrQkhA', '2021-01-26 08:20:21', '2021-01-26 08:20:21'),
(542, 41, 'nCy0kA3kVueF4C2A', 'Received payment for order #ORD-zdQdj2', '2021-01-26 08:42:16', '2021-01-26 08:42:16'),
(543, 41, 'H4Vc1sCfSPrmyNGF', 'Received payment for order #ORD-mItFzn', '2021-01-26 11:36:32', '2021-01-26 11:36:32'),
(544, 44, 'raRBSBxviH5NIqFx', 'Received payment for order #ORD-Lxt0Jf', '2021-01-26 11:47:51', '2021-01-26 11:47:51'),
(545, 44, '06qv4i8HMCfEGREV', 'Received payment for order #ORD-lbb0e1', '2021-01-26 11:49:32', '2021-01-26 11:49:32'),
(546, 44, '3eDiMN9dGDPsG3qx', 'Received payment for order #ORD-4Ryxyz', '2021-01-26 11:52:15', '2021-01-26 11:52:15'),
(547, 44, 'eH9fsDBBX5cCrTvc', 'Received payment for order #ORD-ZeIDlk', '2021-01-26 12:00:09', '2021-01-26 12:00:09'),
(548, 44, 'bNHVU7M8KNXtIoL7', 'Received payment for order #ORD-vziNpF', '2021-01-26 12:11:53', '2021-01-26 12:11:53'),
(549, 44, 'V4wnrd3kIwYZ9JV2', 'Received payment for order #ORD-OspreT', '2021-01-26 12:16:29', '2021-01-26 12:16:29'),
(550, 44, 'jPMYeoHYekqi6KeT', 'Received payment for order #ORD-Hfv4FG', '2021-01-26 12:19:20', '2021-01-26 12:19:20'),
(551, 44, 'ed2Js3WgQOQ1loGY', 'Received payment for order #ORD-KaMFJO', '2021-01-26 12:22:11', '2021-01-26 12:22:11'),
(552, 44, 'FgP4A0T8hOq3zVQ9', 'Received payment for order #ORD-QRzRnN', '2021-01-26 12:24:38', '2021-01-26 12:24:38'),
(553, 41, '6opUQnfVuS5t0WEl', 'Received payment for order #ORD-4a0ZTS', '2021-01-26 12:28:34', '2021-01-26 12:28:34'),
(554, 44, 'vFzNQ6Y7MWWUoCHl', 'Updated account details', '2021-01-26 12:36:50', '2021-01-26 12:36:50'),
(555, 44, 'zKM6nMhsjyZgsa8Y', 'Updated account details', '2021-01-26 13:03:44', '2021-01-26 13:03:44'),
(556, 41, 'WsqbAp64MBEOXecO', 'Received payment for order #ORD-K2vyGg', '2021-01-26 14:23:30', '2021-01-26 14:23:30'),
(557, 41, 'IxtqEojdUhk6jNte', 'Received payment for order #ORD-zCliof', '2021-01-26 19:53:05', '2021-01-26 19:53:05'),
(558, 41, 'G0c8aeIEI5sw8no1', 'Updated compliance form', '2021-01-26 21:07:35', '2021-01-26 21:07:35'),
(559, 41, 'bAzW2QEe4w9azRPk', 'Updated compliance form', '2021-01-26 21:31:32', '2021-01-26 21:31:32'),
(560, 41, 'UrAZhgGranjLjMp3', 'Updated compliance form', '2021-01-26 21:36:15', '2021-01-26 21:36:15'),
(561, 41, '6cF3dpoXMBGpom3D', 'Updated compliance form', '2021-01-26 23:51:07', '2021-01-26 23:51:07'),
(562, 41, 'g55MWYDjMbyFiUBe', 'Updated compliance form', '2021-01-26 23:52:36', '2021-01-26 23:52:36'),
(563, 48, '02Vs6X4k1mfO6vml', 'Created Funding Request of 30000NGN via Card', '2021-01-28 11:56:36', '2021-01-28 11:56:36'),
(564, 48, 'HsAtgtn669QsH6tD', 'Verified Funding Request of 30300NGN via Card', '2021-01-28 11:56:39', '2021-01-28 11:56:39'),
(565, 41, 'TR-uxkqHX', 'Transfered $2000 to s@site.com', '2021-01-28 13:15:13', '2021-01-28 13:15:13'),
(566, 48, 'bZm1sYatCtPy1E51', 'Updated compliance form', '2021-01-28 21:21:04', '2021-01-28 21:21:04'),
(567, 48, 'yZYF8RdnNz7njQ83', 'Updated compliance form', '2021-01-28 21:21:59', '2021-01-28 21:21:59'),
(568, 48, 'iKpSPDwGdNI2Tdod', 'Updated compliance form', '2021-01-28 21:27:36', '2021-01-28 21:27:36'),
(569, 41, 'MCpciGrKF5y18Fcy', 'Terminated Virtual Card #VC-ZA7hEb', '2021-01-31 14:44:06', '2021-01-31 14:44:06'),
(570, 41, 'oBQ3pGLR68SH4DI9', 'Updated compliance form', '2021-02-02 19:19:07', '2021-02-02 19:19:07'),
(571, 41, 'SC-ylXWxD', 'Received payment for Payment LinkSC-525n8z', '2021-02-03 19:10:19', '2021-02-03 19:10:19'),
(572, 41, 'SC-XhfcaV', 'Received payment for Payment LinkSC-525n8z', '2021-02-03 20:08:11', '2021-02-03 20:08:11'),
(573, 41, 'SC-62KbEF', 'Received payment for Payment LinkSC-525n8z', '2021-02-03 20:11:29', '2021-02-03 20:11:29'),
(574, 41, 'tfenYKFZrCLG15qM', 'Payment for SC-525n8z was successful', '2021-02-06 12:03:41', '2021-02-06 12:03:41'),
(575, 41, 'eHBFAkbhGIo9Cx74', 'Received payment for Payment LinkSC-525n8z', '2021-02-06 12:03:41', '2021-02-06 12:03:41'),
(576, 41, '8l9u7L60jNZaYmBe', 'Payment for SC-525n8z was successful', '2021-02-06 12:59:04', '2021-02-06 12:59:04'),
(577, 41, 'oz649dypgCi40QNB', 'Received payment for Payment LinkSC-525n8z', '2021-02-06 12:59:04', '2021-02-06 12:59:04'),
(578, 41, 'hppQQt3Zslv17Ggz', 'Payment for SC-525n8z was successful', '2021-02-06 13:00:04', '2021-02-06 13:00:04'),
(579, 41, 'SKazRV2ZXf0iYbvF', 'Received payment for Payment LinkSC-525n8z', '2021-02-06 13:00:04', '2021-02-06 13:00:04'),
(580, 41, 'k52UW3Asoh9TIBPR', 'Payment for SC-525n8z was successful', '2021-02-06 13:44:40', '2021-02-06 13:44:40'),
(581, 41, 'HtoscfcVMbHXjSED', 'Received payment for Payment LinkSC-525n8z', '2021-02-06 13:44:40', '2021-02-06 13:44:40'),
(582, 41, 'SC-xSm4IU', 'Received payment for Payment LinkuLbtGuqp2UNdkDnL', '2021-02-06 14:27:33', '2021-02-06 14:27:33'),
(583, 41, 'SC-Gud6d6', 'Received payment for Payment LinkuLbtGuqp2UNdkDnL', '2021-02-06 14:30:18', '2021-02-06 14:30:18'),
(584, 41, 'rgJfqGZVJYuNyvnM', 'Donation for xufj59LTUjUS6TZ5 was successful', '2021-02-06 16:28:15', '2021-02-06 16:28:15'),
(585, 41, '5pDbJlpGLKAUPEOp', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2021-02-06 16:28:15', '2021-02-06 16:28:15'),
(586, 41, '7H2RPEoiKNZ0Ftpj', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2021-02-06 16:46:25', '2021-02-06 16:46:25'),
(587, 41, 'pL9ypCDI095j8fsg', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2021-02-06 16:47:06', '2021-02-06 16:47:06'),
(588, 41, '9TSoWayByviudMqO', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2021-02-06 16:49:54', '2021-02-06 16:49:54'),
(589, 41, 'SC-98VvC4', 'Received payment for Payment LinkSC-525n8z', '2021-02-07 10:15:03', '2021-02-07 10:15:03'),
(590, 41, 'SC-YVfVY3', 'Received payment for Payment LinkSC-525n8z', '2021-02-07 10:50:53', '2021-02-07 10:50:53'),
(591, 41, 'SC-qdhDLt', 'Received payment for Payment LinkSC-525n8z', '2021-02-07 12:21:50', '2021-02-07 12:21:50'),
(592, 41, 'SC-nHd5zQ', 'Received payment for Payment LinkSC-525n8z', '2021-02-07 12:22:41', '2021-02-07 12:22:41'),
(593, 41, 'x6JIMlpKMF0uohey', 'Received payment for order #ORD-DnW6Xd', '2021-02-07 15:16:48', '2021-02-07 15:16:48'),
(594, 41, 'TIxEHGvRDPHUJ7C1', 'Received payment for order #ORD-qbRWn7', '2021-02-07 15:20:21', '2021-02-07 15:20:21'),
(595, 41, 'MER-CvM6eB', 'Payment for MER-CvM6eB was successful', '2021-02-09 20:05:15', '2021-02-09 20:05:15'),
(596, 41, 'MER-NXQ1Sl', 'Received Payment for MER-NXQ1Sl was successful', '2021-02-09 20:16:02', '2021-02-09 20:16:02'),
(597, 41, 'SC-jiEwOY', 'Received payment for Payment LinkSC-525n8z', '2021-02-15 14:29:26', '2021-02-15 14:29:26'),
(598, 41, 'SC-Q66H8O', 'Received payment for Payment LinkSC-525n8z', '2021-02-15 14:56:02', '2021-02-15 14:56:02'),
(599, 41, 'SC-6h4u2G', 'Received payment for Payment LinkSC-6h4u2G', '2021-02-15 16:16:57', '2021-02-15 16:16:57'),
(600, 41, 'SC-6h4u2G', 'Received payment for Payment LinkSC-6h4u2G', '2021-02-15 16:17:36', '2021-02-15 16:17:36'),
(601, 41, 'SC-ppmjNW', 'Received payment for Payment LinkSC-ppmjNW', '2021-02-15 16:23:00', '2021-02-15 16:23:00'),
(602, 41, 'SC-kSGeOK', 'Received payment for Payment LinkSC-kSGeOK', '2021-02-15 16:31:05', '2021-02-15 16:31:05'),
(603, 41, 'SC-Wm10Bi', 'Received payment for Payment LinkSC-Wm10Bi', '2021-02-15 16:32:09', '2021-02-15 16:32:09'),
(604, 41, 'SC-Wm10Bi', 'Received payment for Payment LinkSC-Wm10Bi', '2021-02-15 16:32:15', '2021-02-15 16:32:15'),
(605, 41, 'AfzqrahrRieCT7z2', 'Received Donation for Payment LinkDN-YjbEuN', '2021-02-16 03:42:36', '2021-02-16 03:42:36'),
(606, 41, 'DN-nqHSOu', 'Received payment for Payment LinkDN-nqHSOu', '2021-02-16 03:45:32', '2021-02-16 03:45:32'),
(607, 41, 'DN-nqHSOu', 'Received payment for Payment LinkDN-nqHSOu', '2021-02-16 03:46:33', '2021-02-16 03:46:33'),
(608, 41, 'DN-nqHSOu', 'Received payment for Payment LinkDN-nqHSOu', '2021-02-16 03:46:35', '2021-02-16 03:46:35'),
(609, 41, 'DN-tFE9d8', 'Received payment for Payment LinkDN-tFE9d8', '2021-02-16 03:51:08', '2021-02-16 03:51:08'),
(610, 41, 'xoFOCGbBp5McP0um', 'Received payment for order #ORD-68SFl2', '2021-02-16 04:01:12', '2021-02-16 04:01:12'),
(611, 41, 'z7dBof9U9l71r7AO', 'Received payment for order #ORD-XyDNMv', '2021-02-16 04:23:08', '2021-02-16 04:23:08'),
(612, 41, '4hUvSAnqCVwfiAZk', 'Received payment for order #ORD-3LX2y6', '2021-02-16 04:34:30', '2021-02-16 04:34:30'),
(613, 41, 'wdm4a9hVJO0uRHra', 'Received payment for order #ORD-B5jhhb', '2021-02-16 04:34:32', '2021-02-16 04:34:32'),
(614, 41, 'GnT94mkUKrWLiEMr', 'Received payment for order #ORD-jdDmRv', '2021-02-16 04:34:33', '2021-02-16 04:34:33'),
(615, 41, 'zvoruhrMq6tcubnp', 'Received payment for order #ORD-fcBpxT', '2021-02-16 04:34:34', '2021-02-16 04:34:34'),
(616, 41, 'H6fretvDtgq8BhX1', 'Received payment for order #ORD-Yih6OB', '2021-02-16 04:34:36', '2021-02-16 04:34:36'),
(617, 41, 'M0LpLnoO6bQ83vCk', 'Received payment for order #ORD-R9liK1', '2021-02-16 04:34:37', '2021-02-16 04:34:37'),
(618, 41, 'h1CJFYOxWr5I4DfU', 'Received payment for order #ORD-yMnxTX', '2021-02-16 04:34:38', '2021-02-16 04:34:38'),
(619, 41, 'SUZ8SDZd728kNwV6', 'Received payment for order #ORD-4OgNAI', '2021-02-16 04:34:39', '2021-02-16 04:34:39'),
(620, 41, 'xZ4g1pY20JSzcJZ5', 'Received payment for order #ORD-9VhT5u', '2021-02-16 04:34:41', '2021-02-16 04:34:41'),
(621, 41, 'C8kGYM4vcSPC6Ch6', 'Received payment for order #ORD-YRl1Mv', '2021-02-16 04:34:42', '2021-02-16 04:34:42'),
(622, 41, 'olKQ0FE1W6QS1tqg', 'Received payment for order #ORD-Igvd4Y', '2021-02-16 04:34:43', '2021-02-16 04:34:43'),
(623, 41, '5L8MitlqIi9Z8GZz', 'Received payment for order #ORD-PwiUzw', '2021-02-16 04:34:45', '2021-02-16 04:34:45'),
(624, 41, 'IrdLQS4qprohG6Of', 'Received payment for order #ORD-3rEvW6', '2021-02-16 04:34:46', '2021-02-16 04:34:46'),
(625, 41, 'B8Nc1JvuTrV7BRrd', 'Received payment for order #ORD-GifvaJ', '2021-02-16 04:34:47', '2021-02-16 04:34:47'),
(626, 41, 'mwrLlfyT5v0mcg8x', 'Received payment for order #ORD-aNyBMt', '2021-02-16 04:34:49', '2021-02-16 04:34:49'),
(627, 41, 'pkkoBYNee7gCqVXf', 'Received payment for order #ORD-AXBppM', '2021-02-16 04:34:50', '2021-02-16 04:34:50'),
(628, 41, 'sRfiz5MdwlLaCGmr', 'Received payment for order #ORD-KoDZyt', '2021-02-16 04:34:52', '2021-02-16 04:34:52'),
(629, 41, 'XQBWDtO0vA21cfnM', 'Received payment for order #ORD-Bj56aF', '2021-02-16 04:34:53', '2021-02-16 04:34:53'),
(630, 41, '8KmkChUHZ5pRd739', 'Received payment for order #ORD-UhKHJm', '2021-02-16 04:34:54', '2021-02-16 04:34:54'),
(631, 41, 'bPZCit6MfgQX41E3', 'Received payment for order #ORD-rW1y86', '2021-02-16 04:34:56', '2021-02-16 04:34:56'),
(632, 41, '75VgkAUeAnUURw86', 'Received payment for order #ORD-1cPpnE', '2021-02-16 04:34:57', '2021-02-16 04:34:57'),
(633, 41, 'I5UDad1tV9ekrXSy', 'Received payment for order #ORD-PCxVWE', '2021-02-16 04:36:04', '2021-02-16 04:36:04'),
(634, 41, '2HXx6AlYBdq2enZy', 'Received payment for order #ORD-Mpt6Hs', '2021-02-16 04:36:05', '2021-02-16 04:36:05'),
(635, 41, 'c0BgCqsXzQwDPV57', 'Received payment for order #ORD-asf64O', '2021-02-16 04:36:07', '2021-02-16 04:36:07'),
(636, 41, 'wn5pfwf3JYXhRfig', 'Received payment for order #ORD-NN9wCX', '2021-02-16 04:36:08', '2021-02-16 04:36:08'),
(637, 41, 'j4c7MiUmOG5AS6br', 'Received payment for order #ORD-q3H8Ps', '2021-02-16 04:36:09', '2021-02-16 04:36:09'),
(638, 41, 'hX8IYFmJ61ZTEylh', 'Received payment for order #ORD-w5HDGZ', '2021-02-16 04:36:11', '2021-02-16 04:36:11'),
(639, 41, 'qsEYARYBaoPwpzZu', 'Received payment for order #ORD-mpcbEi', '2021-02-16 04:36:12', '2021-02-16 04:36:12'),
(640, 41, 'kZxpzrvBj5gijPmq', 'Received payment for order #ORD-VlE5HI', '2021-02-16 04:36:13', '2021-02-16 04:36:13'),
(641, 41, 'yId1FIz40AAPyEdU', 'Received payment for order #ORD-ZTRBYq', '2021-02-16 04:36:15', '2021-02-16 04:36:15'),
(642, 41, 'wYTpdWPB6xocuVAK', 'Received payment for order #ORD-oH6aSP', '2021-02-16 04:36:16', '2021-02-16 04:36:16'),
(643, 41, 'OjArLIsa3KJRYXsQ', 'Received payment for order #ORD-NFnn6W', '2021-02-16 04:36:18', '2021-02-16 04:36:18'),
(644, 41, 'pNs2WIB3cX1ne6Oj', 'Received payment for order #ORD-oMrALk', '2021-02-16 04:36:19', '2021-02-16 04:36:19'),
(645, 41, 'J7N5Pki5y8WbHzxk', 'Received payment for order #ORD-w8O9V3', '2021-02-16 04:36:20', '2021-02-16 04:36:20'),
(646, 41, 'fDBo0m4GuFH93zza', 'Received payment for order #ORD-iC374u', '2021-02-16 04:36:22', '2021-02-16 04:36:22'),
(647, 41, 'J9yfGv8Fr4unFfkQ', 'Received payment for order #ORD-GOVy9I', '2021-02-16 04:36:23', '2021-02-16 04:36:23'),
(648, 41, 'U5tCVHsuM8S2cRGd', 'Received payment for order #ORD-QJkEvc', '2021-02-16 04:36:24', '2021-02-16 04:36:24'),
(649, 41, 'SMu9YH0mJLdWvYCN', 'Received payment for order #ORD-XzWvxq', '2021-02-16 04:36:26', '2021-02-16 04:36:26'),
(650, 41, 'OwdOf8uKDNr20uoi', 'Received payment for order #ORD-bRaVPI', '2021-02-16 04:36:27', '2021-02-16 04:36:27'),
(651, 41, 'KgYUjWgukGR9JuFC', 'Received payment for order #ORD-bnjwzR', '2021-02-16 04:36:31', '2021-02-16 04:36:31'),
(652, 41, '2skeHnP9IpDyUTOr', 'Received payment for order #ORD-TWS8wk', '2021-02-16 04:36:32', '2021-02-16 04:36:32'),
(653, 41, 'IYRI1tpeb3lHOOdl', 'Received payment for order #ORD-mzW5SP', '2021-02-16 04:36:34', '2021-02-16 04:36:34'),
(654, 41, 'iY1J5dlnoIWGx1dh', 'Received payment for order #ORD-a9RsEe', '2021-02-16 04:39:19', '2021-02-16 04:39:19'),
(655, 41, 'nM3OUcVY2t6Uxzhs', 'Received payment for order #ORD-RowoOT', '2021-02-16 04:39:21', '2021-02-16 04:39:21'),
(656, 41, 'm5fBQbkpf3b3zu6n', 'Received payment for order #ORD-l4dgXM', '2021-02-16 04:39:22', '2021-02-16 04:39:22'),
(657, 41, '1z55xpF4Uo18CQgL', 'Received payment for order #ORD-R9lLv5', '2021-02-16 04:39:23', '2021-02-16 04:39:23'),
(658, 41, 'AJiB4LMpNWzZBxDe', 'Received payment for order #ORD-7pLaCq', '2021-02-16 04:39:25', '2021-02-16 04:39:25'),
(659, 41, 'IyDjD7LVn44IDWYI', 'Received payment for order #ORD-RPrQ9y', '2021-02-16 04:39:26', '2021-02-16 04:39:26'),
(660, 41, 'G0XMJx3Bcc05bS6J', 'Received payment for order #ORD-e18mbO', '2021-02-16 04:39:27', '2021-02-16 04:39:27'),
(661, 41, 'OBXGy3uHgFhTqPTt', 'Received payment for order #ORD-uNk6bO', '2021-02-16 04:39:29', '2021-02-16 04:39:29'),
(662, 41, 'nAtLoVr24z9ICPJy', 'Received payment for order #ORD-lboM22', '2021-02-16 04:39:30', '2021-02-16 04:39:30'),
(663, 41, 'hr9pfcPoRRhW0QS9', 'Received payment for order #ORD-iMTB3u', '2021-02-16 04:39:31', '2021-02-16 04:39:31'),
(664, 41, 'TiHsKwJIANo7gtkQ', 'Received payment for order #ORD-lADPoj', '2021-02-16 04:39:33', '2021-02-16 04:39:33'),
(665, 41, 'yDh2G7TPZkNMl0CX', 'Received payment for order #ORD-eRp6gs', '2021-02-16 04:39:34', '2021-02-16 04:39:34'),
(666, 41, '5cvVnFCSaJDZuRPB', 'Received payment for order #ORD-URB0tU', '2021-02-16 04:39:35', '2021-02-16 04:39:35'),
(667, 41, '3a1RA5Sw8zpSLqtZ', 'Received payment for order #ORD-KJY2mb', '2021-02-16 04:39:37', '2021-02-16 04:39:37'),
(668, 41, 'bIE7egQgRc4NMeU7', 'Received payment for order #ORD-OXYvuG', '2021-02-16 04:39:38', '2021-02-16 04:39:38'),
(669, 41, 'KQ6hEDPwh5B9kHCC', 'Received payment for order #ORD-qOfh9a', '2021-02-16 04:39:39', '2021-02-16 04:39:39'),
(670, 41, 'i2cj9TPIvqyDT8hk', 'Received payment for order #ORD-goVz9B', '2021-02-16 04:39:40', '2021-02-16 04:39:40'),
(671, 41, 'cFiY15BrVIx2bVFn', 'Received payment for order #ORD-bJ50dh', '2021-02-16 04:39:42', '2021-02-16 04:39:42'),
(672, 41, 'PsRjKRfdtlnirHSD', 'Received payment for order #ORD-uBgmt7', '2021-02-16 04:39:43', '2021-02-16 04:39:43'),
(673, 41, 'wEj0zpfkpRn8sk5c', 'Received payment for order #ORD-ehr6MO', '2021-02-16 04:39:44', '2021-02-16 04:39:44'),
(674, 41, '3QOw5q5tDT4gFaB6', 'Received payment for order #ORD-PKrnn2', '2021-02-16 04:39:45', '2021-02-16 04:39:45'),
(675, 41, 'EP3zgekZ7l6Somre', 'Received payment for order #ORD-75tB9c', '2021-02-16 04:43:08', '2021-02-16 04:43:08'),
(676, 41, 'oFbt9k5w2R5oKV0O', 'Created Funding Request of 100USD via Card', '2021-02-16 05:09:20', '2021-02-16 05:09:20'),
(677, 41, 'wOq0dp2DPEiManLt', 'Created Funding Request of 100USD via Card', '2021-02-16 05:09:52', '2021-02-16 05:09:52'),
(678, 41, 'S6mrrUdvvoYgk27J', 'Verified Funding Request of 101USD via Card', '2021-02-16 05:11:29', '2021-02-16 05:11:29'),
(679, 59, '0clz6EEZHSB5T4EI', 'Updated compliance form', '2021-02-17 16:33:10', '2021-02-17 16:33:10'),
(680, 59, 'feIp1FBwWaroYDjJ', 'Updated compliance form', '2021-02-17 16:37:40', '2021-02-17 16:37:40'),
(681, 59, 'ufdEynxlf1m2FutV', 'Updated compliance form', '2021-02-17 17:28:19', '2021-02-17 17:28:19'),
(682, 59, 'w4ojWKbnzpyU8wRU', 'Updated compliance form', '2021-02-17 17:43:10', '2021-02-17 17:43:10'),
(683, 60, 'avoS57iFBFxu72Pa', 'Updated compliance form', '2021-02-17 18:47:01', '2021-02-17 18:47:01'),
(684, 41, 'RQ-81YG2K', 'Requested $12.5 from support@boomchart.net', '2021-02-18 07:32:17', '2021-02-18 07:32:17'),
(685, 41, 'RQ-TzubDD', 'Requested $30.67 from support@boomchart.net', '2021-02-18 08:01:59', '2021-02-18 08:01:59'),
(686, 41, 'TR-Fal4c5', 'Transfered $10245 to support@boomchart.net', '2021-02-18 08:19:34', '2021-02-18 08:19:34'),
(687, 41, 'SUB-337uCi', 'Created Plan -  Blockchain', '2021-02-18 18:05:31', '2021-02-18 18:05:31'),
(688, 59, 'JPxoVcZSaINOPbJz', 'Payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-02-18 19:01:59', '2021-02-18 19:01:59'),
(689, 41, 'TDPwe6H12tDcipfd', 'Received payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-02-18 19:01:59', '2021-02-18 19:01:59'),
(690, 59, '7V7UVRsynEBj6ZQv', 'Payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-02-18 19:06:21', '2021-02-18 19:06:21'),
(691, 41, 'hI4QunojosXnUiy4', 'Received payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-02-18 19:06:21', '2021-02-18 19:06:21'),
(692, 41, 'xtq6QeY29D1OqnIN', 'Payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-02-22 04:42:34', '2021-02-22 04:42:34'),
(693, 41, 'Gj8k2Dw7MVy9zJwY', 'Received payment for subscription #1Udf0bj465M9ecoz - Dog food was successful', '2021-02-22 04:42:34', '2021-02-22 04:42:34'),
(694, 59, 'abu7swt14uYYXZ7l', 'Payment for subscription #PLAN-n0SjNy - Map was successful', '2021-02-22 04:45:03', '2021-02-22 04:45:03'),
(695, 41, 'ou2KWd7bTSPXNcP1', 'Received payment for subscription #PLAN-n0SjNy - Map was successful', '2021-02-22 04:45:03', '2021-02-22 04:45:03'),
(696, 41, 'nHeIgiC8G52H3rRG', 'Payment for SC-525n8z was successful', '2021-02-22 09:45:31', '2021-02-22 09:45:31'),
(697, 41, 'bkGC8lurTtjV4qy6', 'Received payment for Payment LinkSC-525n8z', '2021-02-22 09:45:31', '2021-02-22 09:45:31'),
(698, 59, 'zxdpbHdlr2dE4F2o', 'Payment for SC-525n8z was successful', '2021-02-22 09:46:34', '2021-02-22 09:46:34'),
(699, 41, 'SMX0xncQcZbx8l66', 'Received payment for Payment LinkSC-525n8z', '2021-02-22 09:46:34', '2021-02-22 09:46:34'),
(700, 59, 'elVDF85SdtKo2Wed', 'Donation for xufj59LTUjUS6TZ5 was successful', '2021-02-22 09:56:07', '2021-02-22 09:56:07'),
(701, 41, 'v2kW90Bs7ZOParSH', 'Received Donation for Payment Linkxufj59LTUjUS6TZ5', '2021-02-22 09:56:07', '2021-02-22 09:56:07'),
(702, 41, 'TR-LP3mZU', 'Transfered $1324.56 to freakboss3@gmail.com', '2021-02-22 11:22:18', '2021-02-22 11:22:18'),
(703, 41, 'TR-CTJTae', 'Transfered $1245.34 to freakboss3@gmail.com', '2021-02-22 11:22:45', '2021-02-22 11:22:45'),
(704, 41, 'iJD7YFTPkD9Me74H', 'Received payment for order #ORD-ufT6r3', '2021-02-22 13:13:22', '2021-02-22 13:13:22'),
(705, 62, 'TR-0rPHF8', 'Transfered $1000 to demo@boomchart.net', '2021-02-23 14:29:56', '2021-02-23 14:29:56'),
(706, 41, 'RQ-akGBDC', 'Requested $300 from support@boomchart.net', '2021-02-24 09:21:55', '2021-02-24 09:21:55'),
(707, 63, 'AlEOvbqSI6dnztnU', 'Terminated Virtual Card #VC-pOBkBz', '2021-03-19 17:40:51', '2021-03-19 17:40:51'),
(708, 63, 'caAnCaXGYieLPto4', 'Terminated Virtual Card #VC-2AzG5i', '2021-03-20 09:14:35', '2021-03-20 09:14:35'),
(709, 63, 'Q34NEVNxBIeeghXt', 'Blocked Virtual Card #VC-tlKOZt', '2021-03-20 09:22:33', '2021-03-20 09:22:33'),
(710, 63, 'XKBOtlCODRVpNiXm', 'Blocked Virtual Card #VC-tlKOZt', '2021-03-20 09:23:13', '2021-03-20 09:23:13'),
(711, 63, 'VOripfCe9p7AlyOV', 'Blocked Virtual Card #VC-tlKOZt', '2021-03-20 09:31:03', '2021-03-20 09:31:03'),
(712, 63, 'glErfVU7LGcGwY2h', 'Blocked Virtual Card #VC-0cpMQ6', '2021-03-20 09:32:35', '2021-03-20 09:32:35'),
(713, 63, 'jYBryQI2EIieJUdY', 'Terminated Virtual Card #VC-1ItEYj', '2021-03-20 09:40:56', '2021-03-20 09:40:56'),
(714, 63, 'vryrCVcVICUEnxHu', 'Blocked Virtual Card #VC-tlKOZt', '2021-03-20 10:06:32', '2021-03-20 10:06:32'),
(715, 63, '53lrXa6c6KCBW2h4', 'Blocked Virtual Card #VC-0cpMQ6', '2021-03-20 20:52:28', '2021-03-20 20:52:28'),
(716, 63, 'efB5mCc8YWvv3WCX', 'Changed Password', '2021-04-17 06:30:32', '2021-04-17 06:30:32'),
(717, 64, '7kXRBBgtvds9ub8j', 'Payment for Invoice - INV-iWHp9x was successful', '2022-07-27 04:21:12', '2022-07-27 04:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `bank_id` int(32) DEFAULT NULL,
  `acct_no` varchar(32) DEFAULT NULL,
  `acct_name` text,
  `account_type` text,
  `routing_number` text,
  `status` int(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `user_id`, `bank_id`, `acct_no`, `acct_name`, `account_type`, `routing_number`, `status`, `created_at`, `updated_at`) VALUES
(28, 58, 7, '3245678542', 'adsfg asdfgh', 'company', '2134567854', 1, '2021-02-13 22:04:05', '2021-02-13 21:04:05'),
(32, 63, 7, '12345678543', 'Very good security', 'individual', NULL, 1, '2021-03-19 17:11:59', '2021-03-19 17:11:59'),
(33, 64, 6, '111111', 'Vagner', 'individual', '111111', 1, '2022-06-08 17:22:35', '2022-06-08 17:22:35');

-- --------------------------------------------------------

--
-- Table structure for table `bank_supported`
--

CREATE TABLE `bank_supported` (
  `id` int(32) NOT NULL,
  `name` text NOT NULL,
  `code` text NOT NULL,
  `country_id` int(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank_supported`
--

INSERT INTO `bank_supported` (`id`, `name`, `code`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Zenith Bank', '033', 156, '2021-01-23 11:25:05', '2021-01-23 11:25:05'),
(2, 'First Bank', '012', 13, '2021-01-23 11:35:59', '2021-01-23 11:35:59'),
(3, 'GTB', '22d', 156, '2021-01-23 11:26:24', '2021-01-23 11:26:24'),
(5, 'Castro Bank', '2233', 226, '2021-01-23 11:32:50', '2021-01-23 11:32:50'),
(6, 'Citibank', '2232', 226, '2021-01-23 11:32:50', '2021-01-23 11:32:50'),
(7, 'Citi bannk', '232', 80, '2021-02-13 20:25:48', '2021-02-13 20:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `bank_transfer`
--

CREATE TABLE `bank_transfer` (
  `id` int(11) NOT NULL,
  `user_id` int(32) NOT NULL,
  `trx` varchar(32) DEFAULT NULL,
  `amount` varchar(32) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `status` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_transactions`
--

CREATE TABLE `bill_transactions` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `type` int(1) NOT NULL,
  `amount` varchar(32) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `charge` varchar(32) NOT NULL,
  `biller` text,
  `ref` varchar(32) NOT NULL,
  `track` varchar(64) NOT NULL,
  `trx_ref` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(32) NOT NULL,
  `name` text NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `zip_code` int(32) NOT NULL,
  `postal_code` varchar(32) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `country`, `state`, `mobile`, `zip_code`, `postal_code`, `address`, `created_at`, `updated_at`) VALUES
(3, 'Histol', 'Indonesia', 'Georgia', '43567865433567', 4365443, '3454447567', 'Hell', '2020-02-09 09:38:48', '2020-02-09 08:38:48'),
(4, 'Bilson', 'Antigua & Barbuda', 'Georgia', '13245678786', 300216, '2423', 'Sekupang Batamg', '2020-01-27 19:49:41', '0000-00-00 00:00:00'),
(6, 'Manchester', 'England', 'Bigboss', '13245678786', 300216, '2423', '47 Nungua Link Road 2nd Floor', '2020-01-27 19:49:41', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(32) NOT NULL,
  `image` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` int(2) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `image`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 'brand_1595624243.png', 'Capterra', 1, '2020-07-24 20:57:23', '2020-07-24 19:57:23'),
(2, 'brand_1595624257.png', 'crowd', 1, '2020-07-24 20:57:37', '2020-07-24 19:57:37'),
(3, 'brand_1595624229.png', 'Getapp', 1, '2020-07-24 20:57:09', '2020-07-24 19:57:09'),
(4, 'brand_1595624268.png', 'softwareadvice', 1, '2020-07-24 20:57:48', '2020-07-24 19:57:48'),
(5, 'brand_1613500498.png', 'trustpilot', 1, '2021-02-16 18:34:58', '2021-02-16 17:34:58');

-- --------------------------------------------------------

--
-- Table structure for table `btc_trades`
--

CREATE TABLE `btc_trades` (
  `id` int(32) NOT NULL,
  `user_id` int(32) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `trx` varchar(16) DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `total` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `bank` int(32) DEFAULT NULL,
  `amount` varchar(32) DEFAULT NULL,
  `wallet` text,
  `status` int(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `uniqueid` varchar(255) DEFAULT NULL,
  `product` int(11) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `store` int(32) DEFAULT NULL,
  `total` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `uniqueid`, `product`, `title`, `quantity`, `cost`, `rate`, `currency`, `store`, `total`) VALUES
(184, 'VSsJA0T', 16, 'Baby Towel', 3, 20000, NULL, NULL, NULL, NULL),
(185, 'VSsJA0T', 15, 'Bottle', 1, 20000, NULL, NULL, NULL, NULL),
(186, 'VSsJA0T', 7, 'Lg Tv 2.0', 1, 300000, NULL, NULL, NULL, NULL),
(187, 'VSsJA0T', 6, '2020 Camry SE', 1, 2500000, NULL, NULL, 1, NULL),
(189, 'rNzA6fl', 15, 'Bottle', 3, 20000, NULL, NULL, 1, '60000'),
(200, 'P2aGXCZ', 9, 'Fish', 1, 2000, NULL, NULL, 3, '2000'),
(201, 'NwIfW6x', 9, 'Fish', 3, 2000, NULL, NULL, 3, '6000'),
(202, 'M5dV8pl', 9, 'Fish', 1, 2000, NULL, NULL, 3, '2000'),
(203, 'r5oUpd5', 9, 'Fish', 3, 2000, NULL, NULL, 3, '6000'),
(204, 'BjREcXy', 9, 'Fish', 2, 2000, NULL, NULL, 3, '4000'),
(205, 'ccaixXO', 7, 'Lg Tv 2.0', 1, 300000, NULL, NULL, 1, '300000'),
(206, 'pb9KuaD', 15, 'Bottle', 1, 20000, NULL, NULL, 1, '20000'),
(207, 'pb9KuaD', 6, '2020 Camry SE', 1, 2500000, NULL, NULL, 1, '2500000'),
(208, 'TuCtVsk', 17, 'Bread', 1, 10000, NULL, NULL, 4, '10000'),
(209, 'czPW7f2', 15, 'Bottle', 1, 20000, NULL, NULL, 1, '20000'),
(210, 'hMxZyv4', 15, 'Bottle', 2, 20000, NULL, NULL, 1, '40000'),
(211, 'hMxZyv4', 6, '2020 Camry SE', 2, 2500000, NULL, NULL, 1, '5000000'),
(212, 'yy51qym', 15, 'Bottle', 1, 20000, NULL, NULL, 1, '20000'),
(213, 'yy51qym', 6, '2020 Camry SE', 1, 2500, NULL, NULL, 1, '2500');

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `amount` varchar(32) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `real_amount` varchar(32) DEFAULT NULL,
  `tx_ref` varchar(32) DEFAULT NULL,
  `type` varchar(32) DEFAULT NULL,
  `finn` int(1) DEFAULT NULL,
  `ref_id` varchar(32) NOT NULL,
  `log` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `charges`
--

INSERT INTO `charges` (`id`, `user_id`, `amount`, `rate`, `currency`, `real_amount`, `tx_ref`, `type`, `finn`, `ref_id`, `log`, `created_at`, `updated_at`) VALUES
(474, 63, '25.1', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-pOBkBz', 'Virtual Card creation charge #', '2021-03-19 17:14:57', '2021-03-19 17:14:57'),
(475, 63, '4.49', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-y3Inv5', 'Virtual Card funding charge #', '2021-03-19 17:15:26', '2021-03-19 17:15:26'),
(476, 63, '5.135', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-hqIpoL', 'Virtual Card funding charge #', '2021-03-19 17:22:10', '2021-03-19 17:22:10'),
(477, 63, '4.49', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-SeP6L3', 'Virtual Card funding charge #', '2021-03-19 17:23:14', '2021-03-19 17:23:14'),
(478, 63, '5.15', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-tlKOZt', 'Virtual Card creation charge #', '2021-03-20 05:55:10', '2021-03-20 05:55:10'),
(479, 63, '4.06', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-kGMDSf', 'Virtual Card funding charge #', '2021-03-20 05:57:45', '2021-03-20 05:57:45'),
(480, 63, '7.5', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-abBbVi', 'Virtual Card funding charge #', '2021-03-20 05:58:58', '2021-03-20 05:58:58'),
(481, 63, '5.72', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-0cpMQ6', 'Virtual Card creation charge #', '2021-03-20 06:36:14', '2021-03-20 06:36:14'),
(482, 63, '6.86', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-2AzG5i', 'Virtual Card creation charge #', '2021-03-20 06:37:44', '2021-03-20 06:37:44'),
(483, 63, '6.86', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-eAJdYs', 'Virtual Card creation charge #', '2021-03-20 06:43:44', '2021-03-20 06:43:44'),
(484, 63, '4.06', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-7FoWac', 'Virtual Card funding charge #', '2021-03-20 07:10:00', '2021-03-20 07:10:00'),
(485, 63, '4.06', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-4b3pyB', 'Virtual Card funding charge #', '2021-03-20 07:10:34', '2021-03-20 07:10:34'),
(486, 63, '13.7', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-1ItEYj', 'Virtual Card creation charge #', '2021-03-20 09:40:30', '2021-03-20 09:40:30'),
(487, 63, '4.49', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-H0REau', 'Virtual Card funding charge #', '2021-03-20 09:57:50', '2021-03-20 09:57:50'),
(488, 63, '3.63', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-jwQzX1', 'Virtual Card funding charge #', '2021-03-20 09:59:34', '2021-03-20 09:59:34'),
(489, 63, '7.5', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-YmFawi', 'Virtual Card funding charge #', '2021-03-20 10:32:40', '2021-03-20 10:32:40'),
(490, 63, '17.046', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-7ZwQk7', 'Virtual Card funding charge #', '2021-03-20 10:40:06', '2021-03-20 10:40:06'),
(491, 63, '19.4', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-BHRhYk', 'Virtual Card creation charge #', '2021-03-20 14:08:16', '2021-03-20 14:08:16'),
(492, 63, '20.597', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-JbFqnC', 'Virtual Card creation charge #', '2021-03-20 14:28:11', '2021-03-20 14:28:11'),
(493, 63, '21.965', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-aCyGjR', 'Virtual Card creation charge #', '2021-03-20 20:51:38', '2021-03-20 20:51:38'),
(494, 63, '7.5', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-KCU0Ls', 'Virtual Card funding charge #', '2021-03-20 20:53:26', '2021-03-20 20:53:26'),
(495, 63, '5.15', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-vywam6', 'Virtual Card creation charge #', '2021-03-21 11:40:38', '2021-03-21 11:40:38'),
(496, 63, '4.06', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-7GfY65', 'Virtual Card funding charge #', '2021-03-21 11:44:19', '2021-03-21 11:44:19'),
(497, 63, '4.49', NULL, NULL, NULL, NULL, NULL, NULL, 'VC-8xMWOF', 'Virtual Card withdraw charge #', '2021-03-21 11:45:47', '2021-03-21 11:45:47'),
(498, 64, '7.6', NULL, NULL, NULL, NULL, NULL, NULL, 'INV-zafBCT', 'Charges for invoice #INV-cIUfba', '2022-07-25 01:46:48', '2022-07-25 01:46:48'),
(499, 64, '6.2', NULL, NULL, NULL, NULL, NULL, NULL, 'INV-iWHp9x', 'Charges for invoice #INV-iWHp9x', '2022-07-26 22:09:45', '2022-07-26 22:09:45'),
(500, 64, '6.2', NULL, NULL, NULL, NULL, NULL, NULL, 'INV-ihdR1r', 'Charges for invoice #INV-iWHp9x', '2022-07-27 04:21:12', '2022-07-27 04:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `compliance`
--

CREATE TABLE `compliance` (
  `id` int(32) NOT NULL,
  `user_id` int(32) DEFAULT NULL,
  `first_name` text,
  `last_name` text,
  `day` int(32) DEFAULT NULL,
  `month` varchar(3) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `nationality` text,
  `id_type` varchar(32) DEFAULT NULL,
  `idcard` varchar(32) DEFAULT NULL,
  `address` text,
  `website` text,
  `country` text,
  `state` text,
  `city` text,
  `office_address` text,
  `phone` varchar(32) DEFAULT NULL,
  `gender` varchar(32) DEFAULT NULL,
  `business_type` varchar(32) DEFAULT NULL,
  `registration_type` text,
  `industry` text,
  `category` text,
  `staff_size` varchar(32) DEFAULT NULL,
  `description` text,
  `trading_name` text,
  `legal_name` text,
  `proof` varchar(32) DEFAULT NULL,
  `idcard_back` varchar(32) DEFAULT NULL,
  `proof_back` varchar(32) DEFAULT NULL,
  `paddress` varchar(32) DEFAULT NULL,
  `vat_id` text,
  `tax_id` text,
  `document` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `email` text,
  `reg_no` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `compliance`
--

INSERT INTO `compliance` (`id`, `user_id`, `first_name`, `last_name`, `day`, `month`, `year`, `nationality`, `id_type`, `idcard`, `address`, `website`, `country`, `state`, `city`, `office_address`, `phone`, `gender`, `business_type`, `registration_type`, `industry`, `category`, `staff_size`, `description`, `trading_name`, `legal_name`, `proof`, `idcard_back`, `proof_back`, `paddress`, `vat_id`, `tax_id`, `document`, `status`, `email`, `reg_no`, `created_at`, `updated_at`) VALUES
(5, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-07-23 00:24:53', '2022-07-23 00:24:53'),
(6, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-07-23 00:24:53', '2022-07-23 00:24:53'),
(7, 52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-07-23 00:24:53', '2022-07-23 00:24:53'),
(8, 53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-07-23 00:24:53', '2022-07-23 00:24:53'),
(9, 54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-07-23 00:24:53', '2022-07-23 00:24:53'),
(11, 56, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-07-23 00:24:53', '2022-07-23 00:24:53'),
(12, 57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-07-23 00:24:53', '2022-07-23 00:24:53'),
(13, 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-07-23 00:24:53', '2022-07-23 00:24:53'),
(18, 63, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-07-23 00:24:53', '2022-07-23 00:24:53'),
(19, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2022-07-23 00:24:53', '2022-07-23 00:24:53');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `seen` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `full_name`, `mobile`, `email`, `message`, `seen`, `created_at`, `updated_at`) VALUES
(8, 'awserdt', '2345678965', 'd@d.com', 'asdfghj', 0, '2021-02-22 13:06:30', '2021-02-22 13:06:30'),
(9, 'awserdt', '2345678965', 'd@d.com', 'asdfghj', 0, '2021-02-22 13:07:54', '2021-02-22 13:07:54');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
-- Table structure for table `country_supported`
--

CREATE TABLE `country_supported` (
  `id` int(32) NOT NULL,
  `country_id` int(32) NOT NULL,
  `coin_id` int(32) DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `country_supported`
--

INSERT INTO `country_supported` (`id`, `country_id`, `coin_id`, `rate`, `type`, `status`, `created_at`, `updated_at`) VALUES
(5, 80, 38, '1.2', NULL, 1, '2021-02-18 10:32:21', '2021-02-18 09:32:21'),
(8, 226, 124, '1', NULL, 1, '2021-02-18 18:52:55', '2021-02-18 17:52:55'),
(9, 30, NULL, NULL, NULL, 1, '2022-07-06 03:49:46', '2022-07-06 03:49:46');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `symbol` varchar(100) DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `status` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `country`, `currency`, `name`, `symbol`, `rate`, `status`, `created_at`, `updated_at`) VALUES
(18, 'Brazil', 'Reais', 'BRL', 'R$', NULL, 1, '2022-07-06 00:50:24', '2022-07-06 03:50:24'),
(124, 'United States of America', 'Dollars', 'USD', '$', NULL, 0, '2022-07-06 00:50:24', '2022-07-06 03:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `amount` varchar(191) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `payment_id` varchar(32) NOT NULL,
  `date` varchar(32) NOT NULL,
  `status` int(2) NOT NULL,
  `token` int(11) NOT NULL,
  `trans_id` text NOT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `user_id`, `amount`, `rate`, `currency`, `payment_id`, `date`, `status`, `token`, `trans_id`, `details`) VALUES
(29, 11, '100', NULL, NULL, '2', '2019-08-16 13:27:35', 0, 242331, '', ''),
(30, 11, '1000000', NULL, NULL, '2', '2019-08-29 05:18:12', 0, 1567048693, 'zMwZ8WWAasBqbeu7hmMK', 'Paid'),
(31, 11, '0', NULL, NULL, 'Bitcoin', '2019-09-06 17:55:51', 0, 1567785352, 'xpAGtoelWiDdPVgiBMGr', 'Domain purchase');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `gateway_id` int(11) DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_amo` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `secret` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txn_id` text COLLATE utf8mb4_unicode_ci,
  `status_url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `user_id`, `gateway_id`, `amount`, `charge`, `btc_amo`, `btc_wallet`, `trx`, `status`, `secret`, `txn_id`, `status_url`, `created_at`, `updated_at`) VALUES
(330, 63, 108, '101', '1', NULL, NULL, 'afgdjLVKpXGUJlV7', 0, 'Wmf7WAv5', NULL, NULL, '2021-03-22 13:30:59', '2021-03-22 13:30:59'),
(331, 63, 108, '101', '1', NULL, NULL, 'GoiOMgF53fbBIBnb', 1, '21nAuQGI', NULL, NULL, '2021-03-22 13:36:19', '2022-07-06 03:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(16) NOT NULL,
  `user_id` int(16) DEFAULT NULL,
  `amount` varchar(32) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `anonymous` int(1) NOT NULL DEFAULT '0',
  `ref_id` varchar(32) NOT NULL,
  `donation_id` int(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `user_id`, `amount`, `rate`, `currency`, `status`, `anonymous`, `ref_id`, `donation_id`, `created_at`, `updated_at`) VALUES
(15, NULL, '20000', NULL, NULL, 1, 0, 'o3Lte67WR09KwLLc', 7, '2020-09-22 03:15:23', '2020-09-22 02:15:23'),
(22, NULL, '4000', NULL, NULL, 1, 1, 'Z2aSP4hsu1asN9YL', 9, '2020-09-25 16:26:50', '2020-09-25 15:26:50'),
(23, NULL, '10000', NULL, NULL, 1, 1, '13CNtowdkEkRLg36', 9, '2020-09-25 16:44:31', '2020-09-25 15:44:31'),
(44, NULL, '5000', NULL, NULL, 1, 1, '1siwUNWx4SCK2wmu', 17, '2020-12-22 12:28:24', '2020-12-22 12:28:24'),
(45, NULL, '300000', NULL, NULL, 1, 1, 'nSvWnmUy1lcyAFXu', 17, '2020-12-22 12:29:34', '2020-12-22 12:29:34'),
(46, NULL, '30000', NULL, NULL, 1, 1, 'GgGSZ8y7iwaCvwmO', 18, '2020-12-29 14:28:33', '2020-12-29 14:28:33'),
(47, NULL, '3000', NULL, NULL, 0, 0, 'DN-jOqZPA', 20, '2021-01-20 17:39:43', '2021-01-20 17:39:43'),
(48, NULL, '3000', NULL, NULL, 1, 0, 'DN-QKsjbx', 20, '2021-01-20 17:40:39', '2021-01-20 17:40:39'),
(50, NULL, '50000', NULL, NULL, 1, 1, 'DN-sNsDLd', 20, '2021-01-20 18:01:18', '2021-01-20 18:01:18'),
(51, NULL, '3000', NULL, NULL, 0, 0, 'DN-QA0Qxy', 20, '2021-01-20 18:11:00', '2021-01-20 18:11:00'),
(52, NULL, '20000', NULL, NULL, 1, 1, 'DN-5PD6fN', 20, '2021-01-20 18:11:50', '2021-01-20 18:11:50'),
(54, NULL, '3000', NULL, NULL, 1, 1, 'DN-ExHG1w', 20, '2021-01-20 18:18:47', '2021-01-20 18:18:47'),
(57, NULL, '3333', NULL, NULL, 1, 0, 'DN-3g4jkU', 17, '2021-02-06 17:46:25', '2021-02-06 16:46:25'),
(58, NULL, '22', NULL, NULL, 1, 0, 'DN-64WLcM', 17, '2021-02-06 17:47:06', '2021-02-06 16:47:06');

-- --------------------------------------------------------

--
-- Table structure for table `ext_transfer`
--

CREATE TABLE `ext_transfer` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `ip_address` varchar(32) DEFAULT NULL,
  `card_number` varchar(32) DEFAULT NULL,
  `payment_type` varchar(16) DEFAULT NULL,
  `title` text,
  `description` text,
  `quantity` int(32) DEFAULT NULL,
  `reference` varchar(32) DEFAULT NULL,
  `user_id` int(32) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `merchant_key` varchar(32) DEFAULT NULL,
  `callback_url` text,
  `tx_ref` text,
  `status` int(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(32) NOT NULL,
  `question` text NOT NULL,
  `answer` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(43, 'What is corporate internate banking?', '<p>Corporate internet banking is a secure online banking platform that enables cutomers make transfers to anyone in the world, 24 hours a day, 7 days a week</p>', '2020-01-24 22:12:28', '0000-00-00 00:00:00'),
(44, 'Can i update my account details from any branch?', '<p>Yes account update requsests can be made at any of the branches</p>', '2020-01-24 22:12:28', '0000-00-00 00:00:00'),
(45, 'How long does it take before my account becomes inactive?', '<p>Accounts become dormant after 6 months of inactivity</p>', '2020-01-24 22:12:28', '0000-00-00 00:00:00'),
(46, 'Is it possible to open an account in the coutry and operate the account while out of the country?', '<p>Yes, the account can be operated through any of our internet banking solution.</p>', '2020-01-24 22:12:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` int(10) UNSIGNED NOT NULL,
  `main_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateimg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minamo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maxamo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `val1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `val2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `val3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `val4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `main_name`, `name`, `gateimg`, `minamo`, `maxamo`, `charge`, `val1`, `val2`, `val3`, `val4`, `status`, `created_at`, `updated_at`) VALUES
(101, 'Paypal', 'Paypal', 'paypal.png', '20', '200000', '1', 'dafuture355@gmail.com', NULL, NULL, NULL, 1, NULL, '2022-07-06 03:59:08'),
(103, 'Stripe', 'Card', 'stripe.png', '20', '200000', '1', 'pk_test_51HTQdaDV81Cn4OcKSjOuNkqo1KZVr1t3XbQEJvbKlqEOkwDVvcR4SXTeYfwiRatftReH9GHmIcALpTlVRz8SaHib00m65YW6mK', 'sk_test_51HTQdaDV81Cn4OcKm8Gpj26Em9zWcTSOj92zQrJtGHIhBDAqwXbGHxyx2lT8ScfT5iMw58cjLhozVno4y2IDEScY00TAByE3tf', NULL, NULL, 1, NULL, '2021-02-14 21:41:01'),
(107, 'Paystack', 'Paystack', 'paystack.png', '20', '200000', '1', 'pk_live_293d04f581857487ef9b5cd8cd0f843f7728c3be', '', NULL, NULL, 1, NULL, '2021-01-21 11:21:34'),
(108, 'Flutter', 'Flutter', 'flutter.png', '20', '200000', '1', 'FLWPUBK-06d63b05eb29e07b774db3f6dc871b90-X', 'FLWSECK-6b1abf0e8e65353d3c18262706f164ee-X', NULL, NULL, 1, NULL, '2021-01-21 11:21:34'),
(505, 'Bitcoin', 'CoinPayment BTC', 'btc.png', '10', '50000', '3', '9c4a052c343dc0f52a9e468fc4c51fa58a85539fa161bbc56404fb47acfb4e7f', '17A0F59aFefaFf7876C8176626e8c256fE91F2A655b502004297f73a2cd1D761', NULL, NULL, 1, NULL, '2021-01-21 11:24:34'),
(506, 'Ethereum', 'CoinPayment ETH', 'eth.png', '10', '50000', '3', '954466792454d50b4a7235c6b04731f8b3562d85d12ca9782f0ba7e84dbcf28b', '58b485659b7EA60Dbadf247CcD756FFa10900974dbc0acEAC01f2dfd5350dAAF', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `amount` varchar(32) DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `ref` varchar(32) NOT NULL,
  `main` int(1) NOT NULL,
  `type` int(1) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `stripe_id` text,
  `chargeback` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `amount`, `rate`, `currency`, `charge`, `ref`, `main`, `type`, `status`, `stripe_id`, `chargeback`, `created_at`, `updated_at`) VALUES
(221, 63, '425.1', NULL, NULL, NULL, 'VC-pOBkBz', 1, 2, 1, NULL, 0, '2021-03-19 17:14:57', '2021-03-19 17:14:57'),
(222, 63, '34.91', NULL, NULL, NULL, 'VC-y3Inv5', 0, 2, 1, NULL, 0, '2021-03-19 17:15:26', '2021-03-19 17:15:26'),
(223, 63, '50.765', NULL, NULL, NULL, 'VC-hqIpoL', 0, 2, 1, NULL, 0, '2021-03-19 17:22:10', '2021-03-19 17:22:10'),
(224, 63, '34.91', NULL, NULL, NULL, 'VC-SeP6L3', 0, 2, 1, NULL, 0, '2021-03-19 17:23:14', '2021-03-19 17:23:14'),
(225, 63, '55.15', NULL, NULL, NULL, 'VC-tlKOZt', 1, 2, 1, NULL, 0, '2021-03-20 05:55:10', '2021-03-20 05:55:10'),
(226, 63, '24.06', NULL, NULL, NULL, 'VC-kGMDSf', 0, 2, 1, NULL, 0, '2021-03-20 05:57:45', '2021-03-20 05:57:45'),
(227, 63, '107.5', NULL, NULL, NULL, 'VC-abBbVi', 0, 2, 1, NULL, 0, '2021-03-20 05:58:58', '2021-03-20 05:58:58'),
(228, 63, '65.72', NULL, NULL, NULL, 'VC-0cpMQ6', 1, 2, 1, NULL, 0, '2021-03-20 06:36:14', '2021-03-20 06:36:14'),
(229, 63, '86.86', NULL, NULL, NULL, 'VC-2AzG5i', 1, 2, 1, NULL, 0, '2021-03-20 06:37:44', '2021-03-20 06:37:44'),
(230, 63, '86.86', NULL, NULL, NULL, 'VC-eAJdYs', 1, 2, 1, NULL, 0, '2021-03-20 06:43:44', '2021-03-20 06:43:44'),
(231, 63, '24.06', NULL, NULL, NULL, 'VC-7FoWac', 0, 2, 1, NULL, 0, '2021-03-20 07:10:00', '2021-03-20 07:10:00'),
(232, 63, '24.06', NULL, NULL, NULL, 'VC-4b3pyB', 0, 2, 1, NULL, 0, '2021-03-20 07:10:34', '2021-03-20 07:10:34'),
(233, 63, '213.7', NULL, NULL, NULL, 'VC-1ItEYj', 1, 2, 1, NULL, 0, '2021-03-20 09:40:30', '2021-03-20 09:40:30'),
(234, 63, '34.49', NULL, NULL, NULL, 'VC-H0REau', 0, 2, 1, NULL, 0, '2021-03-20 09:57:50', '2021-03-20 09:57:50'),
(235, 63, '13.63', NULL, NULL, NULL, 'VC-jwQzX1', 0, 2, 1, NULL, 0, '2021-03-20 09:59:34', '2021-03-20 09:59:34'),
(236, 63, '107.5', NULL, NULL, NULL, 'VC-YmFawi', 0, 2, 1, NULL, 0, '2021-03-20 10:32:40', '2021-03-20 10:32:40'),
(237, 63, '339.046', NULL, NULL, NULL, 'VC-7ZwQk7', 0, 2, 1, NULL, 0, '2021-03-20 10:40:06', '2021-03-20 10:40:06'),
(238, 63, '319.4', NULL, NULL, NULL, 'VC-BHRhYk', 1, 2, 1, NULL, 0, '2021-03-20 14:08:16', '2021-03-20 14:08:16'),
(239, 63, '341.597', NULL, NULL, NULL, 'VC-JbFqnC', 1, 2, 1, NULL, 0, '2021-03-20 14:28:11', '2021-03-20 14:28:11'),
(240, 63, '366.965', NULL, NULL, NULL, 'VC-aCyGjR', 1, 2, 1, NULL, 0, '2021-03-20 20:51:38', '2021-03-20 20:51:38'),
(241, 63, '107.5', NULL, NULL, NULL, 'VC-KCU0Ls', 0, 2, 1, NULL, 0, '2021-03-20 20:53:26', '2021-03-20 20:53:26'),
(242, 63, '55.15', NULL, NULL, NULL, 'VC-vywam6', 1, 2, 1, NULL, 0, '2021-03-21 11:40:38', '2021-03-21 11:40:38'),
(243, 63, '24.06', NULL, NULL, NULL, 'VC-7GfY65', 0, 2, 1, NULL, 0, '2021-03-21 11:44:19', '2021-03-21 11:44:19'),
(244, 63, '34.49', NULL, NULL, NULL, 'VC-8xMWOF', 0, 2, 1, NULL, 0, '2021-03-21 11:45:47', '2021-03-21 11:45:47'),
(245, 63, NULL, NULL, NULL, NULL, 'MER-MaTZab', 1, NULL, 1, NULL, 0, '2021-03-22 06:53:58', '2021-03-22 06:53:58'),
(246, 64, NULL, NULL, NULL, NULL, 'MER-PjC2lu', 1, NULL, 1, NULL, 0, '2022-07-23 03:40:47', '2022-07-23 03:40:47'),
(247, 64, '145.8', NULL, NULL, NULL, 'INV-cIUfba', 1, 1, 1, NULL, 0, '2022-07-25 01:36:14', '2022-07-25 01:36:14'),
(248, 64, '142.4', NULL, NULL, NULL, 'INV-zafBCT', 0, 1, 1, NULL, 0, '2022-07-25 01:46:48', '2022-07-25 01:46:48'),
(249, 64, '0', NULL, NULL, NULL, 'INV-bOImqc', 1, 1, 1, NULL, 0, '2022-07-25 03:15:03', '2022-07-25 03:15:03'),
(250, 64, '0', NULL, NULL, NULL, 'INV-z7APyx', 1, 1, 1, NULL, 0, '2022-07-25 03:17:42', '2022-07-25 03:17:42'),
(251, 64, '0', NULL, NULL, NULL, 'INV-R7NHY0', 1, 1, 1, NULL, 0, '2022-07-25 03:45:55', '2022-07-25 03:45:55'),
(252, 64, '0', NULL, NULL, NULL, 'INV-oqiYAJ', 1, 1, 1, NULL, 0, '2022-07-25 03:47:02', '2022-07-25 03:47:02'),
(253, 64, '0', NULL, NULL, NULL, 'INV-SxbEGj', 1, 1, 1, NULL, 0, '2022-07-25 03:48:31', '2022-07-25 03:48:31'),
(254, 64, '0', NULL, NULL, NULL, 'INV-L76Z0e', 1, 1, 1, NULL, 0, '2022-07-25 03:49:14', '2022-07-25 03:49:14'),
(255, 64, '0', NULL, NULL, NULL, 'INV-7VkwhJ', 1, 1, 1, NULL, 0, '2022-07-25 03:51:01', '2022-07-25 03:51:01'),
(256, 64, '0', NULL, NULL, NULL, 'INV-g2VeGJ', 1, 1, 1, NULL, 0, '2022-07-25 04:54:29', '2022-07-25 04:54:29'),
(257, 64, '0', NULL, NULL, NULL, 'INV-TmimKR', 1, 1, 1, NULL, 0, '2022-07-25 04:57:08', '2022-07-25 04:57:08'),
(258, 64, '0', NULL, NULL, NULL, 'INV-o8D17x', 1, 1, 1, NULL, 0, '2022-07-25 05:01:43', '2022-07-25 05:01:43'),
(259, 64, '0', NULL, NULL, NULL, 'INV-iWHp9x', 1, 1, 1, NULL, 0, '2022-07-25 05:16:24', '2022-07-25 05:16:24'),
(260, 64, '6.2', NULL, NULL, NULL, 'INV-iWHp9x', 0, 1, 1, NULL, 0, '2022-07-26 22:09:45', '2022-07-26 22:09:45'),
(261, 64, '93.8', NULL, NULL, NULL, 'INV-ihdR1r', 0, 1, 1, NULL, 0, '2022-07-27 04:21:12', '2022-07-27 04:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `invoice_no` int(16) NOT NULL,
  `due_date` varchar(32) NOT NULL,
  `sent_date` varchar(32) DEFAULT NULL,
  `tax` int(10) DEFAULT NULL,
  `discount` int(10) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `item` text NOT NULL,
  `notes` text,
  `ref_id` varchar(16) NOT NULL,
  `amount` varchar(32) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `total` varchar(32) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `sent` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pix_transaction_id` varchar(255) DEFAULT NULL,
  `pix_copy_past` text,
  `pix_qrcode` text,
  `client_name` varchar(255) DEFAULT NULL,
  `client_document` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `user_id`, `email`, `invoice_no`, `due_date`, `sent_date`, `tax`, `discount`, `quantity`, `item`, `notes`, `ref_id`, `amount`, `rate`, `currency`, `charge`, `total`, `status`, `sent`, `created_at`, `updated_at`, `pix_transaction_id`, `pix_copy_past`, `pix_qrcode`, `client_name`, `client_document`) VALUES
(1, 64, 'vagnercarvalho-02@hotmail.com', 1, '07/29/2022', NULL, 5, 5, 1, 'Mensalidade Fair Sales', 'O nao pagamento poderá implicar no cancelamento da assinatura.', 'INV-cIUfba', '150', NULL, NULL, '7.3872', '150', 1, 0, '2022-07-25 01:36:14', '2022-07-25 01:46:48', NULL, NULL, NULL, NULL, NULL),
(2, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 100, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-bOImqc', '100', NULL, NULL, NULL, '0', 0, 0, '2022-07-25 03:15:03', '2022-07-25 03:15:03', NULL, NULL, NULL, NULL, NULL),
(3, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 0, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-z7APyx', '100', NULL, NULL, NULL, '100', 0, 0, '2022-07-25 03:17:42', '2022-07-25 03:17:42', NULL, NULL, NULL, NULL, NULL),
(4, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 0, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-R7NHY0', '100', NULL, NULL, NULL, '100', 0, 0, '2022-07-25 03:45:55', '2022-07-25 03:45:55', NULL, NULL, NULL, 'Evelyn Lívia Rodrigues', '37135906489'),
(5, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 0, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-oqiYAJ', '100', NULL, NULL, NULL, '100', 0, 0, '2022-07-25 03:47:02', '2022-07-25 03:47:02', NULL, NULL, NULL, 'Evelyn Lívia Rodrigues', '37135906489'),
(6, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 0, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-SxbEGj', '100', NULL, NULL, NULL, '100', 0, 0, '2022-07-25 03:48:31', '2022-07-25 03:48:31', NULL, NULL, NULL, 'Evelyn Lívia Rodrigues', '37135906489'),
(7, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 0, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-L76Z0e', '100', NULL, NULL, NULL, '100', 0, 0, '2022-07-25 03:49:14', '2022-07-25 03:49:14', NULL, NULL, NULL, 'Evelyn Lívia Rodrigues', '12345678909'),
(8, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 0, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-7VkwhJ', '100', NULL, NULL, NULL, '100', 0, 0, '2022-07-25 03:51:00', '2022-07-25 03:51:00', NULL, NULL, NULL, 'Evelyn Lívia Rodrigues', '12345678909'),
(9, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 0, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-g2VeGJ', '100', NULL, NULL, NULL, '100', 0, 0, '2022-07-25 04:54:29', '2022-07-25 04:54:29', NULL, NULL, NULL, 'Evelyn Lívia Rodrigues', '12345678909'),
(10, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 0, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-TmimKR', '100', NULL, NULL, NULL, '100', 0, 0, '2022-07-25 04:57:08', '2022-07-25 04:57:11', 'f4oKxkKnfKw0g748ryiYynotRH4zLVYXmgj', '00020101021226870014br.gov.bcb.pix2565qrcodepix-h.bb.com.br/pix/v2/a542a471-be0c-4683-a713-b7b133ecc2525204000053039865802BR5920ALAN GUIACHERO BUENO6008BRASILIA62070503***63046C1B', 'data:image/png;base64,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', 'Evelyn Lívia Rodrigues', '12345678909'),
(11, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 0, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-o8D17x', '100', NULL, NULL, NULL, '100', 0, 0, '2022-07-25 05:01:43', '2022-07-25 05:01:46', 'PHBxPZFbuYYTUp5DgP6PtAXv0TPoJswFqgH', '00020101021226870014br.gov.bcb.pix2565qrcodepix-h.bb.com.br/pix/v2/dc6825dc-b924-46c3-814e-d5d7a36062895204000053039865802BR5920ALAN GUIACHERO BUENO6008BRASILIA62070503***6304D354', 'data:image/png;base64,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', 'Evelyn Lívia Rodrigues', '12345678909'),
(12, 64, 'evelynliviarodrigues@alkbrasil.com.br', 2, '2022-07-29', NULL, 0, 0, 1, 'Teste de invoice', 'Teste de observacoes de invoice', 'INV-iWHp9x', '100', NULL, NULL, '6.0264', '100', 1, 0, '2022-07-25 05:16:24', '2022-07-27 04:21:12', 'PUJQCE3UXFkWw4xU5A2KHOQsWV8fER6OaU0', '00020101021226870014br.gov.bcb.pix2565qrcodepix-h.bb.com.br/pix/v2/de9faced-295f-428b-a9b5-d793a4509cd95204000053039865802BR5920ALAN GUIACHERO BUENO6008BRASILIA62070503***6304EE0A', 'data:image/png;base64,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', 'Evelyn Lívia Rodrigues', '12345678909');

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

CREATE TABLE `logo` (
  `id` int(32) NOT NULL,
  `image_link` varchar(128) NOT NULL,
  `image_link2` varchar(32) NOT NULL,
  `dark` varchar(32) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logo`
--

INSERT INTO `logo` (`id`, `image_link`, `image_link2`, `dark`, `created_at`, `updated_at`) VALUES
(1, 'images/logo_1659411685.png', 'images/favicon_1657068155.png', 'images/logo_1659411672.png', '2022-08-02 03:41:26', '2022-08-02 06:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `merchant_key` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8mb4_unicode_ci,
  `ref_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `user_id`, `merchant_key`, `name`, `email`, `ref_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 64, 'sMhGytLZYGVSCrhl', 'Site de vendas', 'vagnercarvalho.vfc@gmail.com', 'MER-PjC2lu', 1, '2022-07-23 03:40:47', '2022-07-23 03:40:47');

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
(2, '2014_10_12_100000_create_password_resets_table', 2),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(6, '2016_06_01_000004_create_oauth_clients_table', 2),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(8, '2019_08_19_000000_create_failed_jobs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('63f7d90e128821ff007a9f85ff30064b6a896725214e19f9fc20c1615ebb12bba1275e459a710101', 64, 1, 'MyApp', '[]', 0, '2022-07-25 01:15:44', '2022-07-25 01:15:44', '2023-07-24 22:15:44'),
('ba307a7cd10bf197160fc7492200cf016c9f9c600585495306d0bbde506edc0b8c9efbf73cb2598a', 64, 1, 'MyApp', '[]', 0, '2022-07-25 01:13:09', '2022-07-25 01:13:09', '2023-07-24 22:13:09');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Cronospay Personal Access Client', 'cQCtWmIDkabcLJv3TFaXvb46RgdQcHkFqKR7R2uC', NULL, 'http://localhost', 1, 0, 0, '2022-07-24 15:59:53', '2022-07-24 15:59:53'),
(2, NULL, 'Cronospay Password Grant Client', 'uVA62ouZsUbVVZ7tMtGpNjCHTmyvWaZpKIDiA722', 'users', 'http://localhost', 0, 1, 0, '2022-07-24 15:59:53', '2022-07-24 15:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-07-24 15:59:53', '2022-07-24 15:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ip_address` varchar(32) DEFAULT NULL,
  `card_number` varchar(32) DEFAULT NULL,
  `payment_type` varchar(32) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `amount` varchar(32) DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `total` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `shipping_fee` varchar(32) DEFAULT NULL,
  `address` text,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `town` text,
  `ref_id` varchar(32) NOT NULL,
  `status` int(1) DEFAULT '0',
  `phone` varchar(32) DEFAULT NULL,
  `note` text,
  `ship_id` int(32) DEFAULT NULL,
  `store_id` int(32) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(32) NOT NULL,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `created_at` varchar(32) NOT NULL,
  `updated_at` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(4, 'AML Policy', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p>', 1, '2019-07-31 11:43:14', '2019-11-11 01:21:30'),
(6, 'Diversity', '<header>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>&nbsp;</div>\r\n</div>\r\n<div>\r\n<div>\r\n<div>\r\n<h1>Diversity</h1>\r\n<p>Individuals. Ideas. Inspiration. Yes, we\'re open</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</header>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div data-nn-conditional=\"\">\r\n<div>\r\n<p>Diversity and inclusion matter in our business. An inclusive and diverse workforce makes us better leaders and contributes to a more innovative, dynamic and, ultimately, more successful company. And, variety helps us meet the needs of our diverse client base.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div data-nn-conditional=\"\">\r\n<h2 id=\"col1textimage\">Inclusiveness</h2>\r\n<div>\r\n<p>We promote inclusion and encourage open dialogue to draw out everyone\'s opinions and perspectives. We recognize a diverse range of contributions to keep our people energetic, engaged and inspired. And we are a signatory to the UN Standards of Conduct for Business regarding tackling LGBTI discrimination around the world.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div>\r\n<div>\r\n<div data-nn-conditional=\"\">\r\n<h2 id=\"col2textimage\">Flexibility</h2>\r\n<div>\r\n<p>We offer a modern, flexible working environment. We work where and how it\'s most appropriate according to individual, role and team requirements.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div>\r\n<div>&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', 1, '2020-02-15 23:02:32', '2020-02-16 20:47:41'),
(7, 'Sponsoring', '<div>\n<span>The big picture</span>\n</div>\n<div>\n<div>\n<p>We’re passionate about supporting the places where we live and work. Through our long-standing sponsorships of motor sports and contemporary art, we connect with communities in new and exciting ways every day. It’s our way of understanding how the world works, one pit stop and brush stroke at a time.</p>\n</div>\n</div>', 1, '2020-02-15 23:06:08', '2020-10-03 13:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`, `updated_at`) VALUES
(1, 'ronnie@gmail.com', 'IFsbuBWs5ZgZcoQGMivzLXy8XCvOne', '2018-05-16 04:28:41', NULL),
(2, 'ronnie@gmail.com', 'fHkcBEMW78ef43pmSswx8kVHqLcgDx', '2018-05-23 03:19:47', NULL),
(3, 'ronnie@gmail.com', 'tNPjzNUcsdEYeSPCutmDy8VfbECMUY', '2018-05-23 03:28:28', NULL),
(4, 'ronniearea@gmail.com', 'GXtEiyl8MGzNwMR5tNdRCEI7dTyuVX', '2018-05-27 19:02:22', NULL),
(5, 'abirkhan75@gmail.com', 'Z6sHQHOATk5fluqi0vAJeyqzEd0ZXz', '2018-05-27 08:54:38', NULL),
(6, 'haha@haha.co', 'IDx0BrjOWN6p0FGFpmOdgG6wrdtqO2', '2018-05-29 00:20:01', NULL),
(7, 'haha@haha.co', 'dD4UFej2PEFSEmBil48SJPw1l2zUSv', '2018-05-29 00:26:54', NULL),
(8, 'haha@haha.co', 'gbchqenwrcLnZPhzdjAtpR92V8vwwm', '2018-05-29 00:51:15', NULL),
(9, 'ronniearea@gmail.com', 'aDcOh1kIodnZh7xS1PIfWsQhMpgMdz', '2018-07-07 03:17:52', NULL),
(10, 'ronniearea@gmail.com', 'f1cIXMOls67f0fZTNgrabFt2gz1Tm3', '2018-07-07 03:18:43', NULL),
(11, 'ronniearea@gmail.com', 'otlQ1ZqDnK3fG4ppUJzah8vML0hbWZ', '2018-08-11 01:45:31', NULL),
(12, 'ronniearea@gmail.com', 'voucnaTSJ9zVb68fE89HFlTxpFV5ci', '2018-11-10 09:32:43', NULL),
(13, 'user@test.com', '4eUH4Lgx90OC18eXcDnlczyHNWcr2B', '2020-01-31 13:14:15', NULL),
(14, 'user@test.com', 'm8qZ4EYuDRQYqzBVJkDsQMBLXeWjM5', '2020-09-19 14:01:50', NULL),
(15, 'user@test.com', 'VRtoEmGig8poDYHBkAeIisQyUmgRti', '2020-09-19 14:02:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_link`
--

CREATE TABLE `payment_link` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `ref_id` varchar(16) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `redirect_link` text,
  `image` varchar(32) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `active` int(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_link`
--

INSERT INTO `payment_link` (`id`, `user_id`, `ref_id`, `amount`, `rate`, `currency`, `type`, `name`, `description`, `redirect_link`, `image`, `status`, `active`, `created_at`, `updated_at`) VALUES
(1, 27, 'XEPIruSFH3avCJ33', NULL, NULL, NULL, 1, 'Customization services', 'Customization service for investment project', NULL, NULL, 0, 1, '2020-10-05 04:39:12', '2020-10-05 03:39:12');

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `id` int(16) NOT NULL,
  `user_id` int(32) NOT NULL,
  `ref_id` varchar(32) NOT NULL,
  `name` text NOT NULL,
  `amount` varchar(32) DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `intervals` varchar(32) NOT NULL,
  `times` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `active` int(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL,
  `cat_id` int(32) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `amount` varchar(32) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `quantity` int(32) NOT NULL,
  `sold` int(32) DEFAULT '0',
  `rq` int(32) DEFAULT NULL,
  `charge` int(11) DEFAULT NULL,
  `address` text,
  `note` text,
  `add_status` int(1) NOT NULL DEFAULT '0',
  `quantity_status` int(1) NOT NULL DEFAULT '0',
  `note_status` int(1) NOT NULL DEFAULT '0',
  `description` text,
  `status` int(1) NOT NULL DEFAULT '1',
  `active` int(1) DEFAULT '1',
  `ref_id` varchar(16) NOT NULL,
  `new` int(11) DEFAULT '0',
  `shipping_status` int(1) NOT NULL DEFAULT '0',
  `shipping_fee` int(32) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(16) NOT NULL,
  `product_id` int(16) NOT NULL,
  `image` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(17, 3, '1590272746.jpeg', '2020-05-23 21:25:46', '2020-05-23 21:25:46'),
(30, 15, '1611594647.jpg', '2021-01-25 17:10:47', '2021-01-25 17:10:47'),
(31, 7, '1611595108.jpg', '2021-01-25 17:18:28', '2021-01-25 17:18:28'),
(32, 7, '1611595118.jpg', '2021-01-25 17:18:38', '2021-01-25 17:18:38'),
(34, 6, '1611595306.jpg', '2021-01-25 17:21:46', '2021-01-25 17:21:46'),
(36, 16, '1611601026.jpg', '2021-01-25 18:57:08', '2021-01-25 18:57:08'),
(37, 9, '1611659092.jpg', '2021-01-26 11:04:52', '2021-01-26 11:04:52'),
(38, 17, '1611690325.jpg', '2021-01-26 19:45:25', '2021-01-26 19:45:25'),
(39, 17, '1611690339.jpg', '2021-01-26 19:45:39', '2021-01-26 19:45:39'),
(40, 17, '1611690348.jpg', '2021-01-26 19:45:48', '2021-01-26 19:45:48'),
(41, 17, '1611690359.jpg', '2021-01-26 19:45:59', '2021-01-26 19:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `reply_support`
--

CREATE TABLE `reply_support` (
  `id` int(32) NOT NULL,
  `ticket_id` varchar(32) NOT NULL,
  `reply` text NOT NULL,
  `status` int(2) NOT NULL,
  `staff_id` int(32) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reply_support`
--

INSERT INTO `reply_support` (`id`, `ticket_id`, `reply`, `status`, `staff_id`, `created_at`, `updated_at`) VALUES
(6, 'XvuX4mNrFIMp0KpI', 'sdfghfd', 1, NULL, '2020-05-14 21:14:58', '2020-05-14 21:14:58'),
(7, '2eADkpESfSdctt2f', 'ok', 0, NULL, '2020-05-27 06:11:27', '2020-05-27 06:11:27'),
(8, '2eADkpESfSdctt2f', '<script>\r\n  $(\'#customFileLang\').on(\'change\',function(){\r\n      //get the file name\r\n      var fileName = $(this).val().replace(\'C:\\\\fakepath\\\\\', \" \");\r\n      //replace the \"Choose a file\" label\r\n      $(this).next(\'.custom-file-label\').html(fileName);\r\n  })\r\n  $(\'.carousel\').carousel({\r\n  interval: 2000\r\n  })\r\n  populateCountries(\"country\", \"state\");\r\n  function sellVals(){\r\n    var quantity = $(\"#quantity\").val();\r\n    var amount = $(\"#amount\").val();\r\n    var ship_fee = $(\"#ship_fee\").val();\r\n    var subtotal = parseInt(amount)*parseInt(quantity);\r\n    var total = parseInt(subtotal)+parseInt(ship_fee);\r\n  $(\"#product1\").text(quantity);\r\n  $(\"#subtotal1\").text(subtotal);\r\n  $(\"#total1\").text(total);\r\n}\r\n  $(\"#quantity\").change(sellVals);\r\n  sellVals();\r\n</script>', 1, NULL, '2020-05-27 06:13:42', '2020-05-27 06:13:42'),
(9, 'AW1GaEObUOPORtwA', 'Ok we will look into your report', 0, NULL, '2020-10-09 22:41:41', '2020-10-09 22:41:41'),
(10, 'AW1GaEObUOPORtwA', 'Thanks', 1, NULL, '2020-10-09 22:42:27', '2020-10-09 22:42:27'),
(11, 'AW1GaEObUOPORtwA', 'We are running our investigations', 0, 1, '2020-10-09 22:52:58', '2020-10-09 22:52:58'),
(12, 'AW1GaEObUOPORtwA', 'We are running our investigations', 0, 1, '2020-10-09 22:53:33', '2020-10-09 22:53:33'),
(13, 'DZgX0Gln7g1xI1aX', 'hello', 1, NULL, '2020-10-09 23:12:29', '2020-10-09 23:12:29'),
(14, 'DZgX0Gln7g1xI1aX', 'hey', 0, NULL, '2020-10-10 03:13:49', '2020-10-10 03:13:49'),
(15, 'DZgX0Gln7g1xI1aX', 'ddd', 0, 4, '2020-10-10 03:17:22', '2020-10-10 03:17:22'),
(16, 'DZgX0Gln7g1xI1aX', 'Rate Our customer support', 0, 1, '2020-10-10 03:19:44', '2020-10-10 03:19:44');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(8) NOT NULL,
  `ref_id` varchar(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `confirm` varchar(8) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `image_link` varchar(32) DEFAULT NULL,
  `review` text NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `name`, `occupation`, `image_link`, `review`, `status`, `created_at`, `updated_at`) VALUES
(11, 'Jason Well', 'Forex trader', 'update_1595666475.jpg', 'As YC\'s first Nigerian startup Boompay leads the charge of great companies coming out of Africa, powering modern payments for an entire continent.', 1, '2020-07-25 08:41:15', '2020-07-25 07:41:15'),
(12, 'JacK Mill', 'Market analyst', 'update_1595666510.jpg', 'Our investment in Boompay aligns with the kind of investments we look for - those that will help extend our reach into the global commerce ecosystem', 1, '2020-07-25 08:41:50', '2020-07-25 07:41:50'),
(14, 'Big brother', 'Web developer', 'update_1595666519.jpg', 'Boompay is highly technical and fanatically customer oriented. We’re excited to back such people in one of the world’s fastest-growing regions.', 1, '2020-10-03 12:59:35', '2020-10-03 11:59:35');

-- --------------------------------------------------------

--
-- Table structure for table `sell_cards`
--

CREATE TABLE `sell_cards` (
  `id` int(32) NOT NULL,
  `trx` varchar(16) DEFAULT NULL,
  `user_id` int(16) DEFAULT NULL,
  `plan_id` int(16) DEFAULT NULL,
  `amount` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `bank` int(16) DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `total` varchar(32) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `c_image` varchar(32) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sell_cards`
--

INSERT INTO `sell_cards` (`id`, `trx`, `user_id`, `plan_id`, `amount`, `charge`, `bank`, `rate`, `total`, `status`, `c_image`, `created_at`, `updated_at`) VALUES
(8, '5NDGsfwwtq', 11, 13, '100', NULL, 2, '240', '24000', 1, NULL, '2020-08-08 09:22:22', '2020-05-02 13:05:38'),
(9, 'VV8e2IHT1uzo1p6I', 11, 17, '200', NULL, 2, '260', '52000', 1, NULL, '2020-08-11 15:36:31', '2020-08-11 14:36:31'),
(10, 'C02GNirhZZBb4Ti3', 11, 17, '200', NULL, 2, '260', '52000', 2, 'reason_1605291491.png', '2020-11-13 18:18:11', '2020-11-13 17:18:11'),
(11, 'r3dnAvEhQ4fwXjQk', 11, 17, '200', NULL, 2, '260', '52000', 0, NULL, '2020-08-08 09:23:01', '2020-08-07 18:51:21');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(32) NOT NULL,
  `title` text,
  `details` text,
  `image` varchar(32) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `details`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Promote sales', 'Intelligent value-added services for digital banking, sales.', 'service_1587646811.png', '2021-02-01 04:08:36', '2021-02-01 04:08:36'),
(2, 'Life saving solutions', 'Data-based solutions for retail, analytics, and risk management.', 'service_1587646963.png', '2020-07-25 08:50:40', '2020-07-25 07:50:40'),
(3, 'Easy payment system', 'A centralized payment solution for accepting cards.', 'service_1587647149.png', '2021-02-01 04:08:52', '2021-02-01 04:08:52'),
(5, 'Secure payments', 'We keep your financial details private and transactions secure.', NULL, '2020-07-25 08:50:25', '2020-07-25 07:50:25');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(32) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `site_name` varchar(200) DEFAULT NULL,
  `site_desc` text,
  `email` varchar(128) DEFAULT NULL,
  `support_email` varchar(255) DEFAULT NULL,
  `mobile` varchar(128) DEFAULT NULL,
  `balance_reg` int(32) DEFAULT NULL,
  `email_notify` int(2) DEFAULT NULL,
  `sms_notify` int(2) DEFAULT NULL,
  `kyc` int(2) DEFAULT NULL,
  `transfer_charge` int(32) DEFAULT NULL,
  `transfer_chargep` varchar(32) DEFAULT NULL,
  `min_transfer` varchar(10) DEFAULT NULL,
  `merchant_charge` varchar(11) DEFAULT NULL,
  `merchant_chargep` varchar(32) DEFAULT NULL,
  `invoice_charge` varchar(11) DEFAULT NULL,
  `invoice_chargep` varchar(32) DEFAULT NULL,
  `product_charge` varchar(11) DEFAULT NULL,
  `product_chargep` varchar(32) DEFAULT NULL,
  `single_charge` varchar(11) DEFAULT NULL,
  `single_chargep` varchar(32) DEFAULT NULL,
  `donation_charge` varchar(11) DEFAULT NULL,
  `donation_chargep` varchar(32) DEFAULT NULL,
  `subscription_charge` varchar(11) DEFAULT NULL,
  `subscription_chargep` varchar(32) DEFAULT NULL,
  `bill_charge` varchar(32) DEFAULT NULL,
  `bill_chargep` varchar(32) DEFAULT NULL,
  `virtual_createcharge` varchar(32) DEFAULT NULL,
  `virtual_createchargep` varchar(32) DEFAULT NULL,
  `virtual_charge` varchar(32) DEFAULT NULL,
  `virtual_chargep` varchar(32) DEFAULT NULL,
  `email_verification` int(2) DEFAULT NULL,
  `sms_verification` int(2) DEFAULT NULL,
  `registration` int(2) DEFAULT NULL,
  `withdraw_charge` varchar(191) DEFAULT NULL,
  `withdraw_chargep` varchar(32) DEFAULT NULL,
  `withdraw_limit` varchar(32) DEFAULT NULL,
  `starter_limit` varchar(32) DEFAULT NULL,
  `withdraw_duration` varchar(32) DEFAULT NULL,
  `merchant` int(2) NOT NULL,
  `transfer` int(1) NOT NULL DEFAULT '1',
  `request_money` int(1) NOT NULL DEFAULT '1',
  `invoice` int(1) NOT NULL DEFAULT '1',
  `store` int(1) NOT NULL DEFAULT '1',
  `donation` int(1) NOT NULL DEFAULT '1',
  `single` int(1) NOT NULL DEFAULT '1',
  `subscription` int(1) NOT NULL DEFAULT '1',
  `bill` int(1) DEFAULT '1',
  `vcard` int(1) DEFAULT NULL,
  `livechat` text,
  `language` int(1) DEFAULT '0',
  `recaptcha` int(1) DEFAULT '0',
  `next_settlement` varchar(32) DEFAULT NULL,
  `duration` varchar(32) DEFAULT NULL,
  `xperiod` varchar(32) DEFAULT NULL,
  `period` varchar(32) DEFAULT NULL,
  `vc_no` int(32) DEFAULT NULL,
  `vc_min` double DEFAULT NULL,
  `vc_max` double DEFAULT NULL,
  `btc_wallet` text,
  `btc_sell` varchar(32) DEFAULT NULL,
  `btc_buy` varchar(32) DEFAULT NULL,
  `eth_wallet` text,
  `eth_buy` varchar(32) DEFAULT NULL,
  `eth_sell` varchar(32) DEFAULT NULL,
  `ethereum` int(1) DEFAULT NULL,
  `min_btcsell` int(32) DEFAULT NULL,
  `min_btcbuy` int(32) DEFAULT NULL,
  `min_ethsell` int(32) DEFAULT NULL,
  `min_ethbuy` int(32) DEFAULT NULL,
  `bitcoin` int(1) DEFAULT NULL,
  `btc_charge` varchar(32) DEFAULT NULL,
  `eth_charge` varchar(32) DEFAULT NULL,
  `stripe_chargebacks` varchar(32) DEFAULT NULL,
  `welcome_message` text,
  `stripe_connect` int(1) NOT NULL DEFAULT '0',
  `lock_code` varchar(32) DEFAULT NULL,
  `kyc_restriction` int(1) DEFAULT NULL,
  `country_restriction` int(1) DEFAULT NULL,
  `debit_currency` varchar(3) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `site_name`, `site_desc`, `email`, `support_email`, `mobile`, `balance_reg`, `email_notify`, `sms_notify`, `kyc`, `transfer_charge`, `transfer_chargep`, `min_transfer`, `merchant_charge`, `merchant_chargep`, `invoice_charge`, `invoice_chargep`, `product_charge`, `product_chargep`, `single_charge`, `single_chargep`, `donation_charge`, `donation_chargep`, `subscription_charge`, `subscription_chargep`, `bill_charge`, `bill_chargep`, `virtual_createcharge`, `virtual_createchargep`, `virtual_charge`, `virtual_chargep`, `email_verification`, `sms_verification`, `registration`, `withdraw_charge`, `withdraw_chargep`, `withdraw_limit`, `starter_limit`, `withdraw_duration`, `merchant`, `transfer`, `request_money`, `invoice`, `store`, `donation`, `single`, `subscription`, `bill`, `vcard`, `livechat`, `language`, `recaptcha`, `next_settlement`, `duration`, `xperiod`, `period`, `vc_no`, `vc_min`, `vc_max`, `btc_wallet`, `btc_sell`, `btc_buy`, `eth_wallet`, `eth_buy`, `eth_sell`, `ethereum`, `min_btcsell`, `min_btcbuy`, `min_ethsell`, `min_ethbuy`, `bitcoin`, `btc_charge`, `eth_charge`, `stripe_chargebacks`, `welcome_message`, `stripe_connect`, `lock_code`, `kyc_restriction`, `country_restriction`, `debit_currency`, `created_at`, `updated_at`) VALUES
(1, 'Stay focused on your business', 'Sharkpay', 'Make it as easy as possible to pay. Modular or combined with other services, our payment technologies ensure swift implementation. What’s more, you can flexibly adapt our proven standard solutions to suit each country and application. Lastingly slash your operating costs and boost your sales.', 'test@sharkpay.net', 'test@sharkpay.net', '12345675432', 0, 0, 0, 1, 3, '2', '0', '1.3', '1.2', '2.8', '3.4', '3.7', '2.34', '2.3', '4.23', '0.5', '10', '2.1', '2.3', '3', '3.2', '5.7', '2.3', '4.3', '3.2', 0, 0, 1, '3.1', '4.2', '300000', '2000000', NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 1, 0, '2022-08-04 02:42:23', '2', '0', 'Day', 2, 50, 10000, 'kjdbd-djkdjdj-2o32-2jebk2j', '456', '460', 'kjdbd-djkdjdj-2o32-2jebk2s', '450', '460', 1, 300, 200, NULL, 100, 1, '3', '5', '2022-08-03 02:42:44', 'We are excited to have you on board!, It’s our duty to make your experience smooth and convenient. We make it as easy as possible to pay. Modular or combined with other services, our payment technologies ensure swift implementation. What’s more, you can flexibly adapt our proven standard solutions to suit each country and application. Lastingly slash your operating costs and boost your sales.', 0, NULL, 0, 0, 'USD', '2022-08-02 02:42:44', '2022-08-02 05:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `region` text NOT NULL,
  `amount` varchar(32) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(2) NOT NULL,
  `type` longtext COLLATE utf8_unicode_ci,
  `value` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'facebook', 'https://facebook.com/', '2020-02-09 08:09:22', '2020-02-09 07:09:22'),
(2, 'instagram', 'https://instagram.com/', '2020-01-24 22:09:58', '0000-00-00 00:00:00'),
(3, 'twitter', 'https://twitter.com/', '2020-01-24 22:09:58', '0000-00-00 00:00:00'),
(4, 'skype', NULL, '2020-02-15 22:59:58', '2020-02-15 21:59:58'),
(5, 'pinterest', NULL, '2020-02-15 23:00:20', '2020-02-15 22:00:20'),
(7, 'linkedin', NULL, '2020-02-15 23:00:07', '2020-02-15 22:00:07'),
(8, 'youtube', NULL, '2020-02-15 22:59:48', '2020-02-15 21:59:48'),
(9, 'whatsapp', 'https://whatsapp.com/', '2020-02-09 08:09:38', '2020-02-09 07:09:38'),
(10, 'telegram', 'https://telegram.com/', '2020-02-09 08:09:38', '2020-02-09 07:09:38');

-- --------------------------------------------------------

--
-- Table structure for table `storefront`
--

CREATE TABLE `storefront` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `store_name` text NOT NULL,
  `store_desc` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `store_url` text NOT NULL,
  `category` text NOT NULL,
  `revenue` varchar(32) DEFAULT '0',
  `shipping_status` int(1) NOT NULL DEFAULT '0',
  `note_status` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `storefront_products`
--

CREATE TABLE `storefront_products` (
  `id` int(32) NOT NULL,
  `store_id` int(32) NOT NULL,
  `product_id` int(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `storefront_products`
--

INSERT INTO `storefront_products` (`id`, `store_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '2021-01-25 09:29:46', '2021-01-25 09:29:46'),
(2, 1, 7, '2021-01-25 09:30:09', '2021-01-25 09:30:09'),
(8, 1, 15, '2021-01-25 17:14:35', '2021-01-25 17:14:35'),
(9, 2, 16, '2021-01-25 18:58:55', '2021-01-25 18:58:55'),
(10, 3, 9, '2021-01-26 11:04:30', '2021-01-26 11:04:30'),
(11, 4, 17, '2021-01-26 19:49:17', '2021-01-26 19:49:17'),
(14, 4, 15, '2021-01-26 19:49:51', '2021-01-26 19:49:51'),
(15, 4, 16, '2021-01-26 19:49:58', '2021-01-26 19:49:58'),
(16, 5, 7, '2021-01-29 18:50:39', '2021-01-29 18:50:39'),
(17, 5, 15, '2021-02-22 13:14:15', '2021-02-22 13:14:15');

-- --------------------------------------------------------

--
-- Table structure for table `subaccounts`
--

CREATE TABLE `subaccounts` (
  `id` int(11) NOT NULL,
  `user_id` int(32) NOT NULL,
  `name` text,
  `email` text NOT NULL,
  `bank_id` int(32) NOT NULL,
  `country` int(32) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `amount` varchar(32) DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `acct_no` text,
  `acct_name` text,
  `active` int(1) DEFAULT '1',
  `account_type` text,
  `routing_number` text,
  `stripe_id` int(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subaccounts`
--

INSERT INTO `subaccounts` (`id`, `user_id`, `name`, `email`, `bank_id`, `country`, `type`, `amount`, `rate`, `currency`, `acct_no`, `acct_name`, `active`, `account_type`, `routing_number`, `stripe_id`, `created_at`, `updated_at`) VALUES
(1, 64, 'Sub Conta A', 'vagnercarvalho-02@hotmail.com', 6, 226, 2, '25', NULL, 'USD', '123', 'Vagner', 1, NULL, NULL, NULL, '2022-06-08 18:23:16', '2022-06-08 18:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(16) NOT NULL,
  `user_id` int(32) NOT NULL,
  `merchant_id` int(32) DEFAULT NULL,
  `plan_id` int(32) NOT NULL,
  `expiring_date` varchar(32) NOT NULL,
  `amount` varchar(32) DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `ref_id` varchar(32) NOT NULL,
  `status` int(1) DEFAULT '1',
  `times` int(32) DEFAULT NULL,
  `notify` int(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE `support` (
  `id` int(32) NOT NULL,
  `subject` text NOT NULL,
  `priority` varchar(8) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `files` text,
  `status` int(2) NOT NULL,
  `user_id` int(32) NOT NULL,
  `ticket_id` varchar(16) NOT NULL,
  `ref_no` varchar(32) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support`
--

INSERT INTO `support` (`id`, `subject`, `priority`, `message`, `type`, `files`, `status`, `user_id`, `ticket_id`, `ref_no`, `created_at`, `updated_at`) VALUES
(1, 'teste', 'Low', 'teste de ticket', 'request_money', '{\"lang\":{\"support_disputes\":\"Disputes\",\"support_open_ticket\":\"Open Ticket\",\"support_reply\":\"Reply\",\"support_delete\":\"Delete\",\"support_subject\":\"Subject\",\"support_transaction_reference\":\"Transaction Reference\",\"support_priority\":\"Priority\",\"support_status\":\"Status\",\"support_created\":\"Created\",\"support_updated\":\"Updated\",\"support_null\":\"Null\",\"support_open\":\"Open\",\"support_closed\":\"Closed\",\"support_resolved\":\"Resolved\",\"support_delete_ticket\":\"Delete Ticket\",\"support_support_confirm_delete\":\"Are you sure you want to delete this?, all replies to this ticket will be deleted\",\"support_proceed\":\"Proceed\",\"support_no_ticket_found\":\"No Ticket Found\",\"support_we_couldnt_find_any_ticket\":\"We couldn\'t find any ticket to this account\",\"support_new_ticket\":\"New Ticket\",\"support_reference\":\"Reference\",\"support_transaction_reference_number\":\"Transaction reference number\",\"support_low\":\"Low\",\"support_medium\":\"Medium\",\"support_high\":\"High\",\"support_type\":\"Type\",\"support_subscription\":\"Subscription\",\"support_money_transfer\":\"Money Transfer\",\"support_request_money\":\"Request Money\",\"support_settlement\":\"Settlement\",\"support_store\":\"Store\",\"support_single_charge\":\"Single Charge\",\"support_donation\":\"Donation\",\"support_invoice\":\"Invoice\",\"support_charges\":\"Charges\",\"support_bank_transfer\":\"Bank transfer\",\"support_deposit\":\"Deposit\",\"support_virtual_card\":\"Virtual Card\",\"support_bill_payment\":\"Bill payment\",\"support_cryptocurrency\":\"Cryptocurrency\",\"support_others\":\"Others\",\"support_details\":\"Details\",\"support_select_a_file\":\"Select a file\",\"support_choose_media\":\"Choose Media\",\"support_description\":\"Description\",\"support_save\":\"Save\",\"support_attachements\":\"Attachements\",\"support_log\":\"Log\",\"support_administrator\":\"Administrator\",\"support_staff\":\"Staff\",\"support_enter_your_message\":\"Enter your message...\",\"support_send\":\"Send\"},\"0\":\"support_t6cM8LXIkQ.jpg\"}', 0, 64, 'KrbWMi4KLlGPdnla', '123', '2022-07-12 03:35:06', '2022-07-12 03:35:06');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(32) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `card_number` varchar(32) DEFAULT NULL,
  `ip_address` varchar(32) DEFAULT NULL,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `sender_id` int(32) DEFAULT NULL,
  `receiver_id` int(32) NOT NULL,
  `amount` float NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `type` int(1) NOT NULL,
  `payment_type` varchar(32) DEFAULT NULL,
  `ref_id` varchar(32) NOT NULL,
  `status` int(1) DEFAULT '0',
  `payment_link` int(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pix_end_to_end_id` varchar(40) DEFAULT NULL,
  `pix_callback` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `email`, `card_number`, `ip_address`, `first_name`, `last_name`, `sender_id`, `receiver_id`, `amount`, `rate`, `currency`, `charge`, `type`, `payment_type`, `ref_id`, `status`, `payment_link`, `created_at`, `updated_at`, `pix_end_to_end_id`, `pix_callback`) VALUES
(1, NULL, NULL, '::1', NULL, NULL, 64, 64, 142.4, NULL, NULL, '7.6', 3, 'account', 'INV-zafBCT', 1, 1, '2022-07-24 22:46:48', '2022-07-25 01:46:48', NULL, NULL),
(2, NULL, NULL, '::1', NULL, NULL, 64, 64, 93.8, NULL, NULL, NULL, 3, 'account', 'INV-zKt66g', 0, 11, '2022-07-26 22:13:39', '2022-07-26 22:13:39', NULL, NULL),
(3, NULL, NULL, '127.0.0.1', NULL, NULL, NULL, 64, 93.8, NULL, NULL, '6.2', 3, 'pix', 'INV-ihdR1r', 1, 12, '2022-07-27 01:21:12', '2022-07-27 04:21:12', 'PUJQCE3UXFkWw4xU5A2KHOQsWV8fER6OaU0', '{\"endToEndId\":\"E60746948202103082223A7540Db1234\",\"txid\":\"PUJQCE3UXFkWw4xU5A2KHOQsWV8fER6OaU0\",\"valor\":\"100.00\",\"horario\":\"2022-07-26-19.24.41\",\"infoPagador\":null}');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(32) NOT NULL,
  `ref_id` varchar(32) NOT NULL,
  `amount` varchar(32) NOT NULL,
  `from_rate` varchar(32) DEFAULT NULL,
  `from_currency` varchar(32) DEFAULT NULL,
  `to_rate` varchar(32) DEFAULT NULL,
  `to_currency` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `sender_id` int(32) NOT NULL,
  `receiver_id` int(32) DEFAULT NULL,
  `temp` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trending`
--

CREATE TABLE `trending` (
  `id` int(8) NOT NULL,
  `title` text NOT NULL,
  `details` text NOT NULL,
  `image` varchar(64) NOT NULL,
  `cat_id` int(32) NOT NULL,
  `views` int(32) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trending`
--

INSERT INTO `trending` (`id`, `title`, `details`, `image`, `cat_id`, `views`, `status`, `created_at`, `updated_at`) VALUES
(9, 'Budget for Your Winter Trip to Cancun', '<p>It may be cold at home, but winter months are the peak season for Caribbean beaches, and for good reason: With beautiful scenery, tropical weather, and a dazzling array of adventure opportunities, a trip to sunny Mexico can be the perfect cure for the winter blues.</p>', 'post_1595630633.jpg', 2, 25, 1, '2020-08-21 08:49:28', '2020-08-21 07:49:28'),
(10, 'We are still choosing to help you grow your money and your confidence', '<p>We don’t have a crystal ball, and can’t predict when rates will change again, but we wanted to clearly communicate what’s happening today. We believe that maintaining our high Protected Goals Account rates—and rewarding the choice to save—will help our customers continue to feel confident with their money.</p>', 'post_1595630773.jpg', 2, 4, 1, '2020-07-24 22:46:14', '2020-07-24 21:46:14'),
(11, 'Prioritize your savings goals based on what you really want.', '<p>You know you should be saving, but what should you save for first? Prioritizing your savings goals can be confusing. Here’s how to sift through it all.</p>', 'post_1595630790.jpg', 2, 11, 1, '2021-01-09 14:34:53', '2021-01-09 14:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `trending_cat`
--

CREATE TABLE `trending_cat` (
  `id` int(8) NOT NULL,
  `categories` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trending_cat`
--

INSERT INTO `trending_cat` (`id`, `categories`, `created_at`, `updated_at`) VALUES
(2, 'Inspiration', '2020-01-24 22:13:56', '0000-00-00 00:00:00'),
(3, 'Company', '2020-01-24 22:13:56', '0000-00-00 00:00:00'),
(4, 'Engineering', '2020-01-24 22:13:56', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ui_design`
--

CREATE TABLE `ui_design` (
  `id` int(11) NOT NULL,
  `s6_title` text,
  `s7_title` text,
  `s7_body` text,
  `s7_image` varchar(32) DEFAULT NULL,
  `s8_image` varchar(32) DEFAULT NULL,
  `s8_title` text,
  `s8_body` text,
  `s9_image` varchar(32) DEFAULT NULL,
  `s9_title` text,
  `s9_body` text,
  `s6_body` text,
  `s5_title` text,
  `s5_body` text,
  `s4_title` text,
  `s4_body` text,
  `s4_image` varchar(32) DEFAULT NULL,
  `s3_title` text,
  `s3_body` text,
  `s3_image` varchar(32) DEFAULT NULL,
  `s2_image` varchar(32) DEFAULT NULL,
  `s2_title` text,
  `s2_body` text,
  `s1_title` text,
  `header_title` text,
  `header_body` text,
  `nav_type` int(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ui_design`
--

INSERT INTO `ui_design` (`id`, `s6_title`, `s7_title`, `s7_body`, `s7_image`, `s8_image`, `s8_title`, `s8_body`, `s9_image`, `s9_title`, `s9_body`, `s6_body`, `s5_title`, `s5_body`, `s4_title`, `s4_body`, `s4_image`, `s3_title`, `s3_body`, `s3_image`, `s2_image`, `s2_title`, `s2_body`, `s1_title`, `header_title`, `header_body`, `nav_type`, `created_at`, `updated_at`) VALUES
(1, 'Accepting payments worldwide', 'What our happy client say about our success', 'Boompay is backed by notable investors as well as some of the best payments companies on the planet.', 'section7_1595629930.png', 'section8_1586432780.png', 'Reliable asset program', 'Join our program and learn to invest on asset. Earn from buying, selling and exchanging assets. Asset can also be transferred within platform. The value of asset changes every 1hour based on live market prices', 'section9_1586432802.png', 'Easy access to loan', 'We charge 10% of loaned amount as interest fee. Balance must exceed or equal to 50% of loaned amount as collateral. Participation in save 4 me & PY scheme will not be allowed until loan is paid.', 'Boost your sales with our modular service portfolio. For one, you can accept and process payments via various sales channels.', 'Build your savings without even trying.', 'Turn on Round-up Rules and start saving up effortlessly. Whenever you make a purchase, Goals make it easy to save for the things you want or want to do. There’s no need for spreadsheets or extra apps to budget and track your money.', 'Reliable asset program', 'Join our program and learn to invest on asset. Earn from buying, selling and exchanging assets. Asset can also be transferred within platform. The value of asset changes every 1hour based on live market prices', 'section3_1612152049.png', 'Optimize your business processes with your own solutions', 'Introduce your own payment solution for your customers and employees to use worldwide. Everything is possible, from card products all the way to digital banking and payment apps.\r\n\r\nWe’re your specialists for issuing and technically integrating payment solutions. With us, you get everything from one source: modular end-to-end solutions, flexibly configurable white-label products.', 'section2_1595626647.png', 'section1_1595628336.png', 'Trusted by 60,000+ businesses', '<p>Over 10,000 businesses of all sizes use Boompay to accept payments online, including some of Africa\'s biggest brands.</p>\n<p>Your customers will love the simple, secure payment experience, and if you need any help, our friendly Support team is only a quick phone call (or email) away.</p>\n<p>Thank you for choosing Boompay. We look forward to being a reliable growth engine and partner to you, your team, and your business.</p>', 'Market leaders use app to reach their brand & business.', 'The easy way to pay is right here', 'Give your customers the gift of modern, frictionless, painless payments. Integrate once and let your customers pay you however they want.', 1, '2021-02-01 04:00:49', '2021-02-01 04:00:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `stripe_id` text,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) NOT NULL,
  `image` varchar(32) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `support_email` text,
  `balance` varchar(32) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL,
  `pay_support` varchar(32) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `ip_address` varchar(32) NOT NULL,
  `last_login` varchar(32) DEFAULT NULL,
  `kyc_link` varchar(32) DEFAULT NULL,
  `kyc_status` int(2) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `office_address` text,
  `website_link` text,
  `developer` int(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verification_code` varchar(191) NOT NULL,
  `email_verify` tinyint(4) NOT NULL,
  `email_time` datetime NOT NULL,
  `googlefa_secret` varchar(32) DEFAULT NULL,
  `fa_status` int(1) NOT NULL DEFAULT '0',
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `fa_expiring` varchar(32) DEFAULT NULL,
  `public_key` varchar(64) NOT NULL,
  `secret_key` varchar(64) NOT NULL,
  `business_level` int(1) NOT NULL DEFAULT '1',
  `shipping` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `stripe_id`, `first_name`, `last_name`, `business_name`, `image`, `email`, `support_email`, `balance`, `country`, `pay_support`, `password`, `phone`, `status`, `ip_address`, `last_login`, `kyc_link`, `kyc_status`, `remember_token`, `office_address`, `website_link`, `developer`, `created_at`, `updated_at`, `verification_code`, `email_verify`, `email_time`, `googlefa_secret`, `fa_status`, `facebook`, `twitter`, `instagram`, `linkedin`, `youtube`, `fa_expiring`, `public_key`, `secret_key`, `business_level`, `shipping`) VALUES
(63, NULL, 'Castro', 'King', 'Boomchart', 'person.png', 'info@boomchart.net', NULL, '2572.835', '80', '5', '$2y$10$jMnZixaUrf./DBzXx/yuBef9f0PRM1TinSxCgmTBKAzXwR3YJhJHO', '3456789654', 0, '::1', '2021-05-20 22:05:08', NULL, 0, 'o2qtGXlPJzEZwMVisPZAH1vdpnIwhUBVVNyaKR3RUSPlnf3WiMqwwhI9SlJ5', NULL, NULL, 0, '2021-03-19 23:11:47', '2022-07-06 09:55:30', 'JRJCMC', 1, '2021-03-19 18:16:47', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'PUB-GxS3nU6Nv2OCCfkxr13JHDN1gBpCVTcn', 'SEC-RqqCdiunJPhw7lWH0L9tA1RYwzmZwwft', 1, 0),
(64, NULL, 'Vagner', 'Carvalho', 'Vagner Carvalho', 'person.png', 'vagnercarvalho.vfc@gmail.com', NULL, '100', '226', '8', '$2y$10$omJz9NNDQ9iUkemkucLnKuGg/n.tcOqMzKnNqpIc78o1Z5nbR8jCa', '11976066557', 0, '::1', '2022-08-02 02:42:42', NULL, 0, 'VZPsGchPWDT90gHZfJQftMwM86ZpUP8laLuOLLJ9VZG6IFL8KclkBoifLdZZ', NULL, NULL, 0, '2022-06-08 23:21:40', '2022-08-02 06:45:36', 'ZDWPRG', 1, '2022-06-08 14:26:39', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2022-08-02 03:15:36', 'PUB-MzGTqzUY9K2FXW7FxbGqd0aJFFkym20Q', 'SEC-r2hupazMuHopMUK0lfGWzrT7MdF9fd7b', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `virtual_cards`
--

CREATE TABLE `virtual_cards` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `first_name` text,
  `last_name` text,
  `account_id` int(16) NOT NULL,
  `card_hash` varchar(64) NOT NULL,
  `card_pan` varchar(32) NOT NULL,
  `masked_card` varchar(32) NOT NULL,
  `cvv` varchar(6) NOT NULL,
  `expiration` varchar(16) NOT NULL,
  `card_type` varchar(32) NOT NULL,
  `name_on_card` text NOT NULL,
  `callback` text NOT NULL,
  `secret` varchar(32) DEFAULT NULL,
  `amount` varchar(32) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `charge` varchar(32) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `ref_id` varchar(32) DEFAULT NULL,
  `city` text,
  `state` text,
  `address` text,
  `zip_code` text,
  `bg` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `virtual_cards`
--

INSERT INTO `virtual_cards` (`id`, `user_id`, `first_name`, `last_name`, `account_id`, `card_hash`, `card_pan`, `masked_card`, `cvv`, `expiration`, `card_type`, `name_on_card`, `callback`, `secret`, `amount`, `rate`, `currency`, `charge`, `status`, `ref_id`, `city`, `state`, `address`, `zip_code`, `bg`, `created_at`, `updated_at`) VALUES
(8, 41, NULL, NULL, 118661, '993b7edd-de5a-4d13-96ca-4cae52807f2c', '5366139800942370', '536613*******2370', '208', '2024-01', 'mastercard', 'idbjfd jhcdd', 'http://localhost/new-pay/use-virtual', 'VC-LjBDgP', '0', NULL, NULL, '300', 0, 'VC-LjBDgP', NULL, NULL, NULL, NULL, NULL, '2021-01-20 13:36:22', '2021-02-09 20:50:38'),
(9, 44, NULL, NULL, 118661, 'e9bc954b-261c-4d70-a1c5-2c64fd3c716c', '5366135864840013', '536613*******0013', '799', '2024-01', 'mastercard', 'Rashford kim', 'http://localhost/new-pay/use-virtual', 'VC-C4nBtK', '3000.00', NULL, NULL, '300', 1, 'VC-C4nBtK', NULL, NULL, NULL, NULL, NULL, '2021-01-21 10:20:34', '2022-07-06 03:57:35'),
(10, 48, NULL, NULL, 118661, '261c4a37-7cc1-4a92-9411-c2c979e9f991', '5366132423730116', '536613*******0116', '149', '2024-01', 'mastercard', 'fghj dfghj', 'http://localhost/new-pay/use-virtual', 'VC-lnYXIr', '6000.00', NULL, NULL, '500', 1, 'VC-lnYXIr', NULL, NULL, NULL, NULL, NULL, '2021-01-28 12:52:25', '2021-01-28 12:53:36'),
(11, 48, NULL, NULL, 118661, '0d3b95be-4aee-4092-bac2-d48b7ae32ce0', '5563388086145536', '556338*******5536', '843', '2024-01', 'mastercard', 'fghj dfghj', 'http://localhost/new-pay/use-virtual', 'VC-U2m2hN', '4000.00', NULL, NULL, '400', 1, 'VC-U2m2hN', NULL, NULL, NULL, NULL, NULL, '2021-01-28 12:57:19', '2022-07-06 03:57:41'),
(12, 41, NULL, NULL, 118661, '97560e24-3542-44a7-a507-cc47e58ffc55', '5563388648907886', '556338*******7886', '156', '2024-01', 'mastercard', 'idbjfd jhcdd', 'http://localhost/new-pay/use-virtual', 'VC-ZA7hEb', '0', NULL, NULL, '1000', 0, 'VC-ZA7hEb', NULL, NULL, NULL, NULL, NULL, '2021-01-28 16:43:53', '2021-01-31 14:44:06'),
(13, 41, NULL, NULL, 118661, '460606e6-45b4-4600-86a6-3e80d78fc1fe', '5366138187338285', '536613*******8285', '989', '2024-01', 'mastercard', 'idbjfd jhcdd', 'http://localhost/new-pay/use-virtual', 'VC-xEYulb', '5000.00', NULL, NULL, '500', 0, 'VC-xEYulb', 'Lekki', 'Lagos', NULL, '23401', NULL, '2021-01-31 14:52:17', '2022-07-06 03:58:05'),
(14, 63, NULL, NULL, 118661, '47fc80af-ef5f-4e84-8ccf-93dbb5103617', '5563389938791014', '556338*******1014', '688', '2024-03', 'mastercard', 'Castro King', 'http://localhost/boompay/single/use-virtual', 'VC-pOBkBz', '0', NULL, NULL, '25.1', 2, 'VC-pOBkBz', 'Hillside', 'New jersey', NULL, '07205', 'bg-morpheusden', '2021-03-19 17:14:57', '2021-03-20 09:40:47'),
(15, 63, NULL, NULL, 118661, 'ca2fc8be-704e-4f38-824f-cec733327329', '5563385675497930', '556338*******7930', '807', '2024-03', 'mastercard', 'Castro King', 'http://localhost/boompay/single/use-virtual', 'VC-tlKOZt', '392.00', NULL, NULL, '5.15', 1, 'VC-tlKOZt', 'Hillside', 'New jersey', NULL, '07205', 'bg-sharpblues', '2021-03-20 05:55:10', '2021-03-27 05:05:53'),
(16, 63, NULL, NULL, 118661, '9271ad0a-6121-4ed8-acaf-f777651746f5', '5563381566629608', '556338*******9608', '873', '2024-03', 'mastercard', 'Castro.\' \'.King', 'http://localhost/boompay/single/use-virtual', 'VC-0cpMQ6', '60.00', NULL, NULL, '5.72', 1, 'VC-0cpMQ6', 'Hillside', 'New jersey', '471 mundet pl', '07205', 'bg-newlife', '2021-03-20 06:36:14', '2021-03-27 05:05:49'),
(17, 63, NULL, NULL, 118661, 'ce064874-3448-4442-84a0-aa6fcfb7fb65', '5563382647470517', '556338*******0517', '615', '2024-03', 'mastercard', 'Castro King', 'http://localhost/boompay/single/use-virtual', 'VC-2AzG5i', '0', NULL, NULL, '6.86', 2, 'VC-2AzG5i', 'Hillside', 'New jersey', '471 mundet pl', '07205', 'bg-deepblue', '2021-03-20 06:37:44', '2021-03-20 09:14:35'),
(18, 63, 'Chidid', 'Inydkbfh', 118661, '28c67b26-d9f3-4def-8e2c-acd3028e56f4', '5563388615947741', '556338*******7741', '30', '2024-03', 'mastercard', 'Chidid Inydkbfh', 'http://localhost/boompay/single/use-virtual', 'VC-eAJdYs', '0', NULL, NULL, '6.86', 1, 'VC-eAJdYs', 'Hillside', 'New jersey', '471 mundet pl', '07205', 'bg-fabledsunset', '2021-03-20 06:43:44', '2022-07-06 03:58:20'),
(20, 63, 'Duff', 'dfee', 118661, 'e12c7227-b273-48f8-9c90-91c78b6c478a', '5563382357214717', '556338*******4717', '986', '2024-03', 'mastercard', 'Duff dfee', 'http://localhost/boompay/single/use-virtual', 'VC-BHRhYk', '0', NULL, NULL, '19.4', 1, 'VC-BHRhYk', 'Hillside', 'New jersey', '471 mundet pl', '07205', '', '2021-03-20 14:08:16', '2022-07-06 03:58:23'),
(21, 63, 'asdfg', 'asdfgh', 118661, '979db673-a61b-4b13-9fc4-1e4ecaca4511', '5563384530260609', '556338*******0609', '749', '2024-03', 'mastercard', 'asdfg asdfgh', 'http://localhost/boompay/single/use-virtual', 'VC-JbFqnC', '0', NULL, NULL, '20.597', 1, 'VC-JbFqnC', 'Hillside', 'New jersey', '471 mundet pl', '07205', 'bg-white', '2021-03-20 14:28:11', '2022-07-06 03:58:26'),
(22, 63, 'Chidi', 'Inymama', 118661, 'd6c575a8-00b5-40ce-be1d-de7827d07a46', '5563386979381895', '556338*******1895', '741', '2024-03', 'mastercard', 'Chidi Inymama', 'http://localhost/boompay/single/use-virtual', 'VC-aCyGjR', '345.00', NULL, NULL, '21.965', 1, 'VC-aCyGjR', 'Hillside', 'New jersey', '471 mundet pl', '07205', 'bg-morpheusden', '2021-03-20 20:51:38', '2021-03-27 05:05:31'),
(23, 63, 'Chids', 'fev', 118661, 'f4bd9f02-2bcd-4082-b9af-9a195e90ffe3', '5563388761987871', '556338*******7871', '375', '2024-03', 'mastercard', 'Chids fev', 'http://localhost/boompay/single/use-virtual', 'VC-vywam6', '0', NULL, NULL, '5.15', 1, 'VC-vywam6', 'Hillside', 'New jersey', '471 mundet pl', '07205', 'bg-fruitblend', '2021-03-21 11:40:38', '2022-07-06 03:58:32');

-- --------------------------------------------------------

--
-- Table structure for table `virtual_transactions`
--

CREATE TABLE `virtual_transactions` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `virtual_id` text NOT NULL,
  `amount` varchar(32) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `description` text NOT NULL,
  `trx` varchar(32) NOT NULL,
  `type` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `w_history`
--

CREATE TABLE `w_history` (
  `id` int(32) NOT NULL,
  `reference` varchar(32) NOT NULL,
  `secret` varchar(6) DEFAULT NULL,
  `user_id` int(32) NOT NULL,
  `amount` varchar(32) NOT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `status` int(2) NOT NULL,
  `bank_id` varchar(32) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `sub_id` int(32) DEFAULT NULL,
  `next_settlement` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_site`
--
ALTER TABLE `about_site`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_bank`
--
ALTER TABLE `admin_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_supported`
--
ALTER TABLE `bank_supported`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_transfer`
--
ALTER TABLE `bank_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_transactions`
--
ALTER TABLE `bill_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `btc_trades`
--
ALTER TABLE `btc_trades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compliance`
--
ALTER TABLE `compliance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_supported`
--
ALTER TABLE `country_supported`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ext_transfer`
--
ALTER TABLE `ext_transfer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_key` (`merchant_key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `merchant_key` (`merchant_key`),
  ADD KEY `merchant_key_2` (`merchant_key`),
  ADD KEY `id` (`id`),
  ADD KEY `merchant_key_3` (`merchant_key`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_link`
--
ALTER TABLE `payment_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reply_support`
--
ALTER TABLE `reply_support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sell_cards`
--
ALTER TABLE `sell_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storefront`
--
ALTER TABLE `storefront`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storefront_products`
--
ALTER TABLE `storefront_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subaccounts`
--
ALTER TABLE `subaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trending`
--
ALTER TABLE `trending`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trending_cat`
--
ALTER TABLE `trending_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_design`
--
ALTER TABLE `ui_design`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `virtual_cards`
--
ALTER TABLE `virtual_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `virtual_transactions`
--
ALTER TABLE `virtual_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `w_history`
--
ALTER TABLE `w_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_bank`
--
ALTER TABLE `admin_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=718;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `bank_supported`
--
ALTER TABLE `bank_supported`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bank_transfer`
--
ALTER TABLE `bank_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_transactions`
--
ALTER TABLE `bill_transactions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `btc_trades`
--
ALTER TABLE `btc_trades`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=501;

--
-- AUTO_INCREMENT for table `compliance`
--
ALTER TABLE `compliance`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `country_supported`
--
ALTER TABLE `country_supported`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `ext_transfer`
--
ALTER TABLE `ext_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=507;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment_link`
--
ALTER TABLE `payment_link`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `reply_support`
--
ALTER TABLE `reply_support`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sell_cards`
--
ALTER TABLE `sell_cards`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `storefront`
--
ALTER TABLE `storefront`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storefront_products`
--
ALTER TABLE `storefront_products`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `subaccounts`
--
ALTER TABLE `subaccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support`
--
ALTER TABLE `support`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trending`
--
ALTER TABLE `trending`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `trending_cat`
--
ALTER TABLE `trending_cat`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ui_design`
--
ALTER TABLE `ui_design`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `virtual_cards`
--
ALTER TABLE `virtual_cards`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `virtual_transactions`
--
ALTER TABLE `virtual_transactions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `w_history`
--
ALTER TABLE `w_history`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
