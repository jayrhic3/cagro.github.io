-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2020 at 06:11 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cagro`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_assistant` (OUT `service_id` VARCHAR(255), IN `bene_id` VARCHAR(255), IN `ser_ren` VARCHAR(255), IN `created_at` DATETIME, IN `word_created` VARCHAR(50), IN `request_id` VARCHAR(100), IN `other` VARCHAR(50))  NO SQL
BEGIN

	set service_id=(select concat("S",right(year(now()),1), hour(now()),  second(now()), minute(now()), Week(now()), Weekday(now()),day(now()),  left(dayname(now()),2),char(floor(65.5+(rand()*25)))));
	
INSERT INTO record_assistance_beneficiary(service_id,beneficiary_id,assistanced_received,status,created_at,word_created,other) VALUES(service_id,bene_id,ser_ren,"On Going",created_at,word_created,other);

IF ser_ren="Agri Supplies" THEN

INSERT INTO beneficiries_agri_supplies(service_id,beneficiary_id,status,created_at,word_created) VALUES(service_id,bene_id,"On Going",created_at,word_created);

ELSEIF ser_ren="Technical Assistance" THEN

INSERT INTO beneficiries_Technical_support(service_id,beneficiary_id,status,created_at,word_created) VALUES(service_id,bene_id,"On Going",created_at,word_created);

ELSEIF ser_ren="Farm Mechanization" THEN  

INSERT INTO beneficiries_Farm_mechanization(service_id,beneficiary_id,status,created_at,word_created) VALUES(service_id,bene_id,"On Going",created_at,word_created);

    
END IF;

INSERT INTO beneficiary_history(beneficiary_id,description) VALUES(bene_id,concat("Acquired assistant of ",ser_ren));

INSERT INTO recent_request(service_id,request_id,beneficiary_id,assistance_recieved,status,created_at,word_created,other) VALUES(service_id,request_id,bene_id,ser_ren,"On Going",created_at,word_created,other);



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_products` (IN `beneficiary_id` VARCHAR(200), IN `request_id` VARCHAR(200), IN `word_created` VARCHAR(200), IN `created_at` DATETIME, OUT `unique_id` VARCHAR(200), IN `quantity` INT(10), IN `product_id` INT(10))  NO SQL
BEGIN

set unique_id=(select concat("S",right(year(now()),1), hour(now()),  second(now()), minute(now()), Week(now()), Weekday(now()),day(now()),  left(dayname(now()),2),char(floor(65.5+(rand()*25)))));

INSERT INTO beneficiary_record_product (beneficiary_id,request_id,unique_id,created_at,word_created,product_id,quantity,status) VALUES(beneficiary_id,request_id,unique_id,created_at,word_created,product_id,quantity,'On Going');




END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_services` (OUT `service_id` VARCHAR(255), IN `beneficiary_id` VARCHAR(250), IN `services_recieved` VARCHAR(50), IN `created_at` DATETIME, IN `word_created` VARCHAR(50), IN `request_id` VARCHAR(100), IN `ser_id` VARCHAR(50))  NO SQL
BEGIN

	set service_id=(select concat("S",right(year(now()),1), hour(now()),  second(now()), minute(now()), Week(now()), Weekday(now()),day(now()),  left(dayname(now()),2),char(floor(65.5+(rand()*25)))));
	
INSERT INTO record_services_beneficiary (service_id,request_id,beneficiary_id,services_received,status,created_at,word_created,ser_id) VALUES(service_id,request_id,beneficiary_id,services_recieved,"On Going",created_at,word_created,ser_id);



INSERT INTO beneficiary_history(beneficiary_id,description) VALUES(beneficiary_id,concat("Acquired services of ",services_recieved));

INSERT INTO request_services(service_id,request_id,beneficiary_id,service_recieved,status,created_at,word_created,ser_id) VALUES(service_id,request_id,beneficiary_id,services_recieved,"On Going",created_at,word_created,ser_id);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `beneficiary_data` (OUT `id_b` VARCHAR(255), IN `lastname_i` VARCHAR(50), IN `firstname_i` VARCHAR(50), IN `middlename_i` VARCHAR(50), IN `purok` VARCHAR(50), IN `barangay` VARCHAR(50), IN `mobile` VARCHAR(50), IN `beneficiary_type` VARCHAR(10), IN `municipality` VARCHAR(50), IN `gender` VARCHAR(50), IN `bday` DATE, IN `province` VARCHAR(50), IN `personnel` VARCHAR(50), IN `created_at` VARCHAR(50), IN `word_created` VARCHAR(50), IN `other_id` VARCHAR(100), IN `pag_ibig` VARCHAR(100), IN `phil` VARCHAR(100))  NO SQL
BEGIN

	set id_b=(select concat("S",right(year(now()),1), hour(now()),  second(now()), minute(now()), Week(now()), Weekday(now()),day(now()),  left(dayname(now()),1),"_","CAGRO" ));
	
    INSERT INTO beneficiaries(id,lastname,firstname,middlename,purok,barangay,mobnum,beneficiary_type,
                              mucipality,gender,bday,province,personnel,other_id,pag_ibig,phil,created_at,word_created) VALUE(id_b,lastname_i,firstname_i,middlename_i,purok,barangay,mobile,
                                                beneficiary_type,municipality,gender,bday,province,personnel,other_id,pag_ibig,phil,created_at,word_created);
                                               
    

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `assistance`
--

CREATE TABLE `assistance` (
  `id` int(11) NOT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assistance`
--

INSERT INTO `assistance` (`id`, `description`) VALUES
(1, 'Agri Supplies'),
(2, 'Technical Assistance'),
(3, 'Farm Mechanization'),
(7, 'wala');

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `id` int(11) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`id`, `description`) VALUES
(10, 'Apokon'),
(10, 'Bincungan'),
(10, 'Busaon'),
(10, 'Canocotan'),
(10, 'Cuambogan'),
(10, 'Filipina'),
(10, 'Liboganon'),
(10, 'Madaum'),
(10, 'Magdum'),
(10, 'Magugpo Poblacion'),
(10, 'Magugpo East'),
(10, 'Magugpo North'),
(10, 'Magugpo South'),
(10, 'Magugpo West'),
(10, 'Mankilam'),
(10, 'New Balamban'),
(10, 'Nueva Fuerza'),
(10, 'Pagsambangan'),
(10, 'Pandapan'),
(10, 'Agustin'),
(10, 'San Isidro'),
(10, 'Miguel'),
(10, 'Visayan Village'),
(1, 'Binancian'),
(1, 'Buan'),
(1, 'Buclad'),
(1, 'Cabaywa'),
(1, 'Camansa'),
(1, 'Camoning'),
(1, 'Canatan'),
(1, 'Conception'),
(1, 'Donya Andrea'),
(1, 'Magatos'),
(1, 'Napungas'),
(1, 'New Bantayan'),
(1, 'New Santiago'),
(1, 'Pamacaun'),
(1, 'Cambanogoy'),
(1, 'Sagayen'),
(1, 'San Vicente'),
(1, 'Santa Felomena'),
(1, 'Sonlon'),
(1, 'New Loon'),
(2, 'Cabay-angan'),
(2, 'Dujali'),
(2, 'Magupising'),
(2, 'New Casay'),
(2, 'Tanglaw'),
(3, 'Alejal'),
(3, 'Anibongan'),
(3, 'Asuncion'),
(3, 'Cebulano'),
(3, 'Guadalope'),
(3, 'Ising'),
(3, 'La Paz'),
(3, 'Mabaus'),
(3, 'Mabuhay'),
(3, 'Magsaysay'),
(3, 'Mangalcal'),
(3, 'Minda'),
(3, 'New Camiling'),
(3, 'Salvacion'),
(3, 'San Isidro'),
(3, 'Santo Nino'),
(3, 'Taba'),
(3, 'Tibulao'),
(3, 'Tubod'),
(3, 'Tuganay'),
(4, 'Semong'),
(4, 'Florida'),
(4, 'Gabuyan'),
(4, 'Gupitan'),
(4, 'Capungagan'),
(4, 'Katipunan'),
(4, 'Luna'),
(4, 'Mabantao'),
(4, 'Mamacao'),
(4, 'Pag-asa'),
(4, 'Maniki'),
(4, 'Sampao'),
(4, 'Sua-on'),
(4, 'Tiburcia'),
(5, 'Cabidianan'),
(5, 'Carcor'),
(5, 'Del Monte'),
(5, 'Del Pilar'),
(5, 'El Salvador'),
(5, 'Limba-an'),
(5, 'Macgum'),
(5, 'Mambing'),
(5, 'Mesaoy'),
(5, 'New Bohol'),
(5, 'New Cortez'),
(5, 'New Sambog'),
(5, 'Patrocenio'),
(5, 'Poblacion'),
(5, 'San Roque'),
(5, 'Santa Cruz'),
(5, 'Santa Fe'),
(5, 'Santo Nino'),
(5, 'Suawon'),
(5, 'San Jose'),
(6, 'A.O Florendo'),
(6, 'Buenavista'),
(6, 'Cacao'),
(6, 'Cagangohan'),
(6, 'Consolacion'),
(6, 'Dapco'),
(6, 'Datu Abdul Dabia'),
(6, 'Gredu'),
(6, 'J.P Laurel'),
(6, 'Kasilak'),
(6, 'Katipunan'),
(6, 'Kataulan'),
(6, 'Kauswagan'),
(6, 'Kiotoy'),
(6, 'Little Panay'),
(6, 'Lower Panaga'),
(6, 'Mabunao'),
(6, 'Maduao'),
(6, 'Malativas'),
(6, 'Manay'),
(6, 'Nanyo'),
(6, 'New Malaga'),
(6, 'New Malitbog'),
(6, 'New Pandan'),
(6, 'New Visayas'),
(6, 'Quezon'),
(6, 'Salvacion'),
(6, 'San Francisco'),
(6, 'San Nicholas'),
(6, 'San Pedro'),
(6, 'San Roque'),
(6, 'San Vicente'),
(6, 'Santa Cruz'),
(6, 'Santo Ninyo'),
(6, 'Sindaton'),
(6, 'Southern Davao'),
(6, 'Tagpore'),
(6, 'Tibungol'),
(6, 'Upper Licanan'),
(6, 'Waterfall'),
(7, 'Adecor'),
(7, 'Anonang'),
(7, 'Alumbay'),
(7, 'Aundanao'),
(7, 'Balet'),
(7, 'Bandera'),
(7, 'Caliclic'),
(7, 'Camudmud'),
(7, 'Catagman'),
(7, 'Cawag'),
(7, 'Cogon'),
(7, 'Dadatan'),
(7, 'Del Monte'),
(7, 'Guilon'),
(7, 'Kanaan'),
(7, 'Kinawitnon'),
(7, 'Libertad'),
(7, 'Libuak'),
(7, 'Licup'),
(7, 'Limao'),
(7, 'Linosutan'),
(7, 'Mambago'),
(7, 'Miranda'),
(7, 'Moncado'),
(7, 'Pangubatan'),
(7, 'Penyaplata'),
(7, 'Poblacion'),
(7, 'San Agustin'),
(7, 'San Antonio'),
(7, 'San Isidro'),
(7, 'San Jose'),
(7, 'San Miguel'),
(7, 'San Remigio'),
(7, 'Santa Cruz'),
(7, 'Santo Nino'),
(7, 'Sion'),
(7, 'Tagbaobo'),
(7, 'Tagbay'),
(7, 'Tagbitan-ag'),
(7, 'Tagdaliao'),
(8, 'Dacudao'),
(8, 'Datu Balong'),
(8, 'Igangon'),
(8, 'Kipalili'),
(8, 'Libutan'),
(8, 'Linao'),
(8, 'Mamangan'),
(8, 'Monte Dujali'),
(8, 'Pinamuno'),
(8, 'Sabangan'),
(8, 'San Miguel'),
(8, 'Santo Nino'),
(8, 'Sawata'),
(9, 'Balagunan'),
(9, 'Bobongon'),
(9, 'Casig-Ang'),
(9, 'Esperanza'),
(9, 'Kimamon'),
(9, 'Kinamayan'),
(9, 'La Libertad'),
(9, 'Lungag'),
(9, 'Mangwawa'),
(9, 'New Katipunan'),
(9, 'New Visayas'),
(9, 'Pantaron'),
(9, 'Salvacion'),
(9, 'San Jose'),
(9, 'San Miguel'),
(9, 'San Vicente'),
(9, 'Talomo'),
(9, 'Tibal-og'),
(9, 'Tulalian'),
(11, 'Dagohoy'),
(11, 'Palma Gil'),
(11, 'Santo Nino'),
(12, 'Bagongon'),
(12, 'Gabi'),
(12, 'Lagab'),
(12, 'Mangayon'),
(12, 'Mapaca'),
(12, 'Maparat'),
(12, 'New Alegria'),
(12, 'Ngan'),
(13, 'Aguinaldo'),
(13, 'Amorcruz'),
(13, 'Ampawid'),
(13, 'Andap'),
(13, 'Anitap'),
(13, 'Bagong Silang'),
(13, 'Banbanon'),
(13, 'Belmonte'),
(13, 'Binasbas'),
(13, 'Bullucan'),
(13, 'Ceboleda'),
(13, 'Concepcion'),
(13, 'Datu Ampunan'),
(13, 'Datu Davao'),
(13, 'Do?a Josefa'),
(13, 'El Katipunan'),
(13, 'Il Papa'),
(13, 'Imelda'),
(13, 'Inakayan'),
(13, 'Kaligutan'),
(13, 'Kapatagan'),
(13, 'Kidawa'),
(14, 'Cadunan'),
(14, 'Pindasan'),
(14, 'Cuambog (poblacion)'),
(14, 'Tagnanan (Mampising)'),
(14, 'Anitapan'),
(14, 'Cabuyuan'),
(14, 'Del Pilar'),
(14, 'Libodon'),
(14, 'Golden Valley (Maraut)'),
(14, 'Pangibiran'),
(14, 'San Antonio'),
(15, 'Anibongan'),
(15, 'Anislagan'),
(15, 'Binuangan'),
(15, 'Bucana'),
(15, 'Calabcab'),
(15, 'Concepcion'),
(15, 'Dumlan'),
(15, 'Elizalde (Somil)'),
(15, 'Pangi (Gaudencio Antonio)'),
(15, 'Gubatan'),
(15, 'Hijo'),
(15, 'Kinuban'),
(15, 'Langgam'),
(15, 'Lapu-lapu'),
(15, 'Libay-libay'),
(15, 'Limbo'),
(15, 'Lumatab'),
(15, 'Magangit'),
(15, 'Malamodao'),
(15, 'Manipongol'),
(15, 'Mapaang'),
(15, 'Masara'),
(15, 'New Asturias'),
(15, 'Panibasan'),
(15, 'Panoraon'),
(16, 'Bagong Silang'),
(16, 'Mapawa'),
(16, 'Maragusan'),
(16, 'New Albay'),
(16, 'Tupaz'),
(16, 'Bahi'),
(16, 'Cambagang'),
(16, 'Coronobe'),
(16, 'Katipunan'),
(16, 'Lahi'),
(16, 'Langgawisan'),
(16, 'Mabugnao'),
(16, 'Magcagong'),
(16, 'Mahayahay'),
(16, 'Mauswagon'),
(16, 'New Katipunan'),
(16, 'New Manay'),
(16, 'New Panay'),
(16, 'Paloc'),
(16, 'Pamintaran'),
(16, 'Parasanon'),
(16, 'Talian'),
(16, 'Tandik'),
(16, 'Tigbao'),
(16, 'Panoraon'),
(17, 'Bagong Silang'),
(17, 'Mapawa'),
(17, 'Maragusan'),
(17, 'New Albay'),
(17, 'Tupaz'),
(17, 'Bahi'),
(17, 'Cambagang'),
(17, 'Coronobe'),
(17, 'Katipunan'),
(17, 'Lahi'),
(17, 'Langgawisan'),
(18, 'Awao'),
(18, 'Babag'),
(18, 'Banlag'),
(18, 'Baylo'),
(18, 'Casoon'),
(18, 'Inambatan'),
(18, 'Haguimitan'),
(18, 'Macopa'),
(18, 'Mamunga'),
(18, 'Mount Diwata (Mt. Diwalwal)'),
(18, 'Naboc'),
(18, 'Olaycon'),
(18, 'Pasian (Santa Filomena)'),
(18, 'Poblacion'),
(18, 'Rizal'),
(18, 'Salvacion'),
(18, 'San Isidro'),
(18, 'San Jose'),
(18, 'Tubo-tubo (New Del Monte)'),
(18, 'Upper Ulip'),
(18, 'Union'),
(19, 'Banagbanag'),
(19, 'Banglasan'),
(19, 'Bankerohan Norte'),
(19, 'Bankerohan Sur'),
(19, 'Camansi'),
(19, 'Camantangan'),
(19, 'Concepcion'),
(19, 'Dauman'),
(19, 'Canidkid'),
(19, 'Lebanon'),
(19, 'Linoan'),
(19, 'Mayaon'),
(19, 'New Calape'),
(19, 'New Dalaguete'),
(19, 'New Cebulan (Sambayon)'),
(19, 'New Visayas'),
(19, 'Prosperidad'),
(19, 'San Jose (Poblacion)'),
(19, 'San Vicente'),
(19, 'Tapia'),
(20, 'Anislagan'),
(20, 'Antequera'),
(20, 'Basak'),
(20, 'Bayabas'),
(20, 'Bukal'),
(20, 'Cabacungan'),
(20, 'Cabidianan'),
(20, 'Katipunan'),
(20, 'Libasan'),
(20, 'Linda'),
(20, 'Magading'),
(20, 'Magsaysay'),
(20, 'Mainit'),
(20, 'Manat'),
(20, 'Matilo'),
(20, 'Mipangi'),
(20, 'New Dauis'),
(20, 'New Sibonga'),
(20, 'Ogao'),
(20, 'Pangutosan'),
(20, 'Poblacion'),
(20, 'San Isidro'),
(20, 'San Roque'),
(20, 'San Vicente'),
(20, 'Santa Maria'),
(20, 'Santo Ni?o (Kao)'),
(20, 'Sasa'),
(20, 'Tagnocon'),
(20, 'Anislagan'),
(20, 'Antequera'),
(20, 'Basak'),
(20, 'Bayabas'),
(20, 'Bukal'),
(20, 'Cabacungan'),
(21, 'Andap'),
(21, 'Bantacan'),
(21, 'Batinao'),
(21, 'Cabinuangan (Poblacion)'),
(21, 'Camanlangan'),
(21, 'Cogonon'),
(21, 'Fatima'),
(21, 'Kahayag'),
(21, 'Katipunan'),
(21, 'Magangit'),
(21, 'Magsaysay'),
(21, 'Manurigao'),
(21, 'Pagsabangan'),
(21, 'Panag'),
(21, 'San Roque'),
(21, 'Tandawan'),
(20, 'Anislagan'),
(20, 'Antequera'),
(20, 'Basak'),
(20, 'Bayabas'),
(20, 'Bukal'),
(20, 'Cabacungan'),
(22, 'Bongabong'),
(22, 'Bongbong'),
(22, 'P. Fuentes'),
(22, 'Kingking (Poblacion)'),
(22, 'Magnaga'),
(22, 'Matiao'),
(22, 'Napnapan'),
(22, 'Tagdangua'),
(22, 'Tambongon'),
(22, 'Tibagon'),
(22, 'Las Arenas'),
(22, 'Araibo'),
(22, 'Tagugpo');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `id` varchar(255) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `purok` varchar(50) DEFAULT NULL,
  `barangay` varchar(50) NOT NULL,
  `mobnum` varchar(50) DEFAULT NULL,
  `beneficiary_type` varchar(255) DEFAULT NULL,
  `mucipality` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `bday` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `personnel` varchar(50) DEFAULT NULL,
  `other_id` varchar(100) NOT NULL,
  `pag_ibig` varchar(100) NOT NULL,
  `phil` varchar(100) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `word_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beneficiaries`
--

INSERT INTO `beneficiaries` (`id`, `lastname`, `firstname`, `middlename`, `purok`, `barangay`, `mobnum`, `beneficiary_type`, `mucipality`, `gender`, `bday`, `province`, `personnel`, `other_id`, `pag_ibig`, `phil`, `created_at`, `word_created`) VALUES
('S0151912054S_CAGRO', 'Paypa', 'Leonhail', 'L', 'marang', 'Magnaga', '09106241482', 'student', 'Pantukan', 'Male', '2020-01-08', 'Compostela Valley', 'James Bond', '', '', '', '08:12:19 am 01/04/2020', 'January 4, 2020'),
('S01652528024M_CAGRO', 'davad', 'manilyn', 'A', 'marang', 'Bagongon', '09106241482', 'student', 'Compostela', 'Female', '2020-02-01', 'Compostela Valley', 'Riza Tanong', '', '', '', '09:52:52 am 02/24/2020', 'February 24, 2020'),
('S0730382114T_CAGRO', 'Jaymark', 'Novabos', 'M', 'Bato', 'San Miguel', '09106241482', 'student', 'Samal', 'Male', '2020-01-03', 'Davao del Norte', 'James Bond', '234216767d', '', '', '12:38:30 am 01/14/2020', 'January 14, 2020');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_history`
--

CREATE TABLE `beneficiary_history` (
  `id` int(11) NOT NULL,
  `beneficiary_id` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beneficiary_history`
--

INSERT INTO `beneficiary_history` (`id`, `beneficiary_id`, `description`, `created_at`) VALUES
(430, 'S910244451622S_CAGRO', 'Acquired assistant of Farm Mechanization', '2019-12-23 11:58:46'),
(431, 'S910244451622S_CAGRO', 'Acquired assistant of Farm Mechanization', '2019-12-23 15:17:26'),
(432, 'S910244451622S_CAGRO', 'Acquired assistant of Farm Mechanization', '2019-12-23 15:24:24'),
(433, 'S910244451622S_CAGRO', 'Acquired assistant of Farm Mechanization', '2019-12-25 21:09:41'),
(434, 'S91013151622S_CAGRO', 'Acquired assistant of Farm Mechanization', '2019-12-27 10:48:47'),
(435, 'S910244451622S_CAGRO', 'Acquired assistant of Farm Mechanization', '2019-12-27 10:50:49'),
(436, 'S910244451622S_CAGRO', 'Acquired assistant of Farm Mechanization', '2019-12-28 12:15:37'),
(437, 'S910244451622S_CAGRO', 'Acquired assistant of Agri Supplies', '2020-01-04 13:54:46'),
(438, 'S910244451622S_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-01-04 13:59:47'),
(439, 'S910244451622S_CAGRO', 'Acquired services of Fruit_Trees_Seedlings', '2020-01-04 13:59:47'),
(440, 'S0151912054S_CAGRO', 'Acquired assistant of Agri Supplies', '2020-01-04 15:12:26'),
(441, 'S0151912054S_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-01-04 15:12:42'),
(442, 'S0151912054S_CAGRO', 'Acquired assistant of Agri Supplies', '2020-01-04 15:17:15'),
(443, 'S0151912054S_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-01-04 15:17:35'),
(444, 'S0151912054S_CAGRO', 'Acquired services of Fruit_Trees_Seedlings', '2020-01-04 15:17:35'),
(445, 'S0151912054S_CAGRO', 'Acquired assistant of Agri Supplies', '2020-01-07 07:43:33'),
(446, 'S0151912054S_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-01-07 07:44:07'),
(447, 'S0151912054S_CAGRO', 'Acquired services of Fruit_Trees_Seedlings', '2020-01-07 07:44:07'),
(448, 'S0151912054S_CAGRO', 'Acquired assistant of Agri Supplies', '2020-01-07 08:05:05'),
(449, 'S0151912054S_CAGRO', 'Acquired assistant of Technical Assistance', '2020-01-07 08:05:05'),
(450, 'S0151912054S_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-01-07 08:05:35'),
(451, 'S0151912054S_CAGRO', 'Acquired assistant of Agri Supplies', '2020-01-07 08:23:34'),
(452, 'S0151912054S_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-01-07 08:23:48'),
(453, 'S0151912054S_CAGRO', 'Acquired assistant of Agri Supplies', '2020-01-07 08:27:39'),
(454, 'S0151912054S_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-01-07 08:27:55'),
(455, 'S0730382114T_CAGRO', 'Acquired assistant of Farm Mechanization', '2020-01-20 18:15:06'),
(456, 'S0151912054S_CAGRO', 'Acquired assistant of Agri Supplies', '2020-01-27 13:04:49'),
(457, 'S0730382114T_CAGRO', 'Acquired assistant of Technical Assistance', '2020-02-04 09:55:03'),
(458, 'S0730382114T_CAGRO', 'Acquired assistant of Farm Mechanization', '2020-02-04 09:55:03'),
(459, 'S0151912054S_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-02-04 11:43:12'),
(460, 'S0151912054S_CAGRO', 'Acquired services of Fruit_Trees_Seedlings', '2020-02-04 11:43:12'),
(461, 'S0151912054S_CAGRO', 'Acquired services of Organic/Vermicast', '2020-02-10 10:52:30'),
(462, 'S0730382114T_CAGRO', 'Acquired assistant of Agri Supplies', '2020-02-12 15:16:54'),
(463, 'S0730382114T_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-02-12 16:06:05'),
(464, 'S0730382114T_CAGRO', 'Acquired services of Fruit_Trees_Seedlings', '2020-02-12 16:06:05'),
(465, 'S0730382114T_CAGRO', 'Acquired services of Organic/Vermicast', '2020-02-12 16:06:05'),
(466, 'S0730382114T_CAGRO', 'Acquired services of Fertilizers', '2020-02-12 16:06:05'),
(467, 'S0730382114T_CAGRO', 'Acquired services of Corn_Seeds', '2020-02-12 16:06:05'),
(468, 'S0730382114T_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-02-12 16:27:13'),
(469, 'S0730382114T_CAGRO', 'Acquired services of Fruit_Trees_Seedlings', '2020-02-12 16:27:13'),
(470, 'S0730382114T_CAGRO', 'Acquired services of Organic/Vermicast', '2020-02-12 16:27:13'),
(471, 'S0730382114T_CAGRO', 'Acquired services of Fertilizers', '2020-02-12 16:27:13'),
(472, 'S0730382114T_CAGRO', 'Acquired services of Corn_Seeds', '2020-02-12 16:27:13'),
(473, 'S0730382114T_CAGRO', 'Acquired services of Rice_Seeds', '2020-02-12 16:27:13'),
(474, 'S0730382114T_CAGRO', 'Acquired services of Chemicals', '2020-02-12 16:27:13'),
(475, 'S0151912054S_CAGRO', 'Acquired assistant of Agri Supplies', '2020-02-12 16:56:33'),
(476, 'S0151912054S_CAGRO', 'Acquired services of Corn_Seeds', '2020-02-12 16:57:23'),
(477, 'S0151912054S_CAGRO', 'Acquired services of Rice_Seeds', '2020-02-12 16:57:23'),
(478, 'S0730382114T_CAGRO', 'Acquired assistant of Agri Supplies', '2019-02-22 09:54:04'),
(479, 'S0730382114T_CAGRO', 'Acquired services of Chemicals', '2019-02-22 09:54:37'),
(480, 'S0730382114T_CAGRO', 'Acquired assistant of Agri Supplies', '2020-02-24 14:48:26'),
(481, 'S0730382114T_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-02-24 14:49:46'),
(482, 'S0730382114T_CAGRO', 'Acquired services of Fruit_Trees_Seedlings', '2020-02-24 14:49:46'),
(483, 'S01652528024M_CAGRO', 'Acquired assistant of Agri Supplies', '2020-02-24 16:53:06'),
(484, 'S01652528024M_CAGRO', 'Acquired services of Vegetables_Seedlings/Seeds', '2020-02-24 16:54:08'),
(485, 'S01652528024M_CAGRO', 'Acquired services of Fruit_Trees_Seedlings', '2020-02-24 16:54:08'),
(486, 'S01652528024M_CAGRO', 'Acquired services of Fertilizers', '2020-02-27 15:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_record_product`
--

CREATE TABLE `beneficiary_record_product` (
  `beneficiary_id` varchar(250) DEFAULT NULL,
  `request_id` varchar(80) DEFAULT NULL,
  `unique_id` varchar(200) NOT NULL,
  `product_id` int(20) NOT NULL,
  `quantity` int(10) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `word_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beneficiary_record_product`
--

INSERT INTO `beneficiary_record_product` (`beneficiary_id`, `request_id`, `unique_id`, `product_id`, `quantity`, `status`, `created_at`, `word_created`) VALUES
('S0151912054S_CAGRO', '18090561859428539341668506821', 'S08266117TuT', 28, 10, 'Done', '2020-01-07 01:06:26', 'January 7, 2020'),
('S0151912054S_CAGRO', '18090561859428539341668506821', 'S083621117TuE', 10, 10, 'Done', '2020-01-07 01:21:36', 'January 7, 2020'),
('S0151912054S_CAGRO', '78994863616540221021355274379', 'S082424117TuR', 173, 10, 'Done', '2020-01-07 01:24:24', 'January 7, 2020'),
('S0151912054S_CAGRO', '1441241920206688607807023695', 'S082228117TuE', 173, 10, 'Done', '2020-01-07 01:28:22', 'January 7, 2020'),
('S0151912054S_CAGRO', '2645460519459794851836107443', 'S011157514TuG', 10, 10, 'Done', '2020-02-04 04:57:01', 'February 4, 2020'),
('S0151912054S_CAGRO', '2645460519459794851836107443', 'S011157514TuO', 173, 10, 'Done', '2020-02-04 04:57:01', 'February 4, 2020'),
('S0151912054S_CAGRO', '15001481665458393021580948805', 'S01018546010MoU', 180, 10, 'Done', '2020-02-10 03:54:18', 'February 10, 2020'),
('S0730382114T_CAGRO', '5165064110623322501864355401', 'S0163356212WeS', 170, 6, 'Done', '2020-02-12 09:35:03', 'February 12, 2020'),
('S0151912054S_CAGRO', '154800788214526379632024187821', 'S01619586212WeQ', 30, 4, 'Done', '2020-02-12 09:58:19', 'February 12, 2020'),
('S0151912054S_CAGRO', '154800788214526379632024187821', 'S01619586212WeS', 31, 4, 'Done', '2020-02-12 09:58:19', 'February 12, 2020'),
('S0730382114T_CAGRO', '16596951451791406787238753504', 'S9928557422FrE', 159, 10, 'Done', '2019-02-22 02:55:28', 'February 22, 2019'),
('S0730382114T_CAGRO', '16596951451791406787238753504', 'S9928557422FrU', 170, 10, 'Done', '2019-02-22 02:55:28', 'February 22, 2019'),
('S0730382114T_CAGRO', '124588178214840722141511948547', 'S0140518024MoL', 172, 12, 'On Going', '2020-02-24 07:51:00', 'February 24, 2020');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_type`
--

CREATE TABLE `beneficiary_type` (
  `id` int(11) NOT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beneficiary_type`
--

INSERT INTO `beneficiary_type` (`id`, `description`) VALUES
(1, 'student'),
(2, 'Teacher'),
(3, 'worker'),
(4, 'Farmer');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiries_agri_supplies`
--

CREATE TABLE `beneficiries_agri_supplies` (
  `service_id` varchar(255) DEFAULT NULL,
  `beneficiary_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `word_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beneficiries_agri_supplies`
--

INSERT INTO `beneficiries_agri_supplies` (`service_id`, `beneficiary_id`, `status`, `created_at`, `word_created`) VALUES
('S0855117TuL', 'S0151912054S_CAGRO', 'On Going', '2020-01-07 01:05:05', 'January 7, 2020'),
('S083423117TuD', 'S0151912054S_CAGRO', 'On Going', '2020-01-07 01:23:34', 'January 7, 2020'),
('S083927117TuK', 'S0151912054S_CAGRO', 'On Going', '2020-01-07 01:27:39', 'January 7, 2020'),
('S0134944027MoD', 'S0151912054S_CAGRO', 'On Going', '2020-01-27 06:04:49', 'January 27, 2020'),
('S01554166212WeT', 'S0730382114T_CAGRO', 'On Going', '2020-02-12 08:16:54', 'February 12, 2020'),
('S01632566212WeD', 'S0151912054S_CAGRO', 'On Going', '2020-02-12 09:56:32', 'February 12, 2020'),
('S994547422FrB', 'S0730382114T_CAGRO', 'On Going', '2019-02-22 02:54:04', 'February 22, 2019'),
('S01426488024MoE', 'S0730382114T_CAGRO', 'On Going', '2020-02-24 07:48:26', 'February 24, 2020'),
('S0166538024MoG', 'S01652528024M_CAGRO', 'On Going', '2020-02-24 09:53:06', 'February 24, 2020');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiries_farm_mechanization`
--

CREATE TABLE `beneficiries_farm_mechanization` (
  `service_id` varchar(255) DEFAULT NULL,
  `beneficiary_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `word_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beneficiries_farm_mechanization`
--

INSERT INTO `beneficiries_farm_mechanization` (`service_id`, `beneficiary_id`, `status`, `created_at`, `word_created`) VALUES
('S0186153020MoW', 'S0730382114T_CAGRO', 'On Going', '2020-01-20 11:15:06', 'January 20, 2020'),
('S09355514TuY', 'S0730382114T_CAGRO', 'On Going', '2020-02-04 02:55:03', 'February 4, 2020');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiries_technical_support`
--

CREATE TABLE `beneficiries_technical_support` (
  `service_id` varchar(255) DEFAULT NULL,
  `beneficiary_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `word_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beneficiries_technical_support`
--

INSERT INTO `beneficiries_technical_support` (`service_id`, `beneficiary_id`, `status`, `created_at`, `word_created`) VALUES
('S0855117TuK', 'S0151912054S_CAGRO', 'On Going', '2020-01-07 01:05:05', 'January 7, 2020'),
('S09355514TuP', 'S0730382114T_CAGRO', 'On Going', '2020-02-04 02:55:03', 'February 4, 2020');

-- --------------------------------------------------------

--
-- Table structure for table `comment_recommendation`
--

CREATE TABLE `comment_recommendation` (
  `id` int(11) NOT NULL,
  `beneficiary_id` varchar(100) DEFAULT NULL,
  `assistance_received` varchar(50) DEFAULT NULL,
  `rating` varchar(50) DEFAULT NULL,
  `comment` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `word_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment_recommendation`
--

INSERT INTO `comment_recommendation` (`id`, `beneficiary_id`, `assistance_received`, `rating`, `comment`, `created_at`, `word_created`) VALUES
(1, 'S913182241216W_CAGRO', 'Technical Assistance', 'Satisfied', 'tarungon na', '2019-10-17 03:09:22', 'October 17, 2019'),
(2, 'S97543440411F_CAGRO', '', 'DisSatisfied', 'di ko ganahan\nbasta', '2019-10-17 03:10:40', 'October 17, 2019'),
(3, 'S913182241216W_CAGRO', 'Agri Supplies', 'Satisfied', 'asd', '2019-10-27 03:55:31', 'October 27, 2019'),
(4, 'S91445424437T_CAGRO', 'Agri Supplies', 'Satisfied', 'Yeah', '2019-11-18 05:30:29', 'November 18, 2019'),
(5, 'S912245245011M_CAGRO', 'Farm Mechanization', 'DisSatisfied', 'No', '2019-11-18 05:30:41', 'November 18, 2019'),
(6, 'S91445424437T_CAGRO', 'Other', 'Satisfied', 'Pangit', '2019-11-18 05:30:55', 'November 18, 2019'),
(7, 'S91445424437T_CAGRO', 'Libre Tuli', 'DisSatisfied', 'dfsdf', '2019-11-18 05:49:41', 'November 18, 2019'),
(8, 'S0730382114T_CAGRO', '', 'Satisfied', 'sadasdasdasd\ngfdsfsd', '2020-02-27 03:47:51', 'February 27, 2020');

-- --------------------------------------------------------

--
-- Table structure for table `damage_product`
--

CREATE TABLE `damage_product` (
  `id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `damage_product`
--

INSERT INTO `damage_product` (`id`, `quantity`) VALUES
(173, 10);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_all_products`
--

CREATE TABLE `inventory_all_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `units` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `despensed` int(11) DEFAULT NULL,
  `damage` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `status_updated` varchar(50) NOT NULL,
  `type_product` varchar(50) NOT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `word_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `inventory_all_products`
--

INSERT INTO `inventory_all_products` (`id`, `product_name`, `units`, `quantity`, `despensed`, `damage`, `status`, `status_updated`, `type_product`, `expiry_date`, `created_at`, `word_created`) VALUES
(1, 'Alugbati', 'seedlings', 79, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '2025-04-04 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(2, 'Ampalaya', 'seedlings', 54, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(3, 'Atsal', 'seedlings', 43, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(4, 'Carrots', 'seedlings', 96, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'March 15, 2019'),
(5, 'Cauliflower', 'seedlings', 67, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'March 15, 2019'),
(6, 'Condol', 'seedlings', 54, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'March 15, 2019'),
(7, 'Garbanzos', 'seedlings', 45, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'March 15, 2019'),
(8, 'Kadios', 'seedlings', 90, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'March 15, 2019'),
(9, 'Kalabasa', 'seedlings', 80, 0, 10, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(10, 'Kamatis', 'seedlings', 70, 10, 10, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(11, 'Kamote Tops', 'seedlings', 78, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(12, 'Kamunggay', 'seedlings', 67, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(13, 'Kangkong', 'seedlings', 65, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(14, 'Lemonsito', 'seedlings', 54, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(15, 'Lettuce', 'seedlings', 67, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(16, 'Luya', 'seedlings', 78, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'January 15, 2019'),
(17, 'Mani', 'seedlings', 76, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(18, 'Mongoes', 'seedlings', 87, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(19, 'Okra', 'seedlings', 65, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(20, 'Pako', 'seedlings', 54, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(21, 'Patola', 'seedlings', 67, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(22, 'Pechay', 'seedlings', 78, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(23, 'Pipino', 'seedlings', 89, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(24, 'Radish', 'seedlings', 78, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(25, 'Saluyot', 'seedlings', 65, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(26, 'Sitao', 'seedlings', 54, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(27, 'Talong', 'seedlings', 67, 0, 0, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'February 15, 2019'),
(28, 'Upo', 'seedlings', 69, 20, 0, 'Available', 'Old', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2014-05-07 02:00:00', 'may 7, 2014'),
(29, 'Corn (White Corn)', 'seedlings', 100, 0, 111, 'Available', 'Old', 'Corn_Seeds', '0000-00-00 00:00:00', '2019-12-02 05:00:00', 'March 15, 2019'),
(30, 'Rice (160)', 'seedlings', 60, 4, 12, 'Available', 'Latest', 'Rice_Seeds', '0000-00-00 00:00:00', '2018-08-06 02:00:00', 'February 15, 2019'),
(31, 'Rice (286))', 'seedlings', 60, 4, 1, 'Available', 'Latest', 'Rice_Seeds', '0000-00-00 00:00:00', '2018-08-06 02:00:00', 'February 15, 2019'),
(32, 'Rice Seeds 216', 'seedlings', 76, 0, 0, 'Available', 'Latest', 'Rice_Seeds', '0000-00-00 00:00:00', '2018-08-06 02:00:00', 'February 15, 2019'),
(34, 'Atchuete', 'seedlings', 65, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(35, 'Atis', 'seedlings', 76, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(36, 'Avocado(Grafted)', 'seedlings', 23, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(37, 'Avocado(Ungrafted)', 'seedlings', 56, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(38, 'Balimbing', 'seedlings', 45, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(39, 'Cacao (Grafted)', 'seedlings', 66, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(40, 'Cacao (Ungrafted)', 'seedlings', 76, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(41, 'Calamansi', 'seedlings', 87, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(42, 'Coconut(Aromatic)', 'seedlings', 68, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'March 15, 2019'),
(43, 'Coconut(Green Tall)', 'seedlings', 60, 0, 7, 'Available', 'Old', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'March 15, 2019'),
(44, 'Coconut(Tacunan)', 'seedlings', 56, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'March 15, 2019'),
(45, 'Coffee', 'seedlings', 58, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'March 15, 2019'),
(46, 'Durian(Grafted)', 'seedlings', 34, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'March 15, 2019'),
(47, 'Durian(Ungrafted)', 'seedlings', 43, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'March 15, 2019'),
(48, 'Guava', 'seedlings', 45, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'March 15, 2019'),
(49, 'Guyabano', 'seedlings', 47, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'March 15, 2019'),
(50, 'Japanese Apple', 'seedlings', 48, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'March 15, 2019'),
(51, 'Kalabo', 'seedlings', 90, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(52, 'Katuray', 'seedlings', 76, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(53, 'Langka', 'seedlings', 65, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(54, 'Lanzones(Grafted)', 'seedlings', 76, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(55, 'Lanzones(Ungrafted)', 'seedlings', 87, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(56, 'Lemon Grass', 'seedlings', 65, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'January 15, 2019'),
(57, 'Mandarin', 'seedlings', 89, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'February 15, 2019'),
(58, 'Mangga(Grafted)', 'seedlings', 78, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'February 15, 2019'),
(59, 'Mangga(Ungrafted)', 'seedlings', 67, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'February 15, 2019'),
(60, 'Mangosteen', 'seedlings', 65, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'February 15, 2019'),
(61, 'Marang', 'seedlings', 65, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'February 15, 2019'),
(62, 'Mayana', 'seedlings', 76, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'February 15, 2019'),
(63, 'Rambutan(Grafted)', 'seedlings', 67, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'February 15, 2019'),
(64, 'Rambutan(Ungrafted)', 'seedlings', 65, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'February 15, 2019'),
(65, 'Rubber', 'seedlings', 87, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'February 15, 2019'),
(66, 'Tambis', 'seedlings', 77, 1, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2018-06-05 05:00:00', 'February 15, 2019'),
(87, 'FER-Active Ingredients, Complete(14-14-14) ', 'kgs/bags', 79, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(88, 'FER-Ammonium Sulfate(21-0-0), 50kgs/bag - (', 'kgs/bags', 54, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(89, 'FER-Urea(46-0-0), 50kgs/bag - (162-001-0002', 'kgs/bags', 65, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(90, 'FER- Foliar Complete Micronutrients, Liqui', 'kgs/bags', 76, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(91, 'FER-Micronutrients Powder, 1kg/pack (RHIZOC', 'kgs/bags', 43, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(92, 'FER-Ammonium Phospate(16-20-0), 50kgs/bag -', 'kgs/bags', 23, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(93, 'FER-Magnesium Sulfate, MgS04, 25kgs/bag - (', 'kgs/bags', 56, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(94, 'FER-Muriate of Potash(0-0-60) 50kgs/bag - (', 'kgs/bags', 45, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(95, 'FER-Trichoderma Harzlanum', 'kgs/bags', 66, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(96, 'FER-Foliar Fertilizer (CALIGRO LITER CALIFO', 'kgs/bags', 76, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(97, 'FER-Active Ingredient NPK 16-16-16 (Complet', 'kgs/bags', 87, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(98, 'FER-Calcium Nitrate Fertilizer, NPK 15.5-0-', 'kgs/bags', 96, 0, 0, 'Available', 'Latest', 'Fertilizers', '2022-06-16 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(99, 'FER - Active Ingredient 14-14-14 Complete. ', 'kgs/bags', 57, 0, 10, 'Expired', 'Old', 'Fertilizers', '0000-00-00 00:00:00', '2019-11-20 11:46:00', 'January 15, 2019'),
(150, 'INS-Lambda Cyhalothrin(DELIVER 2.5 EC) - (', 'gal/s', 50, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(151, 'INS-Chlorpyrifos 500 EC (VESSEL 300EC) - (', 'gal/s', 30, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(152, 'INSECTICIDE-Avermectin B1 (CONAZOLE) - ( )', 'gal/s', 70, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(153, 'INS-AI-Chlorantraniliprole(PREVATHON) - (1', 'gal/s', 100, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(154, 'HER-(GLYPHOSATE 480 SL) - (162-002-0002-0069', 'gal/s', 45, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(155, 'INS-Chlorpyrifos, 1LI(CHLORPHOS) - ( )', 'gal/s', 67, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(156, 'INS-Deltamethrin, 1Li(AGRO DEMETHRIN 2.5EC', 'gal/s', 34, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(157, 'INS-Copper Hydroxide, 250g/bttl(KOCIDE DF(', 'gal/s', 58, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(158, 'INS-Cypermetrin(ADER 5 EC) - ( )', 'gal/s', 73, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(159, 'INS-Sevin 85 wp 250gms/pack(SEVIN) - ( )', 'gal/s', 40, 10, 2, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(160, 'INS-Active Ingredients Chloropyriphos (PAR', 'gal/s', 65, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(161, 'INS-Active Ingredients Abamectin, 250ml/lt', 'gal/s', 78, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(162, 'INS-Insecticide Mixer, Apsa Sticker/ Sprea', 'gal/s', 59, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(163, 'INS-Methomyl', 'gal/s', 70, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(164, 'INS-Thiamethoxam 10g/pack', 'gal/s', 72, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(165, 'INS-Active Ingredients, Dimethoate 40EC', 'gal/s', 75, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(166, 'INS-Lambda-Cyhalothrin 2.5EC(YKURAT)', 'gal/s', 77, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(167, 'HER-2-4D (ESTER), Liter (TOP AGRO)', 'gal/s', 79, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(168, 'INS-Cypermethrin (SNIPER)', 'gal/s', 81, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(169, 'HER-GLYPHOSATE 480 SL-Fast Burn', 'gal/s', 84, 0, 0, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(170, 'HER-GLYPHOSATE 480 SL-Ground Plus', 'gal/s', 90, 118, 10, 'Available', 'Latest', 'Chemicals', '0000-00-00 00:00:00', '2019-09-08 05:00:00', 'january 10, 2019'),
(171, 'Vermicast', 'Box', 90, 0, 10, 'Available', 'Old', 'Organic/Vermicast', '0000-00-00 00:00:00', '2019-12-09 12:20:07', 'December 9, 2019'),
(172, 'coffee ', 'seedlings', 880, 110, 10, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2019-12-10 15:23:59', 'December 10, 2019'),
(173, 'Upo', 'seedlings', 60, 10, 20, 'Available', 'Latest', 'Vegetables_Seedlings/Seeds', '0000-00-00 00:00:00', '2020-01-07 08:23:19', 'January 7, 2020'),
(174, 'Coconut(Green Tall)', 'seedlings', 100, 0, 0, 'Available', 'Latest', 'Fruit_Trees_Seedlings', '0000-00-00 00:00:00', '2020-01-14 12:11:30', 'January 14, 2020'),
(175, 'Vermicast', 'Box', 100, 0, 100, 'Available', 'Old', 'Organic/Vermicast', '0000-00-00 00:00:00', '2020-01-14 12:41:44', 'January 14, 2020'),
(176, 'FER - Active Ingredient 14-14-14 Complete. ', 'kgs/bags', 100, 0, 110, 'Expired', 'Old', 'Fertilizers', '0000-00-00 00:00:00', '2020-01-14 13:16:16', 'January 14, 2020'),
(177, 'FER - Active Ingredient 14-14-14 Complete. ', 'kgs/bags', 90, 0, 10, 'Expired', 'Latest', 'Fertilizers', '0000-00-00 00:00:00', '2020-01-20 11:59:15', 'January 20, 2020'),
(178, 'Corn (White Corn)', 'seedlings', 50, 0, 110, 'Available', 'Old', 'Corn_Seeds', '0000-00-00 00:00:00', '2020-01-20 12:06:45', 'January 20, 2020'),
(179, 'Corn (White Corn)', 'seedlings', 90, 0, 10, 'Available', 'Latest', 'Corn_Seeds', '0000-00-00 00:00:00', '2020-01-20 12:07:40', 'January 20, 2020'),
(180, 'Vermicast', 'Box', 90, 10, 0, 'Available', 'Latest', 'Organic/Vermicast', '0000-00-00 00:00:00', '2020-01-20 12:25:33', 'January 20, 2020');

-- --------------------------------------------------------

--
-- Table structure for table `municipality`
--

CREATE TABLE `municipality` (
  `id` int(11) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `municipality`
--

INSERT INTO `municipality` (`id`, `description`, `barangay_id`) VALUES
(9, 'Asuncion', 1),
(9, 'Braulio E. Dujali', 2),
(9, 'Carmen', 3),
(9, 'Kapalong', 4),
(9, 'New Corella', 5),
(9, 'Panbo City', 6),
(9, 'Samal', 7),
(9, 'San Isidro', 8),
(9, 'Santo Tomas', 9),
(9, 'Tagum City', 10),
(9, 'Talaingod', 11),
(7, 'Compostela', 12),
(7, 'Laak', 13),
(7, 'Mabini', 14),
(7, 'Maco', 15),
(7, 'Maragusan', 16),
(7, 'Mawab', 17),
(7, 'Monkayo', 18),
(7, 'Montevista', 19),
(7, 'Nabunturan', 20),
(7, 'New Bataan', 21),
(7, 'Pantukan', 22);

-- --------------------------------------------------------

--
-- Stand-in structure for view `notification`
-- (See below for the actual view)
--
CREATE TABLE `notification` (
`id` int(11)
,`title` varchar(100)
,`start_event` datetime
,`end_event` datetime
,`event_status` varchar(50)
,`sms_stat` varchar(50)
,`start_word` varchar(50)
,`end_word` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `personel`
--

CREATE TABLE `personel` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personel`
--

INSERT INTO `personel` (`id`, `name`) VALUES
(1, 'James Bond'),
(2, 'Marilyn Monte'),
(4, 'Mary Rose Burlaza'),
(5, 'Leonhail Paypa'),
(6, 'Charry'),
(7, 'Cha Cha'),
(8, 'Riza Tanong');

-- --------------------------------------------------------

--
-- Table structure for table `product_name`
--

CREATE TABLE `product_name` (
  `id` int(11) NOT NULL,
  `des` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_name`
--

INSERT INTO `product_name` (`id`, `des`) VALUES
(4, 'Talong Seeds'),
(5, 'Manga Seeds'),
(6, 'Abuno'),
(7, 'Tae'),
(8, 'Segex'),
(9, 'humay'),
(10, 'insecticide'),
(11, 'Vermicast'),
(12, 'coffee ');

-- --------------------------------------------------------

--
-- Table structure for table `project_program`
--

CREATE TABLE `project_program` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `descrip` varchar(100) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  `start_event_word` varchar(50) NOT NULL,
  `end_event_word` varchar(50) NOT NULL,
  `event_status` varchar(50) NOT NULL,
  `sms_stat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` int(11) NOT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `description`) VALUES
(7, 'Compostela Valley'),
(9, 'Davao del Norte');

-- --------------------------------------------------------

--
-- Table structure for table `recent_request`
--

CREATE TABLE `recent_request` (
  `service_id` varchar(255) DEFAULT NULL,
  `request_id` varchar(100) NOT NULL,
  `beneficiary_id` varchar(250) DEFAULT NULL,
  `assistance_recieved` varchar(250) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `word_created` varchar(50) NOT NULL,
  `other` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recent_request`
--

INSERT INTO `recent_request` (`service_id`, `request_id`, `beneficiary_id`, `assistance_recieved`, `status`, `created_at`, `word_created`, `other`) VALUES
('S0855117TuL', '1784010600591961850629569041', 'S0151912054S_CAGRO', 'Agri Supplies', 'Done', '2020-01-07 01:05:05', 'January 7, 2020', ''),
('S0855117TuK', '1784010600591961850629569041', 'S0151912054S_CAGRO', 'Technical Assistance', 'On Going', '2020-01-07 01:05:05', 'January 7, 2020', ''),
('S083423117TuD', '19690587287986160971429453349', 'S0151912054S_CAGRO', 'Agri Supplies', 'Done', '2020-01-07 01:23:34', 'January 7, 2020', ''),
('S083927117TuK', '18727150511298555172574872893', 'S0151912054S_CAGRO', 'Agri Supplies', 'Done', '2020-01-07 01:27:39', 'January 7, 2020', ''),
('S0186153020MoW', '206602714413921273291001427545', 'S0730382114T_CAGRO', 'Farm Mechanization', 'On Going', '2020-01-20 11:15:06', 'January 20, 2020', ''),
('S0134944027MoD', '178528105219149841741922905989', 'S0151912054S_CAGRO', 'Agri Supplies', 'Done', '2020-01-27 06:04:49', 'January 27, 2020', ''),
('S09355514TuP', '207630276612161093351897458756', 'S0730382114T_CAGRO', 'Technical Assistance', 'On Going', '2020-02-04 02:55:03', 'February 4, 2020', ''),
('S09355514TuY', '207630276612161093351897458756', 'S0730382114T_CAGRO', 'Farm Mechanization', 'On Going', '2020-02-04 02:55:03', 'February 4, 2020', ''),
('S01554166212WeT', '63328085952992495933151058', 'S0730382114T_CAGRO', 'Agri Supplies', 'Done', '2020-02-12 08:16:54', 'February 12, 2020', ''),
('S01632566212WeD', '8917424741813984138940670886', 'S0151912054S_CAGRO', 'Agri Supplies', 'Done', '2020-02-12 09:56:32', 'February 12, 2020', ''),
('S994547422FrB', '33555383512041134676914705', 'S0730382114T_CAGRO', 'Agri Supplies', 'Done', '2019-02-22 02:54:04', 'February 22, 2019', ''),
('S01426488024MoE', '699959967207707408625911253', 'S0730382114T_CAGRO', 'Agri Supplies', 'On Going', '2020-02-24 07:48:26', 'February 24, 2020', ''),
('S0166538024MoG', '185217288919990448611282966854', 'S01652528024M_CAGRO', 'Agri Supplies', 'On Going', '2020-02-24 09:53:06', 'February 24, 2020', '');

-- --------------------------------------------------------

--
-- Table structure for table `record_assistance_beneficiary`
--

CREATE TABLE `record_assistance_beneficiary` (
  `service_id` varchar(50) NOT NULL,
  `beneficiary_id` varchar(50) DEFAULT NULL,
  `assistanced_received` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `farm_site` varchar(50) NOT NULL,
  `coordinate` varchar(50) NOT NULL,
  `tentative` date NOT NULL,
  `operation` varchar(50) NOT NULL,
  `date_started` date NOT NULL,
  `date_ended` date NOT NULL,
  `area` varchar(50) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `resched` date NOT NULL,
  `reason` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `word_created` varchar(50) NOT NULL,
  `other` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `record_assistance_beneficiary`
--

INSERT INTO `record_assistance_beneficiary` (`service_id`, `beneficiary_id`, `assistanced_received`, `status`, `farm_site`, `coordinate`, `tentative`, `operation`, `date_started`, `date_ended`, `area`, `operator`, `resched`, `reason`, `created_at`, `word_created`, `other`) VALUES
('S0134944027MoD', 'S0151912054S_CAGRO', 'Agri Supplies', 'Done', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-01-27 06:04:49', 'January 27, 2020', ''),
('S01426488024MoE', 'S0730382114T_CAGRO', 'Agri Supplies', 'On Going', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-02-24 07:48:26', 'February 24, 2020', ''),
('S01554166212WeT', 'S0730382114T_CAGRO', 'Agri Supplies', 'Done', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-02-12 08:16:54', 'February 12, 2020', ''),
('S01632566212WeD', 'S0151912054S_CAGRO', 'Agri Supplies', 'Done', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-02-12 09:56:32', 'February 12, 2020', ''),
('S0166538024MoG', 'S01652528024M_CAGRO', 'Agri Supplies', 'On Going', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-02-24 09:53:06', 'February 24, 2020', ''),
('S0186153020MoW', 'S0730382114T_CAGRO', 'Farm Mechanization', 'On Going', 'dsfds', '7.446725594824114, 125.8072196112631', '2020-02-11', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-01-20 11:15:06', 'January 20, 2020', ''),
('S083423117TuD', 'S0151912054S_CAGRO', 'Agri Supplies', 'Done', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-01-07 01:23:34', 'January 7, 2020', ''),
('S083927117TuK', 'S0151912054S_CAGRO', 'Agri Supplies', 'Done', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-01-07 01:27:39', 'January 7, 2020', ''),
('S0855117TuK', 'S0151912054S_CAGRO', 'Technical Assistance', 'On Going', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-01-07 01:05:05', 'January 7, 2020', ''),
('S0855117TuL', 'S0151912054S_CAGRO', 'Agri Supplies', 'Done', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-01-07 01:05:05', 'January 7, 2020', ''),
('S09355514TuP', 'S0730382114T_CAGRO', 'Technical Assistance', 'On Going', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-02-04 02:55:03', 'February 4, 2020', ''),
('S09355514TuY', 'S0730382114T_CAGRO', 'Farm Mechanization', 'On Going', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2020-02-04 02:55:03', 'February 4, 2020', ''),
('S994547422FrB', 'S0730382114T_CAGRO', 'Agri Supplies', 'Done', '', '', '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '', '2019-02-22 02:54:04', 'February 22, 2019', '');

-- --------------------------------------------------------

--
-- Table structure for table `record_services_beneficiary`
--

CREATE TABLE `record_services_beneficiary` (
  `service_id` varchar(100) NOT NULL,
  `request_id` varchar(100) NOT NULL,
  `beneficiary_id` varchar(255) DEFAULT NULL,
  `services_received` varchar(50) DEFAULT NULL,
  `ser_id` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `word_created` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `record_services_beneficiary`
--

INSERT INTO `record_services_beneficiary` (`service_id`, `request_id`, `beneficiary_id`, `services_received`, `ser_id`, `status`, `created_at`, `word_created`) VALUES
('S01030526010MoA', '15001481665458393021580948805', 'S0151912054S_CAGRO', 'Organic/Vermicast', 'S0134944027MoD', 'Done', '2020-02-10 03:52:30', 'February 10, 2020'),
('S0111243514TuF', '2645460519459794851836107443', 'S0151912054S_CAGRO', 'Vegetables_Seedlings/Seeds', 'S0134944027MoD', 'Done', '2020-02-04 04:43:12', 'February 4, 2020'),
('S0111243514TuQ', '2645460519459794851836107443', 'S0151912054S_CAGRO', 'Fruit_Trees_Seedlings', 'S0134944027MoD', 'Done', '2020-02-04 04:43:12', 'February 4, 2020'),
('S01446498024MoF', '124588178214840722141511948547', 'S0730382114T_CAGRO', 'Vegetables_Seedlings/Seeds', 'S01426488024MoE', 'On Going', '2020-02-24 07:49:46', 'February 24, 2020'),
('S01446498024MoS', '124588178214840722141511948547', 'S0730382114T_CAGRO', 'Fruit_Trees_Seedlings', 'S01426488024MoE', 'On Going', '2020-02-24 07:49:46', 'February 24, 2020'),
('S01549158327ThT', '3631363468317444441893143306', 'S01652528024M_CAGRO', 'Fertilizers', 'S0166538024MoG', 'On Going', '2020-02-27 08:15:49', 'February 27, 2020'),
('S01613276212WeB', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Chemicals', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeD', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Vegetables_Seedlings/Seeds', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeF', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Corn_Seeds', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeI', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Organic/Vermicast', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeN', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Rice_Seeds', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeV', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Fertilizers', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeY', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Fruit_Trees_Seedlings', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01623576212WeP', '154800788214526379632024187821', 'S0151912054S_CAGRO', 'Rice_Seeds', 'S01632566212WeD', 'Done', '2020-02-12 09:57:23', 'February 12, 2020'),
('S01623576212WeX', '154800788214526379632024187821', 'S0151912054S_CAGRO', 'Corn_Seeds', 'S01632566212WeD', 'Done', '2020-02-12 09:57:23', 'February 12, 2020'),
('S016566212WeB', '1079882314601701011860755760', 'S0730382114T_CAGRO', 'Corn_Seeds', 'S01554166212WeT', 'Done', '2020-02-12 09:06:05', 'February 12, 2020'),
('S016566212WeE', '1079882314601701011860755760', 'S0730382114T_CAGRO', 'Vegetables_Seedlings/Seeds', 'S01554166212WeT', 'Done', '2020-02-12 09:06:05', 'February 12, 2020'),
('S016566212WeF', '1079882314601701011860755760', 'S0730382114T_CAGRO', 'Fruit_Trees_Seedlings', 'S01554166212WeT', 'Done', '2020-02-12 09:06:05', 'February 12, 2020'),
('S016566212WeJ', '1079882314601701011860755760', 'S0730382114T_CAGRO', 'Fertilizers', 'S01554166212WeT', 'Done', '2020-02-12 09:06:05', 'February 12, 2020'),
('S016566212WeP', '1079882314601701011860755760', 'S0730382114T_CAGRO', 'Organic/Vermicast', 'S01554166212WeT', 'Done', '2020-02-12 09:06:05', 'February 12, 2020'),
('S0168548024MoE', '1868039157158048680509280810', 'S01652528024M_CAGRO', 'Fruit_Trees_Seedlings', 'S0166538024MoG', 'On Going', '2020-02-24 09:54:08', 'February 24, 2020'),
('S0168548024MoO', '1868039157158048680509280810', 'S01652528024M_CAGRO', 'Vegetables_Seedlings/Seeds', 'S0166538024MoG', 'On Going', '2020-02-24 09:54:08', 'February 24, 2020'),
('S08355117TuY', '18090561859428539341668506821', 'S0151912054S_CAGRO', 'Vegetables_Seedlings/Seeds', 'S0855117TuL', 'Done', '2020-01-07 01:05:35', 'January 7, 2020'),
('S084823117TuT', '78994863616540221021355274379', 'S0151912054S_CAGRO', 'Vegetables_Seedlings/Seeds', 'S083423117TuD', 'Done', '2020-01-07 01:23:48', 'January 7, 2020'),
('S085527117TuV', '1441241920206688607807023695', 'S0151912054S_CAGRO', 'Vegetables_Seedlings/Seeds', 'S083927117TuK', 'Done', '2020-01-07 01:27:55', 'January 7, 2020'),
('S9937547422FrP', '16596951451791406787238753504', 'S0730382114T_CAGRO', 'Chemicals', 'S994547422FrB', 'Done', '2019-02-22 02:54:37', 'February 22, 2019');

-- --------------------------------------------------------

--
-- Table structure for table `request_services`
--

CREATE TABLE `request_services` (
  `service_id` varchar(100) DEFAULT NULL,
  `request_id` varchar(100) DEFAULT NULL,
  `beneficiary_id` varchar(250) DEFAULT NULL,
  `service_recieved` varchar(50) DEFAULT NULL,
  `ser_id` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `word_created` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_services`
--

INSERT INTO `request_services` (`service_id`, `request_id`, `beneficiary_id`, `service_recieved`, `ser_id`, `status`, `created_at`, `word_created`) VALUES
('S08355117TuY', '18090561859428539341668506821', 'S0151912054S_CAGRO', 'Vegetables_Seedlings/Seeds', 'S0855117TuL', 'Done', '2020-01-07 01:05:35', 'January 7, 2020'),
('S084823117TuT', '78994863616540221021355274379', 'S0151912054S_CAGRO', 'Vegetables_Seedlings/Seeds', 'S083423117TuD', 'Done', '2020-01-07 01:23:48', 'January 7, 2020'),
('S085527117TuV', '1441241920206688607807023695', 'S0151912054S_CAGRO', 'Vegetables_Seedlings/Seeds', 'S083927117TuK', 'Done', '2020-01-07 01:27:55', 'January 7, 2020'),
('S0111243514TuF', '2645460519459794851836107443', 'S0151912054S_CAGRO', 'Vegetables_Seedlings/Seeds', 'S0134944027MoD', 'Done', '2020-02-04 04:43:12', 'February 4, 2020'),
('S0111243514TuQ', '2645460519459794851836107443', 'S0151912054S_CAGRO', 'Fruit_Trees_Seedlings', 'S0134944027MoD', 'Done', '2020-02-04 04:43:12', 'February 4, 2020'),
('S01030526010MoA', '15001481665458393021580948805', 'S0151912054S_CAGRO', 'Organic/Vermicast', 'S0134944027MoD', 'Done', '2020-02-10 03:52:30', 'February 10, 2020'),
('S016566212WeE', '1079882314601701011860755760', 'S0730382114T_CAGRO', 'Vegetables_Seedlings/Seeds', 'S01554166212WeT', 'Done', '2020-02-12 09:06:05', 'February 12, 2020'),
('S016566212WeF', '1079882314601701011860755760', 'S0730382114T_CAGRO', 'Fruit_Trees_Seedlings', 'S01554166212WeT', 'Done', '2020-02-12 09:06:05', 'February 12, 2020'),
('S016566212WeP', '1079882314601701011860755760', 'S0730382114T_CAGRO', 'Organic/Vermicast', 'S01554166212WeT', 'Done', '2020-02-12 09:06:05', 'February 12, 2020'),
('S016566212WeJ', '1079882314601701011860755760', 'S0730382114T_CAGRO', 'Fertilizers', 'S01554166212WeT', 'Done', '2020-02-12 09:06:05', 'February 12, 2020'),
('S016566212WeB', '1079882314601701011860755760', 'S0730382114T_CAGRO', 'Corn_Seeds', 'S01554166212WeT', 'Done', '2020-02-12 09:06:05', 'February 12, 2020'),
('S01613276212WeD', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Vegetables_Seedlings/Seeds', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeY', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Fruit_Trees_Seedlings', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeI', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Organic/Vermicast', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeV', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Fertilizers', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeF', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Corn_Seeds', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeN', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Rice_Seeds', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01613276212WeB', '5165064110623322501864355401', 'S0730382114T_CAGRO', 'Chemicals', 'S01554166212WeT', 'Done', '2020-02-12 09:27:13', 'February 12, 2020'),
('S01623576212WeX', '154800788214526379632024187821', 'S0151912054S_CAGRO', 'Corn_Seeds', 'S01632566212WeD', 'Done', '2020-02-12 09:57:23', 'February 12, 2020'),
('S01623576212WeP', '154800788214526379632024187821', 'S0151912054S_CAGRO', 'Rice_Seeds', 'S01632566212WeD', 'Done', '2020-02-12 09:57:23', 'February 12, 2020'),
('S9937547422FrP', '16596951451791406787238753504', 'S0730382114T_CAGRO', 'Chemicals', 'S994547422FrB', 'Done', '2019-02-22 02:54:37', 'February 22, 2019'),
('S01446498024MoF', '124588178214840722141511948547', 'S0730382114T_CAGRO', 'Vegetables_Seedlings/Seeds', 'S01426488024MoE', 'On Going', '2020-02-24 07:49:46', 'February 24, 2020'),
('S01446498024MoS', '124588178214840722141511948547', 'S0730382114T_CAGRO', 'Fruit_Trees_Seedlings', 'S01426488024MoE', 'On Going', '2020-02-24 07:49:46', 'February 24, 2020'),
('S0168548024MoO', '1868039157158048680509280810', 'S01652528024M_CAGRO', 'Vegetables_Seedlings/Seeds', 'S0166538024MoG', 'On Going', '2020-02-24 09:54:08', 'February 24, 2020'),
('S0168548024MoE', '1868039157158048680509280810', 'S01652528024M_CAGRO', 'Fruit_Trees_Seedlings', 'S0166538024MoG', 'On Going', '2020-02-24 09:54:08', 'February 24, 2020'),
('S01549158327ThT', '3631363468317444441893143306', 'S01652528024M_CAGRO', 'Fertilizers', 'S0166538024MoG', 'On Going', '2020-02-27 08:15:49', 'February 27, 2020');

-- --------------------------------------------------------

--
-- Table structure for table `sms_services`
--

CREATE TABLE `sms_services` (
  `id` int(11) NOT NULL,
  `beneficiary_id` varchar(255) DEFAULT NULL,
  `message` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `testchart`
--

CREATE TABLE `testchart` (
  `year` varchar(50) DEFAULT NULL,
  `purchase` double DEFAULT NULL,
  `sale` double DEFAULT NULL,
  `profit` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testchart`
--

INSERT INTO `testchart` (`year`, `purchase`, `sale`, `profit`) VALUES
('2012', 12233, 1232, 123445),
('2013', 342323, 3422, 324);

-- --------------------------------------------------------

--
-- Table structure for table `unit_q`
--

CREATE TABLE `unit_q` (
  `id` int(11) NOT NULL,
  `unit_prod` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_q`
--

INSERT INTO `unit_q` (`id`, `unit_prod`) VALUES
(5, 'Sachet'),
(6, 'Pieces'),
(7, 'Box'),
(8, 'Sachet'),
(9, 'Box'),
(10, 'Sachet'),
(11, 'Box'),
(12, 'seedlings');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `purok` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `municipality` varchar(50) NOT NULL,
  `bday` date NOT NULL,
  `mobnum` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `salt` varchar(250) NOT NULL,
  `profiles` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `middlename`, `position`, `purok`, `barangay`, `municipality`, `bday`, `mobnum`, `gender`, `username`, `password`, `salt`, `profiles`, `created_at`) VALUES
(10, 'Advincula', 'Dave', 'A', 'Planning', '', '', '', '0000-00-00', '', '', 'Dave', '$2y$10$/KRr/YqjobzKKvAeiZZ5S.NLJGAUAT4q9Ou9yKUJwnvBsPJ77g.G.', '339930748paypa', '156535010.jpg', '2019-09-18 10:33:31'),
(11, '', '', '', 'Admin', '', '', '', '0000-00-00', '', '', 'admin', '$2y$10$gtGPgGkusZCDr2PAfjD6a.X0DwVmTeapIsO1p8rgCY5s.eriT3WjO', '580587913paypa', 'user.png', '2019-11-12 07:19:21'),
(12, 'Tanong', 'Riza', '', 'Secretary', '', '', '', '0000-00-00', '', '', 'Riza', '$2y$10$D95yeC33dutx.8mzNK.GdOwdqg03dt0ZJ/Qq.XIbFqQK2VyxO9BoO', '572831955paypa', 'user.png', '2019-11-12 07:22:20');

-- --------------------------------------------------------

--
-- Structure for view `notification`
--
DROP TABLE IF EXISTS `notification`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `notification`  AS  select `t1`.`id` AS `id`,`t1`.`title` AS `title`,`t1`.`start_event` AS `start_event`,`t1`.`end_event` AS `end_event`,`t1`.`event_status` AS `event_status`,`t1`.`sms_stat` AS `sms_stat`,`t1`.`start_event_word` AS `start_word`,`t1`.`end_event_word` AS `end_word` from `project_program` `t1` where (`t1`.`start_event` <= now()) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assistance`
--
ALTER TABLE `assistance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD KEY `id` (`id`);

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiary_type_id` (`beneficiary_type`);

--
-- Indexes for table `beneficiary_history`
--
ALTER TABLE `beneficiary_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beneficiary_record_product`
--
ALTER TABLE `beneficiary_record_product`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `beneficiary_id` (`beneficiary_id`);

--
-- Indexes for table `beneficiary_type`
--
ALTER TABLE `beneficiary_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beneficiries_agri_supplies`
--
ALTER TABLE `beneficiries_agri_supplies`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `beneficiries_farm_mechanization`
--
ALTER TABLE `beneficiries_farm_mechanization`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `beneficiries_technical_support`
--
ALTER TABLE `beneficiries_technical_support`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `comment_recommendation`
--
ALTER TABLE `comment_recommendation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_all_products`
--
ALTER TABLE `inventory_all_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `municipality`
--
ALTER TABLE `municipality`
  ADD PRIMARY KEY (`barangay_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `personel`
--
ALTER TABLE `personel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_name`
--
ALTER TABLE `product_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_program`
--
ALTER TABLE `project_program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recent_request`
--
ALTER TABLE `recent_request`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `record_assistance_beneficiary`
--
ALTER TABLE `record_assistance_beneficiary`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `record_services_beneficiary`
--
ALTER TABLE `record_services_beneficiary`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `beneficiary_id` (`beneficiary_id`);

--
-- Indexes for table `request_services`
--
ALTER TABLE `request_services`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `sms_services`
--
ALTER TABLE `sms_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiary_id` (`beneficiary_id`);

--
-- Indexes for table `unit_q`
--
ALTER TABLE `unit_q`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assistance`
--
ALTER TABLE `assistance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `beneficiary_history`
--
ALTER TABLE `beneficiary_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=487;
--
-- AUTO_INCREMENT for table `beneficiary_type`
--
ALTER TABLE `beneficiary_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `comment_recommendation`
--
ALTER TABLE `comment_recommendation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `inventory_all_products`
--
ALTER TABLE `inventory_all_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;
--
-- AUTO_INCREMENT for table `municipality`
--
ALTER TABLE `municipality`
  MODIFY `barangay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `personel`
--
ALTER TABLE `personel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `product_name`
--
ALTER TABLE `product_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `project_program`
--
ALTER TABLE `project_program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sms_services`
--
ALTER TABLE `sms_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `unit_q`
--
ALTER TABLE `unit_q`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangay`
--
ALTER TABLE `barangay`
  ADD CONSTRAINT `barangay_ibfk_1` FOREIGN KEY (`id`) REFERENCES `municipality` (`barangay_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `beneficiary_record_product`
--
ALTER TABLE `beneficiary_record_product`
  ADD CONSTRAINT `beneficiary_record_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `inventory_all_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `beneficiries_agri_supplies`
--
ALTER TABLE `beneficiries_agri_supplies`
  ADD CONSTRAINT `beneficiries_agri_supplies_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `record_assistance_beneficiary` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `beneficiries_farm_mechanization`
--
ALTER TABLE `beneficiries_farm_mechanization`
  ADD CONSTRAINT `beneficiries_farm_mechanization_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `record_assistance_beneficiary` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `beneficiries_technical_support`
--
ALTER TABLE `beneficiries_technical_support`
  ADD CONSTRAINT `beneficiries_technical_support_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `record_assistance_beneficiary` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `municipality`
--
ALTER TABLE `municipality`
  ADD CONSTRAINT `municipality_ibfk_1` FOREIGN KEY (`id`) REFERENCES `province` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recent_request`
--
ALTER TABLE `recent_request`
  ADD CONSTRAINT `recent_request_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `record_assistance_beneficiary` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `record_services_beneficiary`
--
ALTER TABLE `record_services_beneficiary`
  ADD CONSTRAINT `record_services_beneficiary_ibfk_1` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiaries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request_services`
--
ALTER TABLE `request_services`
  ADD CONSTRAINT `request_services_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `record_services_beneficiary` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sms_services`
--
ALTER TABLE `sms_services`
  ADD CONSTRAINT `sms_services_ibfk_1` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiaries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
