-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 04, 2024 at 09:09 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE DATABASE IF NOT EXISTS response CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE response;

--
-- Database: `Response`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(45) DEFAULT NULL,
  `admin_password` varchar(200) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `response_status` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_email`, `admin_password`, `last_login`, `response_status`) VALUES
(1, 'biolanene@hotmail.com', '$2y$10$RxcWF.itrpuiQ9kJwxJTAumA5HivN1thaiebIV7L8UzI.f4jmGFyK', '2024-05-06 14:27:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Medical'),
(2, 'Fire'),
(3, 'Accident'),
(4, 'Theft/Crime'),
(6, 'Ambulance Service'),
(7, 'Flood'),
(8, 'Building Collapse'),
(9, 'Road Accident'),
(10, 'Gas Leak / Explosion'),
(11, 'Kidnapping'),
(12, 'Domestic Violence'),
(13, 'Electrocution'),
(14, 'Drowning'),
(15, 'Civil Unrest / Riot');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_activity`
--

CREATE TABLE `emergency_activity` (
  `activity_id` int(11) NOT NULL,
  `activity` varchar(200) DEFAULT NULL,
  `desc` varchar(250) DEFAULT NULL,
  `emergency_time` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `alert_id` int(11) DEFAULT NULL,
  `emergency_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_alert_response_unit`
--

CREATE TABLE `emergency_alert_response_unit` (
  `response_id` int(11) NOT NULL,
  `reason_status` varchar(300) DEFAULT NULL,
  `request` varchar(200) DEFAULT NULL,
  `alert_id` int(11) DEFAULT NULL,
  `emergency_id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_alert_table`
--

CREATE TABLE `emergency_alert_table` (
  `alert_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_fullname` varchar(250) DEFAULT NULL,
  `user_phone` varchar(250) DEFAULT NULL,
  `user_location` varchar(100) DEFAULT NULL,
  `emergency_type` int(11) NOT NULL,
  `alert_status` varchar(100) DEFAULT NULL,
  `alert_time` timestamp(6) NULL DEFAULT NULL,
  `emergency_alert_image` varchar(200) DEFAULT NULL,
  `emergency_alert_video` varchar(200) DEFAULT NULL,
  `alert_desc` varchar(250) DEFAULT NULL,
  `responseunit_id` int(11) DEFAULT NULL,
  `emergency_alert_comment` varchar(200) DEFAULT NULL,
  `lga_id` int(11) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emergency_alert_table`
--

INSERT INTO `emergency_alert_table` (`alert_id`, `user_id`, `user_fullname`, `user_phone`, `user_location`, `emergency_type`, `alert_status`, `alert_time`, `emergency_alert_image`, `emergency_alert_video`, `alert_desc`, `responseunit_id`, `emergency_alert_comment`, `lga_id`) VALUES
(1, NULL, 'Abimbola Agbaleke', '09022302201', '14b Oke-arin Street, Ilupeju', 4, 'severe', '2024-05-31 17:25:00.000000', '17171769982116229514.12', '171717699846987277.37', 'Hello', NULL, NULL, 503),
(2, NULL, 'Abimbola Agbaleke', '09022302201', '14b Oke-arin Street, Ilupeju', 4, 'severe', '2024-05-31 17:25:00.000000', '1717177048841985435.12', '17171770481360337602.37', 'Hello', NULL, NULL, 503),
(3, NULL, 'Abimbola Agbaleke', '09022302201', '14b Oke-arin Street, Ilupeju', 4, 'severe', '2024-05-31 17:25:00.000000', '17171771171723771105.12', '17171771171732939541.37', 'Hello', NULL, NULL, 513),
(4, NULL, 'Abimbola Agbaleke', '09022302201', '14b Oke-arin Street, Ilupeju', 4, 'severe', '2024-05-31 17:25:00.000000', '17171772231116033481.12', '17171772231736865264.37', 'Hello', NULL, NULL, 510),
(5, NULL, 'Abimbola Agbaleke', '09022302201', '22, Itire road, Surulere', 4, 'severe', '2024-05-31 17:25:00.000000', '1717177246605107735.12', '17171772461235464866.37', 'Hello', NULL, NULL, 510),
(6, NULL, 'Abimbola Agbaleke', '09022302201', '9 Davies Street, Abule-Oja, Yaba, Lagos', 1, 'severe', '2024-05-31 17:25:00.000000', '17171773001123899564.12', '1717177300983251715.37', 'Hello', NULL, NULL, 517),
(7, NULL, 'Abimbola Agbaleke', '09022302201', '7 Campus, street', 2, 'severe', '2024-05-31 17:25:00.000000', '1717177321538153827.12', '17171773211619569803.37', 'Hello', NULL, NULL, 520),
(8, NULL, 'Abiola Michael', '07029292922', '14b Oke-arin Street, Ilupeju', 1, 'moderate', '2024-06-04 18:03:00.000000', '17175242452075507793.jpeg', '171752424573195977.jpg', 'fire', NULL, NULL, 516);

-- --------------------------------------------------------

--
-- Table structure for table `fire_unit`
--

CREATE TABLE `fire_unit` (
  `fire_unit_id` int(11) NOT NULL,
  `fire_unit_name` varchar(150) DEFAULT NULL,
  `store_unit_name` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `fire_unit_address` varchar(200) DEFAULT NULL,
  `fire_unit_phone_number` varchar(50) DEFAULT NULL,
  `fire_unit_type` varchar(100) DEFAULT NULL,
  `fire_unit_location` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fire_unit`
--

INSERT INTO `fire_unit` (`fire_unit_id`, `fire_unit_name`, `store_unit_name`, `category_id`, `fire_unit_address`, `fire_unit_phone_number`, `fire_unit_type`, `fire_unit_location`) VALUES
(1, 'Alausa (HQ)', '', 2, 'Governor Road, The Secretariat, Alausa, Ikeja', '08033235891', 'Lagos State Fire Service', 513),
(2, 'Ikeja Fire Station', '', 2, 'Powa Market, 57 Mobolaji Bank Anthony Way, Ikeja', '08032219746', 'State Fire Service', 513),
(3, 'Ilupeju Fire Station', '', 2, 'Ikorodu Road, Anthony Bus Stop, Ilupeju.', '08033235891', 'State Fire Service', 518),
(4, 'Isolo Fire Station', '', 2, 'Oshodi/Apapa Exp. Way, Toyota Bus Stop, Isolo,', '07011555524', 'State Fire Service', 520),
(5, 'Airport Road Federal Fire Station', '', 2, ' Airport Rd, Lagos, Ikeja,', '08032219746', 'Federal Fire Service', 513),
(6, 'Bolade Fire Station', '', 2, 'Safety Arena, Bolade Bus Stop, Oshodi,', '07011555542', 'State Fire Service', 520),
(7, 'Badagry Fire Station', '', 2, 'Topo-ASCON Road, Badagry', '08033817515', 'State Fire Service', 508),
(8, 'Agege Fire Station', '', 2, 'Abeokuta Express Way, Ilepo Bus Stop, Oke Odo', '08185704012', 'State Fire Service', 503),
(9, 'Ikorodu Fire Station', '', 2, 'Ikorodu/Shagamu Road, Odogunya, Ikorodu.', '08032220495', 'State Fire Service', 514),
(10, 'Sari-Iganmu Fire Station', '', 2, 'Bola Ahmed Tinubu Tanker Terminal, Sari Iganmu', '08067026444', 'State Fire Service', 522),
(11, 'Ikotun Fire Station', '', 2, 'Ikotun/Igando Council Secretariat, Ikotun', '07063393240', 'State Fire Service', 505),
(12, 'Lekki Phase II Fire Station', '', 2, 'Off Abraham Adesanya Estate, Ogombo-Ajah', '07063393241', 'State Fire Service', 510),
(13, 'Ojo Fire Station', '', 2, 'Ojo Council Secretariat, Olojo Drive, Ojo, Lagos.', '07063393242', 'State Fire Service', 519),
(14, 'Abesan Fire Station', '', 2, 'Abesan Housing Estate, Ipaja.', '08135659817', 'State Fire Service', 505),
(15, 'Ejigbo Fire Station', '', 2, 'Ejigbo Council Secretariat, Ikotun Egbe Road, NNPC Bus Stop, Ejigbo.', '09055694396', 'State Fire Service', 505),
(16, 'Unilag Fire Service', '', 2, 'University of Lagos, Akoka, Lagos', '+234 7086196426', 'Federal Fire Service', 517),
(17, 'Federal Fire Service', '', 2, '27 Awolowo Rd Ikoyi,', '09055694396', 'Federal Fire Service', 510),
(18, 'Federal Fire Service Festac Town', '', 2, 'Festac Town.', '09055694396', 'Federal Fire Service', 506),
(19, 'Federal Fire Service  Surulere', '', 2, '92 Clegg St, Ojuelegba.', '08032003557', 'Federal Fire Service', 522),
(21, 'Federal Fire Service Ebute-Metta', '', 2, 'Savage St, Ebute Metta, Lagos', '08069051020', 'Federal Fire Service', 517),
(22, 'Federal Fire Service Apapa', '', 2, 'Malu Road, Apapa, Lagos', '', 'Federal Fire Service', 507),
(23, 'Lagos State Fire Service Ajao Estate', '', 2, '9 Canal View Layout, Ajao Estate, Lagos', '', 'State Fire Service', 520),
(24, 'Unilag Fire Station High Rise Station', '', 2, 'Eni-Njoku Rd, Lagos Mainland, Lagos.', '07086196426', 'Federal Fire Service', 517),
(25, 'Lekki Fire Service', '', 2, 'Laura Stephens Rd, Eti-Osa, Lekki, Lagos.', '', 'State Fire Service', 510),
(26, 'Federal Fire Service Ikoyi', '', 2, 'Ikoyi, 27 Awolowo Rd, Lagos', '08166215398', 'Federal Fire Service', 510),
(27, 'Lagos State Fire Service Ebute-Elefun', '', 2, 'Adeniji Adele Rd, Lagos Island, Lagos', '09055694396', 'State Fire Service', 516),
(28, 'Lagos State Fire Service Ajegunle', '', 2, '220 Ojo Rd, Alaba, Lagos 102103, Lagos', '08033235891', 'State Fire Service', 519),
(29, 'Lagos State Fire Service Onikan', '', 2, 'Opposite City Mall, Onikan, Awolowo Rd, Lagos', '08033235891', 'State Fire Service', 516);

-- --------------------------------------------------------

--
-- Table structure for table `lga`
--

CREATE TABLE `lga` (
  `lga_id` int(11) NOT NULL,
  `lga_name` varchar(60) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lga`
--

INSERT INTO `lga` (`lga_id`, `lga_name`, `state_id`) VALUES
(1, 'Aba North', 1),
(2, 'Aba South', 1),
(3, 'Arochukwu', 1),
(4, 'Bende', 1),
(5, 'Ikwuano', 1),
(6, 'Isiala-Ngwa North', 1),
(7, 'Isiala-Ngwa South', 1),
(8, 'Isikwuato', 1),
(9, 'Nneochi', 1),
(10, 'Obi-Ngwa', 1),
(11, 'Ohafia', 1),
(12, 'Osisioma', 1),
(13, 'Ugwunagbo', 1),
(14, 'Ukwa East', 1),
(15, 'Ukwa West', 1),
(16, 'Umuahia North', 1),
(17, 'Umuahia South', 1),
(18, 'Demsa', 2),
(19, 'Fufore', 2),
(20, 'Genye', 2),
(21, 'Girei', 2),
(22, 'Gombi', 2),
(23, 'guyuk', 2),
(24, 'Hong', 2),
(25, 'Jada', 2),
(26, 'Jimeta', 2),
(27, 'Lamurde', 2),
(28, 'Madagali', 2),
(29, 'Maiha', 2),
(30, 'Mayo Belwa', 2),
(31, 'Michika', 2),
(32, 'Mubi North', 2),
(33, 'Mubi South', 2),
(34, 'Numan', 2),
(35, 'Shelleng', 2),
(36, 'Song', 2),
(37, 'Toungo', 2),
(38, 'Yola', 2),
(39, 'Abak', 3),
(40, 'Eastern-Obolo', 3),
(41, 'Eket', 3),
(42, 'Ekpe-Atani', 3),
(43, 'Essien-Udim', 3),
(44, 'Esit Ekit', 3),
(45, 'Etim-Ekpo', 3),
(46, 'Etinam', 3),
(47, 'Ibeno', 3),
(48, 'Ibesikp-Asitan', 3),
(49, 'Ibiono-Ibom', 3),
(50, 'Ika', 3),
(51, 'Ikono', 3),
(52, 'Ikot-Abasi', 3),
(53, 'Ikot-Ekpene', 3),
(54, 'Ini', 3),
(55, 'Itu', 3),
(56, 'Mbo', 3),
(57, 'Mkpae-Enin', 3),
(58, 'Nsit-Ibom', 3),
(59, 'Nsit-Ubium', 3),
(60, 'Obot-Akara', 3),
(61, 'Okobo', 3),
(62, 'Onna', 3),
(63, 'Oron', 3),
(64, 'Oro-Anam', 3),
(65, 'Udung-Uko', 3),
(66, 'Ukanefun', 3),
(67, 'Uru Offong Oruko', 3),
(68, 'Uruan', 3),
(69, 'Uquo Ibene', 3),
(70, 'Uyo', 3),
(71, 'Aguata', 4),
(72, 'Anambra', 4),
(73, 'Anambra West', 4),
(74, 'Anocha', 4),
(75, 'Awka- North', 4),
(76, 'Awka-South', 4),
(77, 'Ayamelum', 4),
(78, 'Dunukofia', 4),
(79, 'Ekwusigo', 4),
(80, 'Idemili-North', 4),
(81, 'Idemili-South', 4),
(82, 'Ihiala', 4),
(83, 'Njikoka', 4),
(84, 'Nnewi-North', 4),
(85, 'Nnewi-South', 4),
(86, 'Ogbaru', 4),
(87, 'Onisha North', 4),
(88, 'Onitsha South', 4),
(89, 'Orumba North', 4),
(90, 'Orumba South', 4),
(91, 'Oyi', 4),
(92, 'Alkaleri', 5),
(93, 'Bauchi', 5),
(94, 'Bogoro', 5),
(95, 'Damban', 5),
(96, 'Darazo', 5),
(97, 'Dass', 5),
(98, 'Gamawa', 5),
(99, 'Ganjuwa', 5),
(100, 'Giade', 5),
(101, 'Itas/Gadau', 5),
(102, 'Jama\'are', 5),
(103, 'Katagum', 5),
(104, 'Kirfi', 5),
(105, 'Misau', 5),
(106, 'Ningi', 5),
(107, 'Shira', 5),
(108, 'Tafawa-Balewa', 5),
(109, 'Toro', 5),
(110, 'Warji', 5),
(111, 'Zaki', 5),
(112, 'Brass', 6),
(113, 'Ekerernor', 6),
(114, 'Kolokuma/Opokuma', 6),
(115, 'Nembe', 6),
(116, 'Ogbia', 6),
(117, 'Sagbama', 6),
(118, 'Southern-Ijaw', 6),
(119, 'Yenegoa', 6),
(120, 'Kembe', 6),
(121, 'Ado', 7),
(122, 'Agatu', 7),
(123, 'Apa', 7),
(124, 'Buruku', 7),
(125, 'Gboko', 7),
(126, 'Guma', 7),
(127, 'Gwer-East', 7),
(128, 'Gwer-West', 7),
(129, 'Katsina-Ala', 7),
(130, 'Konshisha', 7),
(131, 'Kwande', 7),
(132, 'Logo', 7),
(133, 'Makurdi', 7),
(134, 'Obi', 7),
(135, 'Ogbadibo', 7),
(136, 'Ohimini', 7),
(137, 'Oju', 7),
(138, 'Okpokwu', 7),
(139, 'Otukpo', 7),
(140, 'Tarkar', 7),
(141, 'Vandeikya', 7),
(142, 'Ukum', 7),
(143, 'Ushongo', 7),
(144, 'Abadan', 8),
(145, 'Askira-Uba', 8),
(146, 'Bama', 8),
(147, 'Bayo', 8),
(148, 'Biu', 8),
(149, 'Chibok', 8),
(150, 'Damboa', 8),
(151, 'Dikwa', 8),
(152, 'Gubio', 8),
(153, 'Guzamala', 8),
(154, 'Gwoza', 8),
(155, 'Hawul', 8),
(156, 'Jere', 8),
(157, 'Kaga', 8),
(158, 'Kala/Balge', 8),
(159, 'Kukawa', 8),
(160, 'Konduga', 8),
(161, 'Kwaya-Kusar', 8),
(162, 'Mafa', 8),
(163, 'Magumeri', 8),
(164, 'Maiduguri', 8),
(165, 'Marte', 8),
(166, 'Mobbar', 8),
(167, 'Monguno', 8),
(168, 'Ngala', 8),
(169, 'Nganzai', 8),
(170, 'Shani', 8),
(171, 'Abi', 9),
(172, 'Akamkpa', 9),
(173, 'Akpabuyo', 9),
(174, 'Bakassi', 9),
(175, 'Bekwara', 9),
(176, 'Biasi', 9),
(177, 'Boki', 9),
(178, 'Calabar-Municipal', 9),
(179, 'Calabar-South', 9),
(180, 'Etunk', 9),
(181, 'Ikom', 9),
(182, 'Obantiku', 9),
(183, 'Ogoja', 9),
(184, 'Ugep North', 9),
(185, 'Yakurr', 9),
(186, 'Yala', 9),
(187, 'Aniocha North', 10),
(188, 'Aniocha South', 10),
(189, 'Bomadi', 10),
(190, 'Burutu', 10),
(191, 'Ethiope East', 10),
(192, 'Ethiope West', 10),
(193, 'Ika North East', 10),
(194, 'Ika South', 10),
(195, 'Isoko North', 10),
(196, 'Isoko South', 10),
(197, 'Ndokwa East', 10),
(198, 'Ndokwa West', 10),
(199, 'Okpe', 10),
(200, 'Oshimili North', 10),
(201, 'Oshimili South', 10),
(202, 'Patani', 10),
(203, 'Sapele', 10),
(204, 'Udu', 10),
(205, 'Ughilli North', 10),
(206, 'Ughilli South', 10),
(207, 'Ukwuani', 10),
(208, 'Uvwie', 10),
(209, 'Warri Central', 10),
(210, 'Warri North', 10),
(211, 'Warri South', 10),
(212, 'Abakaliki', 11),
(213, 'Ofikpo North', 11),
(214, 'Ofikpo South', 11),
(215, 'Ebonyi', 11),
(216, 'Ezza North', 11),
(217, 'Ezza South', 11),
(218, 'ikwo', 11),
(219, 'Ishielu', 11),
(220, 'Ivo', 11),
(221, 'Izzi', 11),
(222, 'Ohaukwu', 11),
(223, 'Ohaozara', 11),
(224, 'Onicha', 11),
(225, 'Akoko Edo', 12),
(226, 'Egor', 12),
(227, 'Esan Central', 12),
(228, 'Esan North East', 12),
(229, 'Esan South East', 12),
(230, 'Esan West', 12),
(231, 'Etsako-Central', 12),
(232, 'Etsako-West', 12),
(233, 'Igueben', 12),
(234, 'Ikpoba-Okha', 12),
(235, 'Oredo', 12),
(236, 'Orhionmwon', 12),
(237, 'Ovia North East', 12),
(238, 'Ovia South West', 12),
(239, 'owan east', 12),
(240, 'Owan West', 12),
(241, 'Umunniwonde', 12),
(242, 'Ado Ekiti', 13),
(243, 'Aiyedire', 13),
(244, 'Efon', 13),
(245, 'Ekiti-East', 13),
(246, 'Ekiti-South West', 13),
(247, 'Ekiti West', 13),
(248, 'Emure', 13),
(249, 'Ido Osi', 13),
(250, 'Ijero', 13),
(251, 'Ikere', 13),
(252, 'Ikole', 13),
(253, 'Ilejemeta', 13),
(254, 'Irepodun/Ifelodun', 13),
(255, 'Ise Orun', 13),
(256, 'Moba', 13),
(257, 'Oye', 13),
(258, 'Aninri', 14),
(259, 'Awgu', 14),
(260, 'Enugu East', 14),
(261, 'Enugu North', 14),
(262, 'Enugu South', 14),
(263, 'Ezeagu', 14),
(264, 'Igbo Etiti', 14),
(265, 'Igbo Eze North', 14),
(266, 'Igbo Eze South', 14),
(267, 'Isi Uzo', 14),
(268, 'Nkanu East', 14),
(269, 'Nkanu West', 14),
(270, 'Nsukka', 14),
(271, 'Oji-River', 14),
(272, 'Udenu', 14),
(273, 'Udi', 14),
(274, 'Uzo Uwani', 14),
(275, 'Akko', 15),
(276, 'Balanga', 15),
(277, 'Billiri', 15),
(278, 'Dukku', 15),
(279, 'Funakaye', 15),
(280, 'Gombe', 15),
(281, 'Kaltungo', 15),
(282, 'Kwami', 15),
(283, 'Nafada/Bajoga', 15),
(284, 'Shomgom', 15),
(285, 'Yamltu/Deba', 15),
(286, 'Ahiazu-Mbaise', 16),
(287, 'Ehime-Mbano', 16),
(288, 'Ezinihtte', 16),
(289, 'Ideato North', 16),
(290, 'Ideato South', 16),
(291, 'Ihitte/Uboma', 16),
(292, 'Ikeduru', 16),
(293, 'Isiala-Mbano', 16),
(294, 'Isu', 16),
(295, 'Mbaitoli', 16),
(296, 'Ngor-Okpala', 16),
(297, 'Njaba', 16),
(298, 'Nkwerre', 16),
(299, 'Nwangele', 16),
(300, 'obowo', 16),
(301, 'Oguta', 16),
(302, 'Ohaji-Eggema', 16),
(303, 'Okigwe', 16),
(304, 'Onuimo', 16),
(305, 'Orlu', 16),
(306, 'Orsu', 16),
(307, 'Oru East', 16),
(308, 'Oru West', 16),
(309, 'Owerri Municipal', 16),
(310, 'Owerri North', 16),
(311, 'Owerri West', 16),
(312, 'Auyu', 17),
(313, 'Babura', 17),
(314, 'Birnin Kudu', 17),
(315, 'Birniwa', 17),
(316, 'Bosuwa', 17),
(317, 'Buji', 17),
(318, 'Dutse', 17),
(319, 'Gagarawa', 17),
(320, 'Garki', 17),
(321, 'Gumel', 17),
(322, 'Guri', 17),
(323, 'Gwaram', 17),
(324, 'Gwiwa', 17),
(325, 'Hadejia', 17),
(326, 'Jahun', 17),
(327, 'Kafin Hausa', 17),
(328, 'Kaugama', 17),
(329, 'Kazaure', 17),
(330, 'Kirikasanuma', 17),
(331, 'Kiyawa', 17),
(332, 'Maigatari', 17),
(333, 'Malam Maduri', 17),
(334, 'Miga', 17),
(335, 'Ringim', 17),
(336, 'Roni', 17),
(337, 'Sule Tankarkar', 17),
(338, 'Taura', 17),
(339, 'Yankwashi', 17),
(340, 'Birnin-Gwari', 18),
(341, 'Chikun', 18),
(342, 'Giwa', 18),
(343, 'Gwagwada', 18),
(344, 'Igabi', 18),
(345, 'Ikara', 18),
(346, 'Jaba', 18),
(347, 'Jema\'a', 18),
(348, 'Kachia', 18),
(349, 'Kaduna North', 18),
(350, 'Kagarko', 18),
(351, 'Kajuru', 18),
(352, 'Kaura', 18),
(353, 'Kauru', 18),
(354, 'Koka/Kawo', 18),
(355, 'Kubah', 18),
(356, 'Kudan', 18),
(357, 'Lere', 18),
(358, 'Makarfi', 18),
(359, 'Sabon Gari', 18),
(360, 'Sanga', 18),
(361, 'Sabo', 18),
(362, 'Tudun-Wada/Makera', 18),
(363, 'Zango-Kataf', 18),
(364, 'Zaria', 18),
(365, 'Ajingi', 19),
(366, ' Albasu', 19),
(367, 'Bagwai', 19),
(368, 'Bebeji', 19),
(369, 'Bichi', 19),
(370, 'Bunkure', 19),
(371, 'Dala', 19),
(372, 'Dambatta', 19),
(373, 'Dawakin Kudu', 19),
(374, 'Dawakin Tofa', 19),
(375, 'Doguwa', 19),
(376, 'Fagge', 19),
(377, 'Gabasawa', 19),
(378, 'Garko', 19),
(379, 'Garun-Mallam', 19),
(380, 'Gaya', 19),
(381, 'Gezawa', 19),
(382, 'Gwale', 19),
(383, 'Gwarzo', 19),
(384, 'Kabo', 19),
(385, 'Kano Municipal', 19),
(386, 'Karaye', 19),
(387, 'Kibiya', 19),
(388, 'Kiru', 19),
(389, 'Kumbotso', 19),
(390, 'Kunchi', 19),
(391, 'Kura', 19),
(392, 'Madobi', 19),
(393, 'Makoda', 19),
(394, 'Minjibir', 19),
(395, 'Nasarawa', 19),
(396, 'Rano', 19),
(397, 'Rimin Gado', 19),
(398, 'Rogo', 19),
(399, 'Shanono', 19),
(400, 'Sumaila', 19),
(401, 'Takai', 19),
(402, 'Tarauni', 19),
(403, 'Tofa', 19),
(404, 'Tsanyawa', 19),
(405, 'Tudun Wada', 19),
(406, 'Ngogo', 19),
(407, 'Warawa', 19),
(408, 'Wudil', 19),
(409, 'Bakori', 20),
(410, 'Batagarawa', 20),
(411, 'Batsari', 20),
(412, 'Baure', 20),
(413, 'Bindawa', 20),
(414, 'Charanchi', 20),
(415, 'Danja', 20),
(416, 'Danjume', 20),
(417, 'Dan-Musa', 20),
(418, 'Daura', 20),
(419, 'Dutsi', 20),
(420, 'Dutsinma', 20),
(421, 'Faskari', 20),
(422, 'Funtua', 20),
(423, 'Ingara', 20),
(424, 'Jibia', 20),
(425, 'Kafur', 20),
(426, 'Kaita', 20),
(427, 'Kankara', 20),
(428, 'Kankia', 20),
(429, 'Katsina', 20),
(430, 'Kurfi', 20),
(431, 'Kusada', 20),
(432, 'Mai Adua', 20),
(433, 'Malumfashi', 20),
(434, 'Mani', 20),
(435, 'Mashi', 20),
(436, 'Matazu', 20),
(437, 'Musawa', 20),
(438, 'Rimi', 20),
(439, 'Sabuwa', 20),
(440, 'Safana', 20),
(441, 'Sandamu', 20),
(442, 'Zango', 20),
(443, 'Aleira', 21),
(444, 'Arewa', 21),
(445, 'Argungu', 21),
(446, 'Augie', 21),
(447, 'Bagudo', 21),
(448, 'Birnin-Kebbi', 21),
(449, 'Bumza', 21),
(450, 'Dandi', 21),
(451, 'Danko', 21),
(452, 'Fakai', 21),
(453, 'Gwandu', 21),
(454, 'Jega', 21),
(455, 'Kalgo', 21),
(456, 'Koko-Besse', 21),
(457, 'Maiyama', 21),
(458, 'Ngaski', 21),
(459, 'Sakaba', 21),
(460, 'Shanga', 21),
(461, 'Suru', 21),
(462, 'Wasagu', 21),
(463, 'Yauri', 21),
(464, 'Zuru', 21),
(465, 'Adavi', 22),
(466, 'Ajaokuta', 22),
(467, 'Ankpa', 22),
(468, 'Bassa', 22),
(469, 'Dekina', 22),
(470, 'Ibaji', 22),
(471, 'Idah', 22),
(472, 'Igalamela', 22),
(473, 'Ijumu', 22),
(474, 'Kabba/Bunu', 22),
(475, 'Kogi', 22),
(476, 'Lokoja', 22),
(477, 'Mopa-Muro-Mopi', 22),
(478, 'Ofu', 22),
(479, 'Ogori/Magongo', 22),
(480, 'Okehi', 22),
(481, 'Okene', 22),
(482, 'Olamaboro', 22),
(483, 'Omala', 22),
(484, 'Oyi', 22),
(485, 'Yagba-East', 22),
(486, 'Yagba-West', 22),
(487, 'Asa', 23),
(488, 'Baruten', 23),
(489, 'Edu', 23),
(490, 'Ekiti', 23),
(491, 'Ifelodun', 23),
(492, 'Ilorin East', 23),
(493, 'Ilorin South', 23),
(494, 'Ilorin West', 23),
(495, 'Irepodun', 23),
(496, 'Isin', 23),
(497, 'Kaiama', 23),
(498, 'Moro', 23),
(499, 'Offa', 23),
(500, 'Oke-Ero', 23),
(501, 'Oyun', 23),
(502, 'Pategi', 23),
(503, 'Agege', 24),
(504, 'Ajeromi-Ifelodun', 24),
(505, 'Alimosho', 24),
(506, 'Amuwo-Odofin', 24),
(507, 'Apapa', 24),
(508, 'Bagagry', 24),
(509, 'Epe', 24),
(510, 'Eti-Osa', 24),
(511, 'Ibeju-Lekki', 24),
(512, 'Ifako-Ijaiye', 24),
(513, 'Ikeja', 24),
(514, 'Ikorodu', 24),
(515, 'Kosofe', 24),
(516, 'Lagos-Island', 24),
(517, 'Lagos-Mainland', 24),
(518, 'Mushin', 24),
(519, 'Ojo', 24),
(520, 'Oshodi-Isolo', 24),
(521, 'Shomolu', 24),
(522, 'Suru-Lere', 24),
(523, 'Akwanga', 25),
(524, 'Awe', 25),
(525, 'Doma', 25),
(526, 'Karu', 25),
(527, 'Keana', 25),
(528, 'Keffi', 25),
(529, 'Kokona', 25),
(530, 'Lafia', 25),
(531, 'Nassarawa', 25),
(532, 'Nassarawa Eggor', 25),
(533, 'Obi', 25),
(534, 'Toto', 25),
(535, 'Wamba', 25),
(536, 'Agaie', 26),
(537, 'Agwara', 26),
(538, 'Bida', 26),
(539, 'Borgu', 26),
(540, 'Bosso', 26),
(541, 'Chanchaga', 26),
(542, 'Edati', 26),
(543, 'Gbako', 26),
(544, 'Gurara', 26),
(545, 'Katcha', 26),
(546, 'Kontagora', 26),
(547, 'Lapai', 26),
(548, 'Lavum', 26),
(549, 'Magama', 26),
(550, 'Mariga', 26),
(551, 'Mashegu', 26),
(552, 'Mokwa', 26),
(553, 'Muya', 26),
(554, 'Paikoro', 26),
(555, 'Rafi', 26),
(556, 'Rajau', 26),
(557, 'Shiroro', 26),
(558, 'Suleja', 26),
(559, 'Tafa', 26),
(560, 'Wushishi', 26),
(561, 'Abeokuta -North', 27),
(562, 'Abeokuta -South', 27),
(563, 'Ado-Odu/Ota', 27),
(564, 'Yewa-North', 27),
(565, 'Yewa-South', 27),
(566, 'Ewekoro', 27),
(567, 'Ifo', 27),
(568, 'Ijebu East', 27),
(569, 'Ijebu North', 27),
(570, 'Ijebu North-East', 27),
(571, 'Ijebu-Ode', 27),
(572, 'Ikenne', 27),
(573, 'Imeko-Afon', 27),
(574, 'Ipokia', 27),
(575, 'Obafemi -Owode', 27),
(576, 'Odeda', 27),
(577, 'Odogbolu', 27),
(578, 'Ogun-Water Side', 27),
(579, 'Remo-North', 27),
(580, 'Shagamu', 27),
(581, 'Akoko-North-East', 28),
(582, 'Akoko-North-West', 28),
(583, 'Akoko-South-West', 28),
(584, 'Akoko-South-East', 28),
(585, 'Akure- South', 28),
(586, 'Akure-North', 28),
(587, 'Ese-Odo', 28),
(588, 'Idanre', 28),
(589, 'Ifedore', 28),
(590, 'Ilaje', 28),
(591, 'Ile-Oluji-Okeigbo', 28),
(592, 'Irele', 28),
(593, 'Odigbo', 28),
(594, 'Okitipupa', 28),
(595, 'Ondo-West', 28),
(596, 'Ondo East', 28),
(597, 'Ose', 28),
(598, 'Owo', 28),
(599, 'Atakumosa', 29),
(600, 'Atakumosa East', 29),
(601, 'Ayeda-Ade', 29),
(602, 'Ayedire', 29),
(603, 'Boluwaduro', 29),
(604, 'Boripe', 29),
(605, 'Ede', 29),
(606, 'Ede North', 29),
(607, 'Egbedore', 29),
(608, 'Ejigbo', 29),
(609, 'Ife', 29),
(610, 'Ife East', 29),
(611, 'Ife North', 29),
(612, 'Ife South', 29),
(613, 'Ifedayo', 29),
(614, 'Ifelodun', 29),
(615, 'Ila', 29),
(616, 'Ilesha', 29),
(617, 'Ilesha-West', 29),
(618, 'Irepodun', 29),
(619, 'Irewole', 29),
(620, 'Isokun', 29),
(621, 'Iwo', 29),
(622, 'Obokun', 29),
(623, 'Odo-Otin', 29),
(624, 'Ola Oluwa', 29),
(625, 'Olorunda', 29),
(626, 'Ori-Ade', 29),
(627, 'Orolu', 29),
(628, 'Osogbo', 29),
(629, 'Afijio', 30),
(630, 'Akinyele', 30),
(631, 'Atiba', 30),
(632, 'Atisbo', 30),
(633, 'Egbeda', 30),
(634, 'Ibadan-Central', 30),
(635, 'Ibadan-North-East', 30),
(636, 'Ibadan-North-West', 30),
(637, 'Ibadan-South-East', 30),
(638, 'Ibadan-South West', 30),
(639, 'Ibarapa-Central', 30),
(640, 'Ibarapa-East', 30),
(641, 'Ibarapa-North', 30),
(642, 'Ido', 30),
(643, 'Ifedayo', 30),
(644, 'Ifeloju', 30),
(645, 'Irepo', 30),
(646, 'Iseyin', 30),
(647, 'Itesiwaju', 30),
(648, 'Iwajowa', 30),
(649, 'Kajola', 30),
(650, 'Lagelu', 30),
(651, 'Odo-Oluwa', 30),
(652, 'Ogbomoso-North', 30),
(653, 'Ogbomosho-South', 30),
(654, 'Olorunsogo', 30),
(655, 'Oluyole', 30),
(656, 'Ona-Ara', 30),
(657, 'Orelope', 30),
(658, 'Ori-Ire', 30),
(659, 'Oyo East', 30),
(660, 'Oyo West', 30),
(661, 'saki east', 30),
(662, 'Saki West', 30),
(663, 'Surulere', 30),
(664, 'Barkin Ladi', 31),
(665, 'Bassa', 31),
(666, 'Bokkos', 31),
(667, 'Jos-East', 31),
(668, 'Jos-South', 31),
(669, 'Jos-North', 31),
(670, 'Kanam', 31),
(671, 'Kanke', 31),
(672, 'Langtang North', 31),
(673, 'Langtang South', 31),
(674, 'Mangu', 31),
(675, 'Mikang', 31),
(676, 'Pankshin', 31),
(677, 'Quan\'pan', 31),
(678, 'Riyom', 31),
(679, 'Shendam', 31),
(680, 'Wase', 31),
(681, 'Abua/Odual', 32),
(682, 'Ahoada East', 32),
(683, 'Ahoada West', 32),
(684, 'Akukutoru', 32),
(685, 'Andoni', 32),
(686, 'Asari-Toro', 32),
(687, 'Bonny', 32),
(688, 'Degema', 32),
(689, 'Eleme', 32),
(690, 'Emuoha', 32),
(691, 'Etche', 32),
(692, 'Gokana', 32),
(693, 'Ikwerre', 32),
(694, 'Khana', 32),
(695, 'Obio/Akpor', 32),
(696, 'Ogba/Egbama/Ndoni', 32),
(697, 'Ogu/Bolo', 32),
(698, 'Okrika', 32),
(699, 'Omuma', 32),
(700, 'Opobo/Nkoro', 32),
(701, 'Oyigbo', 32),
(702, 'Port-Harcourt', 32),
(703, 'Tai', 32),
(704, 'Binji', 33),
(705, 'Bodinga', 33),
(706, 'Dange-Shuni', 33),
(707, 'Gada', 33),
(708, 'Goronyo', 33),
(709, 'Gudu', 33),
(710, 'Gwadabawa', 33),
(711, 'Illela', 33),
(712, 'Isa', 33),
(713, 'Kebbe', 33),
(714, 'Kware', 33),
(715, 'Raba', 33),
(716, 'Sabon-Birni', 33),
(717, 'Shagari', 33),
(718, 'Silame', 33),
(719, 'Sokoto North', 33),
(720, 'Sokoto South', 33),
(721, 'Tambuwal', 33),
(722, 'Tanzaga', 33),
(723, 'Tureta', 33),
(724, 'Wamakko', 33),
(725, 'Wurno', 33),
(726, 'Yabo', 33),
(727, 'Ardo Kola', 34),
(728, 'Bali', 34),
(729, 'Donga', 34),
(730, 'Gashaka', 34),
(731, 'Gassol', 34),
(732, 'Ibi', 34),
(733, 'Jalingo', 34),
(734, 'Karim-Lamido', 34),
(735, 'Kurmi', 34),
(736, 'Lau', 34),
(737, 'Sardauna', 34),
(738, 'Takuni', 34),
(739, 'Ussa', 34),
(740, 'Wukari', 34),
(741, 'Yarro', 34),
(742, 'Zing', 34),
(743, 'Bade', 35),
(744, 'Bursali', 35),
(745, 'Damaturu', 35),
(746, 'Fuka', 35),
(747, 'Fune', 35),
(748, 'Geidam', 35),
(749, 'Gogaram', 35),
(750, 'Gujba', 35),
(751, 'Gulani', 35),
(752, 'Jakusko', 35),
(753, 'Karasuwa', 35),
(754, 'Machina', 35),
(755, 'Nangere', 35),
(756, 'Nguru', 35),
(757, 'Potiskum', 35),
(758, 'Tarmua', 35),
(759, 'Yunisari', 35),
(760, 'Yusufari', 35),
(761, 'Anka', 36),
(762, 'Bakure', 36),
(763, 'Bukkuyum', 36),
(764, 'Bungudo', 36),
(765, 'Gumi', 36),
(766, 'Gusau', 36),
(767, 'Isa', 36),
(768, 'Kaura-Namoda', 36),
(769, 'Kiyawa', 36),
(770, 'Maradun', 36),
(771, 'Marau', 36),
(772, 'Shinkafa', 36),
(773, 'Talata-Mafara', 36),
(774, 'Tsafe', 36),
(775, 'Zurmi', 36),
(776, 'Obudu', 9),
(777, 'Abaji', 37),
(778, 'Bwari', 37),
(779, 'Gwagwalada', 37),
(780, 'Kuje', 37),
(781, 'Kwali', 37),
(782, 'Municipal', 37),
(783, 'Etsako-East', 12),
(784, 'Ahiazu-Mbaise', 16),
(785, 'Foreign', 38),
(786, 'Kaduna South', 18),
(787, 'Aboh-Mbaise', 16),
(788, 'Odukpani', 9);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(250) NOT NULL,
  `state_id` int(11) NOT NULL,
  `lga_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medical_unit`
--

CREATE TABLE `medical_unit` (
  `medical_unit_id` int(11) NOT NULL,
  `medical_unit_name` varchar(150) DEFAULT NULL,
  `store_unit_name` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `medical_unit_address` varchar(200) DEFAULT NULL,
  `medical_unit_phone_number` varchar(50) DEFAULT NULL,
  `medical_unit_type` varchar(100) DEFAULT NULL,
  `medical_unit_location` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medical_unit`
--

INSERT INTO `medical_unit` (`medical_unit_id`, `medical_unit_name`, `store_unit_name`, `category_id`, `medical_unit_address`, `medical_unit_phone_number`, `medical_unit_type`, `medical_unit_location`) VALUES
(1, 'Etta-Atlantic Memorial Hospital', '', 1, '22 Abioro Street, Ikate Lekki, Lagos State Nigeria', '08083734008', '', 510),
(2, 'Chygor-Cole Specialist Hospitals', '', 1, '123 Agbe Road, Jibowu Estate, U-Turn Bus Stop, Abule Egba, Lagos State.', '09078616665', 'Sepecialist Hospital', 505),
(3, 'Lagos Island Maternity Hospital', '', 1, '110 Campbell St, Lagos Island, Lagos.', '0807 559 3743', 'Sepecialist Hospital', 516),
(4, 'Lagos University Teaching Hospital', '', 1, 'Ishaga Rd, Idi-Araba, Lagos .', '0807 059 1395', ' Tertiary Hospital ', 517),
(5, 'Vedic Lifecare Hospital', '', 1, 'Block 105, 6 Olabanji Olajide St\r\nLekki Phase 1, Lagos.', '+2347084008982', '', 510),
(6, 'Isalu Hospitals', '', 1, '349b Odusami Street, off Wemco Rd, Ogba, \r\nLagos Nigeria.', '+2347033304851', 'Multi Sepecialist Hospital', 513),
(7, 'St. Nicholas Hospital, Lagos', '', 1, '57 Campbell Street ,Lagos Island.', '02012718690', '', 516),
(8, 'Wind of Grace Hospital', '', 1, '5 Folarin Fatusin St, Ilasamaja, Lagos ', '08056429736', 'Secondary Health Care Centre', 520),
(9, 'Federal Medical Centre Ebute Metta[', '', 1, 'Federal Medical Centre, Nigerian Railway Compound, Ebute-Metta.', '+2348170693805', 'Public Hospital', 517),
(10, 'First Consultant Hospital', '', 1, '16-24 St.Gregory College Road, Lagos', '01-7404587', 'Private Hospital', 510),
(11, 'Military Hospital Lagos Creek', '', 1, '18 Awolowo Rd, Ikoyi, Lagos.', '08051001711', 'Military Hospital', 510),
(12, 'Lagos State University Teaching Hospital (LASUTH)', '', 1, '1-5 Oba Akinjobi Way, Street, Ikeja, Lagos.', '09131321160', 'Teaching Hospital,', 513),
(13, 'National Orthopaedic Hospital', '', 1, '120/124 Ikorodu-Ososun Rd, Igbobi, Lagos', '07066404598', 'Othopaedic Hospital', 517),
(14, 'Lagoon Hospitals', '', 1, '8 Marine Rd, Apapa, Lagos', '09034136452', 'General Hospital', 507),
(15, 'Duchess International Hospital', '', 1, '22A Joel Ogunnaike St, Ikeja GRA, Ikeja, Lagos.', '07001031700', 'Sepecialist Hospital', 513),
(16, 'Mercy Stripes Specialist Hospital', '', 1, '30 Philip Taiwo Street, Coker Estate Orisunbare Road Shasha, Lagos State.', '08170409077', '', 505),
(17, 'Eko Hospital', '', 1, '31 Mobolaji Bank Anthony Way, Opebi, Lagos.', '012716997', 'General Hospital', 513),
(18, 'Reddington Hospital', '', 1, '12 Idowu Martins Street, Victoria Island, Lagos.', '09165359769', 'General Hospital', 510),
(19, 'Lagos Island General Hospital', '', 1, '216 Broad St, Lagos Island, Lagos.', '012630642', 'Sepecialist Hospital', 516),
(20, 'Yaba Psychiatric Hospital', '', 1, 'Federal Medical Neuro-Psychiatric Hospital, Murtala Muhammed Way, Yaba, Lagos.', '09021527723', 'Psychiatric Hospital', 517),
(21, 'Gbagada General Hospital', '', 1, '1 Hospital Rd, Gbagada, Lagos', '08113898138', 'General Hospital', 515),
(22, 'Holy Trinity Hospital', '', 1, '110 Obafemi Awolowo Way, Allen, Lagos .', '08167599420', 'Private  Hospital', 513),
(23, 'Adefemi Hospital', '', 1, '49 Seriki Aro Ave, Ikeja, Lagos.', '08125071630', 'Private Hospital', 513),
(24, 'Blue Cross Hospital', '', 1, '48 Ijaiye Rd, Ogba, Ikeja, Lagos', '09069955756', 'Private Hospital', 513),
(25, 'Ifako Ijaiye General Hospital', '', 1, '14 College Road, Iju Road, Ifako, Ifako-Ijaye.', '08053554448', 'General Hospital', 503),
(26, 'Isolo General Hospital', '', 1, '121 Mushin Rd, Isolo, Lagos, Lagos', '08054315366', 'General Hospital', 520),
(27, 'Ikorodu General Hospital', '', 1, ' Oba Sekumade Rd, Ikorodu, Lagos', ' 08035025959', 'General Hospital', 514),
(28, 'Badagry General Hospital', '', 1, 'Hospital Rd, Badagry, Lagos', '', 'General Hospital', 508),
(29, 'Maryiam Ville Medical Center', '', 1, '144 Bode Thomas St, Surulere, Lagos, Lagos', '014533734', 'Private Hospital', 522),
(30, 'St. Joseph Physiotherapy Clinic', '', 1, '21b Christ Avenue off Admiralty Road. Lekki phase 1 Lagos.', '09060960109', 'Physiotherapy Clinic', 510);

-- --------------------------------------------------------

--
-- Table structure for table `police_unit`
--

CREATE TABLE `police_unit` (
  `police_unit_id` int(11) NOT NULL,
  `police_unit_name` varchar(150) DEFAULT NULL,
  `store_unit_name` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `police_unit_address` varchar(200) DEFAULT NULL,
  `police_unit_phone_number` varchar(50) DEFAULT NULL,
  `police_unit_phone_number2` varchar(50) DEFAULT NULL,
  `police_unit_phone_number3` varchar(50) DEFAULT NULL,
  `police_unit_type` varchar(100) DEFAULT NULL,
  `police_unit_location` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `police_unit`
--

INSERT INTO `police_unit` (`police_unit_id`, `police_unit_name`, `store_unit_name`, `category_id`, `police_unit_address`, `police_unit_phone_number`, `police_unit_phone_number2`, `police_unit_phone_number3`, `police_unit_type`, `police_unit_location`) VALUES
(1, 'Adekunle Police Station', '', 4, 'Herbert Macaulay Road, Yaba, Lagos', '08033450247', '08081776167', '', 'C.I.D', 517),
(2, 'Ajegunle Police Station', '', 4, 'Baale Adeyemo Street, Ajeromi-Ifelodun, Ajegunle, Lagos', '08037179569', '', '', '', 504),
(3, 'Nigeria Police Station', '', 4, 'Sabo Juction, Herbert Macaulay Wy, Sabo yaba, Lagos', '08035693189', '08035673189', '', '', 517),
(4, 'Bariga Police Station', '', 4, 'Ilaje Bus Stop, Beside CMS Grammar School, Bariga, Shomolu, Lagos', '08023163237', '', '', '', 521),
(5, 'Ijanikin Police Station', '', 4, 'Km 38, Lagos – Badagry Expresssway, Station Bus Stop, Ojo, Lagos.', '08033940341', '', '', '', 519),
(6, 'Ijora – Badia Police Station', '', 4, 'Badia-Amukoko Road, Opp.  Better life Market, beside Lagos State Water Corporation, Apapa, Lagos.', '08023145225', '08033644481', '', '', 507),
(7, 'Ikotun Police Station', '', 4, 'Ikotun Road, Alimosho, Lagos', '08023431587', '', '', '', 505),
(8, 'Ikoyi Police Station', '', 4, 'Awolowo Road, Ikoyi, Lagos', '08033008312', '08055171094', '', '', 510),
(9, 'Isashi Police Station', '', 4, 'Signboard Bus Stop, OPP. Water Corporation, Isashi, Ojo, Lagos.', '08034063058', '', '', '', 519),
(10, 'Itire Police Station', '', 4, 'Behind Cele Police Station, New Itire Road, Oshodi-Isolo, Lagos.', '08024188618', '08037131277', '', '', 520),
(11, 'Okokomaiko Police Station', '', 4, 'Km 12, Lagos-BadagryExpresway. Okokomaiko, Ojo, Lagos	', '08029727191', '', '', '', 519),
(12, 'Okota Police Station Area D', '', 4, 'Okota Road, Opposite Century Hotels Okota, Oshodi-Isolo, Lagos	', '08033594548', '', '', '', 520),
(13, 'Old Ojo Road Police Station', '', 4, 'Domorose Bus Stop, Opposite Access Bank/Palm Beach Hospital, KujeAmuwo, Amuwo-Odofin, Lagos	', '08033890969', '07032214614', '', '', 506),
(14, 'Orile Police Station', '', 4, 'Orile Bus Stop, By Orile-Amukoko Road, Ajeromi-Ifelodun, Lagos	', '08037222249', '08125271949', '', '', 504),
(15, 'Nigeria Police Force – Federal Command', '', 4, 'Kam Salem Building, Moloney Street, Obalende, Eti Osa, Lagos	', '012635054', '012635931', '012635954', '', 510),
(16, 'The Nigeria Police (Dolphin Estate, Ikoyi, Lagos)', '', 4, 'Corporation Drive, Dolphin Estate, Eti Osa, Ikoyi, Lagos', '08023422832', '', '', '', 510),
(17, 'Amukoko Police Station', '', 4, 'Iludun Street, Pako, Bus-stop Cementry Road, Amukoko, Ajeromi-ifelodun, Lagos', '08036247440', '08050253330', '', '', 504),
(18, 'Pedro Police Station', '', 4, 'Pedro Station, Shomolu, Lagos', '08062095439', '', '', '', 521),
(19, 'Nigeria Police Force – State Command', '', 4, 'Ikeja, Ikeja, Lagos', '014962157', '014960200', '', 'State command', 513),
(20, 'Nigeria Police Force – Zone 2 Command', '', 4, 'Island Club Road, Onikan, Lagos Island, Lagos', '012632774', '012631000', '', 'Zonal Command', 516),
(21, 'Satelite Town Police Station Close 6, House', '', 4, '1, Opposite Close 5, Satelite Town, Amuwo-Odofin, Lagos	', '08033070467', '07040024498', '', '', 506),
(23, 'The Nigeria Police Force (Area B, Lagos)', '', 4, 'Layeni Street, Ojo Road, Junction Bus Stop, Ajegunle, Ajeromi-Ifelodun, Lagos', '08032254444', '', '', '', 504),
(24, 'The Nigeria Police Force (Area C, Lagos)', '', 4, '110 Bode Thomas Street, Area C, Surulere, Lagos', '08023769795', '', '', '', 522),
(25, 'The Nigeria Police (Area C, Lagos)', '', 4, 'Funsho Williams Avenue, Iponri, Area C, Surulere, Lagos', '08037623144', '08027246052', '', '', 521),
(26, 'The Nigeria Police, Ikeja, Lagos', '', 4, '26 Oba Akinjobi Road, Ikeja, Lagos', '08033040870', '08020398863', '', 'C.I.D', 513),
(27, 'The Nigerian Police, Panti, Lagos', '', 4, 'Panti Street, By Adekunle Bus-Stop, Yaba, Lagos', '07087233410', '08022400115', '', 'State C.I.D', 517),
(28, 'The Nigerian Police (Area A, Lagos)', '', 4, '26 Awolowo Road, Ikoyi, Eti-Osa, Lagos', '08023223214', '', '', '', 510),
(29, 'The Nigeria Police (Area B, Apapa, Lagos)', '', 4, 'Wharf Road, Point Bus-Stop, Apapa, Lagos', '08033117380', '', '', '', 507),
(30, 'The Nigeria Police (Area B, Apapa, Lagos)', '', 4, 'Fadina Street, By Better Life Market, IjoraBadia, Apapa, Lagos', '08033072580', '', '', '', 507),
(31, 'The Nigeria Police (Area E Command Headquarters, Lagos)', '', 4, 'Area E Headquarters 5, 2nd Avenue, Festac Town, Amuwo Odofin, Lagos	', '017944541', '', '', 'Command HQ', 506),
(32, 'The Nigeria Police (Area D, Oshodi)', '', 4, 'Kabiyesi Street, beside Afin Oba Onitire Palace, Itire, Oshodi-Isolo, Lagos	', '08035841010', '', '', 'C.I.D', 520),
(33, 'The Nigeria Police (Area D, Oshodi, Lagos)', '', 4, 'Balogun Street, Beside Ibalex Nig. Ltd., Oshodi-Isolo, Lagos', '080334472637', '', '', '', 520),
(34, 'The Nigeria Police (Area F, Oshodi, Lagos)', '', 4, 'Akinpelu Street, Bolade, Oshodi-Isolo', '08081760055', '', '', '', 520),
(35, 'The Nigeria Police (Area F, Oshodi, Lagos)', '', 4, 'Mosafejo Street, Beside LASTMA Office, Oshodi-Isolo, Lagos', '08125275213', '', '', '', 520),
(36, 'The Nigeria Police (Area F, Ojodu, Lagos)', '', 4, 'Akinyode Street, After Road Safety Junction, Ojodu, Ikeja, Lagos	', '08024481019', '08056444574', '', '', 513),
(37, 'The Nigeria Police (Area F, Shogunle)', '', 4, 'Shogunle Street, By Oshodi Bus Stop, Oshodi-Isolo, Lagos', '08033780612', '', '', '', 520),
(38, 'The Nigeria Police, Apapa, Lagos', '', 4, 'Wharf Road, Point Bus Stop, Apapa, Lagos', '08073666669', '08023341851', '', '', 507),
(39, 'The Nigeria Police Force, Ojo, Lagos', '', 4, 'Sign-Board Bus-Stop, Isashi, Opposite Water Corporation, Ojo, Lagos', '08034063058', '', '', '', 519),
(40, 'The Nigeria Police Force (Area E, Ojo, Lagos)', '', 4, '76/77, Olojo Drive, Corner Bus-Stop, Area E, Ojo, Lagos', '', '', '', '', 519),
(41, 'The Nigeria Police (Area D, Ojo)', '', 4, '208 OjoIgbede Road, Ilembe Hausa, Area D, Ojo, Lagos', '08035028610', '', '', '', 519),
(42, 'The Nigeria Police (Area A, Lagos Island)', '', 4, '112 Dosunmu Street, Ebutte-Ero, Lagos Island, Lagos', '08052663309', '', '', '', 516),
(43, 'The Nigeria Police (Area B, Apapa)', '', 4, '1B Trinity Street, Opposite Cool Penny Hotels, Apapa, Lagos', '08037175658', '', '', '', 507),
(44, 'The Nigeria Police (Area B, Ajegunle, Apapa, Lagos)', '', 4, 'College Road, Tolu, Ajegunle, Ajeromi-Ifelodun, Lagos', '080680552255', '', '', '', 504),
(45, 'The Nigeria Police (Area B, Kirikiri, Apapa)', '', 4, 'Kirikiri Maintown, Apapa, Lagos', '08035520461', '', '', '', 507),
(46, 'The Nigeria Police Force (Area C, Ojuelegba, Lagos)', '', 4, 'Inside Iponri Police Barracks, Western Avenue, Iponri, Surulere, Lagos', '08033233359', '', '', '', 522),
(47, 'The Nigeria Police (Area D, Okota, Lagos)', '', 4, 'Godmon Street, Police Bus-Stop, Okota-Isolo, Oshodi-Isolo, Lagos', '08066964918', '', '', '', 520),
(48, 'The Nigeria Police (Ejigbo, Lagos)', '', 4, 'Ejigbo Road, Pipeline Bus-Stop, Isolo, Oshodi-Isolo, Lagos	', '08033000917', '', '', '', 520),
(49, 'The Nigeria Police (Area D, Ijesha, Surulere, Lagos)', '', 4, 'Iman Thanni Street, Ijesha, Surulere, Lagos', '08033455356', '', '', '', 522),
(50, 'The Nigeria Police (Area H, Kosofe, Lagos)', '', 4, 'Ikorodu Road, Before Ketu Pedestrian Bridge, Ketu Bus-Stop, Kosofe, Lagos', '0806602020', '', '', '', 515),
(51, 'The Nigeria Police Medical Service HQ (Lagos)', '', 4, 'Falomo Bus-Stop, Awolowo Road, Ikoyi, Eti-Osa, Lagos', '08051668379', '', '', '', 510),
(53, 'The Nigeria Police (Area F, Ogba, Lagos)', '', 4, 'Ogba Bus-Stop, Ikeja, Lagos', '08056630745', '08056630708', '', '', 513),
(54, 'The Nigeria Police (Onipanu, Lagos)', '', 4, 'Ikorodu Road, Onipan Bus-Stop, Shomolu, Lagos', '08033004406', '', '', 'C.I.D', 521),
(55, 'The Nigeria Police Divisional Headquarters (Ipaja, Lagos)', '', 4, 'Along Ipaja-Baruwa Road, Moshalashi Bus-Stop, Alimosho, Lagos', '08058248454', '', '', 'Divisional Heaquaters', 505),
(56, 'The Nigeria Police (Ilogbo, Lagos)', '', 4, 'IlogboIyana Era Road, Ilogbo, Ojo, Lagos', '08034946663', '', '', '', 519),
(57, 'The Nigeria Police (Ogudu, Kosofe)', '', 4, 'Ogudu Road, Police Station Bus-Stop, Ogudu, Kosofe, Lagos', '08027600619', '07085726478', '08035143281', '', 515),
(58, 'The Nigeria Police (GRA, Ikeja Lagos)', '', 4, 'AdekunleFajuyi Way, GRA, Ikeja, Lagos', '08059996992', '014962793', '014960200', '', 513),
(59, 'The Nigeria Police (Ilupeju, Lagos)', '', 4, '17 Bishop Street, Ilupeju, Mushin, Lagos', '08068116310', '', '', '', 518),
(60, 'The Nigeria Police (Ikoyi, Lagos)', '', 4, 'Awolowo Road, Ikoyi, Eti-Osa, Lagos', '08054479115', '', '', 'C.I.D', 510),
(61, 'The Nigeria Police (Area A, Victoria Island, Lagos)', '', 4, 'Ahmadu Bello Way, Opposite Oceanography School, Victoria Island, EtiOsa, Lagos', '08033521772', '017769009', '', '', 510),
(62, 'The Nigeria Police (Area F, Mafoluku, Oshodi)', '', 4, '12 Agbaoku Street, Mafoluku, Oshodi-Isolo, Lagos', '07035044402', '08081760090', '', '', 520),
(63, 'Trade Fair Complex Police Station (Lagos)', '', 4, 'Trade Fair Complex, Badagry Expressway, Ojo, Lagos', '08037144215', '', '', '', 519),
(22, 'Shomolu Police Station', '', 4, 'Adaranijo Street, Pedro, Shomolu, Lagos', '08020311111', '08051111177', '', '', 521);

-- --------------------------------------------------------

--
-- Table structure for table `response_unit`
--

CREATE TABLE `response_unit` (
  `responseunit_id` int(11) NOT NULL,
  `responseunit_name` varchar(150) DEFAULT NULL,
  `store_unit_name` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `responseunit_unit_address` varchar(200) DEFAULT NULL,
  `responseunit_phone_number` varchar(50) DEFAULT NULL,
  `responseunit_type` varchar(100) DEFAULT NULL,
  `responseunit_geolocation` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state_id`, `state_name`) VALUES
(1, 'Abia'),
(2, 'Adamawa'),
(3, 'Akwa Ibom'),
(4, 'Anambra'),
(5, 'Bauchi'),
(6, 'Bayelsa'),
(7, 'Benue'),
(8, 'Borno'),
(9, 'Cross River'),
(10, 'Delta'),
(11, 'Ebonyi'),
(12, 'Edo'),
(13, 'Ekiti'),
(14, 'Enugu'),
(15, 'Gombe'),
(16, 'Imo'),
(17, 'Jigawa'),
(18, 'Kaduna'),
(19, 'Kano'),
(20, 'Katsina'),
(21, 'Kebbi'),
(22, 'Kogi'),
(23, 'Kwara'),
(24, 'Lagos'),
(25, 'Nassarawa'),
(26, 'Niger'),
(27, 'Ogun'),
(28, 'Ondo'),
(29, 'Osun'),
(30, 'Oyo'),
(31, 'Plateau'),
(32, 'Rivers'),
(33, 'Sokoto'),
(34, 'Taraba'),
(35, 'Yobe'),
(36, 'Zamfara'),
(37, 'Abuja (FCT)'),
(38, 'Foreign');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(255) DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(15) DEFAULT NULL,
  `user_gender` enum('male','female') DEFAULT NULL,
  `user_pwd` varchar(200) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `user_local_govtID` int(11) DEFAULT NULL,
  `user_age` varchar(50) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `user_address` varchar(200) DEFAULT NULL,
  `current_loction` int(50) DEFAULT NULL,
  `user_date_registered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_image` varchar(200) DEFAULT NULL,
  `deactivate_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `user_fullname`, `user_email`, `user_phone`, `user_gender`, `user_pwd`, `state_id`, `user_local_govtID`, `user_age`, `admin_id`, `user_address`, `current_loction`, `user_date_registered`, `user_image`, `deactivate_status`) VALUES
(18, 'Abiola Michael', 'biolanene@hotmail.com', '07033296785', 'male', '$2y$10$bBXHZzw7dhi7QReJJsV1Xell.2Oi9rEvc4aV17CODlk.gd2GlG6.u', 28, NULL, '1992-10-06', NULL, '14 Shyllon street, Ilupeju', NULL, '2024-05-18 18:57:03', '17174177922135672024.jpeg', 'active'),
(19, 'Hussein Abdulrahman', 'hussein@yahoo.com', NULL, NULL, '$2y$10$w8D3l9X4bDkdjgweSnl8I.qdmigeQZ.TyqyCVwhJ.uAiBqRQquxia', 27, NULL, NULL, NULL, NULL, NULL, '2024-05-19 02:24:57', NULL, 'inactive'),
(20, 'Aderibigbe Ayodeji', 'deji234@yahoo.com', '07044839845', 'male', '$2y$10$hFtSqnrIOzanUkinXC7kX.A3.ja6ZKYvS8uYp9duBt9K0hPEAT.4a', 28, NULL, '1986-12-11', NULL, '9 davies street', NULL, '2024-05-22 05:47:20', '1716729757701915608.jpg', 'active'),
(21, 'malik kamnu', 'kamnu@gmail.com', '0908889997', 'male', '$2y$10$TnVubcbuYlBjPEx3IhZlde.nKf1abZhQsaL83Gj6aLG4G2w6b01N.', 1, NULL, '2024-02-12', NULL, '14 Shyllon street, Ilupeju', NULL, '2024-05-23 15:14:00', '17164738181832754712.jpg', 'active'),
(22, 'Aderibigbe Ayodeji', 'deji234@yahoo.com', NULL, NULL, '$2y$10$OjbQnl6vqDkBjEG/Y2QouOYmiV7fjfq6ukHfXZgAFo8hAegAk4Gc.', 28, 598, NULL, NULL, NULL, NULL, '2024-05-23 15:56:05', NULL, 'active'),
(23, 'Amanda Nwachukwu', 'amynchks@yahoomail.com', '0707221345', 'female', '$2y$10$4YfGcTWKM1QVdruYI/PwtecVPy7qErGhQW170LY4M3ydEOkG3zuEG', 16, 784, '2000-02-16', NULL, '2 epe express way', NULL, '2024-05-26 13:58:50', '171672839386683404.jpeg', 'active'),
(24, 'Damini Ogulu', 'damogulu@yahoo.com', NULL, NULL, '$2y$10$.6Wk9nShlaNvi1JzJblSjOJUwtH128L2Vdmq1gwqg/V62EL4HKUES', 24, 503, NULL, NULL, NULL, NULL, '2024-05-31 23:10:39', NULL, 'active'),
(25, 'Anita James', 'nitajames@yahoo.com', NULL, NULL, '$2y$10$9rxEbmRWjL/4zMpgxcjRaetUNooXhIJKKE18clOnbTPreDAyBwj0O', 2, 695, NULL, NULL, NULL, NULL, '2024-06-01 00:14:21', NULL, 'active'),
(26, 'Idorenyin Jonah', 'idjonah@gmail.com', '0908889997', 'female', '$2y$10$SzaybAdbVqAxyd/1dSv8celcFg5vrL.ex.QdbyONAAeDcJITl65oO', 3, 49, '1993-06-28', NULL, '2 epe express way', NULL, '2024-06-04 19:01:11', '1717524153208948596.jpeg', 'active');

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
-- Indexes for table `emergency_activity`
--
ALTER TABLE `emergency_activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD UNIQUE KEY `al11` (`alert_id`),
  ADD KEY `emergency_typefk` (`emergency_type`);

--
-- Indexes for table `emergency_alert_response_unit`
--
ALTER TABLE `emergency_alert_response_unit`
  ADD PRIMARY KEY (`response_id`),
  ADD UNIQUE KEY `alert_id` (`alert_id`),
  ADD KEY `emergency_idfk` (`emergency_id`),
  ADD KEY `category_idfk` (`category_id`);

--
-- Indexes for table `emergency_alert_table`
--
ALTER TABLE `emergency_alert_table`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `category_id_fk` (`emergency_type`),
  ADD KEY `lga_iddfk` (`lga_id`);

--
-- Indexes for table `fire_unit`
--
ALTER TABLE `fire_unit`
  ADD PRIMARY KEY (`fire_unit_id`),
  ADD KEY `fire_locationfk` (`fire_unit_location`);

--
-- Indexes for table `lga`
--
ALTER TABLE `lga`
  ADD PRIMARY KEY (`lga_id`),
  ADD KEY `FKSTLGA_idx` (`state_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `state_idfk` (`state_id`),
  ADD KEY `lga_idfk` (`lga_id`);

--
-- Indexes for table `medical_unit`
--
ALTER TABLE `medical_unit`
  ADD PRIMARY KEY (`medical_unit_id`),
  ADD KEY `medic_locationfk` (`medical_unit_location`);

--
-- Indexes for table `police_unit`
--
ALTER TABLE `police_unit`
  ADD KEY `local_govt_polic_id_fk` (`police_unit_location`);

--
-- Indexes for table `response_unit`
--
ALTER TABLE `response_unit`
  ADD PRIMARY KEY (`responseunit_id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `response_unit` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `emergency_activity`
--
ALTER TABLE `emergency_activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emergency_alert_response_unit`
--
ALTER TABLE `emergency_alert_response_unit`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emergency_alert_table`
--
ALTER TABLE `emergency_alert_table`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fire_unit`
--
ALTER TABLE `fire_unit`
  MODIFY `fire_unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_unit`
--
ALTER TABLE `medical_unit`
  MODIFY `medical_unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `response_unit`
--
ALTER TABLE `response_unit`
  MODIFY `responseunit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emergency_activity`
--
ALTER TABLE `emergency_activity`
  ADD CONSTRAINT `emergency_typefk` FOREIGN KEY (`emergency_type`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `emergency_alert_response_unit`
--
ALTER TABLE `emergency_alert_response_unit`
  ADD CONSTRAINT `category_idfk` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `emergency_idfk` FOREIGN KEY (`emergency_id`) REFERENCES `emergency_activity` (`activity_id`);

--
-- Constraints for table `emergency_alert_table`
--
ALTER TABLE `emergency_alert_table`
  ADD CONSTRAINT `category_id_fk` FOREIGN KEY (`emergency_type`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `lga_iddfk` FOREIGN KEY (`lga_id`) REFERENCES `lga` (`lga_id`);

--
-- Constraints for table `fire_unit`
--
ALTER TABLE `fire_unit`
  ADD CONSTRAINT `fire_locationfk` FOREIGN KEY (`fire_unit_location`) REFERENCES `lga` (`lga_id`);

--
-- Constraints for table `lga`
--
ALTER TABLE `lga`
  ADD CONSTRAINT `FKSTLGA` FOREIGN KEY (`state_id`) REFERENCES `state` (`state_id`);

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `lga_idfk` FOREIGN KEY (`lga_id`) REFERENCES `lga` (`lga_id`),
  ADD CONSTRAINT `state_idfk` FOREIGN KEY (`state_id`) REFERENCES `state` (`state_id`);

--
-- Constraints for table `medical_unit`
--
ALTER TABLE `medical_unit`
  ADD CONSTRAINT `medic_locationfk` FOREIGN KEY (`medical_unit_location`) REFERENCES `lga` (`lga_id`);

--
-- Constraints for table `police_unit`
--
ALTER TABLE `police_unit`
  ADD CONSTRAINT `local_govt_polic_id_fk` FOREIGN KEY (`police_unit_location`) REFERENCES `lga` (`lga_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- ---------------------------------------------------------------------------
-- Phase 1 additions: agencies + emergency-type governance
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `agency` (
  `agency_id`   int(11)      NOT NULL AUTO_INCREMENT,
  `agency_name` varchar(150) NOT NULL,
  `agency_type` varchar(30)  NOT NULL DEFAULT 'other',
  `agency_phone` varchar(50) DEFAULT NULL,
  `created_at`  timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`agency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `agency` (`agency_id`, `agency_name`, `agency_type`, `agency_phone`) VALUES
(1, 'Nigeria Police Force',                 'police',  '112'),
(2, 'Lagos State Fire & Rescue Service',    'fire',    '112'),
(3, 'Lagos State Ambulance Service (LASAMBUS)', 'medical', '112'),
(4, 'Federal Road Safety Corps',            'other',   '122');

ALTER TABLE `category`
  ADD COLUMN `agency_id`       int(11)     DEFAULT NULL,
  ADD COLUMN `approval_status` varchar(20) NOT NULL DEFAULT 'approved',
  ADD COLUMN `requested_by`    int(11)     DEFAULT NULL;

UPDATE `category` SET `agency_id` = 1 WHERE `category_id` IN (4, 11, 12, 15);
UPDATE `category` SET `agency_id` = 2 WHERE `category_id` IN (2, 7, 8, 10);
UPDATE `category` SET `agency_id` = 3 WHERE `category_id` IN (1, 3, 6, 9, 13, 14);

-- ---------------------------------------------------------------------------
-- Phase 2 additions: agency staff, assignment & response tracking
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id`   int(11)      NOT NULL AUTO_INCREMENT,
  `fullname`   varchar(150) NOT NULL,
  `email`      varchar(150) NOT NULL,
  `password`   varchar(255) NOT NULL,
  `role`       varchar(30)  NOT NULL DEFAULT 'employee',
  `agency_id`  int(11)      DEFAULT NULL,
  `phone`      varchar(50)  DEFAULT NULL,
  `status`     varchar(20)  NOT NULL DEFAULT 'active',
  `created_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `staff_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `emergency_alert_table`
  ADD COLUMN `assigned_staff_id` int(11) DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `emergency_response` (
  `response_id` int(11)      NOT NULL AUTO_INCREMENT,
  `alert_id`    int(11)      NOT NULL,
  `staff_id`    int(11)      DEFAULT NULL,
  `status`      varchar(50)  DEFAULT NULL,
  `note`        varchar(500) DEFAULT NULL,
  `created_at`  timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`response_id`),
  KEY `resp_alert_idx` (`alert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- Phase 3 additions: severity, richer timeline, feedback
-- ---------------------------------------------------------------------------

ALTER TABLE `emergency_alert_table`
  ADD COLUMN `severity` varchar(20) DEFAULT NULL;

ALTER TABLE `emergency_response`
  ADD COLUMN `user_id` int(11)     DEFAULT NULL,
  ADD COLUMN `image`   varchar(200) DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `feedback` (
  `feedback_id` int(11)      NOT NULL AUTO_INCREMENT,
  `user_id`     int(11)      NOT NULL,
  `alert_id`    int(11)      DEFAULT NULL,
  `rating`      tinyint(4)   DEFAULT NULL,
  `comment`     varchar(500) DEFAULT NULL,
  `created_at`  timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`feedback_id`),
  KEY `feedback_user_idx` (`user_id`),
  KEY `feedback_alert_idx` (`alert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- Phase 4 additions: agency states, flags, richer incident detail
-- ---------------------------------------------------------------------------

ALTER TABLE `agency`
  ADD COLUMN `state_id` int(11) DEFAULT NULL;
UPDATE `agency` SET `state_id` = 24 WHERE `state_id` IS NULL;

ALTER TABLE `emergency_alert_table`
  ADD COLUMN `created_at`      timestamp   NULL DEFAULT CURRENT_TIMESTAMP,
  ADD COLUMN `flagged`         tinyint(1)  NOT NULL DEFAULT 0,
  ADD COLUMN `flag_reason`     varchar(255) DEFAULT NULL,
  ADD COLUMN `landmark`        varchar(200) DEFAULT NULL,
  ADD COLUMN `route`           varchar(200) DEFAULT NULL,
  ADD COLUMN `people_involved` int(11)     DEFAULT NULL,
  ADD COLUMN `affected_gender` varchar(20) DEFAULT NULL,
  ADD COLUMN `offender_gender` varchar(20) DEFAULT NULL;

-- ---------------------------------------------------------------------------
-- Phase 5 additions: support live chat
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `support_message` (
  `message_id` int(11)       NOT NULL AUTO_INCREMENT,
  `user_id`    int(11)       NOT NULL,
  `sender`     varchar(20)   NOT NULL DEFAULT 'user',
  `staff_id`   int(11)       DEFAULT NULL,
  `body`       varchar(1000) NOT NULL,
  `is_read`    tinyint(1)    NOT NULL DEFAULT 0,
  `created_at` timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`),
  KEY `support_user_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- Phase 6 additions: multi-responder dispatch flags
-- ---------------------------------------------------------------------------

ALTER TABLE `emergency_alert_table`
  ADD COLUMN `casualties` tinyint(1) NOT NULL DEFAULT 0,
  ADD COLUMN `weapon`     tinyint(1) NOT NULL DEFAULT 0;

UPDATE `category` SET `agency_id` = 4 WHERE `category_id` IN (3, 9);
