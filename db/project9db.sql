
-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2016 at 02:22 PM
-- Server version: 5.1.57
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `a3390791_pro8`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account_list`
--

CREATE TABLE `tbl_account_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_no` varchar(200) DEFAULT NULL,
  `acc_name` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `acc_type` varchar(200) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbl_account_list`
--

INSERT INTO `tbl_account_list` VALUES(5, '20001', 'New registration | Vehicles', '2016-04-12 00:00:00', 'Vehicles', 78.80, 'Registration card');
INSERT INTO `tbl_account_list` VALUES(7, '10004', 'Lost card | License', '2016-04-12 00:00:00', 'License', 97.00, 'Lost license replacement');
INSERT INTO `tbl_account_list` VALUES(8, '10010', 'New registration | Moto', '2016-04-12 00:00:00', 'Moto', 97.00, 'moto reg card');
INSERT INTO `tbl_account_list` VALUES(9, '10006', 'Damaged card | License', '2016-04-13 00:00:00', 'License', 40.00, 'damaged licece fee');
INSERT INTO `tbl_account_list` VALUES(12, '10005', 'Renewal | License', '2016-04-18 00:00:00', 'License', 50.00, '');
INSERT INTO `tbl_account_list` VALUES(13, '20002', 'Lost card | vehicles', '2016-05-03 00:00:00', 'Vehicles', 80.00, 'Vehciel registration card');
INSERT INTO `tbl_account_list` VALUES(14, '10012', 'Damaged card | Moto', '2016-05-03 00:00:00', 'Moto', 20.00, '');
INSERT INTO `tbl_account_list` VALUES(15, '10009', 'Renewal | Moto', '2016-05-03 00:00:00', 'Moto', 20.00, '');
INSERT INTO `tbl_account_list` VALUES(16, '10000', 'Renewal | vehicles', '2016-05-03 00:00:00', 'Vehicles', 0.00, '');
INSERT INTO `tbl_account_list` VALUES(17, '10015', 'Damaged card | vehicles', '2016-05-03 00:00:00', 'Vehicles', 110.00, '');
INSERT INTO `tbl_account_list` VALUES(18, '10077', 'New registration | License', '2016-05-03 00:00:00', 'License', 75.00, '');
INSERT INTO `tbl_account_list` VALUES(19, '10025', 'Transfer | vehicles', '2016-05-03 00:00:00', 'Vehicles', 180.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_acc_type`
--

CREATE TABLE `tbl_acc_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_acc_type`
--

INSERT INTO `tbl_acc_type` VALUES(1, 'Moto');
INSERT INTO `tbl_acc_type` VALUES(3, 'Vehicles');
INSERT INTO `tbl_acc_type` VALUES(6, 'License');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country`
--

CREATE TABLE `tbl_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(384) DEFAULT NULL,
  `iso_code_2` varchar(6) DEFAULT NULL,
  `iso_code_3` varchar(9) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `tbl_country`
--

INSERT INTO `tbl_country` VALUES(1, 'Britain', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(6, 'Ethiopia', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(3, 'Kenya', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(4, 'Somalia', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(5, 'Yemen', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(17, 'Sweden', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(22, 'Saudi', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(15, 'Qatar', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(14, 'UAE', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(18, 'India', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(19, 'Japan', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(20, 'South Korea', NULL, NULL, NULL);
INSERT INTO `tbl_country` VALUES(21, 'USA', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_driver_detail`
--

CREATE TABLE `tbl_driver_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(100) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `licence_no` varchar(200) DEFAULT NULL,
  `issue_place` varchar(200) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `gender` tinyint(1) DEFAULT '1' COMMENT '1 => male, 2 => female',
  `mother_name` varchar(200) DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `birth_place` varchar(200) DEFAULT NULL,
  `nationality` varchar(200) DEFAULT NULL,
  `address` text,
  `email` varchar(200) DEFAULT NULL,
  `contact_no` varchar(200) DEFAULT NULL,
  `personal_id` varchar(255) DEFAULT NULL,
  `vehicle_types` varchar(255) DEFAULT NULL,
  `comments` text,
  `image` varchar(255) DEFAULT NULL,
  `updated_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT ' 1 => updated, 0=> not updated',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_driver_detail`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_fine_master`
--

CREATE TABLE `tbl_fine_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fine_code` varchar(100) DEFAULT NULL,
  `comments` text,
  `black_point` int(11) DEFAULT NULL,
  `prison` varchar(200) DEFAULT NULL,
  `vehicle_confiscation` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1 => normal fine, 2 => fine master',
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=297 ;

--
-- Dumping data for table `tbl_fine_master`
--

INSERT INTO `tbl_fine_master` VALUES(1, '877', 'asdawK', NULL, NULL, NULL, 1, NULL);
INSERT INTO `tbl_fine_master` VALUES(3, '1', 'Driving dangerously (racing)', 12, ' ', '30 days', 2, 2000.00);
INSERT INTO `tbl_fine_master` VALUES(4, '2', 'Driving under the influence of alcohol, drugs or similar substances', 24, ' ', '60 days', 2, 0.00);
INSERT INTO `tbl_fine_master` VALUES(5, '3', 'Driving a vehicle without number plates', 24, ' ', '60 days', 2, 1000.00);
INSERT INTO `tbl_fine_master` VALUES(6, '4', 'Causing death of others', 12, ' ', '30 days', 2, 0.00);
INSERT INTO `tbl_fine_master` VALUES(7, '5', 'Not stopping after causing an accident that resulted in injuries', 24, ' ', '60 days', 2, 0.00);
INSERT INTO `tbl_fine_master` VALUES(8, '6', 'Reckless driving', 12, ' ', '30 days', 2, 2000.00);
INSERT INTO `tbl_fine_master` VALUES(9, '7', 'Exceeding maximum speed limit by more than 60km/h', 12, ' ', '30 days', 2, 1000.00);
INSERT INTO `tbl_fine_master` VALUES(10, '8', 'Driving in a way that is dangerous to the public', 12, ' ', '30 days', 2, 1000.00);
INSERT INTO `tbl_fine_master` VALUES(11, '9', 'Jumping a red light', 8, ' ', '15 days', 2, 800.00);
INSERT INTO `tbl_fine_master` VALUES(12, '10', 'Running away from a traffic policeman', 12, ' ', '30 days', 2, 800.00);
INSERT INTO `tbl_fine_master` VALUES(13, '11', 'Dangerous overtaking by trucks', 24, ' ', '60 days', 2, 800.00);
INSERT INTO `tbl_fine_master` VALUES(14, '12', 'Causing a car to overturn', 8, ' ', ' ', 2, 0.00);
INSERT INTO `tbl_fine_master` VALUES(15, '13', 'Causing serious injuries', 8, ' ', ' ', 2, 0.00);
INSERT INTO `tbl_fine_master` VALUES(16, '14', 'Exceeding maximum speed limit by not more than 60km/h', 6, ' ', ' ', 2, 900.00);
INSERT INTO `tbl_fine_master` VALUES(17, '15', 'Exceeding maximum speed limit by not more than 50km/h', 0, ' ', ' ', 2, 800.00);
INSERT INTO `tbl_fine_master` VALUES(18, '16', 'Overtaking on the hard shoulder', 6, ' ', ' ', 2, 600.00);
INSERT INTO `tbl_fine_master` VALUES(19, '*16', 'Overtaking on the hard shoulder [revised penalty 17 May 2014]', 10, '1 month', ' ', 2, 600.00);
INSERT INTO `tbl_fine_master` VALUES(20, '17', 'Entering road dangerously', 6, ' ', ' ', 2, 600.00);
INSERT INTO `tbl_fine_master` VALUES(21, '18', 'Causing moderate injury', 6, ' ', ' ', 2, 0.00);
INSERT INTO `tbl_fine_master` VALUES(22, '19', 'Heavy vehicle lane discipline', 6, ' ', ' ', 2, 600.00);
INSERT INTO `tbl_fine_master` VALUES(23, '20', 'Overtaking from a prohibited place', 6, ' ', ' ', 2, 600.00);
INSERT INTO `tbl_fine_master` VALUES(24, '21', 'Causing serious damage to a vehicle', 6, ' ', ' ', 2, 0.00);
INSERT INTO `tbl_fine_master` VALUES(25, '22', 'Exceeding maximum speed limit by not more than 40km/h', 0, ' ', ' ', 2, 700.00);
INSERT INTO `tbl_fine_master` VALUES(26, '23', 'Parking in fire hydrant places, spaces allocated for people with special needs and ambulance parking', 4, ' ', ' ', 2, 1000.00);
INSERT INTO `tbl_fine_master` VALUES(27, '24', 'Exceeding maximum speed limit by not more than 30km/h', 0, ' ', ' ', 2, 600.00);
INSERT INTO `tbl_fine_master` VALUES(28, '25', 'Driving against traffic', 4, ' ', ' ', 2, 400.00);
INSERT INTO `tbl_fine_master` VALUES(29, '26', 'Allowing children under 10 years old to sit in the front seat of a vehicle', 4, ' ', ' ', 2, 400.00);
INSERT INTO `tbl_fine_master` VALUES(30, '27', 'Failure to fasten seat belt while driving', 4, ' ', ' ', 2, 400.00);
INSERT INTO `tbl_fine_master` VALUES(31, '28', 'Failure to leave a safe distance', 4, ' ', ' ', 2, 400.00);
INSERT INTO `tbl_fine_master` VALUES(32, '29', 'Failure to follow the directions of a traffic policeman', 0, ' ', ' ', 2, 0.00);
INSERT INTO `tbl_fine_master` VALUES(33, '30', 'Exceeding maximum speed limit by not more than 20km/h', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(34, '31', 'Entering a road without ensuring that it is clear', 4, ' ', ' ', 2, 400.00);
INSERT INTO `tbl_fine_master` VALUES(35, '32', 'Exceeding permitted level of car window tinting', 0, ' ', '30 days', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(36, '33', 'Not giving way to emergency, police and public service vehicles or official convoys', 4, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(37, '34', 'Driving a heavy vehicle that does not comply with safety and security conditions', 0, ' ', '30 days', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(38, '35', 'Failure to stop after causing an accident', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(39, '36', 'Driving a noisy vehicle', 0, ' ', '30 days', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(40, '37', 'Allowing others to drive a vehicle for which they are unlicensed', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(41, '38', 'Loading a heavy vehicle in a way that may pose danger to others or to the road', 6, ' ', '7 days', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(42, '39', 'Overload or protruding load from a heavy vehicle without permission', 6, ' ', '7 days', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(43, '40', 'Driving a vehicle that causes pollution', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(44, '41', 'Stopping on the road for no reason', 4, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(45, '42', 'Stopping on a yellow box (marked on intersections)', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(46, '43', 'Not giving way to pedestrians on pedestrian crossings', 6, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(47, '44', 'Failure to abide by traffic signs and directions', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(48, '45', 'Throwing waste from vehicles onto roads', 4, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(49, '46', 'Refusing to give traffic police name and address when required', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(50, '47', 'Stopping vehicle on the left side of the road in prohibited places', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(51, '48', 'Stopping vehicle on pedestrian crossing', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(52, '49', 'Teaching driving in a training vehicle that does not bear a learning sign', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(53, '50', 'Teaching driving in a non-training vehicle without permission from licensing authority', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(54, '51', 'Placing marks on the road that may damage the road or block traffic', 0, ' ', ' ', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(55, '52', 'Operating industrial, construction and mechanical vehicles and tractors without permission from licensing authority', 0, ' ', '7 days', 2, 500.00);
INSERT INTO `tbl_fine_master` VALUES(56, '56', 'Exceeding maximum speed limit by not more than 10km/h', 0, ' ', ' ', 2, 400.00);
INSERT INTO `tbl_fine_master` VALUES(57, '57', 'Driving with a driving license issued by a foreign country except in permitted cases', 0, ' ', ' ', 2, 400.00);
INSERT INTO `tbl_fine_master` VALUES(58, '58', 'Violating the terms of the driving license', 0, ' ', ' ', 2, 300.00);
INSERT INTO `tbl_fine_master` VALUES(59, '59', 'Parking behind vehicles and blocking their movement', 0, ' ', ' ', 2, 300.00);
INSERT INTO `tbl_fine_master` VALUES(60, '60', 'Towing a vehicle or a boat with an unprepared vehicle', 0, ' ', ' ', 2, 300.00);
INSERT INTO `tbl_fine_master` VALUES(61, '61', 'Driving a vehicle that omits gases or fumes with substances exceeding permitted rates', 0, ' ', ' ', 2, 300.00);
INSERT INTO `tbl_fine_master` VALUES(62, '62', 'Leaving a vehicle on the road with its engine running (unattended)', 0, ' ', ' ', 2, 300.00);
INSERT INTO `tbl_fine_master` VALUES(63, '63', 'No lights on the back or sides of trailer container', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(64, '64', 'Lights on the back or sides of container not working', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(65, '65', 'Taxis, which have designated pickup areas, stopping in undesignated places', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(66, '66', 'Prohibited entry', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(67, '67', 'Blocking traffic', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(68, '68', 'Vehicle unfit for driving', 0, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(69, '69', 'Driving a light vehicle that does not comply with safety and security conditions', 0, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(70, '70', 'Not lifting exhaust of trucks', 0, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(71, '71', 'Not covering loads of trucks', 0, ' ', '7 days', 2, 3000.00);
INSERT INTO `tbl_fine_master` VALUES(72, '72', 'Using vehicle for purposes other than designated', 4, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(73, '73', 'Heavy vehicle prohibited entry', 4, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(74, '74', 'Violating loading or unloading regulations in parking', 4, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(75, '75', 'Carrying and transporting passengers illegally', 4, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(76, '76', 'Writing phrases or placing stickers on vehicle without permission', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(77, '77', 'Not taking road safety measures during vehicle breakdowns', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(78, '78', 'Turning at undesignated points', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(79, '79', 'Turning the wrong way', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(80, '80', 'Loading a light vehicle in a way that may pose a danger to others or to the road', 3, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(81, '81', 'Overload or protruding load on light vehicles without permission', 3, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(82, '82', 'Stopping vehicle without keeping the distance specified by the law from a curve or junction', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(83, '83', 'Transporting passengers by vehicle undesignated for this purpose', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(84, '84', 'Sudden swerve', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(85, '85', 'Driving a taxi without required license', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(86, '86', 'Carrying passengers in driving training vehicle', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(87, '87', 'Driving a taxi with an expired warranty', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(88, '88', 'Reversing dangerously', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(89, '89', 'Taxi refusing to carry passengers', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(90, '90', 'Falling or leaking load', 12, ' ', '30 days', 2, 3000.00);
INSERT INTO `tbl_fine_master` VALUES(91, '91', 'Not securing vehicle while parked', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(92, '92', 'Parking in prohibited places', 2, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(93, '93', 'Parking in loading and offloading areas without need', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(94, '94', 'Parking on road shoulder except in cases of emergency', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(95, '95', 'Using multi-colored lights', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(96, '96', 'Not wearing helmet while driving motorbike', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(97, '97', 'Exceeding passenger limit', 3, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(98, '98', 'Driving with tires in poor condition', 0, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(99, '99', 'Driving with an expired driving license', 3, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(100, '100', 'Not renewing vehicle registration after expiry', 0, ' ', ' ', 2, 400.00);
INSERT INTO `tbl_fine_master` VALUES(101, '101', 'Driving unlicensed vehicle', 0, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(102, '102', 'Violation of laws of using commercial number plates', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(103, '103', 'Not fixing number plates in designated places', 2, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(104, '104', 'Driving with one number plate', 2, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(105, '105', 'Driving at night or in foggy weather without lights', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(106, '106', 'Using not matching number plates for trailer and container', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(107, '107', 'Not fixing reflective stickers at the back of trucks and heavy vehicles', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(108, '108', 'Not using indicators when changing direction or turning', 3, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(109, '109', 'Not giving way for vehicles to pass on the left', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(110, '110', 'Not giving way to vehicles coming from the left where required', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(111, '111', 'Stopping a vehicle in a way that may pose danger or block traffic', 3, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(112, '112', 'Failure to have vehicle examined after carrying out major modification to engine or body', 0, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(113, '113', 'Using training vehicles outside of timings specified by licensing authority', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(114, '114', 'Using training vehicles in places not designated by licensing authority', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(115, '115', 'Overtaking from the right', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(116, '116', 'Overtaking in a wrong way', 3, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(117, '117', 'Driving an unlicensed vehicle', 0, ' ', '7 days', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(118, '118', 'Abuse of parking space', 3, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(119, '119', 'Number plates with unclear numbers', 3, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(120, '120', 'Violating tariff', 6, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(121, '121', 'Light vehicle lane discipline', 2, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(122, '122', 'Parking vehicles on pavement', 3, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(123, '123', 'Not showing vehicle registration card when required', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(124, '124', 'Not showing driving license when required', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(125, '125', 'Not fixing taxi sign where required', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(126, '126', 'Not fixing a sign indicating licensed overload', 3, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(127, '127', 'Using interior lights for no reason while driving', 0, ' ', ' ', 2, 100.00);
INSERT INTO `tbl_fine_master` VALUES(128, '128', 'Failure to abide by specified color for taxis or training cars', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(129, '129', 'Failure to display tariff of buses or taxis or not showing them when required', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(130, '130', 'Broken lights', 6, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(131, '131', 'Using horn in prohibited areas', 2, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(132, '132', 'Driving below minimum speed limit', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(133, '133', 'Failure to keep taxis and buses clean inside and outside', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(134, '134', 'Smoking inside taxis and buses', 0, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(135, '135', 'Using hand-held mobile phone while driving', 4, ' ', ' ', 2, 200.00);
INSERT INTO `tbl_fine_master` VALUES(136, '136', 'Not abiding by taxi drivers obligatory uniform or not keeping it in good condition', 0, ' ', ' ', 2, 100.00);
INSERT INTO `tbl_fine_master` VALUES(137, '137', 'Calling on passengers in the presence of signs', 0, ' ', ' ', 2, 100.00);
INSERT INTO `tbl_fine_master` VALUES(138, '139', 'Not carrying driving license while driving', 0, ' ', ' ', 2, 100.00);
INSERT INTO `tbl_fine_master` VALUES(139, '140', 'Not carrying vehicle registration card while driving', 0, ' ', ' ', 2, 100.00);
INSERT INTO `tbl_fine_master` VALUES(140, '141', 'Driving without spectacles or contact lenses', 0, ' ', ' ', 2, 100.00);
INSERT INTO `tbl_fine_master` VALUES(141, '142', 'Not using interior light in buses at night', 0, ' ', ' ', 2, 100.00);
INSERT INTO `tbl_fine_master` VALUES(142, '143', 'Broken indicator lights', 2, ' ', ' ', 2, 100.00);
INSERT INTO `tbl_fine_master` VALUES(143, '144', 'Using horn in a disturbing way', 2, ' ', ' ', 2, 100.00);
INSERT INTO `tbl_fine_master` VALUES(144, '145', 'Having no red light at the back of vehicle', 2, 'yes ', ' 1 month', 2, 100.00);
INSERT INTO `tbl_fine_master` VALUES(296, '146', 'sdfsdfsdfd', 2, 'no', '', 2, 123.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_licence_renewal`
--

CREATE TABLE `tbl_licence_renewal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `licence_no` varchar(200) DEFAULT NULL,
  `receipt_no` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `renewal_type` tinyint(1) DEFAULT '1' COMMENT '1 => Expire, 2 => Damage, 3 => Lost',
  `renewal_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `tbl_licence_renewal`
--

INSERT INTO `tbl_licence_renewal` VALUES(1, '7899009', '123', 100.00, 1, '2016-03-13', '2016-05-13');
INSERT INTO `tbl_licence_renewal` VALUES(2, '7899009', '123', 150.00, 2, '2016-04-16', '2016-07-15');
INSERT INTO `tbl_licence_renewal` VALUES(3, '7899009', '123', 0.00, 2, '1970-01-01', '1970-01-01');
INSERT INTO `tbl_licence_renewal` VALUES(4, '7899009', '1212312', 128.00, 1, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(5, '7899009', '12122331', 128.00, 1, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(6, '7899009', '4545e31', 128.00, 1, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(7, '7899009', 'eree31', 128.00, 1, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(8, '7899009', 'awda', 46.00, 3, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(9, '7899009', 'awda', 46.00, 3, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(10, '7899009', 'awda', 46.00, 3, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(11, '7899009', '1232323', 46.00, 1, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(12, '7899009', '123s', 0.00, 1, '1970-01-01', '1970-01-01');
INSERT INTO `tbl_licence_renewal` VALUES(13, '7899009', '123s', 0.00, 1, '1970-01-01', '1970-01-01');
INSERT INTO `tbl_licence_renewal` VALUES(14, '7899009', '099909', 120.00, 3, '2016-04-23', '2016-06-22');
INSERT INTO `tbl_licence_renewal` VALUES(15, '7899009', '099901', 120.00, 3, '2016-04-23', '2016-06-22');
INSERT INTO `tbl_licence_renewal` VALUES(16, '7899009', '09902', 100.00, 2, '2016-04-23', '2016-07-22');
INSERT INTO `tbl_licence_renewal` VALUES(17, '7899009', '099022', 100.00, 2, '2016-04-23', '2016-07-22');
INSERT INTO `tbl_licence_renewal` VALUES(18, '7899009', 'a', 0.00, 1, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(19, '7899009', '3344', 0.00, 1, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(20, '7899009', '1111', 199.00, 2, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(24, '7899009', '10001', 100.00, 2, '2016-04-23', '2016-07-23');
INSERT INTO `tbl_licence_renewal` VALUES(25, '7899009', '10002', 150.00, 3, '2016-04-23', '2016-07-22');
INSERT INTO `tbl_licence_renewal` VALUES(26, '7899007', '123', 55.00, 1, '2016-04-07', '2016-07-06');
INSERT INTO `tbl_licence_renewal` VALUES(28, '7899004', '45454', 77.00, 1, '2016-04-07', '2016-07-06');
INSERT INTO `tbl_licence_renewal` VALUES(30, '790', '1003', 45.35, 2, '2016-04-25', '2016-07-24');
INSERT INTO `tbl_licence_renewal` VALUES(31, '7899009', '123123', 100.00, 2, '2017-05-06', '2020-05-05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plate_types`
--

CREATE TABLE `tbl_plate_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plate_type` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tbl_plate_types`
--

INSERT INTO `tbl_plate_types` VALUES(1, 'PRI', 1);
INSERT INTO `tbl_plate_types` VALUES(2, 'PUB', 1);
INSERT INTO `tbl_plate_types` VALUES(3, 'GOV', 1);
INSERT INTO `tbl_plate_types` VALUES(4, 'TAX', 1);
INSERT INTO `tbl_plate_types` VALUES(5, 'DIP', 1);
INSERT INTO `tbl_plate_types` VALUES(6, 'MIL', 1);
INSERT INTO `tbl_plate_types` VALUES(17, 'OAU', 1);
INSERT INTO `tbl_plate_types` VALUES(14, 'POL', 1);
INSERT INTO `tbl_plate_types` VALUES(15, 'MUN', 1);
INSERT INTO `tbl_plate_types` VALUES(16, 'UN', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receipts`
--

CREATE TABLE `tbl_receipts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(200) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `received_from` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `for_opt` varchar(255) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `comments` text,
  `status` tinyint(1) DEFAULT '1' COMMENT '1 => Not used, 0 => used',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=216 ;

--
-- Dumping data for table `tbl_receipts`
--

INSERT INTO `tbl_receipts` VALUES(215, '111', '2016-05-07 00:00:00', NULL, 'test', 97.00, 'Lost card | License', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(214, '812', '2016-05-03 00:00:00', NULL, 'William johns', 180.00, 'Transfer | vehicles', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(213, '811', '2016-05-03 00:00:00', NULL, 'Abdo suka', 180.00, 'Transfer | vehicles', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(212, '810', '2016-05-03 00:00:00', NULL, 'sso plate', 97.00, 'New registration | Moto', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(211, '809', '2016-05-03 00:00:00', NULL, 'Moto hoto', 20.00, 'Renewal | Moto', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(209, '807', '2016-05-03 00:00:00', NULL, 'Yasmin Kamal', 20.00, 'Damaged card | Moto', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(208, '806', '2016-05-03 00:00:00', NULL, 'dooka mooka', 97.00, 'New registration | Moto', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(207, '805', '2016-02-02 00:00:00', NULL, 'Kamal yousuf', 78.80, 'New registration | Vehicles', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(206, '804', '2016-01-03 00:00:00', NULL, 'Musa kusa', 78.80, 'New registration | Vehicles', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(205, '803', '2016-05-03 00:00:00', NULL, 'Mustaf Barakat', 97.00, 'Lost card | License', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(204, '802', '2016-05-03 00:00:00', NULL, 'Maher abdulla', 50.00, 'Renewal | License', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(210, '808', '2016-05-03 00:00:00', NULL, 'Huda abbas', 75.00, 'New registration | License', NULL, '', 1);
INSERT INTO `tbl_receipts` VALUES(203, '801', '2016-05-03 00:00:00', NULL, 'Abdullatif abdulla', 78.80, 'New registration | Vehicles', NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_traffic_fines`
--

CREATE TABLE `tbl_traffic_fines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fine_no` varchar(100) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `issue_place` varchar(200) DEFAULT NULL,
  `fine_code` int(11) DEFAULT NULL,
  `fine_type` varchar(100) DEFAULT NULL,
  `plate_no` varchar(200) DEFAULT NULL,
  `registration` varchar(200) DEFAULT NULL,
  `driver_name` varchar(200) DEFAULT NULL,
  `licence_no` varchar(200) DEFAULT NULL,
  `comments` text,
  `status` tinyint(1) DEFAULT '1' COMMENT '1 => normal fine, 2 => fine master',
  `receipt_no` varchar(200) NOT NULL,
  `payment_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=151 ;

--
-- Dumping data for table `tbl_traffic_fines`
--

INSERT INTO `tbl_traffic_fines` VALUES(1, '2', '2016-04-06', '14:40:00', 'Islamabad', 1, 'Present', '7119', '98877', 'Haji Khan', '7899009', '', 2, '2', '2006-05-16');
INSERT INTO `tbl_traffic_fines` VALUES(148, '8001', '2016-01-01', '12:10:00', 'xamar weyne', 139, 'Present', 'AC45459', 'Moga', 'Salim', '11112', 'Paid2', 2, '12313', '2016-04-06');
INSERT INTO `tbl_traffic_fines` VALUES(149, '801', '2016-01-01', '12:30:00', 'Mogadishu', 9, 'Present', 'AC20675', 'Beydhabo', 'Latif Abdulla', '000', 'Paid2', 2, '78765', '2015-02-01');
INSERT INTO `tbl_traffic_fines` VALUES(150, '802', '1969-12-31', '12:10:00', 'Mogadishu', 14, 'Present', 'AC45459', '', 'Not known', '000', 'paid', 1, '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1 => Active, 0 => inactive',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` VALUES(1, 'admin', 'YWRtaW4=', '2016-04-17 00:00:00', '2016-07-16 00:00:00', '', 1);
INSERT INTO `tbl_users` VALUES(7, 'asd', 'YXNkYXNk', '2016-04-13 00:00:00', '2016-07-12 00:00:00', 'rwp', 1);
INSERT INTO `tbl_users` VALUES(9, 'Kelly', 'YXNkYXNk', '2016-04-13 00:00:00', '2016-07-12 00:00:00', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_permissions`
--

CREATE TABLE `tbl_user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `R` tinyint(1) DEFAULT '0' COMMENT '1 => yes, 0 => No',
  `W` tinyint(1) DEFAULT '0' COMMENT '1 => yes, 0 => No',
  `E` tinyint(1) DEFAULT '0' COMMENT '1 => yes, 0 => No',
  `module` tinyint(1) DEFAULT '1' COMMENT '1 => receipt, 2 => vehicle, 3 => users, 4 => reports',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141 ;

--
-- Dumping data for table `tbl_user_permissions`
--

INSERT INTO `tbl_user_permissions` VALUES(46, 9, 1, 1, 0, 1);
INSERT INTO `tbl_user_permissions` VALUES(47, 9, 1, 1, 0, 2);
INSERT INTO `tbl_user_permissions` VALUES(48, 9, 1, 1, 1, 3);
INSERT INTO `tbl_user_permissions` VALUES(49, 9, 1, 1, 1, 4);
INSERT INTO `tbl_user_permissions` VALUES(50, 10, 0, 0, 0, 1);
INSERT INTO `tbl_user_permissions` VALUES(51, 10, 0, 0, 0, 2);
INSERT INTO `tbl_user_permissions` VALUES(52, 10, 0, 0, 0, 3);
INSERT INTO `tbl_user_permissions` VALUES(53, 10, 0, 0, 0, 4);
INSERT INTO `tbl_user_permissions` VALUES(137, 1, 1, 1, 1, 4);
INSERT INTO `tbl_user_permissions` VALUES(136, 1, 1, 1, 1, 3);
INSERT INTO `tbl_user_permissions` VALUES(135, 1, 1, 1, 1, 2);
INSERT INTO `tbl_user_permissions` VALUES(134, 1, 1, 1, 1, 1);
INSERT INTO `tbl_user_permissions` VALUES(130, 7, 1, 0, 1, 1);
INSERT INTO `tbl_user_permissions` VALUES(131, 7, 0, 1, 0, 2);
INSERT INTO `tbl_user_permissions` VALUES(132, 7, 0, 0, 0, 3);
INSERT INTO `tbl_user_permissions` VALUES(133, 7, 1, 1, 0, 4);
INSERT INTO `tbl_user_permissions` VALUES(138, 1, 1, 1, 1, 5);
INSERT INTO `tbl_user_permissions` VALUES(139, 1, 1, 1, 1, 6);
INSERT INTO `tbl_user_permissions` VALUES(140, 1, 1, 1, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicles`
--

CREATE TABLE `tbl_vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Owner` varchar(255) DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `nationality` varchar(200) DEFAULT NULL,
  `birth_place` varchar(200) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` text,
  `gender` varchar(100) DEFAULT NULL,
  `personal_id` varchar(100) DEFAULT NULL,
  `fees` varchar(200) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `plate_no` varchar(100) DEFAULT NULL,
  `plate_type` varchar(100) DEFAULT NULL,
  `code` varchar(200) DEFAULT NULL,
  `vehicle` varchar(255) DEFAULT NULL,
  `origin` varchar(200) DEFAULT NULL,
  `weight` varchar(100) DEFAULT NULL,
  `engine_no` varchar(200) DEFAULT NULL,
  `v_type` varchar(200) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `hp` varchar(200) DEFAULT NULL,
  `chassis_no` varchar(200) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `cylinder` varchar(200) DEFAULT NULL,
  `comments` text,
  `issue_place` varchar(200) DEFAULT 'Mogadishu',
  `receipt_no` varchar(200) DEFAULT NULL,
  `updated_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `passengers` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `tbl_vehicles`
--

INSERT INTO `tbl_vehicles` VALUES(2, 'xyz', '1988-03-15', 'Australia', 'awdas', 'Mrs Khan', '+923345214098', 'aamir.satti88@gmail.com', 'House 9', '1', '998900122333', '60.00', '2016-04-06', '2016-03-18', 'AE9269', 'PUB', 'AE', 'TOYOTA  CAROLLA FIELDER', 'JABAN', '', '', '', 'SILVER', '', 'NZE1240012234', '2003', '', '', '', '234234', '2016-04-26 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(3, 'C/rashiid Maxamuud Guure', '0000-00-00', 'Somali', 'Muqdisho', 'Dahabo Diiriye', '615355533', '', 'Muqdisho', 'Lab', '', '95', '0000-00-00', '2016-03-25', 'AF0728', 'PUB', 'AF', 'TOYOTA COROLA', 'JABAN', '', '', '', 'WHITE', '', 'NZE124-0001101', '2004', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(4, 'Axmed Cali Samatar', '0000-00-00', 'Somali', 'G/kacyo', 'Maryan Cabdi Diirshe', '615523262', '', 'Hodan Muqdisho', 'Lab', '', '95', '0000-00-00', '2016-05-18', 'AE9887', 'PUB', 'AE', 'IVECO TURBO', 'JABAN', '', '', '', 'RED', '', 'WJM13JMS004140349', '1990', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(5, 'Cabdi Ceynab Siyaad', '0000-00-00', 'Somali', 'Jawhar', 'Salaado Rooble Siyaad', '615844911', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF2630', 'PUB', 'AF', 'TOYOTA NOAH', 'JABAN', '', '', '', 'WHITE', '', 'SR50-0113078', '2001', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(6, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF2599', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VWGE24-017912', '1998', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(7, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF2549', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VWGE24-043786', '2000', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(8, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF2008', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VWGE24-042475', '2000', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(9, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF2042', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VWGE24-037472', '1999', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(10, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF3075', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'GOLDEN', '', 'VPGE24-000195', '1999', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(11, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF3119', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'GOLDEN', '', 'VRE24-070532', '1995', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(12, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF3120', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VWMGE24-425983', '2000', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(13, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF3135', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'GOLDEN', '', 'VTGE24-062857', '1999', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(14, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF3291', 'PUB', 'AF', 'SUZKI ESCUDO', 'JABAN', '', '', '', 'GREEN', '', 'TD02W-100936', '1997', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(15, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF3292', 'PUB', 'AF', 'TOYOTA DYNA', 'JABAN', '', '', '', 'WHITE', '', 'BU66-005034', '1994', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(16, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF3293', 'PUB', 'AF', 'NISSAN CARAVAN', 'JABAN', '', '', '', 'GREEN', '', 'VTGE24-810060', '1997', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(17, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AE9489', 'PUB', 'AE', 'TOYOTA COROLA  FIELDER', 'JABAN', '', '', '', 'BLUE', '', 'NZE124-0001632', '2000', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(18, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AE9490', 'PUB', 'AE', 'NISSAN CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VWGE24-413506', '1999', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(19, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AE9593', 'PUB', 'AE', 'NISSAN CARAVAN', 'JABAN', '', '', '', 'GOLDEN', '', 'VWE24-009662', '1999', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(20, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF0755', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'GOLDEN', '', 'VTGE24-045878', '1995', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(21, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF0774', 'PUB', 'AF', 'NISSAN HOMY', 'JABAN', '', '', '', 'WHITE', '', 'VREG24-708402', '1996', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(22, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF0673', 'PUB', 'AF', 'NISSAN CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VPGE24-004428', '2001', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(23, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1427', 'PUB', 'AF', 'ISUZU CARGO', 'JABAN', '', '', '', 'WHITE', '', 'KRGE24-810112', '1997', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(24, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1428', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'GOLDEN', '', 'VTGF24-062138', '1998', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(25, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1429', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VWGE24-042450', '2000', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(26, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1734', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VWGE24-015418', '1997', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(27, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1735', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VRMGE24-131761', '1995', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(28, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1736', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VRGE24-514630', '1992', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(29, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1737', 'PUB', 'AF', 'NISSAN  CARAVAN', 'JABAN', '', '', '', 'GOLDEN', '', 'VRGE24-703920', '1995', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(30, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1818', 'PUB', 'AF', 'TOYOTA NOAH', 'JABAN', '', '', '', 'SILVER', '', 'SR50-0100930', '2000', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(31, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1819', 'PUB', 'AF', 'SUZUKI ESCUDO', 'JABAN', '', '', '', 'WHITE', '', 'TA02W-101172', '1999', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(32, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AE8588', 'PUB', 'AE', 'NISSAN CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VWGE24-013898', '1997', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(33, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AE8814', 'PUB', 'AE', 'NISSAN CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'VWGE24-013501', '1997', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(34, 'Maxamed C/llaahi Maxamed', '0000-00-00', 'Somali', 'G/ceel', 'Wiilo Aadan Rooble', '615127007', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AE9191', 'PUB', 'AE', 'NISSAN CARAVAN', 'JABAN', '', '', '', 'WHITE', '', 'KRGE24-037105', '1999', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(35, 'C/risaaq Ibraahim Maxamed', '0000-00-00', 'Somali', 'Sh/dhexe', 'Xaawo Cabdulle', '615521344', '', 'Muqdisho', 'Lab', '', '48', '0000-00-00', '0000-00-00', 'ME456', 'PUB', 'ME', 'MOTO TVS', 'HINDI', '', '', '', 'RED', '', '6E4A29866', '', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(36, 'Mowliid Calas Cali', '0000-00-00', 'Somali', 'Muqdisho', 'Naado Maxamed Xasan', '615840997', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1042', 'PUB', 'AF', 'TOYOTA SUCCEED', 'JABAN', '', '', '', 'SILVER', '', 'NCP58-0051696', '2006', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(37, 'Mowliid Calas Cali', '0000-00-00', 'Somali', 'Muqdisho', 'Naado Maxamed Xasan', '615840997', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF0613', 'PUB', 'AF', 'TOYOTA PREMIO', 'JABAN', '', '', '', 'SILVER', '', 'ZZT245-00258084', '2004', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(38, 'somone', '1979-06-04', 'Serbia', 'bor', 'rada', '63485515', '', 'Serbia', '1', '', '45.35', '2016-04-27', '0000-00-00', 'AE9528', 'PUB', 'AE', 'TOYOTAFIELDER', 'JABAN', '', '', '', 'SILVER', '', 'NZE124-0023178', '2002', '', '', 'Mogadishu', '2125', '2016-04-28 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(39, 'Mowliid Calas Cali', '0000-00-00', 'Somali', 'Muqdisho', 'Naado Maxamed Xasan', '615840997', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF3132', 'PUB', 'AF', 'TOYOTA RUNX', 'JABAN', '', '', '', 'WHITE', '', 'NZE124-0043660', '2004', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(40, 'Mowliid Calas Cali', '0000-00-00', 'Somali', 'Muqdisho', 'Naado Maxamed Xasan', '615840997', '', 'Wadajir Muqdisho', 'Lab', '', '95', '0000-00-00', '0000-00-00', 'AF1980', 'PUB', 'AF', 'TOYOTA FIELDER', 'JABAN', '', '', '', 'WHITE', '', 'NZE124-3035246', '2006', '', '', '', NULL, '0000-00-00 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(41, 'xyz', '1988-03-15', 'Australia', 'awdas', 'Mrs Khan', '+923345214098', 'aamir.satti88@gmail.com', 'House 9', '1', '998900122333', '60.00', '2016-04-06', '0000-00-00', 'AE9269', 'PUB', 'AE', 'TOYOTA  CAROLLA FIELDER', 'JABAN', '', '', '', 'SILVER', '', 'NZE1240012234', '2003', '', '', '', '234234', '2016-04-26 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(42, 'xyz', '1988-03-15', 'Australia', 'awdas', 'Mrs Khan', '+923345214098', 'aamir.satti88@gmail.com', 'House 9', '1', '998900122333', '60.00', '2016-04-06', '0000-00-00', 'AE9269', 'PUB', 'AE', 'TOYOTA  CAROLLA FIELDER', 'JABAN', '', '', '', 'SILVER', '', 'NZE1240012234', '2003', '', '', '', '234234', '2016-04-26 00:00:00', 1, '');
INSERT INTO `tbl_vehicles` VALUES(43, 'Johny', NULL, 'UK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-04-24', '2017-04-24', '0012', NULL, NULL, NULL, 'EU', NULL, NULL, 'Fiuro', 'Black', NULL, 'AERIK900222', '2014', NULL, NULL, 'PK', NULL, '2016-04-30 00:00:00', 1, '22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_plate_codes`
--

CREATE TABLE `tbl_vehicle_plate_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_plate_code` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_vehicle_plate_codes`
--

INSERT INTO `tbl_vehicle_plate_codes` VALUES(1, 'A', 1);
INSERT INTO `tbl_vehicle_plate_codes` VALUES(2, 'AC', 1);
INSERT INTO `tbl_vehicle_plate_codes` VALUES(3, 'AD', 1);
INSERT INTO `tbl_vehicle_plate_codes` VALUES(4, 'AE', 1);
INSERT INTO `tbl_vehicle_plate_codes` VALUES(5, 'AF', 1);
INSERT INTO `tbl_vehicle_plate_codes` VALUES(6, 'B', 1);
INSERT INTO `tbl_vehicle_plate_codes` VALUES(7, 'ME', 1);
INSERT INTO `tbl_vehicle_plate_codes` VALUES(8, 'MF', 1);
INSERT INTO `tbl_vehicle_plate_codes` VALUES(9, 'MG', 1);
INSERT INTO `tbl_vehicle_plate_codes` VALUES(10, 'MH', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_renewal`
--

CREATE TABLE `tbl_vehicle_renewal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plate_no` varchar(200) DEFAULT NULL,
  `receipt_no` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `renewal_type` tinyint(1) DEFAULT '1' COMMENT '1 => Expire, 2 => Damage, 3 => Lost, 4 => Transfer',
  `renewal_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_vehicle_renewal`
--

INSERT INTO `tbl_vehicle_renewal` VALUES(1, 'AE9269', '99800', 97.00, 1, '2016-04-06', '2019-04-06');
INSERT INTO `tbl_vehicle_renewal` VALUES(3, 'AE9269', '67800', 78.80, 4, '2016-04-06', '2019-04-06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_transfer`
--

CREATE TABLE `tbl_vehicle_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Owner` varchar(255) DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `nationality` varchar(200) DEFAULT NULL,
  `birth_place` varchar(200) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` text,
  `gender` varchar(100) DEFAULT NULL,
  `personal_id` varchar(100) DEFAULT NULL,
  `amount` varchar(200) DEFAULT NULL,
  `plate_no` varchar(100) DEFAULT NULL,
  `chassis_no` varchar(200) DEFAULT NULL,
  `owner_status` tinyint(1) DEFAULT '1' COMMENT '1 => new, 2 => old',
  `issue_date` date DEFAULT NULL,
  `receipt_no` varchar(200) DEFAULT NULL,
  `issue_place` varchar(200) NOT NULL DEFAULT 'Mogadishu',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_vehicle_transfer`
--

INSERT INTO `tbl_vehicle_transfer` VALUES(1, 'Liibaan Maxamed Weheliye', '0000-00-00', 'Somali', 'Muqdisho', 'Kaaho Yaasiin Xasan', '615515147', '', 'Hodan Muqdisho', 'Lab', '', '95', 'AE9269', 'NZE1240012234', 2, '0000-00-00', NULL, 'Mogadishu');
INSERT INTO `tbl_vehicle_transfer` VALUES(2, 'Liibaan Maxamed Weheliye', '0000-00-00', 'Somali', 'Muqdisho', 'Kaaho Yaasiin Xasan', '615515147', '', 'Hodan Muqdisho', 'Lab', '', '95', 'AE9269', 'NZE1240012234', 2, '0000-00-00', '', 'Mogadishu');
INSERT INTO `tbl_vehicle_transfer` VALUES(3, 'Liibaan Maxamed Weheliye', '0000-00-00', 'Somali', 'Muqdisho', 'Kaaho Yaasiin Xasan', '615515147', '', 'Hodan Muqdisho', 'Lab', '', '95', 'AE9269', 'NZE1240012234', 2, '0000-00-00', '', 'Mogadishu');
INSERT INTO `tbl_vehicle_transfer` VALUES(4, 'Ali Ahmed', '1988-03-15', 'Option 3', 'awdas', 'Mrs Khan', '+923345214098', 'aamir.satti88@gmail.com', 'House 9', '1', '998900122333', '100', 'AE9269', 'NZE1240012234', 2, '2016-05-04', '123123', 'Mogadishu');
INSERT INTO `tbl_vehicle_transfer` VALUES(5, 'Amjad Khan', '1970-01-01', 'Option 2', 'awdas', 'Mrs Khan', '234234234', 'aamir.satti88@gmail.com', 'House 9', '1', 'asd', '45.00', 'AE9269', 'NZE1240012234', 2, '2016-04-06', '123', 'Mogadishu');
INSERT INTO `tbl_vehicle_transfer` VALUES(6, 'Mowliid Calas Cali', '0000-00-00', 'Somali', 'Muqdisho', 'Naado Maxamed Xasan', '615840997', '', 'Wadajir Muqdisho', 'Lab', '', '95', 'AE9528', 'NZE124-0023178', 2, '0000-00-00', '', 'Mogadishu');
INSERT INTO `tbl_vehicle_transfer` VALUES(7, 'somone', '1969-12-31', '', '', '', '', '', '', '1', '', '45.35', 'AE9528', 'NZE124-0023178', 2, '2016-04-27', '2125', 'Mogadishu');
INSERT INTO `tbl_vehicle_transfer` VALUES(8, 'Transfer test', '1965-01-01', 'Austria', 'Aden', 'Suhail ali', '06788888', '', 'Mogadisho', '1', '', '0.00', 'AE9528', 'NZE124-0023178', 2, '2016-04-27', '2126', 'Mogadishu');
INSERT INTO `tbl_vehicle_transfer` VALUES(9, 'Transfer test', '1969-12-31', '', '', '', '', '', '', '1', '', '0.00', 'AE9528', 'NZE124-0023178', 2, '2016-04-27', '2126', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_types`
--

CREATE TABLE `tbl_vehicle_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=208 ;

--
-- Dumping data for table `tbl_vehicle_types`
--

INSERT INTO `tbl_vehicle_types` VALUES(1, 'Nooca Gaadiidka', 1);
INSERT INTO `tbl_vehicle_types` VALUES(2, 'TOYOTA HILUX PICK UP', 1);
INSERT INTO `tbl_vehicle_types` VALUES(3, 'MARCEDEZ LB', 1);
INSERT INTO `tbl_vehicle_types` VALUES(4, 'TOYOTA HILUX SURF', 1);
INSERT INTO `tbl_vehicle_types` VALUES(5, 'CATTERPILLAR BULDOZER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(6, 'CATTERPILLAR SHOVEL', 1);
INSERT INTO `tbl_vehicle_types` VALUES(7, 'LAND ROVER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(8, 'TOYOTA HIACE TRUCK  PICK UP', 1);
INSERT INTO `tbl_vehicle_types` VALUES(9, 'TOYOTA HIACE', 1);
INSERT INTO `tbl_vehicle_types` VALUES(10, 'TOYOTA PREMIO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(11, 'FIAT ACM 80', 1);
INSERT INTO `tbl_vehicle_types` VALUES(12, 'FIAT 682 N2', 1);
INSERT INTO `tbl_vehicle_types` VALUES(13, 'P&H 800 XL CRANE WHITH WHEEL', 1);
INSERT INTO `tbl_vehicle_types` VALUES(14, 'FIAT VIBERTI', 1);
INSERT INTO `tbl_vehicle_types` VALUES(15, 'TRAILER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(16, 'TOYOTA FIELDER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(17, 'MERCEDEZ ALTESO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(18, 'NISSAN ATLAS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(19, 'IVECO TRUCK', 1);
INSERT INTO `tbl_vehicle_types` VALUES(20, 'HONDA CRV', 1);
INSERT INTO `tbl_vehicle_types` VALUES(21, 'TOYOTA RAV4', 1);
INSERT INTO `tbl_vehicle_types` VALUES(22, 'BEDFORD TM 4X4', 1);
INSERT INTO `tbl_vehicle_types` VALUES(23, 'ISUZU WTZARD', 1);
INSERT INTO `tbl_vehicle_types` VALUES(24, 'BEDFORD TM 6X6', 1);
INSERT INTO `tbl_vehicle_types` VALUES(25, 'FODEN RECOVERY', 1);
INSERT INTO `tbl_vehicle_types` VALUES(26, 'TOYOTA RAUM', 1);
INSERT INTO `tbl_vehicle_types` VALUES(27, 'STEYR 1291-280', 1);
INSERT INTO `tbl_vehicle_types` VALUES(28, 'TOYOTA LITEACE', 1);
INSERT INTO `tbl_vehicle_types` VALUES(29, 'FIAT 300 PC', 1);
INSERT INTO `tbl_vehicle_types` VALUES(30, 'TOYOTA VITZ', 1);
INSERT INTO `tbl_vehicle_types` VALUES(31, 'TOYOTA HARIER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(32, 'TRACTOR FIAT A 4 RM 80 6 DT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(33, 'TRUCK FIAT OM 1000', 1);
INSERT INTO `tbl_vehicle_types` VALUES(34, 'MOTO BAJAJ', 1);
INSERT INTO `tbl_vehicle_types` VALUES(35, 'MOTO BIAGGIO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(36, 'MOTO TVS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(37, 'K-SETRA BUS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(38, 'TOYOTA SPACIO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(39, 'TOYOTA SUCCED', 1);
INSERT INTO `tbl_vehicle_types` VALUES(40, 'SCANIA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(41, 'FIAT ALLIS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(42, 'Toyota HILUX', 1);
INSERT INTO `tbl_vehicle_types` VALUES(43, 'Toyota CROWN', 1);
INSERT INTO `tbl_vehicle_types` VALUES(44, 'Toyata COROLA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(45, 'FORD GALAXY TL06', 1);
INSERT INTO `tbl_vehicle_types` VALUES(46, 'MITSUBISHI', 1);
INSERT INTO `tbl_vehicle_types` VALUES(47, 'Nissan Patrol', 1);
INSERT INTO `tbl_vehicle_types` VALUES(48, 'TOYOTA LAND CRUISER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(49, 'GMC', 1);
INSERT INTO `tbl_vehicle_types` VALUES(50, 'FIAT 110', 1);
INSERT INTO `tbl_vehicle_types` VALUES(51, 'FIAT 682 N3', 1);
INSERT INTO `tbl_vehicle_types` VALUES(52, 'FIAT 662 DT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(53, 'FIAT IVECO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(54, 'FIAT 682 N4', 1);
INSERT INTO `tbl_vehicle_types` VALUES(55, 'FIAT 130 NC', 1);
INSERT INTO `tbl_vehicle_types` VALUES(56, 'FIAT 110 NC', 1);
INSERT INTO `tbl_vehicle_types` VALUES(57, 'FIAT 110 PC', 1);
INSERT INTO `tbl_vehicle_types` VALUES(58, 'FIAT 100-90', 1);
INSERT INTO `tbl_vehicle_types` VALUES(59, 'FIAT 90', 1);
INSERT INTO `tbl_vehicle_types` VALUES(60, 'FIAT TM', 1);
INSERT INTO `tbl_vehicle_types` VALUES(61, 'FIAT 766 DT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(62, 'FIAT 80-66 DT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(63, 'FIAT 70-66 DT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(64, 'NISSAN CARAVAN', 1);
INSERT INTO `tbl_vehicle_types` VALUES(65, 'NISSAN HOMY', 1);
INSERT INTO `tbl_vehicle_types` VALUES(66, 'NISSAN URVAN', 1);
INSERT INTO `tbl_vehicle_types` VALUES(67, 'NISSAN SAFARI', 1);
INSERT INTO `tbl_vehicle_types` VALUES(68, 'NISSAN 4X4', 1);
INSERT INTO `tbl_vehicle_types` VALUES(69, 'NISSAN', 1);
INSERT INTO `tbl_vehicle_types` VALUES(70, 'NISSAN VITARA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(71, 'NISSAN EXTRAIL', 1);
INSERT INTO `tbl_vehicle_types` VALUES(72, 'NISSAN DIESEL', 1);
INSERT INTO `tbl_vehicle_types` VALUES(73, 'NISSAN DIESEL UD', 1);
INSERT INTO `tbl_vehicle_types` VALUES(74, 'TOYOTA DYNA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(75, 'T0Y0TA CARIB', 1);
INSERT INTO `tbl_vehicle_types` VALUES(76, 'SUZUKI CARRY', 1);
INSERT INTO `tbl_vehicle_types` VALUES(77, 'SUZUKI ESCUDO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(78, 'SUZUKI VITARA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(79, 'SUZUKI ALTA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(80, 'SUZUKI KEI', 1);
INSERT INTO `tbl_vehicle_types` VALUES(81, 'MERCEDEZ BENZ', 1);
INSERT INTO `tbl_vehicle_types` VALUES(82, 'TOYOTA NOAH', 1);
INSERT INTO `tbl_vehicle_types` VALUES(83, 'TOYOTA ALLION', 1);
INSERT INTO `tbl_vehicle_types` VALUES(84, 'MITSUBISHI FUSO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(85, 'MITSUBISHI PAJEROmo', 1);
INSERT INTO `tbl_vehicle_types` VALUES(86, 'MITSUBISHI CANTER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(87, 'TOYOTA FORTUNER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(88, 'IVECO TURBO TURBOSTAR', 1);
INSERT INTO `tbl_vehicle_types` VALUES(89, 'HONDA FIT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(90, 'MOTO VESPA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(91, 'MOTO RAUMY', 1);
INSERT INTO `tbl_vehicle_types` VALUES(92, 'MOTO FEKON', 1);
INSERT INTO `tbl_vehicle_types` VALUES(93, 'FIAT AUG AG 70', 1);
INSERT INTO `tbl_vehicle_types` VALUES(94, 'TOYOTA CARINA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(95, 'TRAILER VIBERT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(96, 'SHOVEL FIAT ALLIS 580', 1);
INSERT INTO `tbl_vehicle_types` VALUES(97, 'IVECO MAGIRUS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(98, 'MOTO KENAGO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(99, 'CITREON C4 VN CFF', 1);
INSERT INTO `tbl_vehicle_types` VALUES(100, 'MOTO HTA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(101, 'TOYOTA IST', 1);
INSERT INTO `tbl_vehicle_types` VALUES(102, 'SUZUKI EVERY', 1);
INSERT INTO `tbl_vehicle_types` VALUES(103, 'PARLET', 1);
INSERT INTO `tbl_vehicle_types` VALUES(104, 'FIAT BG', 1);
INSERT INTO `tbl_vehicle_types` VALUES(105, 'IVECO WATER TANKER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(106, 'TRUCK VOLVO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(107, 'NISSAN TEANA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(108, 'TOYOTA CAMRY', 1);
INSERT INTO `tbl_vehicle_types` VALUES(109, 'TOYOTA MARKII', 1);
INSERT INTO `tbl_vehicle_types` VALUES(110, 'TOYOTA PRADO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(111, 'TOYOTA TOWNACE', 1);
INSERT INTO `tbl_vehicle_types` VALUES(112, 'TRUCK MOUNTED CONCRETED PUMP', 1);
INSERT INTO `tbl_vehicle_types` VALUES(113, 'TOYOTA CARIB', 1);
INSERT INTO `tbl_vehicle_types` VALUES(114, 'TOYOTA SUCSUDE', 1);
INSERT INTO `tbl_vehicle_types` VALUES(115, 'MOTO DIASSIO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(116, 'TOYOTA COROLA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(117, 'ISUZU FARGO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(118, 'MOTO SAZGAR', 1);
INSERT INTO `tbl_vehicle_types` VALUES(119, 'LEXUS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(120, 'EXCAVOTAR FIAT HITACHI', 1);
INSERT INTO `tbl_vehicle_types` VALUES(121, 'DAIHATSU TERIOS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(122, 'TOYOTA PLATZS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(123, 'DYNAPAC ROAD LOADER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(124, 'TRUCK ASTRA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(125, 'NSSAN DIESEL CRANE TRUCK', 1);
INSERT INTO `tbl_vehicle_types` VALUES(126, 'NISSAN TRUCK', 1);
INSERT INTO `tbl_vehicle_types` VALUES(127, 'FIAT IVECO 90PM16', 1);
INSERT INTO `tbl_vehicle_types` VALUES(128, 'TOYOTA STARLET', 1);
INSERT INTO `tbl_vehicle_types` VALUES(129, 'NISSAN CARGO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(130, 'NISSAN CONDAR', 1);
INSERT INTO `tbl_vehicle_types` VALUES(131, 'TOYOTO PROBOX', 1);
INSERT INTO `tbl_vehicle_types` VALUES(132, 'FIAT 662 N2', 1);
INSERT INTO `tbl_vehicle_types` VALUES(133, 'NISSAN DATSUN PICK UP', 1);
INSERT INTO `tbl_vehicle_types` VALUES(134, 'TOYOTA TOWNACE NOAH', 1);
INSERT INTO `tbl_vehicle_types` VALUES(135, 'TOYOTA WIISH', 1);
INSERT INTO `tbl_vehicle_types` VALUES(136, 'NISSAN NAVARA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(137, 'FIAT 131', 1);
INSERT INTO `tbl_vehicle_types` VALUES(138, 'CITREON JUMPER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(139, 'FIAT 178', 1);
INSERT INTO `tbl_vehicle_types` VALUES(140, 'TOYOTA AXIO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(141, 'FIAT 330', 1);
INSERT INTO `tbl_vehicle_types` VALUES(142, 'TRACTOR MF 275', 1);
INSERT INTO `tbl_vehicle_types` VALUES(143, 'JACK DYNA CAMAL', 1);
INSERT INTO `tbl_vehicle_types` VALUES(144, 'FIAT TRACTOR AGRIFULL', 1);
INSERT INTO `tbl_vehicle_types` VALUES(145, 'TOYOTA JIMNY', 1);
INSERT INTO `tbl_vehicle_types` VALUES(146, 'AGRICULTURAL TRACKTOR', 1);
INSERT INTO `tbl_vehicle_types` VALUES(147, 'AGRICULTURAL TRACKTORSAME 60 4WD', 1);
INSERT INTO `tbl_vehicle_types` VALUES(148, 'NISSAN NOTE', 1);
INSERT INTO `tbl_vehicle_types` VALUES(149, 'FIAT 80-90', 1);
INSERT INTO `tbl_vehicle_types` VALUES(150, 'MINI PAJERO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(151, 'MOTO KINGS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(152, 'MITSUBISHI SHOGUN', 1);
INSERT INTO `tbl_vehicle_types` VALUES(153, 'IVECO FORD TRUCK', 1);
INSERT INTO `tbl_vehicle_types` VALUES(154, 'TOYOTA 4 RUNNER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(155, 'TOYOTA WIISH', 1);
INSERT INTO `tbl_vehicle_types` VALUES(156, 'NISSAN TINA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(157, 'FIAT ASTAR', 1);
INSERT INTO `tbl_vehicle_types` VALUES(158, 'FIAT EXCAVATOR TRUCTORCTER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(159, 'FIAT SHOVEL ALLIS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(160, 'TRUCTOR IVECO 330.42', 1);
INSERT INTO `tbl_vehicle_types` VALUES(161, 'HONDA ACCORD', 1);
INSERT INTO `tbl_vehicle_types` VALUES(162, 'IVECO TRAILER FIAT 380', 1);
INSERT INTO `tbl_vehicle_types` VALUES(163, 'FIAT OM 110', 1);
INSERT INTO `tbl_vehicle_types` VALUES(164, 'CAT 950', 1);
INSERT INTO `tbl_vehicle_types` VALUES(165, 'FIAT 110 PC/115', 1);
INSERT INTO `tbl_vehicle_types` VALUES(166, 'MAN 6X4', 1);
INSERT INTO `tbl_vehicle_types` VALUES(167, 'FIAT 130-90DT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(168, 'NISSAN CARGO TRUCK', 1);
INSERT INTO `tbl_vehicle_types` VALUES(169, 'GRAND TIGER PICK UP', 1);
INSERT INTO `tbl_vehicle_types` VALUES(170, 'TOYOTA NADIA', 1);
INSERT INTO `tbl_vehicle_types` VALUES(171, 'TOYOTA WIISH', 1);
INSERT INTO `tbl_vehicle_types` VALUES(172, 'TOYOTA VOXY', 1);
INSERT INTO `tbl_vehicle_types` VALUES(173, 'TOYOTA CEMI', 1);
INSERT INTO `tbl_vehicle_types` VALUES(174, 'NISSAN TERANO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(175, 'FIAT 80-76', 1);
INSERT INTO `tbl_vehicle_types` VALUES(176, 'VOLVO FH12-460', 1);
INSERT INTO `tbl_vehicle_types` VALUES(177, 'NISSAN CREW CAB PICK UP', 1);
INSERT INTO `tbl_vehicle_types` VALUES(178, 'TOYOTA AVENSIS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(179, 'TRAILER DALL', 1);
INSERT INTO `tbl_vehicle_types` VALUES(180, 'TRAILER VIBERT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(181, 'TOYOTA AXIO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(182, 'TOYOTA SEATER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(183, 'FIAT 65-66', 1);
INSERT INTO `tbl_vehicle_types` VALUES(184, 'FIAT 6605/N', 1);
INSERT INTO `tbl_vehicle_types` VALUES(185, 'FIAT ALLIS FR 10B', 1);
INSERT INTO `tbl_vehicle_types` VALUES(186, 'RIMOOR VIBERT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(187, 'NISSAN PICK UP 4X2', 1);
INSERT INTO `tbl_vehicle_types` VALUES(188, 'MERCEDEZ MINI BUS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(189, 'TOYOTA COROLA FIELDER', 1);
INSERT INTO `tbl_vehicle_types` VALUES(190, 'FIAT 666DT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(191, 'TOYOTA HILUX IVINCIBLE', 1);
INSERT INTO `tbl_vehicle_types` VALUES(192, 'MOTO.LT150', 1);
INSERT INTO `tbl_vehicle_types` VALUES(193, 'TOYOTA ISIS', 1);
INSERT INTO `tbl_vehicle_types` VALUES(194, 'TRUCK FIAT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(195, 'FIAT IVECO 90', 1);
INSERT INTO `tbl_vehicle_types` VALUES(196, 'FIAT 640 DT', 1);
INSERT INTO `tbl_vehicle_types` VALUES(197, 'MAZDA B2500 PICK UP', 1);
INSERT INTO `tbl_vehicle_types` VALUES(198, 'IVECO 330 35', 1);
INSERT INTO `tbl_vehicle_types` VALUES(199, 'MF 590 TRUCKTOR', 1);
INSERT INTO `tbl_vehicle_types` VALUES(200, 'FIAT 6066', 1);
INSERT INTO `tbl_vehicle_types` VALUES(201, 'TAREEL CALAPRESE', 1);
INSERT INTO `tbl_vehicle_types` VALUES(202, 'TOYOTA MPV', 1);
INSERT INTO `tbl_vehicle_types` VALUES(203, 'FIAT DUCATO', 1);
INSERT INTO `tbl_vehicle_types` VALUES(204, 'TRACKTOR M542SP', 1);
INSERT INTO `tbl_vehicle_types` VALUES(205, 'TRUCK IVECO 190-36', 1);
INSERT INTO `tbl_vehicle_types` VALUES(206, 'FIAT 130-90', 1);
INSERT INTO `tbl_vehicle_types` VALUES(207, 'MITSUBISHI L200', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_v_origin`
--

CREATE TABLE `tbl_v_origin` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(384) DEFAULT NULL,
  `iso_code_2` varchar(6) DEFAULT NULL,
  `iso_code_3` varchar(9) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=255 ;

--
-- Dumping data for table `tbl_v_origin`
--

INSERT INTO `tbl_v_origin` VALUES(1, 'Afghanistan', 'AF', 'AFG', 1);
INSERT INTO `tbl_v_origin` VALUES(2, 'Albania', 'AL', 'ALB', 1);
INSERT INTO `tbl_v_origin` VALUES(3, 'Algeria', 'DZ', 'DZA', 1);
INSERT INTO `tbl_v_origin` VALUES(4, 'American Samoa', 'AS', 'ASM', 1);
INSERT INTO `tbl_v_origin` VALUES(5, 'Andorra', 'AD', 'AND', 1);
INSERT INTO `tbl_v_origin` VALUES(6, 'Angola', 'AO', 'AGO', 1);
INSERT INTO `tbl_v_origin` VALUES(7, 'Anguilla', 'AI', 'AIA', 1);
INSERT INTO `tbl_v_origin` VALUES(8, 'Antarctica', 'AQ', 'ATA', 1);
INSERT INTO `tbl_v_origin` VALUES(9, 'Antigua and Barbuda', 'AG', 'ATG', 1);
INSERT INTO `tbl_v_origin` VALUES(10, 'Argentina', 'AR', 'ARG', 1);
INSERT INTO `tbl_v_origin` VALUES(11, 'Armenia', 'AM', 'ARM', 1);
INSERT INTO `tbl_v_origin` VALUES(12, 'Aruba', 'AW', 'ABW', 1);
INSERT INTO `tbl_v_origin` VALUES(13, 'Australia', 'AU', 'AUS', 1);
INSERT INTO `tbl_v_origin` VALUES(14, 'Austria', 'AT', 'AUT', 1);
INSERT INTO `tbl_v_origin` VALUES(15, 'Azerbaijan', 'AZ', 'AZE', 1);
INSERT INTO `tbl_v_origin` VALUES(16, 'Bahamas', 'BS', 'BHS', 1);
INSERT INTO `tbl_v_origin` VALUES(17, 'Bahrain', 'BH', 'BHR', 1);
INSERT INTO `tbl_v_origin` VALUES(18, 'Bangladesh', 'BD', 'BGD', 1);
INSERT INTO `tbl_v_origin` VALUES(19, 'Barbados', 'BB', 'BRB', 1);
INSERT INTO `tbl_v_origin` VALUES(20, 'Belarus', 'BY', 'BLR', 1);
INSERT INTO `tbl_v_origin` VALUES(21, 'Belgium', 'BE', 'BEL', 1);
INSERT INTO `tbl_v_origin` VALUES(22, 'Belize', 'BZ', 'BLZ', 1);
INSERT INTO `tbl_v_origin` VALUES(23, 'Benin', 'BJ', 'BEN', 1);
INSERT INTO `tbl_v_origin` VALUES(24, 'Bermuda', 'BM', 'BMU', 1);
INSERT INTO `tbl_v_origin` VALUES(25, 'Bhutan', 'BT', 'BTN', 1);
INSERT INTO `tbl_v_origin` VALUES(26, 'Bolivia', 'BO', 'BOL', 1);
INSERT INTO `tbl_v_origin` VALUES(27, 'Bosnia and Herzegovina', 'BA', 'BIH', 1);
INSERT INTO `tbl_v_origin` VALUES(28, 'Botswana', 'BW', 'BWA', 1);
INSERT INTO `tbl_v_origin` VALUES(29, 'Bouvet Island', 'BV', 'BVT', 1);
INSERT INTO `tbl_v_origin` VALUES(30, 'Brazil', 'BR', 'BRA', 1);
INSERT INTO `tbl_v_origin` VALUES(31, 'British Indian Ocean Territory', 'IO', 'IOT', 1);
INSERT INTO `tbl_v_origin` VALUES(32, 'Brunei Darussalam', 'BN', 'BRN', 1);
INSERT INTO `tbl_v_origin` VALUES(33, 'Bulgaria', 'BG', 'BGR', 1);
INSERT INTO `tbl_v_origin` VALUES(34, 'Burkina Faso', 'BF', 'BFA', 1);
INSERT INTO `tbl_v_origin` VALUES(35, 'Burundi', 'BI', 'BDI', 1);
INSERT INTO `tbl_v_origin` VALUES(36, 'Cambodia', 'KH', 'KHM', 1);
INSERT INTO `tbl_v_origin` VALUES(37, 'Cameroon', 'CM', 'CMR', 1);
INSERT INTO `tbl_v_origin` VALUES(38, 'Canada', 'CA', 'CAN', 1);
INSERT INTO `tbl_v_origin` VALUES(39, 'Cape Verde', 'CV', 'CPV', 1);
INSERT INTO `tbl_v_origin` VALUES(40, 'Cayman Islands', 'KY', 'CYM', 1);
INSERT INTO `tbl_v_origin` VALUES(41, 'Central African Republic', 'CF', 'CAF', 1);
INSERT INTO `tbl_v_origin` VALUES(42, 'Chad', 'TD', 'TCD', 1);
INSERT INTO `tbl_v_origin` VALUES(43, 'Chile', 'CL', 'CHL', 1);
INSERT INTO `tbl_v_origin` VALUES(44, 'China', 'CN', 'CHN', 1);
INSERT INTO `tbl_v_origin` VALUES(45, 'Christmas Island', 'CX', 'CXR', 1);
INSERT INTO `tbl_v_origin` VALUES(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', 1);
INSERT INTO `tbl_v_origin` VALUES(47, 'Colombia', 'CO', 'COL', 1);
INSERT INTO `tbl_v_origin` VALUES(48, 'Comoros', 'KM', 'COM', 1);
INSERT INTO `tbl_v_origin` VALUES(49, 'Congo', 'CG', 'COG', 1);
INSERT INTO `tbl_v_origin` VALUES(50, 'Cook Islands', 'CK', 'COK', 1);
INSERT INTO `tbl_v_origin` VALUES(51, 'Costa Rica', 'CR', 'CRI', 1);
INSERT INTO `tbl_v_origin` VALUES(52, 'Cote D''Ivoire', 'CI', 'CIV', 1);
INSERT INTO `tbl_v_origin` VALUES(53, 'Croatia', 'HR', 'HRV', 1);
INSERT INTO `tbl_v_origin` VALUES(54, 'Cuba', 'CU', 'CUB', 1);
INSERT INTO `tbl_v_origin` VALUES(55, 'Cyprus', 'CY', 'CYP', 1);
INSERT INTO `tbl_v_origin` VALUES(56, 'Czech Republic', 'CZ', 'CZE', 1);
INSERT INTO `tbl_v_origin` VALUES(57, 'Denmark', 'DK', 'DNK', 1);
INSERT INTO `tbl_v_origin` VALUES(58, 'Djibouti', 'DJ', 'DJI', 1);
INSERT INTO `tbl_v_origin` VALUES(59, 'Dominica', 'DM', 'DMA', 1);
INSERT INTO `tbl_v_origin` VALUES(60, 'Dominican Republic', 'DO', 'DOM', 1);
INSERT INTO `tbl_v_origin` VALUES(61, 'East Timor', 'TL', 'TLS', 1);
INSERT INTO `tbl_v_origin` VALUES(62, 'Ecuador', 'EC', 'ECU', 1);
INSERT INTO `tbl_v_origin` VALUES(63, 'Egypt', 'EG', 'EGY', 1);
INSERT INTO `tbl_v_origin` VALUES(64, 'El Salvador', 'SV', 'SLV', 1);
INSERT INTO `tbl_v_origin` VALUES(65, 'Equatorial Guinea', 'GQ', 'GNQ', 1);
INSERT INTO `tbl_v_origin` VALUES(66, 'Eritrea', 'ER', 'ERI', 1);
INSERT INTO `tbl_v_origin` VALUES(67, 'Estonia', 'EE', 'EST', 1);
INSERT INTO `tbl_v_origin` VALUES(68, 'Ethiopia', 'ET', 'ETH', 1);
INSERT INTO `tbl_v_origin` VALUES(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 1);
INSERT INTO `tbl_v_origin` VALUES(70, 'Faroe Islands', 'FO', 'FRO', 1);
INSERT INTO `tbl_v_origin` VALUES(71, 'Fiji', 'FJ', 'FJI', 1);
INSERT INTO `tbl_v_origin` VALUES(72, 'Finland', 'FI', 'FIN', 1);
INSERT INTO `tbl_v_origin` VALUES(74, 'France, Metropolitan', 'FR', 'FRA', 1);
INSERT INTO `tbl_v_origin` VALUES(75, 'French Guiana', 'GF', 'GUF', 1);
INSERT INTO `tbl_v_origin` VALUES(76, 'French Polynesia', 'PF', 'PYF', 1);
INSERT INTO `tbl_v_origin` VALUES(77, 'French Southern Territories', 'TF', 'ATF', 1);
INSERT INTO `tbl_v_origin` VALUES(78, 'Gabon', 'GA', 'GAB', 1);
INSERT INTO `tbl_v_origin` VALUES(79, 'Gambia', 'GM', 'GMB', 1);
INSERT INTO `tbl_v_origin` VALUES(80, 'Georgia', 'GE', 'GEO', 1);
INSERT INTO `tbl_v_origin` VALUES(81, 'Germany', 'DE', 'DEU', 1);
INSERT INTO `tbl_v_origin` VALUES(82, 'Ghana', 'GH', 'GHA', 1);
INSERT INTO `tbl_v_origin` VALUES(83, 'Gibraltar', 'GI', 'GIB', 1);
INSERT INTO `tbl_v_origin` VALUES(84, 'Greece', 'GR', 'GRC', 1);
INSERT INTO `tbl_v_origin` VALUES(85, 'Greenland', 'GL', 'GRL', 1);
INSERT INTO `tbl_v_origin` VALUES(86, 'Grenada', 'GD', 'GRD', 1);
INSERT INTO `tbl_v_origin` VALUES(87, 'Guadeloupe', 'GP', 'GLP', 1);
INSERT INTO `tbl_v_origin` VALUES(88, 'Guam', 'GU', 'GUM', 1);
INSERT INTO `tbl_v_origin` VALUES(89, 'Guatemala', 'GT', 'GTM', 1);
INSERT INTO `tbl_v_origin` VALUES(90, 'Guinea', 'GN', 'GIN', 1);
INSERT INTO `tbl_v_origin` VALUES(91, 'Guinea-Bissau', 'GW', 'GNB', 1);
INSERT INTO `tbl_v_origin` VALUES(92, 'Guyana', 'GY', 'GUY', 1);
INSERT INTO `tbl_v_origin` VALUES(93, 'Haiti', 'HT', 'HTI', 1);
INSERT INTO `tbl_v_origin` VALUES(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 1);
INSERT INTO `tbl_v_origin` VALUES(95, 'Honduras', 'HN', 'HND', 1);
INSERT INTO `tbl_v_origin` VALUES(96, 'Hong Kong', 'HK', 'HKG', 1);
INSERT INTO `tbl_v_origin` VALUES(97, 'Hungary', 'HU', 'HUN', 1);
INSERT INTO `tbl_v_origin` VALUES(98, 'Iceland', 'IS', 'ISL', 1);
INSERT INTO `tbl_v_origin` VALUES(99, 'India', 'IN', 'IND', 1);
INSERT INTO `tbl_v_origin` VALUES(100, 'Indonesia', 'ID', 'IDN', 1);
INSERT INTO `tbl_v_origin` VALUES(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', 1);
INSERT INTO `tbl_v_origin` VALUES(102, 'Iraq', 'IQ', 'IRQ', 1);
INSERT INTO `tbl_v_origin` VALUES(103, 'Ireland', 'IE', 'IRL', 1);
INSERT INTO `tbl_v_origin` VALUES(104, 'Israel', 'IL', 'ISR', 1);
INSERT INTO `tbl_v_origin` VALUES(105, 'Italy', 'IT', 'ITA', 1);
INSERT INTO `tbl_v_origin` VALUES(106, 'Jamaica', 'JM', 'JAM', 1);
INSERT INTO `tbl_v_origin` VALUES(107, 'Japan', 'JP', 'JPN', 1);
INSERT INTO `tbl_v_origin` VALUES(108, 'Jordan', 'JO', 'JOR', 1);
INSERT INTO `tbl_v_origin` VALUES(109, 'Kazakhstan', 'KZ', 'KAZ', 1);
INSERT INTO `tbl_v_origin` VALUES(110, 'Kenya', 'KE', 'KEN', 1);
INSERT INTO `tbl_v_origin` VALUES(111, 'Kiribati', 'KI', 'KIR', 1);
INSERT INTO `tbl_v_origin` VALUES(112, 'North Korea', 'KP', 'PRK', 1);
INSERT INTO `tbl_v_origin` VALUES(113, 'Korea, Republic of', 'KR', 'KOR', 1);
INSERT INTO `tbl_v_origin` VALUES(114, 'Kuwait', 'KW', 'KWT', 1);
INSERT INTO `tbl_v_origin` VALUES(115, 'Kyrgyzstan', 'KG', 'KGZ', 1);
INSERT INTO `tbl_v_origin` VALUES(116, 'Lao People''s Democratic Republic', 'LA', 'LAO', 1);
INSERT INTO `tbl_v_origin` VALUES(117, 'Latvia', 'LV', 'LVA', 1);
INSERT INTO `tbl_v_origin` VALUES(118, 'Lebanon', 'LB', 'LBN', 1);
INSERT INTO `tbl_v_origin` VALUES(119, 'Lesotho', 'LS', 'LSO', 1);
INSERT INTO `tbl_v_origin` VALUES(120, 'Liberia', 'LR', 'LBR', 1);
INSERT INTO `tbl_v_origin` VALUES(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 1);
INSERT INTO `tbl_v_origin` VALUES(122, 'Liechtenstein', 'LI', 'LIE', 1);
INSERT INTO `tbl_v_origin` VALUES(123, 'Lithuania', 'LT', 'LTU', 1);
INSERT INTO `tbl_v_origin` VALUES(124, 'Luxembourg', 'LU', 'LUX', 1);
INSERT INTO `tbl_v_origin` VALUES(125, 'Macau', 'MO', 'MAC', 1);
INSERT INTO `tbl_v_origin` VALUES(126, 'FYROM', 'MK', 'MKD', 1);
INSERT INTO `tbl_v_origin` VALUES(127, 'Madagascar', 'MG', 'MDG', 1);
INSERT INTO `tbl_v_origin` VALUES(128, 'Malawi', 'MW', 'MWI', 1);
INSERT INTO `tbl_v_origin` VALUES(129, 'Malaysia', 'MY', 'MYS', 1);
INSERT INTO `tbl_v_origin` VALUES(130, 'Maldives', 'MV', 'MDV', 1);
INSERT INTO `tbl_v_origin` VALUES(131, 'Mali', 'ML', 'MLI', 1);
INSERT INTO `tbl_v_origin` VALUES(132, 'Malta', 'MT', 'MLT', 1);
INSERT INTO `tbl_v_origin` VALUES(133, 'Marshall Islands', 'MH', 'MHL', 1);
INSERT INTO `tbl_v_origin` VALUES(134, 'Martinique', 'MQ', 'MTQ', 1);
INSERT INTO `tbl_v_origin` VALUES(135, 'Mauritania', 'MR', 'MRT', 1);
INSERT INTO `tbl_v_origin` VALUES(136, 'Mauritius', 'MU', 'MUS', 1);
INSERT INTO `tbl_v_origin` VALUES(137, 'Mayotte', 'YT', 'MYT', 1);
INSERT INTO `tbl_v_origin` VALUES(138, 'Mexico', 'MX', 'MEX', 1);
INSERT INTO `tbl_v_origin` VALUES(139, 'Micronesia, Federated States of', 'FM', 'FSM', 1);
INSERT INTO `tbl_v_origin` VALUES(140, 'Moldova, Republic of', 'MD', 'MDA', 1);
INSERT INTO `tbl_v_origin` VALUES(141, 'Monaco', 'MC', 'MCO', 1);
INSERT INTO `tbl_v_origin` VALUES(142, 'Mongolia', 'MN', 'MNG', 1);
INSERT INTO `tbl_v_origin` VALUES(143, 'Montserrat', 'MS', 'MSR', 1);
INSERT INTO `tbl_v_origin` VALUES(144, 'Morocco', 'MA', 'MAR', 1);
INSERT INTO `tbl_v_origin` VALUES(145, 'Mozambique', 'MZ', 'MOZ', 1);
INSERT INTO `tbl_v_origin` VALUES(146, 'Myanmar', 'MM', 'MMR', 1);
INSERT INTO `tbl_v_origin` VALUES(147, 'Namibia', 'NA', 'NAM', 1);
INSERT INTO `tbl_v_origin` VALUES(148, 'Nauru', 'NR', 'NRU', 1);
INSERT INTO `tbl_v_origin` VALUES(149, 'Nepal', 'NP', 'NPL', 1);
INSERT INTO `tbl_v_origin` VALUES(150, 'Netherlands', 'NL', 'NLD', 1);
INSERT INTO `tbl_v_origin` VALUES(151, 'Netherlands Antilles', 'AN', 'ANT', 1);
INSERT INTO `tbl_v_origin` VALUES(152, 'New Caledonia', 'NC', 'NCL', 1);
INSERT INTO `tbl_v_origin` VALUES(153, 'New Zealand', 'NZ', 'NZL', 1);
INSERT INTO `tbl_v_origin` VALUES(154, 'Nicaragua', 'NI', 'NIC', 1);
INSERT INTO `tbl_v_origin` VALUES(155, 'Niger', 'NE', 'NER', 1);
INSERT INTO `tbl_v_origin` VALUES(156, 'Nigeria', 'NG', 'NGA', 1);
INSERT INTO `tbl_v_origin` VALUES(157, 'Niue', 'NU', 'NIU', 1);
INSERT INTO `tbl_v_origin` VALUES(158, 'Norfolk Island', 'NF', 'NFK', 1);
INSERT INTO `tbl_v_origin` VALUES(159, 'Northern Mariana Islands', 'MP', 'MNP', 1);
INSERT INTO `tbl_v_origin` VALUES(160, 'Norway', 'NO', 'NOR', 1);
INSERT INTO `tbl_v_origin` VALUES(161, 'Oman', 'OM', 'OMN', 1);
INSERT INTO `tbl_v_origin` VALUES(162, 'Pakistan', 'PK', 'PAK', 1);
INSERT INTO `tbl_v_origin` VALUES(163, 'Palau', 'PW', 'PLW', 1);
INSERT INTO `tbl_v_origin` VALUES(164, 'Panama', 'PA', 'PAN', 1);
INSERT INTO `tbl_v_origin` VALUES(165, 'Papua New Guinea', 'PG', 'PNG', 1);
INSERT INTO `tbl_v_origin` VALUES(166, 'Paraguay', 'PY', 'PRY', 1);
INSERT INTO `tbl_v_origin` VALUES(167, 'Peru', 'PE', 'PER', 1);
INSERT INTO `tbl_v_origin` VALUES(168, 'Philippines', 'PH', 'PHL', 1);
INSERT INTO `tbl_v_origin` VALUES(169, 'Pitcairn', 'PN', 'PCN', 1);
INSERT INTO `tbl_v_origin` VALUES(170, 'Poland', 'PL', 'POL', 1);
INSERT INTO `tbl_v_origin` VALUES(171, 'Portugal', 'PT', 'PRT', 1);
INSERT INTO `tbl_v_origin` VALUES(172, 'Puerto Rico', 'PR', 'PRI', 1);
INSERT INTO `tbl_v_origin` VALUES(173, 'Qatar', 'QA', 'QAT', 1);
INSERT INTO `tbl_v_origin` VALUES(174, 'Reunion', 'RE', 'REU', 1);
INSERT INTO `tbl_v_origin` VALUES(175, 'Romania', 'RO', 'ROM', 1);
INSERT INTO `tbl_v_origin` VALUES(176, 'Russian Federation', 'RU', 'RUS', 1);
INSERT INTO `tbl_v_origin` VALUES(177, 'Rwanda', 'RW', 'RWA', 1);
INSERT INTO `tbl_v_origin` VALUES(178, 'Saint Kitts and Nevis', 'KN', 'KNA', 1);
INSERT INTO `tbl_v_origin` VALUES(179, 'Saint Lucia', 'LC', 'LCA', 1);
INSERT INTO `tbl_v_origin` VALUES(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 1);
INSERT INTO `tbl_v_origin` VALUES(181, 'Samoa', 'WS', 'WSM', 1);
INSERT INTO `tbl_v_origin` VALUES(182, 'San Marino', 'SM', 'SMR', 1);
INSERT INTO `tbl_v_origin` VALUES(183, 'Sao Tome and Principe', 'ST', 'STP', 1);
INSERT INTO `tbl_v_origin` VALUES(184, 'Saudi Arabia', 'SA', 'SAU', 1);
INSERT INTO `tbl_v_origin` VALUES(185, 'Senegal', 'SN', 'SEN', 1);
INSERT INTO `tbl_v_origin` VALUES(186, 'Seychelles', 'SC', 'SYC', 1);
INSERT INTO `tbl_v_origin` VALUES(187, 'Sierra Leone', 'SL', 'SLE', 1);
INSERT INTO `tbl_v_origin` VALUES(188, 'Singapore', 'SG', 'SGP', 1);
INSERT INTO `tbl_v_origin` VALUES(189, 'Slovak Republic', 'SK', 'SVK', 1);
INSERT INTO `tbl_v_origin` VALUES(190, 'Slovenia', 'SI', 'SVN', 1);
INSERT INTO `tbl_v_origin` VALUES(191, 'Solomon Islands', 'SB', 'SLB', 1);
INSERT INTO `tbl_v_origin` VALUES(192, 'Somalia', 'SO', 'SOM', 1);
INSERT INTO `tbl_v_origin` VALUES(193, 'South Africa', 'ZA', 'ZAF', 1);
INSERT INTO `tbl_v_origin` VALUES(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', 1);
INSERT INTO `tbl_v_origin` VALUES(195, 'Spain', 'ES', 'ESP', 1);
INSERT INTO `tbl_v_origin` VALUES(196, 'Sri Lanka', 'LK', 'LKA', 1);
INSERT INTO `tbl_v_origin` VALUES(197, 'St. Helena', 'SH', 'SHN', 1);
INSERT INTO `tbl_v_origin` VALUES(198, 'St. Pierre and Miquelon', 'PM', 'SPM', 1);
INSERT INTO `tbl_v_origin` VALUES(199, 'Sudan', 'SD', 'SDN', 1);
INSERT INTO `tbl_v_origin` VALUES(200, 'Suriname', 'SR', 'SUR', 1);
INSERT INTO `tbl_v_origin` VALUES(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', 1);
INSERT INTO `tbl_v_origin` VALUES(202, 'Swaziland', 'SZ', 'SWZ', 1);
INSERT INTO `tbl_v_origin` VALUES(203, 'Sweden', 'SE', 'SWE', 1);
INSERT INTO `tbl_v_origin` VALUES(204, 'Switzerland', 'CH', 'CHE', 1);
INSERT INTO `tbl_v_origin` VALUES(205, 'Syrian Arab Republic', 'SY', 'SYR', 1);
INSERT INTO `tbl_v_origin` VALUES(206, 'Taiwan', 'TW', 'TWN', 1);
INSERT INTO `tbl_v_origin` VALUES(207, 'Tajikistan', 'TJ', 'TJK', 1);
INSERT INTO `tbl_v_origin` VALUES(208, 'Tanzania, United Republic of', 'TZ', 'TZA', 1);
INSERT INTO `tbl_v_origin` VALUES(209, 'Thailand', 'TH', 'THA', 1);
INSERT INTO `tbl_v_origin` VALUES(210, 'Togo', 'TG', 'TGO', 1);
INSERT INTO `tbl_v_origin` VALUES(211, 'Tokelau', 'TK', 'TKL', 1);
INSERT INTO `tbl_v_origin` VALUES(212, 'Tonga', 'TO', 'TON', 1);
INSERT INTO `tbl_v_origin` VALUES(213, 'Trinidad and Tobago', 'TT', 'TTO', 1);
INSERT INTO `tbl_v_origin` VALUES(214, 'Tunisia', 'TN', 'TUN', 1);
INSERT INTO `tbl_v_origin` VALUES(215, 'Turkey', 'TR', 'TUR', 1);
INSERT INTO `tbl_v_origin` VALUES(216, 'Turkmenistan', 'TM', 'TKM', 1);
INSERT INTO `tbl_v_origin` VALUES(217, 'Turks and Caicos Islands', 'TC', 'TCA', 1);
INSERT INTO `tbl_v_origin` VALUES(218, 'Tuvalu', 'TV', 'TUV', 1);
INSERT INTO `tbl_v_origin` VALUES(219, 'Uganda', 'UG', 'UGA', 1);
INSERT INTO `tbl_v_origin` VALUES(220, 'Ukraine', 'UA', 'UKR', 1);
INSERT INTO `tbl_v_origin` VALUES(221, 'United Arab Emirates', 'AE', 'ARE', 1);
INSERT INTO `tbl_v_origin` VALUES(222, 'United Kingdom', 'GB', 'GBR', 1);
INSERT INTO `tbl_v_origin` VALUES(223, 'United States', 'US', 'USA', 1);
INSERT INTO `tbl_v_origin` VALUES(224, 'United States Minor Outlying Islands', 'UM', 'UMI', 1);
INSERT INTO `tbl_v_origin` VALUES(225, 'Uruguay', 'UY', 'URY', 1);
INSERT INTO `tbl_v_origin` VALUES(226, 'Uzbekistan', 'UZ', 'UZB', 1);
INSERT INTO `tbl_v_origin` VALUES(227, 'Vanuatu', 'VU', 'VUT', 1);
INSERT INTO `tbl_v_origin` VALUES(228, 'Vatican City State (Holy See)', 'VA', 'VAT', 1);
INSERT INTO `tbl_v_origin` VALUES(229, 'Venezuela', 'VE', 'VEN', 1);
INSERT INTO `tbl_v_origin` VALUES(230, 'Viet Nam', 'VN', 'VNM', 1);
INSERT INTO `tbl_v_origin` VALUES(231, 'Virgin Islands (British)', 'VG', 'VGB', 1);
INSERT INTO `tbl_v_origin` VALUES(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', 1);
INSERT INTO `tbl_v_origin` VALUES(233, 'Wallis and Futuna Islands', 'WF', 'WLF', 1);
INSERT INTO `tbl_v_origin` VALUES(234, 'Western Sahara', 'EH', 'ESH', 1);
INSERT INTO `tbl_v_origin` VALUES(235, 'Yemen', 'YE', 'YEM', 1);
INSERT INTO `tbl_v_origin` VALUES(237, 'Democratic Republic of Congo', 'CD', 'COD', 1);
INSERT INTO `tbl_v_origin` VALUES(238, 'Zambia', 'ZM', 'ZMB', 1);
INSERT INTO `tbl_v_origin` VALUES(239, 'Zimbabwe', 'ZW', 'ZWE', 1);
INSERT INTO `tbl_v_origin` VALUES(240, 'Jersey', 'JE', 'JEY', 1);
INSERT INTO `tbl_v_origin` VALUES(241, 'Guernsey', 'GG', 'GGY', 1);
INSERT INTO `tbl_v_origin` VALUES(242, 'Montenegro', 'ME', 'MNE', 1);
INSERT INTO `tbl_v_origin` VALUES(243, 'Serbia', 'RS', 'SRB', 1);
INSERT INTO `tbl_v_origin` VALUES(244, 'Aaland Islands', 'AX', 'ALA', 1);
INSERT INTO `tbl_v_origin` VALUES(245, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', 1);
INSERT INTO `tbl_v_origin` VALUES(246, 'Curacao', 'CW', 'CUW', 1);
INSERT INTO `tbl_v_origin` VALUES(247, 'Palestinian Territory, Occupied', 'PS', 'PSE', 1);
INSERT INTO `tbl_v_origin` VALUES(248, 'South Sudan', 'SS', 'SSD', 1);
INSERT INTO `tbl_v_origin` VALUES(249, 'St. Barthelemy', 'BL', 'BLM', 1);
INSERT INTO `tbl_v_origin` VALUES(250, 'St. Martin (French part)', 'MF', 'MAF', 1);
INSERT INTO `tbl_v_origin` VALUES(251, 'Canary Islands', 'IC', 'ICA', 1);
