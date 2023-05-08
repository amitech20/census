-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2022 at 10:25 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `census_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `census_year`
--

CREATE TABLE `census_year` (
  `id` int(11) NOT NULL,
  `citizen_id` varchar(11) NOT NULL COMMENT 'citizen''s system id',
  `c_year` varchar(15) NOT NULL,
  `status` varchar(11) NOT NULL,
  `present` int(11) NOT NULL COMMENT 'whether it''s the current census or past'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `citizen`
--

CREATE TABLE `citizen` (
  `id` int(11) NOT NULL,
  `citizen_id` varchar(15) NOT NULL,
  `bid` varchar(13) NOT NULL COMMENT 'citizen''s birth ID',
  `nin` varchar(13) NOT NULL COMMENT 'citizen''s NIN',
  `name` varchar(100) NOT NULL COMMENT 'citizen''s full name',
  `dob` date NOT NULL COMMENT 'citizen''s date of birth',
  `sex` varchar(20) NOT NULL COMMENT 'male or female',
  `educBg` text NOT NULL COMMENT 'educational background of the citizen',
  `familyStructure` varchar(100) NOT NULL COMMENT 'citizen''s family structure',
  `occupation` varchar(100) NOT NULL COMMENT 'his/her occupation',
  `lga` int(11) NOT NULL COMMENT 'citizen''s local government of residence',
  `residentialAdd` text NOT NULL COMMENT 'citizen''s residential address',
  `homeAdd` text NOT NULL COMMENT 'citizen''s permanent/home address',
  `e_status` varchar(20) NOT NULL COMMENT 'citizen''s enumeration status (correction, pendind, approved, disputed)',
  `enumerator_id` varchar(10) NOT NULL COMMENT 'the person who enumerated him/her',
  `remark` text NOT NULL COMMENT 'if returned, reason why it was returned',
  `enum_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `nin_tracking_id` varchar(11) NOT NULL COMMENT 'tracking id for new nin if non existing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lgas`
--

CREATE TABLE `lgas` (
  `id` int(11) NOT NULL,
  `lga_name` varchar(40) NOT NULL,
  `longi` varchar(10) NOT NULL,
  `lat` varchar(10) NOT NULL,
  `gmaps` text NOT NULL,
  `lgahq` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lgas`
--

INSERT INTO `lgas` (`id`, `lga_name`, `longi`, `lat`, `gmaps`, `lgahq`) VALUES
(1, 'Aninri', '6.05', '7.583333', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d179548.8262980969!2d7.527156723114172!3d6.0622779885949045!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1043489d54a95bd5%3A0xe1d095f7d737028c!2sAninri!5e0!3m2!1sen!2sng!4v1651570604682!5m2!1sen!2sng', 'https://www.google.com/maps/place/Aninri+LGA/@6.0317259,7.5779091,19.5z/data=!4m5!3m4!1s0x10434799ee566df3:0xf1441ea6dfdda763!8m2!3d6.0318794!4d7.5780268'),
(2, 'Awgu', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11221.401018824705!2d7.4690080180232155!3d6.081507758682983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10434107a7b3d8e5%3A0x1129931123e4e7bd!2sAwgu!5e0!3m2!1sen!2sng!4v1651683227102!5m2!1sen!2sng', ''),
(3, 'Enugu East', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d123057.51667216378!2d7.519941690167296!3d6.551213488058826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1044bb1a9b6f5041%3A0x71922a94ac5eac9!2sEnugu%20East!5e0!3m2!1sen!2sng!4v1651683151015!5m2!1sen!2sng', ''),
(4, 'Enugu North', '', '', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d89706.93529887497!2d7.50084539162924!3d6.455103590144803!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1044a479ea38c22f%3A0x2fad0cb55e653be0!2sEnugu%20North!5e0!3m2!1sen!2sng!4v1651683017513!5m2!1sen!2sng', ''),
(5, 'Enugu South', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126878.57026009067!2d7.440400953762784!3d6.399759007907297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1044a0d5f0d4452d%3A0xd55c6eff8ce5bc56!2sEnugu%20South!5e0!3m2!1sen!2sng!4v1651570948561!5m2!1sen!2sng', ''),
(6, 'Ezeagu', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.07120810386!2d7.28899631413853!3d6.384811326532958!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10449d16dcb94885%3A0x4823ab74478b3ba8!2sEzeagu!5e0!3m2!1sen!2sng!4v1651570990993!5m2!1sen!2sng', ''),
(7, 'Igbo Etiti', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126804.26774446001!2d7.341698508012771!3d6.6922516950612945!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x104495349824905d%3A0x1488ae9cd55064a6!2sIgbo-Etiti!5e0!3m2!1sen!2sng!4v1651571025754!5m2!1sen!2sng', ''),
(8, 'Igbo Eze North', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126720.61666430444!2d7.392090559152269!3d7.007013454085901!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1044dfbf2c9d086b%3A0x8f8c97736a7142e4!2sIgbo-Eze-North!5e0!3m2!1sen!2sng!4v1651571064050!5m2!1sen!2sng', ''),
(9, 'Igbo Eze South', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126735.12410331695!2d7.326187708950894!3d6.953441412439287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1044e0d5ea800bd1%3A0x59a755ec5a1e5951!2sIgbo-Eze-South!5e0!3m2!1sen!2sng!4v1651571101944!5m2!1sen!2sng', ''),
(10, 'Isi Uzo', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253582.62650908012!2d7.543197098106483!3d6.741953915929026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1044c971e8296e3b%3A0x522e91c136a2b999!2sIsi-Uzo!5e0!3m2!1sen!2sng!4v1651571133494!5m2!1sen!2sng', ''),
(11, 'Nkanu East', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d507578.34187063563!2d7.350967237930688!3d6.334953800436933!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x104357ea386d0b01%3A0xd573932702fd20c4!2sNkanu%20East!5e0!3m2!1sen!2sng!4v1651571164375!5m2!1sen!2sng', ''),
(12, 'Nkanu West', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126897.88295725019!2d7.446092906805591!3d6.321528440823937!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10435f2fd648ae3d%3A0x3962b504c7542b64!2sNkanu%20West!5e0!3m2!1sen!2sng!4v1651571197050!5m2!1sen!2sng', ''),
(13, 'Nsukka', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126757.40937830792!2d7.3341217586445495!3d6.870338302700129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1044e87d972d23d3%3A0x9c5e49d6a945a261!2sNsukka!5e0!3m2!1sen!2sng!4v1651571235163!5m2!1sen!2sng', ''),
(14, 'Oji River', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31728.769487851125!2d7.2545383277541315!3d6.251055671111989!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x104364c9dfe367e1%3A0x6502800a497be259!2sOji%20River!5e0!3m2!1sen!2sng!4v1651571266097!5m2!1sen!2sng', ''),
(15, 'Udenu', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126751.8367354257!2d7.501936208720805!3d6.891212530057664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1044dae30d7a250d%3A0xfdecc3456937c818!2sUdenu!5e0!3m2!1sen!2sng!4v1651571352307!5m2!1sen!2sng', ''),
(16, 'Udi', '6.316667', '7.433333', '\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d507476.0478015086!2d7.025868944099738!3d6.438126959568743!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10449c80fc9c9f55%3A0x6f83b05a5b916a1!2sUdi!5e0!3m2!1sen!2sng!4v1651571390410!5m2!1sen!2sng', ''),
(17, 'Uzo-Uwani', '', '', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d507220.10175138176!2d6.851095409943358!3d6.689333289736865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10448ad73a18f8f3%3A0xf302a04a468b7f3d!2sUzo-Uwani!5e0!3m2!1sen!2sng!4v1651571420959!5m2!1sen!2sng', '');

-- --------------------------------------------------------

--
-- Table structure for table `retrieved_bid`
--

CREATE TABLE `retrieved_bid` (
  `id` int(11) NOT NULL,
  `bid` varchar(13) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `sex` varchar(10) NOT NULL,
  `lga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `retrieved_nin`
--

CREATE TABLE `retrieved_nin` (
  `id` int(11) NOT NULL,
  `nin` bigint(13) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `sex` varchar(10) NOT NULL,
  `lga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Refnum` varchar(11) NOT NULL,
  `fname` varchar(40) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(70) NOT NULL,
  `gender` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `lga_assigned` varchar(20) NOT NULL,
  `total_enum` int(11) NOT NULL DEFAULT 0,
  `total_app` int(11) NOT NULL DEFAULT 0,
  `total_disputed` int(11) NOT NULL DEFAULT 0,
  `nin` varchar(15) NOT NULL,
  `level` varchar(20) NOT NULL COMMENT 'superadmin, admin or enumarator',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '1:active, 2:queried, 0:bared\r\n',
  `session` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `census_year`
--
ALTER TABLE `census_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `citizen`
--
ALTER TABLE `citizen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `citizen_id` (`citizen_id`),
  ADD UNIQUE KEY `nin` (`nin`),
  ADD UNIQUE KEY `bid` (`bid`,`nin`) USING BTREE;

--
-- Indexes for table `lgas`
--
ALTER TABLE `lgas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lga_name` (`lga_name`);

--
-- Indexes for table `retrieved_bid`
--
ALTER TABLE `retrieved_bid`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nin` (`bid`);

--
-- Indexes for table `retrieved_nin`
--
ALTER TABLE `retrieved_nin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nin` (`nin`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Refnum` (`Refnum`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`,`nin`) USING BTREE,
  ADD KEY `level` (`level`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `census_year`
--
ALTER TABLE `census_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `citizen`
--
ALTER TABLE `citizen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lgas`
--
ALTER TABLE `lgas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `retrieved_bid`
--
ALTER TABLE `retrieved_bid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retrieved_nin`
--
ALTER TABLE `retrieved_nin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
